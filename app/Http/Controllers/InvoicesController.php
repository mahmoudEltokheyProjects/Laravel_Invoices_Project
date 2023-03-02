<?php
namespace App\Http\Controllers;
use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use App\Models\User;
use App\Models\Sections;
use App\Models\Products;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

use Maatwebsite\Excel\Facades\Excel;

use App\Exports\InvoicesExport;
use App\Notifications\Add_Invoice_Notification;

class InvoicesController extends Controller
{
    // ++++++++++++++++++++++++++++ Go To "invoices" Page +++++++++++++++++
    // ++++++++++ When Click on "قائمة الفواتير" link in sidebar Then Go To "invoices" Page ++++++++++
    public function index()
    {
        // 1- Get "All data" From "invoices table" and store them in "$allInvoices"
        $allInvoices = invoices::all();
        return view('invoices.invoices',compact('allInvoices'));
    }
    // ++++++++++++++++++++++++++++ Go To "add_invoice" Page +++++++++++++++++
    // ++++++++++ When Click on "اضافة فاتورة" button Then Go To "add_invoice" Page ++++++++++
    public function create()
    {
        // Get "all sections" data
        $allSections = Sections::all();
        // Get "all products" data
        $allProducts = Products::all();
        return view('invoices.add_invoice',compact('allSections','allProducts'));
    }
    // "Ajax request" : To "Get" Products Related to "Section" You select from "add_invoices" page
    // Get Products According to Section you selected from sections selectbox
    public  function getProducts($id)
    {
        /*
            Get "product_name" and "id" from "products table" where "section_id column in products table"
            equal "$id" of "sections selectbox"
        */
        $products = DB::table("products")->where("section_id",$id)->pluck('product_name','id');
        // return $products in "json format"
        return json_encode($products);
    }
    // +++++++++++ Insert "invoice data" in "invoices table" +++++++++++
    public function store(Request $request)
    {
        // 1- Store "invoice data" in "invoices table"
        invoices::create([
            'invoice_number'    => $request->invoice_number    ,
            'invoice_date'      => $request->invoice_Date      ,
            'due_date'          => $request->Due_date          ,
            'product'           => $request->product           ,
            'section_id'        => $request->Section           ,
            'amount_collection' => $request->Amount_collection ,
            'amount_commission' => $request->Amount_Commission ,
            'discount'          => $request->Discount          ,
            'value_vat'         => $request->Value_VAT         ,
            'rate_vat'          => $request->Rate_VAT          ,
            'total'             => $request->Total             ,
            'status'            => 'غير مدفوعة'               ,
            'value_status'      => 2                           ,
            'note'              => $request->note              ,
        ]);
        // 2- Store "invoice data" in "invoices_details table"
        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice'       => $invoice_id,
            'invoice_number'    => $request->invoice_number ,
            'product'           => $request->product        ,
            'Section'           => $request->Section        ,
            'Status'            => 'غير مدفوعة'            ,
            'Value_Status'      => 2                        ,
            'note'              => $request->note           ,
            // "username" of the "login" user [ from session]
            'user'              => (Auth::user()->name)
        ]);
        // 3- Store "invoice data And Attachments" in "invoice_attachment table"
        if ($request->hasFile('pic'))
        {
            $invoice_id = invoices::latest()->first()->id;
            // Get "Uploaded File" from "Form Request"
            $image = $request->file('pic');
            // Get "Uploaded File" name
            $file_name = $image->getClientOriginalName();
            // Get "invoice_number" from "Form Request"
            $invoice_number = $request->invoice_number;
            // Make "object" from "invoice_attachments" Model
            $attachments = new invoice_attachments();
            // Put $file_name as value for "file_name" column in "invoice_attachments" Table
            $attachments->file_name = $file_name;
            // Put $invoice_number as value for "invoice_number" column in "invoice_attachments" Table
            $attachments->invoice_number = $invoice_number;
            // Get "username" of "login user" as value for "created_by" column in "invoice_attachments" Table
            $attachments->created_by = Auth::user()->name;
            // Put $invoice_id as value for "invoice_id" column in "invoice_attachments" Table
            $attachments->invoice_id = $invoice_id;
            // Save All data in "invoice_attachments" Table
            $attachments->save();
            /*  move pic : Save "attachment File [ png , pdf , .. File ] in "invoice_attachments" table in database
                but save "The uploaded File itself" on the server
            */
            // 1- Get "uploaded File" name And Store it in $imageName variable
            $imageName = $request->pic->getClientOriginalName();
            // 2- Move "uploaded File" To "public/Attachments/$invoice_number.$imageName"
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }
        // +++++++++++ To Send "Email Notification" To "User" [ Get "login user info" ] +++++++++++
        // $user = User::first();
        // $user->notify(new AddInvoice( $invoice_id) );
        // Notification::send($user,new AddInvoice($invoice_id) );
        // +++++++++++ To Send "Database Notification" To "owner"  +++++++++++
        // 1- Get "owner User" Except "login user that create invoice"
        $owner = User::where('roles_name','=','["owner"]')->get();
        // 1- Get "login user that create invoice"
        $userCreateInvoice = User::where('id',auth()->user()->id)->get();
        // 2- Get "id of Latest Added invoice"
        $latest_invoice_id = invoices::latest()->first()->id;
        // 3- Go to "Notifications/Add_Invoice_Notification" and Take "$latest_invoice"
        Notification::send($owner,new Add_Invoice_Notification($latest_invoice_id,$userCreateInvoice));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }
    // Change "invoice status" method
    public function show($id)
    {
        // Get "invoice" data From DB
        $invoiceData = invoices::where('id', $id)->first();
        // Go To "invoices/status_update.blade.php" page and Take "invoiceData" to it
        return view('invoices.status_update',compact('invoiceData'));
    }
    // ++++++++++++++++++++++++ Edit invoice ++++++++++++++++++++++++
    public function edit($id)
    {
        // Get one row of "invoice data" from "invoices table" in DB Where [ invoice_id in DB = invoice_id in URL ]
        $invoice_data = invoices::where('id', $id)->first();
        // Get "All sections" To appear them in "selectBox of section"
        $allSections = Sections::all();
        // Go To "invoices/edit_invoice page" and Take 'invoice_data','allSections' to it
        return view("invoices.edit_invoice",compact('invoice_data','allSections')) ;
    }
    // ++++++++++++++++++++++++ Update invoice ++++++++++++++++++++++++
    public function update(Request $request)
    {
        /*
            Get "invoice_data" from "invoices table" in DB
            Where "invoice_id in DB = invoice_id of hidden inputField of Form in invoices.blade.php Page"
        */
        $invoice = invoices::findOrFail($request->invoice_id);
        // Update "invoice_data" in DB
        $invoice->update([
            'invoice_date'      => $request->invoice_Date      ,
            'due_date'          => $request->Due_date          ,
            'product'           => $request->product           ,
            'section_id'        => $request->Section           ,
            'amount_collection' => $request->Amount_collection ,
            'amount_commission' => $request->Amount_Commission ,
            'discount'          => $request->Discount          ,
            'rate_vat'          => $request->Rate_VAT          ,
            'value_vat'         => $request->Value_VAT         ,
            'total'             => $request->Total             ,
            'note'              => $request->note
        ]);
        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return redirect('/invoices');
    }
    // ++++++++++++++++++++++ Delete invoice [ Force Delete ] ++++++++++++++++++++++
    public function destroy(Request $request)
    {
        // Get "invoice_id" of "deleted invoice" From "hidden inputField" of "delete form in modal"
        $id = $request->invoice_id;
        /*
            Get "data" of "deleted invoice" from "invoices table" in DB Where
            ["invoice_id" in invoices Table in DB]==["invoice_id" from "hidden inputField" of "delete form in modal"]
        */
        $invoice_data = invoices::where('id', $id)->first();
        // Get "All Attachments" of The "deleted invoice"
        $attachments = invoice_attachments::where('invoice_id',$id)->first();
        // Check if "attachments" has "invoice_number" Then "force delete" all "attachment files"
        if( !empty($attachments->invoice_number) )
        {
            // Delete "invoice attachments" Folder From "public/Attachments" folder
            Storage::disk('public_uploads')->deleteDirectory($attachments->invoice_number);
        }
        // Delete "invoice data" From "invoices table in DB" and "Html invoices Table"
        $invoice_data->forceDelete();
        // make "session" called "delete_invoice" with Message = "تم الحذف بنجاح"
        session()->flash("delete_invoice","تم حذف الفاتورة بنجاح");
        return redirect('/invoices');
    }
    // ++++++++++++++++++++++ Archive invoice [ SoftDelete ] ++++++++++++++++++++++
    public function archiveInvoice(Request $request)
    {
        // Get "invoice_id" of "deleted invoice" From "hidden inputField" of "delete form in modal"
        $id = $request->invoice_id;
        /*
            Get "data" of "deleted invoice" from "invoices table" in DB Where
            ["invoice_id" in invoices Table in DB]==["invoice_id" from "hidden inputField" of "delete form in modal"]
        */
        $invoice_data = invoices::where('id', $id)->first();
        // Get "All Attachments" of The "deleted invoice"
        $attachments = invoice_attachments::where('invoice_id',$id)->first();
        // ############ Soft Delete invoice [ Archive invoice ] [ When Click "delete" link ] ############
        // When "user" click on "نقل الي الارشيف" link
        $invoice_data->delete();
        session()->flash('archive_invoice','تم أرشفة الفاتورة بنجاح');
        return redirect('/Archive');
    }
    // ++++++++++++++ "Update Paying Status" of invoice ++++++++++++++
    public function Status_Update($id , Request $request)
    {
        // Get "invoice data"
        $invoices = invoices::findOrFail($id);
        // ++++++++++++++++ "لو الفاتورة "مدفوعة ++++++++++++++++
        if ($request->Status === 'مدفوعة')
        {
            $invoices->update([
                'value_status'  => 1                          ,
                'status'        => $request->Status           ,
                'payment_date'  => $request->Payment_Date
            ]);
            // create a new row data of "updated information" of "invoice"
            invoices_details::create([
                'id_Invoice'     => $request->invoice_id      ,
                'invoice_number' => $request->invoice_number  ,
                'product'        => $request->product         ,
                'Section'        => $request->Section         ,
                'Status'         => $request->Status          ,
                'Value_Status'   => 1                         ,
                'note'           => $request->note            ,
                'Payment_Date'   => $request->Payment_Date    ,
                'user'           => (Auth::user()->name)
            ]);
        }
        // ++++++++++++++++ "لو الفاتورة "مدفوعة حزئياً ++++++++++++++++
        else
        {
            $invoices->update([
                'value_status' => 3 ,
                'status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');
    }
    // +++++++++++++++++++++++ "Paid Invoices" Page +++++++++++++++++++++++
    public function Invoice_Paid()
    {
        // Get "All data" of "All paid invoices" where 'Value_Status' == 1
        $invoices = invoices::where('value_status', 1)->get();
        return view('invoices.invoices_paid',compact('invoices'));
    }
    // +++++++++++++++++++++++ "Unpaid Invoices" Page +++++++++++++++++++++++
    public function Invoice_Unpaid()
    {
        // Get "All data" of "All Unpaid invoices" where 'Value_Status' == 2
        $unpaidInvoice = invoices::where('value_status',2)->get();
        return view('invoices.invoices_unpaid',compact('unpaidInvoice'));
    }
    // +++++++++++++++++++++++ "Partial Paid Invoices" Page +++++++++++++++++++++++
    public function Invoice_Partial_Paid()
    {
        // Get "All data" of "All partial paid invoices" where 'Value_Status' == 2
        $partialPaidInvoice = invoices::where('value_status',3)->get();
        return view('invoices.invoices_partial_paid',compact('partialPaidInvoice'));
    }
    // +++++++++++++++++++++++ "Print invoice" Page +++++++++++++++++++++++
    public function Print_invoice($id)
    {
        // Get "Printed invoice" data from DB where 'id in DB' == $id from invoices.blade page
        $invoices = Invoices::where('id',$id)->first();
        // Go to "invoices/Print_invoice.blade.php" page And Take '$invoices' variable To This Page
        return view('invoices.Print_invoice',compact('invoices'));
    }
    // +++++++++++++++++++++++ "Export invoice Excel" Page +++++++++++++++++++++++
    public function export()
    {
        // return "Export Excel";
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }
    // +++++++++++++++++++++++++++++++ Mark All Notification As Read +++++++++++++++++++++++++++++++
    public function MarkAsRead_all (Request $request)
    {
        $userUnreadNotification= auth()->user()->unreadNotifications;
        if($userUnreadNotification)
        {
            $userUnreadNotification->markAsRead();
        }
        return back();
    }
}
