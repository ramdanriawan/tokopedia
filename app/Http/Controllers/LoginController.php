<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        // Retrive Input
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if(auth()->user()->level == 'Unit Kerja') {
                if(!auth()->user()->unit_kerja) {
                    Auth::logout();
    
                    return redirect()->back()->with('error', 'Unit kerja belum dibuat');
                }

                if (auth()->user()->unit_kerja->status == 'Tidak Aktif') {
                    Auth::logout();
    
                    return redirect()->back()->with('error', 'Status akun kamu tidak aktif');
                }
            }
            
            if(auth()->user()->level == 'Rekrutmen') {
                if(!auth()->user()->rekrutmen) {
                    Auth::logout();
    
                    return redirect()->back()->with('error', 'Rekrutmen belum dibuat');
                }

                if (auth()->user()->rekrutmen->status == 'Tidak Aktif') {
                    Auth::logout();
    
                    return redirect()->back()->with('error', 'Status akun kamu tidak aktif');
                }

            }

            return redirect()->route('dashboard');
        }

        // if failed login
        return redirect('login');
    }
}
