<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sections;
use App\Models\invoices;
class Customers_Report extends Controller
{
    // +++++++++++++++++ Show "customers report" +++++++++++++++++++
    public function index()
    {
        $sections = sections::all();
        return view('reports.customers_report',compact('sections'));
    }
    // +++++++++++++++++ search "customers report" +++++++++++++++++++
    public function Search_customers(Request $request)
    {
        // في حالة البحث بدون التاريخ
        if ($request->Section && $request->product && $request->start_at =='' && $request->end_at=='')
        {
            $invoices = invoices::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = Sections::all();
            return view('reports.customers_report',compact('sections'))->withDetails($invoices);
        }
        // في حالة البحث بتاريخ
        else
        {
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $invoices = invoices::whereBetween('invoice_date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = Sections::all();
            return view('reports.customers_report',compact('sections'))->withDetails($invoices);
        }
    }
}
