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
        $users = User::where('parent_id', $data->id)->select('id')->get();
        // dd($users);
        if(count($users) < 11){
            $sponsorUser = User::where('referral_code', $request->sponsor_id)->first();
            if($sponsorUser->id == $data->id)
            {
                if($request->join_side == "L"){
                    $checkeUser = User::where('parent_id', $data->id)->where('index', 5)->first();
                    // dd($checkeUser->id == null);
                    if($checkeUser->id == null)
                    {
                        $joinSide = User::where('parent_id', $data->id)->where('id', '=', null)->where('index', 5)
                        ->update([
                            'id' => $id,
                            'fullname' => $request->fullname,
                            'email' => $request->email,
                            'username' => "MKP".$id,
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
                    $checkeUser = User::where('parent_id', $data->id)->where('index', 6)->first();
                    if($checkeUser->id == null)
                    {
                        $joinSide = User::where('parent_id', $data->id)->where('id', '=', null)->where('index', 6)
                        ->update([
                            'id' => $id,
                            'fullname' => $request->fullname,
                            'email' => $request->email,
                            'username' => "MKP".$id,
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
                            'fullname' => $request->fullname,
                            'email' => $request->email,
                            'username' => "MKP".$id,
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
                if($request->join_side == "R")
                {
                    $index = $sponsorUser->index + 1;
                    $checkeUser = User::where('parent_id', $data->id)->where('index', $index)->first();
                    if($checkeUser->id == null)
                    {
                        $joinSide = User::where('parent_id', $data->id)->where('id', '=', null)->where('index', $index)
                        ->update([
                            'id' => $id,
                            'fullname' => $request->fullname,
                            'email' => $request->email,
                            'username' => "MKP".$id,
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

            // if($bankdetails->save()){
            // $message = "Hello+".urlencode($request->fullname)."%0aWelcome+to+Marketdrushti+"."%0aYour+Distributer+account+credentials+are+as+follows:%0aUsername:-+".$username."%0aPassword:-+".$request->password."%0aYou+can+login+to+your+distributer+account+here%0ahttp://shop.marketdrushti.com/login/";
                        
            // $number = $request->mobile;

            // $this->sendSms($message,$number);
            // dd($this->sendSms($message,$number));
            return redirect('/distributor/joiners')->with([
                'user' => $user,
                'kycdetails' => $kycdetails,
                'bankdetails' => $bankdetails,
                'usersInfo' => $usersInfo,
            ])->with('success', 'Joiner Added Successfully!');
            // }  
        }
        else{
            
            return Redirect::back()->with('danger', 'You cannot add more than 10 joiners.');
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
        $users = User::where('parent_id', '=', Auth::user()->id)->get();
        $allMenus = User::pluck('fullname', 'referral_code','id', 'index')->all();
        
        return view('distributor.treeview.index',compact('users','allMenus'));
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
}
