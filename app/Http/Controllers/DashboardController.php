<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Returnează pagina „Panou personal”
        return view('dashboard');
    }
}
