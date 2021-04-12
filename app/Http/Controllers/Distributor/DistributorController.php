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
        ]);
        $id = mt_rand(10000000,99999999);
        $user_referral_info = $request->user_referral;
        $data = User::where('referral_code',$user_referral_info )->first();
        $users = User::where('parent_id', $data->id)->get();
        if(count($users) < 10){
        // output: 160001
        $user = User::create([
            'id' => $id,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'username' => "MKD".$id,
            'mobile' => $request->mobile_no,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'password_1' => $request->password,
            'referral_code' => "MKD".$id,
            'reg_date' => date("Y-m-d"),
        ]);
        // dd($user);
        $node = User::find($data->id);
        $node->appendNode($user);

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

            if($user->save()){
            $message = "Hello+".urlencode($request->fullname)."%0aWelcome+to+Marketdrushti+"."%0aYour+Distributer+account+credentials+are+as+follows:%0aUsername:-+".$username."%0aPassword:-+".$request->password."%0aYou+can+login+to+your+distributer+account+here%0ahttp://shop.marketdrushti.com/login/";
                        
            $number = $request->mobile;

            // $this->sendSms($message,$number);
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
