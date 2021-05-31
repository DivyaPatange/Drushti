<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Franchise;
use App\Models\Admin\FranchiseBankdetails;
use App\Models\Admin\FranchiseKycdetails;
use App\Models\Admin\FranchiseShopdetails;
use Illuminate\Support\Facades\Hash;

class FranchiseRegisterController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:franchise')->except('logout');
    }
    
    public function showRegisterForm()
    {
        return view('franchise.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            // 'email' => 'required',
            'mobile_no' => 'required',
            'address' => 'required',
            'password' => 'required|min:8|confirmed',
            'shop_name' => 'required',
            'shop_registration_id' => 'required',
        ]);
        $id = mt_rand(10000000,99999999);
        $franchise = new Franchise();
        $franchise->id = $id;
        $franchise->fullname = $request->fullname;
        $franchise->email = $request->email;
        $username = "MKCP".$franchise->id;
        $franchise->username = $username;
        $franchise->mobile = $request->mobile_no;
        $franchise->nominee_name = $request->nominee_name;
        $franchise->nominee_relation = $request->nominee_relation;
        $franchise->reg_date = date("Y-m-d");
        $franchise->address = $request->address;
        $franchise->password = Hash::make($request->password);
        $franchise->password_1 = $request->password;
        $franchise->save();

        $kycdetails = new FranchiseKycdetails();

        $kycdetails->franchise_id = $id;
        $kycdetails->pan_no = $request->pan_no;
        $kycdetails->aadhar_no = $request->aadhar_no;
        $kycdetails->save();
        
        $bankdetails = new FranchiseBankdetails();
        $bankdetails->franchise_id = $id;
        $bankdetails->bank_name = $request->bank_name;
        $bankdetails->branch_name = $request->branch_name;
        $bankdetails->ifsc_code = $request->ifsc_code;
        $bankdetails->acc_no = $request->acc_no;
        $bankdetails->acc_holder_name = $request->acc_holder_name;
        $bankdetails->save();

        $shopdetails = new FranchiseShopdetails();
        $shopdetails->franchise_id = $id;
        $shopdetails->shop_name = $request->shop_name;
        $shopdetails->shop_registration_id = $request->shop_registration_id;
        $shopdetails->save();
        if($franchise->save()){
            $message = "Hello+".urlencode($request->fullname)."%0aWelcome+to+Market+Career+Power+Pvt.+Ltd.+"."%0aYour+Franchise+account+credentials+are+as+follows:%0aUsername:-+".$username."%0aPassword:-+".$request->password."%0aYou+can+login+to+your+distributor+account+here%0ahttps://marketcareerpower.com/franchise/login";
                        
            // dd($message);
            $number = $request->mobile_no;
    
            $this->sendSms($message,$number);
            // dd($this->sendSms($message,$number));
            return redirect('/franchise/login')->with([
                'franchise' => $franchise,
                'kycdetails' => $kycdetails,
                'bankdetails' => $bankdetails,
                'shopdetails' => $shopdetails,
            ])->with('success', 'Registration is Successfully Done!');
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
}
