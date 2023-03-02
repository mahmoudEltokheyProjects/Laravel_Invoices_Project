<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;


class InvoicesDetailsController extends Controller
{
    // ++++++++++++++++ Edit method ++++++++++++++++
    public function edit($invoiceId)
    {
        // Get "All invoices" whatever "Not Archived" or "Archived" invoice
        $invoiceInfo          = invoices::withTrashed()->where('id', $invoiceId)->first();
        $invoiceDetails       = invoices_details::get()->where('id_Invoice', $invoiceId);
        $invoiceAttachment    = invoice_attachments::get()->where('invoice_id', $invoiceId);
        return view('invoices.invoices_details',compact('invoiceInfo','invoiceDetails','invoiceAttachment'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }
    // Remove "attachment" from "invoices"
    public function destroy(Request $request)
    {
        // Get "attachment file"
        $invoice = invoice_attachments::findOrFail($request->id_file);
        // Delete "attachment file" From "DB"
        $invoice->delete();
        // Delete "attachment file" From "Disk" [ '/public/Attachments/']
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        // Make "session" called "delete" and Store Message "تم حذف المرفق بنجاح"
        session()->flash('delete','تم حذف المرفق بنجاح');
        // Go to "back" page
        return back();
    }

    // "view Attachment" methods
    public function open_file($invoice_number,$file_name)
    {
        return response()->file(public_path('Attachments/'.$invoice_number.'/'.$file_name));
    }
    // "download Attachment" methods
    public function download_file($invoice_number,$file_name)
    {
        return response()->download(public_path('Attachments/'.$invoice_number.'/'.$file_name));
    }
}
