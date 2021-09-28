<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Admin\UserInfo;
use App\Models\Admin\UserBankDetail;
use App\Models\Admin\UserKycDetail;
use Illuminate\Support\Facades\Hash;
use DB;
use Redirect;
use App\Models\Franchise\ProductPayment;
use App\Models\User\UserIncome;
use App\Models\User\UserSalary;
use App\Models\User\Reward;
use App\Models\Admin\UserWallet;
use App\Models\Franchise\AdminPayment;

class DistributorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')->join('user_kyc_details', 'user_kyc_details.user_id', '=', 'users.id')
        ->join('user_bank_details', 'user_bank_details.user_id', '=', 'users.id')
        ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
        ->where('parent_id', '=', Auth::user()->id)
        ->select('users.*')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($users)
            ->addIndexColumn()
            ->make(true);
        }
        return view('distributor.joiners.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('distributor.joiners.create');
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
            'user_referral' => 'required',
            'fullname' => 'required',
            'mobile_no' => 'required|digits:10',
            'address' => 'required',
            'password' => 'required|min:8|confirmed',
            'join_side' => 'required',
            'sponsor_id' => 'required',
        ]);
        $id = mt_rand(10000000,99999999);
        $user_referral_info = $request->user_referral;
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
                    return redirect('/distributor/joiners')->with([
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
        $user = User::findorfail($id);
        $kycdetails = UserKycDetail::where('user_id', $id)->first();
        $bankdetails = UserBankDetail::where('user_id', $id)->first();
        $usersInfo = UserInfo::where('user_id', $id)->first();
        return view('distributor.joiners.edit', compact('user', 'kycdetails', 'bankdetails', 'usersInfo'));
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
        $user->referral_code = $request->referral_code;
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


        return Redirect::back()->with('success', 'Profile Updated Successfully!');
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

    public function treeview()
    {
        $users = User::where('sponsor_id', '=', Auth::user()->id)->get();
        $allMenus = User::pluck('fullname', 'referral_code','id', 'side')->all();
        
        return view('distributor.treeview.index',compact('users','allMenus'));
    }
    public function welcomeLetter()
    {
       return view('distributor.welcomeLetter');
    }
    
     public function identity()
    {
        $kycdetails = UserKycDetail::where('user_id', Auth::user()->id)->first();
        return view('distributor.identityCard', compact('kycdetails'));
    }
    

    public function kycDocument()
    {
        $users = User::findorfail(Auth::user()->id);
        $kycdetails = UserKycDetail::where('user_id', Auth::user()->id)->first();
        return view('distributor.kyc-document', compact('users', 'kycdetails'));
    }

    public function uploadKycDocument(Request $request)
    {
        // $user = User::find($request->input('id'));
        $user = User::findorfail(Auth::user()->id);
        // $kycdetails = Kycdetails::find($request->input('user_id'));
        $kycdetails = UserKycDetail::where('user_id', Auth::user()->id)->first();
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
   

        return redirect('/distributor/kyc-document')->with('success', 'KYC Document Uploaded.');
    }

    public function myIncome()
    {
        $id = Auth::user()->id;
        $this->getUserLevel($id);
        $userIncome = UserIncome::where('user_id', $id)->get()->sum('net_income');
        $userSalary = UserSalary::where('user_id', $id)->get()->sum('net_income');
        $reward = Reward::where('user_id', $id)->where('status', 'Qualified')->get()->sum('net_income');
        $total = $userIncome + $userSalary + $reward;
        return view('distributor.income.all', compact('userIncome', 'userSalary', 'reward', 'total'))->with($this->getUserLevel($id));
    }

    public function incomeDetails(Request $request)
    {
        if(request()->ajax())
        {
            $incomeDetails1 = UserIncome::where('user_id', Auth::user()->id);
            if(!empty($request->level)){
                $incomeDetails1 = $incomeDetails1->where('level', $request->level);
            }
            $incomeDetails = $incomeDetails1->orderBy('id', 'DESC')->get();
            return datatables()->of($incomeDetails)
            ->addColumn('referral_code', function($row){    
                $user = User::where('id', $row->child_id)->first();
                if(!empty($user))
                {
                    return $user->referral_code;
                }                                                                                                                                                                                                                                                                                              
            })
            ->addColumn('fullname', function($row){    
                $user = User::where('id', $row->child_id)->first();
                if(!empty($user))
                {
                    return $user->fullname;
                }                                                                                                                                                                                                                                                                                              
            })
            ->addColumn('payment_date', function($row){    
                return date('d-m-Y', strtotime($row->payment_date));                                                                                                                                                                                                                                                                                           
            })
            ->rawColumns(['referral_code', 'fullname', 'payment_date'])
            ->addIndexColumn()
            ->make(true);
        }
        $id = Auth::user()->id;
        $this->getUserLevel($id);
        return view('distributor.income.income-detail')->with($this->getUserLevel($id));
    }

    public function salaryDetails(Request $request)
    {     
        if(request()->ajax())
        {
            $salaryDetails1 = UserSalary::where('user_id', Auth::user()->id);
            if(!empty($request->level1)){
                $salaryDetails1 = $salaryDetails1->where('level', $request->level1);
            }
            $salaryDetails = $salaryDetails1->orderBy('id', 'DESC')->get();
            return datatables()->of($salaryDetails)
            ->addColumn('referral_code', function($row){    
                $user = User::where('id', $row->child_id)->first();
                if(!empty($user))
                {
                    return $user->referral_code;
                }                                                                                                                                                                                                                                                                                              
            })
            ->addColumn('fullname', function($row){    
                $user = User::where('id', $row->child_id)->first();
                if(!empty($user))
                {
                    return $user->fullname;
                }                                                                                                                                                                                                                                                                                              
            })
            ->addColumn('payment_date', function($row){    
                return date('d-m-Y', strtotime($row->payment_date));                                                                                                                                                                                                                                                                                           
            })
            ->rawColumns(['referral_code', 'fullname', 'payment_date'])
            ->addIndexColumn()
            ->make(true);
        }
        $id = Auth::user()->id;
        $this->getUserLevel($id);
        return view('distributor.income.salary-detail')->with($this->getUserLevel($id));
    }
    public function getUserLevel($id)
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
                foreach($user->user_childs as $child)
                {
                    if(!empty($child->id)){
                        $levelPayment1 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                        if(!empty($levelPayment1)){
                            $items1[] = $levelPayment1->payment_date;
                        }
                        foreach($child->user_childs as $child)
                        {
                            if(!empty($child->id)){
                                $levelPayment2 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                                if(!empty($levelPayment2)){
                                    $items2[] = $levelPayment2->payment_date;
                                }
                                foreach($child->user_childs as $child)
                                {
                                    if(!empty($child->id)){
                                        $levelPayment3 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                                        if(!empty($levelPayment3)){
                                            $items3[] = $levelPayment3->payment_date;
                                        }
                                        foreach($child->user_childs as $child)
                                        {
                                            if(!empty($child->id)){
                                                $levelPayment4 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                                                if(!empty($levelPayment4)){
                                                    $items4[] = $levelPayment4->payment_date;
                                                }
                                                foreach($child->user_childs as $child)
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

    public function rewardDetails(Request $request)
    {
        if(request()->ajax())
        {
            $rewardDetails1 = Reward::where('user_id', Auth::user()->id);
            if(!empty($request->level2)){
                $rewardDetails1 = $rewardDetails1->where('level', $request->level2);
            }
            $rewardDetails = $rewardDetails1->orderBy('id', 'DESC')->get();
            return datatables()->of($rewardDetails)
            ->addColumn('status', function($row){    
                if($row->status == "Qualified")
                {
                    return '<span class="badge bg-teal">Qualified</span>';
                }                                                         
                else{
                    return '<span class="badge bg-pink">Not Qualified</span>';
                }                                                                                                                                                                                                                                  
            })
            ->rawColumns(['status'])
            ->addIndexColumn()
            ->make(true);
        }
        $id = Auth::user()->id;
        $this->getUserLevel($id);
        return view('distributor.income.reward')->with($this->getUserLevel($id));
    }

    public function myWallet()
    {
        $userWallet = UserWallet::where('user_id', Auth::user()->id)->sum('salary');
        $amount = number_format($userWallet);
        $adminWallet = AdminPayment::where('user_id', Auth::user()->id)->first();
        $Month = DB::table('user_wallets')->join('settlements', 'settlements.id', '=', 'user_wallets.settlement_id')
        ->where('month_year', date('F Y'))->where('user_id', Auth::user()->id)->get()->sum('salary');
        $paymentSettlement = DB::table('user_wallets')->join('settlements', 'settlements.id', '=', 'user_wallets.settlement_id')
        ->where('user_id', Auth::user()->id)
        ->select('user_wallets.*', 'settlements.month_year', 'settlements.start_date', 'settlements.end_date')->get();
        if(request()->ajax())
        {
            return datatables()->of($paymentSettlement)
            ->addColumn('start_date', function($row){    
                return date('d-m-Y', strtotime($row->start_date));                                                                                                                                                                                                                       
            })
            ->addColumn('end_date', function($row){    
                return date('d-m-Y', strtotime($row->end_date));                                                                                                                                                                                                                       
            })
            ->addColumn('salary', function($row){    
                return number_format($row->salary);                                                                                                                                                                                                                       
            })
            ->addColumn('balance', function($row){    
                return number_format($row->balance);                                                                                                                                                                                                                       
            })
            ->addColumn('extra', function($row){    
                return number_format($row->extra);                                                                                                                                                                                                                       
            })
            ->addColumn('adminwallet', function($row){    
                return number_format($row->adminwallet);                                                                                                                                                                                                                       
            })
            ->rawColumns(['status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('distributor.wallet', compact('userWallet', 'adminWallet', 'amount', 'Month'));
    }

    public function paymentSettlement()
    {
        $paymentSettlement = DB::table('payment_settlements')->join('settlements', 'settlements.id', '=', 'payment_settlements.settlement_id')
        ->where('user_id', Auth::user()->id)
        ->select('payment_settlements.*', 'settlements.month_year', 'settlements.start_date', 'settlements.end_date')->get();
        if(request()->ajax())
        {
            return datatables()->of($paymentSettlement)
            ->addColumn('start_date', function($row){    
                return date('d-m-Y', strtotime($row->start_date));                                                                                                                                                                                                                       
            })
            ->addColumn('end_date', function($row){    
                return date('d-m-Y', strtotime($row->end_date));                                                                                                                                                                                                                       
            })
            ->addColumn('total', function($row){    
                return number_format($row->total);                                                                                                                                                                                                                       
            })
            ->addColumn('settled_status', function($row){    
                if($row->settled_status == 0)
                {
                    return '<span class="badge bg-pink">Not Settled</span>';
                }   
                else{
                    return '<span class="badge bg-teal">Settled</span>';
                }                                                                                                                                                                                                                   
            })
            ->addColumn('settled_date', function($row){    
                return date('d-m-Y', strtotime($row->settled_date));                                                                                                                                                                                        
            })
            ->rawColumns(['settled_status'])
            ->addIndexColumn()
            ->make(true);
        }
    }
    
    public function myBusiness()
    {
        $users = User::where('parent_id', Auth::user()->id)->get();
        $allMenus = User::pluck('fullname', 'referral_code','id', 'index')->all();
        // $currentJoiner = DB::table('users')->where('parent_id', Auth::user()->id)->join('product_payments', 'product_payments.user_id', '=');
        $id = Auth::user()->id;
        // dd($this->getUserLevel($id));
        return view('distributor.my-business', compact('users', 'allMenus'))->with($this->getUserLevel($id));
    }
}
