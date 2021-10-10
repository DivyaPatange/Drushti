<?php

namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Franchise\ProductPayment;
use App\Models\User;
use Auth;
use DB;

class PlanPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productPayment = ProductPayment::where('franchise_id', Auth::guard('franchise')->user()->id)->where('plan', '3000')->get();
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
        return view('franchise.plan-payment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $referral_code = $request->referral_code;
        $user = User::where('referral_code', $referral_code)->first();
        $productPayment = ProductPayment::where('referral_code', $referral_code)->where('product_amount', '=', 3000)->where('plan', '3000')->first();
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
                $productPayment = new ProductPayment();
                $productPayment->franchise_id = Auth::guard('franchise')->user()->id;
                $productPayment->user_id = $user->id;
                $productPayment->referral_code = $referral_code;
                $productPayment->product_amount = 3000;
                $productPayment->payment_date =  date("Y-m-d", strtotime($request->payment_date));
                $productPayment->plan = 3000;
                $productPayment->save();
                if($productPayment)
                {
                $message = "Hello+".urlencode($user->fullname)."%0aYour+Product+Payment+Done:+".$productPayment->product_amount."%0aRegards,+Market+Career+Power+Pvt.+Ltd.";
                    // dd($message);
                                
                    $number = $user->mobile;
                    $this->sendSms($message,$number);
                    // dd($this->sendSms($message, $number));
                }
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
