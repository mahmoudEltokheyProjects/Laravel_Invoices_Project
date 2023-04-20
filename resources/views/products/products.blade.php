@extends('layouts.master')
@section('title')
    المنتجات
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0"> /المنتجات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
<!-- +++++++++++++ Center Content of The Page +++++++++++++ -->
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <!-- "Add product Faild" : Faild Message -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- "Add product Successfully" : Success Message -->
            @if (session()->has('Add'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session()->get('Add') }}</strong>
                    <button type="button" class="close pull-left" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <!-- "Edit product Successfully" : Success Message -->
            @if (session()->has('Edit'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session()->get('Edit') }}</strong>
                    <button type="button" class="close pull-left" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <!-- "Delete product Successfully" : Success Message -->
            @if (session()->has('Delete'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session()->get('Delete') }}</strong>
                    <button type="button" class="close pull-left" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

        </div>
        <!-- ++++++++++++++++++++++++++++ products Table ++++++++++++++++++++++++++++ -->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                @can('اضافة منتج')
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <a class="modal-effect btn btn-primary" href="#modaldemo8" data-effect="effect-scale"
                                data-toggle="modal">إضافة منتج</a>
                        </div>
                    </div>
                @endcan
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">اسم المنتج</th>
                                    <th class="border-bottom-0">اسم القسم</th>
                                    <th class="border-bottom-0">الوصف</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- "counter variable" for products numbering "# column in table" -->
                                <?php $i = 0; ?>
                                <!-- Show "All products" -->
                                @foreach ($allProducts as $product)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->section_name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>
                                            <!-- "Edit Product" button -->
                                            <a  href="#modalEdit" title="تعديل" class="modal-effect btn btn-sm btn-success"
                                                data-effect="effect-scale" data-toggle="modal"
                                                data-product_id="{{ $product->id }}"
                                                data-product_name="{{ $product->product_name }}" data-description="{{ $product->description }}"
                                                data-section_name="{{ $product->sectionsRelation->section_name }}"
                                                data-section_id="{{ $product->sectionsRelation->section_id }}" >
                                                تعديل <i class="las la-pen"></i>
                                            </a>
                                            <!-- "Delete Product" button -->
                                            <a  href="#modalDelete" title="حذف" class="modal-effect btn btn-sm btn-danger"
                                                data-effect="effect-scale" data-toggle="modal"
                                                data-product_id="{{ $product->id }}"
                                                data-product_name="{{ $product->product_name }}" >
                                                حذف <i class="las la-trash"></i>
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
        <!-- ++++++++++++++++++++++++++++++++ Start "Add Product" Modal ++++++++++++++++++++++++++++++ -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">اضافة منتج</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('products.store') }}" method="post">
                            @csrf
                            <!-- ++++++++++++++ "productName" inputField ++++++++++++++ -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم المنتج</label>
                                <input type="text" class="form-control" id="product_name" name="product_name">
                            </div>
                            <!-- ++++++++++++++ sections selectBox ++++++++++++++ -->
                            <div class="form-group">
                                <label class="my-1 mr-2" for="section_id">القسم</label>
                                <select name="section_id" id="section_id" class="form-control">
                                    <option value="" selected disabled> --حدد القسم-- </option>
                                    <!-- Show "All sections" -->
                                    @foreach ($allSections as $section)
                                        <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- ++++++++++++++ "product description" inputField ++++++++++++++ -->
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">ملاحظات</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <!-- ++++++++++++++ "Confirm or Cancel" buttons ++++++++++++++ -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">تاكيد</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ++++++++++++++++++++++++++++++++ End "Add Product" Modal ++++++++++++++++++++++++++++++ -->
        <!-- +++++++++++++++++++++++++++++ Start "Edit Product" Modal  +++++++++++++++++++++++++++++ -->
        <div class="modal" id="modalEdit">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">تعديل المنتج</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="products/update" method="post" autocomplete="off">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <!-- ++++++++++++++ product name ++++++++++++++ -->
                            <div class="form-group">
                                <input type="hidden" name="product_id" id="product_id" value="">
                                <label for="product_name">اسم المنتج</label>
                                <input type="text" class="form-control" name="product_name" id="product_name" value="">
                            </div>
                            <!-- ++++++++++++++ sections selectBox ++++++++++++++ -->
                            <div class="form-group">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                                <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
                                    @foreach ($allSections as $section)
                                        <option>{{$section->section_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- ++++++++++++++ product description ++++++++++++++ -->
                            <div class="form-group">
                                <label for="description">وصف المنتج</label>
                                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">تاكيد</button>
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
                        <h6 class="modal-title" id="exampleModalLabel">حذف المنتج</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="products/delete" method="post" autocomplete="off">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p>
                            <input type="hidden" name="product_id"    id="product_id" value="">
                            <input type="text"   class="form-control" name="product_name" id="product_name" readonly>
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
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
    <!-- ++++++++++++++++++++++++++++++++++ "Edit And Delete Product" js ++++++++++++++++++++++++++++++++++ -->
    <script>
        // Appear "Edit Product Data" in the "Edit Modal InputFields"
        $('#modalEdit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            // Get "productName" from "data-product_name" "custom attribute"
            var productName = button.data('product_name');
            // Get "sectionName" from "data-section_name" "custom attribute"
            var sectionName = button.data('section_name');
            // Get "productId" from "data-product_id" "custom attribute"
            var productId   = button.data('product_id');
            // Get "productDesc" from "data-product_id" "custom attribute"
            var productDesc = button.data('description');

            var modal = $(this)
            // Put "product name" in "Edit Modal" "product_name InputField"
            modal.find('.modal-body #product_name').val(productName);
            // Put "section name" in "Edit Modal" "section_name InputField"
            modal.find('.modal-body #section_name').val(sectionName);
            // Put "product description" in "Edit Modal" "description InputField"
            modal.find('.modal-body #description').val(productDesc);
            // Put "product id" in "Edit Modal "id InputField"
            modal.find('.modal-body #product_id').val(productId);
        });
        // +++++++++++++++++ "Delete Product" js +++++++++++++++++
        // Appear "Delete Product Data" in the "Delete Modal InputFields"
        $("#modalDelete").on('show.bs.modal', function(event){
            var button      = $(event.relatedTarget);
            // Get "productId" from "data-product_id" "custom attribute"
            var productId   = button.data('product_id');
            // Get "productName" from "data-product_name" "custom attribute"
            var productName = button.data('product_name');
            // Put "product data" in "Delete Modal InputFields"
            var modal       = $(this);
            // Put "product id" in "Edit Modal "id InputField"
            modal.find('.modal-body #product_id').val(productId);
            // Put "product name" in "Edit Modal" "product InputField"
            modal.find('.modal-body #product_name').val(productName);
        });
    </script>
@endsection
