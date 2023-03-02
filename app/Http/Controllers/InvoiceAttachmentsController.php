<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachmentsController extends Controller
{
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
    // +++++++++++++++++ Store "invoices Attachments" +++++++++++++++++
    public function store(Request $request)
    {
        // +++++++++++++ 1- Validate on "invoices Attachments" File Type +++++++++++++
        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',

            ], 
            [
                'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
            ]
        );
        // ++++++++ 2- Store "Upload Attachment" on "invoice_attachments" table on "DB" ++++++++
        // 2.1- Get "Upload Attachment" tmp file
        $image = $request->file('file_name');
        // 2.2- Get "Upload Attachment" original File Name
        $file_name = $image->getClientOriginalName();
        // 3- create object called "attachments" from "invoice_attachments" model
        $attachments =  new invoice_attachments();
        // 4- "file_name" column in "invoice_attachments" table = "file_name" inputField value of the Form
        $attachments->file_name = $file_name;
        // 5- "invoice_number" column in "invoice_attachments" table = "invoice_number" inputField value of the Form
        $attachments->invoice_number = $request->invoice_number;
        // 6- "invoice_number" column in "invoice_attachments" table = "invoice_id" inputField value of the Form
        $attachments->invoice_id = $request->invoice_id;
        // 7- "created_by" column in "invoice_attachments" table = "username" of the session of "login user"
        $attachments->created_by = Auth::user()->name;
        // 8- Save Data in "invoice_attachments" table
        $attachments->save();
        // ++++++++ 3- Store "Upload Attachment" on "Disk" on "public/Attachments/" ++++++++
        $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/'. $request->invoice_number), $imageName);
        // make session called "Add" and store message 'تم اضافة المرفق بنجاح'
        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoice_attachments $invoice_attachments)
    {
        //
    }
}
