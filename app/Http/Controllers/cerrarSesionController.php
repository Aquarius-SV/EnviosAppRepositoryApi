<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class cerrarSesionController extends Controller
{
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
