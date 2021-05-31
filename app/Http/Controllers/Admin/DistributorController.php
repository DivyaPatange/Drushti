<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Distributor;
use App\Models\User;
use App\Models\Admin\UserInfo;
use App\Models\Admin\UserBankDetail;
use App\Models\Admin\UserKycDetail;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\Admin\Settlement;
use DateTime;
use App\Models\Admin\UserWallet;
use App\Models\Admin\PaymentSettlement;
use App\Models\Franchise\ProductPayment;

class DistributorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')
        ->where('users.id', '!=', null)
        // ->join('user_kyc_details', 'user_kyc_details.user_id', '=', 'users.id')
        // ->join('user_bank_details', 'user_bank_details.user_id', '=', 'users.id')
        // ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
        ->select('users.*')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($users)
            ->addColumn('action', 'admin.distributor.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.distributor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.distributor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'mobile_no' => 'required|digits:10',
            'address' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        $id = mt_rand(10000000,99999999);
        
        $user = new User();
        $password = $request->password;
        $user->id = $id;
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $username = "MCP".$user->id;
        $user->username = $username;
        $user->mobile = $request->mobile_no;
        $user->address = $request->address;
        $user->password = Hash::make($password);
        $user->password_1 = $password;
        $user->parent_id = $request->parent_id;
        $user->referral_code = "MCP".$user->id;
        $user->reg_date = date('Y-m-d');
        $user->save();

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
        
        if($user->save()){
            $message = "Hello+".urlencode($request->fullname)."%0aWelcome+to+Market+Career+Power+Pvt.+Ltd."."%0aYour+Distributor+account+credentials+are+as+follows:%0aUsername:-+".$username."%0aPassword:-+".$request->password."%0aYou+can+login+to+your+distributor+account+here%0amarketcareerpower.com/login/";             
            $number = $request->mobile_no;

            $this->sendSms($message,$number);    
    
    
            return redirect('admin/distributor')->with([
                'user' => $user,
                'kycdetails' => $kycdetails,
                'bankdetails' => $bankdetails,
                'usersInfo' => $usersInfo,
            ])->with('success','Joiner Added Successfully!');
                
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findorfail($id);
        $kycdetails = UserKycDetail::where('user_id', $id)->first();
        $bankdetails = UserBankDetail::where('user_id', $id)->first();
        $usersInfo = UserInfo::where('user_id', $id)->first();
        return view('admin.distributor.show', compact('user', 'kycdetails', 'bankdetails', 'usersInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findorfail($id);
        $kycdetails = UserKycDetail::where('user_id', $id)->first();
        $bankdetails = UserBankDetail::where('user_id', $id)->first();
        $usersInfo = UserInfo::where('user_id', $id)->first();
        return view('admin.distributor.edit', compact('user', 'kycdetails', 'bankdetails', 'usersInfo'));
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
        $request->validate([
            'fullname' => 'required',
            'mobile' => 'required|digits:10',
            'address' => 'required',
        ]);
        $user = User::findorfail($id);
        
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->update($request->all());

        $usersInfo = UserInfo::where('user_id', $id)->first();
        $usersInfo->nominee_name = $request->nominee_name;
        $usersInfo->nominee_relation = $request->nominee_relation;
        $usersInfo->update($request->all());

        $kycdetails = UserKycDetail::where('user_id', $id)->first();
        // $kycdetails = Kycdetails::find($request->input('user_id'));
        $kycdetails->pan_no = $request->pan_no;
        $kycdetails->aadhar_no = $request->aadhar_no;
        $kycdetails->update($request->all());

        $bankdetails = UserBankDetail::where('user_id', $id)->first();
        // $bankdetails = BankDetails::find($request->input('user_id'));
        $bankdetails->bank_name = $request->bank_name;
        $bankdetails->branch_name = $request->branch_name;
        $bankdetails->ifsc_code = $request->ifsc_code;
        $bankdetails->acc_no = $request->acc_no;
        $bankdetails->acc_holder_name = $request->acc_holder_name;
        $bankdetails->update($request->all());


        return redirect('/admin/distributor')->with('success', 'Joiner Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findorfail($id);
        $usersInfo = UserInfo::where('user_id', $id)->first();
        $kycdetails = UserKycDetail::where('user_id', $id)->first();
        $bankdetails = UserBankDetail::where('user_id', $id)->first();
        $user->delete();
        if(!empty($usersInfo)){
            $usersInfo->delete();
        }
        if(!empty($kycdetails)){
            $kycdetails->delete();
        }
        if(!empty($kycdetails)){
            $bankdetails->delete();
        }
        return response()->json(['success' => 'Distributor Deleted Success']);
    }

    public function companyTree()
    {
        $users = User::where('parent_id', '=', 0)->get();
        $allMenus = User::pluck('fullname', 'referral_code','id', 'index')->all();
        return view('admin.company-tree.index', compact('users', 'allMenus'));
    }

    public function distributorKycVerification()
    {
        $users = DB::table('user_kyc_details')->join('users', 'users.id', '=', 'user_kyc_details.user_id')
                ->where('user_kyc_details.user_img', '!=', null)->where('user_kyc_details.pan', '!=', null)->where('user_kyc_details.cheque', '!=', null)
                ->select('user_kyc_details.*', 'users.fullname', 'users.mobile', 'users.referral_code')->get();
        // dd($users);
        if(request()->ajax())
        {
            return datatables()->of($users)
            ->addColumn('pan', function($row){
                $imageUrl = asset('kycdocument/pan/' . $row->pan);
                return '<a href="'.$imageUrl.'" target="_blank"><button type="button" class="btn bg-indigo waves-effect">View</button></a>';
            })
            ->addColumn('cheque', function($row){
                $imageUrl = asset('kycdocument/cheque/' . $row->cheque);
                return '<a href="'.$imageUrl.'" target="_blank"><button type="button" class="btn bg-indigo waves-effect">View</button></a>';
            })
            ->addColumn('user_img', function($row){
                $imageUrl = asset('kycdocument/userImg/' . $row->user_img);
                return '<a href="'.$imageUrl.'" target="_blank"><button type="button" class="btn bg-indigo waves-effect">View</button></a>';
            })
            ->addColumn('action', function($row){
                if($row->verified == 0){
                    return '<button type="button" data-id="'.$row->id.'" id="status" class="btn bg-green waves-effect">Approve</button></a>';
                }
                else{
                    return '<button type="button" data-id="'.$row->id.'" id="status" class="btn bg-red waves-effect">Reject</button></a>';
                }
            })
            ->rawColumns(['pan', 'cheque', 'user_img', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.kyc-verification.distributor');

    }

    public function kycStatus(Request $request, $id)
    {
        $kycdetails = UserKycDetail::findorfail($id);
        if($kycdetails->verified == 1)
        {
            $kycdetails->verified = 0;
            $kycdetails->update($request->all());
            return response()->json(['error' => 'KYC Verification is Rejected!']);
        }
        else{
            $kycdetails->verified = 1;
            $kycdetails->update($request->all());
            return response()->json(['success' => 'KYC Verification is Approved!']);
        }
    }

    public function incomeSettlement()
    {
        $joiners1 = User::where('parent_id', 0)->get();
        $settlement = Settlement::where('reason', 'Income')->get();
        if(request()->ajax())
        {
            return datatables()->of($settlement)
            ->addColumn('start_date', function($row){
                return date('d-m-Y', strtotime($row->start_date));
            })
            ->addColumn('end_date', function($row){
                return date('d-m-Y', strtotime($row->end_date));
            })
            ->addColumn('action', function($row){
                $route = route('admin.income-settlement.view', $row->id);
                return '<a href="'.$route.'"><button type="button" class="btn bg-indigo waves-effect">View</button></a>';
            })
            ->rawColumns(['start_date', 'end_date', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.payment-settlement.income', compact('joiners1'));
    }

    public function generateIncomeSettlement(Request $request)
    {
        $start_date = date("Y-m-d", strtotime($request->start_date));
        $end_date = date("Y-m-d", strtotime($request->end_date));
        $date = date("d",strtotime($start_date));
        $month1 = date("m",strtotime($start_date));
        $month = date("F",strtotime($start_date));
        $year=date("Y",strtotime($end_date));
        $prev_month_ts = strtotime($start_date.' -1 month');
        $prev_month = date('m', $prev_month_ts);
        $prev_year = date('Y', $prev_month_ts);
        $dt = $prev_year.'-'.$prev_month;
        if($date == 01)
        {
            $startDate = $prev_year.'-'.$prev_month.'-16';
            $endDate = date("Y-m-t", strtotime($dt));
        }
        else{
            $startDate = $year.'-'.$month1.'-01';
            $endDate = $year.'-'.$month1.'-15';
        }
        // return $start_date;
        $users = DB::table('users')->get();
        $settlement = DB::table('settlements')->where('start_date', $start_date)->where('end_date', $end_date)->where('reason', 'Income')->first();    
        // return empty($settlement);
        if(empty($settlement)){
            $settlement = new Settlement();
            $settlement->month_year = $month." ".$year;
            $settlement->start_date = $start_date;
            $settlement->end_date = $end_date;
            $settlement->prev_start_date = $startDate;
            $settlement->prev_end_date = $endDate;
            $settlement->reason = "Income";
            $settlement->save();
            foreach($users as $user)
            {
                $income = DB::table('user_incomes')->whereBetween('payment_date', [$startDate , $endDate])
                ->where('user_id', $user->id)->get()->sum('net_income');
                $adminwallet = DB::table('admin_payments')->where('user_id', $user->id)->first();
                $paymentDetails = DB::table('product_payments')->where('user_id', $user->id)->where('product_amount', 3000)->first();
                if(!empty($paymentDetails)){
                    $user_dt = new DateTime($paymentDetails->payment_date);
                    $user_converted_at = $user_dt->format('Y-m-d');
                    $dt = strtotime($user_converted_at);
                    $extendedDate = date("Y-m-d", strtotime("+15 month", $dt));
                    $convertExtendedDate =strtotime($extendedDate);
                    $month1=date("F",$convertExtendedDate);
                    $year1 = date("Y", $convertExtendedDate);
                }
                if(date("YF", strtotime($month.'-'.$year)) <= date("YF", strtotime($month1.'-'.$year1)))
                {
                    $userwallet = DB::table('user_wallets')->where('user_id', $user->id)->where('date_from',$start_date)->where('date_to', $end_date)->where('settlement_id', $settlement->id)->first();
                    if($income > 0)
                    {
                        if(empty($userwallet))
                        {
                            $userwallet = new UserWallet();
                            $userwallet->settlement_id = $settlement->id;
                            $userwallet->user_id = $user->id;
                            $userwallet->salary = $income;
                            $userwallet->balance = $adminwallet->remain;
                            $userwallet->extra = 0;
                            $userwallet->adminwallet = 0;
                            $userwallet->date_from = $start_date;
                            $userwallet->date_to =  $end_date;
                            $userwallet->reason = "Income";
                            $userwallet->save();
                            if($userwallet)
                            {
                                $empSalary = $userwallet->salary;
                                $paidToAdmin = $userwallet->balance;
                                $usergiven = $adminwallet->usergiven;
                                if($paidToAdmin > 0)
                                {
                                    if($empSalary < $paidToAdmin)
                                    {
                                        $totalDue = $userwallet->balance;
                                        $remain = $paidToAdmin - $empSalary;
                                        $giveToAdmin = $usergiven + $empSalary;
                                        $totalAvailable = $totalDue - ($empSalary + $remain);
                                        $row = DB::table('admin_payments')->where('user_id', $user->id)->update(['usergiven' => $giveToAdmin, 'remain' => $remain]);
                                        $row1 = DB::table('user_wallets')->where('user_id', $user->id)->where('date_from',$start_date)->where('date_to', $end_date)->where('settlement_id', $settlement->id)->update(['extra' => $totalAvailable, 'balance' => $remain, 'adminwallet' => $empSalary]);
        
                                    }
                                    else{
                                        $extra = $empSalary - $paidToAdmin;
                                        $balance = $empSalary - ($paidToAdmin + $extra);
                                        $row2 = DB::table('admin_payments')->where('user_id', $user->id)->update(['usergiven' => 7500, 'remain' => $balance]);
                                        $row3 = DB::table('user_wallets')->where('user_id', $user->id)->where('date_from',$start_date)->where('date_to', $end_date)->where('settlement_id', $settlement->id)->update(['extra' => $extra, 'balance' => $balance, 'adminwallet' => $paidToAdmin]);
                                    }
                                }
                                elseif($userwallet->balance == 0){
                                    $row4 = DB::table('user_wallets')->where('user_id', $user->id)->where('date_from',$start_date)->where('date_to', $end_date)->where('settlement_id', $settlement->id)->update(['extra' => $empSalary, 'balance' => $userwallet->balance, 'adminwallet' => $userwallet->balance]);
                                }
                                $transaction = DB::table('user_wallets')->where('user_id', $user->id)->where('date_from',$start_date)->where('date_to', $end_date)->where('settlement_id', $settlement->id)->first();
                                // dd($transaction);
                                $adminWallet = DB::table('admin_payments')->where('user_id', $user->id)->where('usergiven', 7500)->first();
                                if(!empty($paymentDetails))
                                {
                                    if(!empty($adminWallet))
                                    {
                                        if($transaction->extra > 0)
                                        {
                                            $payment = new PaymentSettlement();
                                            $payment->settlement_id = $settlement->id;
                                            $payment->user_id = $transaction->user_id;
                                            $payment->total = $transaction->extra;
                                            $payment->from_date = $start_date;
                                            $payment->to_date = $end_date;
                                            $payment->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return response()->json(['success' => 'Settlement is Generated!']);
        }
        else{
            return response()->json(['error' => 'Settlement is already Generated!']);
        }
    }

    public static function getUserLevel($id)
    {
        $users = User::where('parent_id', $id)->get();
        $allMenus = User::pluck('fullname', 'referral_code','id', 'index')->all();
        $items = array();
        $items1 = array();
        $items2 = array();
        $items3 = array();
        $items4 = array();
        $items5 = array();
        foreach($users as $user)
        {
            if(!empty($user->id)){
                $levelPayment = ProductPayment::where('user_id', $user->id)->where('product_amount', 3000)->first();
                if(!empty($levelPayment)){
                    $items[] = $levelPayment->payment_date;
                }
                foreach($user->childs as $child)
                {
                    if(!empty($child->id)){
                        $levelPayment1 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                        if(!empty($levelPayment1)){
                            $items1[] = $levelPayment1->payment_date;
                        }
                        foreach($child->childs as $child)
                        {
                            if(!empty($child->id)){
                                $levelPayment2 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                                if(!empty($levelPayment2)){
                                    $items2[] = $levelPayment2->payment_date;
                                }
                                foreach($child->childs as $child)
                                {
                                    if(!empty($child->id)){
                                        $levelPayment3 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                                        if(!empty($levelPayment3)){
                                            $items3[] = $levelPayment3->payment_date;
                                        }
                                        foreach($child->childs as $child)
                                        {
                                            if(!empty($child->id)){
                                                $levelPayment4 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                                                if(!empty($levelPayment4)){
                                                    $items4[] = $levelPayment4->payment_date;
                                                }
                                                foreach($child->childs as $child)
                                                {
                                                    if(!empty($child->id)){
                                                        $levelPayment5 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                                                        if(!empty($levelPayment5)){
                                                            $items5[] = $levelPayment5->payment_date;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return compact('users', 'allMenus', 'items', 'items1', 'items2', 'items3', 'items4', 'items5'); 
    }

    public function salarySettlement()
    {
        $joiners1 = User::where('parent_id', 0)->get();
        $settlement = Settlement::where('reason', 'Salary')->get();
        if(request()->ajax())
        {
            return datatables()->of($settlement)
            ->addColumn('start_date', function($row){
                return date('d-m-Y', strtotime($row->start_date));
            })
            ->addColumn('end_date', function($row){
                return date('d-m-Y', strtotime($row->end_date));
            })
            ->addColumn('action', function($row){
                $route = route('admin.salary-settlement.view', $row->id);
                return '<a href="'.$route.'"><button type="button" class="btn bg-indigo waves-effect">View</button></a>';
            })
            ->rawColumns(['start_date', 'end_date', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.payment-settlement.salary', compact('joiners1'));
    }

    public function generateSalarySettlement(Request $request)
    {
        $year = $request->year;
        $start_date = $year.'-'.$request->month.'-01';
        $end_date = date("Y-m-t", strtotime($start_date));
        $prev_month_ts = strtotime($start_date.' -1 month');
        $prev_month = date('m', $prev_month_ts);
        $prev_year = date('Y', $prev_month_ts);
        $dt = $prev_year.'-'.$prev_month;
        $month = date('F', mktime(0,0,0,$request->month, 1, date('Y')));
        $startDate = date("Y-m-01", strtotime($dt));
        $endDate = date("Y-m-t", strtotime($dt));
        $users = DB::table('users')->get();
        $settlement = DB::table('settlements')->where('start_date', $start_date)->where('end_date', $end_date)->where('reason', 'Salary')->first();
        if(empty($settlement)){
            $settlement = new Settlement();
            $settlement->month_year = $month." ".$year;
            $settlement->start_date = $start_date;
            $settlement->end_date = $end_date;
            $settlement->prev_start_date = $startDate;
            $settlement->prev_end_date = $endDate;
            $settlement->reason = "Salary";
            $settlement->save();
            foreach($users as $user)
            {
                $salary = DB::table('user_salaries')->whereBetween('payment_date', [$startDate , $endDate])
                ->where('user_id', $user->id)->get()->sum('net_income');
                $reward = DB::table('rewards')->whereBetween('date', [$startDate , $endDate])
                ->where('user_id', $user->id)->where('status', 'Qualified')->get()->sum('net_income');
                $adminwallet = DB::table('admin_payments')->where('user_id', $user->id)->first();
                $paymentDetails = DB::table('product_payments')->where('user_id', $user->id)->where('product_amount', 3000)->first();
                if(!empty($paymentDetails)){
                    $user_dt = new DateTime($paymentDetails->payment_date);
                    $user_converted_at = $user_dt->format('Y-m-d');
                    $dt = strtotime($user_converted_at);
                    $extendedDate = date("Y-m-d", strtotime("+15 month", $dt));
                    $convertExtendedDate =strtotime($extendedDate);
                    $month1=date("F",$convertExtendedDate);
                    $year1 = date("Y", $convertExtendedDate);
                }
                if(date("YF", strtotime($month.'-'.$year)) <= date("YF", strtotime($month1.'-'.$year1)))
                {
                    $userwallet = DB::table('user_wallets')->where('user_id', $user->id)->where('date_from',$start_date)->where('date_to', $end_date)->where('settlement_id', $settlement->id)->first();
                    $total = $salary + $reward;
                    if($total > 0)
                    {
                        if(empty($userwallet))
                        {
                            $userwallet = new UserWallet();
                            $userwallet->settlement_id = $settlement->id;
                            $userwallet->user_id = $user->id;
                            $userwallet->salary = $total;
                            $userwallet->balance = $adminwallet->remain;
                            $userwallet->extra = 0;
                            $userwallet->adminwallet = 0;
                            $userwallet->date_from = $start_date;
                            $userwallet->date_to =  $end_date;
                            $userwallet->reason = "Salary";
                            $userwallet->save();
                            if($userwallet)
                            {
                                $empSalary = $userwallet->salary;
                                $paidToAdmin = $userwallet->balance;
                                $usergiven = $adminwallet->usergiven;
                                if($paidToAdmin > 0)
                                {
                                    if($empSalary < $paidToAdmin)
                                    {
                                        $totalDue = $userwallet->balance;
                                        $remain = $paidToAdmin - $empSalary;
                                        $giveToAdmin = $usergiven + $empSalary;
                                        $totalAvailable = $totalDue - ($empSalary + $remain);
                                        $row = DB::table('admin_payments')->where('user_id', $user->id)->update(['usergiven' => $giveToAdmin, 'remain' => $remain]);
                                        $row1 = DB::table('user_wallets')->where('user_id', $user->id)->where('date_from',$start_date)->where('date_to', $end_date)->where('settlement_id', $settlement->id)->update(['extra' => $totalAvailable, 'balance' => $remain, 'adminwallet' => $empSalary]);
        
                                    }
                                    else{
                                        $extra = $empSalary - $paidToAdmin;
                                        $balance = $empSalary - ($paidToAdmin + $extra);
                                        $row2 = DB::table('admin_payments')->where('user_id', $user->id)->update(['usergiven' => 7500, 'remain' => $balance]);
                                        $row3 = DB::table('user_wallets')->where('user_id', $user->id)->where('date_from',$start_date)->where('date_to', $end_date)->where('settlement_id', $settlement->id)->update(['extra' => $extra, 'balance' => $balance, 'adminwallet' => $paidToAdmin]);
                                    }
                                }
                                elseif($userwallet->balance == 0){
                                    $row4 = DB::table('user_wallets')->where('user_id', $user->id)->where('date_from',$start_date)->where('date_to', $end_date)->where('settlement_id', $settlement->id)->update(['extra' => $empSalary, 'balance' => $userwallet->balance, 'adminwallet' => $userwallet->balance]);
                                }
                                $transaction = DB::table('user_wallets')->where('user_id', $user->id)->where('date_from',$start_date)->where('date_to', $end_date)->where('settlement_id', $settlement->id)->first();
                                // dd($transaction);
                                $adminWallet = DB::table('admin_payments')->where('user_id', $user->id)->where('usergiven', 7500)->first();
                                if(!empty($paymentDetails))
                                {
                                    if(!empty($adminWallet))
                                    {
                                        if($transaction->extra > 0)
                                        {
                                            $payment = new PaymentSettlement();
                                            $payment->settlement_id = $settlement->id;
                                            $payment->user_id = $transaction->user_id;
                                            $payment->total = $transaction->extra;
                                            $payment->from_date = $start_date;
                                            $payment->to_date = $end_date;
                                            $payment->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return response()->json(['success' => 'Settlement is Generated!']);
        }
        else{
            return response()->json(['error' => 'Settlement is already Generated!']);
        }
    }

    public function adminWallet()
    {
        $users = DB::table('admin_payments')->where('usergiven', '>', 0)
        ->join('users', 'users.id', '=', 'admin_payments.user_id')
        ->select('admin_payments.*', 'users.fullname', 'users.referral_code')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($users)
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.wallet');
    }

    public function viewIncomeSettlement($id){
        $settlement = Settlement::findorfail($id);
        $paymentSettlement = PaymentSettlement::where('settlement_id', $id)->where('settled_status', 0)->get();
        if(request()->ajax())
        {
            return datatables()->of($paymentSettlement)
            ->addColumn('name', function($row){
                $user = User::where('id', $row->user_id)->first();
                if(!empty($user)){
                    return $user->fullname;
                }
            })
            ->addColumn('action', function($row){
                return '<button type="button" id="status" data-id="'.$row->id.'" class="btn bg-green waves-effect">Clear Due</button>';
            })
            ->rawColumns(['name', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.payment-settlement.view-income', compact('settlement'));
    }

    public function viewPaidIncomeSettlement($id){
        $settlement = Settlement::findorfail($id);
        $paymentSettlement = PaymentSettlement::where('settlement_id', $id)->where('settled_status', 1)->get();
        if(request()->ajax())
        {
            return datatables()->of($paymentSettlement)
            ->addColumn('name', function($row){
                $user = User::where('id', $row->user_id)->first();
                if(!empty($user)){
                    return $user->fullname;
                }
            })
            ->addColumn('action', function($row){
                return '<button type="button" id="status" data-id="'.$row->id.'" class="btn bg-red waves-effect">Revert Due</button>';
            })
            ->rawColumns(['name', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
    }

    public function viewSalarySettlement($id)
    {
        $settlement = Settlement::findorfail($id);
        $paymentSettlement = PaymentSettlement::where('settlement_id', $id)->where('settled_status', 0)->get();
        if(request()->ajax())
        {
            return datatables()->of($paymentSettlement)
            ->addColumn('name', function($row){
                $user = User::where('id', $row->user_id)->first();
                if(!empty($user)){
                    return $user->fullname;
                }
            })
            ->addColumn('action', function($row){
                return '<button type="button" id="status" data-id="'.$row->id.'" class="btn bg-green waves-effect">Clear Due</button>';
            })
            ->rawColumns(['name', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.payment-settlement.view-salary', compact('settlement'));
    }

    public function viewPaidSalarySettlement($id){
        $settlement = Settlement::findorfail($id);
        $paymentSettlement = PaymentSettlement::where('settlement_id', $id)->where('settled_status', 1)->get();
        if(request()->ajax())
        {
            return datatables()->of($paymentSettlement)
            ->addColumn('name', function($row){
                $user = User::where('id', $row->user_id)->first();
                if(!empty($user)){
                    return $user->fullname;
                }
            })
            ->addColumn('action', function($row){
                return '<button type="button" id="status" data-id="'.$row->id.'" class="btn bg-red waves-effect">Revert Due</button>';
            })
            ->rawColumns(['name', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
    }

    public function settlementStatus(Request $request)
    {
        $due_id = $request->id;
        $paymentSettlement = PaymentSettlement::where('id', $due_id)->first();
        if($paymentSettlement->settled_status == 0)
        {
            DB::table('payment_settlements')->where('id',$due_id)->update(['settled_status' => 1, 'settled_date' => date('Y-m-d')]);
            return response()->json(['success' => 'Due Settled Successfully!']);
        }
        else{
            DB::table('payment_settlements')->where('id',$due_id)->update(['settled_status' => 0, 'settled_date' => date('Y-m-d')]);
            return response()->json(['success' => 'Due Reverted Successfully!']);
        }
    }
}
