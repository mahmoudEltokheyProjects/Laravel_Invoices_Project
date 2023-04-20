<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\invoices;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ---------------------- Show "statistics" Charts ----------------------
    public function index()
    {
        return view('home');
    }
}
