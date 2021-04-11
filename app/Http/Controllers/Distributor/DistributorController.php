<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\User;

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
        //
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
