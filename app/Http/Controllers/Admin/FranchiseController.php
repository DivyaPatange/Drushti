<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Franchise;
use App\Models\Admin\FranchiseBankdetails;
use App\Models\Admin\FranchiseKycdetails;
use App\Models\Admin\FranchiseShopdetails;
use Illuminate\Support\Facades\Hash;
use App\Models\Franchise\Order;

class FranchiseController extends Controller
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
        $franchises = DB::table('franchises')->join('franchise_kycdetails', 'franchise_kycdetails.franchise_id', '=', 'franchises.id')
        ->join('franchise_bankdetails', 'franchise_bankdetails.franchise_id', '=', 'franchises.id')
        ->select('franchises.*')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($franchises)
            ->addColumn('status', 'admin.franchise.status')
            ->addColumn('action', 'admin.franchise.action')
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.franchise.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.franchise.create');
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
            'email' => 'required',
            'mobile_no' => 'required',
            'registration_date' => 'required',
            'address' => 'required',
            'password' => 'required|min:8|confirmed',
            'shop_name' => 'required',
            'shop_id' => 'required',
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
        $franchise->reg_date = date("Y-m-d", strtotime($request->registration_date));
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
        $shopdetails->shop_registration_id = $request->shop_id;
        $shopdetails->save();
        if($franchise->save()){
            $message = "Hello+".urlencode($request->fullname)."%0aWelcome+to+Market+Career+Power+Pvt.+Ltd.+"."%0aYour+Distributor+account+credentials+are+as+follows:%0aUsername:-+".$username."%0aPassword:-+".$request->password."%0aYou+can+login+to+your+distributor+account+here%0ahttps://marketcareerpower.com/franchise/";
                        
            // dd($message);
            $number = $request->mobile_no;
    
            $this->sendSms($message,$number);
            // dd($this->sendSms($message,$number));
            return redirect('/admin/franchise')->with([
                'franchise' => $franchise,
                'kycdetails' => $kycdetails,
                'bankdetails' => $bankdetails,
                'shopdetails' => $shopdetails,
            ])->with('success', 'Franchise added successfully!');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $franchise = Franchise::findorfail($id);
        $kycdetails = FranchiseKycdetails::where('franchise_id', $id)->first();
        $bankdetails = FranchiseBankdetails::where('franchise_id', $id)->first();
        $shopdetails = FranchiseShopdetails::where('franchise_id', $id)->first();
        return view('admin.franchise.show', compact('franchise', 'kycdetails', 'bankdetails', 'shopdetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $franchise = Franchise::findorfail($id);
        $kycdetails = FranchiseKycdetails::where('franchise_id', $id)->first();
        $bankdetails = FranchiseBankdetails::where('franchise_id', $id)->first();
        $shopdetails = FranchiseShopdetails::where('franchise_id', $id)->first();
        return view('admin.franchise.edit', compact('franchise', 'bankdetails', 'kycdetails', 'shopdetails'));
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
        $franchise = Franchise::findorfail($id);
        
        $franchise->fullname = $request->fullname;
        $franchise->email = $request->email;
        $franchise->mobile = $request->mobile;
        $franchise->address = $request->address;
        $franchise->nominee_name = $request->nominee_name;
        $franchise->nominee_relation = $request->nominee_relation;
        $franchise->update($request->all());

        $kycdetails = FranchiseKycdetails::where('franchise_id', $id)->first();
        $kycdetails->pan_no = $request->pan_no;
        $kycdetails->aadhar_no = $request->aadhar_no;
        $kycdetails->update($request->all());

        $bankdetails = FranchiseBankdetails::where('franchise_id', $id)->first();
        $bankdetails->bank_name = $request->bank_name;
        $bankdetails->branch_name = $request->branch_name;
        $bankdetails->ifsc_code = $request->ifsc_code;
        $bankdetails->acc_no = $request->acc_no;
        $bankdetails->acc_holder_name = $request->acc_holder_name;
        $bankdetails->update($request->all());

        $shopdetails = FranchiseShopdetails::where('franchise_id', $id)->first();
        $shopdetails->shop_name = $request->shop_name;
        $shopdetails->shop_registration_id = $request->shop_id;
        $shopdetails->update($request->all());

        return redirect('/admin/franchise')->with('success', 'Franchise Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $franchise = Franchise::findorfail($id);
        $kycdetails = FranchiseKycdetails::where('franchise_id', $id)->first();
        $bankdetails = FranchiseBankdetails::where('franchise_id', $id)->first();
        $shopdetails = FranchiseShopdetails::where('franchise_id', $id)->first();
        $franchise->delete();
        if(!empty($kycdetails)){
            $kycdetails->delete();
        }
        if(!empty($bankdetails)){
            $bankdetails->delete();
        }
        if(!empty($shopdetails)){
            $shopdetails->delete();
        }
        return response()->json(['success' => 'Franchise Deleted Success']);
    }

    public function status(Request $request, $id)
    {
        $franchise = Franchise::findorfail($id);
        if($franchise->status == 1)
        {
            $franchise->status = 0;
        }
        else{
            $franchise->status = 1;
        }
        $franchise->update($request->all());
        return response()->json(['success' => 'Status Changed Successfully!']);
    }

    public function orders()
    {
        $orders = Order::all();
        if(request()->ajax())
        {
            return datatables()->of($orders)
            ->addColumn('franchise_name', function($row){
               $franchise = Franchise::where('id', $row->franchise_id)->first();
               if(!empty($franchise))
               {
                   return $franchise->fullname;
               }
            })
            ->addColumn('franchise_id', function($row){
                $franchise = Franchise::where('id', $row->franchise_id)->first();
                if(!empty($franchise))
                {
                    return $franchise->username;
                }
             })
            ->addColumn('status', function($row){
                if($row->status == 1)
                {
                    return '<span class="badge bg-teal">Approved</span>';
                }
                else{
                    return '<span class="badge bg-pink">Not Approved</span>';
                }
            })
            ->addColumn('action', function($row){
                if($row->status == 1)
                {
                    return '<button type="button" id="status" data-id="'.$row->id.'" class="btn btn-danger waves-effect">Not Approved</button>';
                }
                else{
                    return '<button type="button" id="status" data-id="'.$row->id.'" class="btn btn-success waves-effect">Approve</button>';
                }
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.orders.index');
    }

    public function orderStatus(Request $request, $id)
    {
        $order = Order::findorfail($id);
        if($order->status == 1)
        {
            $order->status = 0;
            $order->update($request->all());
            return response()->json(['success' => 'Order Rejected Successfully!']);
        }
        else{
            $order->status = 1;
            $order->update($request->all());
            return response()->json(['success' => 'Order Approved Successfully!']);
        }
    }

    public function franchiseKycVerification()
    {
        $franchise = DB::table('franchise_kycdetails')->join('franchises', 'franchises.id', '=', 'franchise_kycdetails.franchise_id')
                ->where('franchise_kycdetails.user_img', '!=', null)->where('franchise_kycdetails.pan', '!=', null)->where('franchise_kycdetails.cheque', '!=', null)
                ->select('franchise_kycdetails.*', 'franchises.fullname', 'franchises.mobile', 'franchises.username')->get();
        // dd($franchise);
        if(request()->ajax())
        {
            return datatables()->of($franchise)
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
        return view('admin.kyc-verification.franchise');
    }

    public function kycStatus(Request $request, $id)
    {
        $kycdetails = FranchiseKycdetails::findorfail($id);
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
}
