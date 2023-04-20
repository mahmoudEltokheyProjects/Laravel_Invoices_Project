@extends('layouts.master')
@section('title')
    الاقسام
@stop
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">الاعدادات</h4>
                    <span class="text-muted mt-1 tx-13 mr-2 mb-0"> / الاقسام</span>
                </div>
            </div>
        </div>
        <!-- breadcrumb -->
@endsection
@section('content')
            <!-- +++++++++++++ Center Content of The Page +++++++++++++ -->
            <!-- ############## Start row ############## -->
            <div class="row row-sm">
                <div class="col-xl-12">
                    <!-- "Add Section Faild" : Faild Message -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ( $errors->all() as $error )
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- "Add Section Successfully" : Success Message -->
                    @if( session()->has('Add') )
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('Add') }}</strong>
                            <button type="button" class="close pull-left" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <!-- "Edit Section Message" -->
                    @if( session()->has('Edit') )
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('Edit') }}</strong>
                            <button type="button" class="close pull-left" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <!-- "Delete Section Message" -->
                    @if( session()->has('Delete') )
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('Delete') }}</strong>
                            <button type="button" class="close pull-left" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <!-- Bordered Table -->
                <div class="col-xl-12">
                    <div class="card mg-b-20">
                        @can('اضافة قسم')
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <a  class="modal-effect btn btn-primary" href="#modaldemo8"
                                        data-effect="effect-scale" data-toggle="modal">
                                    إضافة قسم
                                    </a>
                                </div>
                            </div>
                        @endcan
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">#</th>
                                            <th class="border-bottom-0">اسم القسم</th>
                                            <th class="border-bottom-0">الوصف</th>
                                            <th class="border-bottom-0">العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=0; ?>
                                    @foreach( $allSections as $sec)
                                    <?php $i++; ?>
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$sec->section_name}}</td>
                                            <td>{{$sec->description}}</td>
                                            <td>
                                                <!-- "Edit Section" button -->
                                                <a  href="#modalEdit" title="تعديل" class="modal-effect btn btn-sm btn-success"
                                                    data-effect="effect-scale"
                                                    data-section_id="{{ $sec->id }}"
                                                    data-section_name="{{ $sec->section_name }}"
                                                    data-description="{{ $sec->description }}"
                                                    data-toggle="modal"
                                                >
                                                    تعديل <i class="las la-pen"></i>
                                                </a>
                                                <!-- "Delete Section" button -->
                                                <a  href="#modalDelete" title="حذف" class="modal-effect btn btn-sm btn-danger"
                                                    data-section_id="{{ $sec->id }}"
                                                    data-section_name="{{ $sec->section_name }}"
                                                    data-toggle="modal" data-effect="effect-scale"
                                                >
                                                    حذف <i  class="las la-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/div-->
                <!-- ++++++++++++++++++++++++++++++++ Start "Add Section" Modal ++++++++++++++++++++++++++++++ -->
                <div class="modal" id="modaldemo8">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">اضافة قسم</h6>
                                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('sections.store') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">اسم القسم</label>
                                        <input type="text" class="form-control" id="section_name" name="section_name">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">ملاحظات</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">تاكيد</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ++++++++++++++++++++++++++++++++ End "Add Section" Modal ++++++++++++++++++++++++++++++ -->
                <!-- +++++++++++++++++++++++++++++ Start "Edit Section" Modal  +++++++++++++++++++++++++++++ -->
                <div class="modal" id="modalEdit">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLabel">تعديل القسم</h6>
                                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="sections/update" method="post" autocomplete="off">
                                {{ method_field('patch') }}
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="section_id" id="section_id" value="">
                                        <label for="section_name">اسم القسم</label>
                                        <input type="text" class="form-control" name="section_name" id="section_name" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">وصف القسم</label>
                                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">تاكيد</button>
                                    <button type="submit" class="btn btn-secondary" data-dismiss="modal" >إغلاق</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- +++++++++++++++++++++++++++++ End "Edit Section" Modal  +++++++++++++++++++++++++++++-->
                <!-- +++++++++++++++++++++++++++++ Start "Delete Section" Modal  +++++++++++++++++++++++++++++ -->
                <div class="modal" id="modalDelete">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLabel">حذف القسم</h6>
                                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="sections/delete" method="post" autocomplete="off">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <p>هل انت متاكد من عملية الحذف ؟</p>
                                    <input type="hidden" name="section_id" id="section_id" value="">
                                    <input type="text" class="form-control" name="section_name" id="section_name" readonly>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">تاكيد</button>
                                    <button type="submit" class="btn btn-secondary" data-dismiss="modal" >إغلاق</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- +++++++++++++++++++++++++++++ End "Delete Section" Modal  +++++++++++++++++++++++++++++-->

            </div>
            <!-- ############## End row ############## -->
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<!-- +++++++++++++++++ "Edit Section" js +++++++++++++++++ -->
<script>
    // Appear "Edit Section Data" in the "Edit Modal InputFields"
    $("#modalEdit").on('show.bs.modal', function(event){
        var button      = $(event.relatedTarget);
        // Get "sectionId" from "data-id" "custom attribute"
        var sectionId   = button.data('section_id');
        // Get "sectionName" from "data-section_name" "custom attribute"
        var sectionName = button.data('section_name');
        // Get "sectionDescription" from "data-section_d" "custom attribute"
        var sectionDesc = button.data('description');
        // Put "section data" in "Edit Modal InputFields"
        var modal       = $(this);
        // Put "section id" in "Edit Modal "id InputField"
        modal.find('.modal-body #section_id').val(sectionId);
        // Put "section name" in "Edit Modal" "section_name InputField"
        modal.find('.modal-body #section_name').val(sectionName);
        // Put "section description" in "Edit Modal" "description InputField"
        modal.find('.modal-body #description').val(sectionDesc);
    });
</script>
<!-- +++++++++++++++++ "Delete Section" js +++++++++++++++++ -->
<script>
    // Appear "Delete Section Data" in the "Delete Modal InputFields"
    $("#modalDelete").on('show.bs.modal', function(event){
        var button      = $(event.relatedTarget);
        // Get "sectionId" from "data-id" "custom attribute"
        var sectionId   = button.data('section_id');
        // Get "sectionName" from "data-section_name" "custom attribute"
        var sectionName = button.data('section_name');
        // Put "section data" in "Delete Modal InputFields"
        var modal       = $(this);
        // Put "section id" in "Edit Modal "id InputField"
        modal.find('.modal-body #section_id').val(sectionId);
        // Put "section name" in "Edit Modal" "section_name InputField"
        modal.find('.modal-body #section_name').val(sectionName);
    });
</script>
@endsection
