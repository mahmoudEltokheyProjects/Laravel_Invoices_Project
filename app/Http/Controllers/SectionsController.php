<?php
namespace App\Http\Controllers;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SectionsValidation;

class SectionsController extends Controller
{
    public function index()
    {
        $allSections = Sections::all();
    // Send "All sections Table data" ($allSections) To "views/sections/sections.blade.php" page
        return view('sections.sections',compact('allSections'));
    }
    public function create()
    {

    }
    public function store(SectionsValidation $request)
    {
        $validartedData = $request->validated();
        Sections::create([
            'section_name' => $request->section_name ,
            'description'  => $request->description  ,
            'created_by'   => Auth::user()->name

        ]);
        session()->flash('Add','تم إضافة القسم بنجاح');
        return redirect('/sections');
    }
    public function show(Sections $sections)
    {
        //
    }
    public function edit(Sections $sections)
    {
        //
    }
    // ++++++++++++++++++++++++ "Update Section" function ++++++++++++++++++++++++
    public function update(Request $request)
    {
        // Get "section_id" From The "Edit Section Form"
        $section_id = $request->section_id;
        // Get The "section row data" of "section_id" in "sections Table" in DB
        $sections = Sections::find($section_id);
        // Update "section" with "section_id"
        $sections->update([
            'section_name' => $request->section_name ,
            'description' => $request->description
        ]);
        // Make "Session" Called "Edit" and Store Message "تم تعديل القسم بنجاح"
        session()->flash('Edit','تم  تعديل القسم بنجاح');
        // Redirect to "sections page"
        return redirect('/sections');
    }
    // ++++++++++++++++++++++++ "Delete Section" function ++++++++++++++++++++++++
    public function destroy(Request $request)
    {
        // Get The "row data" of "section_id" in "sections Table" in DB
        $section_id = $request->section_id;
        // Search on "section id" in "sections Table" in DB , If Exists Then Delete "section"
        Sections::find($section_id)->delete();
        // Make Session called "Delete" And Store Message "تم حذف القسم ينجاح"
        session()->flash('Delete',"تم حذف القسم ينجاح");
        // Go To "sections Page"
        return redirect('/sections');
    }
}
