@extends('template.main_sneat')
@section('tittle')
  Draft Purchase Request
@endsection
@section('pageName')
  Draft List Purchase Request
@endsection
@section('head_css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.min.css" integrity="sha512-Bhi4560umtRBUEJCTIJoNDS6ssVIls7oiYyT3PbhxZV+9uBbLVO/mWo56hrBNNbIfMXKvtIPJi/Jg+vpBpA7sg==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/typography.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/katex.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/editor.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<style type="text/css">
  .textarea-scrollbar {
      /*overflow:scroll !important;*/    
      overflow-y: scroll !important;
      resize: none !important;
      -ms-overflow-style: scrollbar; 
  }

  .textarea-scrollbar::-webkit-scrollbar {
      width: 12px;
  }

  .textarea-scrollbar::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-card-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
    background-color: #555;
  }

  .textarea-scrollbar::-webkit-scrollbar {
    width: 12px;
  }

 /* .icheckbox_-blue{
    margin-left: 147px;
  }*/

  .checkbox label{
    padding-left: 0px!important;
  }

  input[type=file]::-webkit-file-upload-button{
   display: none;
  }

  input::file-selector-button {
   display: none;
  }

  .dataTables_filter {
    display: none;
  }

  #selectPid {
    text-transform:uppercase;
  }

  #draftPr tr td {
    padding-bottom:25px;
  }

  .form-group{
    margin-bottom: 15px;
  }

  .swal2-container {
    z-index: 9999 !important;
  }

  .pull-right{
    float: right;
  }

  #inputDiscountProduct,#inputPb1Product,#inputServiceChargeProduct{
    border-top-left-radius: 0px;
    border-bottom-left-radius: 0px;
  }

  #inputDiscountNominal,#inputPb1Nominal,#inputServiceChargeNominal{
    border-top-right-radius: 0px;
    border-bottom-right-radius: 0px;
  }

  .input-group{
    margin-bottom: 15px;
  }

  .swal2-deny{
    display: none!important;
  }

  .select2-container {
    z-index: 1055 !important; /* modal default: 1050 */
  }

  .select2-dropdown {
    z-index: 1060 !important;
  }
</style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <section class="content">
    <div class="row mb-4" id="BoxId">
      <!--card id-->
    </div>
    <div class="row mb-4">
      <div class="col-lg-12 col-xs-12">
        <div class="card">
          <div class="card-header with-border" style="text-align:right;">
            <button class="btn btn-sm btn-primary" style="display:none!important;" dusk="addDraftPr" id="addDraftPr" onclick="addDraftPr(0)" ><i class="icon-base bx bx-plus"></i> Draft PR</button>
          </div>
          <div class="card-body">
            <div class="row mb-4" style="margin-bottom:10px" id="filterBox">
              <div class="col-md-2 col-xs-12">
                <div class="form-group">
                  <label>Filter by Type PR : </label>
                  <select class="form-control select2" id="inputFilterTypePr" onchange="searchCustom()" style="width:100%" tabindex="-1" aria-hidden="true">
                  </select>
                </div>
              </div>

              <div class="col-md-2 col-xs-12">
                <div class="form-group">
                  <label>Filter by Status : </label>
                  <select class="form-control select2" id="inputFilterStatus" onchange="searchCustom()" style="width:100%" tabindex="-1" aria-hidden="true"></select>
                </div>
              </div>

              <div class="col-md-2 col-xs-12" id="filterUser" style="display:none!important">
                <div class="form-group">
                  <label>Filter by User : </label>
                  <select class="form-control select2" id="inputFilterUser" onchange="searchCustom()" style="width:100%" tabindex="-1" aria-hidden="true"></select>
                </div>
              </div>

              <div class="col-md-2 col-xs-12">
                <div class="form-group">
                  <label>Range Date PR : </label>
                  <button type="button" class="btn btn-sm btn-outline-secondary btn-flat pull-left" style="width:100%;" id="inputRangeDate">
                    <i class="bx bx-calendar"></i> Date range
                    <span>
                      <i class="bx bx-caret-down"></i>
                    </span>
                  </button>
                </div>
              </div>
              
              <div class="col-md-4 col-xs-12">
                <div class="form-group">
                  <label>Search Anything : </label>
                  <div class="input-group">
                    <input id="inputSearchAnything" onchange="searchCustom()" type="text" class="form-control" placeholder="ex: PR Id">
                    <button id="btnShowEntryTicket" class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Show 100 </button>
                    <ul class="dropdown-menu" id="selectShowEntryTicket">
                      <li id="10"><a class="dropdown-item" href="#" onclick="changeNumberEntries(10)">10</a></li>
                      <li id="25"><a class="dropdown-item" href="#" onclick="changeNumberEntries(25)">25</a></li>
                      <li id="50"><a class="dropdown-item" href="#" onclick="changeNumberEntries(50)">50</a></li>
                      <li id="100" class="active"><a class="dropdown-item" href="#" onclick="changeNumberEntries(100)">100</a></li>
                    </ul>
                    <button style="margin-left: 10px;" title="Clear Filter" id="clearFilterTable" type="button" class="btn btn-sm btn-secondary btn-flat">
                      <i class="bx bx-x"></i>
                    </button>
                  </div>
                </div>
              </div>
                  
            </div>
            <div class="table-responsive">
              <table class="table datatable table-striped" id="draftPr" width="100%;height:100%" cellspacing="2">
                <tbody id="tbodyDraft" name="tbodyDraft">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="ModalDraftPr" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close">    
        </button>
        <h6 class="modal-title">Information Supplier</h6>
      </div>
      <div class="modal-body">
        <form method="POST" action="" id="modal_pr" name="modal_pr">
          @csrf
          <!--lagi ngedit-->

          <div class="tab-add" style="display:none!important;">
            <div class="tabGroup">
              <div class="form-group">
                <label for="">To*</label>
                <select id="selectTo" name="selectTo" class="form-control select2" style="width:100%!important" onchange="fillInput('selectTo')"><option></option></select>
                <a id="otherTo" style="cursor:pointer;">Other</a>
                <div id="divInputTo" class="divInputTo" style="display: none;">
                  <button type="button" class="close" aria-hidden="true" style="color:red">×</button>
                  <input autocomplete="off" type="" class="form-control" placeholder="ex. PT Multi Solusindo Perkasa" id="inputTo" name="inputTo" onkeyup="fillInput('to')">
                  <small>
                    *Sertakan bentuk usaha/badan hukum dari supplier apabila ada (PT/CV)<br>
                    *PT/CV ditulis capital<br>
                    *Nama perusahaan ditulis dengan Capital diawal suku kata(Multi Solusindo Perkasa)
                  </small>
                </div>
                <span class="invalid-feedback" style="display:none!important;">Please fill To!</span>
              </div>      

              <div class="row mb-4">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">Type*</label>
                    <select autofocus type="text" class="custom-form-control-select w-100" name="type" onchange="fillInput('selectType')" placeholder="ex. Internal Purchase Request" id="selectType" required>
                        <option value="">Select Type</option>
                        <option value="IPR">IPR (Internal Purchase Request)</option>
                        <option value="EPR">EPR (Eksternal Purchase Request)</option>
                    </select>
                    <span class="invalid-feedback" style="display:none!important;">Please fill Type!</span>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">Email*</label>
                    <input autocomplete="off" type="" class="form-control" placeholder="ex. absolut588@gmail.com" id="inputEmail" name="inputEmail" onkeyup="fillInput('email')">
                    <span class="invalid-feedback" style="display:none!important;">Please fill Email!</span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="">Category</label>
                <select autofocus type="text" class="custom-form-control-select w-100" onchange="fillInput('selectCategory')" name="selectCategory" id="selectCategory" style="width: 100%">
                    <option value="">Select Category</option>
                        <option value="Barang dan Jasa">Barang dan Jasa</option>
                        <option value="Barang">Barang</option>
                        <option value="Jasa">Jasa</option>
                        <option value="Bank Garansi">Bank Garansi</option>
                        <option value="Service">Service</option>
                        <option value="Pajak Kendaraan">Pajak Kendaraan</option>
                        <option value="ATK">ATK</option>
                        <option value="Aset">Aset</option>
                        <option value="Tinta">Tinta</option>
                        <option value="Konsultasi dan Pelatihan">Konsultasi dan Pelatihan</option>
                        <option value="Ujian">Ujian</option>
                        <!-- <option value="Tiket">Tiket</option>
                        <option value="Akomodasi">Akomodasi</option> -->
                        <option value="Perjalanan Dinas">Perjalanan Dinas</option>
                        <option value="Sponsor">Sponsor</option>
                        <option value="Logistic">Logistic</option>
                        <option value="Legal">Legal</option>
                        <option value="License">License</option>
                        <option value="Reference Fee Member">Reference Fee Member</option>
                        <option value="Parkir">Parkir</option>
                        <option value="Kesehatan">Kesehatan</option>
                        <option value="Olahraga">Olahraga</option>
                        <option value="Karangan Bunga">Karangan Bunga</option>
                        <option value="Utilitas">Utilitas</option>
                        <option value="Other">Other</option>
                </select>
                <span class="invalid-feedback" style="display:none!important;">Please fill Category!</span>
              </div>

              <div class="row mb-4">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">Phone*</label>
                    <input autocomplete="off" class="form-control" id="inputPhone" type="" name="" placeholder="ex. 999-999-999-999" onkeyup="fillInput('phone')">
                    <span class="invalid-feedback" style="display:none!important;">Please fill Phone!</span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">Attention*</label>
                    <input autocomplete="off" type="text" class="form-control" placeholder="ex. Marsono" name="inputAttention" id="inputAttention" onkeyup="fillInput('attention')">
                    <span class="invalid-feedback" style="display:none!important;">Please fill Attention!</span>
                  </div>
                </div>
              </div>           

              <div class="form-group">
                <label for="">Subject*</label>
                <input autocomplete="off" type="text" class="form-control" placeholder="ex. Pembelian laptop MSI Modern 14 (Sdri. Faiqoh, Sdr. Oktavian, Sdr. Subchana)" name="inputSubject" id="inputSubject" onkeyup="fillInput('subject')">
                <span class="invalid-feedback" style="display:none!important;">Please fill Subject!</span>
              </div>

              <div class="form-group">
                <label for="">Address*</label>
                <textarea autocomplete="off" class="form-control" id="inputAddress" name="inputAddress" placeholder="ex. Plaza Pinangsia Lt. 1 No. 7-8 Jl. Pinangsia Raya no.1" onkeyup="fillInput('address')" style="resize: vertical;"></textarea>
                <span class="invalid-feedback" style="display:none!important;">Please fill Address!</span>
              </div>

              <div class="form-group">
                <label for="">Request Methode*</label>
                <select autofocus type="text" class="custom-form-control-select w-100" placeholder="ex. Purchase Order" name="type" id="selectMethode" required >
                    <option value="">Select Methode</option>
                    <option value="purchase_order">Purchase Order</option>
                    <option value="payment">Payment</option>
                    <option value="reimbursement">Reimbursement</option>
                </select>
                <span class="invalid-feedback" style="display:none!important;">Please fill Type!</span>
              </div>

              <div class="form-group">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="cbCommit" class="">
                    This supplier has been committed with us to supply this product
                  </label>
                </div>
              </div>

              <div class="form-group" id="divNotePembanding" style="display:none!important;">
                <label for="">Note Pembanding*</label>
                <textarea autocomplete="off" class="form-control" id="note_pembanding" name="note_pembanding"></textarea>
                <span class="invalid-feedback" style="display:none!important;">Please fill Note Pembanding!</span>
              </div>
            </div>
          </div>
          <div class="tab-add" style="display:none!important">
            <div class="tabGroupInitiateAdd">
              <div class="form-group" style="display:flex">
                <button class="btn btn-sm btn-primary" id="btnInitiateAddProduct" type="button" style="margin:0 auto;"><i class="bx bx-plus"></i>&nbspAdd Product</button>
              </div>
              <div class="form-group" style="display:flex;">
                <span style="margin:0 auto;">OR</span>
              </div>
              <div class="form-group" style="display: flex;">
                <div style="padding: 7px;
                  border: 1px solid #787bff !important;
                  color: #337ab7;
                  height: 35px;
                  background-color: #eee;
                  display: inline;
                  margin: 0 auto;">
                  <i class="bx bx-cloud-upload" style="margin-left:5px">
                  <input id="uploadCsv" hidden type="file" name="uploadCsv" style="margin-top: 3px;width: 80px;display: inline;"></i>
                  <label for="uploadCsv">Upload CSV</label>
                  <i class="bx bx-x" hidden onclick="cancelUploadCsv()" style="display:inline;color: red;"></i>
                  <!-- <span class="invalid-feedback" style="display:none!important;">Please Upload File or Add Product!</span> -->
                </div>
              </div>         
              <div style="display: flex;">
              <!--<span style="margin: 0 auto;">You can get format of CSV from this <a href="{{url('https://drive.google.com/uc?export=download&id=1IDI8NVdVskSl__qQVfsrugEamr01W4IA')}}" style="cursor:pointer;">link</a></span> -->
              <span style="margin: 0 auto;">You can get format of CSV from this <a href="{{url('https://drive.google.com/uc?export=download&id=13ywzNFAJFEDGA8HUIy1GBT7B6OBG4L2W')}}" style="cursor:pointer;">link</a></span>
              </div>
              <div style="display: flex;" class="mb-4">
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
              <div class="row mb-4">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Serial Number</label>
                    <input autocomplete="off" type="text" name="" class="form-control" id="inputSerialNumber">
                  </div> 
                </div>
                <div class="col-md-6"> 
                  <div class="form-group">
                    <label>Part Number</label>
                    <input autocomplete="off" type="text" name="" class="form-control" id="inputPartNumber">
                  </div>
                </div>
              </div>
              <div class="row mb-4">
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Qty*</label>
                    <input autocomplete="off" type="number" name="" class="form-control" id="inputQtyProduct" placeholder="ex. 5" onkeyup="fillInput('qty_product')">
                    <span class="invalid-feedback" style="display:none!important;">Please fill Qty!</span>
                  </div> 
                </div>
                <div class="col-md-4" style="margin-bottom:10px"> 
                  <label>Type*</label>
                  <i class="bx bx-warning" title="If type is undefined, Please contact developer team!" style="display:inline"></i>
                  <select style="width:100%;display:inline;" class="form-control" id="selectTypeProduct" placeholder="ex. Unit" onchange="fillInput('type_product')">
                    <option></option>                
                  </select>
                  <span class="invalid-feedback" style="display:none!important;">Please fill Unit!</span>
                </div>
                <div class="col-md-6" style="margin-bottom:10px"> 
                  <label>Price*</label>
                  <div class="input-group">
                    <div class="input-group-text">
                    Rp.
                    </div>
                    <input autocomplete="off" type="text" name="" class="form-control money" id="inputPriceProduct" placeholder="ex. 500,000.00" onkeyup="fillInput('price_product')">
                    <button type="button" class="btn btn-sm btn-outline-primary  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">  
                    </button>       
                    <ul class="dropdown-menu dropdown-menu-end">       
                      <li><a class="dropdown-item"  onclick="changeCurreny('usd')">USD($)</a></li>
                      <li><a class="dropdown-item"  onclick="changeCurreny('dollar')">IDR(RP)</a></li>
                    </ul>
                  </div>
                  <span class="invalid-feedback" style="display:none!important;">Please fill Price!</span>
                </div>
              </div>            
              <div class="form-group">
                <label>Total Price</label>
                <div class="input-group">
                  <div class="input-group-text">
                  Rp.
                  </div>
                    <input autocomplete="off" disabled type="text" name="" class="form-control" id="inputTotalPrice" placeholder="75.000.000,00">
                </div>
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
                  <th>Qty</th>
                  <th>Type</th>
                  <th>Price</th>
                  <th>Total Price</th>
                  <th><a class="pull-right" onclick="refreshTable()"><i class="bx bx-refresh"></i>&nbsp</a></th>
                </thead>
                <tbody id="tbodyProducts">
                </tbody>
              </table>
            </div>
            <div class="row mb-4">
              <div class="col-md-12" id="bottomProducts">
              </div>
            </div>
            <div class="form-group" style="display:flex;margin-top: 10px;">
              <button class="btn btn-sm btn-sm btn-primary" style="margin: 0 auto;" type="button" id="addProduct"><i class="bx bx-plus"></i>&nbsp Add product</button>
            </div>
          </div>
          <!---upload dokumen-->
          <div class="tab-add" style="display:none">
            <div class="tabGroup">
              <div id="formForPrExternal" style="display:none">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>PID*</label>
                      <select id="selectPid" style="width: 100%;" class="select2 form-control" onchange="fillInput('selectPID')">
                        <option></option>
                      </select>
                      <span class="invalid-feedback" style="display:none;">Please fill PID!</span>
                      <!-- <span id="makeId" style="cursor: pointer;">other?</span>
                      <div class="form-group" id="project_idNew" style="display: none;">
                        <div class="input-group">
                          <input autocomplete="off" type="text" class="form-control pull-left col-md-8" placeholder="input Project ID" name="project_idInputNew" id="projectIdInputNew">
                          <span class="input-group-addon" style="cursor: pointer;" id="removeNewId"><i class="glyphicon glyphicon-remove"></i></span>
                        </div>
                      </div>  -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Lead Register*</label>
                      <select id="selectLeadId" style="width:100%" class="select2 form-control" onchange="fillInput('selectLeadId')">
                        <option></option>
                      </select>
                      <span class="invalid-feedback" style="display:none;">Please fill Lead Register!</span>
                    </div>
                  </div>
                </div> 

                <div class="form-group">
                  <label>Quote Number*</label>
                  <select name="selectQuoteNumber" class="select2 form-control" id="selectQuoteNumber" >
                    <option></option>
                  </select>
                  <!-- <input type="file" class="files" name="inputQuoteNumber" id="inputQuoteNumber" class="form-control" onkeyup="fillInput('quoteNumber')"> -->
                  <span class="invalid-feedback" style="display:none;">Please fill Quote Number!</span>
                </div> 

                <div class="form-group">
                  <label>Quote Supplier*</label>
                  <div style="border: 1px solid #787bff !important;padding: 5px;color: #337ab7;">
                    <label for="inputQuoteSupplier" style="margin-bottom: 0px;">
                      <span class="bx bx-cloud-upload" style="display:inline;"></span>
                      <input autocomplete="off" style="display: inline;font-family: inherit;text-overflow: ellipsis;white-space:nowrap;overflow:hidden;width: 200px;" type="file" class="files" name="inputQuoteSupplier" id="inputQuoteSupplier" onchange="fillInput('quoteSupplier')" >
                    </label>
                  </div>
                  <span class="invalid-feedback" style="display:none;">Please fill Quote Supplier!</span>
                  <span style="display:none;" id="span_link_drive_quoteSup"><a id="link_quoteSup" target="_blank"><i class="bx bx-link"></i>&nbspLink drive</a></span>
                </div>             
                
                <div class="form-group">
                  <label>SPK/Kontrak*</label>
                  <div style="border: 1px solid #787bff !important;padding: 5px;color: #337ab7;">
                    <label for="inputSPK" style="margin-bottom: 0px;">
                      <span class="bx bx-cloud-upload" style="display:inline;"></span>
                      <input autocomplete="off" style="display: inline;font-family: inherit;" type="file" class="files" name="inputSPK" id="inputSPK" onchange="fillInput('spk')" >
                    </label>
                  </div>
                  <span class="invalid-feedback" style="display:none;">Please fill SPK/Kontrak!</span>
                  <span style="display:none;" id="span_link_drive_spk"><a id="link_spk" target="_blank"><i class="bx bx-link"></i>&nbspLink drive</a></span>
                </div>

                <div class="form-group">
                  <label>SBE*</label>
                  <div style="border: 1px solid #787bff !important;padding: 5px;color: #337ab7;">
                    <label for="inputSBE" style="margin-bottom: 0px;">
                      <span class="bx bx-cloud-upload" style="display:inline;"></span>
                      <input autocomplete="off" style="display: inline;font-family: inherit;" type="file" class="files" name="inputSBE" id="inputSBE" onchange="fillInput('sbe')" >
                    </label>
                  </div>
                  <span class="invalid-feedback" style="display:none;">Please fill SBE!</span>
                  <span style="display:none;" id="span_link_drive_sbe"><a id="link_sbe" target="_blank"><i class="bx bx-link"></i>&nbspLink drive</a></span>
                </div>

                <div id="docPendukungContainer" class="table-responsive">
                  <label id="titleDoc_epr" style="display:none;">Lampiran Dokumen Lainnya</label>
                  <table id="tableDocPendukung_epr" class="border-collapse:collapse" style="border-collapse: separate;border-spacing: 0 15px;">
                    
                  </table>
                </div>
                <div class="form-group" style="display: flex;margin-top: 10px;">
                  <button type="button" id="btnAddDocPendukung_epr" style="margin:0 auto" class="btn btn-sm btn-sm btn-primary" onclick="addDocPendukung('epr')"><i class="bx bx-plus"></i>&nbsp Dokumen Lainnya</button>
                </div>  
              </div>
                
              <div id="formForPrInternal" style="display:none;">
                <div class="form-group">
                  <label>Lampiran Penawaran Harga*</label>
                  <div style="border: 1px solid #787bff !important;padding: 5px;color: #337ab7;">
                    <label for="inputPenawaranHarga" style="margin-bottom:0px">
                      <i class="bx bx-cloud-upload" style="display:inline"></i>
                      <input autocomplete="off" style="display: inline;" type="file" class="files" name="inputPenawaranHarga" id="inputPenawaranHarga" onchange="fillInput('penawaranHarga')">
                    </label>                  
                  </div>
                  <span class="invalid-feedback" style="display:none;">Please fill Penawaran Harga!</span>
                  <span style="display:none;" id="span_link_drive_penawaranHarga"><a id="link_penawaran_harga" target="_blank"><i class="bx bx-link"></i>&nbspLink drive</a></span>
                </div>

                <div id="docPendukungContainer" class="table-responsive">
                  <label id="titleDoc_ipr" style="display:none;">Lampiran Dokumen Pendukung</label>
                  <table id="tableDocPendukung_ipr" class="border-collapse:collapse" style="border-collapse: separate;border-spacing: 0 15px;">
                    
                  </table>
                </div>
                <div class="form-group" style="display: flex;margin-top: 10px;">
                  <button type="button" id="btnAddDocPendukung_ipr" style="margin:0 auto" class="btn btn-sm btn-primary" onclick="addDocPendukung('ipr')"><i class="bx bx-plus"></i>&nbsp Dokumen Pendukung</button>
                </div>
              </div>
            </div>
          </div>
          <!---->  
          <div class="tab-add" style="display:none!important">
            <div class="tabGroup">
              <div class="card-body mb-4">
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
                <span class="invalid-feedback" style="display:none!important;">Please fill Top of Payment!</span>
              </div>
            </div>
          </div>  
          <div class="tab-add" style="display:none!important">
            <div class="tabGroup">
              <div class="row mb-4">
                <div class="col-md-12" id="headerPreviewFinal">
                  
                </div>
              </div><br>
              <div class="row mb-4">
                <div class="col-md-12 table-responsive">
                  <table class="table" style="white-space: nowrap;">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Total Price</th>
                      </tr>
                    </thead>
                    <tbody id="tbodyFinalPageProducts">
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row mb-4">
                <div class="col-md-12" id="bottomPreviewFinal">
                  
                </div>
              </div> 
            </div>        
          </div>     
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" id="prevBtnAdd" style="display:none!important;">Back</button>
        <button type="button" class="btn btn-sm btn-primary" id="nextBtnAdd">Next</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="ModalDraftPrAdmin" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <h6 class="modal-title">Information Supplier</h6>
        </div>
        <div class="modal-body">
          <form method="POST" action="" id="modal_pr" name="modal_pr">
            @csrf
            <div class="tab-cek" style="display:none!important;">
              <div class="form-group">
                <label for="">To*</label>
                <div class="input-group">  
                    <input type="text" disabled class="form-control" placeholder="ex. eSmart Solution" id="inputToCek" name="inputToCek">
                  <div class="input-group-text">
                    <input onchange="checkBoxCek('to_cek')" id="to_cek" name="chk[]" type="checkbox" class="form-check-input">
                  </div>
                </div>
              </div>        

              <div class="row mb-4">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">Type*</label>
                    <div class="input-group">   
                      <select type="text" disabled class="form-control" placeholder="ex. Internal Purchase Request" id="selectTypeCek">
                          <option selected value="IPR">IPR (Internal Purchase Request)</option>
                          <option value="EPR">EPR (Eksternal Purchase Request)</option>
                      </select>
                      <div class="input-group-text">
                        <input onchange="checkBoxCek('type_cek')" id="type_cek" name="chk[]" type="checkbox" class="form-check-input">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">Email*</label>
                    <div class="input-group">   
                      <input type="" disabled class="form-control" placeholder="ex. absolut588@gmail.com" id="inputEmailCek" name="inputEmailCek">
                      <div class="input-group-text">
                        <input onchange="checkBoxCek('email_cek')" id="email_cek" name="chk[]" type="checkbox" class="form-check-input">
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>

              <div class="form-group">
                  <label for="">Category</label>
                  <div class="input-group">
                    <select disabled type="text" class="form-control select2" name="selectCategoryCek" id="selectCategoryCek">
                        <option value="">Select Category</option>
                        <option value="Barang dan Jasa">Barang dan Jasa</option>
                        <option value="Barang">Barang</option>
                        <option value="Jasa">Jasa</option>
                        <option value="Bank Garansi">Bank Garansi</option>
                        <option value="Service">Service</option>
                        <option value="Pajak Kendaraan">Pajak Kendaraan</option>
                        <option value="ATK">ATK</option>
                        <option value="Aset">Aset</option>
                        <option value="Tinta">Tinta</option>
                        <option value="Konsultasi dan Pelatihan">Konsultasi dan Pelatihan</option>
                        <option value="Ujian">Ujian</option>
                        <!-- <option value="Tiket">Tiket</option> -->
                        <!-- <option value="Akomodasi">Akomodasi</option> -->
                        <option value="Perjalanan Dinas">Perjalanan Dinas</option>
                        <option value="Sponsor">Sponsor</option>
                        <option value="Logistic">Logistic</option>
                        <option value="Legal">Legal</option>
                        <option value="License">License</option>
                        <option value="Reference Fee Member">Reference Fee Member</option>
                        <option value="Parkir">Parkir</option>
                        <option value="Kesehatan">Kesehatan</option>
                        <option value="Olahraga">Olahraga</option>
                        <option value="Karangan Bunga">Karangan Bunga</option>
                        <option value="Utilitas">Utilitas</option>
                        <option value="Other">Other</option>
                    </select>
                    <div class="input-group-text">
                      <input onchange="checkBoxCek('category_cek')" id="category_Cek" name="chk[]" type="checkbox" class="form-check-input">
                    </div>
                  </div>
              </div>

              <div class="row mb-4">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">Phone*</label>
                    <div class="input-group">
                      <input class="form-control" id="inputPhoneCek" type="" name="" placeholder="ex. 999-999-999-999" disabled>
                      <div class="input-group-text">
                        <input onchange="checkBoxCek('phone_Cek')" id="phone_cek" name="chk[]" type="checkbox" class="form-check-input">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">Attention*</label>
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="ex. Marsono" name="inputAttentionCek" id="inputAttentionCek" disabled>
                      <div class="input-group-text">
                        <input onchange="checkBoxCek('attention_cek')" id="attention_cek" name="chk[]" type="checkbox" class="form-check-input">
                      </div>
                    </div>
                  </div>
                </div>
              </div> 

              <div class="form-group">
                <label for="">Subject*</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="ex. Pembelian laptop MSI Modern 14 (Sdri. Faiqoh, Sdr. Oktavian, Sdr. Subchana)" name="inputSubjectCek" id="inputSubjectCek" onkeyup="fillInput('subject')" disabled>
                  <div class="input-group-text">
                    <input onchange="checkBoxCek('subject_cek')" id="subject_cek" name="chk[]" type="checkbox" class="form-check-input">
                  </div>
                </div>
                
              </div>

              <div class="form-group">
                <label for="">Address*</label>
                <div class="input-group">
                  <textarea style="resize: none;height: 150px;" class="form-control" id="inputAddressCek" name="inputAddressCek" placeholder="ex. Plaza Pinangsia Lt. 1 No. 7-8 Jl. Pinangsia Raya no.1" onkeyup="fillInput('address')" disabled></textarea>
                  <div class="input-group-text">
                  <input onchange="checkBoxCek('address_cek')" id="address_cek" name="chk[]" type="checkbox" class="form-check-input">
                  </div>
                </div>
                
              </div>

              <div class="form-group">
                <label for="">Request Methode*</label>
                <div class="input-group">
                  <select type="text" class="form-control" placeholder="ex. Purchase Order" id="selectMethodeCek" disabled >
                      <option selected value="purchase_order">Purchase Order</option>
                      <option value="payment">Payment</option>
                      <option value="reimbursement">Reimbursement</option>
                  </select>
                  <div class="input-group-text">
                    <input onchange="checkBoxCek('methode_cek')" id="methode_cek" name="chk[]" type="checkbox" class="form-check-input">
                  </div>
                </div>              
              </div>
            </div>
            <div class="tab-cek" style="display:none!important;">
              <div class="table-responsive">
                <table class="table no-wrap">
                  <thead>
                    <th>No</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th><a class="pull-right" id="refreshTableCek"><i class="bx bx-refresh"></i>&nbsp</a></th>
                  </thead>
                  <tbody id="tbodyProductsCek"> 
                  </tbody>
                </table>
              </div>            
              <div class="row mb-4">
                <div class="col-md-12" id="bottomProductsCek">
                  
                </div>
              </div>
            </div>
            <div class="tab-cek" style="display:none!important">
              <div id="formForPrExternalCek" style="display:none!important">
                <div class="form-group">
                  <div class="row mb-4">
                    <div class="col-md-6">
                      <label>Lead Register*</label>
                      <div class="input-group">
                        <input disabled id="selectLeadIdCek" class="form-control"/>
                        <div class="input-group-text">
                          <input type="checkbox" disabled class="" name="" id="lead_cek" onchange="checkBoxCek('lead_cek')">
                        </div>
                      </div>
                      
                    </div>
                    <div class="col-md-6">
                      <label>PID*</label>
                      <div class="input-group">
                        <input id="selectPidCek" disabled class="form-control"/>
                        <div class="input-group-text">
                          <input type="checkbox" class="" name="" id="pid_cek" onchange="checkBoxCek('pid_Cek')">
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>                
                
                <div class="form-group">
                  <label>SPK/Kontrak*</label>
                  <div class="input-group" disabled>
                    <div style="border: 1px solid #787bff !important;padding: 5px;background-color: #EEEEEE;">
                      <i class="icon_spk" style="display:inline;color: #5f61e6;"></i>
                      <a target="_blank" href="" id="link_spkCek"><input style="display: inline;background-color: transparent;border: none;" type="text" name="inputSPK" id="inputSPKCek" disabled></a>
                    </div>
                    <div class="input-group-text">
                      <input type="checkbox" class="" name="" id="spk_cek" onchange="checkBoxCek('spk_cek')">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label>SBE*</label>
                  <div class="input-group" disabled>
                    <div style="border: 1px solid #787bff !important;padding: 5px;background-color: #EEEEEE;">
                      <i class="icon_sbe" style="display:inline;color: #5f61e6;"></i>
                      <a target="_blank" href="" id="link_sbeCek"><input style="display:inline;background-color: transparent;border: none;" type="text" name="inputSBECek" id="inputSBECek" disabled ></a>
                    </div>
                    <div class="input-group-text">
                      <input type="checkbox" class="" name="" id="sbe_cek" onchange="checkBoxCek('sbe_cek')">
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="row mb-4">
                    <div class="col-md-6">
                      <label>Quote Supplier*</label>
                      <div class="input-group" disabled>
                        <div style="border: 1px solid #787bff !important;padding: 5px;background-color: #EEEEEE;">
                          <i class="icon_quo" style="display:inline;color: #5f61e6;"></i>
                          <a target="_blank" href="" id="link_quoteSupCek"><input style="display: inline;background-color: transparent;border: none;" type="text" name="inputQuoteSupplierCek" id="inputQuoteSupplierCek" disabled ></a>
                        </div>
                        <div class="input-group-text">
                          <input type="checkbox" class="" name="" id="quoSup_cek" onchange="checkBoxCek('quoSup_cek')">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label>Quote Number*</label>
                      <div class="input-group">
                        <input disabled id="selectQuoteNumCek" class="form-control" />
                        <div class="input-group-text">
                          <input type="checkbox" class="" name="" id="quoNum_cek" onchange="checkBoxCek('quoNum_cek')">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>  

                <div class="form-group">
                  <div id="docPendukungContainerCekEPR">
                  </div>
                </div>  
              </div>
                
              <div id="formForPrInternalCek" style="display:none!important;">
                <div id="docPendukungContainerCek">
                  
                </div>
              </div>
            </div>   
            <div class="tab-cek" style="display:none!important">
              <div class="input-group">
                <div disabled class="form-control textarea-scrollbar" id="textAreaTOPCek" style="height: 210px;  font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221);resize: none;overflow: auto;">
                </div>
                <div class="input-group-text">
                  <input type="checkbox" class="" name="chk[]" id="textarea_top_cek" name="" onchange="checkBoxCek('textareaTOP')">
                </div>
              </div>
            </div>  
            <div class="tab-cek" style="display:none!important">
              <div class="row mb-4">
                <div class="col-md-12" id="headerPreviewFinalCek">
                  
                </div>
              </div><br>
              <div class="row mb-4">
                <div class="col-md-12 table-responsive">
                  <table class="table" style="white-space: nowrap;">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Total Price</th>
                      </tr>
                    </thead>
                    <tbody id="tbodyFinalPageProductsCek">
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row mb-4">
                <div class="col-md-12" id="bottomPreviewFinalCek">
                  
                </div>
              </div>              
            </div>  
            <div class="tab-cek" style="display:none!important">
              <div id="AllChecked">
                <div style="display: inline;text-align:justify;">                
                  <span style="position:absolute;"><input type="checkbox" id="cbAllChecked" class="" value=""/></span>
                  <span style="display:flex;margin-left: 25px;display:flex;">Dengan ini saya menyatakan bahwa Draft PR ini sudah betul baik dari input yang diberikan beserta data pendukung yang dilampirkan dan Draft PR siap untuk dilanjutkan ke proses berikutnya</span>
                </div>
              </div>
              <div id="notAllChecked" style="display:none!important;">
                  <div class="form-group">
                    <label>Approve/Reject*</label><br>
                    <div class="radio">
                      <label>
                        <input type="radio" class=" radioConfirm" name="radioConfirm" value="approve">
                        Approve
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" class=" radioConfirm" name="radioConfirm" value="reject">
                        Reject
                      </label>
                    </div>
                  </div>
                  <div class="form-group" style="display:none!important;" id="divReasonReject">
                    <h6>Reason of Reject</h6>
                    <textarea id="textAreaReasonReject" onkeyup="fillInput('reason_reject')" class="form-control" placeholder="ex. [Informasi Supplier - To] Ada Kesalahan Penulisan Nama" style="resize:vertical;"></textarea>
                    <span class="invalid-feedback" style="display:none!important;">Please fill Reason!</span>
                  </div>
              </div>  
            </div> 
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary" id="prevBtnAddAdmin">Back</button>
            <button type="button" class="btn btn-sm btn-primary" id="nextBtnAddAdmin">Next</button>
        </div>
      </div>
    </div>
</div>
@endsection
@section('scriptImport')
  <script src="{{asset('assets/vendor/libs/quill/katex.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/quill/quill.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script type="text/javascript" src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('assets/js/jquery.mask.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
  <!--datatables-->
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <!--fixed column-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.js" integrity="sha512-SSQo56LrrC0adA0IJk1GONb6LLfKM6+gqBTAGgWNO8DIxHiy0ARRIztRWVK6hGnrlYWOFKEbSLQuONZDtJFK0Q==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('script')
  <script type="text/javascript">
    $('.money').mask('#.##0,00', {reverse: true})
    let snowEditor;

    $(document).ready(function(){ 
      currentTab = 0     
      $('input[class="files"]').change(function(){
        var f=this.files[0]
        var filePath = f;
     
        // Allowing file type
        var allowedExtensions =
        /(\.pdf)$/i;

        var ErrorText = []
        // 
        if (f.size > 30000000|| f.fileSize > 30000000) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Invalid file size, just allow file with size less than 30MB!',
          }).then((result) => {
            this.value = ''
          })
        }

        var ext = filePath.name.split(".");
        ext = ext[ext.length-1].toLowerCase();   
        var arrayExtensions = ["pdf"];

        if (arrayExtensions.lastIndexOf(ext) == -1) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Invalid file type, just allow pdf file',
          }).then((result) => {
            this.value = ''
          })
        }
      }) 

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
          $("#uploadCsv").next('label').attr('style','display:none!important')
          $("input[type='file'][name='uploadCsv']").removeClass('hidden')
          $("input[type='file'][name='uploadCsv']").prev('i').attr('style','display:none!important')
          $("#uploadCsv").next('label').next('i').removeClass('hidden') 
          $("#btnInitiateAddProduct").prop("disabled",true)
        }
      })

      DashboardCounterFilter()
      // InitiateFilterParam()
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
            dropdownParent: $('#ModalDraftPr')
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

    function DashboardCounter(){
      $("#BoxId").empty()
      
      var countPr = []

      var i = 0
      var append = ""
      var colors = []
      var ArrColors = [{
            name: 'Need Attention',style: 'color:white', color: 'text-bg-warning', icon: 'icon-base bx bx-exclamation',status:"NA",index: 0
        },
        {
            name: 'Ongoing',style: 'color:white', color: 'btn-linkedin', icon: 'icon-base bx bx-edit',status:"OG",index: 1
        },
        {
            name: 'Done',style: 'color:white', color: 'text-bg-success', icon: 'icon-base bx bx-check',status:"DO",index: 2
        },
        {
            name: 'All',style: 'color:white', color: 'text-bg-primary', icon: 'icon-base bx bx-list-ul',status:"ALL",index: 3
        },
      ]

      // var ArrColors = [{
      //       name: 'Need Attention',style: 'color:white', color: 'bg-yellow', icon: '',status:"NA",index: 0
      //   },
      //   {
      //       name: 'Ongoing',style: 'color:white', color: 'bg-primary', icon: '',status:"OG",index: 1
      //   },
      //   {
      //       name: 'Done',style: 'color:white', color: 'bg-green', icon: '',status:"DO",index: 2
      //   },
      //   {
      //       name: 'All',style: 'color:white', color: 'bg-purple', icon: '',status:"ALL",index: 3
      //   },
      // ]

      colors.push(ArrColors)
      $.each(colors[0], function(key, value){
        var status = "'"+ value.status +"'"
        append = append + '<div class="col-lg-3 col-xs-12">'
          // append = append + '<div class="small-card ' + value.color + '">'
          //   append = append + '<div class="inner">'
          //     append = append + '<h6 style="'+ value.style +'" class="counter" id="count_pr_'+value.index+'"</h6>'
          //     append = append + '<h6 style="'+ value.style +'"><b>'+ value.name +'</b></h6>'

          //   append = append + '</div>'
          //   append = append + '<div class="icon">'
          //     append = append + '<i class="'+ value.icon +'" style="'+ value.style +';opacity:0.4"></i>'
          //   append = append + '</div>'
          //   append = append + '<a href="#" onclick="sortingByDashboard('+ status +')" class="small-card-footer">Sorting <i class="bx bx-filter"></i></a>'
          // append = append + '</div>'

          append = append + '<div class="card">'
            append = append + '<div class="card-header d-flex align-items-center justify-content-between">'
              append = append + '<a href="#" onclick="sortingByDashboard('+ status +')" class="small-card-footer">Sorting <i class="icon-base bx bx-filter"></i></a>'              
            append = append + '</div>'
            append = append + '<div class="card-body">'
              append = append + '<div class="d-flex justify-content-between">'
                append = append + '<div class="card-info">'
                  append = append + '<div class="d-flex align-items-center mb-1">'
                    append = append + '<h4 class="card-title mb-0 me-2 counter" id="count_pr_'+value.index+'">0</h4>'
                  append = append + '</div>'
                  append = append + '<span><b>'+ value.name +'</b></span>'
                append = append + '</div>'
                append = append + '<div class="card-icon">'
                  append = append + '<span class="badge bg-label-primary rounded p-2">'
                    append = append + '<i class="'+ value.icon +'"></i>'
                  append = append + '</span>'
                append = append + '</div>'
              append = append + '</div>'
            append = append + '</div>'
          append = append + '</div>'
        append = append + '</div>'
      id = "count_pr_"+value.index
      countPr.push(id)
      })

      $("#BoxId").append(append)
  
      $.ajax({
        type:"GET",
        url:"{{url('/admin/getCount')}}",
        success:function(result){
            $("#"+countPr[0]).text(result.count_need_attention)
            $("#"+countPr[1]).text(result.count_ongoing)
            $("#"+countPr[2]).text(result.count_done)
            $("#"+countPr[3]).text(result.count_all)

          $('.counter').each(function () {
              var size = $(this).text().split(".")[1] ? $(this).text().split(".")[1].length : 0;
              $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
              }, {
                duration: 5000,
                step: function (func) {
                   $(this).text(parseFloat(func).toFixed(size));
                }
              });
          });
        },
      })
    }

    function DashboardCounterFilter(temp){
      var temp = ''
      if (temp == undefined) {
        temp = '?' + temp
      }else{
        temp = ''
      }

      $("#BoxId").empty()
      var countPr = []
      var i = 0
      var append = ""
      var colors = []
      var ArrColors = [{
            name: 'Need Attention',style: 'color:white', color: 'bg-label-warning', icon: 'icon-base bx bx-calendar-exclamation',status:"NA",index: 0
        },
        {
            name: 'Ongoing',style: 'color:white', color: 'btn-linkedin', icon: 'icon-base bx bx-edit',status:"OG",index: 1
        },
        {
            name: 'Done',style: 'color:white', color: 'bg-label-success', icon: 'icon-base bx bx-check',status:"DO",index: 2
        },
        {
            name: 'All',style: 'color:white', color: 'bg-label-primary', icon: 'icon-base bx bx-list-ul',status:"ALL",index: 3
        },
      ]

      colors.push(ArrColors)
      $.each(colors[0], function(key, value){
        append = append + '<div class="col-lg-3 col-xs-6">'
          // append = append + '<div class="small-card ' + value.color + '">'
          //   append = append + '<div class="inner">'
          //     append = append + '<h6 style="'+ value.style +'" class="counter" id="count_pr_'+value.index+'"</h6>'
          //     append = append + '<h6 style="'+ value.style +'"><b>'+ value.name +'</b></h6>'
          //   append = append + '</div>'
          //   append = append + '<div class="icon">'
          //     append = append + '<i class="'+ value.icon +'" style="'+ value.style +';opacity:0.4"></i>'
          //   append = append + '</div>'
          // append = append + '</div>'
          append = append + '<div class="card">'
            append = append + '<div class="card-header d-flex align-items-center justify-content-between">'
              append = append + '<a href="#" onclick="sortingByDashboard('+ status +')" class="small-card-footer">Sorting <i class="icon-base bx bx-filter"></i></a>'              
            append = append + '</div>'
            append = append + '<div class="card-body">'
              append = append + '<div class="d-flex justify-content-between">'
                append = append + '<div class="card-info">'
                  append = append + '<div class="d-flex align-items-center mb-1">'
                    append = append + '<h4 class="card-title mb-0 me-2 counter" id="count_pr_'+value.index+'">0</h4>'
                  append = append + '</div>'
                  append = append + '<span><b>'+ value.name +'</b></span>'
                append = append + '</div>'
                append = append + '<div class="card-icon">'
                  append = append + '<span class="badge ' + value.color + ' rounded p-2">'
                    append = append + '<i class="'+ value.icon +'"></i>'
                  append = append + '</span>'
                append = append + '</div>'
              append = append + '</div>'
            append = append + '</div>'
          append = append + '</div>'
        append = append + '</div>'
      id = "count_pr_"+value.index
      countPr.push(id)
      })

      $("#BoxId").append(append)

      $.ajax({
        type:"GET",
        url:"{{url('/admin/getFilterCount')}}" + temp,
        success:function(result){
            $("#"+countPr[0]).text(result.count_need_attention)
            $("#"+countPr[1]).text(result.count_ongoing)
            $("#"+countPr[2]).text(result.count_done)
            $("#"+countPr[3]).text(result.count_all)

          $('.counter').each(function () {
              var size = $(this).text().split(".")[1] ? $(this).text().split(".")[1].length : 0;
              $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
              }, {
                duration: 5000,
                step: function (func) {
                   $(this).text(parseFloat(func).toFixed(size));
                }
              });
          });
        },
      })
    }

    var accesable = @json($feature_item);
    accesable.forEach(function(item,index){
      $("#" + item).show()
    })

    var formatter = new Intl.NumberFormat(['ban', 'id']);

    function textAreaAdjust(element) {
      element.style.height = "1px";
      element.style.height = (25+element.scrollHeight)+"px";
    }

    $("#draftPr").DataTable({
        processing:true,
        serverSide:true,
        "ajax":{
          "type":"GET",
          "url":"{{url('/admin/getDraftPr')}}",
          // "dataSrc": function (json){
          //   json.data.forEach(function(data,index){
          //     if (data.status == 'REJECT') {
          //       data.status_numerical = 1
          //     }else if (data.status == 'UNAPPROVED') {
          //       data.status_numerical = 2
          //     }else if (data.status == 'SAVED') {
          //       data.status_numerical = 3
          //     }else if (data.status == 'DRAFT') {
          //       data.status_numerical = 4
          //     }else if (data.status == 'VERIFIED') {
          //       data.status_numerical = 5
          //     }else if (data.status == 'COMPARING') {
          //       data.status_numerical = 6
          //     }else if (data.status == 'CIRCULAR') {
          //       data.status_numerical = 7
          //     }else if (data.status == 'FINALIZED') {
          //       data.status_numerical = 8
          //     }else if (data.status == 'SENDED') {
          //       data.status_numerical = 9
          //     }else if (data.status == 'CANCEL') {
          //       data.status_numerical = 10
          //     }
          //   })
          //   return json.data
          // }
        },
        "columns": [
          { 
            title:"No. PR",
            render: function (data, type, row, meta){
              if (row.status == "SAVED" || row.status == "DRAFT") {
                return " - "           
              }else{
                return row.no_pr         
              }
            },
            width:"150px"
          },
          {
            title:"Created at",
            orderData:[8],
            render: function (data, type, row, meta){
             return moment(row.date).format("D MMM YYYY");   
            },
            width:"80px"
          },
          { 
            title:"Subject",
            render: function (data, type, row, meta){
              if (row.attention_notes == "False") {
                return '<span class="badge text-bg-primary"><b><i>' + row.type_of_letter + '</i></b></span>&nbsp<i title="Pay Attention to the Notes!" class="bx bx-error" style="color:red;font-size:18px"></i> ' + row.title         
              }else{
                return '<span class="badge text-bg-primary"><b><i>' + row.type_of_letter + '</i></b></span> ' + row.title         
              }
              // return "-"
            },
            width:"300px"
          },
          { title:"Issued By", 
            "data": "name",
            width:"150px"
          },
          { 
            title:"Supplier",
            "data": "to",
            width:"150px"
          },
          { 
            title:"Total Price",
            render: function (data, type, row, meta){
              if (isNaN(row.nominal) == true) {
                return formatter.format(row.nominal.replace(/\./g,'').replace(',','.').replace(' ',''))       
              }else{
                return formatter.format(row.nominal)          
              }
            },
            className:'text-right'
          },
          { 
            title:"Status",
            orderData:[7],
            render: function (data, type, row, meta){
              if (row.status == 'SAVED') {
                return '<span class="badge btn-linkedin">'+row.status+'</span>'           
              }else if (row.status == 'DRAFT') {
                return '<span class="badge text-bg-primary">'+row.status+'</span>'           
              }else if (row.status == 'VERIFIED') {
                return '<span class="badge text-bg-success">'+row.status+'</span>'
              }else if (row.status == 'COMPARING') {
                return '<span class="badge text-bg-primary">'+row.status+'</span>'
              }else if (row.status == 'CIRCULAR') {
                if (row.circularby == "-") {
                  return '<span class="badge text-bg-warning">'+row.status+'</span><br><small>On Procurement & Vendor Management<small>'
                }else{
                  return '<span class="badge text-bg-warning">'+row.status+'</span><br><small>On '+ row.circularby +'<small>'
                }
              }else if (row.status == 'FINALIZED') {
                return '<span class="badge text-bg-success">'+row.status+'</span>'           
              }else if (row.status == 'SENDED') {
                return '<span class="badge text-bg-primary">'+row.status+'</span>'           
              }else if (row.status == 'UNAPPROVED' || row.status == 'REJECT' || row.status == 'CANCEL') {
                return '<span class="badge text-bg-danger">'+row.status+'</span>' 
              }
            },
            className:'text-center',
            width:"100px"
          },
          { 
            title:"Action",
            render: function (data, type, row, meta){
              let onclick = ""
              let title = ""
              let btnClass = ""
              let isDisabled = ""
              let isDisabledCancel = ""
              let btnId = ""
              let status = ""
              let value = ""
              let btnDetailUnApproved = ""

              if (row.status == 'DRAFT') {
                onClick = ""
                title = "Verify"
                btnClass = "btnCekDraft text-bg-info"
                if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Procurement & Vendor Management')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Internal Chain Management')->exists()}}") {
                  isDisabled = ""
                  onclick = "cekByAdmin(0,"+ row.id +")"
                }else{
                  isDisabled = "disabled"
                }
                btnId = "btnCekDraft"
              }else if (row.status == 'SAVED') {
                btnClass = "text-bg-warning"
                title = "Draft"
                btnId = "btnDraft"
                if (row.issuance == '{{Auth::User()->nik}}') {
                  status = '"saved"'
                  value = status
                  onclick = "unfinishedDraft(0,"+ row.id +","+ status +")"
                }else{
                  isDisabled = "disabled"
                } 
              }
              else if (row.status == 'REJECT') {
                title = "Revision"
                btnClass = "text-bg-warning"
                // btnId = "btnDraft"
                if (row.issuance == '{{Auth::User()->nik}}') {
                  status = '"reject"'
                  value = status
                  onclick = "unfinishedDraft(0,"+ row.id +","+ status +")"
                }else{
                  isDisabled = "disabled"
                } 
              }
              else if(row.status == 'UNAPPROVED'){
                title = "Revision"
                btnClass = "text-bg-warning"
                if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Procurement & Vendor Management')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Supply Chain, CPS & Asset Management')->exists()}}") {
                  status = '"revision"'
                  value = status
                  onclick = "unfinishedDraft(0,"+ row.id +","+ status +")"
                }else{
                  isDisabled = "disabled"
                }

                btnDetailUnApproved = "<a href='{{url('admin/detailDraftPR')}}/"+ row.id +"?hide' style='width:70px;margin-right:5px' class='btn btn-sm btn-primary' btnCekDraftDusk_"+row.id+"' data-value='"+row.id+"'  id='btnDetail' target='_blank'>Detail</a>"
              }else{
                title = "Detail"
                btnClass = "btn-primary"
                btnId = "btnDetail"
                onclick = "{{url('admin/detailDraftPR')}}/"+row.id
              } 

              if (row.issuance == '{{Auth::User()->nik}}') {
                if (row.status == 'CANCEL') {
                  isDisabledCancel = 'disabled'
                }else{
                  isDisabledCancel = ''
                }
              }else{
                if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Procurement & Vendor Management')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Supply Chain, CPS & Asset Management')->exists()}}") {
                  isDisabledCancel = ''
                }else{
                  isDisabledCancel = 'disabled'
                }
              }

              if (title == 'Detail') {
                return "<td><a href='"+ onclick +"' style='width:70px' class='btn btn-sm "+ btnClass +" btnCekDraftDusk_"+row.id+"' data-value='"+row.id+"' "+isDisabled+" id='"+ btnId +"' target='_blank'>"+ title +"</a>" + " " + "<button class='btn btn-sm btn-danger' "+ isDisabledCancel +" onclick='btnCancel("+ row.id +")' value='"+ value +"' style='width:70px'>Cancel</button></td>"
              }else {
                if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Procurement & Vendor Management')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Supply Chain, CPS & Asset Management')->exists()}}") {
                  return "<td>"+ btnDetailUnApproved +"<a onclick='"+ onclick +"' "+isDisabled+" style='width:70px' class='btn btn-sm "+ btnClass +" btnCekDraftDusk_"+row.id+"' data-value='"+row.id+"' id='"+ btnId +"' target='_blank'>"+ title +"</a>" + " " + "<button "+isDisabled+" class='btn btn-sm btn-danger' "+ isDisabledCancel +" onclick='btnCancel("+ row.id +")' value='"+ value +"' style='width:70px'>Cancel</button></td>"
                }else{
                  if (row.status == 'UNAPPROVED') {
                    return "<td>"+ btnDetailUnApproved + " " + "<button "+isDisabled+" class='btn btn-sm btn-danger' "+ isDisabledCancel +" onclick='btnCancel("+ row.id +")' value='"+ value +"' style='width:70px'>Cancel</button></td>"
                  }else if (row.status == 'REJECT') {
                    return "<td>"+ btnDetailUnApproved +"<a onclick='"+ onclick +"' "+isDisabled+" style='width:70px' class='btn btn-sm "+ btnClass +" btnCekDraftDusk_"+row.id+"' data-value='"+row.id+"' id='"+ btnId +"' target='_blank'>"+ title +"</a>" + " " + "<button "+isDisabled+" class='btn btn-sm btn-danger' "+ isDisabledCancel +" onclick='btnCancel("+ row.id +")' value='"+ value +"' style='width:70px'>Cancel</button></td>"
                  }else{
                    return "<td>"+ btnDetailUnApproved +"<a onclick='"+ onclick +"' "+isDisabled+" style='width:70px' class='btn btn-sm "+ btnClass +" btnCekDraftDusk_"+row.id+"' data-value='"+row.id+"' id='"+ btnId +"' target='_blank'>"+ title +"</a>" + " " + "<button "+isDisabled+" class='btn btn-sm btn-danger' "+ isDisabledCancel +" onclick='btnCancel("+ row.id +")' value='"+ value +"' style='width:70px'>Cancel</button></td>"
                  }
                }
                
              }
                                  
            },
            className:'text-center',
            "bSortable":false,
            width:"250px"
          },//action
          // {
          //   "data":"status_numerical",
          //   "visible":false,
          //   "targets":[5]
          // },
          {
            "data":"created_at",
            "visible":false,
            "targets":[1],
          },
        ],
        drawCallback: function(settings) {
          if (accesable.includes("btnCekDraft")) {
            $(".btnCekDraft").prop("disabled",false)
          }
        },
        columnDefs: [
          { width: '40%', targets: 2 },
          { width: '10%', targets: 1 }
        ],
        "pageLength":100,
        lengthChange:false,
        // autoWidth:true,
        scrollX:        true,
        scrollCollapse: true,
        // paging:         false,
        // fixedColumns:   {
        //   leftColumns: 1,
        //   rightColumns: 1
        // },
        processing:true,
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
        initComplete: function () {
          InitiateFilterParam()
          $("#inputRangeDate").prop('disabled',false)
          $.each($("#selectShowColumnTicket li input"),function(index,item){
            var column = $("#draftPr").DataTable().column(index)
            // column.visible() ? $(item).addClass('active') : $(item).removeClass('active')
            $(item).prop('checked', column.visible())
          })
        }
    })

    if ("{{Auth::User()->id_territory}}" == 'TERRITORY 4') {
      $("#addDraftPr").show()
    }
    
    function changeColumnTable(data){
      var column = $("#draftPr").DataTable().column($(data).attr("data-column"))
      column.visible( ! column.visible() );
    }

    function InitiateFilterParam(arrStatusBack,arrTypeBack){
      $.ajax({
        url:"{{url('/admin/getDropdownFilterPr')}}",
        type:"GET",
        success:function(result){
          var arrStatus = result.dataStatus;

          if (arrStatusBack == undefined) {
            $("#inputFilterStatus").select2({
              placeholder: " Select Status",
              // allowClear: true,
              multiple:true,
              data:arrStatus,
              closeOnSelect:true,
            })
          }else{
            $("#inputFilterStatus").select2({
              placeholder: " Select Status",
              // allowClear: true,
              multiple:true,
              data:arrStatus,
              closeOnSelect:true,
            }).val(arrStatusBack).change()
          }

          // $("#inputFilterUser").select2().val("");
          var arrUser = result.dataUser
          $("#inputFilterUser").select2({
            placeholder: " Select User",
            // allowClear: true,
            multiple:true,
            data:arrUser,
            closeOnSelect:true,
          })

          if (arrTypeBack == undefined) {
            $("#inputFilterTypePr").select2({
              placeholder: "Select a Type",
              // allowClear: true,
              data:result.data_type_letter,
              multiple:true,
              closeOnSelect:true,
            })
          }else{
            $("#inputFilterTypePr").select2({
              placeholder: "Select a Type",
              // allowClear: true,
              data:result.data_type_letter,
              multiple:true,
              closeOnSelect:true,
            }).val(arrTypeBack).change()
          }
        }
      })
    }  

    function showFilterData(temp,arrStatusBack,arrTypeBack){
      $("#draftPr").DataTable().ajax.url("{{url('/admin/getFilterDraft')}}" + temp).load()
      InitiateFilterParam(arrStatusBack,arrTypeBack)
    }  

    function sortingByDashboard(value){
      var tempType = 'type_of_letter[]=', tempStatus = 'status[]=', tempUser = 'user[]=', tempStartDate = 'startDate=', tempEndDate = 'endDate=', tempAnything = 'searchFor='

      if (tempStatus == 'status[]=') {
        tempStatus = tempStatus + value
      }else{
        tempStatus = tempStatus + 'status[]=' + value
      }

      var temp = '?' + tempType + '&' + tempStatus + '&' + tempUser + '&' + tempStartDate + '&' + tempEndDate + '&' + tempAnything
      
      showFilterData(temp)
    }

    function searchCustom(startDate,endDate){
      var tempType = 'type_of_letter[]=', tempStatus = 'status[]=', tempUser = 'user[]=', tempStartDate = 'startDate=', tempEndDate = 'endDate=', tempAnything = 'searchFor='

      $.each($('#inputFilterStatus').val(),function(key,value){
        if (tempStatus == 'status[]=') {
          tempStatus = tempStatus + value
        }else{
          tempStatus = tempStatus + '&status[]=' + value
        }

        if(value == ''){
          localStorage.removeItem("arrFilterBack")
        }
      })

      $.each($('#inputFilterUser').val(),function(key,value){
        if (tempUser == 'user[]=') {
          tempUser = tempUser + value
        }else{
          tempUser = tempUser + '&user[]=' + value
        }

        if(value == ''){
          localStorage.removeItem("arrFilterBack")
        }
      })

      $.each($('#inputFilterTypePr').val(),function(key,value){
        if (tempType == 'type_of_letter[]=') {
          tempType = tempType + value
        }else{
          tempType = tempType + '&type_of_letter[]=' + value
        }

        if(value == ''){
          localStorage.removeItem("arrFilterBack")
        }
      })

      tempAnything = tempAnything + $("#inputSearchAnything").val()

      if($("#inputSearchAnything").val() == ''){
        localStorage.removeItem("arrFilterBack")
      }

      if (startDate != undefined) {
        tempStartDate = tempStartDate + startDate
      }else{
        localStorage.removeItem("arrFilterBack")
      }

      if (endDate != undefined) {
        tempEndDate = tempEndDate + endDate
      }else{
        localStorage.removeItem("arrFilterBack")
      }

      var temp = "?" + tempType + '&' + tempStatus + '&' + tempUser + '&' + tempStartDate + '&' + tempEndDate + '&' + tempAnything
      showFilterData(temp)
      DashboardCounterFilter(temp)

      if (tempStatus || tempType) {
        localStorage.setItem('isTemp',true)
        // localStorage.setItem("arrFilterBack",true)
      }else{
        localStorage.setItem('isTemp',false)
        // localStorage.removeItem("arrFilterBack",true)
      }

      return localStorage.setItem("arrFilter", temp) 
    }

    window.onload = function() {
      localStorage.setItem("arrFilterBack",localStorage.getItem("arrFilter"))

      if (localStorage.getItem("arrFilterBack") != undefined) {
        var arrStatus = [], arrType = [], arr = []
        if (localStorage.getItem("arrFilter")) {
            // 
          arr = localStorage.getItem("arrFilter").split("?")[1].split("&")

          if (localStorage.getItem("arrFilter").split("?")[1].split("&")[0].split('=')[1] != '') {
              $.each(arr,function(item,value){
              if(value.indexOf("type") != -1){
                arrType.push(value.split("=")[1])
              }
            })
          }

          if(localStorage.getItem("arrFilter").split("?")[1].split("&")[1].split('=')[1] != ''){
              $.each(arr,function(item,value){
              if(value.indexOf("status") != -1){
                arrStatus.push(value.split("=")[1])
              }
            })
          }

          if (localStorage.getItem('isTemp') === 'true') {
            var returnArray = searchCustom()
            localStorage.setItem("arrFilter", returnArray);
          }else{
            localStorage.removeItem("arrFilterBack")
          }

          if(localStorage.getItem("arrFilterBack") != undefined && localStorage.getItem("arrFilterBack") != null && localStorage.getItem("arrFilterBack") != ''){
            // window.history.pushState(null,null,location.protocol + '//' + location.host + location.pathname + localStorage.getItem("arrFilterBack"))
            // DashboardCounterFilter(localStorage.getItem("arrFilterBack"))
            var arr = localStorage.getItem("arrFilterBack").split("?")[1].split("&")
            var arrStatus = [], arrType = []

            $.each(arr,function(item,value){
              if(value.indexOf("status") != -1){
                  arrStatus.push(value.split("=")[1])
              }

              if(value.indexOf("type") != -1){
                  arrType.push(value.split("=")[1])
              }
            })
          }
          InitiateFilterParam(arrStatus,arrType)
        } 
      }
    }

    $('#clearFilterTable').click(function(){
      localStorage.setItem('isTemp',false)
      $('#inputSearchAnything').val('')
      $("#inputFilterTypePr").empty();
      $("#inputFilterStatus").empty();
      $("#inputFilterUser").empty();
      DashboardCounterFilter()
      localStorage.removeItem("arrFilterBack");
      localStorage.removeItem("arrFilter");
      InitiateFilterParam()
      $("#inputRangeDate").val("")
      $('#inputRangeDate').html("")
      $('#inputRangeDate').html('<i class="bx bx-calendar"></i> <span> Date range <i class="bx bx-caret-down"></i></span>');
      $('#draftPr').DataTable().ajax.url("{{url('/admin/getDraftPr')}}").load();
    });

    $('#reloadTable').click(function(){
      localStorage.setItem('isTemp',false)  
      $('#inputSearchAnything').val('')
      $("#inputFilterTypePr").empty();
      $("#inputFilterStatus").empty();
      $("#inputFilterUser").empty();
      DashboardCounterFilter()
      localStorage.removeItem("arrFilterBack");
      localStorage.removeItem("arrFilter");
      InitiateFilterParam()
      $("#inputRangeDate").val("")
      $('#inputRangeDate').html("")
      $('#inputRangeDate').html('<i class="bx bx-calendar"></i> <span> Date range <i class="bx bx-caret-down"></i></span>');
      $('#draftPr').DataTable().ajax.url("{{url('/admin/getDraftPr')}}").load();
    });

    function changeNumberEntries(number){
      $("#btnShowEntryTicket").html('Show ' + number + ' <span class="bx bx-caret-down"></span>')
      $("#selectShowEntryTicket").find("li").removeClass("active")
      $("#selectShowEntryTicket").find("li#"+number).addClass("active")
      $("#draftPr").DataTable().page.len( number ).draw();
    }

    $('#inputRangeDate').daterangepicker({
      ranges: {
        'Today'       : [moment(), moment()],
        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate: moment()
    },function (start, end) {
      $('#inputRangeDate').html("")
      $('#inputRangeDate').html('<i class="bx bx-calendar"></i> <span>' + start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY') + '</span>&nbsp<i class="bx bx-caret-down"></i>');

      var startDay = start.format('YYYY-MM-DD');
      var endDay = end.format('YYYY-MM-DD');

      $("#startDateFilter").val(startDay)
      $("#endDateFilter").val(endDay)

      startDate = start.format('D MMMM YYYY');
      endDate = end.format('D MMMM YYYY');

      if (startDay != undefined && endDay != undefined) {
        searchCustom(startDay,endDay)
      }
    });

    localStorage.setItem('firstLaunch', true);
    localStorage.setItem('isStoreSupplier',false);

    //ini buat alert diatas
    function reasonReject(item,display,nameClass){
      $(".divReasonRejectRevision").remove()

      var textTitle = ""
      var className = ""

      if (nameClass == 'tabGroup') {
        textTitle = "Note Reject PR"
        className = "tabGroup"
      }else{
        textTitle = "Alert Error!"
        className = nameClass
      }
      
      var append = ""

      append = append + '<div class="alert alert-danger divReasonRejectRevision" style="display:none!important">'
        append = append + '<h6><i class="icon bx bx-alert"></i>'+ textTitle +'</h6>'
        append = append + '<p class="reason_reject_revision">'+item.replaceAll("\n","<br>")+'</p>'
      append = append + '</div>'

      $("." + nameClass).prepend(append)

      if (display == "block") {
        $(".divReasonRejectRevision").show()
      }
    }

    function unfinishedDraft(n,id_draft,status){
      localStorage.setItem('firstLaunch', false);
      localStorage.setItem('no_pr',id_draft)
      localStorage.setItem('status_unfinished',status)

      if (status == 'revision') {
        url = "{{url('/admin/getDetailPr')}}"
      }else{
        url = "{{url('/admin/getPreviewPr')}}"
      }
      $.ajax({
        type: "GET",
        url: url,
        data: {
          no_pr:id_draft,
        },
        success: function(result) {
          if (status == 'revision') {
            localStorage.setItem("id_compare_pr",result.id_compare_pr)
            if (result.pr.status_draft_pr == "pembanding") {
              localStorage.setItem("status_pr","revision")
            }else{
              localStorage.setItem("status_pr","")
            }
          }else{
            localStorage.setItem('no_pr',id_draft)
          }

          var x = document.getElementsByClassName("tab-add");
          x[n].style.display = "inline";
          x[n].classList.remove('d-none');
          if (n == (x.length - 1)) {
            $(".modal-dialog").addClass('modal-lg')
            $("#prevBtnAdd").attr('onclick','nextPrevUnFinished(-1,"saved")')        
            $("#nextBtnAdd").attr('onclick','nextPrevUnFinished(1,"saved")')
            $(".modal-title").text('')
            document.getElementById("prevBtnAdd").style.display = "inline";
            $("#headerPreviewFinal").empty()
            document.getElementById("nextBtnAdd").innerHTML = "Create";
            $("#nextBtnAdd").attr('onclick','createPR("'+ status +'")');  

            if ($("#selectType").val() == 'IPR') {
              PRType = '<b>Internal Purchase Request</b>'
            }else{
              PRType = '<b>External Purchase Request</b>'
            }

            PRMethode = $("#selectMethode").find(":selected").text()
            leadRegister = $("#selectLeadId").val()
            quoteNumber = $("#selectQuoteNumber").val() 
            
            var appendHeader = ""
            appendHeader = appendHeader + '<div class="row">'
            appendHeader = appendHeader + '    <div class="col-md-6">'
            appendHeader = appendHeader + '        <div class="">To: '+ result.pr.to +'</div>'
            appendHeader = appendHeader + '        <div class="">Email: ' + result.pr.email + '</div>'
            appendHeader = appendHeader + '        <div class="">Phone: ' + result.pr.phone + '</div>'
            appendHeader = appendHeader + '        <div class="">Fax: '+ result.pr.fax +' </div>'
            appendHeader = appendHeader + '        <div class="">Attention: '+ result.pr.attention +'</div>'
            appendHeader = appendHeader + '        <div class="">From: '+ result.pr.name +'</div>'
            appendHeader = appendHeader + '        <div class="">Subject: '+ result.pr.title +'</div>'
            appendHeader = appendHeader + '        <div class="" style="width:fit-content;word-wrap: break-word;">Address: '+ result.pr.address +'</div>'

            appendHeader = appendHeader + '    </div>'
            if (window.matchMedia("(max-width: 768px)").matches)
            {
                appendHeader = appendHeader + '    <div class="col-md-6">'
                // The viewport is less than 768 pixels wide
                
            } else {
                appendHeader = appendHeader + '    <div class="col-md-6" style="text-align:end">'
                // The viewport is at least 768 pixels wide
                
            }
            appendHeader = appendHeader + '        <div>'+ PRType +'</div>'
            appendHeader = appendHeader + '        <div><b>Request Methode</b></div>'
            appendHeader = appendHeader + '        <div>'+ result.pr.request_method +'</div>'
            appendHeader = appendHeader + '        <div>'+ moment(result.pr.created_at).format('DD MMMM') +'</div>'
            if (PRType == 'EPR') {
              appendHeader = appendHeader + '        <div><b>Lead Register</b></div>'
              appendHeader = appendHeader + '        <div>'+ result.pr.lead_id +'</div>'
              appendHeader = appendHeader + '        <div><b>Quote Number</b></div>'
              appendHeader = appendHeader + '        <div>'+ result.pr.quote_number +'</div>'
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
                append = append + "<input data-value='' disabled style='font-size: 12px;width:200px' class='form-control' type='' name='' value='"+ item.name_product + "'>"
                append = append + '</td>'
                append = append + '<td width="40%">'
                  append = append + '<textarea disabled class="form-control" style="resize: none;height: 120px;font-size: 12px;width:400px">' + item.description.replaceAll("<br>","\n") + '&#10;&#10;' + 'SN : ' + item.serial_number + '&#10;PN : ' + '\n' + item.part_number + '\n\n' + item.for  + '</textarea>'
                append = append + '</td>'
                append = append + '<td width="5%">'
                  append = append + '<input disabled class="form-control" type="" name="" value="'+ item.qty +'" style="width:45px;font-size: 12px; important">'
                append = append + '</td>'
                append = append + '<td width="5%">'
                  append = append + '<select disabled style="width:75px;font-size: 12px; important" class="form-control">'
                  append = append + '<option>' + item.unit.charAt(0).toUpperCase() + item.unit.slice(1) + '</option>'
                  append = append + '</select>'
                append = append + '</td>'
                append = append + '<td width="15%">'
                  append = append + '<input disabled class="form-control" type="" name="" value="'+ formatter.format(item.nominal_product) +'" style="width:100px;font-size: 12px; important">'
                append = append + '</td>'
                append = append + '<td width="15%">'
                  append = append + '<input disabled id="grandTotalPreview" class="form-control grandTotalPreview" type="" name="" value="'+ formatter.format(item.grand_total) +'" style="width:100px;font-size: 12px; important">'
                append = append + '</td>'
              append = append + '</tr>'
            })

            $("#tbodyFinalPageProducts").append(append)

            $("#bottomPreviewFinal").empty()        
            appendBottom = ""
            appendBottom = appendBottom + '<hr>'
            appendBottom = appendBottom + '<div class="form-group">'
            appendBottom = appendBottom + '  <div class="row">'
            appendBottom = appendBottom + '    <div class="col-md-12 col-xs-12">'
            appendBottom = appendBottom + '      <div class="pull-right">'
            appendBottom = appendBottom + '        <span style="display: inline;margin-right: 15px;">Total</span>'
            appendBottom = appendBottom + '        <input disabled type="text" style="width:250px;display: inline;text-align:right" id="inputGrandTotalProduct_unfinishPreview" class="form-control inputGrandTotalProduct_unfinishPreview">'
            appendBottom = appendBottom + '      </div>'
            appendBottom = appendBottom + '    </div>'
            appendBottom = appendBottom + '  </div>'

            appendBottom = appendBottom + ' <div class="row" style="margin-top: 10px;">'
              appendBottom = appendBottom + '    <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + '      <div class="pull-right">'
              appendBottom = appendBottom + '        <span style="display: inline;margin-right: 15px;">Discount <span class="title_discount"></span></span>'
              appendBottom = appendBottom + '        <input disabled type="text" style="width:250px;display: inline;text-align:right" class="form-control inputDiscount_unfinishPreview" id="inputDiscount_unfinishPreview" name="inputDiscount_unfinishPreview">'
              appendBottom = appendBottom + '      </div>'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
            appendBottom = appendBottom + '</div>'

            appendBottom = appendBottom + ' <div class="row" style="margin-top: 10px;">'
              appendBottom = appendBottom + '    <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + '      <div class="pull-right">'
              appendBottom = appendBottom + '        <span style="display: inline;margin-right: 15px;">Tax Base Other <span class="title_base_other"></span></span>'
              appendBottom = appendBottom + '        <input disabled type="text" style="width:250px;display: inline;text-align:right" class="form-control inputTextBaseOther_unfinishPreview" id="inputTextBaseOther_unfinishPreview" name="inputTextBaseOther_unfinishPreview">'
              appendBottom = appendBottom + '      </div>'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
            appendBottom = appendBottom + '</div>'

            appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
              appendBottom = appendBottom + ' <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + ' <div class="pull-right" style="display:flex">'
                appendBottom = appendBottom + '  <span style="margin-right: 15px;margin-top:8px;display:inline-flex">Vat <span class="title_tax"></span>'
              appendBottom = appendBottom + '  </span>'
              appendBottom = appendBottom + '  <div class="input-group" style="display: inline-flex;">'
              appendBottom = appendBottom + '   <input disabled type="text" class="form-control vat_tax" id="vat_tax_unfinishPreview" name=""vat_tax_unfinishPreview" style="width:250px;display:inline;text-align:right">'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
              appendBottom = appendBottom + ' </div>'
              appendBottom = appendBottom + '</div>'
            appendBottom = appendBottom + '</div>'

            appendBottom = appendBottom + ' <div class="row" style="margin-top: 10px;">'
              appendBottom = appendBottom + '    <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + '      <div class="pull-right">'
              appendBottom = appendBottom + '        <span style="display: inline;margin-right: 15px;">PB1 <span class="title_pb1"></span></span>'
              appendBottom = appendBottom + '        <input disabled type="text" style="width:250px;display: inline;text-align:right" class="form-control inputPb1_unfinishPreview" id="inputPb1_unfinishPreview" name="inputPb1_unfinishPreview">'
              appendBottom = appendBottom + '      </div>'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
            appendBottom = appendBottom + '</div>'

            appendBottom = appendBottom + ' <div class="row" style="margin-top: 10px;">'
              appendBottom = appendBottom + '    <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + '      <div class="pull-right">'
              appendBottom = appendBottom + '        <span style="display: inline;margin-right: 15px;">Service Charge <span class="title_service"></span></span>'
              appendBottom = appendBottom + '        <input disabled type="text" style="width:250px;display: inline;text-align:right" class="form-control inputServiceCharge_unfinishPreview" id="inputServiceCharge_unfinishPreview" name="inputServiceCharge_unfinishPreview">'
              appendBottom = appendBottom + '      </div>'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
            appendBottom = appendBottom + '</div>'

            appendBottom = appendBottom + ' <div class="row" style="margin-top: 10px;">'
              appendBottom = appendBottom + '    <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + '      <div class="pull-right">'
              appendBottom = appendBottom + '        <span style="display: inline;margin-right: 15px;">Grand Price</span>'
              appendBottom = appendBottom + '        <input disabled type="text" style="width:250px;display: inline;text-align:right" class="form-control inputFinalPageGrandPrice_unfinishPreview" id="inputFinalPageGrandPrice" name="inputFinalPageGrandPrice_unfinishPreview">'
              appendBottom = appendBottom + '      </div>'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
            appendBottom = appendBottom + '</div>'
            appendBottom = appendBottom + '<hr>'
            appendBottom = appendBottom + '<span style="display:block;text-align:center"><b>Terms & Condition</b></span>'
            appendBottom = appendBottom + '<div class="form-control" id="termPreview" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221);overflow:auto"></div>'
            appendBottom = appendBottom + '<hr>'
            appendBottom = appendBottom + '<span><b>Attached Files</b><span>'
            var pdf = "bx bx-fw bxs-file-pdf"
            var image = "bx bx-fw bxs-file-image"
            if (result.dokumen[0].dokumen_location.split(".")[1] == 'pdf') {
              var fa_doc = pdf
            }else{
              var fa_doc = image
            }
            if (result.pr.type_of_letter == 'IPR') {
              appendBottom = appendBottom + '<div class="form-group" style="font-size: reguler;">'
                appendBottom = appendBottom + '<div class="row">'
                  appendBottom = appendBottom + '<div class="col-md-6">'
                    appendBottom = appendBottom + '<div style="border: 1px solid #787bff !important;padding: 5px;"><a href="'+result.dokumen[0].link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ result.dokumen[0].dokumen_location.substring(0,15) + '....'+ result.dokumen[0].dokumen_location.split(".")[0].substring(result.dokumen[0].dokumen_location.length -10) + "." + result.dokumen[0].dokumen_location.split(".")[1] +'</a>'
                    appendBottom = appendBottom + '</div>'
                  appendBottom = appendBottom + '</div>'
                  appendBottom = appendBottom + '<div class="col-md-6">'
                    appendBottom = appendBottom + '<div style="padding: 5px;">Penawaan Harga</div>'
                  appendBottom = appendBottom + '</div>'
                appendBottom = appendBottom + '</div>'
              appendBottom = appendBottom + '</div>'
              
              $.each(result.dokumen,function(value,item){
                if (item.dokumen_location.split(".")[1] == 'pdf') {
                  var fa_doc = pdf
                }else{
                  var fa_doc = image
                }
                if (value != 0) {
                  appendBottom = appendBottom + '<div class="form-group" style="font-size: reguler;">'
                    appendBottom = appendBottom + '<div class="row">'
                      appendBottom = appendBottom + '<div class="col-md-6">'
                        appendBottom = appendBottom + '<div style="border: 1px solid #787bff !important;padding: 5px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
                        appendBottom = appendBottom + '</div>'
                      appendBottom = appendBottom + '</div>'
                      appendBottom = appendBottom + '<div class="col-md-6">'
                        appendBottom = appendBottom + '<div style="padding: 5px;">Dokumen Pendukung : &nbsp'+ item.dokumen_name +'</div>'
                      appendBottom = appendBottom + '</div>'
                    appendBottom = appendBottom + '</div>'
                  appendBottom = appendBottom + '</div>'
                }        
              })
            }else{        
              $.each(result.dokumen,function(value,item){
                if (item.dokumen_location.split(".")[1] == 'pdf') {
                    var fa_doc = pdf
                  }else{
                    var fa_doc = image
                  }
                  appendBottom = appendBottom + '<div class="form-group" style="font-size: reguler;">'
                    appendBottom = appendBottom + '<div class="row">'
                      appendBottom = appendBottom + '<div class="col-md-6">'
                        appendBottom = appendBottom + '<div style="border: 1px solid #787bff !important;padding: 5px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
                        appendBottom = appendBottom + '</div>'
                      appendBottom = appendBottom + '</div>'
                      appendBottom = appendBottom + '<div class="col-md-6">'
                        appendBottom = appendBottom + '<div style="padding: 5px;">Dokumen &nbsp'+ item.dokumen_name +'</div>'
                      appendBottom = appendBottom + '</div>'
                    appendBottom = appendBottom + '</div>'
                  appendBottom = appendBottom + '</div>'      
              })
            }      

            $("#bottomPreviewFinal").append(appendBottom)
                            
            if(result.pr.term_payment != null){
              $("#termPreview").html(result.pr.term_payment.replaceAll("&lt;br&gt;","<br>"))
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
            var valueVat = ""

            $('.grandTotalPreview').each(function() {
                var temp = parseFloat($(this).val() == "" ? "0" : parseFloat($(this).val().replace(/\./g,'').replace(',','.').replace(' ','')))
                sum += temp;
            });

            if (result.pr.status_tax == false) {
              valueVat = 'false'
            }else{
              valueVat = result.pr.status_tax
            }

            tempDiscount = $("#inputDiscountNominal").val() == 0?false:parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ','') / parseFloat(sum) * 100)

            if (!isNaN(valueVat)) {
              setTimeout(function(){
                tempVat = $("#inputDiscount_unfinishPreview").val() == 0 ? Math.round((parseFloat(sum)) * (valueVat == false?0:parseFloat(valueVat) / 100)) : Math.round((parseFloat(sum) - parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ',''))) * (valueVat == false?0:parseFloat(valueVat) / 100))

                console.log(tempVat + "sini")
                console.log(isNaN(tempVat) + "sini")

                finalVat = tempVat

                finalGrand = tempGrand

                tempTotal = parseFloat(sum)

                if (valueVat == 11) {
                  valueVat = 12
                }else if (valueVat == 1.1) {
                  valueVat = 1.2
                }else{
                  valueVat
                }

                $('.title_tax').text(valueVat == '' || valueVat == null ?"":valueVat + '%')

                $("#vat_tax").val(formatter.format(isNaN(tempVat)?0:tempVat))
              },500)
            }

            // else{
            //   tempVat = Math.round((parseFloat(sum) * ($("#vat_tax").val() == ""?0:parseFloat($("#vat_tax").val())) / 100))
              
            //   finalVat = tempVat

            //   finalGrand = tempGrand

            //   tempTotal = parseFloat(sum)
              
            //   $('.title_tax').text($("#vat_tax").val() == "" ||$("#vat_tax").val() == 0?"":$('.title_tax').text().replace("%","") + '%')
            // }

            setTimeout(function(){
              $('.title_pb1').text(result.pr.tax_pb == 'false' || result.pr.tax_pb == 0?"":result.pr.tax_pb+"%")
              $('.title_service').text(result.pr.service_charge == 'false' || result.pr.service_charge == 0?"":result.pr.service_charge+"%")
              $('.title_discount').text(result.pr.discount == 'false' || result.pr.discount == 0?"":parseFloat(result.pr.discount).toFixed(2)+"%")

              tempPb1 = Math.round((parseFloat(sum) - (parseFloat(sum) * tempDiscount/100)) * (result.pr.tax_pb == null || result.pr.tax_pb == "false"?0:parseFloat(result.pr.tax_pb) / 100))

              tempService = Math.round((parseFloat(sum) - (parseFloat(sum) * tempDiscount/100)) * (result.pr.service_charge == null || result.pr.service_charge == "false"?0:parseFloat(result.pr.service_charge) / 100))

              tempDiscount = Math.round(parseFloat(sum) * (result.pr.discount == null || result.pr.discount == 'false'?0:parseFloat(result.pr.discount) / 100))
              
              $("#vat_tax_unfinishPreview").val(formatter.format(tempVat))
              $("#inputPb1_unfinishPreview").val(formatter.format(tempPb1))
              $("#inputTextBaseOther_unfinishPreview").val(formatter.format(customRound(formatter.format((tempTotal - tempDiscount)*11/12))))
              $("#inputServiceCharge_unfinishPreview").val(formatter.format(tempService))
              $("#inputDiscount_unfinishPreview").val(formatter.format(tempDiscount))
              $("#inputGrandTotalProduct_unfinishPreview").val(formatter.format(sum))
              $("#inputFinalPageGrandPrice").val(formatter.format(result.grand_total))
            },500)

            if (status == 'reject' || status == 'revision') {
              reasonReject(result.activity.reason,"block","tabGroup")
            }                               

            if (window.location.href.split("/")[5] != undefined) {
              if (window.location.href.split("/")[5].split("?")[1].split("=")[1] == 'reject' || window.location.href.split("/")[5].split("?")[1].split("=")[1] == 'revision') {
                reasonReject(result.activity.reason,"block","tabGroup")
              }
            }
            
          } else {
            if (n == 0) {
              //reinitiate
              $("#inputTo").val("")
              $("#selectType").val("")
              $("#inputEmail").val("")
              $("#inputPhone").val("")
              // $("#inputFax").val("")
              $("#inputAttention").val("")
              $("#inputSubject").val("")
              $("#inputAddress").val("")

              $.ajax({
                url:"{{url('/admin/getSupplier')}}",
                type:"GET",
                success:function(results){
                  $("#selectTo").select2({
                    data:results,
                    placeholder:"Select Supplier",
                    dropdownParent:$("#ModalDraftPr .modal-body")
                  }).val(result.pr.to).trigger("change")

                  $("#selectTo").change(function(){
                    $.ajax({
                      url:"{{url('/admin/getSupplierDetail')}}",
                      type:"GET",
                      data:{
                        to:this.value
                      },success:function(result){
                        $.each(result,function(index,value){
                          $("#inputEmail").val(value.email)
                          $("#inputPhone").val(value.phone)
                          $("#inputAddress").val(value.address)
                        })
                      }
                    })
                  })
                }
              })   

              ///////////////

              $("#otherTo").click(function(){
                $("#divInputTo").show("slow")
              })

              $(".close").click(function(){
                $("#divInputTo").hide("slow")
              }) 

              // $("#inputTo").val(result.pr.to)
              $("#selectType").val(result.pr.type_of_letter)
              $("#inputEmail").val(result.pr.email)
              $("#inputPhone").val(result.pr.phone)
              // $("#inputFax").val(result.pr.fax)
              $("#inputAttention").val(result.pr.attention)
              $("#inputSubject").val(result.pr.title)
              $("#inputAddress").val(result.pr.address)
              if (result.pr.request_method == 'Reimbursement') {
                $("#selectMethode").val('reimbursement')
              }else if (result.pr.request_method == 'Purchase Order') {
                $("#selectMethode").val('purchase_order')
              }else{
                $("#selectMethode").val('payment')
              }
              $("#selectCategory").val(result.pr.category)

              if (result.pr.isCommit == 'True') {
                $("#cbCommit").prop('checked',true)
              }

              const firstLaunch = localStorage.getItem('firstLaunch')
              document.getElementById("prevBtnAdd").style.display = "none!important";
              $(".modal-title").text('Information Supplier')
              $(".modal-dialog").removeClass('modal-lg')
 
              localStorage.setItem('no_pr',id_draft)
              if (status == 'reject') {
                if (result.verify.verify_type_of_letter == 'True'){
                  $("#selectType").prop("disabled",true)
                }
                if (result.verify.verify_category == 'True'){
                  $("#selectCategory").prop("disabled",true)
                }
                if (result.verify.verify_to == 'True'){
                  $("#inputTo").prop("disabled",true)
                }
                if (result.verify.verify_email == 'True'){
                  $("#inputEmail").prop("disabled",true)
                }
                if (result.verify.verify_phone == 'True'){
                  $("#inputPhone").prop("disabled",true)
                }
                if (result.verify.verify_attention == 'True'){
                  $("#inputAttention").prop("disabled",true)
                }
                if (result.verify.verify_title == 'True'){
                  $("#inputSubject").prop("disabled",true)
                }
                if (result.verify.verify_address == 'True'){
                  $("#inputAddress").prop("disabled",true)
                }
                if (result.verify.verify_request_method == 'True'){
                  $("#selectMethode").prop("disabled",true)
                }

                reasonReject(result.activity.reason,"block","tabGroup")

                $("#nextBtnAdd").attr('onclick','nextPrevUnFinished(2,"saved")')
              } else if (status == 'revision') {
                $(".divReasonRejectRevision").show()
                $(".reason_reject_revision").html(result.activity.reason.replaceAll("\n","<br>"))

                reasonReject(result.activity.reason,"block","tabGroup")

                $("#nextBtnAdd").attr('onclick','nextPrevUnFinished(2,"saved")')
              } else {
                if (firstLaunch == 'true') {
                  $("#nextBtnAdd").attr('onclick','nextPrevUnFinished(1,"saved")')
                }else{
                  $("#nextBtnAdd").attr('onclick','nextPrevUnFinished(2,"saved")')
                } 
              }
            } else if (n == 1) {
              select2TypeProduct()

              $(".modal-title").text('Information Product')
              $(".modal-dialog").removeClass('modal-lg')  

              //button add initiate product show form-group
              $("#btnInitiateAddProduct").click(function(){
                console.log(result.pr.category)
                console.log($("#selectCategory").val())

                var append = "", appendFrom = ""

                $("select[name='selectBudgetType']").closest(".form-group").remove()
                $("select[name='fromBudgetType']").closest(".form-group").remove() 
                if (result.pr.category == 'Perjalanan Dinas') {
                  append = append + '<div class="form-group">'
                    append = append + '<label>Budget Type*</label>'
                      append = append + '<select name="selectBudgetType" class="custom-form-control-select w-100" id="selectBudgetType" placeholder="Select Budget Type" onchange="fillInput(' + "'" + 'budget_type' + "'" + ')">'
                        append = append + '<option value="" disabled selected>Select Budget Type</option>'
                        append = append + '<option value="OPERASIONAL">OPERASIONAL</option>'
                        append = append + '<option value="NON-OPERASIONAL">NON-OPERASIONAL</option>'
                      append = append + '</select>'
                    append = append + '<span class="invalid-feedback" style="display:none;">Please fill Budget Type!</span>'
                  append = append + '</div>'

                  console.log(!$("#selectBudgetType").is(":visible"))
                  if (!$("#selectBudgetType").is(":visible")) {
                    $("#inputNameProduct").closest(".form-group").before(append)
                  }

                  $("#selectBudgetType").change(function(){
                    console.log(this.value)
                    if (this.value == 'OPERASIONAL') {
                      appendFrom = appendFrom + '<div class="form-group">'
                        appendFrom = appendFrom + '<label>For*</label>'
                          appendFrom = appendFrom + '<select name="fromBudgetType" class="form-control" id="fromBudgetType" placeholder="Select Budget Type" onchange="fillInput(' + "'" + 'fromBudgetType' + "'" + ')">'
                            appendFrom = appendFrom + '<option></option>'
                          appendFrom = appendFrom + '</select>'
                        appendFrom = appendFrom + '<span class="invalid-feedback" style="display:none;">Please fill Budget Type!</span>'
                      appendFrom = appendFrom + '</div>'

                      if ($("#selectBudgetType").closest(".form-group").next().find("#fromBudgetType").length == 0) {
                        console.log("sini lagi")
                        $("#selectBudgetType").closest(".form-group").after(appendFrom)

                        $("#fromBudgetType").select2({
                          // data:dataCategory,
                          placeholder:"Select User",
                          ajax: {
                            url: '{{url("admin/getUserOperasional")}}',
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                              return {
                                q:params.term
                              };
                            },
                            processResults: function(data, params) {
                              params.page = params.page || 1;
                              return {
                                  results: data,
                                  pagination: {
                                      more: (params.page * 10) < data.count_filtered
                                  }
                              };
                            },
                          },
                        })
                      }else{
                        console.log("cuman show lagi")

                        $("#fromBudgetType").closest(".form-group").show()
                      }                
                    }else{
                      console.log("ini hide")
                      var from = $("#fromBudgetType");
                      var option = new Option('', '', true, true);
                      from.append(option).trigger('change');

                      $("#fromBudgetType").closest(".form-group").attr('style','display:none!important')
                    }
                  })
                }

                $(".tabGroupInitiateAdd").attr('style','display:none!important')
                x[n].children[1].style.display = 'inline'
                $("#inputNameProduct").val('')
                $("#inputDescProduct").val('')
                $("#inputQtyProduct").val('')
                $("#selectTypeProduct").val('')
                $("#inputPriceProduct").val('')
                $("#inputSerialNumber").val('')
                $("#inputPartNumber").val('')
                $("#inputTotalPrice").val('')

                if ($("#selectTypeProduct").val() == '') {
                  select2TypeProduct()
                }
              })

              if (status == 'admin') {
                $("#nextBtnAdd").attr('onclick','nextPrevAddAdmin(1,'+ id_draft +')')
              }else{
                $("#nextBtnAdd").attr('onclick','nextPrevUnFinished(1,"saved")')
                $("#prevBtnAdd").attr('onclick','nextPrevUnFinished(-1,"saved")')     
              }
              if (localStorage.getItem('isEditProduct') == 'true') {
                document.getElementById("prevBtnAdd").style.display = "none";
              } else {
                document.getElementById("prevBtnAdd").style.display = "inline";
              }  
              localStorage.setItem('no_pr',id_draft)
            } else if(n == 2){
              $(".modal-title").text('')
              $("#nextBtnAdd").removeAttr('onclick')
              $(".modal-dialog").addClass('modal-lg')
              localStorage.setItem('firstLaunch',false)
              addTable(0,result.pr.status_tax,result)

              if (localStorage.getItem('firstLaunch') == 'false') {
                $("#prevBtnAdd").attr('onclick','nextPrevUnFinished(-2,"saved")')
                $("#nextBtnAdd").attr('onclick','nextPrevUnFinished(1,"saved")')
              }else{
                $("#prevBtnAdd").attr('onclick','nextPrevUnFinished(-1,"saved")')
              } 
              document.getElementById("prevBtnAdd").style.display = "inline";
              localStorage.setItem('no_pr',id_draft)
            } else if (n == 3) {
              localStorage.setItem('status_draft_pr',result.pr.status_draft_pr)
              $(".modal-dialog").removeClass('modal-lg')
              if ($("#selectType").val() == 'EPR') {
                $(".modal-title").text('External Purchase Request')
                $("#formForPrExternal").show()
                $("#formForPrInternal").attr('style','display:none!important')

                fillInput('spk')
                fillInput('sbe')
                fillInput('quoteSupplier')

                const fileSPK   = document.querySelector('input[type="file"][name="inputSPK"]');

                const fileSBE   = document.querySelector('input[type="file"][name="inputSBE"]');

                const fileQuote = document.querySelector('input[type="file"][name="inputQuoteSupplier"]');

                // Create a new File object
                if (status == 'revision') {
                  url = "{{url('/admin/getDetailPr')}}"                  
                }else{
                  url = "{{url('/admin/getPreviewPr')}}"
                }
                $.ajax({
                  type: "GET",
                  url: url,
                  data: {
                    no_pr:localStorage.getItem('no_pr'),
                  },
                  success:function(result){
                    var selectedPid     = result.pr.pid
                    var selectedLeadId  = result.pr.lead_id
                    // $("#selectLeadId").val(result.pr.lead_id).trigger("change")
                    // $("#selectQuoteNum").val(result.pr.quote_number).trigger("change")

                    $.ajax({
                      url: "{{url('/admin/getPidUnion')}}",
                      type: "GET",
                      success: function(result) {
                        if (selectedPid) {
                          $("#selectPid").val(selectedPid).trigger("change")
                        }

                        if (selectedLeadId) {
                          $("#selectPid").val(selectedPid).trigger("change")
                        }

                        $("#selectPid").select2({
                            placeholder: "Select/Input Pid",
                            dropdownParent: $('#ModalDraftPr .modal-body'),
                            tags: true,
                            data: result.data,
                        }).on('change', function() {
                          var data = $("#selectPid option:selected").text();
                          $("#selectLeadId").empty()
                          $.ajax({
                            url: "{{url('/admin/getLeadByPid')}}",
                            type: "GET",
                            data: {
                              pid:data
                            },
                            success: function(result) {
                              $("#selectLeadId").select2({
                                  data: result.data,
                                  placeholder: "Select Lead Register",
                                  dropdownParent: $('#ModalDraftPr .modal-body')
                              })

                              var lead_id = $("#selectLeadId option:selected").text();
                              $("#selectQuoteNumber").empty()

                              $.ajax({
                                url: "{{url('/admin/getQuote')}}",
                                type: "GET",
                                data:{
                                  lead_id:lead_id
                                },
                                success: function(result) {
                                  $("#selectQuoteNumber").select2({
                                      data: result.data,
                                      placeholder: "Select Quote Number",
                                      dropdownParent: $('#ModalDraftPr .modal-body')
                                  })
                                }
                              }) 

                              if (result.linkSbe.length > 0) {
                                const myFileSbe = new File(['{{asset("/")}}'+result.linkSbe[0].document_location], '/'+result.linkSbe[0].document_location,{
                                  type: 'text/plain',
                                  lastModified: new Date(),
                                });
                                // Now let's create a DataTransfer to get a FileList
                                const dataTransferSbe = new DataTransfer();
                                dataTransferSbe.items.add(myFileSbe);
                                fileSBE.files = dataTransferSbe.files;

                                $("#inputSBE").attr("disabled",true).css("cursor","not-allowed")
                                $("#inputSBE").closest(".form-group").find("#span_link_drive_sbe").show()
                                $("#link_sbe").attr("href",result.linkSbe[0].link_drive)
                              }
                            }
                          }) 

                         
                        })

                        if (status == 'reject' || status == 'revision' || status == 'saved') {
                          $("#selectPid").val(selectedPid).trigger("change")
                        }
                      }
                    })

                    if (status == 'reject') {
                      if (result.verify.verify_pid == 'True'){
                        $("#selectPid").prop("disabled",true)
                      }
                      if (result.verify.verify_lead_id == 'True'){
                        $("#selectLeadId").prop("disabled",true)
                      }
                      if (result.verify.verify_quote_number == 'True'){
                        $("#selectQuoteNumber").prop("disabled",true)
                      }

                      reasonReject(result.activity.reason,"block","tabGroup")

                    } else if (status == 'revision') {
                      reasonReject(result.activity.reason,"block","tabGroup")
                    } 

                    if (result.dokumen.length > 0) {
                      let formData = new FormData();

                      if (result.dokumen[0] !== undefined) {
                        const myFileQuote = new File(['{{asset("/")}}"'+ result.dokumen[0].dokumen_location +'"'], '/'+ result.dokumen[0].dokumen_location,{
                            type: 'text/plain',
                            lastModified: new Date(),
                        });

                        // Now let's create a DataTransfer to get a FileList
                        const dataTransferQuote = new DataTransfer();
                        dataTransferQuote.items.add(myFileQuote);
                        fileQuote.files = dataTransferQuote.files;

                        if (result.dokumen[0].link_drive != null) {
                          $("#span_link_drive_quoteSup").show()
                          $("#link_quoteSup").attr("href",result.dokumen[0].link_drive) 
                        }
                      }

                      if (result.dokumen[1] !== undefined) {
                        const myFileSpk = new File(['{{asset("/")}}"'+ result.dokumen[1].dokumen_location +'"'], '/'+ result.dokumen[1].dokumen_location,{
                            type: 'text/plain',
                            lastModified: new Date(),
                        });

                        // Now let's create a DataTransfer to get a FileList
                        const dataTransferSpk = new DataTransfer();
                        dataTransferSpk.items.add(myFileSpk);
                        fileSPK.files = dataTransferSpk.files;

                        if (result.dokumen[1].link_drive != null) {
                          $("#span_link_drive_spk").show()
                          $("#link_spk").attr("href",result.dokumen[1].link_drive) 
                        }
                      }

                      if (result.dokumen[2] !== undefined) {
                        const myFileSbe = new File(['{{asset("/")}}"'+ result.dokumen[2].dokumen_location +'"'], '/'+ result.dokumen[2].dokumen_location,{
                          type: 'text/plain',
                          lastModified: new Date(),
                        });
                        // Now let's create a DataTransfer to get a FileList
                        const dataTransferSbe = new DataTransfer();
                        dataTransferSbe.items.add(myFileSbe);
                        fileSBE.files = dataTransferSbe.files;

                        if (result.dokumen[2].link_drive != null) {
                          $("#span_link_drive_sbe").show()
                          $("#link_sbe").attr("href",result.dokumen[2].link_drive)
                        }
                      }                        

                      $("#tableDocPendukung_epr").empty()

                      if (result.dokumen.length > 3) {
                        $("#titleDoc_epr").css("display",'block')
                      }
                      appendDocPendukung = ""
                      $.each(result.dokumen,function(value,item){
                        if (value != 0 &&  value != 1 && value != 2) {
                          appendDocPendukung = appendDocPendukung + '<tr style="height:10px" class="trDocPendukung">'
                            appendDocPendukung = appendDocPendukung + "<td>"
                              appendDocPendukung = appendDocPendukung + '<button type="button" value="'+ item.id_dokumen +'" class="bx bx-x btnRemoveDocPendukung" data-value="remove_'+ value +'" style="display:inline;color:red;background-color:transparent;border:none"></button>&nbsp'
                                  appendDocPendukung = appendDocPendukung + '<div style="border: 1px solid #787bff !important;padding: 5px;color: #337ab7;display: inline-block;width:200px;background-color:darkgrey;cursor:not-allowed">'
                                    appendDocPendukung = appendDocPendukung + "<input style='font-family: inherit;width: 90px;color:grey' type='file' name='inputDocPendukung' id='inputDocPendukung' data-value='"+ item.id_dokumen +"' class='inputDocPendukung_"+value+"' disabled>"
                                   appendDocPendukung = appendDocPendukung + '</div>'
                                   appendDocPendukung = appendDocPendukung + "<br><a style='margin-left: 26px;font-family:Source Sans Pro,Helvetica Neue,Helvetica,Arial,sans-serif' href='"+ item.link_drive +"' target='_blank'><i class='bx bx-link'></i>&nbspLink drive</a>"
                            appendDocPendukung = appendDocPendukung + "</td>"
                            appendDocPendukung = appendDocPendukung + "<td>"
                              appendDocPendukung = appendDocPendukung + '<input style="width:250px;margin-left:20px" class="form-control inputNameDocPendukung_'+value+'" value="'+ item.dokumen_name +'" name="inputNameDocPendukung" id="inputNameDocPendukung" placeholder="ex : faktur pajak"><br>'
                            appendDocPendukung = appendDocPendukung + "</td>"
                          appendDocPendukung = appendDocPendukung + "</tr>"
                        }   
                      })
                      $("#tableDocPendukung_epr").append(appendDocPendukung)

                      $('#inputNameDocPendukung').keydown(function(){
                        
                        if ($('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung')).data('value').val() == "") {
                          $("#btnAddDocPendukung_epr").prop("disabled",true)
                          $("#btnAddDocPendukung_ipr").prop("disabled",true)
                        }else{
                          $("#btnAddDocPendukung_epr").prop("disabled",false)
                          $("#btnAddDocPendukung_ipr").prop("disabled",false)
                        }
                      })

                      $.each(result.dokumen,function(value,item){
                        if (value != 0 &&  value != 1 && value != 2) {
                          const filedocpendukung = document.querySelector('.inputDocPendukung_'+value);

                          const FilePendukung = new File(['{{asset("/")}}"'+ item.dokumen_location +'"'], '/'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1],{
                              type: 'text/plain',
                              lastModified: new Date(),
                          });

                          // Now let's create a DataTransfer to get a FileList
                          const dataTransfer = new DataTransfer();
                          dataTransfer.items.add(FilePendukung);
                          filedocpendukung.files = dataTransfer.files;

                          $('.inputNameDocPendukung_'+value).val(item.dokumen_name)
                        }

                        $(".btnRemoveDocPendukung[data-value='remove_" + value + "']").click(function(){
                          Swal.fire({
                            title: 'Are you sure?',
                            text: "Deleting document",
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
                                  url:"{{url('/admin/deleteDokumen/')}}",
                                  data:{
                                    _token:"{{ csrf_token() }}",
                                    id:this.value
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
                                  success: function(data)
                                  {
                                    Swal.showLoading()
                                    Swal.fire(
                                        'Document has been deleted!',
                                        'You can adding another document files',
                                        'success'
                                    ).then((result) => {
                                      if (result.value) {
                                        $(".btnRemoveDocPendukung[data-value='remove_" + value + "']").closest("tr").remove();
                                      }
                                    })
                                  }
                                })
                              }
                          })
                          if($('#tableDocPendukung_epr tr').length == 0){
                            $("#titleDoc_epr").attr('style','display:none!important')
                          }
                        })
                      })
                      
                    }
                  }
                })
              }else{
                $(".modal-title").text('Internal Purchase Request')
                $("#formForPrInternal").show()
                $("#formForPrExternal").attr('style','display:none!important')  

                fillInput('penawaranHarga')

                // Get a reference to our file input
                const fileInput = document.querySelector('input[type="file"][name="inputPenawaranHarga"]');
                if (status == 'revision') {
                  url = "{{url('/admin/getDetailPr')}}"
                }else{
                  url = "{{url('/admin/getPreviewPr')}}"
                }
                $.ajax({
                  type: "GET",
                  url: url,
                  data: {
                    no_pr:localStorage.getItem("no_pr"),
                  },
                  success:function(result){
                    if (status == 'reject') {
                      reasonReject(result.activity.reason,"block","tabGroup")

                    }else if (status == 'revision') {
                      reasonReject(result.activity.reason,"block","tabGroup")
                    }

                    var pdf = "bx bx-fw bxs-file-pdf"
                    var image = "bx bx-fw bxs-file-image"

                    if(result.dokumen.length > 0){
                      if (result.dokumen.length > 1) {
                        $("#titleDoc_ipr").show()
                      }
                      const myFile = new File(['{{asset("/")}}"'+ result.dokumen[0].dokumen_location +'"'], '/'+ result.dokumen[0].dokumen_location.substring(0,15) + '....'+ result.dokumen[0].dokumen_location.split(".")[0].substring(result.dokumen[0].dokumen_location.length -10) + "." + result.dokumen[0].dokumen_location.split(".")[1],{
                          type: 'text/plain',
                          lastModified: new Date(),
                      });

                      $("#span_link_drive_penawaranHarga").show()
                      $("#link_penawaran_harga").attr("href",result.dokumen[0].link_drive)                
                      // Now let's create a DataTransfer to get a FileList
                      const dataTransfer = new DataTransfer();
                      dataTransfer.items.add(myFile);
                      // dataTransfer.items.add(myFile);
                      fileInput.files = dataTransfer.files;
                    }    


                    $("#tableDocPendukung_ipr").empty()

                    appendDocPendukung = ""
                    $.each(result.dokumen,function(value,item){
                      if (value != 0) {
                        appendDocPendukung = appendDocPendukung + '<tr style="height:10px" class="trDocPendukung">'
                          appendDocPendukung = appendDocPendukung + "<td>"
                            appendDocPendukung = appendDocPendukung + '<button type="button" value="'+ item.id_dokumen +'" class="bx bx-x btnRemoveDocPendukung" data-value="remove_'+ value +'" style="display:inline;color:red;background-color:transparent;border:none"></button>&nbsp'
                                appendDocPendukung = appendDocPendukung + '<div style="border: 1px solid #787bff !important;padding: 5px;color: #337ab7;display: inline-block;width:200px;background-color:darkgrey;cursor:not-allowed">'
                                  appendDocPendukung = appendDocPendukung + "<input style='font-family: inherit;width: 90px;color:grey' type='file' name='inputDocPendukung' id='inputDocPendukung' data-value='"+ item.id_dokumen +"' class='inputDocPendukung_"+value+"' disabled>"
                                 appendDocPendukung = appendDocPendukung + '</div>'
                                 appendDocPendukung = appendDocPendukung + "<br><a style='margin-left: 26px;font-family:Source Sans Pro,Helvetica Neue,Helvetica,Arial,sans-serif' href='"+ item.link_drive +"' target='_blank'><i class='bx bx-link'></i>&nbspLink drive</a>"
                          appendDocPendukung = appendDocPendukung + "</td>"
                          appendDocPendukung = appendDocPendukung + "<td>"
                            appendDocPendukung = appendDocPendukung + '<input style="width:250px;margin-left:20px" class="form-control inputNameDocPendukung_'+value+'" name="inputNameDocPendukung" data-value='+ value +' id="inputNameDocPendukung" placeholder="ex : faktur pajak"><br>'
                          appendDocPendukung = appendDocPendukung + "</td>"
                        appendDocPendukung = appendDocPendukung + "</tr>"
                      }   
                    })
                    $("#tableDocPendukung_ipr").append(appendDocPendukung)                            

                    $.each(result.dokumen,function(value,item){
                      if (value != 0) {
                        const filedocpendukung = document.querySelector('.inputDocPendukung_'+value);

                        const FilePendukung = new File(['{{asset("/")}}"'+ item.dokumen_location +'"'], '/'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1],{
                            type: 'text/plain',
                            lastModified: new Date(),
                        });

                        // Now let's create a DataTransfer to get a FileList
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(FilePendukung);
                        filedocpendukung.files = dataTransfer.files;

                        $('.inputNameDocPendukung_'+value).val(item.dokumen_name)
                      }

                      $(".btnRemoveDocPendukung[data-value='remove_" + value + "']").click(function(){
                        Swal.fire({
                          title: 'Are you sure?',
                          text: "Deleting document",
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
                                url:"{{url('/admin/deleteDokumen/')}}",
                                data:{
                                  _token:"{{ csrf_token() }}",
                                  id:this.value
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
                                success: function(data)
                                {
                                  Swal.showLoading()
                                  Swal.fire(
                                      'Document has been deleted!',
                                      'You can adding another document files',
                                      'success'
                                  ).then((result) => {
                                    if (result.value) {
                                      $(".btnRemoveDocPendukung[data-value='remove_" + value + "']").closest("tr").remove();
                                    }
                                  })
                                }
                              })
                            }
                        })
                        if($('#tableDocPendukung_ipr tr').length == 0){
                          $("#titleDoc").attr('style','display:none!important')
                        }
                      })
                    })
                  }
                })                  
              }   
    
              $("#prevBtnAdd").attr('onclick','nextPrevUnFinished(-1,"saved")')        
              $("#nextBtnAdd").attr('onclick','nextPrevUnFinished(1,"saved")')
              document.getElementById("prevBtnAdd").style.display = "inline";
            } else if (n == 4) {
              // $(".modal-dialog").addClass('modal-lg')
              snowEditor = new Quill('#snow-editor', {
                bounds: '#snow-editor',
                modules: {
                  formula: true,
                  toolbar: '#snow-toolbar'
                },
                theme: 'snow'
              });

              if (result.pr.term_payment != null) {
                snowEditor.clipboard.dangerouslyPasteHTML(result.pr.term_payment)
              }

              if (status == 'reject') {
                $(".divReasonRejectRevision").show()
                $(".reason_reject_revision").val(result.activity.reason.replaceAll("\n","<br>"))
                reasonReject(result.activity.reason,"block","tabGroup")

              }else if (status == 'revision') {
                $(".divReasonRejectRevision").show()
                $(".reason_reject_revision").html(result.activity.reason.replaceAll("\n","<br>"))
                reasonReject(result.activity.reason,"block","tabGroup")
              }
              $(".modal-title").text('Terms & Condition')  
              $(".modal-dialog").addClass('modal-lg')  

              $("#prevBtnAdd").attr('onclick','nextPrevUnFinished(-1,"saved")')        
              $("#nextBtnAdd").attr('onclick','nextPrevUnFinished(1,"saved")')
              document.getElementById("prevBtnAdd").style.display = "inline";
              // if ($('.wysihtml5-toolbar').length == 0) {
              //   $("#textAreaTOP").html(result.pr.term_payment)
              //   $("#textAreaTOP").wysihtml5({
              //     toolbar: {
              //       "font-styles": true, // Font styling, e.g. h1, h2, etc.
              //       "emphasis": true, // Italics, bold, etc.
              //       "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
              //       "html": false, // Button which allows you to edit the generated HTML.
              //       "link": false, // Button to insert a link.
              //       "image": false, // Button to insert an image.
              //       "color": false, // Button to change color of font
              //       "blockquote": false, // Blockquote
              //       "size": true // options are xs, sm, lg
              //     }
              //   })
              // }else{
              //   $("#textAreaTOP").html(result.pr.term_payment)
              // }
            }
            document.getElementById("nextBtnAdd").innerHTML = "Next"
            $("#nextBtnAdd").prop("disabled",false)
            $("#addProduct").attr('onclick','nextPrevUnFinished(-1,"saved")')
          }
        }
      })
      
      $("#ModalDraftPr").modal("show")  
    }

    function btnCancel(id){
      Swal.fire({
        title: 'Are you sure to cancel this pr?',
        icon: 'warning',
        input: 'textarea',
        // inputLabel: 'Cancelation reason',
        inputPlaceholder: 'Type reason here...',
        inputAttributes: {
          'aria-label': 'Type reason here'
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
      }).then((result) => {
        if (result.value == "") {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please fill the reason to cancel this pr!'
          }).then(() => {
            btnCancel(id)
          })
        }else if (result.value != undefined) {
          $.ajax({
            type: "POST",
            url: "{{url('/admin/cancelDraftPr')}}",
            data: {
              _token: "{{ csrf_token() }}",
              no_pr:id,
              notes:result.value
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
              Swal.hideLoading()
              Swal.fire(
                  'Successfully!',
                  'success',
                  'success'
              ).then((result) => {
                if (result.value) {
                  location.reload()
                  Swal.close()
                }
              })
              
            }
          })
        }
      })
    }

    function addDraftPr(n){
      localStorage.setItem('status_tax',false)
      localStorage.setItem('status_pr','')
      let x = document.getElementsByClassName("tab-add");
      x[n].style.display = "inline";
      x[n].classList.remove('d-none');

      if (n == (x.length - 1)) {
        $(".modal-dialog").addClass('modal-lg')
        $("#prevBtnAdd").attr('onclick','nextPrevAdd(-1)')        
        $("#nextBtnAdd").attr('onclick','nextPrevAdd(1)')
        $(".modal-title").text('')
        document.getElementById("prevBtnAdd").classList.remove('d-none');
        document.getElementById("prevBtnAdd").style.display = 'block'

        $("#headerPreviewFinal").empty()
        document.getElementById("nextBtnAdd").innerHTML = "Create";
        $("#nextBtnAdd").attr('onclick','createPR("saved")'); 

        if ($("#selectType").val() == 'IPR') {
          PRType = '<b>Internal Purchase Request</b>'
        }else{
          PRType = '<b>External Purchase Request</b>'
        }

        PRMethode = $("#selectMethode").find(":selected").text()
        leadRegister = $("#selectLeadId").val()
        quoteNumber = $("#selectQuoteNumber").val() 
        $.ajax({
          type: "GET",
          url: "{{url('/admin/getPreviewPr')}}",
          data: {
              no_pr:localStorage.getItem('no_pr'),
          },
          success: function(result) {
            var appendHeader = ""
            appendHeader = appendHeader + '<div class="row mb-4">'
            appendHeader = appendHeader + '    <div class="col-md-6">'
            appendHeader = appendHeader + '        <div class="">To: '+ result.pr.to +'</div>'
            appendHeader = appendHeader + '        <div class="">Email: ' + result.pr.email + '</div>'
            appendHeader = appendHeader + '        <div class="">Phone: ' + result.pr.phone + '</div>'
            appendHeader = appendHeader + '        <div class="">Fax: '+ result.pr.fax +' </div>'
            appendHeader = appendHeader + '        <div class="">Attention: '+ result.pr.attention +'</div>'
            appendHeader = appendHeader + '        <div class="">From: '+ result.pr.name +'</div>'
            appendHeader = appendHeader + '        <div class="">Subject: '+ result.pr.title +'</div>'
            appendHeader = appendHeader + '        <div class="" style="width:fit-content;word-wrap: break-word;">Address: '+ result.pr.address +'</div>'

            appendHeader = appendHeader + '    </div>'
            if (window.matchMedia("(max-width: 768px)").matches)
            {
                appendHeader = appendHeader + '    <div class="col-md-6">'
                // The viewport is less than 768 pixels wide
                
            } else {
                appendHeader = appendHeader + '    <div class="col-md-6" style="text-align:end">'
                // The viewport is at least 768 pixels wide
                
            }
            appendHeader = appendHeader + '        <div>'+ PRType +'</div>'
            appendHeader = appendHeader + '        <div><b>Request Methode</b></div>'
            appendHeader = appendHeader + '        <div>'+ result.pr.request_method +'</div>'
            appendHeader = appendHeader + '        <div>'+ moment(result.pr.created_at).format('DD MMMM') +'</div>'
            if (PRType == 'EPR') {
              appendHeader = appendHeader + '        <div><b>Lead Register</b></div>'
              appendHeader = appendHeader + '        <div>'+ result.pr.lead_id +'</div>'
              appendHeader = appendHeader + '        <div><b>Quote Number</b></div>'
              appendHeader = appendHeader + '        <div>'+ result.pr.quote_number +'</div>'
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
                append = append + "<input data-value='' disabled style='font-size: 12px; important' class='form-control' type='' name='' value='"+ item.name_product + "'>"
                append = append + '</td>'
                append = append + '<td width="35%">'
                  append = append + '<textarea disabled class="form-control" style="height: 250px;resize: none;height: 120px;font-size: 12px;">' + item.description.replaceAll("<br>","\n") + '\n\n' + item.for  +'</textarea>'
                append = append + '</td>'
                append = append + '<td width="10%">'
                  append = append + '<input disabled class="form-control" type="text" name="" value="'+ item.serial_number +'" style="width:100px;font-size: 12px;">'
                append = append + '</td>'
                append = append + '<td width="10%">'
                  append = append + '<input disabled class="form-control" type="text" name="" value="'+ item.part_number +'" style="width:100px;font-size: 12px;">'
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
                  append = append + '<input disabled class="form-control" type="" name="" value="'+ formatter.format(item.nominal_product) +'" style="width:100px;font-size: 12px;">'
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
              appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;text-align:right" class="form-control inputTotalPriceFinal" id="inputTotalPriceFinal" name="inputTotalPriceFinal">'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
              appendBottom = appendBottom + '</div>'

              appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
                appendBottom = appendBottom + '      <span> Discount <span class="title_service"></span></span>'
                appendBottom = appendBottom + '      <input disabled type="text" style="width:250px;display: inline;margin-left:15px;text-align:right" class="form-control inputDiscountFinal" id="inputDiscountFinal" name="inputDiscountFinal">'
                appendBottom = appendBottom + '    </div>'
                appendBottom = appendBottom + '  </div>'
              appendBottom = appendBottom  + '</div>'

              appendBottom = appendBottom + ' <div class="row mb-4" style="margin-top: 10px;">'
                appendBottom = appendBottom + '    <div class="col-md-12 col-xs-12">'
                appendBottom = appendBottom + '      <div class="pull-right">'
                appendBottom = appendBottom + '        <span style="display: inline;margin-right: 15px;">Tax Base Other <span class="title_base_final"></span></span>'
                appendBottom = appendBottom + '        <input disabled type="text" style="width:250px;display: inline;text-align:right" class="form-control inputTextBaseOtherFinal" id="inputTextBaseOtherFinal" name="inputTextBaseOtherFinal>'
                appendBottom = appendBottom + '      </div>'
                appendBottom = appendBottom + '    </div>'
                appendBottom = appendBottom + '  </div>'
              appendBottom = appendBottom + '</div>'

              appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
              appendBottom = appendBottom + ' <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + '   <div class="pull-right">'
                appendBottom = appendBottom + '   <span style="margin-right: -5px;">Vat <span class="title_tax"></span></span>'
                appendBottom = appendBottom + '     <div class="input-group margin" style="display: inline;">'
                appendBottom = appendBottom + '       <input disabled autocomplete="off" type="text" class="form-control vat_tax" id="vat_tax_final" name="vat_tax_final" style="width:150px;text-align:right">'
                appendBottom = appendBottom + '     </div>'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + ' </div>'
              appendBottom = appendBottom + '</div>'

              appendBottom = appendBottom + '<div class="row mb-4">'
                appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
                appendBottom = appendBottom + '      <span>PB1 <span class="title_pb1"></span></span>'
                appendBottom = appendBottom + '      <input disabled type="text" style="width:250px;display: inline;margin-left:15px;text-align:right" class="form-control inputPb1Final" id="inputPb1Final" name="inputPb1Final">'
                appendBottom = appendBottom + '    </div>'
                appendBottom = appendBottom + '  </div>'
              appendBottom = appendBottom  + '</div>'

              appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
                appendBottom = appendBottom + '      <span> Service Charge <span class="title_service"></span></span>'
                appendBottom = appendBottom + '      <input disabled type="text" style="width:250px;display: inline;margin-left:15px;text-align:right" class="form-control inputServiceChargeFinal" id="inputServiceChargeFinal" name="inputServiceChargeFinal">'
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
            appendBottom = appendBottom + '<hr>'
            appendBottom = appendBottom + '<span><b>Attached Files</b><span>'
            var pdf = "bx bx-fw bxs-file-pdf"
            var image = "bx bx-fw bxs-file-image"
            if (result.dokumen[0].dokumen_location.split(".")[1] == 'pdf') {
              var fa_doc = pdf
            }else{
              var fa_doc = image
            }
            if (result.pr.type_of_letter == 'IPR') {
              appendBottom = appendBottom + '<div class="form-group" style="font-size: reguler;">'
                appendBottom = appendBottom + '<div class="row mb-4">'
                  appendBottom = appendBottom + '<div class="col-md-6">'
                    appendBottom = appendBottom + '<div style="border: 1px solid #787bff !important;padding: 5px;"><a href="'+result.dokumen[0].link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ result.dokumen[0].dokumen_location.substring(0,15) + '....'+ result.dokumen[0].dokumen_location.split(".")[0].substring(result.dokumen[0].dokumen_location.length -10) + "." + result.dokumen[0].dokumen_location.split(".")[1] +'</a>'
                    appendBottom = appendBottom + '</div>'
                  appendBottom = appendBottom + '</div>'
                  appendBottom = appendBottom + '<div class="col-md-6">'
                    appendBottom = appendBottom + '<div style="padding: 5px;">Penawaan Harga</div>'
                  appendBottom = appendBottom + '</div>'
                appendBottom = appendBottom + '</div>'
              appendBottom = appendBottom + '</div>'
              
              $.each(result.dokumen,function(value,item){
                if (value != 0) {
                  if (item.dokumen_location.split(".")[1] == 'pdf') {
                    var fa_doc = pdf
                  }else{
                    var fa_doc = image
                  }

                  appendBottom = appendBottom + '<div class="form-group" style="font-size: reguler;">'
                    appendBottom = appendBottom + '<div class="row mb-4">'
                      appendBottom = appendBottom + '<div class="col-md-6">'
                        appendBottom = appendBottom + '<div style="border: 1px solid #787bff !important;padding: 5px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
                        appendBottom = appendBottom + '</div>'
                      appendBottom = appendBottom + '</div>'
                      appendBottom = appendBottom + '<div class="col-md-6">'
                        appendBottom = appendBottom + '<div style="padding: 5px;">Dokumen Pendukung : &nbsp'+ item.dokumen_name +'</div>'
                      appendBottom = appendBottom + '</div>'
                    appendBottom = appendBottom + '</div>'
                  appendBottom = appendBottom + '</div>'
                }        
              })
            }else{        
              $.each(result.dokumen,function(value,item){
                if (item.dokumen_location.split(".")[1] == 'pdf') {
                    var fa_doc = pdf
                  }else{
                    var fa_doc = image
                  }
                  appendBottom = appendBottom + '<div class="form-group" style="font-size: reguler;">'
                    appendBottom = appendBottom + '<div class="row mb-4">'
                      appendBottom = appendBottom + '<div class="col-md-6">'
                        appendBottom = appendBottom + '<div style="border: 1px solid #787bff !important;padding: 5px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
                        appendBottom = appendBottom + '</div>'
                      appendBottom = appendBottom + '</div>'
                      appendBottom = appendBottom + '<div class="col-md-6">'
                        appendBottom = appendBottom + '<div style="padding: 5px;">Dokumen &nbsp'+ item.dokumen_name +'</div>'
                      appendBottom = appendBottom + '</div>'
                    appendBottom = appendBottom + '</div>'
                  appendBottom = appendBottom + '</div>'      
              })
            }       

            $("#bottomPreviewFinal").append(appendBottom)
                            
            if(result.pr.term_payment != null){
              $("#termPreview").html(result.pr.term_payment.replaceAll("&lt;br&gt;","<br>"))
            }

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

            if (result.pr.status_tax == 'True') {
              tempVat = formatter.format((parseFloat(sum) * 11) / 100)
              tempGrand = parseFloat(sum) +  parseFloat((parseFloat(sum) * 11) / 100)
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

      } else {
        if (n == 0) {
          const firstLaunch = localStorage.getItem('firstLaunch')
          document.getElementById("prevBtnAdd").classList.add("d-none");
          $(".modal-title").text('Information Supplier')
          $(".modal-dialog").removeClass('modal-lg')

          if (firstLaunch == 'true') {
            $("#nextBtnAdd").attr('onclick','nextPrevAdd(1,'+ firstLaunch +')')
          }else{
            $("#nextBtnAdd").attr('onclick','nextPrevAdd(2,'+ firstLaunch +')')
          }   

          $.ajax({
            url:"{{url('/admin/getSupplier')}}",
            type:"GET",
            success:function(result){
              $("#selectTo").select2({
                data:result,
                placeholder:"Select Supplier",
                dropdownParent:$("#ModalDraftPr .modal-body")
              }).change(function(){
                $.ajax({
                  url:"{{url('/admin/getSupplierDetail')}}",
                  type:"GET",
                  data:{
                    to:this.value
                  },success:function(result){
                    $.each(result,function(index,value){
                      $("#inputEmail").val(value.email)
                      $("#inputPhone").val(value.phone)
                      $("#inputAddress").val(value.address)
                    })
                  }
                })
              })
            }
          })   

          $("#otherTo").click(function(){
            $("#divInputTo").show("slow")
          })

          $(".close").click(function(){
            $("#divInputTo").hide("slow")
          })   
        }else if (n == 1) {
          select2TypeProduct()

          $(".modal-title").text('Information Product')
          $(".modal-dialog").removeClass('modal-lg')  
          $("#nextBtnAdd").attr('onclick','nextPrevAdd(1)')
          $("#prevBtnAdd").attr('onclick','nextPrevAdd(-1)')        
          document.getElementById("prevBtnAdd").classList.remove('d-none')
          document.getElementById("prevBtnAdd").style.display = 'block'

          //button add initiate product show form-group
          $("#btnInitiateAddProduct").click(function(){
            console.log("bukan sini kan")
            console.log($("#selectCategory").val())

            var append = "", appendFrom = ""

            $("select[name='selectBudgetType']").closest(".form-group").remove() 
            $("select[name='fromBudgetType']").closest(".form-group").remove()
            if ($("#selectCategory").val() == 'Perjalanan Dinas') {
              append = append + '<div class="form-group">'
                append = append + '<label>Budget Type*</label>'
                  append = append + '<select name="selectBudgetType" class="custom-form-control-select w-100" id="selectBudgetType" placeholder="Select Budget Type" onchange="fillInput(' + "'" + 'budget_type' + "'" + ')">'
                    append = append + '<option value="" disabled selected>Select Budget Type</option>'
                    append = append + '<option value="OPERASIONAL">OPERASIONAL</option>'
                    append = append + '<option value="NON-OPERASIONAL">NON-OPERASIONAL</option>'
                  append = append + '</select>'
                append = append + '<span class="invalid-feedback" style="display:none!important;">Please fill Budget Type!</span>'
              append = append + '</div>'

              console.log(!$("#selectBudgetType").is(":visible"))
              if (!$("#selectBudgetType").is(":visible")) {
                $("#inputNameProduct").closest(".form-group").before(append)
              }

              $("#selectBudgetType").change(function(){
                console.log(this.value)
                if (this.value == 'OPERASIONAL') {
                  appendFrom = appendFrom + '<div class="form-group">'
                    appendFrom = appendFrom + '<label>For*</label>'
                      appendFrom = appendFrom + '<select name="fromBudgetType" class="form-control" id="fromBudgetType" placeholder="Select Budget Type" onchange="fillInput(' + "'" + 'fromBudgetType' + "'" + ')">'
                        appendFrom = appendFrom + '<option></option>'
                      appendFrom = appendFrom + '</select>'
                    appendFrom = appendFrom + '<span class="invalid-feedback" style="display:none!important;">Please fill Budget Type!</span>'
                  appendFrom = appendFrom + '</div>'

                  if ($("#selectBudgetType").closest(".form-group").next().find("#fromBudgetType").length == 0) {
                    console.log("sini lagi")
                    $("#selectBudgetType").closest(".form-group").after(appendFrom)

                    $("#fromBudgetType").select2({
                      // data:dataCategory,
                      placeholder:"Select User",
                      ajax: {
                        url: '{{url("admin/getUserOperasional")}}',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                          return {
                            q:params.term
                          };
                        },
                        processResults: function(data, params) {
                          params.page = params.page || 1;
                          return {
                              results: data,
                              pagination: {
                                  more: (params.page * 10) < data.count_filtered
                              }
                          };
                        },
                      },
                      dropdownParent: $('#ModalDraftPr .modal-body'),
                    })
                  }else{
                    console.log("cuman show lagi")

                    $("#fromBudgetType").closest(".form-group").show()
                  }                
                }else{
                  console.log("ini hide")
                  var from = $("#fromBudgetType");
                  var option = new Option('', '', true, true);
                  from.append(option).trigger('change');

                  $("#fromBudgetType").closest(".form-group").attr('style','display:none!important')
                }
              })
            }
            $(".tabGroupInitiateAdd").attr('style','display:none!important')
            x[n].children[1].style.display = "inline"
            x[n].children[1].classList.remove('d-none')

          })
          
        } 
        else if(n == 2){
          $(".modal-title").text('')
          $("#nextBtnAdd").removeAttr('onclick')
          $(".modal-dialog").addClass('modal-lg')

          localStorage.setItem('firstLaunch',false)
          if (localStorage.getItem('firstLaunch') == 'false') {
            $("#prevBtnAdd").attr('onclick','nextPrevAdd(-2)')
            $("#nextBtnAdd").attr('onclick','nextPrevAdd(1)')
          }else{
            $("#prevBtnAdd").attr('onclick','nextPrevAdd(-1)')
          } 
          document.getElementById("prevBtnAdd").classList.remove('d-none')
          document.getElementById("prevBtnAdd").style.display = 'block'

        }else if (n == 3) {
          $(".modal-dialog").removeClass('modal-lg')
          if ($("#selectType").val() == 'EPR') {
            $(".modal-title").text('External Purchase Request')
            $("#formForPrExternal").show()
            $("#formForPrInternal").attr('style','display:none!important')  
            fillInput('spk')
            fillInput('sbe')
            fillInput('quoteSupplier')      
          }else{
            $(".modal-title").text('Internal Purchase Request')
            $("#formForPrInternal").show()
            $("#formForPrExternal").attr('style','display:none!important')      

            fillInput('penawaranHarga')
          }         
          $("#prevBtnAdd").attr('onclick','nextPrevUnFinished(-1,"saved")')       
          $("#nextBtnAdd").attr('onclick','nextPrevUnFinished(1,"saved")')
          document.getElementById("prevBtnAdd").classList.remove('d-none')
          document.getElementById("prevBtnAdd").style.display = 'block'


          $.ajax({
            url: "{{url('/admin/getPidUnion')}}",
            type: "GET",
            success: function(result) {
              $("#selectPid").select2({
                  data: result.data,
                  placeholder: "Select/Input Pid",
                  dropdownParent: $('#ModalDraftPr .modal-body'),
                  tags: true
              }).on('select2:select', function() {
                var data = $("#selectPid option:selected").text();
                var lead_id = $("#selectLeadId option:selected").text();

                $("#selectLeadId").empty()
                $.ajax({
                  url: "{{url('/admin/getLeadByPid')}}",
                  type: "GET",
                  data: {
                    pid:data
                  },
                  success: function(result) {
                    let fileSPK   = document.querySelector('input[type="file"][name="inputSPK"]');

                    let fileSBE   = document.querySelector('input[type="file"][name="inputSBE"]');

                    let fileQuote = document.querySelector('input[type="file"][name="inputQuoteSupplier"]');

                    $("#selectLeadId").select2({
                        data: result.data,
                        placeholder: "Select Lead Register",
                        dropdownParent: $('#ModalDraftPr .modal-body')
                    })

                    if (result.linkSbe.length > 0) {
                      const myFileSbe = new File(['{{asset("/")}}'+result.linkSbe[0].document_location], '/'+result.linkSbe[0].document_location,{
                        type: 'text/plain',
                        lastModified: new Date(),
                      });
                      // Now let's create a DataTransfer to get a FileList
                      const dataTransferSbe = new DataTransfer();
                      dataTransferSbe.items.add(myFileSbe);
                      fileSBE.files = dataTransferSbe.files;

                      $("#inputSBE").attr("disabled",true).css("cursor","not-allowed")
                      $("#inputSBE").closest(".form-group").find("#span_link_drive_sbe").show()
                      $("#link_sbe").attr("href",result.linkSbe[0].link_drive)
                    }else{
                      $("#inputSBE").attr("disabled",false).css("cursor","")
                      $("#inputSBE").val("")
                      $("#inputSBE").closest(".form-group").find("#span_link_drive_sbe").attr('style','display:none!important')
                    }
                  }
                }) 

                $("#selectQuoteNumber").empty()
                $.ajax({
                  url: "{{url('/admin/getQuote')}}",
                  type: "GET",
                  data:{
                    lead_id:lead_id
                  },
                  success: function(result) {
                    $("#selectQuoteNumber").select2({
                        data: result.data,
                        placeholder: "Select Quote Number",
                        dropdownParent: $('#ModalDraftPr .modal-body')
                    })
                  }
                }) 
              })
            }
          })

          $.ajax({
            url: "{{url('/admin/getQuote')}}",
            type: "GET",
            success: function(result) {
              $("#selectQuoteNumber").select2({
                  data: result.data,
                  placeholder: "Select Quote Number",
                  dropdownParent:$("#ModalDraftPr")
              })
            }
          }) 

          $.ajax({
            url: "{{url('/admin/getLead')}}",
            type: "GET",
            success: function(result) {
              // result.data.unshift({"id" : "-","text" : "Select Lead Register"})
              $("#selectLeadId").select2({
                  data: result.data,
                  placeholder: "Select Lead Register",
                  dropdownParent:$("#ModalDraftPr")
              })
            }
          }) 

          // $.ajax({
          //   url: "{{url('/admin/getPid')}}",
          //   type: "GET",
          //   success: function(result) {
          //     $("#selectPid").select2({
          //         data: result.data,
          //         placeholder: "Select PID",
          //         tags: true
          //     })
          //   }
          // }) 

        }else if (n == 4) {
          $(".modal-title").text('Terms & Condition')   
          $(".modal-dialog").removeClass('modal-lg')   
          $("#prevBtnAdd").attr('onclick','nextPrevAdd(-1)')        
          $("#nextBtnAdd").attr('onclick','nextPrevAdd(1)')
          document.getElementById("prevBtnAdd").classList.remove('d-none')
          document.getElementById("prevBtnAdd").style.display = 'block'

        }
        document.getElementById("nextBtnAdd").innerHTML = "Next"
        $("#nextBtnAdd").prop("disabled",false)
        $("#addProduct").attr('onclick','nextPrevAdd(-1)')
      }

      $("#ModalDraftPr").modal("show"); // Show modal first

      $('#ModalDraftPr').on('shown.bs.modal', function () {
        var modalInstance = bootstrap.Modal.getInstance(this);
        modalInstance._config.backdrop = "static";
        modalInstance._config.keyboard = false;
      });
    }

    $('#ModalDraftPr').on('hidden.bs.modal', function () {
      $(".tab-add").css('display','none')
      currentTab = 0
      n = 0
      $(".divReasonRejectRevision").attr('style','display:none!important')
      $(this)
      .find("input,textarea,select")
         .val('')
         .prop("disabled",false)
         .end()
      .find("input[type=checkbox], input[type=radio]")
         .prop("checked", "")
         .end();
      localStorage.setItem('firstLaunch', true);
      localStorage.setItem('isStoreSupplier',false);
      $("#span_link_drive_spk").attr('style','display:none!important')
      $("#span_link_drive_sbe").attr('style','display:none!important')
      $("#span_link_drive_quoteSup").attr('style','display:none!important')
      $("#span_link_drive_penawaranHarga").attr('style','display:none!important')
      // $("#tableDocPendukung").remove()
      localStorage.setItem('isEditProduct',false)
      localStorage.setItem('status_pr','') 
    }) 

    $('#ModalDraftPrAdmin').on('hidden.bs.modal', function () {
      // if (window.location.href.split("/")[4] != undefined) {
      //   location.replace("{{url('/admin/draftPR')}}/")
      // }
      // localStorage.setItem('isEditProduct',false)
      window.history.pushState(null,null,location.protocol + '//' + location.host + location.pathname)
      $(".tab-cek").css('display','none')
      currentTab = 0
      n = 0
    })

    if (window.location.href.split("/")[4].split("?")[1] != undefined) {
      if (window.location.href.split("/")[4].split("?")[1].split("&")[0].split("=")[1]  == 'draft') {
        cekByAdmin(0,window.location.href.split("/")[4].split("?")[1].split("&")[1].split("=")[1])
      }else if (window.location.href.split("/")[4].split("?")[1].split("&")[0].split("=")[1]  == 'reject' || window.location.href.split("/")[4].split("?")[1].split("&")[0].split("=")[1]  == 'revision') {
        unfinishedDraft(0,window.location.href.split("/")[4].split("?")[1].split("&")[1].split("=")[1],window.location.href.split("/")[4].split("?")[1].split("&")[0].split("=")[1])
      }
    }

    function cekByAdmin(n,no_pr){
      $.ajax({
        type: "GET",
        url: "{{url('/admin/getPreviewPr')}}",
        data: {
          no_pr:no_pr,
        },
        success: function(result) {
          var x = document.getElementsByClassName("tab-cek");
          x[n].style.display = "inline"
          x[n].classList.remove('d-none')

          if (n == (x.length - 1)) {
            countCheck = $('input[name="chk[]"]').length
            if ($('input[name="chk[]"]:checked').length < countCheck) {
              $("input[type='radio'][name='radioConfirm']").click(function(){
                if ($("input[type='radio'][name='radioConfirm']:checked").val() == 'reject' ) {
                  $("#divReasonReject").show()
                  $("#nextBtnAddAdmin").attr('onclick','ConfirmDraftPr(' +no_pr+', "reject")')
                }else{
                  $("#divReasonReject").attr('style','display:none!important')
                  $("#nextBtnAddAdmin").attr('onclick','ConfirmDraftPr(' +no_pr+',"approve")')
                }
              })

              $("#notAllChecked").show()
              $("#AllChecked").attr('style','display:none!important')
            }else{
              $("#notAllChecked").attr('style','display:none!important')
              $("#AllChecked").show()

              $("#nextBtnAddAdmin").attr('onclick','ConfirmDraftPr(' +no_pr+',"approve")')
            }
            
            $(".modal-title").text('Confirm Draft PR')
            $(".modal-dialog").removeClass('modal-lg')
            document.getElementById("nextBtnAddAdmin").innerHTML = "Verify"
            $("#nextBtnAddAdmin").attr('onclick','ConfirmDraftPr(' +no_pr+',"approve")')
          } else {
            document.getElementById("nextBtnAddAdmin").innerHTML = "Next"

            if (n == 0) {
              $("#inputToCek").val(result.pr.to)
              $("#selectTypeCek").val(result.pr.type_of_letter)
              $("#inputEmailCek").val(result.pr.email)
              $("#inputPhoneCek").val(result.pr.phone)
              // $("#inputFax").val(result.pr.fax)
              $("#inputAttentionCek").val(result.pr.attention)
              $("#inputSubjectCek").val(result.pr.title)
              $("#inputAddressCek").val(result.pr.address)
              if (result.pr.request_method == 'Reimbursement') {
                $("#selectMethodeCek").val('reimbursement')
              }else if (result.pr.request_method == 'Purchase Order') {
                $("#selectMethodeCek").val('purchase_order')
              }else{
                $("#selectMethodeCek").val('payment')
              }
              $("#selectCategoryCek").val(result.pr.category)

              document.getElementById("prevBtnAddAdmin").classList.add("d-none");
              $(".modal-title").text('Information Supplier')
              $(".modal-dialog").removeClass('modal-lg')
              $("#nextBtnAddAdmin").attr('onclick','nextPrevAddAdmin(1,'+ result.pr.id +')')
              
            }else if(n == 1){
              $(".modal-title").text('')
              $("#nextBtnAddAdmin").removeAttr('onclick')
              $(".modal-dialog").addClass('modal-lg')
              $("#nextBtnAddAdmin").attr('onclick','nextPrevAddAdmin(1,'+ result.pr.id +')')
              $("#prevBtnAddAdmin").attr('onclick','nextPrevAddAdmin(-1,'+ result.pr.id +')')
              document.getElementById("prevBtnAddAdmin").classList.remove('d-none')
              cekTable(no_pr)

              $("#refreshTableCek").click(function(){
                cekTable(no_pr)
              })

              $("#bottomProductsCek").empty()
              var appendBottom = ""
              appendBottom = appendBottom + '<hr>'
                appendBottom = appendBottom + '<div class="row mb-4">'
                appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                appendBottom = appendBottom + '    <div class="pull-right">'
                appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Total</span>'
                appendBottom = appendBottom + '      <input disabled="" type="text" style="width:250px;display: inline;text-align:right" class="form-control inputGrandTotalProductCek" id="inputGrandTotalProductCek" name="inputGrandTotalProductCek">'
                appendBottom = appendBottom + '    </div>'
                appendBottom = appendBottom + '  </div>'
                appendBottom = appendBottom + '</div>'

                appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                appendBottom = appendBottom + ' <div class="col-md-12 col-xs-12">'
                appendBottom = appendBottom + '   <div class="pull-right">'
                  appendBottom = appendBottom + '   <span style="margin-right: 10px;display:inline">Discount <span class="title_discount"></span></span>'

                  appendBottom = appendBottom + '       <input disabled="" type="text" class="form-control discount_cek" id="discount_cek" name="discount_cek" style="width:250px;text-align:right;display:inline">'
                appendBottom = appendBottom + '    </div>'
                appendBottom = appendBottom + ' </div>'
                appendBottom = appendBottom + '</div>'

                appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                appendBottom = appendBottom + ' <div class="col-md-12 col-xs-12">'
                appendBottom = appendBottom + '   <div class="pull-right">'
                  appendBottom = appendBottom + '   <span style="margin-right: 10px;display:inline">Tax Base Other <span class="title_tax_base_other"></span></span>'
                  appendBottom = appendBottom + '       <input disabled="" type="text" class="form-control tax_base_other_cek" id="tax_base_other_cek" name="tax_base_other_cek" style="width:250px;text-align:right;display:inline">'

                appendBottom = appendBottom + '    </div>'
                appendBottom = appendBottom + ' </div>'
                appendBottom = appendBottom + '</div>'

                appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                appendBottom = appendBottom + ' <div class="col-md-12 col-xs-12">'
                appendBottom = appendBottom + '   <div class="pull-right">'
                  appendBottom = appendBottom + '   <span style="margin-right: 10px;display:inline">Vat <span class="title_tax"></span></span>'
                  appendBottom = appendBottom + '       <input disabled="" type="text" class="form-control vat_tax_cek" id="vat_tax_cek" name="vat_tax_cek" style="width:250px;text-align:right;display:inline">'
                appendBottom = appendBottom + '    </div>'
                appendBottom = appendBottom + ' </div>'
                appendBottom = appendBottom + '</div>'


                appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                appendBottom = appendBottom + ' <div class="col-md-12 col-xs-12">'
                appendBottom = appendBottom + '   <div class="pull-right">'
                  appendBottom = appendBottom + '   <span style="margin-right: 10px;display:inline">PB1 <span class="title_pb1"></span></span>'
                  appendBottom = appendBottom + '       <input disabled="" type="text" class="form-control pb1_cek" id="pb1_cek" name="pb1_cek" style="width:250px;text-align:right;display:inline">'
                appendBottom = appendBottom + '    </div>'
                appendBottom = appendBottom + ' </div>'
                appendBottom = appendBottom + '</div>'

                appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                appendBottom = appendBottom + ' <div class="col-md-12 col-xs-12">'
                appendBottom = appendBottom + '   <div class="pull-right">'
                  appendBottom = appendBottom + '   <span style="margin-right: 10px;display:inline">Service Charge <span class="title_service"></span></span>'
                  appendBottom = appendBottom + '       <input disabled="" type="text" class="form-control service_charge_cek" id="service_charge_cek" name="service_charge_cek" style="width:250px;text-align:right;display:inline">'
                appendBottom = appendBottom + '    </div>'
                appendBottom = appendBottom + ' </div>'
                appendBottom = appendBottom + '</div>'

                appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                  appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                  appendBottom = appendBottom + '    <div class="pull-right">'
                  appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Grand Total</span>'
                  appendBottom = appendBottom + '      <input disabled type="text" style="width:250px;display: inline;text-align:right" class="form-control inputGrandTotalProductFinalCek" id="inputGrandTotalProductFinalCek" name="inputGrandTotalProductFinalCek">'
                  appendBottom = appendBottom + '    </div>'
                  appendBottom = appendBottom + '  </div>'
                appendBottom = appendBottom + '</div>'

              $("#bottomProductsCek").append(appendBottom)  

              $(document).on("click", "#btnEditProdukCek", function() {
                $("#ModalDraftPrAdmin").modal('hide')
                currentTab = 1
                unfinishedDraft(currentTab,no_pr,"admin")
                $(".tabGroupInitiateAdd").attr('style','display:none!important')
                $(".tab-add")[1].children[1].style.display = "inline"
                $(".tab-add")[1].children[1].classList.remove('d-none')
                localStorage.setItem('isEditProduct',true)
                localStorage.setItem('id_product',result.product[$(this).data("value")].id_product)
                nominal = result.product[$(this).data("value")].nominal_product
                $("#inputNameProduct").val(result.product[$(this).data("value")].name_product)
                $("#inputDescProduct").val(result.product[$(this).data("value")].description.replaceAll("<br>","\n"))
                $("#inputQtyProduct").val(result.product[$(this).data("value")].qty)
                select2TypeProduct(result.product[$(this).data("value")].unit)
                $("#inputPriceProduct").val(formatter.format(nominal))
                $("#inputSerialNumber").val(result.product[$(this).data("value")].serial_number)
                $("#inputPartNumber").val(result.product[$(this).data("value")].part_number)
                $("#inputTotalPrice").val(formatter.format(result.product[$(this).data("value")].grand_total))
              })

              $(document).on("click", "#btnDeleteProdukCek", function() {
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
                      url: "{{url('/admin/deleteProduct')}}",
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
                          // $("#tbodyProductsCek").empty()
                          cekTable(no_pr)
                        })
                      }
                    })          
                  }
                })
              })
            
            }else if (n == 2) {
              $(".modal-dialog").removeClass('modal-lg')
              if ($("#selectTypeCek").val() == 'EPR') {
                $(".modal-title").text('External Purchase Request')
                $("#formForPrExternalCek").show()
                $("#formForPrInternalCek").attr('style','display:none!important')   

                $("#formForPrExternalCek").find($("input[type=checkbox]")).attr('name','chk[]')
                $("#selectPidCek").val(result.pr.pid)
                $("#selectLeadIdCek").val(result.pr.lead_id)
                $("#selectQuoteNumCek").val(result.pr.quote_number)

                var pdf = "bx bx-fw bxs-file-pdf"
                var image = "bx bx-fw bxs-file-image"
                
                if (result.dokumen[0].link_drive != null) {
                  if (result.dokumen[0].dokumen_location.split(".")[1] == 'pdf') {
                    var fa_doc = pdf
                  }else{
                    var fa_doc = image
                  }
                  $("#span_link_drive_quoteSup_cek").show()
                  $("#link_quoteSupCek").attr("href",result.dokumen[0].link_drive)
                  $("#inputQuoteSupplierCek").val(result.dokumen[0].dokumen_location)
                  $(".icon_quo").addClass(fa_doc)
                }

                if (result.dokumen[2].link_drive != null) {
                  if (result.dokumen[2].dokumen_location.split(".")[1] == 'pdf') {
                    var fa_doc = pdf
                  }else{
                    var fa_doc = image
                  }
                  $("#span_link_drive_sbe_cek").show()
                  $("#link_sbeCek").attr("href",result.dokumen[2].link_drive)
                  $("#inputSBECek").val(result.dokumen[2].dokumen_location)
                  $(".icon_sbe").addClass(fa_doc)
                }

                if (result.dokumen[1].link_drive != null) {
                  if (result.dokumen[1].dokumen_location.split(".")[1] == 'pdf') {
                    var fa_doc = pdf
                  }else{
                    var fa_doc = image
                  }
                  $("#span_link_drive_spk_cek").show()
                  $("#link_spkCek").attr("href",result.dokumen[1].link_drive)
                  $("#inputSPKCek").val(result.dokumen[1].dokumen_location)
                  $(".icon_spk").addClass(fa_doc)
                }

                var appendDokumen = ""
                $("#docPendukungContainerCekEPR").empty()

                $.each(result.dokumen,function(value,item){
                  var pdf = "bx bx-fw bxs-file-pdf"
                  var image = "bx bx-fw bxs-file-image"

                  if (item.dokumen_location.split(".")[1] == 'pdf') {
                    var fa_doc = pdf
                  }else{
                    var fa_doc = image
                  }

                  if (value != 0 && value != 1 && value != 2) {
                    appendDokumen = appendDokumen + '<div class="form-group">'
                    appendDokumen = appendDokumen + '<label>Lampiran Dokumen Pendukung</label>'
                    
                    appendDokumen = appendDokumen + '<div class="form-group" style="font-size: reguler;">'
                      appendDokumen = appendDokumen + '<div class="row mb-4">'
                        appendDokumen = appendDokumen + '<div class="col-md-6">'
                          appendDokumen = appendDokumen + '<div style="border: 1px solid #787bff !important;padding: 5px;background-color: #EEEEEE;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
                          appendDokumen = appendDokumen + '</div>'
                        appendDokumen = appendDokumen + '</div>'
                        appendDokumen = appendDokumen + '<div class="col-md-6">'
                          appendDokumen = appendDokumen + '<div style="padding: 5px;display:inline"> Dokumen Pendukung : ' + item.dokumen_name + '</div><input style="display:inline" id="doc_'+item.id_dokumen+'_pendukung" class="" type="checkbox" name="chk[]" />'
                        appendDokumen = appendDokumen + '</div>'
                      appendDokumen = appendDokumen + '</div>'
                    appendDokumen = appendDokumen + '</div>'
                  }

                })
                $("#docPendukungContainerCekEPR").append(appendDokumen)

              }else{
                $(".modal-title").text('Internal Purchase Request')
                $("#formForPrInternalCek").show()
                $("#formForPrExternalCek").attr('style','display:none!important')       

                $("#formForPrInternalCek").find($("input[type=checkbox]")).attr('name','chk[]')     

                var appendDokumen = ""
                $("#docPendukungContainerCek").empty()
                $.each(result.dokumen,function(value,item){
                  var pdf = "bx bx-fw bxs-file-pdf"
                  var image = "bx bx-fw bxs-file-image"

                  if (item.dokumen_location.split(".")[1] == 'pdf') {
                    var fa_doc = pdf
                  }else{
                    var fa_doc = image
                  }
                  if (item.dokumen_name == 'Penawaran Harga') {                    
                    appendDokumen = appendDokumen + '<div class="form-group">'
                    appendDokumen = appendDokumen + '<label>Lampiran Penawaran Harga*</label>'
                    appendDokumen = appendDokumen + '<div class="form-group" style="font-size: reguler;">'
                      appendDokumen = appendDokumen + '<div class="row mb-4">'
                        appendDokumen = appendDokumen + '<div class="col-md-6">'
                          appendDokumen = appendDokumen + '<div style="border: 1px solid #787bff !important;padding: 5px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'" style="color:#5f61e6"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
                          appendDokumen = appendDokumen + '</div>'
                        appendDokumen = appendDokumen + '</div>'
                        appendDokumen = appendDokumen + '<div class="col-md-6">'
                          appendDokumen = appendDokumen + '<div style="padding: 5px;display:inline">Penawaan Harga</div><input style="display:inline" id="doc_'+item.id_dokumen+'_pendukung" class="" type="checkbox" name="chk[]" />'
                        appendDokumen = appendDokumen + '</div>'
                      appendDokumen = appendDokumen + '</div>'
                    appendDokumen = appendDokumen + '</div>'         
                    appendDokumen = appendDokumen + '</div>'
                  }else{
                    appendDokumen = appendDokumen + '<div class="form-group">'
                    if (value == 1) {
                      appendDokumen = appendDokumen + '<label>Lampiran Dokumen Pendukung</label>'
                    }
                    appendDokumen = appendDokumen + '<div class="form-group" style="font-size: reguler;">'
                      appendDokumen = appendDokumen + '<div class="row mb-4">'
                        appendDokumen = appendDokumen + '<div class="col-md-6">'
                          appendDokumen = appendDokumen + '<div style="border: 1px solid #787bff !important;padding: 5px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
                          appendDokumen = appendDokumen + '</div>'
                        appendDokumen = appendDokumen + '</div>'
                        appendDokumen = appendDokumen + '<div class="col-md-6">'
                          appendDokumen = appendDokumen + '<div style="padding: 5px;display:inline"> Dokumen Pendukung : ' + item.dokumen_name + '</div><input style="display:inline" id="doc_'+item.id_dokumen+'_pendukung" class="" type="checkbox" name="chk[]" />'
                        appendDokumen = appendDokumen + '</div>'
                      appendDokumen = appendDokumen + '</div>'
                    appendDokumen = appendDokumen + '</div>'
                  }  

                })
                $("#docPendukungContainerCek").append(appendDokumen)
              }     

              $("#prevBtnAddAdmin").attr('onclick','nextPrevAddAdmin(-1,'+ result.pr.id +')')       
              $("#nextBtnAddAdmin").attr('onclick','nextPrevAddAdmin(1,'+ result.pr.id +')')
              document.getElementById("prevBtnAddAdmin").style.display = "inline"
              document.getElementById("prevBtnAddAdmin").classList.remove('d-none')

            }else if (n == 3) {
              if(result.pr.term_payment != null){
                $("#textAreaTOPCek").html(result.pr.term_payment.replaceAll("&lt;br&gt;","<br>"))
              }
              $(".modal-title").text('Terms & Condition')
              $(".modal-dialog").removeClass('modal-lg')
              $("#prevBtnAddAdmin").attr('onclick','nextPrevAddAdmin(-1,'+ result.pr.id +')')       
              $("#nextBtnAddAdmin").attr('onclick','nextPrevAddAdmin(1,'+ result.pr.id +')')
              document.getElementById("prevBtnAddAdmin").style.display = "inline"
              document.getElementById("prevBtnAddAdmin").classList.remove('d-none')


            }else if (n == 4) {
              $("#headerPreviewFinalCek").empty()

              $(".modal-dialog").addClass('modal-lg')
              $("#prevBtnAddAdmin").attr('onclick','nextPrevAddAdmin(-1,'+ result.pr.id +')')        
              $("#nextBtnAddAdmin").attr('onclick','nextPrevAddAdmin(1,'+ result.pr.id +')')
              $(".modal-title").text('')
              document.getElementById("prevBtnAddAdmin").style.display = "inline"
              document.getElementById("prevBtnAddAdmin").classList.remove('d-none')

              document.getElementById("nextBtnAddAdmin").innerHTML = "Create";

              if ($("#selectTypeCek").val() == 'IPR') {
                PRType = '<b>Internal Purchase Request</b>'
              }else{
                PRType = '<b>External Purchase Request</b>'
              }

              PRMethode = $("#selectMethode").find(":selected").text()

              var appendHeader = ""
              appendHeader = appendHeader + '<div class="row mb-4">'
              appendHeader = appendHeader + '    <div class="col-md-6">'
              appendHeader = appendHeader + '        <div class="">To: '+ result.pr.to +'</div>'
              appendHeader = appendHeader + '        <div class="">Email: ' + result.pr.email + '</div>'
              appendHeader = appendHeader + '        <div class="">Phone: ' + result.pr.phone + '</div>'
              appendHeader = appendHeader + '        <div class="">Fax: '+ result.pr.fax +' </div>'
              appendHeader = appendHeader + '        <div class="">Attention: '+ result.pr.attention +'</div>'
              appendHeader = appendHeader + '        <div class="">From: '+ result.pr.name +'</div>'
              appendHeader = appendHeader + '        <div class="">Subject: '+ result.pr.title +'</div>'
              appendHeader = appendHeader + '        <div class="" style="width:fit-content;word-wrap: break-word;">Address: '+ result.pr.address +'</div>'

              appendHeader = appendHeader + '    </div>'
              if (window.matchMedia("(max-width: 768px)").matches){
                  appendHeader = appendHeader + '    <div class="col-md-6">'
                  // The viewport is less than 768 pixels wide
                  
              }else {
                  appendHeader = appendHeader + '    <div class="col-md-6" style="text-align:end">'
              }
              appendHeader = appendHeader + '        <div>'+ PRType +'</div>'
              appendHeader = appendHeader + '        <div><b>Request Methode</b></div>'
              appendHeader = appendHeader + '        <div>'+ result.pr.request_method +'</div>'
              appendHeader = appendHeader + '        <div>'+ moment(result.pr.created_at).format('DD MMMM') +'</div>'
              if ($("#selectTypeCek").val() == 'EPR'){
                appendHeader = appendHeader + '        <div><b>Lead Register</b></div>'
                appendHeader = appendHeader + '        <div>'+ result.pr.lead_id +'</div>'
                appendHeader = appendHeader + '        <div><b>Quote Number</b></div>'
                appendHeader = appendHeader + '        <div>'+ result.pr.quote_number +'</div>'
              }
              appendHeader = appendHeader + '    </div>'
              appendHeader = appendHeader + '</div>'

              $("#headerPreviewFinalCek").append(appendHeader)

              $("#tbodyFinalPageProductsCek").empty()
              var append = ""
              var i = 0
              $.each(result.product,function(value,item){
                i++
                append = append + '<tr>'
                  append = append + '<td>'
                    append = append + '<span>'+ i +'</span>'
                  append = append + '</td>'
                  append = append + '<td width="20%">'
                  append = append + "<input data-value='' disabled style='font-size: 12px;width:200px' class='form-control' type='' name='' value='"+ item.name_product + "'>"
                  append = append + '</td>'
                  append = append + '<td width="40%">'
                    append = append + '<textarea style="font-size: 12px;height:150px;resize:none;width:400px" disabled class="form-control">' + item.description.replaceAll("<br>","\n") + '&#10;&#10;SN : ' + item.serial_number + '&#10;PN : ' + item.part_number + '</textarea>'
                  append = append + '</td>'
                  append = append + '<td width="5%">'
                    append = append + '<input disabled class="form-control" type="" name="" value="'+ item.qty +'" style="width:45px;font-size: 12px;">'
                  append = append + '</td>'
                  append = append + '<td width="5%">'
                    append = append + '<select disabled style="width:70px;font-size: 12px;" class="form-control">'
                    append = append + '<option>'+ item.unit.charAt(0).toUpperCase() + item.unit.slice(1) +'</option>'
                    append = append + '</select>'
                  append = append + '</td>'
                  append = append + '<td width="15%">'
                    append = append + '<input style="font-size: 12px;" disabled class="form-control" type="" name="" value="'+ formatter.format(item.nominal_product) +'" style="width:100px">'
                  append = append + '</td>'
                  append = append + '<td width="15%">'
                    append = append + '<input disabled class="form-control grandTotalCek" id="grandTotalCek" type="" name="" value="'+ formatter.format(item.grand_total) +'" style="width:100px;font-size: 12px;">'
                  append = append + '</td>'
                append = append + '</tr>'
              })

              $("#tbodyFinalPageProductsCek").append(append)

              $("#bottomPreviewFinalCek").empty()  
              appendBottom = ""
              appendBottom = appendBottom + '<hr>'
              appendBottom = appendBottom + '<div class="form-group">'
              appendBottom = appendBottom + '<div class="row mb-4">'
              appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + '    <div class="pull-right">'
              appendBottom = appendBottom + '      <span style="display: inline;margin-right: 15px;">Total</span>'
              appendBottom = appendBottom + '      <input disabled="" type="text" style="width:150px;display: inline;text-align:right" class="form-control inputGrandTotalProductPreviewCek" id="inputGrandTotalProductPreviewCek" name="inputGrandTotalProductPreviewCek">'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
              appendBottom = appendBottom + '</div>'

              appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
                appendBottom = appendBottom + '      <span>Discount <span class="title_discount"></span></span>'
                appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;margin-left:15px;text-align:right" class="form-control inputDiscountFinalProductCek" id="inputDiscountFinalProductCek" name="inputDiscountFinalProductCek">'
                appendBottom = appendBottom + '    </div>'
                appendBottom = appendBottom + '  </div>'
              appendBottom = appendBottom  + '</div>'

              appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
              appendBottom = appendBottom + ' <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + '   <div class="pull-right">'
                appendBottom = appendBottom + '   <span style="margin-right: 15px;">Tax Base Other <span class="title_tax_base_other_previewCek"></span></span>'
                appendBottom = appendBottom + '     <div class="input-group margin" style="display: inline;">'
                appendBottom = appendBottom + '       <input disabled type="text" class="form-control pull-right" id="tax_base_other_previewCek" name="tax_base_other_previewCek" style="width:150px;text-align:right">'
                appendBottom = appendBottom + '     </div>'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + ' </div>'
              appendBottom = appendBottom + '</div>'

              appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
              appendBottom = appendBottom + ' <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + '   <div class="pull-right">'
                appendBottom = appendBottom + '   <span style="margin-right: 15px;">Vat <span class="title_tax"></span></span>'
                appendBottom = appendBottom + '     <div class="input-group margin" style="display: inline;">'
                appendBottom = appendBottom + '       <input disabled type="text" class="form-control vat_tax pull-right" id="vat_tax_PreviewCek" name="vat_tax_PreviewCek" style="width:150px;text-align:right">'
                appendBottom = appendBottom + '     </div>'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + ' </div>'
              appendBottom = appendBottom + '</div>'

              appendBottom = appendBottom + '<div class="row mb-4">'
                appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
                appendBottom = appendBottom + '      <span>PB1 <span class="title_pb1"></span></span>'
                appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;margin-left:15px;text-align:right" class="form-control inputPb1ProductFinalCek" id="inputPb1ProductFinalCek" name="inputPb1ProductFinalCek">'
                appendBottom = appendBottom + '    </div>'
                appendBottom = appendBottom + '  </div>'
              appendBottom = appendBottom  + '</div>'

              appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
                appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
                appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
                appendBottom = appendBottom + '      <span>Service Charge <span class="title_service"></span></span>'
                appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;margin-left:15px;text-align:right" class="form-control inputServiceChargeFinalProductCek" id="inputServiceChargeFinalProductCek" name="inputServiceChargeFinalProductCek">'
                appendBottom = appendBottom + '    </div>'
                appendBottom = appendBottom + '  </div>'
              appendBottom = appendBottom  + '</div>'

              appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
              appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + '    <div class="pull-right">'
              appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Grand Total</span>'
              appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;text-align:right" class="form-control inputFinalPageGrandPricePreviewCek" id="inputFinalPageGrandPricePreviewCek" name="inputFinalPageGrandPricePreviewCek" style="text-align:right">'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
              appendBottom = appendBottom + '</div>'
              appendBottom = appendBottom + '</div>'
              appendBottom = appendBottom + '<hr>'
              appendBottom = appendBottom + '<span style="display:block;text-align:center"><b>Terms & Condition</b></span>'
              appendBottom = appendBottom + '<div disabled id="termPreviewCek" class="form-control" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221);overflow:auto"></div>'
              appendBottom = appendBottom + '<hr>'
              appendBottom = appendBottom + '<span><b>Attached Files</b><span>'
              var pdf = "bx bx-fw bxs-file-pdf"
              var image = "bx bx-fw bxs-file-image"
              if (result.dokumen[0].dokumen_location.split(".")[1] == 'pdf') {
                var fa_doc = pdf
              }else{
                var fa_doc = image
              }
              if (result.pr.type_of_letter == 'IPR') {
                appendBottom = appendBottom + '<div class="form-group" style="font-size: reguler;">'
                  appendBottom = appendBottom + '<div class="row mb-4">'
                    appendBottom = appendBottom + '<div class="col-md-6">'
                      appendBottom = appendBottom + '<div style="border: 1px solid #787bff !important;padding: 5px;"><a href="'+result.dokumen[0].link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ result.dokumen[0].dokumen_location.substring(0,15) + '....'+ result.dokumen[0].dokumen_location.split(".")[0].substring(result.dokumen[0].dokumen_location.length -10) + "." + result.dokumen[0].dokumen_location.split(".")[1] +'</a>'
                      appendBottom = appendBottom + '</div>'
                    appendBottom = appendBottom + '</div>'
                    appendBottom = appendBottom + '<div class="col-md-6">'
                      appendBottom = appendBottom + '<div style="padding: 5px;">Penawaan Harga</div>'
                    appendBottom = appendBottom + '</div>'
                  appendBottom = appendBottom + '</div>'
                appendBottom = appendBottom + '</div>'
                
                $.each(result.dokumen,function(value,item){
                  if (item.dokumen_location.split(".")[1] == 'pdf') {
                    var fa_doc = pdf
                  }else{
                    var fa_doc = image
                  }
                  if (value != 0) {
                    appendBottom = appendBottom + '<div class="form-group" style="font-size: reguler;">'
                      appendBottom = appendBottom + '<div class="row mb-4">'
                        appendBottom = appendBottom + '<div class="col-md-6">'
                          appendBottom = appendBottom + '<div style="border: 1px solid #787bff !important;padding: 5px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
                          appendBottom = appendBottom + '</div>'
                        appendBottom = appendBottom + '</div>'
                        appendBottom = appendBottom + '<div class="col-md-6">'
                          appendBottom = appendBottom + '<div style="padding: 5px;">Dokumen Pendukung : &nbsp'+ item.dokumen_name +'</div>'
                        appendBottom = appendBottom + '</div>'
                      appendBottom = appendBottom + '</div>'
                    appendBottom = appendBottom + '</div>'
                  }        
                })
              }else{        
                $.each(result.dokumen,function(value,item){
                  if (item.dokumen_location.split(".")[1] == 'pdf') {
                      var fa_doc = pdf
                    }else{
                      var fa_doc = image
                    }
                    appendBottom = appendBottom + '<div class="form-group" style="font-size: reguler;">'
                      appendBottom = appendBottom + '<div class="row mb-4">'
                        appendBottom = appendBottom + '<div class="col-md-6">'
                          appendBottom = appendBottom + '<div style="border: 1px solid #787bff !important;padding: 5px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
                          appendBottom = appendBottom + '</div>'
                        appendBottom = appendBottom + '</div>'
                        appendBottom = appendBottom + '<div class="col-md-6">'
                          appendBottom = appendBottom + '<div style="padding: 5px;">Dokumen &nbsp'+ item.dokumen_name +'</div>'
                        appendBottom = appendBottom + '</div>'
                      appendBottom = appendBottom + '</div>'
                    appendBottom = appendBottom + '</div>'      
                })
              } 

              $("#bottomPreviewFinalCek").append(appendBottom)

              if (result.pr.term_payment) {
                $("#termPreviewCek").html(result.pr.term_payment.replaceAll("&lt;br&gt;","<br>"))
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
              var valueVat = ""
              // if (result.pr.status_tax == 'True') {
              //   tempVat = formatter.format((parseFloat(sum) * 11) / 100)
              //   tempGrand = parseFloat(sum) +  parseFloat((parseFloat(sum) * 11) / 100)
              // }else{
              //   tempVat = tempVat
              //   tempGrand = parseFloat(sum)
              // }

              $('.grandTotalCek').each(function() {
                var temp = parseFloat($(this).val() == "" ? "0" : parseFloat($(this).val().replace(/\./g,'').replace(',','.').replace(' ','')))
                sum += temp;
              });

              if (result.pr.status_tax == false) {
                valueVat = 'false'
              }else{
                valueVat = result.pr.status_tax
              }

              tempDiscount = Math.round(parseFloat(sum) * (result.pr.discount == null || result.pr.discount == 'false'?0:parseFloat(result.pr.discount) / 100))

              if (!isNaN(valueVat)) {

                tempVat = Math.round((parseFloat(sum) - tempDiscount) * (valueVat == false?0:parseFloat(valueVat) / 100))
                // Math.round((parseFloat(sum) * parseFloat(valueVat)) / 100)

                finalVat = tempVat

                tempGrand = Math.round(parseFloat(sum) +  parseFloat((parseFloat(sum) * parseFloat(valueVat)) / 100))

                finalGrand = tempGrand

                tempTotal = sum

                if (valueVat == 11) {
                  valueVat = 12
                }else if (value == 1.1) {
                  valueVat = 1.2
                }else{
                  valueVat
                }

                $('.title_tax').text(valueVat + '%')
              }else{
                tempVat = 0

                tempGrand = sum

                $('.title_tax').text("")
              }

              $('.title_pb1').text(result.pr.tax_pb == 'false'|| result.pr.tax_pb == 0?"":result.pr.tax_pb+"%")
              $('.title_service').text(result.pr.service_charge == 'false' || result.pr.service_charge == 0?"":result.pr.service_charge+"%")
              $('.title_discount').text(result.pr.discount == 'false' || result.pr.discount == 0?"":parseFloat(result.pr.discount).toFixed(2)+"%")

              tempPb1 = Math.round((parseFloat(sum) - tempDiscount) * (result.pr.tax_pb == null || result.pr.tax_pb == 'false'?0:parseFloat(result.pr.tax_pb)) / 100)
              tempService = Math.round((parseFloat(sum) - tempDiscount) * (result.pr.service_charge == "false"?0:parseFloat(result.pr.service_charge)) / 100)

              tempDiscount = Math.round(parseFloat(sum) * (result.pr.discount == null || result.pr.discount == 'false'?0:parseFloat(result.pr.discount) / 100))

              $("#vat_tax_PreviewCek").val(formatter.format(tempVat))
              $("#inputGrandTotalProductPreviewCek").val(formatter.format(sum))
              $("#tax_base_other_previewCek").val(customRound(formatter.format((tempTotal - tempDiscount)*11/12)))
              $("#inputPb1ProductFinalCek").val(formatter.format(tempPb1))
              $("#inputServiceChargeFinalProductCek").val(formatter.format(tempService))
              $("#inputDiscountFinalProductCek").val(formatter.format(tempDiscount))
              $("#inputFinalPageGrandPricePreviewCek").val(formatter.format(result.grand_total))
            }
          }    
        }    
      }) 
      // $("#ModalDraftPrAdmin").modal({backdrop: 'static', keyboard: false}) 
      $("#ModalDraftPrAdmin").modal("show")  

    }

    function cekTable(no_pr){
      $.ajax({
        type: "GET",
        url: "{{url('/admin/getPreviewPr')}}",
        data: {
          no_pr:no_pr,
        },
        success: function(result) {
          var append = ""
          var i = 0
          var value = 0
          $("#tbodyProductsCek").empty()

          $.each(result.product,function(item,value){
            i++
            append = append + '<tr>'
              append = append + '<td>'
                append = append + '<span style="font-size: 12px;">'+ i +'</span>'
              append = append + '</td>'
              append = append + '<td width="20%">'
              append = append + "<input id='inputNameProductEdit' data-value='' disabled style='font-size: 12px;min-width:200px' class='form-control' type='' name='' value='"+ value.name_product + "'>"
              append = append + '</td>'
              append = append + '<td width="30%">'
                append = append + '<textarea id="textAreaDescProductEdit" disabled data-value="" style="font-size: 12px;resize: none;min-height: 110px;min-width:400px" class="form-control">'+ value.description.replaceAll("<br>","\n") + '&#10;&#10;' + 'SN : ' + value.serial_number + '&#10;PN : ' + value.part_number
                append = append + '</textarea>'
              append = append + '</td>'
              append = append + '<td width="7%">'
                append = append + '<input id="inputQtyEdit" data-value="" disabled style="font-size: 12px;width:100px" class="form-control" type="" name="" value="'+ value.qty +'">'
              append = append + '</td>'
              append = append + '<td width="15%">'
              append = append + '<select id="inputTypeProductEdit" disabled data-value="" style="font-size: 12px;width:100px" class="form-control">'
              append = append + '<option>'+ value.unit.charAt(0).toUpperCase() + value.unit.slice(1) +'</option>'
              append = append + '</select>' 
              append = append + '</td>'
              append = append + '<td width="15%">'

                append = append + '<input id="inputPriceEdit" disabled data-value="" style="font-size: 12px;width:150px" class="form-control money" type="" name="" value="'+ formatter.format(value.nominal_product) +'">'
              append = append + '</td>'
              append = append + '<td width="15%">'
                append = append + '<input id="inputTotalPriceEditCek" disabled data-value="" style="font-size: 12px;width:150px" class="form-control inputTotalPriceEditCek" type="" name="" value="'+ formatter.format(value.grand_total) +'">'
              append = append + '</td>'
              append = append + '<td width="8%">'
                append = append + '<button type="button" id="btnEditProdukCek" data-value="'+ item +'" class="btn btn-sm text-bg-warning bx bx-edit bx-2xs" style="width:25px;height:25px;margin-bottom:5px"></button>'
                append = append + '<button type="button" id="btnDeleteProdukCek" data-id="'+ value.id_product +'" data-value="'+ item +'" class="btn btn-sm btn-danger bx bx-trash bx-2xs" style="width:25px;height:25px;"></button>'
              append = append + '</td>'
              append = append + '<td width="5%">'
                append = append + '<input type="checkbox" id="product_'+i+'_cek" name="chk[]" class="">'
              append = append + '</td>'
            append = append + '</tr>' 

          })

          $("#tbodyProductsCek").append(append)

          var tempVat = 0
          var finalVat = 0
          var tempGrand = 0
          var tempPb1 = 0
          var tempService = 0
          var finalGrand = 0
          var tempTotal = 0
          var btnVatStatus = true
          var valueVat = ''
          var sum = 0

          finalVat = tempVat

          finalGrand = tempGrand

          tempTotal = sum

          // if (result.pr.status_tax == 'True') {
          //   tempVat = formatter.format((parseFloat(sum) * 11) / 100)
          //   tempGrand = parseFloat(sum) +  parseFloat((parseFloat(sum) * 11) / 100)
          // }else{
          //   tempVat = tempVat
          //   tempGrand = parseFloat(sum)
          // }

          if (result.pr.status_tax == false) {
            valueVat = 'false'
          }else{
            valueVat = result.pr.status_tax
          }

          $('.inputTotalPriceEditCek').each(function() {
            var temp = parseFloat($(this).val() == "" ? "0" : parseFloat($(this).val().replace(/\./g,'').replace(',','.').replace(' ','')))
            sum += temp;
          });

          tempDiscount = Math.round(parseFloat(sum) * (result.pr.discount == null || result.pr.discount == 'false'?0:parseFloat(result.pr.discount) / 100))

          if (!isNaN(valueVat)) {
            setTimeout(function() {
              tempVat = Math.round((parseFloat(sum) - tempDiscount)) * (valueVat == false?0:parseFloat(valueVat) / 100)
              // tempVat = Math.round((parseFloat(sum) * parseFloat(valueVat)) / 100)

              finalVat = tempVat

              tempGrand = sum + finalVat

              tempTotal = sum

              if (valueVat == 11) {
                valueVat = 12
              }else if (value == 1.1) {
                valueVat = 1.2
              }else{
                valueVat
              }

              $('.title_tax').text(valueVat + '%')
            },500)
          }else{
            tempVat = 0

            tempGrand = sum

            $('.title_tax').text("")
          }

          setTimeout(function() {
            $('.title_pb1').text(result.pr.tax_pb == 'false' || result.pr.tax_pb == 0?"":result.pr.tax_pb+"%")
            $('.title_service').text(result.pr.service_charge == 'false' || result.pr.service_charge == 0?"":result.pr.service_charge+"%")
            $('.title_discount').text(result.pr.discount == 'false' || result.pr.discount == 0?"":parseFloat(result.pr.discount).toFixed(2)+"%")

            tempPb1 = Math.round((parseFloat(sum) - tempDiscount) * (result.pr.tax_pb == null || result.pr.tax_pb == 'false'?0:parseFloat(result.pr.tax_pb)) / 100)

            tempService = Math.round((parseFloat(sum) - tempDiscount) * (result.pr.service_charge == null || result.pr.service_charge == "false"?0:parseFloat(result.pr.service_charge)) / 100)

            tempDiscount = Math.round(parseFloat(sum) * (result.pr.discount == null || result.pr.discount == 'false'?0:parseFloat(result.pr.discount) / 100))
            

            $("#vat_tax_cek").val(formatter.format(tempVat))
            $("#inputGrandTotalProductCek").val(formatter.format(sum))
            $("#tax_base_other_cek").val(customRound(formatter.format((tempTotal - tempDiscount)*11/12)))
            $("#pb1_cek").val(formatter.format(tempPb1))
            $("#service_charge_cek").val(formatter.format(tempService))
            $("#discount_cek").val(formatter.format(tempDiscount))
            $("#inputGrandTotalProductFinalCek").val(formatter.format(result.grand_total))
          },500)
        }
      })
      
    }

    //button confirm draft
    function ConfirmDraftPr(no_pr,status){
      var arrCheck = [];
      $('input[name="chk[]"]:checked').each(function () {
        // valuesChecked[valuesChecked.length] = (this.checked ? $(this).attr('id') : "");
        arrCheck.push($(this).attr('id'))
      });

      if (status == "reject") {
        if ($("#textAreaReasonReject").val() == "") {
          $("#textAreaReasonReject").closest('.form-group').addClass('needs-validation ')
          $("#textAreaReasonReject").closest('textarea').next('span').show();
          $("#textAreaReasonReject").prev('.input-group-text').css("background-color","red");
        } else {
          var data = {
            _token:'{{ csrf_token() }}',
            no_pr:no_pr,
            valuesChecked:arrCheck,
            rejectReason:$("#textAreaReasonReject").val(),
            radioConfirm:$("input[type='radio'][name='radioConfirm']:checked").val(),
          }

          verifyDraft(data)

        }           
      }else{
        var data = {
          _token:'{{ csrf_token() }}',
          no_pr:no_pr,
          valuesChecked:arrCheck,
          radioConfirm:$("input[type='radio'][name='radioConfirm']:checked").val(),
        }

        verifyDraft(data)
      }
    }

    //ajax post verify draft
    function verifyDraft(data){
      Swal.fire({
        title: 'Are you sure?',  
        text: "Admin verify PR",
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
            url: "{{url('/admin/verifyDraft')}}",
            data:data,
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
                    'Verify PR Successfully.',
                    'success'
                ).then((result) => {
                    if (result.value) {
                      location.replace("{{url('admin/draftPR')}}")
                    }
                })
            },
            error: function(resultAjax,errorStatus,errorMessage){
              console.log(resultAjax)
              if (resultAjax.responseText) {
                var error = JSON.parse(resultAjax.responseText).message
              }else{
                var error = 'Something Went Wrong, Please Try Again!'
              }
              Swal.hideLoading()
              Swal.fire({
                title: 'Error!',
                text: error,
                icon: 'error',
                confirmButtonText: 'OK',
              }).then((result) => {
                swal.close()
              })
            }
          })          
        }
      })
    }

    function fillInput(val){
      if (val == "selectTo") {
        $("#selectTo").closest('.form-group').removeClass('needs-validation ')
        $("#selectTo").closest('.form-group').find('.invalid-feedback').attr('style','display:none!important');
        $("#selectTo").prev('.input-group-text').css("background-color","red");
      }else if (val == "to") {
        $("#inputTo").closest('.divInputTo').closest('.form-group').removeClass('needs-validation ')
        $("#inputTo").closest('.divInputTo').find('.invalid-feedback').attr('style','display:none!important');
        $("#inputTo").prev('.input-group-text').css("background-color","red");
      }else if (val == "email") {
        const validateEmail = (email) => {
          return email.match(
            /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          )
        }

        emails = validateEmail($("#inputEmail").val())

        if ($("#inputEmail").val() == '-') {
          $("#inputEmail").closest('.form-group').removeClass('needs-validation ')
          $("#inputEmail").closest('input').next('span').attr('style','display:none!important')
          $("#inputEmail").prev('.input-group-text').css("background-color","red")
        }else{
          switch(emails){
            case null:
              $("#inputEmail").closest('.form-group').addClass('needs-validation ')
              $("#inputEmail").closest('input').next('span').show();
              $("#inputEmail").prev('.input-group-text').css("background-color","red");
              $("#inputEmail").closest('input').next('span').text("Enter a Valid Email Address!")
            break;
            default:
              $("#inputEmail").closest('.form-group').removeClass('needs-validation ')
              $("#inputEmail").closest('input').next('span').attr('style','display:none!important')
              $("#inputEmail").prev('.input-group-text').css("background-color","red")
          }
        }
      }else if (val == "phone") {
        $("#inputPhone").inputmask({"mask": "999-999-999-999"})
        $("#inputPhone").closest('.form-group').removeClass('needs-validation ')
        $("#inputPhone").closest('input').next('span').attr('style','display:none!important');
        $("#inputPhone").prev('.input-group-text').css("background-color","red");
      }else if(val == "subject") {
        $("#inputSubject").closest('.form-group').removeClass('needs-validation ')
        $("#inputSubject").closest('input').next('span').attr('style','display:none!important');
        $("#inputSubject").prev('.input-group-text').css("background-color","red");
      }else if(val == "attention") {
        $("#inputAttention").closest('.form-group').removeClass('needs-validation ')
        $("#inputAttention").closest('input').next('span').attr('style','display:none!important');
        $("#inputAttention").prev('.input-group-text').css("background-color","red");
      }else if(val == "from") {
        $("#inputFrom").closest('.form-group').removeClass('needs-validation ')
        $("#inputFrom").closest('input').next('span').attr('style','display:none!important');
        $("#inputFrom").prev('.input-group-text').css("background-color","red");
      }else if(val == "address") {
        $("#inputAddress").closest('.form-group').removeClass('needs-validation ')
        $("#inputAddress").closest('input').next('span').attr('style','display:none!important');
        $("#inputAddress").prev('.input-group-text').css("background-color","red");  
      }

      if (val == "selectLeadId") {
        $("#selectLeadId").closest('.form-group').removeClass('needs-validation ')
        $("#selectLeadId").closest('select').next('span').next("span").attr('style','display:none!important'); 
        $("#selectLeadId").prev('.col-md-6').css("background-color","red");
      }

      if (val == "selectPID") {
        $("#selectPid").closest('.form-group').removeClass('needs-validation ')
        $("#selectPid").closest('select').next('span').next("span").attr('style','display:none!important'); 
        $("#selectPid").prev('.col-md-6').css("background-color","red");
      }

      if (val == "selectType") {
        $("#selectType").closest('.form-group').removeClass('needs-validation ')
        $("#selectType").closest('select').next('span').attr('style','display:none!important');
        $("#selectType").prev('.input-group-text').css("background-color","red");
      }

      if (val == "selectCategory") {
        $("#selectCategory").closest('.form-group').removeClass('needs-validation ')
        $("#selectCategory").closest('select').next('span').attr('style','display:none!important');
        $("#selectCategory").prev('.input-group-text').css("background-color","red");
      }

      if (val == "name_product") {
        $("#inputNameProduct").closest('.form-group').removeClass('needs-validation ')
        $("#inputNameProduct").closest('input').next('span').attr('style','display:none!important');
        $("#inputNameProduct").prev('.input-group-text').css("background-color","red");
      }
      if (val == "desc_product") {
        $("#inputDescProduct").closest('.form-group').removeClass('needs-validation ')
        $("#inputDescProduct").closest('textarea').next('span').attr('style','display:none!important');
        $("#inputDescProduct").prev('.input-group-text').css("background-color","red");
      }
      if (val == "qty_product") {
        if (localStorage.getItem('isRupiah') == 'true') {
          $("#inputTotalPrice").val(formatter.format(Math.round(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ','')))))
        }else{
          $("#inputTotalPrice").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
        }
        $("#inputQtyProduct").closest('.col-md-4').removeClass('needs-validation ')
        $("#inputQtyProduct").closest('input').next('span').attr('style','display:none!important');
        $("#inputQtyProduct").prev('.input-group-text').css("background-color","red");
      }

      if (val == "type_product") {
        $("#selectTypeProduct").closest('.col-md-4').removeClass('needs-validation ')
        $("#selectTypeProduct").closest('select').next('span').next('span').attr('style','display:none!important');
        $("#selectTypeProduct").prev('.input-group-text').css("background-color","red");
      }

      if (val == "price_product") {
        // formatter.format($("#inputPriceProduct").val())
        if (localStorage.getItem('isRupiah') == 'true') {
          $("#inputTotalPrice").val(formatter.format(Math.round(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ','')))))
        }else{
          $("#inputTotalPrice").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
        }
        $("#inputPriceProduct").closest('.col-md-4').removeClass('needs-validation ')
        $("#inputPriceProduct").closest('input').closest('.input-group').next('span').attr('style','display:none!important');
        $("#inputPriceProduct").prev('.col-md-4').css("background-color","red");
      }
      if (val == "spk") {
        $("#inputSPK").closest('.form-group').removeClass('needs-validation ')
        $("#inputSPK").closest('div').next('span').attr('style','display:none!important');
        $("#inputSPK").prev('.input-group-text').css("background-color","red");
      }

      if (val == "sbe") {
        $("#inputSBE").closest('.form-group').removeClass('needs-validation ')
        $("#inputSBE").closest('div').next('span').attr('style','display:none!important');
        $("#inputSBE").prev('.input-group-text').css("background-color","red");
      }

      if (val == "quoteSupplier") {
        $("#inputQuoteSupplier").closest('.form-group').removeClass('needs-validation ')
        $("#inputQuoteSupplier").closest('div').next('span').attr('style','display:none!important');
        $("#inputQuoteSupplier").prev('.input-group-text').css("background-color","red");  
      }

      if (val == "quoteNumber") {
        $("#inputQuoteNumber").closest('.form-group').removeClass('needs-validation ')
        $("#inputQuoteNumber").closest('select').next('span').next("span").attr('style','display:none!important'); 
        $("#inputQuoteNumber").prev('.input-group-text').css("background-color","red");  
      }

      if (val == "penawaranHarga") {
        $("#inputPenawaranHarga").closest('.form-group').removeClass('needs-validation ')
        $("#inputPenawaranHarga").closest('div').next('span').attr('style','display:none!important');
        $("#inputPenawaranHarga").prev('.input-group-text').css("background-color","red");  
      }

      if (val == "textArea_TOP") {
        $("#snow-editor").next('span').attr('style','display:none!important')  
      }

      if (val == "reason_reject") {
        $("#textAreaReasonReject").closest('.form-group').removeClass('needs-validation ')
        $("#textAreaReasonReject").closest('textarea').next('span').attr('style','display:none!important');
        $("#textAreaReasonReject").prev('.input-group-text').css("background-color","red"); 
      }
    }

    // localStorage.setItem('status_tax',false)
    // localStorage.setItem('tax_pb',0)
    // localStorage.setItem('service_charge',0)
    function customRound(num) {
      var parseNum = parseFloat(num.replace(/\./g, "").replace(",", "."));
      return Math.round(parseNum);
    } 

    function changeVatValue(value=false){
      var tempVat = 0
      var finalVat = 0
      var tempGrand = 0
      var tempPb1 = 0
      var tempService = 0
      var tempDiscount = 0
      var finalGrand = 0
      var tempTotal = 0
      var sum = 0

      $('.inputTotalPriceEdit').each(function() {
        var temp = parseFloat($(this).val() == "" ? "0" : parseFloat($(this).val().replace(/\./g,'').replace(',','.').replace(' ','')))
        sum += temp;
      });

      $("#inputGrandTotalProduct").val(formatter.format(sum))

      if (value == false) {
        valueVat = ''
        if ($("#inputDiscountNominal").val() != "") {
          tempDiscount = $("#inputDiscountNominal").val() == 0?false:parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ','') / parseFloat(sum) * 100)
        }
      }else{
        if (value == 'service' || value == 'pb1') {
          valueVat = $("#vat_tax").val() == 0?false:parseFloat($('.title_tax').text().replace("%",""))
          if ($("#inputDiscountNominal").val() != "") {
            tempDiscount = $("#inputDiscountNominal").val() == 0?false:parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ','') / parseFloat(sum) * 100)
          }
        }else if (value == 'discount') {
          if ($("#inputDiscountNominal").val() == "") {
            tempDiscount = tempDiscount
          } else {
            tempDiscount = $("#inputDiscountNominal").val() == 0?false:parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ','') / parseFloat(sum) * 100)
          }
        }else{
          valueVat = value
          if ($("#inputDiscountNominal").val() != "") {
            tempDiscount = $("#inputDiscountNominal").val() == 0?false:parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ','') / parseFloat(sum) * 100)
          }
        }
      }

      $('.money').mask('#.##0,00', {reverse: true})

      if (!isNaN(valueVat)) {   
        setTimeout(function(){
          tempVat = $("#inputDiscountNominal").val() == '' ? Math.round((parseFloat(sum)) * (valueVat == false?0:parseFloat(valueVat) / 100)) : Math.round((parseFloat(sum) - parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ',''))) * (valueVat == false?0:parseFloat(valueVat) / 100))

          finalVat = tempVat

          finalGrand = tempGrand

          tempTotal = parseFloat(sum)

          if (valueVat == 11) {
            valueVat = 12
          }else if (valueVat == 1.1) {
            valueVat = 1.2
          }else{
            valueVat
          }

          console.log(valueVat)
          $('.title_tax').text(valueVat == '' || valueVat == null ?"":valueVat + '%')

          $("#vat_tax").val(formatter.format(isNaN(tempVat)?0:tempVat))
        },500)
      }else{
        if (value == 'pb1' || value == 'service') {
          tempVat = Math.round((parseFloat(sum) * ($("#vat_tax").val() == ""?0:parseFloat($("#vat_tax").val())) / 100))
        }else{
          tempVat = 0
          $("#vat_tax").val(formatter.format(tempVat))
        } 

        finalVat = tempVat

        finalGrand = tempGrand

        tempTotal = parseFloat(sum)
        $('.title_tax').text($("#vat_tax").val() == "" ||$("#vat_tax").val() == 0?"":$('.title_tax').text().replace("%","") + '%')
      }

      setTimeout(function(){
        tempDiscNominal = isNaN(parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ','')))?0:parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ',''))

        tempPb1 = Math.round((parseFloat(sum) - tempDiscNominal) * ($("#inputPb1Product").val() == ""?0:parseFloat($("#inputPb1Product").val())) / 100)

        tempService = Math.round((parseFloat(sum) - tempDiscNominal) * ($("#inputServiceChargeProduct").val() == ""?0:parseFloat($("#inputServiceChargeProduct").val())) / 100)
        
        $("#inputServiceChargeNominal").val(formatter.format(tempService))

        console.log(formatter.format((tempTotal - tempDiscNominal)*11/12))
        $("#inputTaxBaseOtherFinal").val(formatter.format(customRound(formatter.format((tempTotal - tempDiscNominal)*11/12))))

        $("#inputPb1Nominal").val(formatter.format(tempPb1))
        $("#inputDiscountProduct").val(tempDiscount)

        tempGrand = tempTotal + tempPb1 + tempService + tempVat - tempDiscNominal

        changeValueGrandTotal(isNaN(tempGrand)?0:tempGrand)
      },500)

      localStorage.setItem('status_tax',valueVat)
      localStorage.setItem('tax_pb',$("#inputPb1Product").val() == ''?0:$("#inputPb1Product").val().split(".")[0])
      localStorage.setItem('service_charge',$("#inputServiceChargeProduct").val() == ''?0:$("#inputServiceChargeProduct").val().split(".")[0])
      localStorage.setItem('discount',tempDiscount == ''?0:tempDiscount)
    }

    function changeValueGrandTotal(grandTotal){
      $("#inputGrandTotalProductFinal").val(formatter.format(grandTotal))
    }

    localStorage.setItem("isRupiah",true)
    function changeCurreny(value){
      if (value == "usd") {
        $("#inputPriceProduct").closest("div").find(".input-group-text").text("$")
        $("#inputTotalPrice").closest("div").find("div").text("$")
        localStorage.setItem("isRupiah",false)
        $('.money').mask('#0,00', {reverse: true})

        // $(".money").mask('000.000.000.000.000', {reverse: true})
      }else{
        $("#inputPriceProduct").closest("div").find(".input-group-text").text("Rp.")
        $("#inputTotalPrice").closest("div").find("div").text("Rp.")

        localStorage.setItem("isRupiah",true)

        $('.money').mask('#.##0,00', {reverse: true})
      }

      if (localStorage.getItem('isRupiah') == 'true') {
        $("#inputTotalPrice").val(formatter.format(Math.round(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ','')))))
      }else{
        $("#inputTotalPrice").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
      }
    }

    currentTab = 0
    var isStartScroll = false
    function nextPrevUnFinished(n,valueEdit){
      if(localStorage.getItem('status_draft_pr') == 'pembanding'){
        url = "{{url('/admin/getDetailPr')}}"
        urlDokumen = "{{url('/admin/storePembandingDokumen')}}"
        urlProduct = "{{url('/admin/storePembandingProduct')}}"
        urlGetProduct = "{{url('/admin/getProductPembanding')}}"
        no_pr = localStorage.getItem("id_compare_pr")
      }else{
        url = "{{url('/admin/getPreviewPr')}}"
        urlDokumen = "{{url('/admin/storeDokumen')}}"
        urlProduct = "{{url('/admin/storeProductPr')}}"
        urlGetProduct = "{{url('/admin/getProductPr')}}"
        no_pr = localStorage.getItem("no_pr")
      }

      if (valueEdit == undefined) {
        if (valueEdit == 0) {
          $(".tabGroupInitiateAdd").attr('style','display:none!important')
          $(".tab-add")[1].children[1].style.display = "inline"
          $(".tab-add")[1].children[1].classList.remove('d-none')

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

        //ini false kalau nilainya angka
        if (!isNaN(valueEdit)) {
          $(".tabGroupInitiateAdd").attr('style','display:none!important')
          $(".tab-add")[1].children[1].style.display = "inline"
          $(".tab-add")[1].children[1].classList.remove('d-none')

          $.ajax({
            type: "GET",
            url: "{{url('/admin/getProductById')}}",
            data: {
              id_product:valueEdit,
            },
            success: function(result) {
              $.each(result,function(value,item){
                isStartScroll = false

                $("#prevBtnAdd").css("display", "none");
                localStorage.setItem('isEditProduct',true)
                localStorage.setItem('id_product',item.id_product)
                nominal = item.nominal_product
                $("#inputNameProduct").val(item.name_product)
                $("#inputDescProduct").val(item.description.replaceAll("<br>","\n"))
                $("#inputQtyProduct").val(item.qty)
                select2TypeProduct(item.unit)
                $("#inputPriceProduct").val(formatter.format(nominal))
                $("#inputSerialNumber").val(item.serial_number)
                $("#inputPartNumber").val(item.part_number)
                $("#inputTotalPrice").val(formatter.format(item.grand_total))
                if (item.isRupiah == "false") {
                  $("#inputPriceProduct").closest("div").find(".input-group-text").text("$")
                }else{
                  $("#inputPriceProduct").closest("div").find(".input-group-text").text("Rp.")
                }
              })
            }
          })
          // $.ajax({
          //   type: "GET",
          //   url: urlGetProduct,
          //   data: {
          //     no_pr:no_pr,
          //   },
          //   success: function(result) {
          //     $.each(result.data,function(value,item){
          //       $("#prevBtnAdd").css("display", "none");
          //       localStorage.setItem('isEditProduct',true)
          //       localStorage.setItem('id_product',result.data[valueEdit].id_product)
          //       nominal = result.data[valueEdit].nominal_product
          //       $("#inputNameProduct").val(result.data[valueEdit].name_product)
          //       $("#inputDescProduct").val(result.data[valueEdit].description.replaceAll("<br>","\n"))
          //       $("#inputQtyProduct").val(result.data[valueEdit].qty)
          //       select2TypeProduct(result.data[valueEdit].unit)
          //       $("#inputPriceProduct").val(formatter.format(nominal))
          //       $("#inputSerialNumber").val(result.data[valueEdit].serial_number)
          //       $("#inputPartNumber").val(result.data[valueEdit].part_number)
          //       $("#inputTotalPrice").val(formatter.format(result.data[valueEdit].grand_total))
          //     })
          //   }
          // })
        }
      }

      if (currentTab == 0) { 
        isStartScroll = true
        if ($("#selectType").val() == "") {
          $("#selectType").closest('.form-group').addClass('needs-validation ')
          $("#selectType").closest('select').next('span').show();
          $("#selectType").prev('.input-group-text').css("background-color","red");
        }else if ($("#inputEmail").val() == "") {
          $("#inputEmail").closest('.form-group').addClass('needs-validation ')
          $("#inputEmail").closest('input').next('span').show();
          $("#inputEmail").prev('.input-group-text').css("background-color","red");
          $("#inputEmail").closest('input').next('span').text("Please fill an Email!")
        }else if ($("#selectCategory").val() == "") {
          $("#selectCategory").closest('.form-group').addClass('needs-validation ')
          $("#selectCategory").closest('select').next('span').show();
          $("#selectCategory").prev('.input-group-text').css("background-color","red");
        }else if ($("#selectPosition").val() == "") {
          $("#selectPosition").closest('.form-group').addClass('needs-validation ')
          $("#selectPosition").closest('select').next('span').show();
          $("#selectPosition").prev('.input-group-text').css("background-color","red");
        }else if ($("#inputPhone").val() == "") {
          $("#inputPhone").closest('.form-group').addClass('needs-validation ')
          $("#inputPhone").closest('input').next('span').show();
          $("#inputPhone").prev('.input-group-text').css("background-color","red");
        }else if($("#inputAttention").val() == "") {
          $("#inputAttention").closest('.form-group').addClass('needs-validation ')
          $("#inputAttention").closest('input').next('span').show();
          $("#inputAttention").prev('.input-group-text').css("background-color","red");
        }else if($("#inputFrom").val() == "") {
          $("#inputFrom").closest('.form-group').addClass('needs-validation ')
          $("#inputFrom").closest('input').next('span').show();
          $("#inputFrom").prev('.input-group-text').css("background-color","red");
        }else if($("#inputSubject").val() == "") {
          $("#inputSubject").closest('.form-group').addClass('needs-validation ')
          $("#inputSubject").closest('input').next('span').show();
          $("#inputSubject").prev('.input-group-text').css("background-color","red");
        }else if($("#inputAddress").val() == "") {
          $("#inputAddress").closest('.form-group').addClass('needs-validation ')
          $("#inputAddress").closest('textarea').next('span').show();
          $("#inputAddress").prev('.input-group-text').css("background-color","red");
        }else if($("#selectMethode").val() == ""){
          $("#selectMethode").closest('.form-group').addClass('needs-validation ')
          $("#selectMethode").closest('select').next('span').show();
          $("#selectMethode").prev('.input-group-text').css("background-color","red");
        }else{
          let commitValue = ''
          if ($("#cbCommit").is(':checked')){
            commitValue = 'True'
          }else{
            commitValue = 'False'
          }

          let inputTo = ""
          if ($("#selectTo").val() == ""  || $('#selectTo').val() == null) {
            inputTo = $("#inputTo").val()
          }else{
            inputTo = $("#selectTo").val()
          }

          $.ajax({
            type:"POST",
            url:"{{url('/admin/updateSupplier/')}}",
            data:{
              _token:"{{ csrf_token() }}",
              inputTo:inputTo,
              selectType:$("#selectType").val(),
              inputEmail:$("#inputEmail").val(),
              inputPhone:$("#inputPhone").val(),
              // inputFax:$("#inputFax").val(),
              inputAttention:$("#inputAttention").val(),
              inputSubject:$("#inputSubject").val(),
              inputAddress:$("#inputAddress").val(),
              selectMethode:$("#selectMethode").val(),
              selectPosition:$("#selectPosition").val(),
              selectCategory:$("#selectCategory").val(),
              cbCommit:commitValue,
              no_pr:localStorage.getItem('no_pr')
            },beforeSend:function(){
              Swal.fire({
                  title: 'Please Wait..!',
                  text: "It's saving..",
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
            success: function(data)
            {
              Swal.close()
              let x = document.getElementsByClassName("tab-add");
              x[currentTab].classList.add("d-none");
              currentTab = currentTab + n;
              if (currentTab >= x.length) {
                x[n].classList.add("d-none");
                currentTab = 0;
              }
              unfinishedDraft(currentTab,localStorage.getItem('no_pr'),localStorage.getItem("status_unfinished"));
            }
          })          
        }         
      }else if (currentTab == 1) {
        isStartScroll = true
        
        if (($(".tab-add")[1].children[1].style.display == 'inline' ) == true) {
          if (n == 1) {
            if ($("#inputNameProduct").val() == "") {
              $("#inputNameProduct").closest('.form-group').addClass('needs-validation ')
              $("#inputNameProduct").closest('input').next('span').show();
              $("#inputNameProduct").prev('.input-group-text').css("background-color","red");
            }else if ($("#inputDescProduct").val() == "") {
              $("#inputDescProduct").closest('.form-group').addClass('needs-validation ')
              $("#inputDescProduct").closest('textarea').next('span').show();
              $("#inputDescProduct").prev('.input-group-text').css("background-color","red");
            }else if ($("#inputQtyProduct").val() == "") {
              $("#inputQtyProduct").closest('.col-md-4').addClass('needs-validation ')
              $("#inputQtyProduct").closest('input').next('span').show();
              $("#inputQtyProduct").prev('.input-group-text').css("background-color","red");
            }else if ($("#selectTypeProduct").val() == "") {
              $("#selectTypeProduct").closest('.col-md-4').addClass('needs-validation ')
              $("#selectTypeProduct").closest('select').next('span').next('span').show();
              $("#selectTypeProduct").prev('.input-group-text').css("background-color","red");
            }else if ($("#inputPriceProduct").val() == "") {
              $("#inputPriceProduct").closest('.col-md-4').addClass('needs-validation ')
              $("#inputPriceProduct").closest('input').closest('.input-group').next('span').show();
              $("#inputPriceProduct").prev('.col-md-4').css("background-color","red");
            }else{
              if (localStorage.getItem('isEditProduct') == 'true') {
                $.ajax({
                  url: "{{url('/admin/updateProductPr')}}",
                  type: 'post',
                  data: {
                   _token:"{{ csrf_token() }}",
                   id_product:localStorage.getItem('id_product'),
                   inputNameProduct:$("#inputNameProduct").val(),
                   inputDescProduct:$("#inputDescProduct").val().replaceAll("\n","<br>"),
                   inputQtyProduct:$("#inputQtyProduct").val(),
                   selectTypeProduct:$("#selectTypeProduct").val(),
                   inputPriceProduct:$("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''),
                   inputTotalPrice:$("#inputTotalPrice").val().replace(/\./g,'').replace(',','.').replace(' ',''),
                   inputSerialNumber:$("#inputSerialNumber").val(),
                   inputPartNumber:$("#inputPartNumber").val(),
                   inputGrandTotalProduct:$("#inputFinalPageTotalPrice").val(),
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
                    let x = document.getElementsByClassName("tab-add");
                    x[currentTab].classList.add("d-none");
                    currentTab = currentTab + n;
                    if (currentTab >= x.length) {
                      x[n].classList.add("d-none");
                      currentTab = 0;
                    }
                    unfinishedDraft(currentTab,localStorage.getItem('no_pr'),localStorage.getItem("status_unfinished"));
                    localStorage.setItem('isEditProduct',false)
                    $(".tabGroupInitiateAdd").show()
                    $(".tab-add")[1].children[1].style.display = 'none'
                    document.getElementsByClassName('tabGroupInitiateAdd')[0].childNodes[1].style.display = 'flex' 
                    $("#inputNameProduct").val('')
                    $("#inputDescProduct").val('')
                    $("#inputPriceProduct").val('')
                    $("#inputQtyProduct").val('')
                    $("#inputSerialNumber").val('')
                    $("#inputPartNumber").val('')
                    $("#inputTotalPrice").val('')
                  }
                })
              }else{
                $.ajax({
                  url: urlProduct,
                  type: 'post',
                  data: {
                   _token:"{{ csrf_token() }}",
                   no_pr:no_pr,
                   selectBudgetType:$("#selectBudgetType").val(),
                   inputFromBudgetType:$("#fromBudgetType").text(),
                   inputNameProduct:$("#inputNameProduct").val(),
                   inputDescProduct:$("#inputDescProduct").val().replaceAll("\n","<br>"),
                   inputQtyProduct:$("#inputQtyProduct").val(),
                   selectTypeProduct:$("#selectTypeProduct").val(),
                   inputSerialNumber:$("#inputSerialNumber").val(),
                   inputPartNumber:$("#inputPartNumber").val(),
                   inputPriceProduct:$("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''),
                   inputTotalPrice:$("#inputTotalPrice").val().replace(/\./g,'').replace(',','.').replace(' ',''),
                   inputGrandTotalProduct:$("#inputGrandTotalProduct").val(),
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
                    let x = document.getElementsByClassName("tab-add");
                    x[currentTab].classList.add("d-none");
                    currentTab = currentTab + n;
                    if (currentTab >= x.length) {
                      x[n].classList.add("d-none");
                      currentTab = 0;
                    }
                    unfinishedDraft(currentTab,localStorage.getItem('no_pr'),localStorage.getItem("status_unfinished"));
                    $(".tabGroupInitiateAdd").show()
                    $(".tab-add")[1].children[1].style.display = 'none'
                    document.getElementsByClassName('tabGroupInitiateAdd')[0].childNodes[1].style.display = 'flex'
                    $("#inputNameProduct").val('')
                    $("#inputDescProduct").val('')
                    $("#inputPriceProduct").val('')
                    $("#inputQtyProduct").val('')
                    $("#inputSerialNumber").val('')
                    $("#inputPartNumber").val('')
                    $("#inputTotalPrice").val('')
                  }
                })
              }               
            } 
          }else{
            $(".tabGroupInitiateAdd").show()
            $(".tab-add")[1].children[1].style.display = 'none'
            document.getElementsByClassName('tabGroupInitiateAdd')[0].childNodes[1].style.display = 'flex' 
          }
           
        }else{

          if ($('#uploadCsv').val() == "") {
            let x = document.getElementsByClassName("tab-add");
            x[currentTab].classList.add("d-none");
            currentTab = currentTab + n;
            if (currentTab >= x.length) {
              x[n].classList.add("d-none");
              currentTab = 0;
            }
            unfinishedDraft(currentTab,localStorage.getItem('no_pr'),localStorage.getItem("status_unfinished"));
          }else{
            var dataForm = new FormData();
            dataForm.append('csv_file',$('#uploadCsv').prop('files')[0]);
            dataForm.append('_token','{{ csrf_token() }}');
            dataForm.append('no_pr',localStorage.getItem('no_pr'));

            $.ajax({
              processData: false,
              contentType: false,
              url: "{{url('/admin/uploadCSV')}}",
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
                cancelUploadCsv()

                if (result.status == "Error") {
                  reasonReject(result.text,"block","tabGroupInitiateAdd")
                }else{
                  let x = document.getElementsByClassName("tab-add");
                  x[currentTab].classList.add("d-none");
                  currentTab = currentTab + n;
                  if (currentTab >= x.length) {
                    x[n].classList.add("d-none");
                    currentTab = 0;
                  }
                  unfinishedDraft(currentTab,localStorage.getItem('no_pr'),localStorage.getItem("status_unfinished"));
                  $(".divReasonRejectRevision").remove()
                  //nge reset upload csv
                  // cancelUploadCsv()
                }
              }
            })
          }
        }    
      }
      else if (currentTab == 3) {
        $("#btnAddDocPendukung_epr").prop("disabled",false)
        $("#btnAddDocPendukung_ipr").prop("disabled",false)
        if (n == 1) {
          if ($("#selectType").val() == 'IPR') {
            $.ajax({
                type: "GET",
                url: url,
                data: {
                  no_pr:localStorage.getItem('no_pr'),
                },
                success:function(result){
                  let formData = new FormData();
                  const filepenawaranHarga = $('#inputPenawaranHarga').prop('files')[0];
                  var arrInputDocPendukung = []

                  if (result.dokumen.length > 0) {
                    if ($('#inputPenawaranHarga').prop('files')[0].name.replace("/","") != result.dokumen[0].dokumen_location.substring(0,15) + '....'+ result.dokumen[0].dokumen_location.split(".")[0].substring(result.dokumen[0].dokumen_location.length -10) + "." + result.dokumen[0].dokumen_location.split(".")[1]) {
                      formData.append('inputPenawaranHarga', filepenawaranHarga)
                    } else {
                      formData.append('inputPenawaranHarga', '-')
                    }

                    if (result.dokumen[1] != undefined) {
                      if (!(result.dokumen.slice(1).length == $('#tableDocPendukung_ipr .trDocPendukung').length)) {
                        $('#tableDocPendukung_ipr .trDocPendukung').slice(result.dokumen.slice(1).length).each(function(){
                          var fileInput = $(this).find('#inputDocPendukung').prop('files').length
                          if (fileInput == 0) { 
                            

                            formData.append('inputDocPendukung[]','-')
                          }else{
                          

                            formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0])
                            arrInputDocPendukung.push({
                              nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
                              no_pr:no_pr
                            })
                          }
                        })

                      }else{
                        
                        var fileInput = $(this).find('#inputDocPendukung').val()
                        if (fileInput && fileInput !== '') { 
                          formData.append('inputDocPendukung[]','-')
                        }
                      }  
                    }else{
                      $('#tableDocPendukung_ipr .trDocPendukung').each(function() {
                        var fileInput = $(this).find('#inputDocPendukung').val()
                        if (fileInput && fileInput !== '') { 
                          formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0])
                          arrInputDocPendukung.push({
                            nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
                            no_pr:no_pr
                          })
                        }
                      });
                    }
                                    
                  }else{
                    formData.append('inputPenawaranHarga', filepenawaranHarga);
                    $('#tableDocPendukung_ipr .trDocPendukung').each(function() {
                      var fileInput = $(this).find('#inputDocPendukung').val()
                      if (fileInput && fileInput !== '') { 
                        formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0])
                        arrInputDocPendukung.push({
                          nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
                          no_pr:no_pr
                        }) 
                      }
                    });
                    
                  }               

                  formData.append('_token',"{{csrf_token()}}")
                  formData.append('arrInputDocPendukung',JSON.stringify(arrInputDocPendukung))
                  formData.append('no_pr',no_pr)

                  function storeIPR(urlDokumen,formData){
                    if (n == 1) {
                      $.ajax({
                        url: urlDokumen,
                        type: 'post',
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
                              didOpen: () => {
                                  Swal.showLoading()
                              }
                          })
                        },
                        success: function(data)
                        {
                          Swal.close()
                          let x = document.getElementsByClassName("tab-add");
                          x[currentTab].classList.add("d-none");
                          currentTab = currentTab + n;
                          if (currentTab >= x.length) {
                            x[n].classList.add("d-none");
                            currentTab = 0;
                          }
                          unfinishedDraft(currentTab,localStorage.getItem('no_pr'),localStorage.getItem("status_unfinished"));
                        }
                      });
                    }else{
                      let x = document.getElementsByClassName("tab-add");
                      x[currentTab].classList.add("d-none");
                      currentTab = currentTab + n;
                      if (currentTab >= x.length) {
                        x[n].classList.add("d-none");
                        currentTab = 0;
                      }
                      unfinishedDraft(currentTab,localStorage.getItem('no_pr'),localStorage.getItem("status_unfinished"));
                    } 
                  }

                  if ($("#inputPenawaranHarga").val() == "") {
                    $("#inputPenawaranHarga").closest('.form-group').addClass('needs-validation ')
                    $("#inputPenawaranHarga").closest('div').next('span').show();
                    $("#inputPenawaranHarga").prev('.input-group-text').css("background-color","red"); 
                  }else if($("#tableDocPendukung_ipr .trDocPendukung").length > 0){
                    
                    if (result.dokumen[1] != undefined) {
                      if (!(result.dokumen.slice(1).length == $('#tableDocPendukung_ipr .trDocPendukung').length)) {
                        $('#tableDocPendukung_ipr .trDocPendukung').slice(result.dokumen.slice(1).length).each(function(){
                          if ($(this).find('.inputDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).val() != "") {
                            if ($(this).find('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).val() == "") {
                              
                              $('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).next('span').show()
                              
                              $('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).css("border-color","red");
                            }else{
                              storeIPR(urlDokumen,formData)
                            }
                          }else{
                            storeIPR(urlDokumen,formData)
                          }
                        })
                      }else{
                        
                        var fileInput = $(this).find('#inputDocPendukung').val()
                        if (fileInput && fileInput !== '') { 
                          formData.append('inputDocPendukung[]','-')
                        }

                        storeIPR(urlDokumen,formData)
                      }  
                    }else{
                      $('#tableDocPendukung_ipr .trDocPendukung').slice(result.dokumen.slice(1).length).each(function(){
                        if ($(this).find('.inputDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).val() != "") {
                          if ($(this).find('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).val() == "") {
                            
                            $('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).next('span').show()
                            
                            $('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).css("border-color","red");
                          }else{
                            storeIPR(urlDokumen,formData)
                          }
                        }else{
                          storeIPR(urlDokumen,formData)
                        }
                      })
                    }
                  }else{
                    storeIPR(urlDokumen,formData)
                  }               
                }
            })
          }else{
            if ($("#projectIdInputNew").is(":visible") == false) {
              if ($("#selectPid").val() == "") {
                $("#selectPid").closest('.form-group').addClass('needs-validation ')
                $("#selectPid").closest('select').next('span').next("span").show(); 
                $("#selectPid").prev('.col-md-6').css("background-color","red");
              }
            }

            if ($("#selectLeadId").val() == "") {
              $("#selectLeadId").closest('.form-group').addClass('needs-validation ')
              $("#selectLeadId").closest('select').next('span').next("span").show(); 
              $("#selectLeadId").prev('.col-md-6').css("background-color","red");
            }else if ($("#inputQuoteNumber").val() == "") {
              $("#inputQuoteNumber").closest('.form-group').addClass('needs-validation ')
              $("#inputQuoteNumber").closest('select').next('span').next("span").show(); 
              $("#inputQuoteNumber").prev('.col-md-6').css("background-color","red");
            }else if ($("#inputQuoteSupplier").val() == "") {
              $("#inputQuoteSupplier").closest('.form-group').addClass('needs-validation ')
              $("#inputQuoteSupplier").closest('div').next('span').show();
              $("#inputQuoteSupplier").prev('.input-group-text').css("background-color","red");
            }else if ($("#inputSPK").val() == "") {
              $("#inputSPK").closest('.form-group').addClass('needs-validation ')
              $("#inputSPK").closest('div').next('span').show();
              $("#inputSPK").prev('.input-group-text').css("background-color","red");
            }else if ($("#inputSBE").val() == "") {
              $("#inputSBE").closest('.form-group').addClass('needs-validation ')
              $("#inputSBE").closest('div').next('span').show();
              $("#inputSBE").prev('.input-group-text').css("background-color","red");
            }else{
              $.ajax({
                type: "GET",
                url: url,
                data: {
                  no_pr:localStorage.getItem('no_pr'),
                },
                success:function(result){
                  let formData = new FormData();

                  const fileSpk = $('#inputSPK').prop('files')[0];
                  var nama_file_spk = $('#inputSPK').val();

                  const fileQuoteSupplier = $('#inputQuoteSupplier').prop('files')[0];
                  var nama_file_quote_supplier = $('#inputQuoteSupplier').val();

                  const fileSbe = $('#inputSBE').prop('files')[0];
                  var nama_file_sbe = $('#inputSBE').val();          

                  if (result.dokumen.length > 0) {
                    if (result.dokumen[0] !== undefined) {
                      if (result.dokumen[0].dokumen_location != $('#inputQuoteSupplier').prop('files')[0].name.replace("/","") || $('#inputQuoteSupplier').prop('files').length == 0) {
                        formData.append('inputQuoteSupplier', fileQuoteSupplier);
                      } else {
                        formData.append('inputQuoteSupplier', "-");
                      }
                    }else{
                        formData.append('inputQuoteSupplier', fileQuoteSupplier);
                    }

                    if (result.dokumen[1] !== undefined) {
                      if (result.dokumen[1].dokumen_location != $('#inputSPK').prop('files')[0].name.replace("/","") || $('#inputSPK').prop('files').length == 0) {
                        formData.append('inputSPK', fileSpk);
                      } else {
                        formData.append('inputSPK', "-");
                      }
                    }else{
                      formData.append('inputSPK', fileSpk);
                    }                  

                    if (result.dokumen[2] !== undefined) {
                      if (result.dokumen[2].dokumen_location != $('#inputSBE').prop('files')[0].name.replace("/","") || $('#inputSBE').prop('files').length == 0) {
                        formData.append('inputSBE', fileSbe);
                      } else {
                        formData.append('inputSBE', "-");
                      }
                    }else{
                        formData.append('inputSBE', fileSbe);
                    }

                  }else{
                    formData.append('inputSPK', fileSpk);
                    formData.append('inputQuoteSupplier', fileQuoteSupplier);
                    formData.append('inputSBE', fileSbe);
                  }

                  formData.append('_token',"{{csrf_token()}}")
                  formData.append('no_pr',no_pr)
                  formData.append('selectLeadId', $("#selectLeadId").val())
                  formData.append('selectPid', $("#selectPid").val())
                  formData.append('inputPid',$("#projectIdInputNew").val())
                  formData.append('selectQuoteNumber', $("#selectQuoteNumber").val())

                  function storeEPR(urlDokumen,formData){
                    if(n == 1){
                      $.ajax({
                        type:"POST",
                        url:urlDokumen,
                        processData: false,
                        contentType: false,
                        data:formData,
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
                          let x = document.getElementsByClassName("tab-add");
                          x[currentTab].classList.add("d-none");
                          currentTab = currentTab + n;
                          if (currentTab >= x.length) {
                            x[n].classList.add("d-none");
                            currentTab = 0;
                          }
                          unfinishedDraft(currentTab,localStorage.getItem('no_pr'),localStorage.getItem("status_unfinished"));
                        }
                      })
                    } else {
                      let x = document.getElementsByClassName("tab-add");
                      x[currentTab].classList.add("d-none");
                      currentTab = currentTab + n;
                      if (currentTab >= x.length) {
                        x[n].classList.add("d-none");
                        currentTab = 0;
                      }
                      unfinishedDraft(currentTab,localStorage.getItem('no_pr'),localStorage.getItem("status_unfinished"));
                    }
                  }
                  
                  arrInputDocPendukungEPR = []
                  if($("#tableDocPendukung_epr .trDocPendukung").length > 0){
                      if (!(result.dokumen.slice(3).length == $('#tableDocPendukung_epr .trDocPendukung').length)) {

                        $('#tableDocPendukung_epr .trDocPendukung').slice(result.dokumen.slice(3).length).each(function(){
                          if ($(this).find('.inputDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).val() != "") {
                            if ($(this).find('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).val() == "") {
                              
                              $('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).next('span').show()
                              
                              $('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).css("border-color","red");
                            }else{
                              arrInputDocPendukungEPR.push({
                                nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
                                no_pr:no_pr
                              })

                              formData.append('arrInputDocPendukung',JSON.stringify(arrInputDocPendukungEPR))
                              formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0]) 
                              // arrInputDocPendukungEPR.push({
                              //   nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
                              //   no_pr:no_pr
                              // })

                              // formData.append('arrInputDocPendukung',JSON.stringify(arrInputDocPendukungEPR))
                              // formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0])
                              // storeEPR(urlDokumen,formData)
                            }
                          }else{
                            // storeEPR(urlDokumen,formData)
                          }
                        })
                      }else{
                        // arrInputDocPendukungEPR.push({
                        //   nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
                        //   no_pr:no_pr
                        // })
                        formData.append('arrInputDocPendukung',JSON.stringify(arrInputDocPendukungEPR))
                        formData.append('inputDocPendukung[]','-')

                        // storeEPR(urlDokumen,formData)
                      } 


                  }else{
                    formData.append('arrInputDocPendukung',JSON.stringify(arrInputDocPendukungEPR))
                    formData.append('inputDocPendukung[]','-')                    
                  }
                  storeEPR(urlDokumen,formData)
                  // if (result.dokumen.length > 0) {
                  //   if (!(result.dokumen.slice(3).length == $('#tableDocPendukung_epr .trDocPendukung').length)) {
                  //     $('#tableDocPendukung_epr .trDocPendukung').slice(result.dokumen.slice(3).length).each(function(){
                  //         

                  //       if ($(this).find('.inputDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).val() != "") {
                  //         if ($(this).find('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).val() == "") {
                  //           
                  //           $('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).next('span').show()
                  //           
                  //           $('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).css("border-color","red");
                  //         }else{
                  //           
                  //           formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0])
                  //           arrInputDocPendukung.push({
                  //             nameDocPendukung:$(this).find('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).val(),
                  //             no_pr:no_pr
                  //           })
                  //           storeEPR(urlDokumen,formData)
                  //         }
                  //       }else{
                  //         
                  //         storeEPR(urlDokumen,formData)
                  //       }
                        
                  //     })

                  //   }else{
                  //     var fileInput = $(this).find('#inputDocPendukung').prop('files').length
                  //     if (fileInput == 0) { 
                  //       

                  //       formData.append('inputDocPendukung[]','-')
                  //       storeEPR(urlDokumen,formData)
                  //     }

                  //   }                                 
                  // }else{
                  //   $('#tableDocPendukung_epr .trDocPendukung').each(function() {
                  //     var fileInput = $(this).find('#inputDocPendukung').prop('files').length
                  //     if (fileInput !== 0) { 

                  //       formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0])
                  //       arrInputDocPendukung.push({
                  //         nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
                  //         no_pr:no_pr
                  //       })

                  //       storeEPR(urlDokumen,formData)
                  //     }else{
                  //       formData.append('inputDocPendukung[]','-')

                  //       storeEPR(urlDokumen,formData)
                  //     }
                  //   })
                  // } 
                          
                }
              })            
            } 
          }
        }else{
          let x = document.getElementsByClassName("tab-add");
          x[currentTab].classList.add("d-none");
          currentTab = currentTab + n;
          if (currentTab >= x.length) {
            x[n].classList.add("d-none");
            currentTab = 0;
          }
          
          unfinishedDraft(currentTab,localStorage.getItem('no_pr'),localStorage.getItem("status_unfinished"));
        }
      }
      else if (currentTab == 4) {
        if (n == 1) {
          if (snowEditor.getText().trim() == "") {
            $("#snow-editor").next('span').show()
          }else{
            $("#snow-editor").next('span').attr('style','display:none!important')

            $.ajax({
              url: "{{'/admin/storeTermPayment'}}",
              type: 'post',
              data:{
                no_pr:localStorage.getItem('no_pr'),
                _token:"{{csrf_token()}}",
                textAreaTOP:snowEditor.root.innerHTML,
              },
              success: function(data)
              {
                let x = document.getElementsByClassName("tab-add");
                x[currentTab].classList.add("d-none");
                currentTab = currentTab + n;
                if (currentTab >= x.length) {
                  x[n].classList.add("d-none");
                  currentTab = 0;
                }
                unfinishedDraft(currentTab,localStorage.getItem('no_pr'),localStorage.getItem("status_unfinished"));
              }
            }); 
          }
        }else{
          let x = document.getElementsByClassName("tab-add");
          x[currentTab].classList.add("d-none");
          currentTab = currentTab + n;
          if (currentTab >= x.length) {
            x[n].classList.add("d-none");
            currentTab = 0;
          }
          unfinishedDraft(currentTab,localStorage.getItem('no_pr'),localStorage.getItem("status_unfinished"));
        }
                
      }else{
        $.ajax({
          type:"POST",
          url:"{{url('/admin/storeTax')}}",
            data:{
              _token:"{{csrf_token()}}",
              no_pr:localStorage.getItem('no_pr'),
              isRupiah:localStorage.getItem('isRupiah'),
              status_tax:localStorage.getItem('status_tax'),
              discount:localStorage.getItem('discount')=='NaN'?0:localStorage.getItem('discount'),
              tax_pb:localStorage.getItem('tax_pb')=='NaN'?0:localStorage.getItem('tax_pb'),
              service_charge:localStorage.getItem('service_charge')=='NaN'?0:localStorage.getItem('service_charge'),
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
              let x = document.getElementsByClassName("tab-add");
              x[currentTab].classList.add("d-none");
              currentTab = currentTab + n;
              if (currentTab >= x.length) {
                x[n].classList.add("d-none");
                currentTab = 0;
              }

              unfinishedDraft(currentTab,localStorage.getItem('no_pr'),localStorage.getItem("status_unfinished"));
          }
        })
      }
    }

    function addTable(n,status,results=""){ 
      if (window.location.href.split("/")[6] == undefined) {
        if (localStorage.getItem('status_pr') == 'revision') {
          url = "{{url('/admin/getProductPembanding')}}"
          no_pr = localStorage.getItem('id_compare_pr')
        }else{
          url = "{{url('/admin/getProductPr')}}"
          no_pr = localStorage.getItem('no_pr')
        }
      }else{
        url = "{{url('/admin/getProductPembanding')}}"
        no_pr = localStorage.getItem('no_pembanding')
      }
      $.ajax({
        type: "GET",
        url: url,
        data: {
          no_pr:no_pr,
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
                append = append + "<input id='inputNameProductEdit' data-value='' disabled style='font-size: 12px;min-width:150px' class='form-control' type='' name='' value='"+ item.name_product + "'>"
              append = append + '</td>'
              append = append + '<td width="30%">'
                append = append + '<textarea id="textAreaDescProductEdit" disabled data-value="" style="font-size: 12px; important;resize:none;min-height:110px;min-width:200px" class="form-control">'+ item.description.replaceAll("<br>","\n") + '&#10;&#10;SN : ' + item.serial_number + '&#10;PN : ' + item.part_number 
                append = append + '</textarea>'
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
                append = append + '<input id="inputPriceEdit" disabled data-value="" style="font-size: 12px;width:100px" class="form-control" type="" name="" value="'+ formatter.format(item.nominal_product) +'">'
              append = append + '</td>'
              append = append + '<td width="15%">'
                append = append + '<input id="inputTotalPriceEdit" disabled data-value="" style="font-size: 12px;width:100px" class="form-control inputTotalPriceEdit" type="" name="" value="'+ formatter.format(item.grand_total) +'">'
              append = append + '</td>'
              append = append + '<td width="8%">'
                if (localStorage.getItem('status_pr') == 'draft') {
                  btnNext = 'nextPrevAdd(-1,'+ item.id_product +')'
                }else{
                  btnNext = 'nextPrevUnFinished(-1,'+ item.id_product +')'
                }
                append = append + '<button type="button" onclick="'+ btnNext +'" id="btnEditProduk" data-id="'+ value +'" data-value="'+ valueEdit +'" class="btn btn-sm text-bg-warning bx bx-edit btnEditProduk" style="width:25px;height:25px;margin-bottom:5px"></button>'
                append = append + '<button id="btnDeleteProduk" type="button" data-id="'+ item.id_product +'" data-value="'+ value +'" class="btn btn-sm btn-danger bx bx-trash" style="width:25px;height:25px"></button>'
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
              appendBottom = appendBottom + '    <div style="text-align:right">'
              appendBottom = appendBottom + '      <span style="display: inline;margin-right: 15px;">Total</span>'
              appendBottom = appendBottom + '      <input disabled="" type="text" style="width:250px;display: inline;" class="form-control inputTotalProduct" id="inputGrandTotalProduct" name="inputGrandTotalProduct">'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
            appendBottom = appendBottom + '</div>'

            appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
              appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'

              appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
              appendBottom = appendBottom + '      <div class="checkbox" style="margin-top:5px"><label><input type="checkbox" class="" id="cbInputDiscountProduct">&nbsp&nbspDiscount</label></div>'
              appendBottom = appendBottom + ' <input type="text" style="width: 170px;display: inline;margin-left: 15px;text-align: left;" class="form-control money" id="inputDiscountNominal" name="inputdiscountNominal" disabled onkeyup="changeVatValue('+ "'discount'"+')">'
              appendBottom = appendBottom + '      <input type="text" style="width:80px;display: inline" class="form-control inputDiscountProduct" id="inputDiscountProduct" name="inputDiscountProduct" disabled>'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
            appendBottom = appendBottom  + '</div>'

             appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
              appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + '    <div class="pull-right">'
              appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Tax Base Other</span>'
              appendBottom = appendBottom + '      <input disabled type="text" style="width:250px;display: inline;" class="form-control inputTaxBaseOtherFinal" id="inputTaxBaseOtherFinal" name="inputTaxBaseOtherFinal">'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
            appendBottom = appendBottom  + '</div>'

            appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
              appendBottom = appendBottom + '<div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + ' <div class="pull-right" style="display:flex">'
              appendBottom = appendBottom + '  <span style="margin-right: 15px;margin-top: 8px;display:block ruby">Vat <span class="title_tax"></span>'
              appendBottom = appendBottom + '  </span>'
              appendBottom = appendBottom + '  <div class="input-group" style="display: inline-flex;">'
              appendBottom = appendBottom + '   <input disabled type="text" class="form-control vat_tax" id="vat_tax" name="vat_tax" style="width:208px;display:inline">'
              appendBottom = appendBottom + '       <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">'
              appendBottom = appendBottom + '       </button>'
              appendBottom = appendBottom + '       <ul class="dropdown-menu">'
              appendBottom = appendBottom + '       <li>'
              appendBottom = appendBottom + '        <a class="dropdown-item" onclick="changeVatValue(false)">Without Vat</a>'
              appendBottom = appendBottom + '       </li>'
              appendBottom = appendBottom + '       <li>'
              appendBottom = appendBottom + '        <a class="dropdown-item" onclick="changeVatValue(11)">Vat 12%</a>'
              appendBottom = appendBottom + '       </li>'
              // appendBottom = appendBottom + '       <li>'
              // appendBottom = appendBottom + '        <a class="dropdown-item" onclick="changeVatValue(11)">Vat 11%</a>'
              // appendBottom = appendBottom + '       </li>'
              appendBottom = appendBottom + '       <li>'
              appendBottom = appendBottom + '        <a class="dropdown-item" onclick="changeVatValue('+ parseFloat(1.1) +')">Vat 1,2%</a>'
              appendBottom = appendBottom + '       </li>'
              // appendBottom = appendBottom + '       <li>'
              // appendBottom = appendBottom + '        <a class="dropdown-item" onclick="changeVatValue('+ parseFloat(1.1) +')">Vat 1,1%</a>'
              // appendBottom = appendBottom + '       </li>'
              appendBottom = appendBottom + '      </ul>'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
              appendBottom = appendBottom + '</div>'
            appendBottom = appendBottom + '</div>'

            appendBottom = appendBottom + '<div class="row mb-4">'
              appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
              appendBottom = appendBottom + '      <div class="checkbox" style="margin-top:5px"><label><input type="checkbox" class="" id="cbInputPb1Product">&nbsp&nbspPB1</label></div>'
              appendBottom = appendBottom + ' <input type="text" style="width: 170px;display: inline;margin-left: 15px;text-align: left;" class="form-control" id="inputPb1Nominal" disabled>'
              appendBottom = appendBottom + '      <input type="text" style="width:80px;display: inline" class="form-control inputPb1Product" id="inputPb1Product" name="inputPb1Product" disabled onkeyup="changeVatValue('+ "'pb1'"+')">'
              appendBottom = appendBottom + '    </div>'
              appendBottom = appendBottom + '  </div>'
            appendBottom = appendBottom  + '</div>'

            appendBottom = appendBottom + '<div class="row mb-4" style="margin-top: 10px;">'
              appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
              appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
              appendBottom = appendBottom + '      <div class="checkbox" style="margin-top:5px"><label><input type="checkbox" class="" id="cbInputServiceChargeProduct">&nbsp&nbspService Charge</label></div>'
              appendBottom = appendBottom + ' <input type="text" style="width: 170px;display: inline;margin-left: 15px;text-align: left;" class="form-control" id="inputServiceChargeNominal" disabled>'
              appendBottom = appendBottom + '      <input type="text" style="width:80px;display: inline" class="form-control inputServiceChargeProduct" id="inputServiceChargeProduct" name="inputServiceChargeProduct" disabled onkeyup="changeVatValue('+ "'service'"+')">'
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

          if (results != "") {
            setTimeout(function(argument) {
              changeValueGrandTotal(results.grand_total)
            },500)
            
            if (results.pr.tax_pb == "false") {
              toggleIcheckPajak(false)
            }else{
              toggleIcheckPajak(true)
              $("#inputPb1Nominal").val(formatter.format(Math.round(($("#inputGrandTotalProduct").val() == ""?0:parseFloat($("#inputGrandTotalProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))) * results.pr.tax_pb / 100)))
              $("#inputPb1Product").val(results.pr.tax_pb)
              $("#cbInputPb1Product").prop('checked',true);
            }

            if (results.pr.service_charge == "false") {
              toggleIcheckPajak(false)
            }else{
              $("#inputServiceChargeNominal").val(formatter.format(Math.round(($("#inputGrandTotalProduct").val() == ""?0:parseFloat($("#inputGrandTotalProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))) * results.pr.service_charge / 100)))
              $("#inputServiceChargeProduct").val(results.pr.service_charge)
              toggleIcheckPajak(true)
              $("#cbInputServiceChargeProduct").prop('checked',true);
            }

            if (results.pr.discount == "false") {
              toggleIcheckPajak(false)
            }else{
              $("#inputDiscountNominal").val(formatter.format(Math.round(($("#inputGrandTotalProduct").val() == ""?0:parseFloat($("#inputGrandTotalProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))) * results.pr.discount / 100)))
              setTimeout(function(){
                $("#inputDiscountProduct").val(parseFloat(results.pr.discount).toFixed(2))
              },500)
              toggleIcheckPajak(true)
              $("#cbInputDiscountProduct").prop('checked',true);
            }

            localStorage.setItem('tax_pb',parseInt(results.pr.tax_pb))
            localStorage.setItem('service_charge',parseInt(results.pr.service_charge))
            localStorage.setItem('discount',parseFloat(results.pr.discount))
          }else{
            toggleIcheckPajak(false)
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
                  url: "{{url('/admin/deleteProduct')}}",
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

    function toggleIcheckPajak(value){
      $('#cbInputPb1Product').on('change', function(event){
        if ($('#cbInputPb1Product').is(":checked")) {
          $("#inputPb1Product").prop("disabled",false)
        }
      });

      $('#cbInputPb1Product').on('change', function(event){
        if (!$('#cbInputPb1Product').is(":checked")) {
          $("#inputPb1Product").prop("disabled",true)
          if (value == false) {
            $("#inputPb1Product").val("")
            $("#inputPb1Nominal").val("")
            changeVatValue("pb1")
          }
        }
      });

      $('#cbInputServiceChargeProduct').on('change', function(event){
        if ($('#cbInputServiceChargeProduct').is(":checked")) {

          $("#inputServiceChargeProduct").prop("disabled",false)
        }
      });

      $('#cbInputServiceChargeProduct').on('change', function(event){
        if (!$('#cbInputServiceChargeProduct').is(":checked")) {

          $("#inputServiceChargeProduct").prop("disabled",true)
          if (value == false) {
            $("#inputServiceChargeProduct").val("")
            $("#inputServiceChargeNominal").val("")
            changeVatValue("service")
          }
        }
      });

      $('#cbInputDiscountProduct').on('change', function(event){
        if ($('#cbInputDiscountProduct').is(":checked")) {
          $("#inputDiscountNominal").prop("disabled",false)
        }
      });

      $('#cbInputDiscountProduct').on('change', function(event){
        if (!$('#cbInputDiscountProduct').is(":checked")) {
          $("#inputDiscountNominal").prop("disabled",true)
          if (value == false) {
            $("#inputDiscountNominal").val("")
             changeVatValue("discount")
          }
        }
      });
    }

    function scrollTopModal(){
      var savedScrollPosition = localStorage.getItem('scrollPosition');
      var scrollableElement = document.getElementById('ModalDraftPr');
      scrollableElement.scrollTop = savedScrollPosition;
    }

    $("#ModalDraftPr").on('scroll', function() {
      if (isStartScroll == true) {
        var scrollPosition = $("#ModalDraftPr .modal-body").scrollTop();
        localStorage.setItem('scrollPosition', scrollPosition);
      }
      // Update the scroll position variable with the latest scroll position
      // If a saved scroll position exists, set the scroll position to the saved value
    })

    var isFilledPenawaranHarga = true
    var isFilledDocPendukung = true
    var arrInputDocPendukung = []

    var nama_file_sbe = ""
    var nama_file_spk = ""
    var nama_file_quote_supplier = ""

    function nextPrevAdd(n,value) {
      valueEdit = value
      if (valueEdit == undefined) {
        if (valueEdit == 0) {
          $(".tabGroupInitiateAdd").attr('style','display:none!important')
          $(".tab-add")[1].children[1].style.display = "inline"
          $(".tab-add")[1].children[1].classList.remove('d-none')

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
          var append = '', appendFrom = ''
          $("select[name='selectBudgetType']").closest(".form-group").remove() 
          if ($("#selectCategory").val() == 'Perjalanan Dinas') {
            append = append + '<div class="form-group">'
              append = append + '<label>Budget Type*</label>'
                append = append + '<select name="selectBudgetType" class="form-control" id="selectBudgetType" placeholder="Select Budget Type" onchange="fillInput(' + "'" + 'budget_type' + "'" + ')">'
                  append = append + '<option value="" disabled selected>Select Budget Type</option>'
                  append = append + '<option value="OPERASIONAL">OPERASIONAL</option>'
                  append = append + '<option value="NON-OPERASIONAL">NON-OPERASIONAL</option>'
                append = append + '</select>'
              append = append + '<span class="invalid-feedback" style="display:none!important;">Please fill Budget Type!</span>'
            append = append + '</div>'

            if (!$("#selectBudgetType").is(":visible")) {
              $("#inputNameProduct").closest(".form-group").before(append)
            }

            $("#selectBudgetType").change(function(){
              console.log(this.value)
              if (this.value == 'OPERASIONAL') {
                appendFrom = appendFrom + '<div class="form-group">'
                  appendFrom = appendFrom + '<label>For*</label>'
                    appendFrom = appendFrom + '<select name="fromBudgetType" class="form-control" id="fromBudgetType" placeholder="Select Budget Type" onchange="fillInput(' + "'" + 'fromBudgetType' + "'" + ')">'
                      appendFrom = appendFrom + '<option></option>'
                    appendFrom = appendFrom + '</select>'
                  appendFrom = appendFrom + '<span class="invalid-feedback" style="display:none!important;">Please fill Budget Type!</span>'
                appendFrom = appendFrom + '</div>'

                if ($("#selectBudgetType").closest(".form-group").next().find("#fromBudgetType").length == 0) {
                  console.log("sini lagi")
                  $("#selectBudgetType").closest(".form-group").after(appendFrom)

                  $("#fromBudgetType").select2({
                    // data:dataCategory,
                    placeholder:"Select User",
                    ajax: {
                      url: '{{url("admin/getUserOperasional")}}',
                      dataType: 'json',
                      delay: 250,
                      data: function (params) {
                        return {
                          q:params.term
                        };
                      },
                      processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data,
                            pagination: {
                                more: (params.page * 10) < data.count_filtered
                            }
                        };
                      },
                    },
                    dropdownParent: $('#ModalDraftPr .modal-body'),
                  })
                }else{
                  $("#fromBudgetType").closest(".form-group").show()
                }                
              }else{
                var from = $("#fromBudgetType");
                var option = new Option('', '', true, true);
                from.append(option).trigger('change');

                $("#fromBudgetType").closest(".form-group").attr('style','display:none!important')
              }
            })
          }
          $(".tabGroupInitiateAdd").attr('style','display:none!important')
          $(".tab-add")[1].children[1].style.display = "inline"
          $(".tab-add")[1].children[1].classList.remove('d-none')

          $.ajax({
            type: "GET",
            url: "{{url('/admin/getProductById')}}",
            data: {
              id_product:valueEdit,
            },
            success: function(result) {
              $.each(result,function(value,item){
                if (item.budget_type) {
                  $("#selectBudgetType").val(item.budget_type)
                }

                if (item.for) {
                  var from = $("#fromBudgetType");
                  var option = new Option(item.from, item.from, true, true);
                  from.append(option).trigger('change');
                }
                $("#prevBtnAdd").css("display", "none");
                localStorage.setItem('isEditProduct',true)
                localStorage.setItem('id_product',item.id_product)
                nominal = item.nominal_product
                $("#inputNameProduct").val(item.name_product)
                $("#inputDescProduct").val(item.description.replaceAll("<br>","\n"))
                $("#inputQtyProduct").val(item.qty)
                select2TypeProduct(item.unit)
                $("#inputPriceProduct").val(formatter.format(nominal))
                $("#inputSerialNumber").val(item.serial_number)
                $("#inputPartNumber").val(item.part_number)
                $("#inputTotalPrice").val(formatter.format(item.grand_total))
                if (item.isRupiah == "false") {
                  $("#inputPriceProduct").closest("div").find(".input-group-text").text("$")
                }else{
                  $("#inputPriceProduct").closest("div").find(".input-group-text").text("Rp.")
                }
              })
            }
          })          
        }
      }

      if (currentTab == 0) {
        if ($("#selectTo").val() == "") {
          if ($("#inputTo").val() != "") {
            if ($("#inputTo").val() == "") {
              $("#inputTo").closest('.form-group').addClass('needs-validation ')
              $("#inputTo").closest('input').next('span').show();
              $("#inputTo").prev('.input-group-text').css("background-color","red");
            }
          }else{
            $("#selectTo").closest('.form-group').addClass('needs-validation ')
            $("#selectTo").closest('.form-group').find('.invalid-feedback').show()
            $("#selectTo").css("background-color","red");
          }
        }

        if ($("#selectType").val() == "") {
          $("#selectType").closest('.form-group').addClass('needs-validation ')
          $("#selectType").closest('select').next('span').show();
          $("#selectType").prev('.input-group-text').css("background-color","red");
        }else if ($("#inputEmail").val() == "") {
          $("#inputEmail").closest('.form-group').addClass('needs-validation ')
          $("#inputEmail").closest('input').next('span').show();
          $("#inputEmail").prev('.input-group-text').css("background-color","red");
          $("#inputEmail").closest('input').next('span').text("Please fill an Email!")
        }else if ($("#selectCategory").val() == "") {
          $("#selectCategory").closest('.form-group').addClass('needs-validation ')
          $("#selectCategory").closest('select').next('span').show();
          $("#selectCategory").prev('.input-group-text').css("background-color","red");
        }else if ($("#selectPosition").val() == "") {
          $("#selectPosition").closest('.form-group').addClass('needs-validation ')
          $("#selectPosition").closest('select').next('span').show();
          $("#selectPosition").prev('.input-group-text').css("background-color","red");
        }else if ($("#inputPhone").val() == "") {
          $("#inputPhone").closest('.form-group').addClass('needs-validation ')
          $("#inputPhone").closest('input').next('span').show();
          $("#inputPhone").prev('.input-group-text').css("background-color","red");
        }else if($("#inputAttention").val() == "") {
          $("#inputAttention").closest('.form-group').addClass('needs-validation ')
          $("#inputAttention").closest('input').next('span').show();
          $("#inputAttention").prev('.input-group-text').css("background-color","red");
        }else if($("#inputFrom").val() == "") {
          $("#inputFrom").closest('.form-group').addClass('needs-validation ')
          $("#inputFrom").closest('input').next('span').show();
          $("#inputFrom").prev('.input-group-text').css("background-color","red");
        }else if($("#inputSubject").val() == "") {
          $("#inputSubject").closest('.form-group').addClass('needs-validation ')
          $("#inputSubject").closest('input').next('span').show();
          $("#inputSubject").prev('.input-group-text').css("background-color","red");
        }else if($("#inputAddress").val() == "") {
          $("#inputAddress").closest('.form-group').addClass('needs-validation ')
          $("#inputAddress").closest('textarea').next('span').show();
          $("#inputAddress").prev('.input-group-text').css("background-color","red");
        }else if($("#selectMethode").val() == ""){
          $("#selectMethode").closest('.form-group').addClass('needs-validation ')
          $("#selectMethode").closest('select').next('span').show();
          $("#selectMethode").prev('.input-group-text').css("background-color","red");
        }else{
          let inputTo = ""
          if ($("#selectTo").val() == "") {
            inputTo = $("#inputTo").val()
          }else{
            inputTo = $("#selectTo").val()
          }

          if (value == true) {
            isStoreSupplier = localStorage.getItem('isStoreSupplier')
            if (isStoreSupplier == 'false') {
              let commitValue = ''
              if ($("#cbCommit").is(':checked')){
                commitValue = 'True'
              }else{
                commitValue = 'False'
              }
              Swal.fire({
                  title: 'Are you sure?',
                  text: "Save info Supplier",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes',
                  cancelButtonText: 'No',
              }).then((result) => {
                  if (result.value) {
                      Swal.showLoading()
                      $.ajax({
                        type:"POST",
                        url:"{{url('/admin/storeDraftPr')}}",
                        data:{
                          _token: "{{ csrf_token() }}",
                          inputTo:inputTo,
                          selectType:$("#selectType").val(),
                          inputEmail:$("#inputEmail").val(),
                          inputPhone:$("#inputPhone").val(),
                          // inputFax:$("#inputFax").val(),
                          inputAttention:$("#inputAttention").val(),
                          inputSubject:$("#inputSubject").val(),
                          inputAddress:$("#inputAddress").val(),
                          selectMethode:$("#selectMethode").val(),
                          selectPosition:$("#selectPosition").val(),
                          selectCategory:$("#selectCategory").val(),
                          cbCommit:commitValue,
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
                        success: function(result){
                          localStorage.setItem('isStoreSupplier',true)
                          Swal.close()
                          var x = document.getElementsByClassName("tab-add");
                          x[currentTab].classList.add("d-none");
                          currentTab = currentTab + n;
                          if (currentTab >= x.length) {
                            x[n].classList.add("d-none");
                            currentTab = 0;
                          }
                          addDraftPr(currentTab);
                          localStorage.setItem('no_pr',result)
                        }
                      })
                  }
                  
              })
            }else{
              var x = document.getElementsByClassName("tab-add");
              x[currentTab].classList.add("d-none");
              currentTab = currentTab + n;
              if (currentTab >= x.length) {
                x[n].classList.add("d-none");
                currentTab = 0;
              }
              addDraftPr(currentTab);
            }
          }else{
            var x = document.getElementsByClassName("tab-add");
            x[currentTab].classList.add("d-none");
            currentTab = currentTab + n;
            if (currentTab >= x.length) {
              x[n].classList.add("d-none");
              currentTab = 0;
            }
            addDraftPr(currentTab);
          }
        }
      }else if (currentTab == 1) {
        if (($(".tab-add")[1].children[1].style.display == 'inline' ) == true) {
          if (n == 1) {
            if ($("#inputNameProduct").val() == "") {
              $("#inputNameProduct").closest('.form-group').addClass('needs-validation ')
              $("#inputNameProduct").closest('input').next('span').show();
              $("#inputNameProduct").prev('.input-group-text').css("background-color","red");
            } else if ($("#inputDescProduct").val() == "") {
              $("#inputDescProduct").closest('.form-group').addClass('needs-validation ')
              $("#inputDescProduct").closest('textarea').next('span').show();
              $("#inputDescProduct").prev('.input-group-text').css("background-color","red");
            } else if ($("#inputQtyProduct").val() == "") {
              $("#inputQtyProduct").closest('.col-md-4').addClass('needs-validation ')
              $("#inputQtyProduct").closest('input').next('span').show();
              $("#inputQtyProduct").prev('.input-group-text').css("background-color","red");
            } else if ($("#selectTypeProduct").val() == "" || $("#selectTypeProduct").val() == null) {
              $("#selectTypeProduct").closest('.col-md-4').addClass('needs-validation ')
              $("#selectTypeProduct").closest('select').next('span').next('span').show();
              $("#selectTypeProduct").prev('.input-group-text').css("background-color","red");
            } else if ($("#inputPriceProduct").val() == "") {
              $("#inputPriceProduct").closest('.col-md-4').addClass('needs-validation ')
              $("#inputPriceProduct").closest('input').closest('.input-group').next('span').show();
              $("#inputPriceProduct").prev('.col-md-4').css("background-color","red");
            } else{
              if (localStorage.getItem('isEditProduct') == 'true') {
                $.ajax({
                  url: "{{url('/admin/updateProductPr')}}",
                  type: 'post',
                  data: {
                   _token:"{{ csrf_token() }}",
                   id_product:localStorage.getItem('id_product'),
                   selectBudgetType:$("#selectBudgetType").val(),
                   inputNameProduct:$("#inputNameProduct").val(),
                   inputDescProduct:$("#inputDescProduct").val().replaceAll("\n","<br>"),
                   inputQtyProduct:$("#inputQtyProduct").val(),
                   selectTypeProduct:$("#selectTypeProduct").val(),
                   inputPriceProduct:$("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''),
                   inputTotalPrice:$("#inputTotalPrice").val().replace(/\./g,'').replace(',','.').replace(' ',''),
                   inputSerialNumber:$("#inputSerialNumber").val(),
                   inputPartNumber:$("#inputPartNumber").val(),
                   inputGrandTotalProduct:$("#inputFinalPageTotalPrice").val(),
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
                    x[currentTab].classList.add("d-none");
                    currentTab = currentTab + n;
                    if (currentTab >= x.length) {
                      x[n].classList.add("d-none");
                      currentTab = 0;
                    }
                    addDraftPr(currentTab);
                    addTable(0,localStorage.getItem('status_tax'))
                    localStorage.setItem('isEditProduct',false)
                    localStorage.setItem('status_pr','draft')
                    $(".tabGroupInitiateAdd").show()
                    $(".tab-add")[1].children[1].style.display = 'none'
                    document.getElementsByClassName('tabGroupInitiateAdd')[0].childNodes[1].style.display = 'flex'
                    $("#inputNameProduct").val('')
                    $("#inputDescProduct").val('')
                    $("#inputPriceProduct").val('')
                    $("#inputQtyProduct").val('')
                    $("#inputSerialNumber").val('')
                    $("#inputPartNumber").val('')
                    $("#inputTotalPrice").val('')
                  }
                })
              }else{
                $.ajax({
                  url: "{{url('/admin/storeProductPr')}}",
                  type: 'post',
                  data: {
                   _token:"{{ csrf_token() }}",
                   no_pr:localStorage.getItem('no_pr'),
                   selectBudgetType:$("#selectBudgetType").val(),
                   inputFromBudgetType:$("#fromBudgetType").text(),
                   inputNameProduct:$("#inputNameProduct").val(),
                   inputDescProduct:$("#inputDescProduct").val().replaceAll("\n","<br>"),
                   inputSerialNumber:$("#inputSerialNumber").val(),
                   inputPartNumber:$("#inputPartNumber").val(),
                   inputQtyProduct:$("#inputQtyProduct").val(),
                   selectTypeProduct:$("#selectTypeProduct").val(),
                   inputPriceProduct:$("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''),
                   inputTotalPrice:$("#inputTotalPrice").val().replace(/\./g,'').replace(',','.').replace(' ',''),
                   inputGrandTotalProduct:$("#inputGrandTotalProduct").val(),
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
                  },success:function(){
                      Swal.close()
                      let x = document.getElementsByClassName("tab-add");
                      x[currentTab].classList.add("d-none");
                      currentTab = currentTab + n;
                      if (currentTab >= x.length) {
                        x[n].classList.add("d-none");
                        currentTab = 0;
                      }
                      addDraftPr(currentTab);
                      localStorage.setItem('status_pr','draft')
                      addTable(0,localStorage.getItem('status_tax'))
                      $("#inputNameProduct").val('')
                      $("#inputDescProduct").val('')
                      $("#inputPriceProduct").val('')
                      $("#inputQtyProduct").val('')
                      $("#inputSerialNumber").val('')
                      $("#inputPartNumber").val('')
                      $("#inputTotalPrice").val('')

                      $(".tabGroupInitiateAdd").show()
                      x[n].children[1].style.display = 'none'
                      document.getElementsByClassName('tabGroupInitiateAdd')[0].childNodes[1].style.display = 'flex' 
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
            x[currentTab].classList.add("d-none");
            currentTab = currentTab + n;
            if (currentTab >= x.length) {
              x[n].classList.add("d-none");
              currentTab = 0;
            }
            addDraftPr(currentTab);
          }else{
            var dataForm = new FormData();
            dataForm.append('csv_file',$('#uploadCsv').prop('files')[0]);
            dataForm.append('_token','{{ csrf_token() }}');
            dataForm.append('no_pr',localStorage.getItem('no_pr'));

            $.ajax({
              processData: false,
              contentType: false,
              url: "{{url('/admin/uploadCSV')}}",
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
                  reasonReject(result.text,"block","tabGroupInitiateAdd")
                }else{
                  var x = document.getElementsByClassName("tab-add");
                  x[currentTab].classList.add("d-none");
                  currentTab = currentTab + n;
                  if (currentTab >= x.length) {
                    x[n].classList.add("d-none");
                    currentTab = 0;
                  }
                  addDraftPr(currentTab);
                  addTable(0,localStorage.getItem('status_tax'))
                  localStorage.setItem('status_pr','draft')
                }
              }
            })
          }
        }       
      }else if (currentTab == 3) {
        if (n == 1) {
          if ($("#selectType").val() == 'IPR') {
            if ($("#inputPenawaranHarga").val() == "") {
              $("#inputPenawaranHarga").closest('.form-group').addClass('needs-validation ')
              $("#inputPenawaranHarga").closest('div').next('span').show();
              $("#inputPenawaranHarga").prev('.input-group-text').css("background-color","red"); 
            }else{
              let formData = new FormData();
              const filepenawaranHarga = $('#inputPenawaranHarga').prop('files')[0];
              if (isFilledPenawaranHarga) {
                formData.append('inputPenawaranHarga', filepenawaranHarga);
                isFilledPenawaranHarga = false
                // formData.append('nama_file_penawaranHarga', nama_file_penawaranHarga);
              } else {
                formData.append('inputPenawaranHarga', "-");
              }

              $(".tableDocPendukung").empty()


              if($('#tableDocPendukung .trDocPendukung').length != arrInputDocPendukung.length){
                if(arrInputDocPendukung.length != 0){
                  var lengthArrInputDocPendukung = $('#tableDocPendukung .trDocPendukung').length
                  arrInputDocPendukung = []
                  var i = 1;
                  $('#tableDocPendukung .trDocPendukung').each(function() {
                    if(i >= lengthArrInputDocPendukung){
                      var fileInput = $(this).find('#inputDocPendukung').val()
                      if (fileInput && fileInput !== '') { 
                        formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0])

                        arrInputDocPendukung.push({
                          nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
                          no_pr:localStorage.getItem('no_pr')
                        })
                      }
                    }
                    i++
                  });
                } else {
                  $('#tableDocPendukung .trDocPendukung').each(function() {
                    var fileInput = $(this).find('#inputDocPendukung').val()
                    if (fileInput && fileInput !== '') {
                      formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0])

                      arrInputDocPendukung.push({
                        nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
                        no_pr:localStorage.getItem('no_pr')
                      })
                    }                  
                  });
                }
              } else {
                var fileInput = $(this).find('#inputDocPendukung').val()
                if (fileInput && fileInput !== '') {
                  formData.append('inputDocPendukung[]',"-")
                }
              }
              

              isFilledDocPendukung = false

              formData.append('_token',"{{csrf_token()}}")
              formData.append('arrInputDocPendukung',JSON.stringify(arrInputDocPendukung))
              formData.append('no_pr',localStorage.getItem('no_pr'))

              $.ajax({
                url: "{{'/admin/storeDokumen'}}",
                type: 'post',
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
                      didOpen: () => {
                          Swal.showLoading()
                      }
                  })
                },
                success: function(data)
                {
                  Swal.close()
                  var x = document.getElementsByClassName("tab-add");
                  x[currentTab].classList.add("d-none");
                  currentTab = currentTab + n;
                  if (currentTab >= x.length) {
                    x[n].classList.add("d-none");
                    currentTab = 0;
                  }
                  addDraftPr(currentTab);
                }
              });           
            }         
          }else{
            if ($("#selectLeadId").val() == "-") {
              $("#selectLeadId").closest('.col-md-6').addClass('needs-validation ')
              $("#selectLeadId").closest('select').siblings('span.invalid-feedback').show();
              $("#selectLeadId").prev('.col-md-6').css("background-color","red");
            }else if ($("#selectPid").val() == "-") {
              $("#selectPid").closest('.col-md-6').addClass('needs-validation ')
              $("#selectPid").closest('select').next('span invalid-feedback').show();
              $("#selectPid").prev('.col-md-6').css("background-color","red");
            }else if ($("#inputSPK").val() == "") {
              $("#inputSPK").closest('.form-group').addClass('needs-validation ')
              $("#inputSPK").closest('div').next('span').show();
              $("#inputSPK").prev('.input-group-text').css("background-color","red");
            }else if ($("#inputSBE").val() == "") {
              $("#inputSBE").closest('.form-group').addClass('needs-validation ')
              $("#inputSBE").closest('div').next('span').show();
              $("#inputSBE").prev('.input-group-text').css("background-color","red");
            }else if ($("#inputQuoteSupplier").val() == "") {
              $("#inputQuoteSupplier").closest('.col-md-6').addClass('needs-validation ')
              $("#inputQuoteSupplier").closest('div').next('span').show();
              $("#inputQuoteSupplier").prev('.col-md-6').css("background-color","red");
            }else if ($("#inputQuoteNumber").val() == "-") {
              $("#inputQuoteNumber").closest('.col-md-6').addClass('needs-validation ')
              $("#inputQuoteNumber").closest('input').next('span').show();
              $("#inputQuoteNumber").prev('.col-md-6').css("background-color","red");
            }else{
              let formData = new FormData();
              arrInputDocPendukungEPR = []

              const fileSpk = $('#inputSPK').prop('files')[0];              
              if ($('#inputSPK').val() !="") {
                if(nama_file_spk == ""){
                  nama_file_spk = $('#inputSPK').val();
                  formData.append('inputSPK', fileSpk);
                } else if (nama_file_spk == $('#inputSPK').val()){
                  formData.append('inputSPK', "-");
                }
              }
              const fileSbe = $('#inputSBE').prop('files')[0];
              
              if ($('#inputSBE').val() !="") {
                if(nama_file_sbe == ""){
                  nama_file_sbe = $('#inputSBE').val();
                  formData.append('inputSBE', fileSbe);
                } else if (nama_file_sbe == $('#inputSBE').val()){
                  formData.append('inputSBE', "-");
                }
              }
              const fileQuoteSupplier = $('#inputQuoteSupplier').prop('files')[0];
              
              if ($('#inputQuoteSupplier').val() !="") {
                if(nama_file_quote_supplier == ""){
                  nama_file_quote_supplier = $('#inputQuoteSupplier').val();
                  formData.append('inputQuoteSupplier', fileQuoteSupplier);
                } else if (nama_file_quote_supplier == $('#inputQuoteSupplier').val()){
                  formData.append('inputQuoteSupplier', "-");
                }
              }

              // $('#tableDocPendukung .trDocPendukung').each(function() {
              //   var fileInput = $(this).find('#inputDocPendukung').val()
              //   if (fileInput && fileInput !== '') {
              //     formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0])

              //     arrInputDocPendukung.push({
              //       nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
              //       no_pr:localStorage.getItem('no_pr')
              //     })
              //   }                  
              // });
              $('#tableDocPendukung_epr .trDocPendukung').each(function() {
                var fileInput = $(this).find('#inputDocPendukung').val()
                if (fileInput && fileInput !== '') {
                  formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0])
                  formData.append('nameDocPendukung[]',$(this).find('#inputNameDocPendukung').val())
                  formData.append('no_pr',localStorage.getItem('no_pr'))
                  // arrInputDocPendukungEPR.push({
                  //   nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
                  //   no_pr:localStorage.getItem('no_pr')
                  // })
                }                  
              });

              formData.append('_token',"{{csrf_token()}}")
              formData.append('no_pr', localStorage.getItem('no_pr'))
              formData.append('selectLeadId', $("#selectLeadId").val())
              formData.append('selectPid', $("#selectPid").val())
              formData.append('inputPid',$("#projectIdInputNew").val())
              formData.append('selectQuoteNumber', $("#selectQuoteNumber").val())
              // formData.append('arrInputDocPendukung',JSON.stringify(arrInputDocPendukungEPR))

              $.ajax({
                  type:"POST",
                  url:"{{url('/admin/storeDokumen')}}",
                  processData: false,
                  contentType: false,
                  data:formData,
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
                    localStorage.setItem('isStoreSupplier',true)
                    Swal.close()
                    var x = document.getElementsByClassName("tab-add");
                    x[currentTab].classList.add("d-none");
                    currentTab = currentTab + n;
                    if (currentTab >= x.length) {
                      x[n].classList.add("d-none");
                      currentTab = 0;
                    }
                    addDraftPr(currentTab);
                  }
              })                        
            } 
          }
        }else{
          var x = document.getElementsByClassName("tab-add");
          x[currentTab].classList.add("d-none");
          currentTab = currentTab + n;
          if (currentTab >= x.length) {
            x[n].classList.add("d-none");
            currentTab = 0;
          }
          addDraftPr(currentTab);
        }
        
      }else if (currentTab == 4) {
        if (n == 1) {
          if (snowEditor.getText().trim() == "") {
            $("#snow-editor").next('span').show()
          }else{
            $("#snow-editor").next('span').attr('style','display:none!important')

            $.ajax({
              url: "{{'/admin/storeTermPayment'}}",
              type: 'post',
              data:{
                no_pr:localStorage.getItem('no_pr'),
                _token:"{{csrf_token()}}",
                textAreaTOP:snowEditor.root.innerHTML,
              },
              success: function(data)
              {
                var x = document.getElementsByClassName("tab-add");
                x[currentTab].classList.add("d-none");
                currentTab = currentTab + n;
                if (currentTab >= x.length) {
                  x[n].classList.add("d-none");
                  currentTab = 0;
                }
                addDraftPr(currentTab);
              }
            });
          }  
        }else{
          var x = document.getElementsByClassName("tab-add");
          x[currentTab].classList.add("d-none");
          currentTab = currentTab + n;
          if (currentTab >= x.length) {
            x[n].classList.add("d-none");
            currentTab = 0;
          }
          addDraftPr(currentTab);
        }  
      }else{
        $.ajax({
          type:"POST",
          url:"{{url('/admin/storeTax')}}",
            data:{
              _token:"{{csrf_token()}}",
              no_pr:localStorage.getItem('no_pr'),
              isRupiah:localStorage.getItem('isRupiah'),
              status_tax:localStorage.getItem('status_tax'),
              discount:localStorage.getItem('discount')=='NaN'?0:localStorage.getItem('discount'),
              tax_pb:localStorage.getItem('tax_pb')=='NaN'?0:localStorage.getItem('tax_pb'),
              service_charge:localStorage.getItem('service_charge')=='NaN'?0:localStorage.getItem('service_charge'),
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

              var x = document.getElementsByClassName("tab-add");
              x[currentTab].classList.add("d-none");
              currentTab = currentTab + n;
              if (currentTab >= x.length) {
                x[n].classList.add("d-none");
                currentTab = 0;
              }
              addDraftPr(currentTab);
              localStorage.setItem('status_pr','draft')
          }
        })
      }
      
    }
    
    localStorage.setItem('isEditProduct',false)
    function nextPrevAddAdmin(n,no_pr) {
      if (localStorage.getItem('isEditProduct') == 'true') {
        $.ajax({
          url: "{{url('/admin/updateProductPr')}}",
          type: 'post',
          data: {
           _token:"{{ csrf_token() }}",
           id_product:localStorage.getItem('id_product'),
           inputNameProduct:$("#inputNameProduct").val(),
           inputDescProduct:$("#inputDescProduct").val().replaceAll("\n","<br>"),
           inputQtyProduct:$("#inputQtyProduct").val(),
           selectTypeProduct:$("#selectTypeProduct").val(),
           inputPriceProduct:$("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''),
           inputTotalPrice:$("#inputTotalPrice").val().replace(/\./g,'').replace(',','.').replace(' ',''),
           inputSerialNumber:$("#inputSerialNumber").val(),
           inputPartNumber:$("#inputPartNumber").val(),
           inputGrandTotalProduct:$("#inputFinalPageTotalPrice").val(),
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
            localStorage.setItem('isEditProduct',false)
            cekByAdmin(currentTab,no_pr);
            $("#ModalDraftPr").modal("hide")
            Swal.close()
            currentTab = 1

            $("#inputNameProduct").val('')
            $("#inputDescProduct").val('')
            $("#inputPriceProduct").val('')
            $("#inputQtyProduct").val('')
            $("#inputSerialNumber").val('')
            $("#inputPartNumber").val('')
            $("#inputTotalPrice").val('')
          }
        })
      }

      if (n == -1) {
        $(".radioConfirm").prop('checked', false);
      }

      var x = document.getElementsByClassName("tab-cek");
      x[currentTab].classList.add("d-none");
      currentTab = currentTab + n;
      if (currentTab >= x.length) {
        x[n].classList.add("d-none");
        currentTab = 0;
      }
      cekByAdmin(currentTab,no_pr);
    }

    var incrementDoc = 0
    function addDocPendukung(value){
      $("#titleDoc_"+value).show()
      append = ""
        append = append + "<tr style='height:10px' class='trDocPendukung'>"
          append = append + "<td>"
            append = append + '<button type="button" class="bx bx-x btnRemoveAddDocPendukung" style="display:inline;color:red;background-color:transparent;border:none"></button>&nbsp'
            append = append + '<label for="inputDocPendukung" style="margin-bottom:0px">'
            append = append + '<span class="bx bx-cloud-upload" style="display:inline"></span>'
            append = append + '<input style="display:inline;font-family: inherit;width: 90px;" class="inputDocPendukung_'+ incrementDoc +' files" type="file" name="inputDocPendukung" id="inputDocPendukung" data-value="'+incrementDoc+'">'
            append = append + '</label>'
          append = append + "</td>"
          append = append + "<td>"
            append = append + '<input style="width:250px;margin-left:20px" data-value='+ incrementDoc +' class="form-control inputNameDocPendukung_'+ incrementDoc+'" name="inputNameDocPendukung" id="inputNameDocPendukung" placeholder="ex : faktur pajak"><span class="invalid-feedback" style="display:none!important;margin-left:20px">Please fill Document Name!</span>'
          append = append + "</td>"
        append = append + "</tr>"
      $("#tableDocPendukung_"+value).append(append) 
      incrementDoc++

      $("#btnAddDocPendukung_epr").prop("disabled",true)
      $("#btnAddDocPendukung_ipr").prop("disabled",true)

      $("#tableDocPendukung_"+ value +" .trDocPendukung").each(function(){
        
        $('.inputNameDocPendukung_'+$(this).find('#inputDocPendukung').data('value')).keydown(function(){
          
          if (this.value == "") {
            $("#btnAddDocPendukung_epr").prop("disabled",true)
            $("#btnAddDocPendukung_ipr").prop("disabled",true)
          }else{
            $("#btnAddDocPendukung_epr").prop("disabled",false)
            $("#btnAddDocPendukung_ipr").prop("disabled",false)
          }
        })   
      })   
    }

    $(document).on('click', '.btnRemoveAddDocPendukung', function() {
      $(this).closest("tr").remove();
      if($('#tableDocPendukung tr').length == 0){
        $("#titleDoc").attr('style','display:none!important')
      }
    });

    function createPR(status){
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
          text: "Submit Draft PR",
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
                  url:"{{url('/admin/storeLastStepDraftPr')}}",
                  data:{
                    _token:"{{csrf_token()}}",
                    no_pr:localStorage.getItem('no_pr'),
                    inputGrandTotalProduct:$("#inputFinalPageGrandPrice").val(),
                    status_revision:status,
                    isRupiah:localStorage.getItem("isRupiah"),
                  },
                  success: function(result){
                    Swal.fire({
                      title: 'Drafting PR Successs',
                      html: "<p style='text-align:center;'>Your PR draft will be verified by Admin/Procurement & Vendor Management soon, please wait for further progress</p>",
                      type: 'success',
                      confirmButtonText: 'Reload',
                    }).then((result) => {
                      localStorage.setItem('status_pr','') 
                      if (status == 'revision') {
                        location.replace("{{url('/admin/detailDraftPR')}}/"+ localStorage.getItem('no_pr'))
                      }else{
                        location.replace("{{url('admin/draftPR')}}")
                      }
                    })
                  }
                })
            }
        })
      }
    }

    function cekPRbyAdmin(){
    }

    function refreshTable(){
      addTable(0,localStorage.getItem('status_tax'))
    }

    $('#makeId').click(function(){
      $('#project_idNew').show()
      $('#project_id').val("").select2({
        dropdownParent:$("#ModalDraftPr .modal-body")
      }).trigger("change")

      $("#selectPid").closest('.form-group').removeClass('needs-validation ')
      $("#selectPid").closest('select').next('span').next("span").attr('style','display:none!important'); 
      $("#selectPid").prev('.col-md-6').css("background-color","red");
    })

    $('#removeNewId').click(function(){
      $('#project_idNew').hide('slow')
      $('#projectIdInputNew').val('')
    })
  </script>
@endsection