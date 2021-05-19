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

class DistributorController extends Controller
{
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
            $message = "Hello+".urlencode($request->fullname)."%0aWelcome+to+Market+Drushti+"."%0aYour+Distributer+account+credentials+are+as+follows:%0aUsername:-+".$username."%0aPassword:-+".$password."%0aYou+can+login+to+your+distributer+account+here%0ahttp://shop.marketdrushti.com/login/";
            // dd($message);
                        
            $number = $request->mobile;
    
            // $this->sendSms($message,$number);    
    
    
            return redirect('admin/distributor')->with([
                'user' => $user,
                'kycdetails' => $kycdetails,
                'bankdetails' => $bankdetails,
                'usersInfo' => $usersInfo,
            ])->with('success','Joiner Added Successfully!');
                
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
        $user = User::findorfail($id);
        return view('admin.distributor.show', compact('user'));
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
        //
    }

    public function companyTree()
    {
        $users = User::where('parent_id', '=', 0)->get();
        $allMenus = User::pluck('fullname', 'referral_code','id', 'index')->all();
        return view('admin.company-tree.index', compact('users', 'allMenus'));
    }
}
