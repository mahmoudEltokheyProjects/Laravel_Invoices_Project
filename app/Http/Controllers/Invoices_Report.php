<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\invoices;

class Invoices_Report extends Controller
{
    // ++++++++++++++++++++++++++++ index() method ++++++++++++++++++++++++++++
    public function index()
    {
        // Go to "views/reports/invoices_report" page
        return view('reports.invoices_report');
    }
    // +++++++++++++++++++++++++ Search_invoices() method +++++++++++++++++++++++++
    public function Search_invoices(Request $request)
    {
        $rdio = $request->rdio;
        // 1- Click on "radio1" : في حالة البحث بنوع الفاتورة
        if ($rdio == 1)
        {
            // في حالة عدم تحديد تاريخ
            if ($request->type && $request->start_at =='' && $request->end_at =='')
            {
                $invoices = invoices::select('*')->where('Status','=',$request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report',compact('type'))->withDetails($invoices);
            }
            // في حالة تحديد تاريخ استحقاق
            else
            {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;
                $invoices = invoices::whereBetween('invoice_date',[$start_at,$end_at])->where('Status','=',$request->type)->get();
                return view('reports.invoices_report',compact('type','start_at','end_at'))->withDetails($invoices);
            }
        }
        // 2- Click on "radio2" : في البحث برقم الفاتورة
        else
        {
            $invoices = invoices::select('*')->where('invoice_number','=',$request->invoice_number)->get();
            return view('reports.invoices_report')->withDetails($invoices);
        }
    }
}
