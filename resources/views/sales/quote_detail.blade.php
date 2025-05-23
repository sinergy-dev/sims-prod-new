@extends('template.main_sneat')
@section('tittle')
    Quotation Detail
@endsection
@section('pageName')
    Quotation Detail
@endsection
@section('head_css')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
    <link rel="preload" href="{{ url('assets/css/jquery.emailinput.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="{{ url('assets/css/bootstrap-timepicker.min.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="{{ url('assets/css/jquery.mentionsInput.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    {{--<link rel="preload" href="{{asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">--}}
{{--    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.min.css" integrity="sha512-Bhi4560umtRBUEJCTIJoNDS6ssVIls7oiYyT3PbhxZV+9uBbLVO/mWo56hrBNNbIfMXKvtIPJi/Jg+vpBpA7sg==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>--}}
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/typography.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/katex.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/editor.css')}}" />
    <style type="text/css">
        p > strong::before{
            content: "@";
        }

        input[type=file]::-webkit-file-upload-button {
            display: none;
        }

        input::file-selector-button {
            display: none;
        }

        .cbDraft:disabled,
        .cbDraft[disabled]{
            border-color: rgba(118, 118, 118, 0.3);
            background: #3c8dbc !important;
            color: #3c8dbc !important;
        }

        .icheckcard_minimal-blue:disabled{
            background: #3c8dbc !important;
        }
        .icheckcard_minimal-blue:disabled{
            background: #3c8dbc !important;
            border: 1px solid #d4d4d5;
        }

        .form-group{
            margin-bottom: 15px;
        }

        .swal2-container {
            z-index: 9999 !important;
        }

        .select2-container {
            z-index: 1055 !important; /* modal default: 1050 */
        }

        .select2-dropdown {
            z-index: 1060 !important;
        }

        .pull-right{
            float: right;
        }
    </style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <section class="content">
            <div class="row mb-4" id="showDetail">
            </div>
            <div class="row mb-4" id="changeLog">
                <div class="col-md-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h6>Change Log</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="width: 100%">
                                <table id="tbChangeLog" class="table table-striped table-bordered">

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="ModalRejectQuotation" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Quotation Reject</h6>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="" name="">
                        <div class="form-group">
                            <label>Reason</label>
                            <textarea class="form-control" style="resize: vertical;" onkeyup="fillInput('reason_reject')"  id="reasonReject" name="reasonReject"></textarea>
                            <span class="help-block" style="display:none;">Please fill Reason!</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" onclick="rejectQuotation()" class="btn btn-sm btn-danger">Reject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAdd" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content modal-md">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
                    <h6 class="modal-title">Add Quote</h6>
                </div>
                <form method="POST" action="" id="modalAddQuote" name="modalAddQuote">
                    <div class="modal-body">
                        @csrf
                        <div class="tab-add" style="display: none!important;">
                            <div class="tabGroup">
                                <div class="form-group">
                                    <label for="">Lead ID*</label>
                                    <input type="text" name="lead_id" id="leadId" class="form-control" required style="width: 100%" disabled>
                                    <span class="invalid-feedback" style="display:none!important;">Please fill Lead ID!</span>
                                </div>
                                @if(Auth::user()->roles()->first()->name == 'Account Executive')
                                    <div class="form-group">
                                        <label for="">Position</label>
                                        <select type="text" class="custom-form-control-select w-100" name="position" id="position" required>
                                            <option value="">--Choose Position--</option>
                                            <option value="TAM">TAM</option>
                                            <option value="DIR">DIR</option>
                                        </select>
                                        <span class="invalid-feedback" style="display:none!important;">Please fill Position!</span>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Customer</label>
                                    <input type="text" class="form-control" name="customer" id="customer" required disabled>
                                    <span class="invalid-feedback" style="display:none!important;">Please fill Customer!</span>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Telp*</label>
                                            <input type="text" name="no_telp" id="no_telp" class="form-control" required>
                                            <span class="invalid-feedback" style="display:none!important;">Please fill Telp!</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email*</label>
                                            <input type="text" name="email" id="email" class="form-control" placeholder="ex: johndoe@gmail.com" onkeyup="fillInput('email')" required>
                                            <span class="invalid-feedback" style="display:none!important;">Please fill Email!</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Date*</label>
                                    <input type="date" class="form-control datepicker" name="date" id="date" required>
                                    <span class="invalid-feedback" style="display:none!important;">Please fill Date!</span>
                                </div>
                                <div class="form-group">
                                    <label for="">Subject*</label>
                                    <input type="text" class="form-control" name="subject" id="subject" required>
                                    <span class="invalid-feedback" style="display:none!important;">Please fill Subject!</span>
                                </div>
                                {{--                                    <div class="form-group">--}}
                                {{--                                        <label for="">Address*</label>--}}
                                {{--                                        <textarea name="address" id="address" class="form-control" rows="3" placeholder="Building Name&#10;Street&#10;City - Province"></textarea>--}}
                                {{--                                        <span class="invalid-feedback" style="display:none!important;">Please fill Address!</span>--}}
                                {{--                                    </div>--}}
                                <div class="form-group">
                                    <label for="">Building Name</label>
                                    <input type="text" class="form-control" name="building" id="building" placeholder="ex: Gedung Inlingua">
                                    <span class="invalid-feedback" style="display: none!important;">Please fill Building Name!</span>
                                </div>
                                <div class="form-group">
                                    <label for="">Street Name*</label>
                                    <input type="text" class="form-control" name="street" id="street" placeholder="ex: Jl. Puri Kencana Blok K6 No. 2M-2L" required>
                                    <span class="invalid-feedback" style="display: none!important;">Please fill Street Name!</span>
                                </div>
                                <div class="form-group">
                                    <label for="">City - Postal Code*</label>
                                    <input type="text" class="form-control" name="city" id="city" placeholder="ex: Jakarta - 11610" required>
                                    <span class="invalid-feedback" style="display: none!important;">Please fill City - Postal Code!</span>
                                </div>
                                <div class="form-group">
                                    <label>Attention*</label>
                                    <input class="form-control" placeholder="ex: John Doe" id="attention" name="attention" required>
                                    <span class="invalid-feedback" style="display:none!important;">Please fill Attention!</span>
                                </div>
                                <div class="form-group">
                                    <label for="">Quotation Type</label>
                                    <input type="text" name="quote_type" id="quote_type" class="form-control" placeholder="ex: Supply Only, Maintenance">
                                    <span class="invalid-feedback" style="display:none!important;">Please fill Quotation Type!</span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-add" style="display: none!important;">
                            <div class="tabGroupInitiateAdd">
                                <div class="form-group" style="display:flex">
                                    <button class="btn btn-sm btn-primary" id="btnInitiateAddProduct" type="button" style="margin:0 auto;"><i class="bx bx-plus"></i>&nbspAdd Product</button>
                                </div>
                                <div class="form-group" style="display:flex;">
                                    <span style="margin:0 auto;">OR</span>
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <div style="padding: 7px;
                                      border: 1px solid #dee2e6 !important;
                                      color: #337ab7;
                                      height: 35px;
                                      background-color: #eee;
                                      display: inline;
                                      margin: 0 auto;">
                                        <i class="bx bx-cloud-upload" style="margin-left:5px">
                                            <input id="uploadCsv" type="file" name="uploadCsv" style="margin-top: 3px;width: 80px;display: none;"></i>
                                        <label for="uploadCsv">Upload CSV</label>
                                        <i class="bx bx-x hidden" onclick="cancelUploadCsv()" style="display:inline;color: red;"></i>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                <!--              <span style="margin: 0 auto;">You can get format of CSV from this <a href="{{url('https://drive.google.com/uc?export=download&id=1IDI8NVdVskSl__qQVfsrugEamr01W4IA')}}" style="cursor:pointer;">link</a></span> -->
                                    <span style="margin: 0 auto;">You can get format of CSV from this <a href="{{url('https://drive.google.com/uc?export=download&id=1G8JIaREKOPlQypwMCaQ6o5vdujrLV5Ar')}}" style="cursor:pointer;">link</a></span>
                                    {{--                                    <span style="margin: 0 auto;">You can get format of CSV from this <a href="{{url('https://drive.google.com/uc?export=download&id=1Hwpgo-RcVkmQdND7159f5l4Ah-qgcNwK')}}" style="cursor:pointer;">link</a></span>--}}
                                </div>
                                <div style="display: flex;">
                                    <span style="margin: 0 auto;">And make sure, the change of template only at row 2, any change on row 1 (header) will be reject</span>
                                </div>
                            </div>
                            <div class="tabGroup" style="display:none!important">
                                <div class="form-group">
                                    <label>Product*</label>
                                    <input autocomplete="off" type="text" name="" class="form-control" id="inputNameProduct" placeholder="ex. Laptop MSI Modern 14" onkeyup="fillInput('name_product')">
                                    <span class="invalid-feedback" style="display:none!important;">Please fill Name Product!</span>
                                </div>
                                <div class="form-group">
                                    <label>Description*</label>
                                    <textarea onkeyup="fillInput('desc_product')" style="resize:vertical;height:150px" id="inputDescProduct" placeholder='ex. Laptop mSI Modern 14, Processor AMD Rayzen 7 5700, Memory 16GB, SSD 512 Gb, Screen 14", VGA vega 8, Windows 11 Home' name="inputDescProduct" class="form-control"></textarea>
                                    <span class="invalid-feedback" style="display:none!important;">Please fill Description!</span>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Time Period</label>
                                        <div class="input-group">
                                            <input autocomplete="off" type="number" name="" class="form-control" id="inputTimePeriod" placeholder="Ex. 12" onkeyup="fillInput('time_period')">
                                            <div class="input-group-text">
                                                Month
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Qty*</label>
                                            <input autocomplete="off" type="number" name="" class="form-control" id="inputQtyProduct" placeholder="ex. 5" onkeyup="fillInput('qty_product')">
                                            <span class="help-block" style="display:none;">Please fill Qty!</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="margin-bottom:10px">
                                        <label>Type*</label>
                                        {{--                                            <i class="fa fa-warning" title="If type is undefined, Please contact developer team!" style="display:inline"></i>--}}
                                        <select style="width:100%;display:inline;" class="form-control" id="selectTypeProduct" placeholder="ex. Unit" onchange="fillInput('type_product')">
                                            <option>
                                        </select>
                                        <span class="help-block" style="display:none;">Please fill Unit!</span>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6" style="margin-bottom:10px">
                                        <label>Price*</label>
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                            <input autocomplete="off" type="text" name="" class="form-control money" id="inputPriceProduct" placeholder="ex. 500,000.00" onkeyup="fillInput('price_product')">
                                        </div>
                                        <span class="help-block" style="display:none;">Please fill Price!</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Price List</label>
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                            <input autocomplete="off" type="text" name="" class="form-control money" id="inputPriceList" placeholder="ex. 500,000.00" onkeyup="fillInput('price_list')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Price</label>
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                                <input autocomplete="off" readonly type="text" name="" class="form-control" id="inputTotalPrice" placeholder="75.000.000,00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Price List</label>
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                                <input autocomplete="off" readonly type="text" name="" class="form-control" id="inputTotalPriceList" placeholder="75.000.000,00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="additionalInputContainer">
                                    </div>
                                </div>
                                <div class="text-end mt-2">
                                    <button type="button" class="btn btn-sm btn-warning" onclick="addAdditionalInput()"><i class="bx bx-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-add" style="display:none!important">
                            <div class="tabGroup table-responsive">
                                <table class="table no-wrap">
                                    <thead>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Description</th>
                                    <th>Time Period</th>
                                    <th>Qty</th>
                                    <th>Type</th>
                                    <th>Price List</th>
                                    <th>Total Price List</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                    <th><a class="pull-right" onclick="refreshTable()"><i class="bx bx-refresh"></i>&nbsp</a></th>
                                    </thead>
                                    <tbody id="tbodyProducts">
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12" id="bottomProducts">
                                </div>
                            </div>
                            <div class="form-group" style="display:flex;margin-top: 10px;">
                                <button class="btn btn-sm btn-sm btn-primary" style="margin: 0 auto;" type="button" id="addProduct"><i class="bx bx-plus"></i>&nbsp Add product</button>
                            </div>
                        </div>
                        <div class="tab-add" style="display:none!important">
                            <div class="tabGroup">
                                <div class="card-body">
                                    <div id="snow-toolbar">
                                        <span class="ql-formats">
                                          <select class="ql-font"></select>
                                          <select class="ql-size"></select>
                                        </span>
                                        <span class="ql-formats">
                                          <button class="ql-bold"></button>
                                          <button class="ql-italic"></button>
                                          <button class="ql-underline"></button>
                                          <button class="ql-strike"></button>
                                        </span>
                                        <span class="ql-formats">
                                          <select class="ql-color"></select>
                                          <select class="ql-background"></select>
                                        </span>
                                        <span class="ql-formats">
                                          <button class="ql-script" value="sub"></button>
                                          <button class="ql-script" value="super"></button>
                                        </span>
                                        <span class="ql-formats">
                                          <button class="ql-header" value="1"></button>
                                          <button class="ql-header" value="2"></button>
                                          <button class="ql-blockquote"></button>
                                          <button class="ql-code-block"></button>
                                        </span>
                                    </div>
                                    <div tabindex="0" id="snow-editor" onkeydown="fillInput('textArea_TOP')">
                                    </div>
                                    <span class="invalid-feedback" style="display:none!important;">Please fill Term of Payment!</span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-add" style="display:none!important">
                            <div class="tabGroup">
                                <div class="row">
                                    <div class="col-md-12" id="headerPreviewFinal">

                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table" style="white-space: nowrap;">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Product</th>
                                                <th>Description</th>
                                                <th class="dynamic-header-placeholder-preview"></th>
                                                <th>Time Period</th>
                                                <th>Qty</th>
                                                <th>Type</th>
                                                <th>Price List</th>
                                                <th>Total Price List</th>
                                                <th>Price</th>
                                                <th>Total Price</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbodyFinalPageProducts">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="bottomPreviewFinal">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="prevBtnAdd">Back</button>
                        <button type="button" class="btn btn-sm btn-primary" id="nextBtnAdd">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="signatureModal" role="dialog" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                    <h6 class="modal-title" id="signatureModalLabel">Sign Quotation</h6>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <canvas id="signatureCanvas" style="border: 1px solid #000; width: 100%; height: 200px;"></canvas>
                    </div>
                    <div class="mt-3 text-center">
                        <button type="button" id="clearCanvas" class="btn btn-sm btn-danger">Clear</button>
                        <button type="button" id="saveSignature" class="btn btn-sm btn-primary">Save Signature</button>
                        <button type="button" id="skipSignature" class="btn btn-sm btn-outline-secondary">Skip</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pdfModal" role="dialog" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                    <h6 class="modal-title" >Choose Template PDF</h6>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <a href="{{url('/sales/quote/generatePDFQuote?id_quote='.$id.'&lang=id')}}" target="_blank" class="list-group-item list-group-item-action" onclick="closeModalPdf()">
                            Bahasa Indonesia
                        </a>
                        <a href="{{url('/sales/quote/generatePDFQuote?id_quote='.$id.'&lang=en')}}" target="_blank" class="list-group-item list-group-item-action" onclick="closeModalPdf()">
                            English
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptImport')
    <script src="{{asset('assets/vendor/libs/quill/katex.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/quill/quill.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js' type='text/javascript'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ url('assets/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ url('assets/js/jquery.emailinput.min.js')}}"></script>
    <script src="{{ url('assets/js/roman.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.mask.js')}}"></script>
    <script src="{{asset('assets/js/jquery.mentionsInput.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/jquery.events.input.js')}}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

@endsection
@section('script')
    <script type="text/javascript">
        // $(".money").mask('000,000,000,000,000', {reverse: true})
        $('.money').mask('#.##0,00', {reverse: true})
        let snowEditor ;


        window.onload = function(){
            localStorage.setItem("arrFilterBack", localStorage.getItem("arrFilter"))
        }

        function closeModalPdf() {
            $('#pdfModal').modal('hide');
        }

        document.addEventListener('DOMContentLoaded', function() {
            var canvas = document.getElementById('signatureCanvas');

            var signaturePad = new SignaturePad(canvas);

            document.getElementById('clearCanvas').addEventListener('click', function() {
                signaturePad.clear();
            });

            document.getElementById('saveSignature').addEventListener('click', function() {
                if (!signaturePad.isEmpty()) {
                    var dataUrl = signaturePad.toDataURL('image/png');
                    saveSignature(dataUrl);
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: "Isi tanda tangan terlebih dahulu!",
                        icon: 'error',
                    })
                }
            });

            document.getElementById('skipSignature').addEventListener('click', function(){
                $('#signatureModal').modal('hide');

                // Tunggu animasi close modal selesai sebelum membuka modal baru
                setTimeout(() => {
                    // Buka modal pdfModal
                    $('#pdfModal').modal('show');
                }, 500); // Durasi animasi modal close
            })

            function saveSignature(dataUrl) {
                let version = localStorage.getItem('version');
                let idQuote = localStorage.getItem('id_quote');
                Swal.fire({
                    title: 'Mohon tunggu..!',
                    text: "Data diproses..",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    customClass: {
                        popup: 'border-radius-0',
                    },
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '/sales/quote/saveSignature',
                    type: 'POST',
                    data: {
                        _token:"{{csrf_token()}}",
                        signature: dataUrl,
                        id_quote: idQuote
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success',
                            text: "Signature saved!",
                            icon: 'success',
                        }).then(() => {
                            // window.open('/sales/quote/generatePDFQuote?id_quote=' + idQuote , '_blank');
                            $('#signatureModal').modal('hide');

                            // Tunggu animasi close modal selesai sebelum membuka modal baru
                            setTimeout(() => {
                                // Buka modal pdfModal
                                $('#pdfModal').modal('show');
                            }, 500); // Durasi animasi modal close
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Gagal',
                            text: "Terjadi kesalahan saat menyimpan tanda tangan.",
                            icon: 'error',
                        });
                    }
                });
            }

        });

        var formatter = new Intl.NumberFormat(['ban', 'id']);

        $(document).ready(function(){
            showDetail()

            $('input[type="file"][name="uploadCsv"]').change(function(){
                var f=this.files[0]
                var filePath = f;

                var ext = filePath.name.split(".");
                ext = ext[ext.length-1].toLowerCase();
                var arrayExtensions = ["csv"];

                if (arrayExtensions.lastIndexOf(ext) == -1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Invalid file type, just allow csv file',
                    }).then((result) => {
                        this.value = ''
                    })
                }else{
                    localStorage.setItem('isProductInline',false)
                    $("#uploadCsv").next('label').attr('style','display:none!important')
                    $("input[type='file'][name='uploadCsv']").removeClass('hidden')
                    $("input[type='file'][name='uploadCsv']").prev('i').attr('style','display:none!important')
                    $("#uploadCsv").next('label').next('i').removeClass('hidden')
                    $("#btnInitiateAddProduct").prop("disabled",true)
                }
            })

        })

        function select2TypeProduct(value){
            $.ajax({
                type:"GET",
                dataType:"json",
                url:"{{asset('/json/typePrProduct.json')}}",
                success: function(result){
                    $('#selectTypeProduct').select2({
                        data:result,
                        placeholder:'Ex. Unit',
                        dropdownParent: $('#modalAdd')
                    })
                }
            })

            if (value != undefined) {
                $('#selectTypeProduct').val(value.toLowerCase()).trigger('change')
            }
        }

        function cancelUploadCsv(){
            $("input[type='file'][name='uploadCsv']").val('')
            $("#uploadCsv").next('label').show()
            $("input[type='file'][name='uploadCsv']").addClass('hidden')
            $("input[type='file'][name='uploadCsv']").prev('i').show()
            $("#uploadCsv").next('label').next('i').addClass('hidden')
            $("#btnInitiateAddProduct").prop("disabled",false)
        }

        function buttonBack() {
            if (localStorage.getItem('isEmail') == 'true') {
                $("#showDetail").empty()
                localStorage.setItem('isEmail',false)
                showDetail()
            }else{
                $("#BtnBack").attr("href", "{{url('/sales/quote')}}")
            }
        }



        let arrReason = []
        function reasonReject(reason,display,nameClass,typeCallout=""){
            $(".divReasonRejectRevision").remove()
            var textTitle = ""
            var className = ""

            if (nameClass == 'tabGroup' || nameClass == 'tabGroupModal') {
                textTitle = "Note Quotation"
                className = "tabGroup"
            }else{
                textTitle = "Warning!"
                className = nameClass
            }

            var append = ""

            append = append + '<div class="alert alert-danger divReasonRejectRevision" style="display:none">'
            append = append + '<h6><i class="icon bx bx-x"></i>'+ textTitle +'</h6>'
            if (reason != null){
                append = append + '<p class="reason_reject_revision">'+ reason.replaceAll("\n","<br>")+'</p>'
            }
            append = append + '</div>'

            $("." + nameClass).prepend(append)

            if (display == "block") {
                $(".divReasonRejectRevision").show()
            }
        }

        function showDetail(){
            localStorage.setItem('id_quote', window.location.href.split("/")[5]);
            append = ""
            append = append + '<div class="col-md-9 tabGroup">'
            append = append + '<div class="row mb-4">'
            append = append + '<div class="col-md-12">'
            append = append + '<div class="card">'
            append = append + '<div class="card-body">'
            append = append + '<div class="row mb-4">'
            append = append + '<div class="col-md-12">'
            append = append + '<span><b>Action</b></span><br>'
            @if(\Illuminate\Support\Facades\Auth::user()->nik == $nik)
                append = append + '<button class="btn btn-sm btn-primary" style="margin-right:5px" id="btnEdit" data-bs-target="#modalAdd" data-bs-toggle="modal" onclick="unfinishedDraft(0, '+ window.location.href.split("/")[5] +', null)" ><i class="bx bx-pencil"></i> Edit</button>'
                @if($status == 'APPROVED')
                    append = append + '<button class="btn btn-sm btn-warning" style="margin-right:5px" id="btnSendEmail" onclick="sendEmailQuotation({{$sign == null ? '0' : '1'}},{{$idVersion}})" {{$sended == 1 ? 'disabled' : ''}} ><i class="bx bx-envelope"></i> Send Email</button>'
                @endif
            @endif

            @if($status != 'APPROVED' && $status != 'REJECTED')
                @if($canApproveReject)
                append = append + '<button class="btn btn-sm btn-danger" style="margin-right:5px" id="btnReject" data-bs-target="#ModalRejectQuotation" data-bs-toggle="modal">Reject</button>'
            append = append + '<button class="btn btn-sm btn-success" style="margin-right:5px" id="btnApprove" onclick="approveQuotation()">Approve</button>'
                @endif
            @endif
            @if($status == 'APPROVED' && Auth::user()->nik == $nik)
                append = append + '<button id="btnShowPdf" class="btn btn-sm btn-warning pull-right" data-bs-toggle="modal" data-bs-target="#signatureModal">Show PDF</button>'
            @elseif($status == 'APPROVED' && Auth::user()->nik != $nik)
                append = append + '<button id="btnShowPdf2" data-bs-toggle="modal" data-bs-target="#pdfModal" class="btn btn-sm btn-warning pull-right">Show PDF</button>'
            @endif
            append = append + '</div>'
            append = append + '</div>'
            append = append + '<hr>'
            append = append + '<div class="row mb-4">'
            append = append + '<div class="col-md-12">'
            append = append + '<div id="headerPreview">'
            append = append + '</div>'
            append = append + '<div class="card p-4 mb-4">'
            append = append + '<div class="card-header" style="display:block ruby"><h6 class="card-title" style="margin-top:15px">Products</h6><div class="card-tools pull-right"><button type="button" class="btn btn-sm btn-card-tool btnProductCollapse mt-1"><span class="bx bx-lg bx-chevron-down"></span></button></div></div>'
            append = append + '<div class="card-body" id="bodyCollapseProduct">'
            append = append + '<div class="table-responsive">'
            append = append + '<table class="table no-wrap">'
            append = append + '<thead>'
            append = append + '<th>No</th>'
            append = append + '<th width="20%">Product</th>'
            append = append + '<th width="40%">Description</th>'
            append = append + '<th width="40%" class="dynamic-header-placeholder"></th>'
            append = append + '<th width="10%">Time Period</th>'
            append = append + '<th width="5%">Qty</th>'
            append = append + '<th width="5%">Type</th>'
            append = append + '<th width="10%">Price List</th>'
            append = append + '<th width="10%">Total Price List</th>'
            append = append + '<th width="10%">Price</th>'
            append = append + '<th width="10%">Total Price</th>'
            append = append + '</thead>'
            append = append + '<tbody id="bodyPreview" class="mb-4">'
            append = append + '</tbody>'
            append = append + '</table>'
            append = append + '</div>'

            append = append + '<div id="bottomPreviewProduct" class="mb-4">'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '<div id="bottomPreview" class="mb-4">'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'

            append = append + '<div class="col-md-12" id="showResolve">'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '<div class="col-md-3">'
            append = append + '<div id="scrollingDiv">'
            append = append + '<div class="card">'
            append = append + '<div class="card-header">'
            append = append + '<h6> Version </h6>'
            append = append + '</div>'
            append = append + '<div class="card-body" id="version">'
            $.ajax({
                type:"GET",
                url:"{{url('/sales/quote/getVersionConfig')}}",
                data:{
                    id_quote:window.location.href.split("/")[5]
                },
                beforeSend:function(){
                    $('.layout-container').block({
                      message: '<div class=""spinner-border text-white"" role=""status""></div>',
                      timeout: 1000,
                      css: {
                        backgroundColor: 'transparent',
                        border: '0'
                      },
                      overlayCSS: {
                        opacity: 0.5
                      }
                    });
                },
                success:function(result){
                    appendVersion = ''
                    appendVersion = appendVersion + '    <div class="row mb-4" style="padding:10px">'
                    $.each(result.data,function(index, config){
                        appendVersion = appendVersion + '     <div class="col-md-12 col-xs-12">'
                        appendVersion = appendVersion + '        <div class="form-group">'
                        var checked = ""
                        if (config.status == "Choosed") {
                            var checked = "checked"
                            loadDataSubmitted(config.version)
                            localStorage.setItem('version', config.version)
                            localStorage.setItem('id_version', config.id)
                            if (config.reason !== null){
                                reasonReject(config.reason,'block','tabGroup');
                            }
                        }
                        appendVersion = appendVersion + '     <div class="radio">'
                        appendVersion = appendVersion + '       <label>'
                        appendVersion = appendVersion + '         <input '+ checked +' onclick="handleRadioClick(this, '+ config.version +', '+ config.id +')"  type="radio" name="radioGroup" id="radio'+ config.version +'" value="'+ config.id +'">'
                        appendVersion = appendVersion + "Version " + parseInt(config.version) + " - " + config.project_type
                        appendVersion = appendVersion + '          </label>'
                        // appendVersion = appendVersion + '            <a onclick="loadDataSubmitted('+ config.version +')">'
                        // appendVersion = appendVersion + '               <i class="bx bx-pencil-square-o"></i>'
                        // appendVersion = appendVersion + '            </a>'
                        appendVersion = appendVersion + '      </div>'
                        appendVersion = appendVersion + '       </div>'
                        appendVersion = appendVersion + '     </div>'
                    })
                    appendVersion = appendVersion + '   </div>'
                    $("#version").append(appendVersion)

                }
            })
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'

            $("#showDetail").append(append)

            var no = 0
            var appendResolve = ''


            $("#btnAddNotes").click(function(){
                $(".modal-dialog").removeClass('modal-lg')
                $("#ModalAddNote").modal("show")
            })
        }

        function handleRadioClick(element, version, id) {
            if (element.checked) {
                loadDataSubmitted(version);
                localStorage.setItem('version', version);
                localStorage.setItem('id_version', id);
            }
        }

        function num(value){
            alert("Number " + value);
        }

        $("#tbChangeLog").DataTable({
            "ajax":{
                "type":"GET",
                "url":"{{url('/sales/quote/getActivity')}}",
                "data":{
                    id_quote:window.location.href.split("/")[5]
                }
            },
            columns: [
                {
                    title: "Name",
                    data: "operator",
                    orderable: false
                },
                {
                    title: "Activity",
                    data: "activity"
                },
                {
                    title: "Status",
                    data: "status"
                },
                {
                    title: "Date",
                    data: "date_add"
                },
            ],
            "aaSorting": [],
            "bFilter": true,
            "bSort":true,
            // "bLengthChange": false,
            "pageLength": 10,
            "bInfo": false,
            initComplete: function () {

            }
        });

        function sendEmailQuotation(sign,version){
            if(sign == '0'){
                Swal.fire({
                    title: 'Attention!',
                    text: "You need to sign the document before send email to Customer",
                    icon: 'warning'
                })
            }else{
                $('#showDetail').empty();
                $('#changeLog').empty();
                showEmail(version)
                localStorage.setItem('isEmail',true)
            }
        }

        // $('#bodyOpenMail').slimScroll({
        //     height: '600px'
        // });

        // $('#table-produk').slimScroll({
        //     width: '600px'
        // });

        function showEmail(version){
            append = ""
            append = append + '<div class="col-md-12">'
            append = append + '<div class="card">'
            append = append + '<div class="card-body">'
            append = append + '<div class="form-horizontal">'
            append = append + '<div class="form-group">'
            append = append + '<label class="col-sm-1 control-label">'
            append = append + 'To : '
            append = append + '</label>'
            append = append + '<div class="col-sm-11">'
            append = append + '<input class="form-control" name="emailTo" id="emailOpenTo">'
            append = append + '</div>'
            append = append + '<div class="col-sm-11 col-sm-offset-1 help-block" style="margin-bottom: 0px;">'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '<div class="form-group">'
            append = append + '<label class="col-sm-1 control-label">'
            append = append + 'Cc :'
            append = append + '</label>'
            append = append + '<div class="col-sm-11">'
            append = append + '<input class="form-control" name="emailCc" id="emailOpenCc">'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '<div class="form-group">'
            append = append + '<label class="col-sm-1 control-label">'
            append = append + 'Subject :'
            append = append + '</label>'
            append = append + '<div class="col-sm-11">'
            append = append + '<input class="form-control" name="emailSubject" id="emailOpenSubject">'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '<div class="form-group">'
            append = append + '<div class="col-sm-12">'
            append = append + '<div contenteditable="true" class="form-control" style="height: 600px;overflow: auto;" id="bodyOpenMail">'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '<div class="form-group">'
            append = append + '<div class="col-sm-12">'
            append = append + '<button class="btn btn-sm btn-flat btn-primary pull-right ml-4" style="display:inline" onclick="sendOpenEmail('+version+')"><i class="bx bx-envelope-o"></i> Send</button>'
            append = append + '<button class="btn btn-sm btn-flat btn-danger pull-right mr-2" style="display:inline; margin-right: 3px;" id="BtnBack" onclick="buttonBack()">Back</button>'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'
            append = append + '</div>'

            $("#showDetail").append(append)
            createEmailBody(version)
        }

        function generatePDFQuote(){
            let version = localStorage.getItem('version');
            let idQuote = localStorage.getItem('id_quote');
            window.open('/sales/quote/generatePDFQuote?id_quote=' + idQuote + '&version=' + version, '_blank');
        }

        function approveQuotation(){
            let version = localStorage.getItem('version');
            let idQuote = localStorage.getItem('id_quote');
            let idConfig = localStorage.getItem('id_version');

            Swal.fire({
                title: 'Are you sure?',
                text: "Approve Quotation Version " + version,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: 'Please Wait..!',
                        text: "It's sending..",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        customClass: {
                            popup: 'border-radius-0',
                        },
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                    $.ajax({
                        type:"POST",
                        url:"{{url('/sales/quote/approveQuotation')}}",
                        data:{
                            _token:"{{csrf_token()}}",
                            id_quote: idQuote,
                            version: version,
                            id_config: idConfig
                        },
                        success: function(result){
                            Swal.fire({
                                title: 'Success',
                                text: 'Approve Quotation Success',
                                icon: 'success',
                                confirmButtonText: 'Reload',
                            }).then((result) => {
                                location.reload()
                            })
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Ooppss!!',
                                text: 'Something wrong, try again..',
                                icon: 'error',
                            })
                        }
                    })
                }
            })
        }

        function rejectQuotation(){
            let version = localStorage.getItem('version');
            let idQuote = localStorage.getItem('id_quote');
            let idConfig = localStorage.getItem('id_version');
            let reason = $('#reasonReject').val();
            Swal.fire({
                title: 'Are you sure?',
                text: "Reject Quotation Version " + version,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: 'Please Wait..!',
                        text: "It's sending..",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        customClass: {
                            popup: 'border-radius-0',
                        },
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                    $.ajax({
                        type:"POST",
                        url:"{{url('/sales/quote/rejectQuotation')}}",
                        data:{
                            _token:"{{csrf_token()}}",
                            id_quote: idQuote,
                            version: version,
                            id_config: idConfig,
                            reason: reason
                        },
                        success: function(result){
                            Swal.fire({
                                title: 'Success',
                                text: 'Reject Quotation Success',
                                icon: 'success',
                                confirmButtonText: 'Reload',
                            }).then((result) => {
                                location.reload()
                            })
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Ooppss!!',
                                text: 'Something wrong, try again..',
                                icon: 'error',
                            })
                        }
                    })
                }
            })
        }

        function loadData(){
            $.ajax({
                type: "GET",
                url: "{{url('/sales/quote/getPreview')}}",
                data: {
                    id_quote:window.location.href.split("/")[5],
                },
                success: function(result) {
                    var appendHeader = ""
                    appendHeader = appendHeader + '<div class="row mb-4">'
                    appendHeader = appendHeader + '    <div class="col-md-6">'
                    appendHeader = appendHeader + '        <div class="mb-2">To: '+ result.quote.to +'</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">Email: ' + result.quote.email + '</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">Phone: ' + result.quote.no_telp + '</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">Attention: '+ result.quote.attention +'</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">From: '+ result.quote.from +'</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">Subject: '+ result.quote.title +'</div>'
                    appendHeader = appendHeader + '        <div class="mb-2" style="width:fit-content;word-wrap: break-word;">Address: '+ result.quote.address +'</div>'

                    appendHeader = appendHeader + '    </div>'
                    if (window.matchMedia("(max-width: 767px)").matches)
                    {
                        appendHeader = appendHeader + '    <div class="col-md-6">'
                        // The viewport is less than 768 pixels wide

                    } else {
                        appendHeader = appendHeader + '    <div class="col-md-6" style="text-align:end">'
                        // The viewport is at least 768 pixels wide

                    }
                    appendHeader = appendHeader + '        <div class="mb-2"><b>Quote Number</b></div>'
                    appendHeader = appendHeader + '        <div class="mb-2">'+ result.quote.quote_number +'</div>'
                    appendHeader = appendHeader + '        <div class="mb-2"><b>Lead ID</b></div>'
                    appendHeader = appendHeader + '        <div class="mb-2">'+ result.quote.lead_id +'</div>'
                    appendHeader = appendHeader + '        <div class="mb-2"><b>Quotation Type</b></div>'
                    appendHeader = appendHeader + '        <div class="mb-2">'+ result.config.project_type +'</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">'+ moment(result.quote.created_at).format('DD MMMM') +'</div>'
                    appendHeader = appendHeader + '    </div>'
                    appendHeader = appendHeader + '</div>'

                    $("#headerPreview").append(appendHeader)
                    var append = ""
                    var i = 0
                    var valueGrandTotal = 0
                    var additionalHeadersDetail = [];
                    $.each(result.product,function(value,item){
                        if (value === 0) {
                            let hasAdditionalColumn = false;
                            for (let j = 1; j <= 5; j++) {
                                const col = item[`additional_column_${j}`];
                                if (col && col.includes("-") && col !== null && col !== "") {
                                    const header = col.split("-")[0].trim();
                                    if (header) {
                                        additionalHeadersDetail.push({ index: j, header });
                                        hasAdditionalColumn = true;
                                    }
                                }
                            }
                            let dynamicHeaderHTML = "";
                            if (hasAdditionalColumn) {
                                additionalHeadersDetail.forEach(h => {
                                    dynamicHeaderHTML += `<th width='20%'>${h.header}</th>`;
                                });

                                $(".table thead tr th.dynamic-header-placeholder").replaceWith(dynamicHeaderHTML);
                            }else{
                                $(".table thead tr th.dynamic-header-placeholder").replaceWith(dynamicHeaderHTML);
                            }

                        }
                        i++
                        valueGrandTotal += parseFloat(item.grand_total)
                        append = append + '<tr>'
                        append = append + '<td>'
                        append = append + '<span>'+ i +'</span>'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + "<input data-value='' disabled style='width:200px;font-size: 12px; important' class='form-control' type='' name='' value='"+ item.name + "'>"
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<textarea style="width:500px;font-size:12px;height:150px;width:200px;resize:none" class="form-control" disabled>' + item.description.replaceAll("<br>","\n") + '&#10;&#10;SN : ' + item.serial_number + '&#10;PN : ' + item.part_number +'</textarea>'
                        append = append + '</td>'
                        additionalHeadersDetail.forEach(h => {
                            const col = item[`additional_column_${h.index}`];
                            let value = "-";
                            if (col && col.includes("-")) {
                                value = col.split("-")[1]?.trim() || "";
                            }
                            append += `<td style="font-size: 12px;"><input type="text" readonly class="form-control" value="${value}"></td>`;
                        });
                        append = append + '<td>'
                        append = append + '<input disabled class="form-control" type="" name="" value="'+ item.jangka_waktu +'" style="width:75px;font-size:12px">'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<input disabled class="form-control" type="" name="" value="'+ item.qty +'" style="width:45px;font-size:12px">'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<select disabled class="form-control" style="width:80px;font-size:12px">'
                        append = append + '<option>'+ item.unit.charAt(0).toUpperCase() + item.unit.slice(1) +'</option>'
                        append = append + '</select>'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<input disabled class="form-control" type="" name="" value="'+ formatter.format(item.nominal) +'" style="width:100px;font-size:12px">'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<input disabled class="form-control grandTotalPrice" id="grandTotalPrice" type="" name="" value="'+ formatter.format(item.grand_total) +'" style="width:100px;font-size:12px">'
                        append = append + '</td>'
                        append = append + '</tr>'
                    })

                    $("#bodyPreview").append(append)
                    appendBottom = ""
                    appendBottom = appendBottom + '<hr>'
                    appendBottom = appendBottom + '<div class="row mb-4">'
                    appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                    appendBottom = appendBottom + '    <form class="form-horizontal">'
                    appendBottom = appendBottom + '      <div class="form-group">'
                    appendBottom = appendBottom + '        <label for="" class="col-sm-offset-6 col-sm-2 control-label">Total</label>'
                    appendBottom = appendBottom + '        <div class="col-sm-4">'
                    appendBottom = appendBottom + '          <input disabled="" type="text" class="form-control inputGrandTotalProductPreviewData" id="inputGrandTotalProductPreviewData" data-value="'+i+'" style="text-align:right">'
                    appendBottom = appendBottom + '        </div>'
                    appendBottom = appendBottom + '      </div>'


                    appendBottom = appendBottom + '      <div class="form-group">'
                    appendBottom = appendBottom + '        <label for="" class="col-sm-offset-6 col-sm-2 control-label">Vat <span class="title_tax"></span></label>'
                    appendBottom = appendBottom + '        <div class="col-sm-4">'
                    appendBottom = appendBottom + '          <input disabled="" style="text-align:right" type="text" class="form-control vat_tax_preview" id="vat_tax_previewData" data-value="'+i+'">'
                    appendBottom = appendBottom + '        </div>'
                    appendBottom = appendBottom + '      </div>'

                    appendBottom = appendBottom + '      <div class="form-group">'
                    appendBottom = appendBottom + '        <label for="" class="col-sm-offset-6 col-sm-2 control-label">Grand Total</label>'
                    appendBottom = appendBottom + '        <div class="col-sm-4">'
                    appendBottom = appendBottom + '          <input disabled="" style="text-align:right" type="text" class="form-control inputFinalPageTotalPriceData" id="inputFinalPageTotalPriceData" data-value="'+i+'">'
                    appendBottom = appendBottom + '        </div>'
                    appendBottom = appendBottom + '      </div>'

                    appendBottom = appendBottom + '    </form>'
                    appendBottom = appendBottom + '  </div>'
                    appendBottom = appendBottom + '</div>'
                    appendBottom = appendBottom + '<hr>'

                    appendBottom = appendBottom + '<div class="card">'
                        appendBottom = appendBottom + '<div class="card-header with-border">'
                            appendBottom = appendBottom + '<h6 class="card-title" style="margin-top:15px">Terms & Condition</h6>'
                            appendBottom = appendBottom + '<div class="card-tools pull-right">'
                                appendBottom = appendBottom + '<button type="button" class="btn btn-sm btn-card-tool mt-1" data-value="draft"><span class="bx bx-lg bx-chevron-right"></span>'
                                appendBottom = appendBottom + '</button>'
                            appendBottom = appendBottom + '</div>'
                        appendBottom = appendBottom + '</div>'
                        appendBottom = appendBottom + '<div class="card-body p-4" id="" data-value="draft">'
                            appendBottom = appendBottom + '<div class="form-control" id="termPreview" style="padding:10px;width: 100%; height: 200px; font-size: 12px; line-height: 18px; border: 1px solid rgb(221, 221);overflow:auto"></div>'
                            appendBottom = appendBottom + '</div>'
                        appendBottom = appendBottom + '</div>'

                    $("#bottomPreview").append(appendBottom)

                    $("#termPreview").html(result.quote.term_payment.replaceAll("&lt;br&gt;","<br>"))
                    var tempVat = 0
                    var tempPb1 = 0
                    var tempService = 0
                    var tempDiscount = 0
                    var finalVat = 0
                    var tempGrand = 0
                    var finalGrand = 0
                    var tempTotal = 0
                    var sum = 0

                    // $('.grandTotalPrice').each(function() {
                    //     var temp = parseFloat($(this).val() == "" ? "0" : $(this).val().replace(/\./g, '').replace(',', '.').replace(' ', ''));
                    //     sum += temp;
                    // });

                    sum += valueGrandTotal

                    if (result.config.vat_tax == null || result.config.vat_tax == 0 || result.config.vat_tax == "null") {
                        valueVat = '';
                    } else {
                        valueVat = parseFloat(result.config.tax_vat);
                        console.log(valueVat)
                    }

                    if (!isNaN(valueVat)) {
                        tempVat = (parseFloat(sum) * (valueVat / 100));
                        finalVat = tempVat;

                        tempGrand = parseFloat(sum) + parseFloat(tempVat);

                        finalGrand = tempGrand;

                        tempTotal = sum;

                        $('.title_tax').text(valueVat == 0 ? "" : valueVat.toFixed(2) + '%');
                    } else {
                        tempGrand = sum;

                        $('.title_tax').text("");
                    }

                    $('.title_discount').text(result.config.discount == 'false' ? "" : parseFloat(result.config.discount).toFixed(2) + "%");

                    tempDiscount = sum * (result.config.discount == 'false' ? 0 : parseFloat(result.config.discount) / 100);

                    $("#vat_tax_previewData").val(formatter.format(tempVat.toFixed(2)));
                    $("#inputGrandTotalProductPreviewData").val(formatter.format(sum.toFixed(2)));
                    $("#discount_previewData").val(formatter.format(tempDiscount.toFixed(2)));
                    $("#inputFinalPageTotalPriceData").val(formatter.format(parseFloat(sum).toFixed(2)));

                    if (result.config.discount == 'false') {
                        $("#discount_previewData").closest(".form-group").attr('style','display:none!important');
                    } else {
                        $("#discount_previewData").closest(".form-group").show();
                    }

                }
            })
        }

        $(document).on('click','.btnTerm', function() {
            if ($("#bodyCollapse").is(':visible') == true) {
                $("#bodyCollapse").hide("slow")
                $(this).find('span').removeClass("bx-chevron-down").addClass("bx-chevron-right")

            }
            if ($("#bodyCollapse").is(':hidden') == true){
                $("#bodyCollapse").show('slow')
                $(this).find('span').removeClass("bx-chevron-right").addClass("bx-chevron-down")
            }

        })

        $(document).on('click','.btnProductCollapse', function() {
            if ($("#bodyCollapseProduct").is(':visible') == true) {
                $("#bodyCollapseProduct").hide("slow")
                $(this).find('span').removeClass("bx-chevron-down").addClass("bx-chevron-right")

            }
            if ($("#bodyCollapseProduct").is(':hidden') == true){
                $("#bodyCollapseProduct").show('slow')
                $(this).find('span').removeClass("bx-chevron-right").addClass("bx-chevron-down")
            }

        })

        function loadDataSubmitted(version = null){
            localStorage.setItem('status_tax', 12)
            if(version == null){
                version = 1;
            }else{
                version = version;
            }
            $.ajax({
                type: "GET",
                url: "{{url('/sales/quote/getDetailQuote/')}}",
                data: {
                    id_quote:window.location.href.split("/")[5],
                    versi: version
                },
                beforeSend:function(){
                    $('.layout-container').block({
                      message: '<div class=""spinner-border text-white"" role=""status""></div>',
                      timeout: 1000,
                      css: {
                        backgroundColor: 'transparent',
                        border: '0'
                      },
                      overlayCSS: {
                        opacity: 0.5
                      }
                    });
                },
                success: function(result) {
                    $("#headerPreview").empty();
                    $("#bodyPreview").empty();
                    $("#bottomPreviewProduct").empty();
                    $("#bottomPreview").empty();

                    if (result.quote.status == "REJECT" || result.quote.status == "UNAPPROVED" || result.quote.activity == 'Updating' && result.quote.status == 'COMPARING'){
                        // reasonReject(result.activity.reason,"block")
                    }

                    var appendHeader = ""
                    appendHeader = appendHeader + '<div class="row mb-4">'
                    appendHeader = appendHeader + '    <div class="col-md-2">'
                    appendHeader = appendHeader + '        <div class="mb-2">To</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">Email</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">Phone</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">Attention</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">From</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">Subject</div>'
                    appendHeader = appendHeader + '        <div class="mb-2" style="width:fit-content;word-wrap: break-word;">Address</div>'
                    appendHeader = appendHeader + '    </div>'
                    appendHeader = appendHeader + '    <div class="col-md-6">'
                    appendHeader = appendHeader + '        <div class="mb-2">:  '+ result.quote.to +'</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">:  ' + result.config.email + '</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">:  ' + result.quote.no_telp + '</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">:  '+ result.config.attention +'</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">:  '+ result.quote.from +'</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">:  '+ result.quote.title +'</div>'
                    appendHeader = appendHeader + '        <div class="mb-2" style="width:fit-content;word-wrap: break-word;">:    '+ result.quote.address +'</div>'
                    appendHeader = appendHeader + '    </div>'
                    if (window.matchMedia("(max-width: 767px)").matches)
                    {
                        appendHeader = appendHeader + '    <div class="col-md-4">'
                        // The viewport is less than 768 pixels wide

                    } else {
                        appendHeader = appendHeader + '    <div class="col-md-4" style="text-align:end">'
                        // The viewport is at least 768 pixels wide

                    }
                    appendHeader = appendHeader + '        <div class="mb-2"><b>Quote Number</b></div>'
                    appendHeader = appendHeader + '        <div class="mb-2">'+ result.quote.quote_number +'</div>'
                    appendHeader = appendHeader + '        <div class="mb-2"><b>Quotation Type</b></div>'
                    appendHeader = appendHeader + '        <div class="mb-2">'+ result.config.project_type +'</div>'
                    appendHeader = appendHeader + '        <div class="mb-2">'+ moment(result.quote.created_at).format('DD MMMM') +'</div>'
                    appendHeader = appendHeader + '    </div>'
                    appendHeader = appendHeader + '</div>'

                    $("#headerPreview").append(appendHeader)
                    var append = ""
                    var i = 0
                    var additionalHeadersDetail = [];

                    function formatCurrency(value) {
                        let numericValue = parseFloat(value);
                        if (isNaN(numericValue)) numericValue = 0;
                        return new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(numericValue);
                    }
                    var valueGrandTotal = 0

                    $.each(result.product,function(value,item){
                        if (value === 0) {
                            let hasAdditionalColumn = false;
                            for (let j = 1; j <= 5; j++) {
                                const col = item[`additional_column_${j}`];
                                if (col && col.includes("-") && col !== null && col !== "") {
                                    const header = col.split("-")[0].trim();
                                    if (header) {
                                        additionalHeadersDetail.push({ index: j, header });
                                        hasAdditionalColumn = true;
                                    }
                                }
                            }
                            let dynamicHeaderHTML = `<th class="dynamic-header-placeholder" style="display:none;" width='20%'></th>`;
                            if (hasAdditionalColumn) {
                                dynamicHeaderHTML = "";
                                additionalHeadersDetail.forEach(h => {
                                    dynamicHeaderHTML += `<th class="dynamic-header-placeholder" width='20%'>${h.header}</th>`;
                                });

                                $(".table thead tr th.dynamic-header-placeholder").replaceWith(dynamicHeaderHTML);
                            }else{
                                $(".table thead tr th.dynamic-header-placeholder").replaceWith(dynamicHeaderHTML);
                            }

                        }
                        i++
                        valueGrandTotal += parseFloat(item.grand_total)
                        append = append + '<tr>'
                        append = append + '<td>'
                        append = append + '<span>'+ i +'</span>'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + "<input data-value='' disabled style='width:200px;font-size: 12px; important' class='form-control' type='' name='' value='"+ item.name + "'>"
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<textarea style="font-size:12px;height:150px;width:200px;resize:none" class="form-control" disabled>' + item.description.replaceAll("<br>","\n") +'</textarea>'
                        append = append + '</td>'
                        additionalHeadersDetail.forEach(h => {
                            const col = item[`additional_column_${h.index}`];
                            let value = "-";
                            if (col && col.includes("-")) {
                                value = col.split("-")[1]?.trim() || "";
                            }
                            append += `<td style="font-size: 12px;"><input type="text" readonly class="form-control" value="${value}"></td>`;
                        });
                        append = append + '<td>'
                        append = append + '<input disabled class="form-control" type="" name="" value="' + (item.jangka_waktu ? item.jangka_waktu : '-') + '" style="width:75px;font-size:12px">'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<input disabled class="form-control" type="" name="" value="'+ item.qty +'" style="width:45px;font-size:12px">'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<select disabled class="form-control" style="width:80px;font-size:12px">'
                        append = append + '<option>'+ item.unit.charAt(0).toUpperCase() + item.unit.slice(1) +'</option>'
                        append = append + '</select>'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<input disabled class="form-control" type="" name="" value="'+ formatCurrency(item.price_list) +'" style="width:120px;font-size:12px">'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<input disabled class="form-control" id="" type="" name="" value="'+ formatCurrency(item.total_price_list) +'" style="width:120px;font-size:12px">'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<input disabled class="form-control" type="" name="" value="'+ formatCurrency(item.nominal) +'" style="width:120px;font-size:12px">'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<input disabled class="form-control grandTotalPrice" id="grandTotalPrice" type="" name="" value="'+ formatCurrency(item.grand_total) +'" style="width:120px;font-size:12px">'
                        append = append + '</td>'
                        append = append + '</tr>'
                    })

                    $("#bodyPreview").append(append)
                    appendBottomProduct = ""
                    appendBottomProduct = appendBottomProduct + '<hr>'
                    appendBottomProduct += `
                      <div class="row mb-4">
                        <div class="col-md-12 col-xs-12">
                          <form class="form-horizontal">
                            <div class="d-flex justify-content-end align-items-center mb-2">
                              <label for="inputEmail3" class="col-sm-offset-8 col-sm-2 control-label">Total</label>
                              <input disabled type="text" class="form-control inputGrandTotalProductPreview w-auto text-end" 
                                     id="inputGrandTotalProductPreview" data-value="${i}">
                            </div>

                            <div class="d-flex justify-content-end align-items-center mb-2">
                              <label for="inputEmail4" class="col-sm-offset-8 col-sm-2 control-label">DPP Nilai Lainnya</label>
                                <input disabled style="text-align:right" type="text" class="form-control dpp w-auto text-end" 
                                       id="dpp_preview" data-value="${i}">
                            </div>

                            <div class="d-flex justify-content-end align-items-center mb-2">
                                <label for="inputEmail4" class="col-sm-offset-8 col-sm-2 control-label">
                                    PPN <span class="title_tax"></span>
                                </label>
                                <input disabled style="text-align:right" type="text" class="form-control vat_tax w-auto text-end" 
                                       id="vat_tax_preview" data-value="${i}">
                            </div>

                            <div class="d-flex justify-content-end align-items-center mb-2">
                                <label for="inputEmail5" class="col-sm-offset-8 col-sm-2 control-label">Grand Total</label>
                                <input disabled style="text-align:right" type="text" class="form-control inputFinalPageTotalPrice w-auto text-end" 
                                       id="inputFinalPageTotalPrice" data-value="${i}">
                            </div>
                          </form>
                        </div>
                      </div>
                    `;
                    appendBottomProduct = appendBottomProduct + '<hr>'

                    $("#bottomPreviewProduct").append(appendBottomProduct)

                    appendBottom = ""
                    appendBottom = appendBottom + '<div class="card">'
                    appendBottom = appendBottom + '<div class="card-header" style="display:block ruby"><h6 class="card-title" style="margin-top:15px">Terms & Condition</h6><div class="card-tools pull-right"><button type="button" class="btn btn-sm btn-card-tool btnTerm mt-1"><span class="bx bx-lg bx-chevron-down"></span></button></div></div>'
                    appendBottom = appendBottom + '<div class="card-body p-4" id="bodyCollapse">'
                    appendBottom = appendBottom + '<div class="form-control" id="termPreview" style="width: 100%; height: 200px; font-size: 12px; line-height: 18px; border: 1px solid rgb(221, 221);overflow:auto"></div>'
                    appendBottom = appendBottom + '</div>'
                    appendBottom = appendBottom + '</div>'

                    $("#bottomPreview").append(appendBottom)

                    if (result.quote.term_payment != null) {
                        $("#termPreview").html(result.quote.term_payment.replaceAll("&lt;br&gt;","<br>"))
                    }
                    var tempVat = 0
                    var tempPb1 = 0
                    var tempService = 0
                    var tempDiscount = 0
                    var finalVat = 0
                    var tempGrand = 0
                    var finalGrand = 0
                    var tempTotal = 0
                    var sum = 0
                    var dpp = 0
                    var valueVat = ""

                    sum += valueGrandTotal;

                    if (result.config.tax_vat == null || result.config.tax_vat == 0 || result.config.tax_vat == 'null') {
                        valueVat = 'false'
                    }else{
                        valueVat = result.config.tax_vat
                    }

                    if (!isNaN(valueVat)) {
                        if (valueVat == 12){
                            dpp = (parseFloat(sum)) * 11 / 12
                            tempVat = dpp * valueVat / 100
                        }else{
                            tempVat = (parseFloat(sum) * (parseFloat(result.config.tax_vat)/100))
                        }                        finalVat = tempVat

                        tempGrand = parseFloat(sum) +  parseFloat(tempVat)

                        tempTotal = sum

                        $('.title_tax').text(valueVat + '%')
                    }else{
                        tempGrand = sum

                        $('.title_tax').text("")
                    }

                    $('.title_discount').text(result.config.discount == 0?"":parseFloat(result.config.discount).toFixed(2)+"%")

                    tempDiscount = (parseFloat(sum) * (result.config.discount == 'false'?tempDiscount:parseFloat(result.config.discount)) / 100)

                    // finalGrand = tempGrand + tempPb1 + tempService - tempDiscount
                    $('#dpp_preview').val(formatCurrency(dpp))
                    $("#vat_tax_preview").val(formatCurrency(tempVat));
                    $("#inputGrandTotalProductPreview").val(formatCurrency(sum));
                    $("#inputDiscount_preview").val(formatCurrency(tempDiscount));
                    $("#inputFinalPageTotalPrice").val(formatCurrency(tempGrand));


                    if (result.config.discount == 0) {
                        $("#inputDiscount_preview").closest(".form-group").attr('style','display:none!important')
                    }else{
                        $("#inputDiscount_preview").closest(".form-group").show()
                    }
                }
            })
        }


        function createEmailBody(version){
            $('.emailMultiSelector').remove()

            $.ajax({
                url:"{{url('/sales/quote/getVersionDetail')}}",
                data:{
                    id:version,
                },
                type:"GET",
                success: function (result){
                    $("#emailOpenTo").val(result.data.email)
                    $('#emailOpenSubject').val('Quotation - '+result.data.title)
                }
        })

            $.ajax({
                url:"{{url('sales/quote/getDataEmail')}}",
                data:{
                    id:version
                },
                type:'GET',
                success: function (result) {
                    $("#bodyOpenMail").html(result)

                }
            })

            // {{--$.ajax({--}}
            // {{--    type:"GET",--}}
            // {{--    url:"{{url('/admin/getDataSendEmail')}}",--}}
            // {{--    data:{--}}
            // {{--        no_pr:window.location.href.split("/")[6],--}}
            // {{--        user:user,--}}
            // {{--    },--}}
            // {{--    success: function(result){--}}
            // {{--        arrEmailCc = []--}}
            // {{--        $.each(result.cc,function(value,item){--}}

            // {{--            arrEmailCc.push(item.email)--}}
            // {{--        })--}}
            // {{--        arrEmailCcJoin = arrEmailCc.filter(function(i) {--}}
            // {{--            if (i != null || i != false)--}}
            // {{--                return i;--}}
            // {{--        }).join(";")--}}

            // {{--        $("#emailOpenTo").val(result.to)--}}
            // {{--        $("#emailOpenCc").val(arrEmailCcJoin)--}}
            // {{--        $("#emailOpenSubject").val(result.subject);--}}
            // {{--    },complete: function(){--}}
            // {{--        $("#emailOpenTo").emailinput({ onlyValidValue: true, delim: ';' });--}}
            // {{--        $("#emailOpenCc").emailinput({ onlyValidValue: true, delim: ';' });--}}
            // {{--    }--}}
            // {{--})--}}
        }

        function sendOpenEmail(version){
            text = 'Email Sended'
            Swal.fire({
                title: 'Are you sure?',
                text: 'Make sure there is nothing wrong to send this',
                icon: 'warning',
                showCancelButton: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                    if (result.value){
                        $.ajax({
                            type: "POST",
                            url: "{{url('/sales/quote/sendMailtoCustomer')}}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id:version,
                                body:$("#bodyOpenMail").html(),
                                subject: $("#emailOpenSubject").val(),
                                to: $("#emailOpenTo").val(),
                                cc: $("#emailOpenCc").val(),
                            },
                            beforeSend: function(){
                                Swal.fire({
                                    title: 'Please Wait..!',
                                    text: "It's sending..",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                    customClass: {
                                        popup: 'border-radius-0',
                                    },
                                    didOpen: () => {
                                        Swal.showLoading()
                                    }
                                })
                            },
                            success: function(resultAjax){
                                Swal.hideLoading()
                                Swal.fire({
                                    title: 'Success!',
                                    text: text,
                                    icon: 'success',
                                    confirmButtonText: 'Reload',
                                }).then((result) => {
                                    location.reload()
                                })
                            },
                            error: function(resultAjax,errorStatus,errorMessage){
                                Swal.hideLoading()
                                Swal.fire({
                                    title: 'Error!',
                                    text: "Something went wrong",
                                    icon: 'error',
                                }).then((result) => {
                                    location.reload()
                                })
                            }
                        });
                    }
                }
            );
        }

        function submitTTD(value){
            if (value == 'ready') {
                if ($("input[type='radio'][name='selectTTD']:checked").length == 1) {
                    $.ajax({
                        type:"POST",
                        url:"{{url('/admin/submitTtdApprovePR')}}",
                        data:{
                            _token: "{{ csrf_token() }}",
                            no_pr:window.location.href.split("/")[5]
                        },
                        beforeSend:function(){
                            Swal.fire({
                                title: 'Please Wait..!',
                                text: "It's sending..",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                customClass: {
                                    popup: 'border-radius-0',
                                },
                            })
                            Swal.showLoading()
                        },
                        success: function(result){
                            Swal.hideLoading()
                            Swal.fire(
                                'Successfully!',
                                'Circulating PR.',
                                'success'
                            ).then((result) => {
                                if (result.value) {
                                    location.reload()
                                }
                            })
                        }
                    })
                }else{
                    alert('Please Select TTD')
                }
            }else{
                let formData = new FormData();
                const inputTTD = $('#inputTTD').prop('files')[0];
                if (inputTTD != "") {
                    formData.append('inputTTD', inputTTD)
                }
                formData.append('no_pr', window.location.href.split("/")[5])
                formData.append('_token',"{{ csrf_token() }}")
                $.ajax({
                    type:"POST",
                    url:"{{url('/admin/uploadTTD')}}",
                    data:formData,
                    processData: false,
                    contentType: false,
                    beforeSend:function(){
                        Swal.fire({
                            title: 'Please Wait..!',
                            text: "It's sending..",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            customClass: {
                                popup: 'border-radius-0',
                            },
                        })
                        Swal.showLoading()
                    },
                    success: function(result){
                        Swal.hideLoading()
                        Swal.fire(
                            'Successfully!',
                            'Circulating PR.',
                            'success'
                        ).then((result) => {
                            if (result.value) {
                                location.reload()
                            }
                        })
                    }
                })
            }
        }

        $("#btnAccept").click(function(){
            // $("#ModalSirkulasiPr").modal("hide")
            // $(".modal-dialog").removeClass("modal-lg")
            Swal.fire({
                title: 'Are you sure?',
                text: "Approve this Quotation!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:"POST",
                        url:"{{url('/sales/quote/submitTtdApproveQuote')}}",
                        data:{
                            _token:"{{ csrf_token() }}",
                            id_quote:window.location.href.split("/")[5],
                            version: localStorage.getItem('version')
                        },beforeSend:function(){
                            Swal.fire({
                                title: 'Please Wait..!',
                                text: "It's sending..",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                customClass: {
                                    popup: 'border-radius-0',
                                },
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            })
                        },
                        success: function(result) {
                            processing=false
                            Swal.fire(
                                'Successfully!',
                                'Document has been approved.',
                                'success'
                            ).then((result) => {
                                location.reload()
                            })
                        },
                        error: function(resultAjax,errorStatus,errorMessage){
                            Swal.hideLoading()
                            // Swal.fire({
                            //     title: 'Successfully!',
                            //     text: "Document has been circulated.",
                            //     icon: 'success',
                            // }).then((result) => {
                            //     location.reload()
                            // })
                        }
                    })
                }
            })
             $.ajax({
               type:"GET",
               url:"{{url('/admin/cekTTD')}}",
               data:{
                 nik:"{{Auth::User()->nik}}",
               },
               success: function(result){
                 if (result.ttd == null) {
                   $("#ModalUploadNewTTD").modal("show")
                 }else{
                   $("#ModalAcceptQuotation").modal("show")
                   $("#TTD").attr("src","{!! asset('"+result.ttd+"')!!}")
                 }
               }
             })
        })

        $("#btnReject").click(function(){
            $(".modal-dialog").removeClass("modal-lg")
            $("#ModalRejectQuotation").modal("show")
        })

        $("#btnUploadNewTTD").click(function(){
            $("#ModalAcceptQuotation").modal("hide")
            $("#ModalUploadNewTTD").modal("show")
        })

        // $("#textAreaTOP").wysihtml5();

        // const firstLaunch = localStorage.setItem('firstLaunch',true)

        function fillInput(val){
            if (val == "selectTo") {
                $("#selectTo").closest('.form-group').removeClass('has-error')
                $("#selectTo").closest('.form-group').find('.help-block').attr('style','display:none!important');
                $("#selectTo").prev('.input-group-addon').css("background-color","red");
            }else if (val == "to") {
                $("#inputTo").closest('.divInputTo').closest('.form-group').removeClass('has-error')
                $("#inputTo").closest('.divInputTo').find('.help-block').attr('style','display:none!important');
                $("#inputTo").prev('.input-group-addon').css("background-color","red");
            }else if (val == "email") {
                const validateEmail = (email) => {
                    return email.match(
                        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    )
                }

                emails = validateEmail($("#inputEmail").val())

                if ($("#inputEmail").val() == '-') {
                    $("#inputEmail").closest('.form-group').removeClass('has-error')
                    $("#inputEmail").closest('input').next('span').attr('style','display:none!important')
                    $("#inputEmail").prev('.input-group-addon').css("background-color","red")
                }else{
                    switch(emails){
                        case null:
                            $("#inputEmail").closest('.form-group').addClass('has-error')
                            $("#inputEmail").closest('input').next('span').show();
                            $("#inputEmail").prev('.input-group-addon').css("background-color","red");
                            $("#inputEmail").closest('input').next('span').text("Enter a Valid Email Address!")
                            break;
                        default:
                            $("#inputEmail").closest('.form-group').removeClass('has-error')
                            $("#inputEmail").closest('input').next('span').attr('style','display:none!important')
                    }
                }
            }else if (val == "phone") {
                $("#inputPhone").inputmask({"mask": "999-999-999-999"})
                $("#inputPhone").closest('.form-group').removeClass('has-error')
                $("#inputPhone").closest('input').next('span').attr('style','display:none!important');
                $("#inputPhone").prev('.input-group-addon').css("background-color","red");
            }else if(val == "subject") {
                $("#inputSubject").closest('.form-group').removeClass('has-error')
                $("#inputSubject").closest('input').next('span').attr('style','display:none!important');
                $("#inputSubject").prev('.input-group-addon').css("background-color","red");
            }else if(val == "attention") {
                $("#inputAttention").closest('.form-group').removeClass('has-error')
                $("#inputAttention").closest('input').next('span').attr('style','display:none!important');
                $("#inputAttention").prev('.input-group-addon').css("background-color","red");
            }else if(val == "from") {
                $("#inputFrom").closest('.form-group').removeClass('has-error')
                $("#inputFrom").closest('input').next('span').attr('style','display:none!important');
                $("#inputFrom").prev('.input-group-addon').css("background-color","red");
            }else if(val == "address") {
                $("#inputAddress").closest('.form-group').removeClass('has-error')
                $("#inputAddress").closest('input').next('span').attr('style','display:none!important');
                $("#inputAddress").prev('.input-group-addon').css("background-color","red");
            }

            if (val == "selectLeadId") {
                $("#selectLeadId").closest('.form-group').removeClass('has-error')
                $("#selectLeadId").closest('select').next('span').next('span').attr('style','display:none!important');
                $("#selectLeadId").prev('.input-group-addon').css("background-color","red");
            }

            if (val == "selectPID") {
                $("#selectPID").closest('.form-group').removeClass('has-error')
                $("#selectPID").closest('select').next('span').next('span').attr('style','display:none!important');
                $("#selectPID").prev('.input-group-addon').css("background-color","red");
            }

            if (val == "selectType") {
                $("#selectType").closest('.form-group').removeClass('has-error')
                $("#selectType").closest('select').next('span').attr('style','display:none!important');
                $("#selectType").prev('.input-group-addon').css("background-color","red");
            }

            if (val == "selectCategory") {
                $("#selectCategory").closest('.form-group').removeClass('has-error')
                $("#selectCategory").closest('select').next('span').attr('style','display:none!important');
                $("#selectCategory").prev('.input-group-addon').css("background-color","red");
            }

            if (val == "name_product") {
                $("#inputNameProduct").closest('.form-group').removeClass('has-error')
                $("#inputNameProduct").closest('input').next('span').attr('style','display:none!important');
                $("#inputNameProduct").prev('.input-group-addon').css("background-color","red");
            }
            if (val == "desc_product") {
                $("#inputDescProduct").closest('.form-group').removeClass('has-error')
                $("#inputDescProduct").closest('textarea').next('span').attr('style','display:none!important');
                $("#inputDescProduct").prev('.input-group-addon').css("background-color","red");
            }
            if (val == "qty_product") {
                if (Number($("#inputTimePeriod").val()) > 0) {
                    $("#inputTotalPrice").val(formatter.format(Number($("#inputTimePeriod").val()) * Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
                    $("#inputTotalPriceList").val(formatter.format(Number($("#inputTimePeriod").val()) * Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceList").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
                }else{
                    $("#inputTotalPriceList").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceList").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
                    $("#inputTotalPrice").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
                }
                $("#inputQtyProduct").closest('.col-md-4').removeClass('has-error')
                $("#inputQtyProduct").closest('input').next('span').hide();
                $("#inputQtyProduct").prev('.input-group-addon').css("background-color","red");
            }

            if (val == "time_period"){
                if ( Number($("#inputTimePeriod").val()) > 0) {
                    $("#inputTotalPrice").val(formatter.format(Number($("#inputTimePeriod").val()) * Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
                    $("#inputTotalPriceList").val(formatter.format(Number($("#inputTimePeriod").val()) * Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceList").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
                }else{
                    $("#inputTotalPriceList").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceList").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
                    $("#inputTotalPrice").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
                }
            }
            if (val == "price_product") {
                if ( Number($("#inputTimePeriod").val()) > 0) {
                    $("#inputTotalPrice").val(formatter.format(Number($("#inputTimePeriod").val()) * Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
                }else{
                    $("#inputTotalPrice").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
                }
                $("#inputPriceProduct").closest('.col-md-4').removeClass('has-error')
                $("#inputPriceProduct").closest('input').closest('.input-group').next('span').hide();
                $("#inputPriceProduct").prev('.col-md-4').css("background-color","red");
            }
            if (val == "price_list"){
                if ( Number($("#inputTimePeriod").val()) > 0) {
                    $("#inputTotalPriceList").val(formatter.format(Number($("#inputTimePeriod").val()) * Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceList").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
                }else{
                    $("#inputTotalPriceList").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceList").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
                }
            }
            if (val == "quoteNumber") {
                $("#inputQuoteNumber").closest('.form-group').removeClass('has-error')
                $("#inputQuoteNumber").closest('input').next('span').attr('style','display:none!important');
                $("#inputQuoteNumber").prev('.input-group-addon').css("background-color","red");
            }

            if (val == "textArea_TOP") {
                $("#textAreaTOP").closest('.form-group').removeClass('has-error')
                $("#textAreaTOP").closest('textarea').next('span').attr('style','display:none!important');
                $("#textAreaTOP").prev('.input-group-addon').css("background-color","red");
            }

            if (val == "reason_reject") {
                if (val == "reason_reject") {
                    $("#reasonRejectSirkular").closest('.form-group').removeClass('has-error')
                    $("#reasonRejectSirkular").closest('textarea').next('span').attr('style','display:none!important');
                    $("#reasonRejectSirkular").prev('.input-group-addon').css("background-color","red");
                }
            }
        }

        localStorage.setItem('isEditProduct',false)

        localStorage.setItem('isRupiah',true)
        function changeCurreny(value){
            if (value == "usd") {
                $("#inputPriceProduct").closest("div").find(".input-group-addon").text("$")
                $("#inputTotalPrice").closest("div").find("div").text("$")

                localStorage.setItem('isRupiah',false)
                $('.money').mask('#0,00', {reverse: true})

            }else{
                $("#inputPriceProduct").closest("div").find(".input-group-addon").text("Rp.")
                $("#inputTotalPrice").closest("div").find("div").text("Rp.")

                localStorage.setItem('isRupiah',true)

                $('.money').mask('#.##0,00', {reverse: true})
            }

            if (localStorage.getItem('isRupiah') == 'true') {
                $("#inputTotalPrice").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
            }else{
                $("#inputTotalPrice").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
            }
        }

        var incrementDoc = 0

        function refreshTable(){
            addTable(0,localStorage.getItem('status_tax'))
        }


        function showPdf(){
            const signatureModal = new bootstrap.Modal(document.getElementById("signatureModal"));
            signatureModal.show();
        }

        $('#customer_quote').select2({
            dropdownParent:$("#modalAdd")
        });

        $('#leadId').on('change', function(){
            $.ajax({
                url: '/sales/getDetailLead',
                type: 'GET',
                data:{
                    lead_id: $(this).val()
                },
                success: function (result) {
                    $('#customer').val(result.customer)
                    $('#no_telp').val(result.phone)
                    $('#subject').val(result.subject)
                    $('#building').val(result.office_building)
                    $('#street').val(result.street_address)
                    $('#city').val(result.city + ' - ' + result.postal)
                    // $('#address').text(result.office_building + ' ' + result.street_address + ' ' + result.city)
                    // $('#no_telp').val(result.phone)
                    // $('#subject').val(result.subject)
                    localStorage.setItem('id_customer_quote', result.id_customer)
                }
            })
        })

        function addQuote(n){
            let x = document.getElementsByClassName("tab-add");
            x[n].style.display = "inline";
            if(n == 0){
                document.getElementById("prevBtnAdd").style.display = "none";
                $("#nextBtnAdd").attr('onclick','nextPrevAdd(1)')
            }else if(n == 1){
                select2TypeProduct();
                $("nextBtnAdd").attr('onclick', 'nextPrevAdd(1)')
                $("#prevBtnAdd").attr('onclick','nextPrevAdd(-1)')
                document.getElementById('prevBtnAdd').innerText = "Back";
                document.getElementById("prevBtnAdd").style.display = "inline";
                $('.money').mask('#.##0,00', {reverse: true})
                $("#btnInitiateAddProduct").click(function(){
                    $(".tabGroupInitiateAdd").attr('style','display:none!important')
                    x[n].children[1].style.display = 'inline'
                })
            }else if (n == 2){
                $("#nextBtnAdd").removeAttr('onclick')
                $(".modal-dialog").addClass('modal-lg')

                $("#prevBtnAdd").attr('onclick','nextPrevAdd(-1)')
                $("#nextBtnAdd").attr('onclick','nextPrevAdd(1)')
                document.getElementById("prevBtnAdd").style.display = "inline";

            }else if (n == 3) {
                // if ($('.wysihtml5-toolbar').length == 0) {
                //     $("#textAreaTOP").wysihtml5({
                //         toolbar: {
                //             "font-styles": true, // Font styling, e.g. h1, h2, etc.
                //             "emphasis": true, // Italics, bold, etc.
                //             "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
                //             "html": false, // Button which allows you to edit the generated HTML.
                //             "link": false, // Button to insert a link.
                //             "image": false, // Button to insert an image.
                //             "color": false, // Button to change color of font
                //             "blockquote": false, // Blockquote
                //             "size": true // options are xs, sm, lg
                //         }
                //     });
                // }
                snowEditor = new Quill('#snow-editor', {
                    bounds: '#snow-editor',
                    modules: {
                        formula: true,
                        toolbar: '#snow-toolbar'
                    },
                    theme: 'snow'
                });

                $(".modal-title").text('Terms & Condition')
                $(".modal-dialog").removeClass('modal-lg')
                $("#prevBtnAdd").attr('onclick','nextPrevAdd(-1)')
                $("#nextBtnAdd").attr('onclick','nextPrevAdd(1)')
                document.getElementById("prevBtnAdd").style.display = "inline";
            } else {
                $(".modal-dialog").addClass('modal-lg')
                $("#prevBtnAdd").attr('onclick','nextPrevAdd(-1)')
                $(".modal-title").text('')
                document.getElementById("prevBtnAdd").style.display = "inline";
                $("#headerPreviewFinal").empty()
                document.getElementById("nextBtnAdd").innerText = "Create";
                $("#nextBtnAdd").attr('onclick','createQuote("saved")');

                $.ajax({
                    type: "GET",
                    url: "{{url('/sales/quote/getPreview')}}",
                    data: {
                        id_quote:localStorage.getItem('id_quote'),
                    },
                    success: function(result) {
                        var appendHeader = ""
                        appendHeader = appendHeader + '<div class="row mb-4">'
                        appendHeader = appendHeader + '    <div class="col-md-6">'
                        appendHeader = appendHeader + '        <div class="">To: '+ result.quote.to +'</div>'
                        appendHeader = appendHeader + '        <div class="">Email: ' + result.quote.email + '</div>'
                        appendHeader = appendHeader + '        <div class="">Phone: ' + result.quote.no_telp + '</div>'
                        appendHeader = appendHeader + '        <div class="">Attention: '+ result.quote.attention +'</div>'
                        appendHeader = appendHeader + '        <div class="" style="width:fit-content;word-wrap: break-word;">Address: '+ result.quote.address +'</div>'
                        appendHeader = appendHeader + '        <div class="">From: '+ result.quote.from +'</div>'
                        appendHeader = appendHeader + '        <div class="">Subject: '+ result.quote.title +'</div>'

                        appendHeader = appendHeader + '    </div>'
                        if (window.matchMedia("(max-width: 768px)").matches)
                        {
                            appendHeader = appendHeader + '    <div class="col-md-6">'
                            // The viewport is less than 768 pixels wide

                        } else {
                            appendHeader = appendHeader + '    <div class="col-md-6" style="text-align:end">'
                            // The viewport is at least 768 pixels wide

                        }
                        appendHeader = appendHeader + '    </div>'
                        appendHeader = appendHeader + '</div>'

                        $("#headerPreviewFinal").append(appendHeader)

                        $("#tbodyFinalPageProducts").empty()
                        var append = ""
                        var i = 0
                        $.each(result.product,function(value,item){
                            i++
                            append = append + '<tr>'
                            append = append + '<td>'
                            append = append + '<span>'+ i +'</span>'
                            append = append + '</td>'
                            append = append + '<td width="20%">'
                            append = append + "<input data-value='' disabled style='font-size: 12px; important' class='form-control' type='' name='' value='"+ item.name + "'>"
                            append = append + '</td>'
                            append = append + '<td width="35%">'
                            append = append + '<textarea disabled class="form-control" style="width: 250px;resize: none;height: 120px;font-size: 12px;">' + item.description.replaceAll("<br>","\n") + '</textarea>'
                            append = append + '</td>'
                            append = append + '<td width="10%">'
                            append = append + '<input disabled class="form-control" type="" name="" value="'+ item.qty +'" style="width:45px;font-size: 12px;">'
                            append = append + '</td>'
                            append = append + '<td width="10%">'
                            append = append + '<select disabled style="width:75px;font-size: 12px;" class="form-control">'
                            append = append + '<option>'+ item.unit.charAt(0).toUpperCase() + item.unit.slice(1) +'</option>'
                            append = append + '</select>'
                            append = append + '</td>'
                            append = append + '<td width="15%">'
                            append = append + '<input disabled class="form-control" type="" name="" value="'+ formatter.format(item.nominal) +'" style="width:100px;font-size: 12px;">'
                            append = append + '</td>'
                            append = append + '<td width="15%">'
                            append = append + '<input disabled id="grandTotalPreviewFinalPage" class="form-control grandTotalPreviewFinalPage" type="" name="" value="'+ formatter.format(item.grand_total) +'" style="width:100px;font-size: 12px;">'
                            append = append + '</td>'
                            append = append + '</tr>'
                        })

                        $("#tbodyFinalPageProducts").append(append)

                        $("#bottomPreviewFinal").empty()
                        appendBottom = ""
                        appendBottom = appendBottom + '<hr>'
                        appendBottom = appendBottom + '<div class="form-group">'
                        appendBottom = appendBottom + '<div class="row mb-4">'
                        appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                        appendBottom = appendBottom + '    <div class="pull-right">'
                        appendBottom = appendBottom + '      <span style="display: inline;margin-right: 15px;">Total</span>'
                        appendBottom = appendBottom + '      <input disabled="" type="text" style="width:150px;display: inline;text-align:right" class="form-control inputTotalPriceFinal" id="inputTotalPriceFinal" name="inputTotalPriceFinal">'
                        appendBottom = appendBottom + '    </div>'
                        appendBottom = appendBottom + '  </div>'
                        appendBottom = appendBottom + '</div>'

                        appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                        appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                        appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
                        appendBottom = appendBottom + '      <span> Vat <span id="vat_value"></span> <span class="title_service"></span></span>'
                        appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;margin-left:15px;text-align:right" class="form-control" id="vat_tax_final" name="vat_tax_final">'
                        appendBottom = appendBottom + '    </div>'
                        appendBottom = appendBottom + '  </div>'
                        appendBottom = appendBottom  + '</div>'

                        appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                        appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                        appendBottom = appendBottom + '    <div class="pull-right">'
                        appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Grand Total</span>'
                        appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;text-align:right" class="form-control inputFinalPageGrandPrice" id="inputFinalPageGrandPrice" name="inputFinalPageGrandPrice">'
                        appendBottom = appendBottom + '    </div>'
                        appendBottom = appendBottom + '  </div>'
                        appendBottom = appendBottom + '</div>'
                        appendBottom = appendBottom + '</div>'
                        appendBottom = appendBottom + '<hr>'
                        appendBottom = appendBottom + '<span style="display:block;text-align:center"><b>Terms & Condition</b></span>'
                        appendBottom = appendBottom + '<div class="form-control" id="termPreview" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221);overflow:auto"></div>'

                        $("#bottomPreviewFinal").append(appendBottom)

                        $("#termPreview").html(result.quote.term_payment.replaceAll("&lt;br&gt;","<br>"))

                        var tempVat = 0
                        var finalVat = 0
                        var tempGrand = 0
                        var finalGrand = 0
                        var tempTotal = 0
                        var sum = 0

                        $('.grandTotalPreviewFinalPage').each(function() {
                            var temp = parseFloat($(this).val() == "" ? "0" : parseFloat($(this).val().replace(/\./g,'').replace(',','.').replace(' ','')))
                            sum += temp;
                        });

                        if (result.config.tax_vat > 0) {
                            $("#vat_value").text(result.config.tax_vat + '%')
                            tempVat = formatter.format((parseFloat(sum) * result.config.tax_vat) / 100)
                            tempGrand = parseFloat(sum) +  parseFloat((parseFloat(sum) * result.config.tax_vat) / 100)
                        }else{
                            tempVat = tempVat
                            tempGrand = parseFloat(sum)
                        }

                        finalVat = tempVat

                        finalGrand = tempGrand

                        tempTotal = sum
                        $("#vat_tax_final").val(tempVat)
                        $("#inputTotalPriceFinal").val(formatter.format(sum))
                        $("#inputFinalPageGrandPrice").val(formatter.format(tempGrand))
                    }
                })

            }
            document.getElementById("nextBtnAdd").innerHTML = "Next"
            $("#nextBtnAdd").prop("disabled",false)
            $("#addProduct").attr('onclick','nextPrevAdd(-1)')
        }

        function unfinishedDraft(n,id_quote,id_config,status){
            localStorage.setItem('id_quote', id_quote)
            $.ajax({
                type: 'GET',
                url: '/sales/quote/getPreview',
                data: {
                    id_quote: id_quote,
                    id_config: id_config ? id_config : localStorage.getItem('id_version')
                },
                success: function (data) {
                    let x = document.getElementsByClassName("tab-add");
                    x[n].style.display = "inline";
                    if(n == 0){
                        document.getElementById("prevBtnAdd").style.display = "none";
                        console.log(data.quote.lead_id)
                        $("#nextBtnAdd").attr('onclick','nextPrevUnfinished(2)')
                        $('#leadId').val(data.quote.lead_id).trigger('change');
                        $('#subject').val(data.quote.title)
                        $('#position').val(data.quote.position)
                        $('#date').val(data.quote.date)
                        $('#email').val(data.quote.email)
                        $('#attention').val(data.quote.attention)
                        $('#quote_type').val(data.quote.project_type)
                        // $('#address').text(data.quote.address.replaceAll("<br>","\n"))
                        $('#building').val(data.quote.building)
                        $('#street').val(data.quote.street)
                        $('#city').val(data.quote.city)
                        $('#no_telp').val(data.quote.no_telp)
                    }else if(n == 1){
                        select2TypeProduct();
                        $("nextBtnAdd").attr('onclick', 'nextPrevUnfinished(1)')
                        $("#prevBtnAdd").attr('onclick','nextPrevUnfinished(-1)')
                        document.getElementById('prevBtnAdd').innerText = "Back";
                        document.getElementById("prevBtnAdd").style.display = "inline";
                        $('.money').mask('#.##0,00', {reverse: true})
                        $("#btnInitiateAddProduct").click(function(){
                            $(".tabGroupInitiateAdd").attr('style','display:none!important')
                            x[n].children[1].style.display = 'inline'
                        })
                    }else if (n == 2){
                        if(data.config == null || data.config == 'null'){
                            localStorage.setItem('store_tax', '')
                            localStorage.setItem('status_tax', 12)
                        }else{
                            localStorage.setItem('store_tax', data.config.id)
                            if(data.config.tax_vat != null || data.config.tax_vat > 0){
                                localStorage.setItem('status_tax', data.config.tax_vat)
                            }else{
                                localStorage.setItem('status_tax', 12)
                            }
                        }

                        $("#nextBtnAdd").removeAttr('onclick')
                        $(".modal-dialog").addClass('modal-lg')
                        addTable(0, localStorage.getItem('status_tax'))
                        $('#addProduct').attr('onclick', 'nextPrevUnfinished(-1)')
                        $("#prevBtnAdd").attr('onclick','nextPrevUnfinished(-2)')
                        $("#nextBtnAdd").attr('onclick','nextPrevUnfinished(1)')
                        document.getElementById("prevBtnAdd").style.display = "inline";

                    }else if (n == 3) {
                        snowEditor = new Quill('#snow-editor', {
                            bounds: '#snow-editor',
                            modules: {
                                formula: true,
                                toolbar: '#snow-toolbar'
                            },
                            theme: 'snow'
                        });
                        // if ($('.wysihtml5-toolbar').length == 0) {
                        //     $("#textAreaTOP").wysihtml5({
                        //         toolbar: {
                        //             "font-styles": true, // Font styling, e.g. h1, h2, etc.
                        //             "emphasis": true, // Italics, bold, etc.
                        //             "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
                        //             "html": false, // Button which allows you to edit the generated HTML.
                        //             "link": false, // Button to insert a link.
                        //             "image": false, // Button to insert an image.
                        //             "color": false, // Button to change color of font
                        //             "blockquote": false, // Blockquote
                        //             "size": true // options are xs, sm, lg
                        //         }
                        //     });
                        // }

                        if(data.quote.term_payment != null ){
                            snowEditor.clipboard.dangerouslyPasteHTML(data.quote.term_payment)
                        }
                        $(".modal-title").text('Terms & Condition')
                        $(".modal-dialog").removeClass('modal-lg')
                        $("#prevBtnAdd").attr('onclick','nextPrevUnfinished(-1)')
                        $("#nextBtnAdd").attr('onclick','nextPrevUnfinished(1)')
                        document.getElementById("prevBtnAdd").style.display = 'inline';
                        document.getElementById("nextBtnAdd").innerText = "Next";
                    } else {
                        $(".modal-dialog").addClass('modal-lg')
                        $("#prevBtnAdd").attr('onclick','nextPrevUnfinished(-1)')
                        $(".modal-title").text('')
                        document.getElementById("prevBtnAdd").style.display = "inline";
                        $("#headerPreviewFinal").empty()
                        document.getElementById("nextBtnAdd").innerText = "Create";
                        $("#nextBtnAdd").attr('onclick','createQuote("saved")');

                        var appendHeader = ""
                        appendHeader = appendHeader + '<div class="row mb-4">'
                        appendHeader = appendHeader + '    <div class="col-md-6">'
                        appendHeader = appendHeader + '        <div class="">To: '+ data.quote.to +'</div>'
                        appendHeader = appendHeader + '        <div class="">Email: ' + data.quote.email + '</div>'
                        appendHeader = appendHeader + '        <div class="">Phone: ' + data.quote.no_telp + '</div>'
                        appendHeader = appendHeader + '        <div class="">Attention: '+ data.quote.attention +'</div>'
                        appendHeader = appendHeader + '        <div class="" style="width:fit-content;word-wrap: break-word;">Address: '+ data.quote.address +'</div>'
                        appendHeader = appendHeader + '        <div class="">From: '+ data.quote.from +'</div>'
                        appendHeader = appendHeader + '        <div class="">Subject: '+ data.quote.title +'</div>'

                        appendHeader = appendHeader + '    </div>'
                        if (window.matchMedia("(max-width: 768px)").matches)
                        {
                            appendHeader = appendHeader + '    <div class="col-md-6">'
                            // The viewport is less than 768 pixels wide

                        } else {
                            appendHeader = appendHeader + '    <div class="col-md-6" style="text-align:end">'
                            // The viewport is at least 768 pixels wide

                        }
                        appendHeader = appendHeader + '    </div>'
                        appendHeader = appendHeader + '</div>'

                        $("#headerPreviewFinal").append(appendHeader)

                        $("#tbodyFinalPageProducts").empty()
                        var append = ""
                        var i = 0
                        var valueGrandTotal = 0;
                        var additionalHeaders = [];

                        function formatCurrency(value) {
                            let numericValue = parseFloat(value);
                            if (isNaN(numericValue)) numericValue = 0;
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(numericValue);
                        }

                        $.each(data.product,function(value,item){
                            if (value === 0) {

                                for (let j = 1; j <= 5; j++) {
                                    const col = item[`additional_column_${j}`];
                                    if (col && col.includes("-")) {
                                        const header = col.split("-")[0].trim();
                                        if (header) {
                                            additionalHeaders.push({ index: j, header });
                                        }
                                    }
                                }

                                let dynamicHeaderHTML = "";
                                additionalHeaders.forEach(h => {
                                    dynamicHeaderHTML += `<th>${h.header}</th>`;
                                });

                                $(".table thead tr th.dynamic-header-placeholder-preview").replaceWith(dynamicHeaderHTML);
                            }
                            i++
                            valueGrandTotal += parseFloat(item.grand_total);
                            append = append + '<tr>'
                            append = append + '<td>'
                            append = append + '<span>'+ i +'</span>'
                            append = append + '</td>'
                            append = append + '<td width="20%">'
                            append = append + "<input data-value='' disabled style='font-size: 12px; important' class='form-control' type='' name='' value='"+ item.name + "'>"
                            append = append + '</td>'
                            append = append + '<td width="35%">'
                            append = append + '<textarea disabled class="form-control" style="width: 250px;resize: none;height: 120px;font-size: 12px;">' + item.description.replaceAll("<br>","\n") + '</textarea>'
                            append = append + '</td>'
                            additionalHeaders.forEach(h => {
                                const col = item[`additional_column_${h.index}`];
                                let value = "-";
                                if (col && col.includes("-")) {
                                    value = col.split("-")[1]?.trim() || "";
                                }
                                append += `<td style="font-size: 12px;"><input type="text" readonly class="form-control" value="${value}"></td>`;
                            });
                            append = append + '<td width="10%">'
                            append = append + '<input readonly class="form-control" type="" name="" value="'+ (item.jangka_waktu ? item.jangka_waktu : '-') +'" style="width:75px;font-size: 12px;">'
                            append = append + '</td>'
                            append = append + '<td width="10%">'
                            append = append + '<input disabled class="form-control" type="" name="" value="'+ item.qty +'" style="width:45px;font-size: 12px;">'
                            append = append + '</td>'
                            append = append + '<td width="10%">'
                            append = append + '<select disabled style="width:75px;font-size: 12px;" class="form-control">'
                            append = append + '<option>'+ item.unit.charAt(0).toUpperCase() + item.unit.slice(1) +'</option>'
                            append = append + '</select>'
                            append = append + '</td>'
                            append = append + '<td width="15%">'
                            append = append + '<input disabled class="form-control" type="" name="" value="'+ formatCurrency(item.price_list) +'" style="width:100px;font-size: 12px;">'
                            append = append + '</td>'
                            append = append + '<td width="15%">'
                            append = append + '<input disabled id="grandTotalPreviewFinalPage" class="form-control " type="" name="" value="'+ formatCurrency(item.total_price_list) +'" style="width:100px;font-size: 12px;">'
                            append = append + '</td>'
                            append = append + '<td width="15%">'
                            append = append + '<input disabled class="form-control" type="" name="" value="'+ formatCurrency(item.nominal) +'" style="width:100px;font-size: 12px;">'
                            append = append + '</td>'
                            append = append + '<td width="15%">'
                            append = append + '<input disabled id="grandTotalPreviewFinalPage" class="form-control grandTotalPreviewFinalPage" type="" name="" value="'+ formatCurrency(item.grand_total) +'" style="width:100px;font-size: 12px;">'
                            append = append + '</td>'
                            append = append + '</tr>'
                        })

                        $("#tbodyFinalPageProducts").append(append)

                        $("#bottomPreviewFinal").empty()
                        appendBottom = ""
                        appendBottom = appendBottom + '<hr>'
                        appendBottom = appendBottom + '<div class="form-group">'
                        appendBottom = appendBottom + '<div class="row mb-4">'
                        appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                        appendBottom = appendBottom + '    <div class="pull-right">'
                        appendBottom = appendBottom + '      <span style="display: inline;margin-right: 15px;">Total</span>'
                        appendBottom = appendBottom + '      <input disabled="" type="text" style="width:150px;display: inline;text-align:right" class="form-control inputTotalPriceFinal" id="inputTotalPriceFinal" name="inputTotalPriceFinal">'
                        appendBottom = appendBottom + '    </div>'
                        appendBottom = appendBottom + '  </div>'
                        appendBottom = appendBottom + '</div>'

                        appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                        appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                        appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
                        appendBottom = appendBottom + '      <span> DPP Nilai Lainnya</span>'
                        appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;margin-left:15px;text-align:right" class="form-control" id="dpp_final" name="dpp_final">'
                        appendBottom = appendBottom + '    </div>'
                        appendBottom = appendBottom + '  </div>'
                        appendBottom = appendBottom  + '</div>'

                        appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                        appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                        appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
                        appendBottom = appendBottom + '      <span> PPN <span id="vat_value"></span> <span class="title_service"></span></span>'
                        appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;margin-left:15px;text-align:right" class="form-control" id="vat_tax_final" name="vat_tax_final">'
                        appendBottom = appendBottom + '    </div>'
                        appendBottom = appendBottom + '  </div>'
                        appendBottom = appendBottom  + '</div>'

                        appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                        appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                        appendBottom = appendBottom + '    <div class="pull-right">'
                        appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Grand Total</span>'
                        appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;text-align:right" class="form-control inputFinalPageGrandPrice" id="inputFinalPageGrandPrice" name="inputFinalPageGrandPrice">'
                        appendBottom = appendBottom + '    </div>'
                        appendBottom = appendBottom + '  </div>'
                        appendBottom = appendBottom + '</div>'
                        appendBottom = appendBottom + '</div>'
                        appendBottom = appendBottom + '<hr>'
                        appendBottom = appendBottom + '<span style="display:block;text-align:center"><b>Terms & Condition</b></span>'
                        appendBottom = appendBottom + '<div class="form-control" id="termConditionPreview" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221);overflow:auto"></div>'

                        $("#bottomPreviewFinal").append(appendBottom)

                        $("#termConditionPreview").html(data.quote.term_payment.replaceAll("&lt;br&gt;","<br>"))

                        var tempVat = 0
                        var finalVat = 0
                        var tempGrand = 0
                        var finalGrand = 0
                        var tempTotal = 0
                        var sum = 0
                        var tempDiscount = 0
                        var dpp = 0

                        // $('.grandTotalPreviewFinalPage').each(function() {
                        //     var temp = parseFloat($(this).val() == "" ? "0" : parseFloat($(this).val().replace(/\./g,'').replace(',','.').replace(' ','')))
                        //     sum += temp;
                        // });

                        sum += valueGrandTotal;

                        if (data.config.tax_vat == null || data.config.tax_vat == 0 || data.config.tax_vat == 'null') {
                            valueVat = 'false'
                        }else{
                            valueVat = data.config.tax_vat
                        }

                        if (!isNaN(valueVat)) {
                            if (valueVat == 12){
                                dpp = (parseFloat(sum)) * 11 / 12
                                tempVat = dpp * valueVat / 100
                            }else{
                                tempVat = (parseFloat(sum) * (parseFloat(result.config.tax_vat)/100))
                            }                            finalVat = tempVat

                            tempGrand = parseFloat(sum) +  parseFloat(tempVat)

                            tempTotal = sum

                            $('#vat_value').text(valueVat + '%')
                        }else{
                            tempGrand = sum

                            $('#vat_value').text("")
                        }

                        // if (data.config.tax_vat > 0){
                        //     tempVat = formatter.format((parseFloat(sum) * data.config.tax_vat) / 100)
                        //     tempGrand =  parseFloat(sum) + parseFloat((parseFloat(sum) * data.config.tax_vat) / 100)
                        // }else{
                        //     tempGrand = parseFloat(sum)
                        // }

                        finalVat = tempVat

                        finalGrand = tempGrand

                        tempTotal = sum

                        $('#dpp_final').val(formatCurrency(dpp))
                        $("#vat_tax_final").val(formatCurrency(tempVat))
                        $("#inputTotalPriceFinal").val(formatCurrency(sum))
                        $("#inputFinalPageGrandPrice").val(formatCurrency(tempGrand))
                        $("#inputDiscountFinal").val(tempDiscount)
                    }
                }
            })
        }

        $('#modalAdd').on('hidden.bs.modal', function () {
            $(".tab-add").css('display','none')
            currentTab = 0
            n = 0
            $(".divReasonRejectRevision").attr('style','display:none!important')
            $(this)
                .find("input,textarea,select")
                .val('')
                .prop("disabled",false)
                .end()
                .find("input[type=checkcard], input[type=radio]")
                .prop("checked", "")
                .end();
            localStorage.setItem('newVersion', true);
            localStorage.setItem('isStoreCustomer',false);
            localStorage.setItem('isEditProduct',false)
            localStorage.setItem('status_quote','')
        })

            let additionalCount = 0;
            const maxAdditional = 5;

            function addAdditionalInput() {
                if (additionalCount >= maxAdditional) {
                    Swal.fire({
                        text: 'Max 5 Additional Info',
                        icon: 'warning',
                        title: 'Warning'
                    });
                    return;
                }

                additionalCount++;
                const container = $('#additionalInputContainer');
                const inputId = 'additional' + additionalCount;

                const inputGroup = $(`
            <div class="input-group mb-2" id="group-${inputId}">
                <input type="text" class="form-control" id="${inputId}" placeholder="Header - Value ex: Serial Number - 1933420192 ">
                <button class="btn btn-danger" type="button" onclick="removeAdditionalInput('${inputId}')">-</button>
            </div>
        `);

                container.append(inputGroup);
            }

            function removeAdditionalInput(id) {
                $('#group-' + id).remove();
                additionalCount--;
            }

            let additionalInputs = [];
            $('#additionalInputContainer input').each(function (index) {
                additionalInputs[index] = $(this).val();
            });

            currentTab = 0;

        function nextPrevUnfinished(n, value) {
            valueEdit = value
            if (valueEdit == undefined) {
                if (valueEdit == 0) {
                    $(".tabGroupInitiateAdd").attr('style','display:none!important')
                    $(".tab-add")[1].children[1].style.display = 'inline'
                }
            }else{
                valueEdit = valueEdit
                if (valueEdit == true) {
                    valueEdit = 'true'
                }else if (valueEdit == false) {
                    valueEdit = 'false'
                }else{
                    valueEdit = parseFloat(valueEdit)
                }
                if (!isNaN(valueEdit)) {
                    $(".tabGroupInitiateAdd").attr('style','display:none!important')
                    $(".tab-add")[1].children[1].style.display = 'inline'
                    $.ajax({
                        type: "GET",
                        url: "{{url('/sales/quote/getProductById')}}",
                        data: {
                            id:valueEdit,
                        },
                        success: function(result) {
                            $.each(result,function(value,item){
                                $("#prevBtnAdd").css("display", "none");
                                localStorage.setItem('isEditProduct',true)
                                localStorage.setItem('id_product',item.id)
                                nominal = item.nominal
                                $("#inputNameProduct").val(item.name)
                                $("#inputDescProduct").val(item.description.replaceAll("<br>","\n"))
                                $("#inputQtyProduct").val(item.qty)
                                $("#inputTimePeriod").val(item.jangka_waktu)
                                $('#selectTypeProduct').val(item.unit)
                                select2TypeProduct(item.unit)
                                $("#inputPriceProduct").val(formatter.format(nominal))
                                $("#inputTotalPrice").val(formatter.format(item.grand_total))
                                $("#inputPriceList").val(formatter.format(item.price_list))
                                $("#inputTotalPriceList").val(formatter.format(item.total_price_list))
                                $("#inputPriceProduct").closest("div").find(".input-group-addon").text("Rp.")
                                $('#additionalInputContainer').empty();
                                additionalCount = 0;

                                for (let i = 1; i <= 5; i++) {
                                    const col = item[`additional_column_${i}`];
                                    if (col && col.trim() !== "") {
                                        addAdditionalInput();
                                        $(`#additional${additionalCount}`).val(col);
                                    }
                                }
                            })
                        }
                    })
                }
            }

            if(currentTab === 0){
                if($('#leadId').val() === ""){
                    $('#leadId').closest('.form-group').addClass('has-error')
                    $('#leadId').closest('.form-group').find('span').show();
                    $('#leadId').prev('.input-group-addon').css("background-color","red");
                }else if($('#customer').val() === ""){
                    $('#customer').closest('.form-group').addClass('has-error')
                    $('#customer').closest('.form-group').find('span').show();
                    $('#customer').prev('.input-group-addon').css("background-color","red");
                }else if($('#no_telp').val() === ""){
                    $('#no_telp').closest('.form-group').addClass('has-error')
                    $('#no_telp').closest('.form-group').find('span').show();
                    $('#no_telp').prev('.input-group-addon').css("background-color","red");
                }else if($('#email').val() === ""){
                    $('#email').closest('.form-group').addClass('has-error')
                    $('#email').closest('.form-group').find('span').show();
                    $('#email').prev('.input-group-addon').css("background-color","red");
                }else if($('#subject').val() === ""){
                    $('#subject').closest('.form-group').addClass('has-error')
                    $('#subject').closest('.form-group').find('span').show();
                    $('#subject').prev('.input-group-addon').css("background-color","red");
                }else if($('#street').val() === ""){
                    $('#street').closest('.form-group').addClass('has-error')
                    $('#street').closest('.form-group').find('span').show();
                    $('#street').prev('.input-group-addon').css("background-color","red");
                }else if($('#city').val() === ""){
                    $('#city').closest('.form-group').addClass('has-error')
                    $('#city').closest('.form-group').find('span').show();
                    $('#city').prev('.input-group-addon').css("background-color","red");
                }else if($('#attention').val() === ""){
                    $('#attention').closest('.form-group').addClass('has-error')
                    $('#attention').closest('.form-group').find('span').show();
                    $('#attention').prev('.input-group-addon').css("background-color","red");
                }else if($('#quote_type').val() === ""){
                    $('#quote_type').closest('.form-group').addClass('has-error')
                    $('#quote_type').closest('.form-group').find('span').show();
                    $('#quote_type').prev('.input-group-addon').css("background-color","red");
                }else if($('#date').val() === ""){
                    $('#date').closest('.form-group').addClass('has-error')
                    $('#date').closest('.form-group').find('span').show();
                    $('#date').prev('.input-group-addon').css("background-color","red");
                }else{
                    isStoreVersion = localStorage.getItem('newVersion');
                    if(isStoreVersion == 'true' || isStoreVersion == null){
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Save info Quotation",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No',
                        }).then((result) => {
                            if(result.isConfirmed){
                                $.ajax({
                                    type: "POST",
                                    url: "/sales/updateQuotationNewVersion",
                                    data: {
                                        _token:'{{ csrf_token() }}',
                                        lead_id: $('#leadId').val(),
                                        customer: $('#customer').val(),
                                        telp: $('#no_telp').val(),
                                        email: $('#email').val(),
                                        building: $('#building').val(),
                                        @if(Auth::user()->roles()->first()->name =='Account Executive')
                                        position: $('#position').val(),
                                        @endif
                                        street: $('#street').val(),
                                        city: $('#city').val(),
                                        subject: $('#subject').val(),
                                        attention: $('#attention').val(),
                                        quote_type: $('#quote_type').val(),
                                        id_customer: localStorage.getItem('id_customer_quote'),
                                        date: $('#date').val(),
                                        id_quote: localStorage.getItem('id_quote'),
                                        version: 'new'
                                    },
                                    beforeSend:function(){
                                        Swal.fire({
                                            title: 'Please Wait..!',
                                            text: "It's sending..",
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                            allowEnterKey: false,
                                            customClass: {
                                                popup: 'border-radius-0',
                                            },
                                            didOpen: () => {
                                                Swal.showLoading()
                                            }
                                        })
                                    },
                                    success: function (result) {
                                        Swal.close();
                                        localStorage.setItem('id_config', result);
                                        localStorage.setItem('isEditProduct', false);
                                        localStorage.setItem('newVersion', false);
                                        var x = document.getElementsByClassName("tab-add");
                                        x[currentTab].style.display = "none";
                                        currentTab = currentTab + n;
                                        unfinishedDraft(currentTab, localStorage.getItem('id_quote'), result);
                                    },
                                    error: function () {
                                        Swal.close()
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Something went wrong, please try again',
                                            icon: 'error'
                                        })
                                    }
                                })
                            }
                        })
                    }else{
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Save info Quotation",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No',
                        }).then((result) => {
                            if(result.isConfirmed){
                                $.ajax({
                                    type: "POST",
                                    url: "/sales/updateQuotationNewVersion",
                                    data: {
                                        _token:'{{ csrf_token() }}',
                                        lead_id: $('#leadId').val(),
                                        customer: $('#customer').val(),
                                        telp: $('#no_telp').val(),
                                        email: $('#email').val(),
                                        building: $('#building').val(),
                                        @if(Auth::user()->roles()->first()->name =='Account Executive')
                                        position: $('#position').val(),
                                        @endif
                                        street: $('#street').val(),
                                        city: $('#city').val(),
                                        subject: $('#subject').val(),
                                        attention: $('#attention').val(),
                                        quote_type: $('#quote_type').val(),
                                        id_customer: localStorage.getItem('id_customer_quote'),
                                        date: $('#date').val(),
                                        id_quote: localStorage.getItem('id_quote'),
                                        version: 'update',
                                        id_config: localStorage.getItem('id_config')
                                    },
                                    beforeSend:function(){
                                        Swal.fire({
                                            title: 'Please Wait..!',
                                            text: "It's sending..",
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                            allowEnterKey: false,
                                            customClass: {
                                                popup: 'border-radius-0',
                                            },
                                            didOpen: () => {
                                                Swal.showLoading()
                                            }
                                        })
                                    },
                                    success: function (result) {
                                        Swal.close();
                                        localStorage.setItem('id_config', result);
                                        localStorage.setItem('isEditProduct', false);
                                        localStorage.setItem('newVersion', false);
                                        var x = document.getElementsByClassName("tab-add");
                                        x[currentTab].style.display = "none";
                                        currentTab = currentTab + n;
                                        unfinishedDraft(currentTab, localStorage.getItem('id_quote'),result);
                                    }, error: function () {
                                        Swal.close()
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Something went wrong, please try again',
                                            icon: 'error'
                                        })
                                    }
                                })
                            }
                        })
                    }
                }
            }else if(currentTab == 1){
                if (($(".tab-add")[1].children[1].style.display == 'inline' ) == true) {
                    if (n == 1) {
                        if ($("#inputNameProduct").val() == "") {
                            $("#inputNameProduct").closest('.form-group').addClass('has-error')
                            $("#inputNameProduct").closest('input').next('span').show();
                            $("#inputNameProduct").prev('.input-group-addon').css("background-color","red");
                        } else if ($("#inputDescProduct").val() == "") {
                            $("#inputDescProduct").closest('.form-group').addClass('has-error')
                            $("#inputDescProduct").closest('textarea').next('span').show();
                            $("#inputDescProduct").prev('.input-group-addon').css("background-color","red");
                        } else if ($("#inputQtyProduct").val() == "") {
                            $("#inputQtyProduct").closest('.col-md-4').addClass('has-error')
                            $("#inputQtyProduct").closest('input').next('span').show();
                            $("#inputQtyProduct").prev('.input-group-addon').css("background-color","red");
                        } else if ($("#selectTypeProduct").val() == "" || $("#selectTypeProduct").val() == null) {
                            $("#selectTypeProduct").closest('.col-md-4').addClass('has-error')
                            $("#selectTypeProduct").closest('select').next('span').next('span').show();
                            $("#selectTypeProduct").prev('.input-group-addon').css("background-color","red");
                        } else if ($("#inputPriceProduct").val() == "") {
                            $("#inputPriceProduct").closest('.col-md-4').addClass('has-error')
                            $("#inputPriceProduct").closest('input').closest('.input-group').next('span').show();
                            $("#inputPriceProduct").prev('.col-md-4').css("background-color","red");
                        } else{
                            if (localStorage.getItem('isEditProduct') == 'true') {
                                $('#additionalInputContainer input').each(function (index) {
                                    additionalInputs[index] = $(this).val();
                                });
                                $.ajax({
                                    url: "{{url('/sales/updateProductQuote')}}",
                                    type: 'post',
                                    data: {
                                        _token:"{{ csrf_token() }}",
                                        id:localStorage.getItem('id_product'),
                                        id_quote: localStorage.getItem('id_quote'),
                                        nameProduct: $("#inputNameProduct").val(),
                                        descProduct: $("#inputDescProduct").val().replaceAll("\n", "<br>"),
                                        timePeriod: $("#inputTimePeriod").val(),
                                        qtyProduct: $("#inputQtyProduct").val(),
                                        typeProduct: $("#selectTypeProduct").val(),
                                        priceProduct: $("#inputPriceProduct").val().replace(/\./g, '').replace(',', '.').replace(' ', ''),
                                        priceList: $("#inputPriceList").val().replace(/\./g, '').replace(',', '.').replace(' ', ''),
                                        totalPrice: $("#inputTotalPrice").val().replace(/\./g, '').replace(',', '.').replace(' ', ''),
                                        inputGrandTotalProduct: $("#inputGrandTotalProduct").val(),
                                        additional1: additionalInputs[0],
                                        additional2: additionalInputs[1],
                                        additional3: additionalInputs[2],
                                        additional4: additionalInputs[3],
                                        additional5: additionalInputs[4],
                                    },beforeSend:function(){
                                        Swal.fire({
                                            title: 'Please Wait..!',
                                            text: "It's sending..",
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                            allowEnterKey: false,
                                            customClass: {
                                                popup: 'border-radius-0',
                                            },
                                            didOpen: () => {
                                                Swal.showLoading()
                                            }
                                        })
                                    },success:function(){
                                        Swal.close()
                                        var x = document.getElementsByClassName("tab-add");
                                        x[currentTab].style.display = "none";
                                        currentTab = currentTab + n;
                                        if (currentTab >= x.length) {
                                            x[n].style.display = "none";
                                            currentTab = 0;
                                        }
                                        unfinishedDraft(currentTab, localStorage.getItem('id_quote'), localStorage.getItem('id_config'));
                                        addTable(0,localStorage.getItem('status_tax'))
                                        localStorage.setItem('isEditProduct',false)
                                        localStorage.setItem('status_quote','draft')
                                        $(".tabGroupInitiateAdd").show()
                                        $(".tab-add")[1].children[1].style.display = 'none'
                                        document.getElementsByClassName('tabGroupInitiateAdd')[0].childNodes[1].style.display = 'flex'
                                        $("#inputNameProduct").val('')
                                        $("#inputDescProduct").val('')
                                        $("#inputPriceProduct").val('')
                                        $("#inputQtyProduct").val('')
                                        $("#inputTotalPrice").val('')
                                        $("#inputPriceList").val('')
                                        $("#inputTotalPriceList").val('')
                                        $("#selectTypeProduct").val('')
                                        $("#inputTimePeriod").val('')
                                        $('#additionalInputContainer').empty();
                                    },
                                    error: function () {
                                        Swal.close()
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Something went wrong, please try again',
                                            icon: 'error'
                                        })
                                    }
                                })
                            }else {
                                $('#additionalInputContainer input').each(function (index) {
                                    additionalInputs[index] = $(this).val();
                                });
                                $.ajax({
                                    url: "{{url('/sales/storeProductQuote')}}",
                                    type: 'post',
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        id_quote: localStorage.getItem('id_quote'),
                                        nameProduct: $("#inputNameProduct").val(),
                                        descProduct: $("#inputDescProduct").val().replaceAll("\n", "<br>"),
                                        qtyProduct: $("#inputQtyProduct").val(),
                                        typeProduct: $("#selectTypeProduct").val(),
                                        timePeriod: $("#inputTimePeriod").val(),
                                        priceProduct: $("#inputPriceProduct").val().replace(/\./g, '').replace(',', '.').replace(' ', ''),
                                        priceList: $("#inputPriceList").val().replace(/\./g, '').replace(',', '.').replace(' ', ''),
                                        totalPrice: $("#inputTotalPrice").val().replace(/\./g, '').replace(',', '.').replace(' ', ''),
                                        inputGrandTotalProduct: $("#inputGrandTotalProduct").val(),
                                        id_config: localStorage.getItem('id_config'),
                                        additional1: additionalInputs[0] ,
                                        additional2: additionalInputs[1] ,
                                        additional3: additionalInputs[2] ,
                                        additional4: additionalInputs[3] ,
                                        additional5: additionalInputs[4] ,
                                    },
                                    beforeSend: function () {
                                        Swal.fire({
                                            title: 'Please Wait..!',
                                            text: "It's sending..",
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                            allowEnterKey: false,
                                            customClass: {
                                                popup: 'border-radius-0',
                                            },
                                            didOpen: () => {
                                                Swal.showLoading()
                                            }
                                        })
                                    }, success: function () {
                                        Swal.close()
                                        let x = document.getElementsByClassName("tab-add");
                                        x[currentTab].style.display = "none";
                                        currentTab = currentTab + n;
                                        if (currentTab >= x.length) {
                                            x[n].style.display = "none";
                                            currentTab = 0;
                                        }
                                        unfinishedDraft(currentTab, localStorage.getItem('id_quote'),localStorage.getItem('id_config'));
                                        localStorage.setItem('status_quote', 'draft')
                                        addTable(0, localStorage.getItem('status_tax'))
                                        $("#inputNameProduct").val('')
                                        $("#inputDescProduct").val('')
                                        $("#inputPriceProduct").val('')
                                        $("#inputQtyProduct").val('')
                                        $("#inputTotalPrice").val('')
                                        $("#inputTotalPriceList").val('')
                                        $("#inputPriceList").val('')
                                        $("#selectTypeProduct").val('')
                                        $("#inputTimePeriod").val('')
                                        $('#additionalInputContainer').empty();
                                        $(".tabGroupInitiateAdd").show()
                                        x[n].children[1].style.display = 'none'
                                        document.getElementsByClassName('tabGroupInitiateAdd')[0].childNodes[1].style.display = 'flex'
                                    },
                                    error: function () {
                                        Swal.close()
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Something went wrong, please try again',
                                            icon: 'error'
                                        })
                                    }
                                })
                            }
                        }
                    }else{
                        $(".tabGroupInitiateAdd").show()
                        let x = document.getElementsByClassName("tab-add");
                        x[1].children[1].style.display = 'none'
                        document.getElementsByClassName('tabGroupInitiateAdd')[0].childNodes[1].style.display = 'flex'
                    }
                }else{
                    if ($('#uploadCsv').val() == "") {
                        var x = document.getElementsByClassName("tab-add");
                        x[currentTab].style.display = "none";
                        currentTab = currentTab + n;
                        if (currentTab >= x.length) {
                            x[n].style.display = "none";
                            currentTab = 0;
                        }
                        unfinishedDraft(currentTab, localStorage.getItem('id_quote'),localStorage.getItem('id_config'));
                    }else{
                        var dataForm = new FormData();
                        dataForm.append('csv_file',$('#uploadCsv').prop('files')[0]);
                        dataForm.append('_token','{{ csrf_token() }}');
                        dataForm.append('id_quote',localStorage.getItem('id_quote'));
                        dataForm.append('id_config', localStorage.getItem('id_config'));
                        dataForm.append('new_version', true);
                        $.ajax({
                            processData: false,
                            contentType: false,
                            url: "{{url('/sales/quote/uploadCSV')}}",
                            type: 'POST',
                            data: dataForm,
                            beforeSend:function(){
                                Swal.fire({
                                    title: 'Please Wait..!',
                                    text: "It's sending..",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                    customClass: {
                                        popup: 'border-radius-0',
                                    },
                                    didOpen: () => {
                                        Swal.showLoading()
                                    }
                                })
                            },success:function(result){
                                Swal.close()
                                //nge reset upload csv
                                cancelUploadCsv()
                                if (result.status == "Error") {
                                    // reasonReject(result.text,"block","tabGroupInitiateAdd")
                                }else{
                                    var x = document.getElementsByClassName("tab-add");
                                    x[currentTab].style.display = "none";
                                    currentTab = currentTab + n;
                                    if (currentTab >= x.length) {
                                        x[n].style.display = "none";
                                        currentTab = 0;
                                    }
                                    unfinishedDraft(currentTab, localStorage.getItem('id_quote'),localStorage.getItem('id_config'));
                                    addTable(0,localStorage.getItem('status_tax'))
                                    // localStorage.setItem('status_pr','draft')
                                }
                            },
                            error: function () {
                                Swal.close()
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong, please try again',
                                    icon: 'error'
                                })
                            }
                        })
                    }
                }
            } else if(currentTab == 2){
                if (n == 1){
                        $.ajax({
                            type:"POST",
                            url:"{{url('/sales/quote/updateTaxNewVersion')}}",
                            data:{
                                _token:"{{csrf_token()}}",
                                id: localStorage.getItem('id_config'),
                                id_quote:localStorage.getItem('id_quote'),
                                discount:localStorage.getItem('discount')==0?0:localStorage.getItem('discount'),
                                status_tax:localStorage.getItem('status_tax'),
                                grand_total: $('#inputGrandTotalProductFinal').val(),
                            },
                            beforeSend:function(){
                                Swal.fire({
                                    title: 'Please Wait..!',
                                    text: "It's sending..",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                    customClass: {
                                        popup: 'border-radius-0',
                                    },
                                    didOpen: () => {
                                        Swal.showLoading()
                                    }
                                })
                            },
                            success: function(result){
                                Swal.close()
                                $(".divReasonRejectRevision").remove()
                                localStorage.setItem('store_tax', result);
                                var x = document.getElementsByClassName("tab-add");
                                x[currentTab].style.display = "none";
                                currentTab = currentTab + n;
                                if (currentTab >= x.length) {
                                    x[n].style.display = "none";
                                    currentTab = 0;
                                }
                                unfinishedDraft(currentTab, localStorage.getItem('id_quote'),localStorage.getItem('id_config'));
                                localStorage.setItem('status_quote','draft')
                            },
                            error: function () {
                                Swal.close()
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong, please try again',
                                    icon: 'error'
                                })
                            }
                        })
                }else{
                    var x = document.getElementsByClassName("tab-add");
                    x[currentTab].style.display = "none";
                    currentTab = currentTab + n;
                    if (currentTab >= x.length) {
                        x[n].style.display = "none";
                        currentTab = 0;
                    }
                    unfinishedDraft(currentTab, localStorage.getItem('id_quote'), localStorage.getItem('id_config'));
                }

            } else if(currentTab == 3){
                if (n == 1) {
                    if (snowEditor.getText().trim() == "") {
                        $("#snow-editor").next('span').show()
                    }else{
                        $("#snow-editor").next('span').attr('style','display:none!important')

                        $.ajax({
                            url: "{{'/sales/quote/storeTermPayment'}}",
                            type: 'post',
                            data:{
                                id_quote:localStorage.getItem('id_quote'),
                                _token:"{{csrf_token()}}",
                                term_payment:snowEditor.root.innerHTML,
                            },
                            success: function(data)
                            {
                                var x = document.getElementsByClassName("tab-add");
                                x[currentTab].style.display = 'none';
                                currentTab = currentTab + n;
                                if (currentTab >= x.length) {
                                    x[n].style.display = 'none';
                                    currentTab = 0;
                                }
                                unfinishedDraft(currentTab, localStorage.getItem('id_quote'), localStorage.getItem('id_config'));
                            },
                            error: function () {
                                Swal.close()
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong, please try again',
                                    icon: 'error'
                                })
                            }
                        });
                    }
                }else{
                    var x = document.getElementsByClassName("tab-add");
                    x[currentTab].style.display = "none";
                    currentTab = currentTab + n;
                    if (currentTab >= x.length) {
                        x[n].style.display = "none";
                        currentTab = 0;
                    }
                    unfinishedDraft(currentTab, localStorage.getItem('id_quote'), localStorage.getItem('id_config'));
                }
            }else{
                var x = document.getElementsByClassName("tab-add");
                x[currentTab].style.display = "none";
                currentTab = currentTab + n;
                if (currentTab >= x.length) {
                    x[n].style.display = "none";
                    currentTab = 0;
                }
                unfinishedDraft(currentTab, localStorage.getItem('id_quote'), localStorage.getItem('id_config'));
            }
        }

        function addTable(n,status,results=""){
            $.ajax({
                type: "GET",
                url: '{{url('/sales/quote/getProductQuoteNewVersion')}}',
                data: {
                    id_quote:localStorage.getItem('id_quote'),
                    id_config: localStorage.getItem('id_config')
                },
                success: function(result) {
                    var i = 0
                    var valueEdit = 0
                    var append = ""
                    $("#tbodyProducts").empty()
                    $.each(result.data,function(value,item){
                        i++;
                        valueEdit++;
                        append = append + '<tr>'
                        append = append + '<td>'
                        append = append + '<span style="font-size: 12px; important">'+ i +'</span>'
                        append = append + '</td>'
                        append = append + '<td width="20%">'
                        append = append + "<input id='inputNameProductEdit' data-value='' disabled style='font-size: 12px; important' class='form-control' type='' name='' value='"+ item.name + "'>"
                        append = append + '</td>'
                        append = append + '<td width="30%">'
                        append = append + '<textarea id="textAreaDescProductEdit" disabled data-value="" style="font-size: 12px; important;resize:none;height:150px;width:150px;" class="form-control">'+ item.description.replaceAll("<br>","\n") + '&#10;'
                        append = append + '</textarea>'
                        append = append + '</td>'
                        append = append + '<td width="10%">'
                        append = append + '<input id="inputTimePeriodEdit" data-value="" readonly style="font-size: 12px; important;width:70px" class="form-control" type="number" name="" value="'+ item.jangka_waktu +'">'
                        append = append + '</td>'
                        append = append + '<td width="7%">'
                        append = append + '<input id="inputQtyEdit" data-value="" disabled style="font-size: 12px; important;width:70px" class="form-control" type="number" name="" value="'+ item.qty +'">'
                        append = append + '</td>'
                        append = append + '<td width="10%">'
                        append = append + '<select id="inputTypeProductEdit" disabled data-value="" style="font-size: 12px; important;width:70px" class="form-control">'
                        append = append + '<option>'+ item.unit.charAt(0).toUpperCase() + item.unit.slice(1) +'<option>'
                        append = append + '</select>'
                        append = append + '</td>'
                        append = append + '<td width="15%">'
                        append = append + '<input id="inputPriceList" disabled data-value="" style="font-size: 12px;width:100px" class="form-control" type="" name="" value="'+ formatter.format(item.price_list) +'">'
                        append = append + '</td>'
                        append = append + '<td width="15%">'
                        append = append + '<input id="inputTotalPriceList" disabled data-value="" style="font-size: 12px;width:100px" class="form-control" type="" name="" value="'+ formatter.format(item.total_price_list) +'">'
                        append = append + '</td>'
                        append = append + '<td width="15%">'
                        append = append + '<input id="inputPriceEdit" disabled data-value="" style="font-size: 12px;width:100px" class="form-control" type="" name="" value="'+ formatter.format(item.nominal) +'">'
                        append = append + '</td>'
                        append = append + '<td width="15%">'
                        append = append + '<input id="inputTotalPriceEdit" disabled data-value="" style="font-size: 12px;width:100px" class="form-control inputTotalPriceEdit" type="" name="" value="'+ formatter.format(item.grand_total) +'">'
                        append = append + '</td>'
                        append = append + '<td width="8%">'
                        btnNext = 'nextPrevUnfinished(-1,'+ item.id +')'
                        append = append + '<button type="button" onclick="'+ btnNext +'" id="btnEditProduk" data-id="'+ value +'" data-value="'+ valueEdit +'" class="btn btn-sm btn-xs btn-warning bx bx-edit btnEditProduk" style="width:25px;height:25px;margin-bottom:5px"></button>'
                        append = append + '<button id="btnDeleteProduk" type="button" data-id="'+ item.id+'" data-value="'+ value +'" class="btn btn-sm btn-xs btn-danger bx bx-trash" style="width:25px;height:25px"></button>'
                        append = append + '</td>'
                        append = append + '</tr>'
                    })

                    $("#tbodyProducts").append(append)

                    scrollTopModal()

                    $("#bottomProducts").empty()

                    var appendBottom = ""
                    appendBottom = appendBottom + '<hr>'
                    appendBottom = appendBottom + '<div class="row mb-4">'
                    appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                    appendBottom = appendBottom + '    <div class="pull-right">'
                    appendBottom = appendBottom + '      <span style="display: inline;margin-right: 15px;">Total</span>'
                    appendBottom = appendBottom + '      <input disabled="" type="text" style="width:250px;display: inline;" class="form-control inputTotalProduct" id="inputGrandTotalProduct" name="inputGrandTotalProduct">'
                    appendBottom = appendBottom + '    </div>'
                    appendBottom = appendBottom + '  </div>'
                    appendBottom = appendBottom + '</div>'

                    // appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                    // appendBottom = appendBottom + '<div class="col-md-12 col-xs-12">'
                    // appendBottom = appendBottom + ' <div class="pull-right">'
                    // appendBottom = appendBottom + '  <span style="margin-right: 15px;">Vat <span class="title_tax"></span>'
                    // appendBottom = appendBottom + '  </span>'
                    // appendBottom = appendBottom + '  <div class="input-group" style="display: inline-flex;">'
                    // appendBottom = appendBottom + '   <input disabled="" type="text" class="form-control vat_tax" id="vat_tax" name="vat_tax" style="width:217px;display:inline">'
                    // appendBottom = appendBottom + '  <div class="input-group-btn">'
                    // appendBottom = appendBottom + '       <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">'
                    // appendBottom = appendBottom + '         <span class="bx bx-caret-down"></span>'
                    // appendBottom = appendBottom + '       </button>'
                    // appendBottom = appendBottom + '       <ul class="dropdown-menu">'
                    // appendBottom = appendBottom + '       <li>'
                    // appendBottom = appendBottom + '        <a onclick="changeVatValue(false)">Without Vat</a>'
                    // appendBottom = appendBottom + '       </li>'
                    // appendBottom = appendBottom + '       <li>'
                    // appendBottom = appendBottom + '        <a onclick="changeVatValue(11)">Vat 11%</a>'
                    // appendBottom = appendBottom + '       </li>'
                    // appendBottom = appendBottom + '       <li>'
                    // appendBottom = appendBottom + '        <a onclick="changeVatValue(12)">Vat 12%</a>'
                    // appendBottom = appendBottom + '       </li>'
                    // appendBottom = appendBottom + '      </ul>'
                    // appendBottom = appendBottom + '     </div>'
                    // appendBottom = appendBottom + '    </div>'
                    // appendBottom = appendBottom + '  </div>'
                    // appendBottom = appendBottom + '</div>'
                    // appendBottom = appendBottom + '</div>'

                    appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                    appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                    appendBottom = appendBottom + '    <div class="pull-right">'
                    appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">DPP Nilai Lainnya</span>'
                    appendBottom = appendBottom + '      <input disabled type="text" style="width:250px;display: inline;" class="form-control dpp" id="dpp" name="dpp">'
                    appendBottom = appendBottom + '    </div>'
                    appendBottom = appendBottom + '  </div>'
                    appendBottom = appendBottom  + '</div>'

                    appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                    appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                    appendBottom = appendBottom + '    <div class="pull-right">'
                    appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">PPN <span class="title_tax"></span></span>'
                    appendBottom = appendBottom + '      <input disabled type="text" style="width:250px;display: inline;" class="form-control vat_tax" id="vat_tax" name="vat_tax">'
                    appendBottom = appendBottom + '    </div>'
                    appendBottom = appendBottom + '  </div>'
                    appendBottom = appendBottom  + '</div>'

                    appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                    appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                    appendBottom = appendBottom + '    <div class="pull-right">'
                    appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Grand Total</span>'
                    appendBottom = appendBottom + '      <input disabled type="text" style="width:250px;display: inline;" class="form-control inputGrandTotalProductFinal" id="inputGrandTotalProductFinal" name="inputGrandTotalProductFinal">'
                    appendBottom = appendBottom + '    </div>'
                    appendBottom = appendBottom + '  </div>'
                    appendBottom = appendBottom  + '</div>'

                    $("#bottomProducts").append(appendBottom)

                    if (status != "") {
                        changeVatValue(status)
                    }
                    if(localStorage.getItem('store_tax') == "" || localStorage.getItem('store_tax') == null){
                        toggleIcheckPajak(false)
                    }else{
                        $.ajax({
                            type: 'GET',
                            url: '{{url('/sales/quote/getTax')}}',
                            data:{
                                id_tax: localStorage.getItem('store_tax')
                            },
                            success: function (results) {
                                setTimeout(function(argument) {
                                    if (results.data.nominal != null){
                                        changeValueGrandTotal(parseFloat(results.data.nominal.replace(',', '.')))
                                    }
                                },500)
                                if (results.data.discount == 0 || results.data.discount == null) {
                                    toggleIcheckPajak(false)
                                }else{
                                    $("#inputDiscountNominal").val(formatter.format(($("#inputGrandTotalProduct").val() == ""?0:parseFloat($("#inputGrandTotalProduct").val().replace(/\./g,'').replace(',','.').replace(' ','')) * results.data.discount / 100)))
                                    setTimeout(function(){
                                        $("#inputDiscountProduct").val(parseFloat(results.data.discount).toFixed(2))
                                    },500)
                                    toggleIcheckPajak(true)
                                    $("#cbInputDiscountProduct").prop('checked',true);
                                }

                                localStorage.setItem('discount',parseFloat(results.data.discount))
                            }
                        })
                    }

                    $(document).on("click", "#btnDeleteProduk", function() {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Deleting Product",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No',
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    type: "POST",
                                    url: "{{url('/sales/quote/deleteProduct')}}",
                                    data:{
                                        _token:'{{ csrf_token() }}',
                                        id:$(this).data("id")
                                    },
                                    beforeSend:function(){
                                        Swal.fire({
                                            title: 'Please Wait..!',
                                            text: "It's sending..",
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                            allowEnterKey: false,
                                            customClass: {
                                                popup: 'border-radius-0',
                                            },
                                        })
                                        Swal.showLoading()
                                    },
                                    success: function(result) {
                                        Swal.fire(
                                            'Successfully!',
                                            'Delete Product.',
                                            'success'
                                        ).then((result) => {
                                            refreshTable()
                                        })
                                    }
                                })
                            }
                        })
                    })

                    // $('input[type="checkcard"].minimal').iCheck({
                    //     checkcardClass: 'icheckcard_minimal-blue',
                    // })

                    $("#inputPb1Product").inputmask({
                        alias:"percentage",
                        integerDigits:2,
                        digits:2,
                        allowMinus:false,
                        digitsOptional: false,
                        placeholder: "0"
                    });

                    $("#inputServiceChargeProduct").inputmask({
                        alias:"percentage",
                        integerDigits:2,
                        digits:2,
                        allowMinus:false,
                        digitsOptional: false,
                        placeholder: "0"
                    });

                    $("#inputDiscountProduct").inputmask({
                        alias:"percentage",
                        integerDigits:2,
                        digits:2,
                        allowMinus:false,
                        digitsOptional: false,
                        placeholder: "0"
                    });
                }
            })
        }

        function scrollTopModal(){
            var savedScrollPosition = localStorage.getItem('scrollPosition');
            var scrollableElement = document.getElementById('modalAdd');
            scrollableElement.scrollTop = savedScrollPosition;
        }

        function createQuote(status){
            if ($("#inputFinalPageGrandPrice").val() == '0') {
                Swal.fire({
                    title: 'Alert',
                    text: "Please to add some products.",
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                })
            }else{
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Submit Quotation",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: 'Please Wait..!',
                            text: "It's sending..",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            customClass: {
                                popup: 'border-radius-0',
                            },
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        })
                        $.ajax({
                            type:"POST",
                            url:"{{url('/sales/quote/storeLastStepQuoteNewVersion')}}",
                            data:{
                                _token:"{{csrf_token()}}",
                                id_quote:localStorage.getItem('id_quote'),
                                id_config: localStorage.getItem('id_config'),
                                status_revision:status,
                                isRupiah:localStorage.getItem("isRupiah"),
                            },
                            success: function(result){
                                if(result.message === 'success'){
                                    localStorage.setItem('newVersion', true)
                                    Swal.fire({
                                        title: 'Add Quotation Successs',
                                        html: "<p style='text-align:center;'>Your Quotation will be verified by manager soon, please wait for further progress</p>",
                                        type: 'success',
                                        confirmButtonText: 'Reload',
                                    }).then((result) => {
                                        localStorage.setItem('status_quote','')
                                        location.reload()
                                    })
                                }
                            },
                            error: function () {
                                Swal.close()
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong, please try again',
                                    icon: 'error'
                                })
                            }
                        })
                    }
                })
            }
        }

        function toggleIcheckPajak(value){

            $('#cbInputDiscountProduct').on('change', function(event){
                if ($('#cbInputDiscountProduct').is(":checked")) {
                    $("#inputDiscountNominal").prop("disabled",false)
                }
            });

            $('#cbInputDiscountProduct').on('change', function(event){
                if (!$('#cbInputDiscountProduct').is(":checked")) {
                    $("#inputDiscountNominal").prop("disabled",true)
                    if (value == false) {
                        $("#inputDiscountNominal").val(0)
                        changeVatValue("discount")
                    }
                }
            });
        }

        function changeVatValue(value=false){
            var tempVat = 0
            var finalVat = 0
            var tempGrand = 0
            var tempDiscount = 0
            var finalGrand = 0
            var tempTotal = 0
            var sum = 0
            var dpp = 0

            $('.inputTotalPriceEdit').each(function() {
                var temp = parseFloat($(this).val() == "" ? "0" : parseFloat($(this).val().replace(/\./g,'').replace(',','.').replace(' ','')))
                sum += temp;
            });

            $("#inputGrandTotalProduct").val(formatter.format(sum))

            if (value == false) {
                valueVat = ''
                // if ($("#inputDiscountNominal").val() != "") {
                //     tempDiscount = $("#inputDiscountNominal").val() == 0?false:parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ','') / parseFloat(sum) * 100)
                // }
            }else{
                if (value == 'discount') {
                    // if ($("#inputDiscountNominal").val() == "") {
                    //     tempDiscount = tempDiscount
                    // } else {
                    //     tempDiscount = $("#inputDiscountNominal").val() == 0?false:parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ','') / parseFloat(sum) * 100)
                    // }
                }else{
                    valueVat = value
                    // if ($("#inputDiscountNominal").val() != "") {
                    //     tempDiscount = $("#inputDiscountNominal").val() == 0?false:parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ','') / parseFloat(sum) * 100)
                    // }
                }
            }

            $('.money').mask('#.##0,00', {reverse: true})

            if (!isNaN(valueVat)) {
                setTimeout(function(){
                    if (valueVat == 12){
                        dpp = (parseFloat(sum)) * (11 / 12)
                        tempVat = dpp * valueVat / 100
                    }else{
                        tempVat = (parseFloat(sum)) * (valueVat == false?0:parseFloat(valueVat) / 100)
                    }
                    finalVat = tempVat

                    finalGrand = tempGrand

                    tempTotal = parseFloat(sum)

                    $('.title_tax').text(valueVat == '' || valueVat == null ?"":valueVat + '%')

                    $("#vat_tax").val(formatter.format(isNaN(tempVat)?0:tempVat.toFixed(2)))
                    $("#dpp").val(formatter.format(isNaN(dpp)?0:dpp.toFixed(2)))
                },500)
            }else{
                tempVat = 0
                $("#vat_tax").val(formatter.format(tempVat.toFixed(2)))

                finalVat = tempVat

                finalGrand = tempGrand

                tempTotal = parseFloat(sum)

                $('.title_tax').text($("#vat_tax").val() == "" ||$("#vat_tax").val() == 0?"":$('.title_tax').text().replace("%","") + '%')
            }

            setTimeout(function(){
                // tempDiscNominal = isNaN(parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ','')))?0:parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ',''))

                $("#inputDiscountProduct").val(tempDiscount)

                tempGrand = tempTotal + tempVat //- tempDiscNominal

                changeValueGrandTotal(isNaN(tempGrand)?0:tempGrand.toFixed(2))
            },500)

            localStorage.setItem('status_tax',valueVat)
            localStorage.setItem('discount',tempDiscount == ''?0:tempDiscount)
        }

        function changeValueGrandTotal(grandTotal){
            $("#inputGrandTotalProductFinal").val(formatter.format(grandTotal))
        }

    </script>
@endsection