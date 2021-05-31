<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Route;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class FranchiseLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:franchise')->except('logout');
    }

    public function showLoginForm()
    {
      return view('franchise.login');
    }
    
    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'username'   => 'required',
        'password' => 'required|min:6'
      ]);
      
      if (Auth::guard('franchise')->attempt(['username' => $request->username, 'password' => $request->password, 'status' => 1])) {
        // if successful, then redirect to their intended location
        
        return redirect()->intended(route('franchise.dashboard'));
      } 
      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->withInput($request->only('username', 'remember'))->with('danger', 'Your Account is not Activated.');
    }

    public function logout()
    {
        Auth::guard('franchise')->logout();
        return redirect('/franchise/login')->with('success', 'Successfully Logout!');
    }
}
