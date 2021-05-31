<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use app\Models\Admin\UserInfo;
use app\Models\Admin\UserBankDetail;
use app\Models\Admin\UserKycDetail;
use Redirect;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'referral_code' => ['required'],
            'sponsor_id' => ['required'],
            'fullname' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile_no' => ['required', 'digits:10'],
            'address' => ['required'],
            'join_side' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $id = mt_rand(10000000,99999999);
        $user_referral_info = $data['referral_code'];
        $data = User::where('referral_code',$user_referral_info )->first();
        $users = User::where('parent_id', $data->id)->select('id')->get();
        if(count($users) < 10){
            $sponsorUser = User::where('referral_code', $data['sponsor_id'])->first();
            if($sponsorUser->id == $data->id)
            {
                if($data['join_side'] == "L"){
                    $checkeUser = User::where('parent_id', $data->id)->where('index', 5)->first();
                    // dd($checkeUser->id == null);
                    if($checkeUser->id == null)
                    {
                        $joinSide = User::where('parent_id', $data->id)->where('id', '=', null)->where('index', 5)
                        ->update([
                            'id' => $id,
                            'fullname' => $data['fullname'],
                            'email' => $data['email'],
                            'username' => "MKP".$id,
                            'mobile' => $data['mobile_no'],
                            'address' => $data['address'],
                            'password' => Hash::make($data['password']),
                            'password_1' => $data['password'],
                            'referral_code' => "MKP".$id,
                            'reg_date' => date("Y-m-d"),
                        ]);
                    }
                    else{
                        return Redirect::back()->with('danger', 'Joiner Already Exist!');
                    }
                }
                else{
                    $checkeUser = User::where('parent_id', $data->id)->where('index', 6)->first();
                    if($checkeUser->id == null)
                    {
                        $joinSide = User::where('parent_id', $data->id)->where('id', '=', null)->where('index', 6)
                        ->update([
                            'id' => $id,
                            'fullname' => $data['fullname'],
                            'email' => $data['email'],
                            'username' => "MKP".$id,
                            'mobile' => $data['mobile_no'],
                            'address' => $data['address'],
                            'password' => Hash::make($data['password']),
                            'password_1' => $data['password'],
                            'referral_code' => "MKP".$id,
                            'reg_date' => date("Y-m-d"),
                        ]);
                    }
                    else{
                        return Redirect::back()->with('danger', 'Joiner Already Exist!');
                    }
                }
            }
            else{
                if($request->join_side == "L")
                {
                    $index = $sponsorUser->index - 1;
                    $checkeUser = User::where('parent_id', $data->id)->where('index', $index)->first();
                    if($checkeUser->id == null)
                    {
                        $joinSide = User::where('parent_id', $data->id)->where('id', '=', null)->where('index', $index)
                        ->update([
                            'id' => $id,
                            'fullname' => $data['fullname'],
                            'email' => $data['email'],
                            'username' => "MKP".$id,
                            'mobile' => $data['mobile_no'],
                            'address' => $data['address'],
                            'password' => Hash::make($data['password']),
                            'password_1' => $data['password'],
                            'referral_code' => "MKP".$id,
                            'reg_date' => date("Y-m-d"),
                        ]);
                    }
                    else{
                        return Redirect::back()->with('danger', 'Joiner Already Exist!');
                    }
                }
                if($request->join_side == "R")
                {
                    $index = $sponsorUser->index + 1;
                    $checkeUser = User::where('parent_id', $data->id)->where('index', $index)->first();
                    if($checkeUser->id == null)
                    {
                        $joinSide = User::where('parent_id', $data->id)->where('id', '=', null)->where('index', $index)
                        ->update([
                            'id' => $id,
                            'fullname' => $data['fullname'],
                            'email' => $data['email'],
                            'username' => "MKP".$id,
                            'mobile' => $data['mobile_no'],
                            'address' => $data['address'],
                            'password' => Hash::make($data['password']),
                            'password_1' => $data['password'],
                            'referral_code' => "MKP".$id,
                            'reg_date' => date("Y-m-d"),
                        ]);
                    }
                    else{
                        return Redirect::back()->with('danger', 'Joiner Already Exist!');
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
            $usersInfo->nominee_name = $data['nominee_name'];
            $usersInfo->nominee_relation = $data['nominee_relation'];
            $usersInfo->save();

            $kycdetails = new UserKycDetail();
            $kycdetails->user_id = $id;
            $kycdetails->pan_no = $data['pan_no'];
            $kycdetails->aadhar_no = $data['aadhar_no'];
            $kycdetails->save();
        
            $bankdetails = new UserBankDetail();
            $bankdetails->user_id = $id;
            $bankdetails->bank_name = $data['bank_name'];
            $bankdetails->branch_name = $data['branch_name'];
            $bankdetails->ifsc_code = $data['ifsc_code'];
            $bankdetails->acc_no = $data['acc_no'];
            $bankdetails->acc_holder_name = $data['acc_holder_name'];
            $bankdetails->save();

            if($bankdetails->save()){
                $message = "Hello+".urlencode($data['fullname'])."%0aWelcome+to+Market+Career+Power+"."%0aYour+Distributer+account+credentials+are+as+follows:%0aUsername:-+".$username."%0aPassword:-+".$data['password']."%0aYou+can+login+to+your+distributer+account+here%0ahttps://marketcareerpower.com/login/";
                            
                $number = $request->mobile_no;

                $this->sendSms($message,$number);
                // dd($this->sendSms($message,$number));
                $userDetail = User::where('id', $id)->first();
                return userDetail;
            } 
        }
        else{
            
            return Redirect::back()->with('danger', 'You cannot add more than 10 joiners.');
        }
    }

    public function sendSms($message,$number)
    {
        $url = 'http://sms.bulksmsind.in/v2/sendSMS?username=iceico&message='.$message.'&sendername=ICEICO&smstype=TRANS&numbers='.$number.'&apikey=24ae8ae0-b514-499b-8baf-51d55808a2c4&peid=1201161909189905209&templateid=1207161959177676662';
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

    public function search(Request $request)
    {
        if($request->ajax()) {
            // select country name from database
            $data = User::where('referral_code', 'LIKE', $request->user_referral_info.'%')
                ->get();
                
        
            // declare an empty array for output
            $output = '';
            // if searched countries count is larager than zero
            // dd(!(isset($data)) || empty($data));
            if(!(isset($data)) || empty($data))
            {
                return array("error","Please Enter Valid Referral Code");
            }
            if (count($data)>0) {
                // concatenate output to the array
                // loop through the result array
                foreach ($data as $row)
                {
                    if($request->user_referral_info == $row->referral_code){
                       $output .= $row->fullname;
                    }
                }
                // end of output
            }
            
            else {
                // if there's no matching results according to the input
                $output .= 'No results';
            }
            // return output result array
            return $output;
        }
    }
}
