<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\UserInfo;
use App\Models\Admin\UserBankDetail;
use App\Models\Admin\UserKycDetail;
use Redirect;
use App\Models\User;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function store(Request $request)
    {
        $request->validate([
            'referral_code' => 'required',
            'fullname' => 'required',
            'mobile_no' => 'required|digits:10',
            'address' => 'required',
            'password' => 'required|min:8|confirmed',
            'join_side' => 'required',
            'sponsor_id' => 'required',
        ]);
        $id = mt_rand(10000000,99999999);
        $user_referral_info = $request->referral_code;
        $data = User::where('referral_code',$user_referral_info )->first();
        $users = User::where('parent_id', $data->id)->get();
        $sponsorUser = User::where('referral_code', $request->sponsor_id)->first();
        if(count($users) < 10){
            $parentUser = User::where('id', $data->sub_parent_id)->first();
            if(empty($parentUser))
            {
                $maxIndex = User::where('sub_parent_id', $data->id)->where('side', $request->join_side)->max('index');
                // dd($maxIndex);
                if(empty($maxIndex))
                {
                    $index = 1;
                    $sub_parent_id = $data->id;
                }
                else{
                    $leftUser = User::where('sub_parent_id', $data->id)->where('side', $request->join_side)->where('index', $maxIndex)->first();
                    $index = $maxIndex + 1;
                    $sub_parent_id = $leftUser->sub_parent_id;
                }
            }
            else{
                $checkSide = $parentUser->side;
                if(empty($checkSide))
                {
                    if($request->join_side == $data->side)
                    {
                        $maxIndex = User::where('sub_parent_id', $parentUser->id)->where('side', $request->join_side)->max('index');
                        if(empty($maxIndex))
                        {
                            $index = 1;
                            $sub_parent_id = $parentUser->id;
                        }
                        else{
                            $leftUser = User::where('sub_parent_id', $parentUser->id)->where('side', $request->join_side)->where('index', $maxIndex)->first();
                            $index = $maxIndex + 1;
                            $sub_parent_id = $parentUser->id;
                        }
                    }
                    else{
                        $maxIndex = User::where('sub_parent_id', $data->id)->where('side', $request->join_side)->max('index');
                        if(empty($maxIndex)){
                            $index = 1;
                            $sub_parent_id = $data->id;
                        }
                        else{
                            $leftUser = User::where('sub_parent_id', $data->id)->where('side', $request->join_side)->where('index', $maxIndex)->first();
                            $index = $maxIndex + 1;
                            $sub_parent_id = $leftUser->sub_parent_id;
                        }
                    }  
                }
                elseif($checkSide == $data->side){
                    if($request->join_side == $data->side)
                    {
                        $maxIndex = User::where('sub_parent_id', $parentUser->sub_parent_id)->where('side', $request->join_side)->max('index');
                        if(empty($maxIndex))
                        {
                            $index = 1;
                            $sub_parent_id = $parentUser->sub_parent_id;
                        }
                        else{
                            $leftUser = User::where('sub_parent_id', $parentUser->sub_parent_id)->where('side', $request->join_side)->where('index', $maxIndex)->first();
                            $index = $maxIndex + 1;
                            $sub_parent_id = $parentUser->sub_parent_id;
                        }
                    }
                    else{
                        $maxIndex = User::where('sub_parent_id', $data->id)->where('side', $request->join_side)->max('index');
                        if(empty($maxIndex)){
                            $index = 1;
                            $sub_parent_id = $data->id;
                        }
                        else{
                            $leftUser = User::where('sub_parent_id', $data->id)->where('side', $request->join_side)->where('index', $maxIndex)->first();
                            $index = $maxIndex + 1;
                            $sub_parent_id = $leftUser->sub_parent_id;
                        }
                    } 
                }
                else{
                    if($request->join_side == $data->side)
                    {
                        $maxIndex = User::where('sub_parent_id', $parentUser->id)->where('side', $request->join_side)->max('index');
                        if(empty($maxIndex))
                        {
                            $index = 1;
                            $sub_parent_id = $parentUser->id;
                        }
                        else{
                            $leftUser = User::where('sub_parent_id', $parentUser->id)->where('side', $request->join_side)->where('index', $maxIndex)->first();
                            $index = $maxIndex + 1;
                            $sub_parent_id = $parentUser->id;
                        }
                    }
                    else{
                        $maxIndex = User::where('sub_parent_id', $data->id)->where('side', $request->join_side)->max('index');
                        if(empty($maxIndex)){
                            $index = 1;
                            $sub_parent_id = $data->id;
                        }
                        else{
                            $leftUser = User::where('sub_parent_id', $data->id)->where('side', $request->join_side)->where('index', $maxIndex)->first();
                            $index = $maxIndex + 1;
                            $sub_parent_id = $leftUser->sub_parent_id;
                        }
                    }
                }
            }
            $sideUser = User::where('parent_id', $data->id)->where('side', $request->join_side)->get();
            if(count($sideUser) < 5){
                $user = User::create([
                    'id' => $id,
                    'fullname' => $request->fullname,
                    'email' => $request->email,
                    'username' => "MCP".$id,
                    'mobile' => $request->mobile_no,
                    'address' => $request->address,
                    'password' => Hash::make($request->password),
                    'password_1' => $request->password,
                    'referral_code' => "MCP".$id,
                    'reg_date' => date("Y-m-d"),
                    'index' => $index,
                    'parent_id' => $data->id,
                    'side' => $request->join_side,
                    'sub_parent_id' => $sub_parent_id,
                    'sponsor_id' => $sponsorUser->id,
                ]);
                $usersInfo = new UserInfo();
                $usersInfo->user_id = $id;
                $usersInfo->nominee_name = $request->nominee_name;
                $usersInfo->nominee_relation = $request->nominee_relation;
                $usersInfo->save();

                $kycdetails = new UserKycDetail();
                $kycdetails->user_id = $id;
                $kycdetails->pan_no = $request->pan_no;
                $kycdetails->aadhar_no = $request->aadhar_no;
                $kycdetails->save();
            
                $bankdetails = new UserBankDetail();
                $bankdetails->user_id = $id;
                $bankdetails->bank_name = $request->bank_name;
                $bankdetails->branch_name = $request->branch_name;
                $bankdetails->ifsc_code = $request->ifsc_code;
                $bankdetails->acc_no = $request->acc_no;
                $bankdetails->acc_holder_name = $request->acc_holder_name;
                $bankdetails->save();

                if($bankdetails->save()){
                    $username = "MCP".$id;
                    $message = "Hello+".urlencode($request->fullname)."%0aWelcome+to+Market+Career+Power+Pvt.+Ltd."."%0aYour+Distributor+account+credentials+are+as+follows:%0aUsername:-+".$username."%0aPassword:-+".$request->password."%0aYou+can+login+to+your+distributor+account+here%0amarketcareerpower.com/login/";
                                
                    $number = $request->mobile_no;
        
                    $this->sendSms($message,$number); 
                    // dd($this->sendSms($message,$number)); 
                    return redirect('/login')->with([
                        'user' => $user,
                        'kycdetails' => $kycdetails,
                        'bankdetails' => $bankdetails,
                        'usersInfo' => $usersInfo,
                    ])->with('success', 'Joiner Added Successfully!');
                }  
            }
            else{
                if($request->join_side == "L")
                {
                    $side = "Left";
                }
                else{
                    $side = "Right";
                }
                return Redirect::back()->with('danger', 'You cannot add more than 5 joiners on '.$side.' side.');
            }
        }
        else{
            
            return Redirect::back()->with('danger', 'You cannot add more than 10 joiners.');
        }
    }

    public function sendSms($message,$number)
    {
        $url = 'http://sms.bulksmsind.in/v2/sendSMS?username=iceico&message='.$message.'&sendername=MRKTCP&smstype=TRANS&numbers='.$number.'&apikey=24ae8ae0-b514-499b-8baf-51d55808a2c4&peid=1201161909189905209&templateid=1207161959177676662';
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($ch,CURLOPT_HEADER, false);
    
        $output=curl_exec($ch);
    
        curl_close($ch);
    
        return $output;
    }

    public function searchSponsor(Request $request)
    {
        if($request->ajax()) {
            // select country name from database
            $referralUser = User::where('referral_code', $request->referral_code)->first();
            $parentUser = User::where('id', $referralUser->sub_parent_id)->first();
            if(empty($parentUser))
            {
                $maxIndex = User::where('sub_parent_id', $referralUser->id)->where('side', $request->side)->max('index');
                if(empty($maxIndex))
                {
                    return response()->json(['sponsor_id' => $referralUser->referral_code, 'sponsor_name' => $referralUser->fullname]);
                }
                else{
                    $user = User::where('sub_parent_id', $referralUser->id)->where('side', $request->side)->where('index', $maxIndex)->first();
                    return response()->json(['sponsor_id' => $user->referral_code, 'sponsor_name' => $user->fullname]);
                }
            }
            else{
                $checkSide = $parentUser->side;
                if(empty($checkSide))
                {
                    if($request->side == $referralUser->side)
                    {
                        $maxIndex = User::where('sub_parent_id', $parentUser->id)->where('side', $request->side)->max('index');
                        if(empty($maxIndex))
                        {
                            return response()->json(['sponsor_id' => $referralUser->referral_code, 'sponsor_name' => $referralUser->fullname]);
                        }
                        else{
                            $user = User::where('sub_parent_id', $parentUser->id)->where('side', $request->side)->where('index', $maxIndex)->first();
                            // return $user->fullname;
                            return response()->json(['sponsor_id' => $user->referral_code, 'sponsor_name' => $user->fullname]);
                        }
                    }
                    else{
                        $maxIndex = User::where('sub_parent_id', $referralUser->id)->where('side', $request->side)->max('index');
                        if(empty($maxIndex)){
                            return response()->json(['sponsor_id' => $referralUser->referral_code, 'sponsor_name' => $referralUser->fullname]);
                        }
                        else{
                            $user = User::where('sub_parent_id', $referralUser->id)->where('side', $request->side)->where('index', $maxIndex)->first();
                            return response()->json(['sponsor_id' => $user->referral_code, 'sponsor_name' => $user->fullname]);
                        }
                    }
                }
                elseif($checkSide == $referralUser->side){
                    if($request->side == $referralUser->side)
                    {
                        $maxIndex = User::where('sub_parent_id', $parentUser->sub_parent_id)->where('side', $request->side)->max('index');
                        if(empty($maxIndex))
                        {
                            return response()->json(['sponsor_id' => $referralUser->referral_code, 'sponsor_name' => $referralUser->fullname]);
                        }
                        else{
                            $user = User::where('sub_parent_id', $parentUser->sub_parent_id)->where('side', $request->side)->where('index', $maxIndex)->first();
                            return response()->json(['sponsor_id' => $user->referral_code, 'sponsor_name' => $user->fullname]);
                        }
                    }
                    else{
                        $maxIndex = User::where('sub_parent_id', $data->id)->where('side', $request->join_side)->max('index');
                        if(empty($maxIndex)){
                            $index = 1;
                            $sub_parent_id = $data->id;
                        }
                        else{
                            $leftUser = User::where('sub_parent_id', $data->id)->where('side', $request->join_side)->where('index', $maxIndex)->first();
                            $index = $maxIndex + 1;
                            $sub_parent_id = $leftUser->sub_parent_id;
                        }
                    } 
                }
                else{
                    if($request->side == $referralUser->side)
                    {
                        $maxIndex = User::where('sub_parent_id', $parentUser->id)->where('side', $request->side)->max('index');
                        if(empty($maxIndex))
                        {
                            return response()->json(['sponsor_id' => $referralUser->referral_code, 'sponsor_name' => $referralUser->fullname]);
                        }
                        else{
                            $user = User::where('sub_parent_id', $parentUser->id)->where('side', $request->side)->where('index', $maxIndex)->first();
                            return response()->json(['sponsor_id' => $user->referral_code, 'sponsor_name' => $user->fullname]);
                        }
                    }
                    else{
                        $maxIndex = User::where('sub_parent_id', $referralUser->id)->where('side', $request->side)->max('index');
                        if(empty($maxIndex)){
                            return response()->json(['sponsor_id' => $referralUser->referral_code, 'sponsor_name' => $referralUser->fullname]);
                        }
                        else{
                            $user = User::where('sub_parent_id', $referralUser->id)->where('side', $request->side)->where('index', $maxIndex)->first();
                            return response()->json(['sponsor_id' => $user->referral_code, 'sponsor_name' => $user->fullname]);
                        }
                    }
                }
            }
                
        }
    }

}
