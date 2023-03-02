<?php

namespace App\Http\Controllers;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\Sections;
use App\Http\Requests\productsValidation;

class ProductsController extends Controller
{
    public function index()
    {
        // Get "all sections" data
        $allSections = Sections::all();
        // Get "all products" data
        $allProducts = Products::all();
        // Redirect To "products page" And Send "all products" and "all sections" to "products Page"
        return view('products.products',compact('allSections','allProducts'));
    }
    public function create()
    { }
    // +++++++++++++++++++++++++++++ Insert New Products +++++++++++++++++++++++++++++
    public function store(ProductsValidation $request)
    {
        // Get "section id" from "sections table" where "id in section table" == "section_id in products Form"
        $secId = Sections::all()->where('id','=',$request->section_id)->first()->id;
        // Get "section name" from "sections table" where "id in section table" == "section_id in products Form"
        $sectionName = Sections::all()->where('id','=',$request->section_id)->first()->section_name;
        // insert "product data" in "products table"
        products::create([
            'product_name' => $request->product_name ,
            'section_name' => $sectionName ,
            'description'  => $request->description  ,
            'section_id'   => $secId
        ]);
        // Make "Session" called "Add" and Store "Message" on it "تم إضافة المنتج بنجاح"
        session()->flash('Add','تم إضافة المنتج بنجاح');
        // Go To "products page"
        return redirect('/products');
    }
    public function show(Products $products)
    {
        //
    }
    public function edit(Products $products)
    { }
    // +++++++++++++++++++++++++ "Update Product" function +++++++++++++++++++++++++
    public function update(Request $request)
    {
        // Get "section id" from "sections table" where "id in section table" == "section_id in products Form"
        $sec_id = Sections::all()->where('section_name','=',$request->section_name)->first()->id;
        // Get "product_id" From The "product_id hidden inputField"
        $productId = $request->product_id;
        // Get The "product row data" of "product_id" in "products Table" in DB
        $products = Products::find($productId);
        // Update "product data" with "new data of modal"
        $products->update([
            'product_name' => $request->product_name ,
            'description'  => $request->description  ,
            'section_id'   => $sec_id                ,
            'section_name' => $request->section_name
        ]);
        // Make "Session" Called "Edit" and Store Message "تم تعديل المنتج بنجاح"
        session()->flash('Edit','تم  تعديل المنتج بنجاح');
        // Redirect to "products page"
        return redirect('/products');
    }
    // ++++++++++++++++++++++++ Delete product ++++++++++++++++++++++++
    public function destroy(Request $request)
    {
        // Get The "product_id" From "delete Form"
        $productId = $request->product_id;
        // Search on "product id" in "products Table" in DB , If Exists Then Delete "product"
        Products::find($productId)->delete();
        // Make Session called "Delete" And Store Message "تم حذف المنتج ينجاح"
        session()->flash('Delete',"تم حذف المنتج ينجاح");
        // Go To "products Page"
        return redirect('/products');
    }
}
