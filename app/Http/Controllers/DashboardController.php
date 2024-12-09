<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {

        if (Auth::check() && Auth::user()->role === 'admin') {
            redirect()->intended(route('dashboard', absolute: false));
        }

        return redirect()->intended(route('verification.umkm', absolute: false)); 
    }
}
