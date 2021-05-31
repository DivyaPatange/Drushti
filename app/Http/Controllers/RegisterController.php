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
        $users = User::where('parent_id', $data->id)->where('id', '!=', null)->get();
        // dd(count($users));
        if(count($users) < 10){
            $sponsorUser = User::where('referral_code', $request->sponsor_id)->first();
            if($sponsorUser->id == $data->id)
            {
                if($request->join_side == "L"){
                    $checkeUser = User::where('parent_id', $data->id)->where('index', 5)->first();
                    // dd($checkeUser->id == null);
                    if(!empty($checkeUser))
                    {
                        if($checkeUser->id == null)
                        {
                            $joinSide = User::where('parent_id', $data->id)->where('id', '=', null)->where('index', 5)
                            ->update([
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
                            ]);
                        }
                        else{
                            return Redirect::back()->with('danger', 'Joiner Already Exist!');
                        }
                    }
                    else{
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
                            'index' => 5,
                            'parent_id' => $data->id,
                        ]);
                    }
                }
                else{
                    $checkeUser = User::where('parent_id', $data->id)->where('index', 6)->first();
                    if(!empty($checkeUser))
                    {
                        if($checkeUser->id == null)
                        {
                            $joinSide = User::where('parent_id', $data->id)->where('id', '=', null)->where('index', 6)
                            ->update([
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
                            ]);
                        }
                        else{
                            return Redirect::back()->with('danger', 'Joiner Already Exist!');
                        }
                    }
                    else{
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
                            'index' => 6,
                            'parent_id' => $data->id,
                        ]);
                    }
                }
            }
            else{
                if($request->join_side == "L")
                {
                    $index = $sponsorUser->index - 1;
                    $checkeUser = User::where('parent_id', $data->id)->where('index', $index)->first();
                    if(!empty($checkeUser))
                    {
                        if($checkeUser->id == null){
                            $joinSide = User::where('parent_id', $data->id)->where('id', '=', null)->where('index', $index)
                            ->update([
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
                            ]);
                        }
                        else{
                            return Redirect::back()->with('danger', 'Joiner Already Exist!');
                        }
                    }
                    else{
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
                        ]);
                    }
                }
                if($request->join_side == "R")
                {
                    $index = $sponsorUser->index + 1;
                    $checkeUser = User::where('parent_id', $data->id)->where('index', $index)->first();
                    if(!empty($checkeUser))
                    {
                        if($checkeUser->id == null)
                        {
                            $joinSide = User::where('parent_id', $data->id)->where('id', '=', null)->where('index', $index)
                            ->update([
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
                            ]);
                        }
                        else{
                            return Redirect::back()->with('danger', 'Joiner Already Exist!');
                        }
                    }
                    else{
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
                        ]);
                    }
                }
            }
            for($i=1; $i <=5; $i++)
            {
                $user = new User();
                $user->parent_id = $id;
                $user->index = $i;
                $user->save();
            }
            for($i=6; $i <=10; $i++)
            {
                $user = new User();
                $user->parent_id = $id;
                $user->index = $i;
                $user->save();
            }
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

            $username = "MCP".$id;
            if($bankdetails->save()){
                $message = "Hello+".urlencode($request->fullname)."%0aWelcome+to+Market+Career+Power+Pvt.+Ltd."."%0aYour+Distributor+account+credentials+are+as+follows:%0aUsername:-+".$username."%0aPassword:-+".$request->password."%0aYou+can+login+to+your+distributor+account+here%0amarketcareerpower.com/login/";
                                      
                $number = $request->mobile_no;

                $this->sendSms($message,$number);
                // dd($this->sendSms($message,$number));
                $userDetail = User::where('id', $id)->first();
                
                return redirect('/login')->with('success', 'Registration is Successfully Done!');
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

}
