<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('login');
    }

    public function login(Request $request) {
        $details = $request->only('email', 'password');

        if(Auth::attempt($details)) {
            if(Auth::user()->role == 'admin') {
                return redirect(route('admin.dashboard'));
            } else {
                return redirect(route('customer.home'));
            }
        } else {
            return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
        }
    }
}
