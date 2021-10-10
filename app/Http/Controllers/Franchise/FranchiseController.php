<?php

namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Franchise\Order;
use Auth;
use App\Models\Franchise\ProductPayment;
use App\Models\User;
use App\Models\Franchise\AdminPayment;
use DB;
use App\Models\Franchise;
use App\Models\Admin\FranchiseKycdetails;
use App\Models\Admin\FranchiseBankdetails;
use App\Models\Admin\FranchiseShopdetails;
use Illuminate\Support\Facades\Hash;
use App\Models\Franchise\Otp;

class FranchiseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:franchise');
    }
    
    public function order()
    {
        $orders = Order::where('franchise_id', Auth::guard('franchise')->user()->id)->get();
        if(request()->ajax())
        {
            return datatables()->of($orders)
            ->addColumn('status', function($row){
                if($row->status == 1)
                {
                    return '<span class="badge bg-teal">Approved</span>';
                }
                else{
                    return '<span class="badge bg-pink">Not Approved</span>';
                }
            })
            ->rawColumns(['status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('franchise.order.index');
    }

    public function orderStore(Request $request)
    {
        $order = new Order();
        $order->franchise_id = Auth::guard('franchise')->user()->id;
        $order->order_amt = $request->order_amt;
        $order->status = 0;
        $order->save();
        return response()->json(['success' => 'Product Request is Done']);
    }

    public function productPayment()
    {
        $productPayment = ProductPayment::where('franchise_id', Auth::guard('franchise')->user()->id)->where('plan', '10500')->get();
        if(request()->ajax())
        {
            return datatables()->of($productPayment)
            ->addColumn('username', function($row){
                $user = User::where('id', $row->user_id)->first();
                if(!empty($user))
                {
                    return $user->fullname;
                }
            })
            ->addColumn('referral_code', function($row){
                $user = User::where('id', $row->user_id)->first();
                if(!empty($user))
                {
                    return $user->referral_code;
                }
            })
            ->addColumn('payment_date', function($row){
                return date("Y-m-d", strtotime($row->payment_date));
            })
            ->addColumn('action', 'franchise.product-payment.action')
            ->rawColumns(['username', 'referral_code', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('franchise.product-payment.index');
    }

    public function search(Request $request)
    {
        if($request->ajax()) {
            // select country name from database
            $data = User::where('referral_code', 'LIKE', $request->referral_code.'%')
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
                    if($request->referral_code == $row->referral_code){
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

    public function storeProductPayment(Request $request)
    {
        $referral_code = $request->referral_code;
        $user = User::where('referral_code', $referral_code)->first();
        $productPayment = ProductPayment::where('referral_code', $referral_code)->where('product_amount', '=', 3000)->where('plan', '10500')->first();
        $order = DB::table('orders')->where('franchise_id', Auth::guard('franchise')->user()->id)->where('status', 1)->get()->sum('order_amt');
        // dd($product);
        $productPaymentAmount = DB::table('product_payments')->where('franchise_id', Auth::guard('franchise')->user()->id)->get()->sum('product_amount');
        // dd($productPaymentAmount);
        $balance = $order - $productPaymentAmount;
        // dd($balance);
        if($balance >= 3000)
        {
            if(empty($productPayment))
            {
                // $date = date('Y-m-d H:i:s');
                $productPayment = new ProductPayment();
                $productPayment->franchise_id = Auth::guard('franchise')->user()->id;
                $productPayment->user_id = $user->id;
                $productPayment->referral_code = $referral_code;
                $productPayment->product_amount = 3000;
                $productPayment->payment_date =  date("Y-m-d", strtotime($request->payment_date));
                $productPayment->plan = 10500;
                $productPayment->save();
                if($productPayment)
                {
                $message = "Hello+".urlencode($user->fullname)."%0aYour+Product+Payment+Done:+".$productPayment->product_amount."%0aRegards,+Market+Career+Power+Pvt.+Ltd.";
                    // dd($message);
                                
                    $number = $user->mobile;
                    $this->sendSms($message,$number);
                    // dd($this->sendSms($message, $number));
                }
                $adminPayment = new AdminPayment();
                $adminPayment->user_id = $user->id;
                $adminPayment->admingiven = 7500;
                $adminPayment->usergiven = 0;
                $adminPayment->remain = 7500;
                $adminPayment->save();
                return response()->json(['success' => 'Payment Received.']);
            }
            else{
                return response()->json(['danger' => 'Payment is already Received.']);
            }
        }
        else{
            return response()->json(['danger' => "Your Account doesn't have enough balance."]);
        }
    }

    public function sendSms($message,$number)
    {
        $url = 'http://sms.bulksmsind.in/v2/sendSMS?username=iceico&message='.$message.'&sendername=MRKTCP&smstype=TRANS&numbers='.$number.'&apikey=24ae8ae0-b514-499b-8baf-51d55808a2c4&peid=1201161909189905209&templateid=1207161976622516208';
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

    public function viewProductPayment($id)
    {
        $franchise = Franchise::where('id', Auth::guard('franchise')->user()->id)->first();
        $productPayment = ProductPayment::findorfail($id);
        $user = User::where('id', $productPayment->user_id)->first();
        $adminPayment = AdminPayment::where('user_id', $productPayment->user_id)->first();
        return view('franchise.product-payment.view', compact('productPayment', 'adminPayment', 'franchise', 'user'));
    }

    public function kycDocument()
    {
        $franchise = Franchise::findorfail(Auth::guard('franchise')->user()->id);
        $kycdetails = FranchiseKycdetails::where('franchise_id', Auth::guard('franchise')->user()->id)->first();
        return view('franchise.kyc-document', compact('franchise', 'kycdetails'));
    }

    public function uploadKycDocument(Request $request)
    {
        // $user = User::find($request->input('id'));
        $franchise = Franchise::findorfail(Auth::guard('franchise')->user()->id);
        // $kycdetails = Kycdetails::find($request->input('user_id'));
        $kycdetails = FranchiseKycdetails::where('franchise_id', Auth::guard('franchise')->user()->id)->first();
        if($request->pan != ''){        
            $path = public_path().'/kycdocument/pan/';
  
            //upload new file
            $file = $request->pan;
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);
  
            //for update in table
            $kycdetails->update(['pan' => $filename]);
       }

       if($request->cheque != ''){        
            $path1 = public_path().'/kycdocument/cheque/';

            //upload new file
            $file1 = $request->cheque;
            $filename1 = $file1->getClientOriginalName();
            $file1->move($path1, $filename1);

            //for update in table
            $kycdetails->update(['cheque' => $filename1]);
        }

        if($request->user_img != ''){        
            $path2 = public_path().'/kycdocument/userImg/';
    
            //upload new file
            $file2 = $request->user_img;
            $filename2 = $file2->getClientOriginalName();
            $file2->move($path2, $filename2);
    
            //for update in table
            $kycdetails->update(['user_img' => $filename2]);
        }
   

        return redirect('/franchise/kyc-document')->with('success', 'KYC Document Uploaded.');
    }

    public function profile()
    {
        $franchise = Franchise::findorfail(Auth::guard('franchise')->user()->id);
        $kycdetails = FranchiseKycdetails::where('franchise_id', Auth::guard('franchise')->user()->id)->first();
        $bankdetails = FranchiseBankdetails::where('franchise_id', Auth::guard('franchise')->user()->id)->first();
        $shopdetails = FranchiseShopdetails::where('franchise_id', Auth::guard('franchise')->user()->id)->first();

        return view('franchise.profile', compact('franchise', 'kycdetails', 'bankdetails', 'shopdetails'));
    }

    public function updateProfile(Request $request)
    {
        $franchise = Franchise::findorfail(Auth::guard('franchise')->user()->id);
        
        $franchise->fullname = $request->fullname;
        $franchise->email = $request->email;
        $franchise->mobile = $request->mobile;
        $franchise->address = $request->address;
        $franchise->nominee_name = $request->nominee_name;
        $franchise->nominee_relation = $request->nominee_relation;
        $franchise->update($request->all());

        $kycdetails = FranchiseKycdetails::where('franchise_id', Auth::guard('franchise')->user()->id)->first();
        $kycdetails->pan_no = $request->pan_no;
        $kycdetails->aadhar_no = $request->aadhar_no;
        $kycdetails->update($request->all());

        $bankdetails = FranchiseBankdetails::where('franchise_id', Auth::guard('franchise')->user()->id)->first();
        $bankdetails->bank_name = $request->bank_name;
        $bankdetails->branch_name = $request->branch_name;
        $bankdetails->ifsc_code = $request->ifsc_code;
        $bankdetails->acc_no = $request->acc_no;
        $bankdetails->acc_holder_name = $request->acc_holder_name;
        $bankdetails->update($request->all());

        $shopdetails = FranchiseShopdetails::where('franchise_id', Auth::guard('franchise')->user()->id)->first();
        $shopdetails->shop_name = $request->shop_name;
        $shopdetails->shop_registration_id = $request->shop_id;
        $shopdetails->update($request->all());

        return response()->json(['success' => 'Profile Updated Successfully!']);
    }

    public function updatePassword(Request $request)
    {
        $franchise = Franchise::where('id', Auth::guard('franchise')->user()->id)->update([
            'password' => Hash::make($request->NewPassword),
            'password_1' => $request->NewPassword,
        ]);
        return response()->json(['success' => 'Password Updated Successfully!']);
    }

    public function payment()
    {
        return view('franchise.product-payment.payment');
    }

    public function searchDistributorDetails(Request $request)
    {
        if($request->ajax()) {
            // select country name from database
            $data = DB::table('users')
            ->where('referral_code', 'LIKE', $request->referral_info.'%')
                ->get();
                // dd($data);
                
        
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
                foreach ($data as $row){
                    // dd($request->referral_info == $row->referral_code);
                    if($request->referral_info == $row->referral_code){
                    // concatenate output to the array
                    // dd($adminPayment->amount);
                    $adminPayment = DB::table('admin_payments')->where('user_id', $row->id)->first();
                    // dd($adminPayment);
                    $rank = DB::table('rewards')->where('user_id', $row->id)->where('status', 'Qualified')->get();
                    // dd($rank);
                    $output .= '<tr>'.
                    '<td>User Name</td>'.
                    '<td><span style="color:green;font-size:15px;">'. $row->fullname.'</span></td>'.  
                    '</tr>';
                    if($adminPayment){
                        $output .= '<tr>'.
                        '<td>Admin Wallet</td>'.
                        '<td><span style="color:green;font-size:15px;">'.$adminPayment->usergiven.'</span></td>'.  
                        '</tr>';
                    }
                    // dd($output);
                    if(count($rank) > 0){
                        $output .= '<tr>'.
                        '<td>Reward</td>';
                        foreach($rank as $r)
                        {
                            $output .= '<td><span style="color:green;font-size:15px;">'. $r->net_income.'</span></td>';
                        }
                          
                        $output .='</tr>';
                    }
                   
                        
                    
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

    public function sendOtp(Request $request)
    {
        $user = DB::table('users')->where('referral_code', $request->referral_code)->first();
        $adminPayment = DB::table('admin_payments')->where('user_id',  $user->id)->first();
        
        $otp = mt_rand(100000,999999);
        $otps = new Otp();
        $otps->otp = $otp;
        $otps->save();
        $message = "Hello+".urlencode($user->fullname)."%0aYour+OTP+is:+".$otp."%0aRegards,+Market+Career+Power+Pvt.+Ltd.";
        // dd($message);
                    
        $number = $user->mobile;

        $this->sendSms1($message,$number);
        return response()->json(['success' => 'OTP Send Successfully!', 'referral_id' => $request->referral_code]);
    }

    public function sendSms1($message,$number)
    {
        $url = 'http://sms.bulksmsind.in/v2/sendSMS?username=iceico&message='.$message.'&sendername=MRKTCP&smstype=TRANS&numbers='.$number.'&apikey=24ae8ae0-b514-499b-8baf-51d55808a2c4&peid=1201161909189905209&templateid=1207161976611807625';
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

    
    public function submitProductPayment(Request $request)
    {
        $otp = $request->otp;
        $user = User::where('referral_code', '=', $request->referral_code)->first();
        $checkOtp = DB::table('otps')->where('otp', $otp)->first();
        $productPayment = ProductPayment::where('referral_code', $request->referral_code)->where('product_amount', '=', 7500)->first();
        // dd($checkOtp);
        $product = DB::table('orders')->where('franchise_id', Auth::guard('franchise')->user()->id)->where('status', 1)->get()->sum('order_amt');
        // dd($product);
        $productPaymentAmount = DB::table('product_payments')->where('franchise_id', Auth::guard('franchise')->user()->id)->get()->sum('product_amount');
        // dd($productPaymentAmount);
        $balance = $product - $productPaymentAmount;
        // dd($balance);
        if($balance >= 7500)
        {
            if($checkOtp->status == 1)
            {
                return response()->json(['danger' => 'OTP is Already used!']);
            }
            else{   
                if(empty($productPayment))
                {
                    // $date = date('Y-m-d H:i:s');
                    $payment =  new ProductPayment();
                    $payment->user_id = $user->id;
                    $payment->franchise_id = Auth::guard('franchise')->user()->id;
                    $payment->referral_code = $request->referral_code;
                    $payment->product_amount = 7500;
                    $payment->payment_date = date('Y-m-d',strtotime($request->payment_date));
                    $payment->save();
                    $message = "Hello+".urlencode($user->fullname)."%0aYour+Product+Payment+Done:+".$payment->product_amount."%0aRegards,+Market+Career+Power+Pvt.+Ltd.";
                                
                    $number = $user->mobile;
            
                    $this->sendSms($message,$number);
                    $checkOtps = Otp::where('otp', $otp)->update(['status' => 1]);
                    return response()->json(['success' => 'Product Payment Successfully Done!']);
                }
                else{
                    return response()->json(['danger' => 'Payment is already Received.']);
                } 
            }
        }
        else{
            return response()->json(['danger' => "Your Account doesn't have enough balance."]);
        }
        
    }
}
