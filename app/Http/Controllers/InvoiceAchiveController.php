<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;

class InvoiceAchiveController extends Controller
{
    // Show "Archive Invoices"
    public function index()
    {
        // Get "All SoftDeleted invoices" Where there "deleted_at column" !== null From "invoices table" in DB
        $archived_invoices = invoices::onlyTrashed()->get();
        // Go To "Invoices/Archive_Invoices.blade.php" and Take "invoices variable" with You
        return view('Invoices.Archive_Invoices',compact('archived_invoices'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    // Restore "Archive invoice" [ Move "invoice" From "Archiving" To "invoices table" ]
    public function update(Request $request)
    {
        $id = $request->invoice_id;
        // put 'NULL" value in "deleted_at column" in "invoices table" in DB To restore "Archived invoice"
        $flight = invoices::withTrashed()->where('id', $id)->restore();
        session()->flash('restore_invoice');
        return redirect('/invoices');
    }
    // Delete "Archiving invoices"
    public function destroy(Request $request)
    {
        // Get "archiving_invoice" [ which has "deleted_at column" is "not nulll" ]
        $invoices = invoices::withTrashed()->where('id',$request->invoice_id)->first();
        // ForceDelete "archiving_invoice" from "invoices table" in DB
        $invoices->forceDelete();
        // make session called "delete_invoice"
        session()->flash('delete_invoice');
        // Go to "Archive" page
        return redirect('/Archive');
    }
}



