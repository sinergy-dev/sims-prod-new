@extends('template.main_sneat')
@section('tittle')
  Draft Purchase Request
@endsection
@section('pageName')
  Draft Purchase Request Detail
@endsection
@section('head_css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />

<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>

<link rel="preload" href="{{asset('assets/css/jquery.emailinput.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="{{asset('assets/css/bootstrap-timepicker.min.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="{{asset('assets/js/mentions/jquery.mentionsInput.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
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

  .icheckbox-blue:disabled{
    background: #3c8dbc !important;
  }
  .icheckbox-blue:disabled{
    background: #3c8dbc !important;
    border: 1px solid #d4d4d5;
  }

  .pull-right{
    float: right;
  }

  .avatar + .img-push {
    margin-left: 10px;
  }

  .input-group-mention{
    position: relative;
    display: flex;
    border-collapse: separate;
  }

  .input-group-mention > .mentions-input-box{
    width: 705px;
  }

  .pull-right{
    float: right;
  }

  #inputDiscountProduct,#inputPb1Product,#inputServiceChargeProduct,#inputDiscountFinal,#inputPb1Final,#inputServiceChargeFinal{
    border-top-left-radius: 0px;
    border-bottom-left-radius: 0px;
  }

  #inputDiscountNominal,#inputPb1Nominal,#inputServiceChargeNominal{
    border-top-right-radius: 0px;
    border-bottom-right-radius: 0px;
  }

  .swal2-container {
    z-index: 9999 !important; /* Set a higher z-index */
  }

  .form-group{
    margin-bottom: 15px;
  }
</style>
@endsection
@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <section class="content">
      <div class="row" id="showDetail">
      </div>
    </section>
  </div>

  <div class="modal fade" id="ModalSirkulasiPr" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Sirkulasi PR</h6>
          <button class="btn-close" data-bs-togggle="modal"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="" id="sirkulasi_pr" name="sirkulasi_pr">
            <div class="tab-sirkulasi">
              <div class="form-group">
                <label>There is no comparison, are you sure? Give a reason</label>
                <textarea style="resize: vertical;" class="form-control" id="reasonNoPembanding"></textarea>
                <span class="invalid-feedback" style="display:none;">Please fill the reason!</span>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="nextBtnSirkulasi" class="btn btn-sm btn-success">Sirkulasi</button>
              </div>
            </div>
            <div class="tab-sirkulasi" style="display:none">
              <label style="display:block;text-align: center;">Product</label>
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
                  </thead>
                  <tbody id="bodyPreviewSirkulasi">
                    
                  </tbody>
                </table>
                <div id="bottomPreviewSirkulasi">
                </div>
              </div>       
            </div>           
          </form>
        </div>
        <div class="modal-footer">
          <a target="_blank" class="btn btn-sm btn-warning" id="showPdf">Show PDF</a>
          <button type="button" data-bs-toggle="modal" data-bs-target="#ModalAddNote" class="btn btn-sm text-bg-primary">Notes</button>
          <button type="button" id="btnReject" class="btn btn-sm btn-danger">Reject</button>
          <button type="button" id="btnAccept" class="btn btn-sm btn-success">Accept</button>
        </div>  
      </div>
    </div>
  </div>

  <div class="modal fade" id="ModalRejectSirkulasi" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title">Sirkulasi PR - Reject</h6>
          </div>
          <div class="modal-body">
            <form method="POST" action="" id="rejectsirkulasi" name="rejectsirkulasi">
                <div class="form-group">
                  <label>Reason</label>
                  <textarea class="form-control" style="resize: vertical;" onkeyup="fillInput('reason_reject')"  id="reasonRejectSirkular" name="reasonRejectSirkular"></textarea>
                  <span class="invalid-feedback" style="display:none;">Please fill Reason!</span>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm text-bg-primary" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" onclick="rejectSirkulasi()" class="btn btn-sm btn-danger">Reject</button>
                </div>           
            </form>
          </div>
        </div>
      </div>
  </div>

  <div class="modal fade" id="ModalAcceptSirkulasi" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title">Sirkulasi PR - Accept</h6>
          </div>
          <div class="modal-body">
            <form method="POST" action="" id="acceptsirkulasi" name="acceptsirkulasi">
                <div class="form-group">
                  <label>Pilih TTD Digital</label>
                  <br>
                  <input type="radio" name="selectTTD" id="selectTTD">
                  <img id="TTD" src="https://1.bp.blogspot.com/-cTTuRO8QNq0/UOYc_tD75bI/AAAAAAAAAx4/wg-S154-jUA/s1600/tanda-tangan.jpg" style="width:100px;height:100px">
                </div>
                <div class="modal-footer">
                  <button type="button" id="btnUploadNewTTD" class="btn btn-sm btn-success">Upload New</button>
                  <button type="button" class="btn btn-sm text-bg-primary" onclick="submitTTD('ready')">Submit</button>
                </div>          
            </form>
          </div>
        </div>
      </div>
  </div>

  <div class="modal fade" id="ModalUploadNewTTD" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title">Sirkulasi PR - Accept</h6>
          </div>
          <div class="modal-body">
            <form method="POST" action="" id="acceptsirkulasi" name="acceptsirkulasi">
                <div class="form-group">
                  <label>Anda belum memiliki TTD digital, Silahkan input</label>
                  <br>
                  <input type="file" name="inputTTD" id="inputTTD" class="form-control">
                </div>
                <div class="modal-footer">
                  <button type="button" onclick="submitTTD('notReady')" class="btn btn-sm btn-success">Upload</button>
                </div>          
            </form>
          </div>
        </div>
      </div>
  </div>

  <div class="modal fade" id="ModalAddNote" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title">Notes</h6>
          </div>
          <div class="modal-body">
            <form method="POST" action="" id="notes" name="notes">
                <div class="form-group">
                  <textarea id="inputNotes" style="resize:none;height: 200px;" placeholder="@ mention member"></textarea>
                </div>          
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="btnSubmitNotes()" class="btn btn-sm btn-success">Saved</button>
            <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-secondary">Cancel</button>
          </div>
        </div>
      </div>
  </div>

  <div class="modal fade" id="ModalDraftPr" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Information Supplier</h6>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="" id="modal_pr" name="modal_pr">
            @csrf
            <div class="tab-add" style="display:none;">
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
                <span class="invalid-feedback" style="display:none;">Please fill To!</span>
              </div>      

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">Type*</label>
                    <select type="text" class="custom-form-control-select w-100" name="type" placeholder="ex. Internal Purchase Request" onchange="fillInput('selectType')" id="selectType" required >
                        <option selected value="">Select Type</option>
                        <option value="IPR">IPR (Internal Purchase Request)</option>
                        <option value="EPR">EPR (Eksternal Purchase Request)</option>
                    </select>
                    <span class="invalid-feedback" style="display:none;">Please fill Type!</span>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">Email*</label>
                    <input autocomplete="off" type="" class="form-control" placeholder="ex. absolut588@gmail.com" id="inputEmail" name="inputEmail" onkeyup="fillInput('email')">
                    <span class="invalid-feedback" style="display:none;">Please fill Email!</span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="">Category</label>
                <select type="text" class="custom-form-control-select w-100" name="selectCategory" id="selectCategory" style="width: 100%" onchange="fillInput('selectCategory')">
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
                <span class="invalid-feedback" style="display:none;">Please fill Category!</span>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">Phone*</label>
                    <input autocomplete="off" class="form-control" id="inputPhone" type="" name="" placeholder="ex. 999-999-999-999" onkeyup="fillInput('phone')">
                    <span class="invalid-feedback" style="display:none;">Please fill Phone!</span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">Attention*</label>
                    <input autocomplete="off" type="text" class="form-control" placeholder="ex. Marsono" name="inputAttention" id="inputAttention" onkeyup="fillInput('attention')">
                    <span class="invalid-feedback" style="display:none;">Please fill Attention!</span>
                  </div> 
                  <!-- <div class="form-group">
                    <label for="">Fax</label>
                    <input type="" id="inputFax" class="form-control" name="inputFax">
                  </div> -->
                </div>
              </div>

              <div class="form-group">
                <label for="">Subject*</label>
                <input autocomplete="off" type="text" class="form-control" placeholder="ex. Pembelian laptop MSI Modern 14 (Sdri. Faiqoh, Sdr. Oktavian, Sdr. Subchana)" name="inputSubject" id="inputSubject" onkeyup="fillInput('subject')">
                <span class="invalid-feedback" style="display:none;">Please fill Subject!</span>
              </div>

              <div class="form-group">
                <label for="">Address*</label>
                <textarea autocomplete="off" class="form-control" id="inputAddress" name="inputAddress" placeholder="ex. Plaza Pinangsia Lt. 1 No. 7-8 Jl. Pinangsia Raya no.1" onkeyup="fillInput('address')" style="resize: vertical;"></textarea>
                <span class="invalid-feedback" style="display:none;">Please fill Address!</span>
              </div>

              <div class="form-group">
                <label for="">Request Methode*</label>
                <select type="text" class="custom-form-control-select w-100" placeholder="ex. Purchase Order" name="type" id="selectMethode" required >
                    <option selected value="">Select Methode</option>
                    <option value="purchase_order">Purchase Order</option>
                    <option value="payment">Payment</option>
                    <option value="reimbursement">Reimbursement</option>
                </select>
                <span class="invalid-feedback" style="display:none;">Please fill Type!</span>
              </div>

              <div class="form-group" id="divNotePembanding">
                <label for="">Comparison Note*</label>
                <textarea autocomplete="off" class="form-control" id="note_pembanding" name="note_pembanding"></textarea>
                <span class="invalid-feedback" style="display:none;">Please fill Comparison Note!</span>
              </div>
            </div>
            <div class="tab-add" style="display:none">
              <div class="tabGroupInitiateAdd">
                <div class="form-group" style="display:flex">
                  <button class="btn btn-sm text-bg-primary" id="btnInitiateAddProduct" type="button" style="margin:0 auto;"><i class="bx bx-plus"></i>&nbspAdd Product</button>
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
                    <i class="bx bx-cloud-upload" style="margin-left:5px"></i>
                    <input autocomplete="off" id="uploadCsv" class="hidden" type="file" name="uploadCsv" style="margin-top: 3px;width: 80px;display: inline;">
                    <label for="uploadCsv">Upload CSV</label>
                    <i class="bx bx-x hidden" onclick="cancelUploadCsv()" style="display:inline;color: red;"></i>
                    <!-- <span class="invalid-feedback" style="display:none;">Please Upload File or Add Product!</span> -->
                  </div>
                </div>         
                <div style="display: flex;">
                  <span style="margin: 0 auto;">You can get format of CSV from this <a href="{{url('draft_pr/Import_product_sample.csv')}}" style="cursor:pointer;">link</a></span>
                </div>
                <div style="display: flex;">
                  <span style="margin: 0 auto;">And make sure, the change of template only at row 2, any change on row 1 (header) will be reject</span>
                </div>
              </div>
              <div class="tabGroupModal" style="display:none">
                <div class="form-group">
                  <label>Product*</label>
                  <input autocomplete="off" type="text" name="" class="form-control" id="inputNameProduct" placeholder="ex. Laptop MSI Modern 14" onkeyup="fillInput('name_product')">
                  <span class="invalid-feedback" style="display:none;">Please fill Name Product!</span>
                </div>
                <div class="form-group">
                  <label>Description*</label> 
                  <textarea autocomplete="off" onkeyup="fillInput('desc_product')" style="resize:vertical;height:150px" id="inputDescProduct" placeholder='ex. Laptop mSI Modern 14, Processor AMD Rayzen 7 5700, Memory 16GB, SSD 512 Gb, Screen 14", VGA vega 8, Windows 11 Home' name="inputDescProduct" class="form-control"></textarea>
                  <span class="invalid-feedback" style="display:none;">Please fill Description!</span>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6"> 
                      <label>Serial Number</label>
                      <input autocomplete="off" type="text" name="" class="form-control" id="inputSerialNumber">
                    </div>
                    <div class="col-md-6"> 
                      <label>Part Number</label>
                      <input autocomplete="off" type="text" name="" class="form-control" id="inputPartNumber">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-2"> 
                      <label>Qty*</label>
                      <input autocomplete="off" type="number" name="" class="form-control" id="inputQtyProduct" placeholder="ex. 5" onkeyup="fillInput('qty_product')">
                      <span class="invalid-feedback" style="display:none;">Please fill Qty!</span>
                    </div>
                    <div class="col-md-4"> 
                      <label>Type*</label>
                      <i class="bx bx-warning" title="If type is undefined, Please contact developer team!" style="display:inline"></i>
                      <select style="width:100%;display:inline;" class="form-control" id="selectTypeProduct" placeholder="ex. Unit" onchange="fillInput('type_product')">
                        <option></option>                  
                      </select>
                      <span class="invalid-feedback" style="display:none;">Please fill Unit!</span>
                    </div>
                    <div class="col-md-6"> 
                      <label>Price*</label>
                      <div class="input-group">
                        <div class="input-group-text">
                        Rp.
                        </div>
                        <input autocomplete="off" type="text" name="" class="form-control money" id="inputPriceProduct" placeholder="ex. 500,00.00" onkeyup="fillInput('price_product')">     
                        <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        </button>       
                        <ul class="dropdown-menu">       
                          <li><a class="dropdown-item" onclick="changeCurreny('usd')">USD($)</a></li>
                          <li><a class="dropdown-item" onclick="changeCurreny('dollar')">IDR(RP)</a></li>
                        </ul>
                      </div>
                      <span class="invalid-feedback" style="display:none;">Please fill Price!</span>
                    </div>
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
            <div class="tab-add" style="display:none">
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
              <div class="form-group" style="margin-top:10px;display: flex;">
                <button class="btn btn-sm text-bg-primary" style="margin: 0 auto;" type="button" id="addProduct"><i class="bx bx-plus"></i>&nbsp Add product</button>
              </div>
            </div>
            <div class="tab-add" style="display:none">
              <div id="formForPrExternal" style="display:none">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>Lead Register*</label>
                      <select id="selectLeadId" style="width:100%" class="select2 form-control" onchange="fillInput('selectLeadId')">
                        <option></option>
                      </select>
                      <span class="invalid-feedback" style="display:none;">Please fill Lead Register!</span>
                    </div>
                    <div class="col-md-6">
                      <label>PID*</label>
                      <select id="selectPid" style="width: 100%;" class="select2 form-control" onchange="fillInput('selectPID')">
                        <option></option>
                      </select>
                      <span class="invalid-feedback" style="display:none;">Please fill PID!</span>
                      <span id="makeId" style="cursor: pointer;">other?</span>
                      <div class="form-group" id="project_idNew" style="display: none;">
                        <div class="input-group">
                          <input autocomplete="off" type="text" class="form-control pull-left col-md-8" placeholder="input Project ID" name="project_idInputNew" id="projectIdInputNew">
                          <span class="input-group-text" style="cursor: pointer;" id="removeNewId"><i class="glyphicon glyphicon-remove"></i></span>
                        </div>
                      </div> 
                    </div>
                  </div>
                </div>                
                
                <div class="form-group">
                  <label>SPK/Kontrak*</label>
                  <div style="border: 1px solid #dee2e6 !important;color: #337ab7;height: 34px;padding: 6px 12px;background-color: #eee;">
                    <input autocomplete="off" type="file" name="inputSPK" id="inputSPK" disabled onkeyup="fillInput('spk')" style="margin-top: 4px;">
                  </div>
                  <span class="invalid-feedback" style="display:none;">Please fill SPK/Kontrak!</span>
                  <span style="display:none;" id="span_link_drive_spk"><a id="link_spk" target="_blank"><i class="bx bx-link"></i>&nbspLink drive</a></span>
                </div>

                <div class="form-group">
                  <label>SBE*</label>
                  <div style="border: 1px solid #dee2e6 !important;color: #337ab7;height: 34px;padding: 6px 12px;background-color: #eee;">
                    <input autocomplete="off" type="file" name="inputSBE" id="inputSBE" disabled onkeyup="fillInput('sbe')" style="margin-top: 4px;">
                  </div>
                  <span class="invalid-feedback" style="display:none;">Please fill SBE!</span>
                  <span style="display:none;" id="span_link_drive_sbe"><a id="link_sbe" target="_blank"><i class="bx bx-link"></i>&nbspLink drive</a></span>
                </div>
                
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>Quote Supplier*</label>
                      <div style="border: 1px solid #dee2e6 !important;color: #337ab7;height: 34px;padding-bottom: 5px;padding-top: 3px;padding-left: 10px;">
                        <span class="bx bx-cloud-upload" style="display:inline;"></span>
                        <input autocomplete="off" type="file" name="inputQuoteSupplier" id="inputQuoteSupplier" onkeyup="fillInput('quoteSupplier')" style="margin-top: 4px;display:inline;text-overflow: ellipsis;white-space:nowrap;overflow:hidden;width: 200px;">
                      </div>
                      <span class="invalid-feedback" style="display:none;">Please fill Quote Supplier!</span>
                      <span style="display:none;" id="span_link_drive_quoteSup"><a id="link_quoteSup" target="_blank"><i class="bx bx-link"></i>&nbspLink drive</a></span>
                    </div>
                    <div class="col-md-6">
                      <label>Quote Number*</label>
                      <select name="selectQuoteNumber" class="select2 form-control" id="selectQuoteNumber" >
                        <option></option>
                      </select>
                      <span class="invalid-feedback" style="display:none;">Please fill Quote Number!</span>
                    </div>
                  </div>
                </div> 

                <div class="form-group">
                  <div id="docPendukungContainer" class="table-responsive">
                    <label id="titleDoc_epr" style="display:none;">Lampiran Dokumen Lainnya</label>
                    <table id="tableDocPendukung_epr" class="border-collapse:collapse" style="border-collapse: separate;border-spacing: 0 15px;">
                      
                    </table>
                  </div>
                  <div class="form-group" style="display:flex;margin-top: 10px;">
                    <a type="button" style="margin:0 auto" id="btnAddDocPendukung" class="btn btn-sm text-bg-primary" onclick="addDocPendukung('epr')"><i class="bx bx-plus"></i>&nbsp Dokumen Pendukung</a>
                  </div>
                </div>   
              </div>
                
              <div id="formForPrInternal" style="display:none;">
                <div class="form-group">
                  <label>Lampiran Penawaran Harga*</label>
                  <div style="border: 1px solid #dee2e6 !important;padding: 5px;color: #337ab7;">
                    <label for="inputPenawaranHarga" style="margin-bottom:0px">
                      <span class="bx bx-cloud-upload" style="display:inline"></span>
                      <input autocomplete="off" style="display: inline;" type="file" name="inputPenawaranHarga" class="files" id="inputPenawaranHarga">
                    </label>
                  </div>
                  <span class="invalid-feedback" style="display:none;">Please fill Penawaran Harga!</span>
                  <span style="display:none;" id="span_link_drive"><a id="link_penawaran_harga" target="_blank"><i class="bx bx-link"></i>&nbspLink drive</a></span>
                </div>
                <div id="docPendukungContainer" class="table-responsive">
                  <label id="titleDoc_ipr" style="display:none;">Lampiran Dokumen Pendukung</label>
                  <table id="tableDocPendukung_ipr" class="border-collapse:collapse" style="border-collapse: separate;border-spacing: 0 15px;">
                    
                  </table>
                </div>
                <div class="form-group" style="display:flex;margin-top: 10px;">
                  <a type="button" style="margin:0 auto" id="btnAddDocPendukung" class="btn btn-sm text-bg-primary" onclick="addDocPendukung('ipr')"><i class="bx bx-plus"></i>&nbsp Dokumen Pendukung</a>
                </div>
              </div>
            </div>   
            <div class="tab-add" style="display:none">
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
                <span class="invalid-feedback" style="display:none;">Please fill Top of Payment!</span>
               <!--  <form> 
                  <textarea onkeyup="fillInput('textArea_TOP')" class="textarea" id="textAreaTOP" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221);" placeholder="ex. terms & Condition"></textarea>
                </form> -->
              </div>
            </div>  
            <div class="tab-add" style="display:none">
              <div class="row">
                <div class="col-md-12" id="headerPreviewFinal">
                  
                </div>
              </div>
              <div class="row">
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
              <div class="row">
                <div class="col-md-12" id="bottomPreviewFinal">
                  
                </div>
              </div>              
            </div>     
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" id="prevBtnAdd">Back</button>
          <button type="button" class="btn btn-sm text-bg-primary" id="nextBtnAdd">Next</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scriptImport')
<script src="{{asset('assets/vendor/libs/quill/katex.js')}}"></script>
<script src="{{asset('assets/vendor/libs/quill/quill.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js' type='text/javascript'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('assets/js/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.emailinput.min.js')}}"></script>
<script src="{{asset('assets/js/roman.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.mask.js')}}"></script>
<script src="{{asset('assets/js/mentions/jquery.mentionsInput.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/jquery.events.input.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/jquery.elastic.js')}}" type="text/javascript"></script>
@endsection
@section('script')
<script type="text/javascript">
  // $(".money").mask('000,000,000,000,000', {reverse: true})
  $('.money').mask('#.##0,00', {reverse: true})
  let snowEditor;

  window.onload = function(){
    localStorage.setItem("arrFilterBack", localStorage.getItem("arrFilter"))
  }

  $.ajax({
    type:"GET",
    url:"{{url('/admin/getPerson')}}",
    data:{
      no_pr:window.location.href.split("/")[5]
    },
    success: function(result){
      var i = 0
      const results = result.map(item => {
          const container = {};

          container.id = i++;
          container.name = item.name;
          if (item.avatar == null) {
            container.avatar = '{{ asset("image/place_profile_3.png")}}';
          }else{
            container.avatar = item.avatar;
          }
          container.type = item.email;

          return container;
      })

      $('#inputNotes').mentionsInput({
        onDataRequest:function (mode, query, callback) {
          var data = results

          data = _.filter(data, function(item) { return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1 });

          callback.call(this, data);

          if ($('html').hasClass('dark-style')) {
            // do something if it has the class
            console.log("betul")
            $(".mentions").attr('style','display:none!important')
          }
        }
      });
    }
  })  

  var formatter = new Intl.NumberFormat(['ban', 'id']);

  var accesable = @json($feature_item);
  console.log(accesable)

  isPembanding = localStorage.setItem('isPembanding',false)
  isLastStorePembanding = localStorage.getItem('isLastStorePembanding')

  $(document).ready(function(){    
    // Pace.restart()
    // Pace.track(function() {
    if (isLastStorePembanding == 'true') {
      pembanding()
    }else{
      showDetail() 
      loadDataSubmitted()   
    } 
    // })

    $('input[class="files"]').change(function(){
      
      var f=this.files[0]
      var filePath = f;
   
      // Allowing file type
      var allowedExtensions =
      /(\.jpg|\.jpeg|\.png|\.pdf)$/i;

      var ErrorText = []
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
      var arrayExtensions = ["jpg" , "jpeg", "png", "pdf"];

      if (arrayExtensions.lastIndexOf(ext) == -1) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Invalid file type, just allow png/jpg/pdf file',
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
        localStorage.setItem('isProductInline',false)
        $("#uploadCsv").next('label').attr('style','display:none!important')
        $("input[type='file'][name='uploadCsv']").removeClass('hidden')
        $("input[type='file'][name='uploadCsv']").prev('i').attr('style','display:none!important')
        $("#uploadCsv").next('label').next('i').removeClass('hidden') 
        $("#btnInitiateAddProduct").prop("disabled",true)
      }
    })

    if (window.location.href.split("?")[1] == "hide") {
      $("#btnSirkulasi").attr('style','display:none!important')
      $("#btnFinalize").attr('style','display:none!important')
      $("#btnRevision").attr('style','display:none!important')
      $("#btnAddNotes").attr('style','display:none!important')
      $("#BtnBack").attr('style','display:none!important')
    }
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

  let arrReason = []
  function reasonReject(item,display,nameClass,typealert=""){
    $(".divReasonRejectRevision").remove()
    arrReason.push(item)
    

    var textTitle = ""
    var className = ""

    if (nameClass == 'tabGroup' || nameClass == 'tabGroupModal') {
      textTitle = "Note PR!"
      className = "tabGroup"
    }else{
      textTitle = "Warning!"
      className = nameClass
    }

    var append = ""
    
    append = append + '<div class="alert alert-danger divReasonRejectRevision" style="display:none">'
      append = append + '<h6><i class="icon bx bxs-error-alt"></i>'+ textTitle +'</h6>'
      $.each(arrReason,function(item,value){
        append = append + '<p class="reason_reject_revision">'+ value.replaceAll("\n","<br>")+'</p>'
      })
    append = append + '</div>'

    $("." + nameClass).prepend(append)
    

    if (display == "block") {
      $(".divReasonRejectRevision").show()
    }
  }

  function showDetail(){
    append = ""
    append = append + '<div class="col-md-9 tabGroup">'
      append = append + '<div class="row">'
        append = append + '<div class="col-md-12">'
          append = append + '<div class="card mb-4">'
            append = append + '<div class="card-body">'
              append = append + '<div class="row">'
                append = append + '<div class="col-md-12">'
                  append = append + '<span><b>Action</b></span><br>'
                   append = append + '<button onclick="pembanding()" class="btn btn-sm text-bg-primary" id="btnPembanding" style="margin-right:5px">Comparison</button>'
                      append = append + '<button disabled class="btn btn-sm btn-warning" id="btnSirkulasi" style="margin-right:5px" onclick="sirkulasi(0)">Circular</button>'
                  append = append + '<button class="btn btn-sm btn-success" style="margin-right:5px" id="btnFinalize" disabled>Finalize</button>'
                  append = append + '<button class="btn btn-sm btn-danger" id="btnRevision" style="display:none" disabled>Revision</button>'
                  append = append + '<a id="btnShowPdf" target="_blank" href="{{url("/admin/getPdfPRFromLink")}}/?no_pr='+ window.location.href.split("/")[5] +'" class="btn btn-sm btn-warning pull-right">Show PDF</a>'
                  append = append + '<button id="btnAddNotes" class="btn btn-sm text-bg-primary pull-right" style="margin-right:5px">Notes</button>'
                append = append + '</div>'
              append = append + '</div>'
              append = append + '<hr>'
              append = append + '<div class="row">'
                append = append + '<div class="col-md-12">'
                  append = append + '<div id="headerPreview">'
                  append = append + '</div>'
                  append = append + '<div class="card mb-4" style="margin-top:10px">'
                    append = append + '<div class="card-header" style="display:block ruby"><h6 class="card-title" style="margin-top:15px">Products</h6><div class="card-tools pull-right"><button type="button" class="btn btn-sm btn-card-tool btnProductCollapse mt-1"><span class="bx bx-lg bx-chevron-down"></span></button></div></div>'
                    append = append + '<div class="card-body" id="bodyCollapseProduct">'
                      append = append + '<div class="table-responsive">'
                        append = append + '<table class="table no-wrap">'
                          append = append + '<thead>'
                            append = append + '<th>No</th>'
                            append = append + '<th width="20%">Product</th>'
                            append = append + '<th width="40%">Description</th>'
                            append = append + '<th width="5%">Qty</th>'
                            append = append + '<th width="5%">Type</th>'
                            append = append + '<th width="10%">Price</th>'
                            append = append + '<th width="10%">Total Price</th>'
                          append = append + '</thead>'
                          append = append + '<tbody id="bodyPreview">'
                          append = append + '</tbody>'
                        append = append + '</table>'
                      append = append + '</div>'

                      append = append + '<div id="bottomPreviewProduct">'
                      append = append + '</div>'
                    append = append + '</div>'
                  append = append + '</div>'
                  append = append + '<div id="bottomPreview">'
                  append = append + '</div>'
                append = append + '</div>              '
              append = append + '</div>'
            append = append + '</div>'
          append = append + '</div>'
        append = append + '</div>'

        append = append + '<div class="col-md-12" id="showResolve">'
        append = append + '</div>'
      append = append + '</div>'
    append = append + '</div>'
    append = append + '<div class="col-md-3">'
    append = append + '<div id="scrollingDiv" style="overflow-y:scroll;height:1000px;padding:10px">'
      append = append + '<ul class="timeline">'
        $.ajax({
          type: "GET",
          url: "{{url('/admin/getActivity')}}",
          data: {
            no_pr: window.location.href.split("/")[5],
          },
          success: function(result) {
            
            //for user privilege

            if (result[2].isCircular == 'True') {   
              if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Procurement & Vendor Management')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Internal Chain Management')->exists()}}") {
                $("#btnSirkulasi").prop('disabled',true)
                if ((window.location.href.split("?")[1] == "hide") == false){
                  $("#btnRevision").show().prop('disabled',false).click(function(){
                    $(".modal-title").text("Sirkulasi PR - Revision")
                    $("#ModalRejectSirkulasi").modal("show")
                  })
                }
              }
            }else{
              $.each(result[0],function(key,value){
                $.each(value,function(keys,values){
                  if (values.status == 'CANCEL') {
                    $("#btnPembanding").attr("disabled",true)
                  }
                })
              })
            } 
            
            $.each(result[0],function(value,item){
              loadActivity(value,item)
            })
          }
        })
      append = append + '</ul>'
    append = append + '</div>'
    append = append + '</div>'

    $("#showDetail").append(append)

    var no = 0
    var appendResolve = ''
    $.ajax({
      url:"{{url('/admin/getNotes')}}",
      type:"GET",
      data:{
        no_pr:window.location.href.split("/")[5]
      },
      success:function(result){
        $("#showResolve").empty("")
        $.each(result,function(item,value){
          no++

          if (value.image != '' && value.image != '-' && value.image != null) {
            image = value.image
          }else{
            image = "place_profile_3.png"
          }

          let span = ''
          let disableResolve = ''
          let disableReply = ''
          
          if (value.resolve == 'True') {
            span = '<span class="pull-right badge bg-green">Resolved</span>'
            disableResolve = 'disabled'
            disableReply = 'disabled'
          }else{
            if ({{Auth::User()->nik}} != value.issuance) {
              disableResolve
              disableReply
            }else{
              disableResolve = 'disabled'
              disableReply
            }
            span = '<span class="badge text-bg-secondary">Progress</span>'
            ////////////
          }
          const cals = moment(value.date_add)
          .calendar(null, {
            lastDay: '[Yesterday]',
            sameDay: '[Today]',
            nextDay: '[Tomorrow]',
            lastWeek: '[last] dddd',
            nextWeek: 'dddd',
            sameElse: 'L'
          })

          appendResolve = appendResolve + '<div class="accordion" id="accordionExample'+item+'">'
            appendResolve = appendResolve + '<div class="accordion-item active">'
              appendResolve = appendResolve + '<h2 class="accordion-header">'
                appendResolve = appendResolve + '<button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordion'+ item +'" aria-expanded="true" aria-controls="accordion'+ item+'">'
                  
                  appendResolve = appendResolve + '<a href="javascript:void(0);" class="list-group-item list-group-item-action d-flex justify-content-between">'
                  appendResolve = appendResolve + '<div class="li-wrapper d-flex justify-content-start align-items-center">'
                    appendResolve = appendResolve + '<div class="avatar me-3">'
                      appendResolve = appendResolve + '<img class="rounded-circle" src="{{ asset("image/")}}/'+ image +'" alt="User Image">'
                    appendResolve = appendResolve + '</div>'
                    appendResolve = appendResolve + '<div class="list-content">'
                      appendResolve = appendResolve + '<h6 class="mb-0 username">'+ value.operator +'</h6>'
                      appendResolve = appendResolve + '<small>'+span +'</small><small class="text-body-secondary description">Note #'+ no +' - '+ value.no_pr + ' - ' +  cals + '&nbspat&nbsp' + moment(value.date_add).format('hh:mm A') +'</small>' 
                    appendResolve = appendResolve + '</div>'
                  appendResolve = appendResolve + '</div>'
                appendResolve = appendResolve + '</a>'
                appendResolve = appendResolve + '</button>'
                
              appendResolve = appendResolve + '</h2>'
              appendResolve = appendResolve + '<div id="accordion'+ item +'" class="accordion-collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample'+ item +'">'
                appendResolve = appendResolve + '<div class="accordion-body">'
                  //content
                  appendResolve = appendResolve + '<p style="display:inline">'+ value.notes +'</p><br>'
                  appendResolve = appendResolve + '<button type="button" value="'+ value.id +'" id="btnResolve" onclick="btnResolve('+ value.id +')" '+ disableResolve +' class="pull-right btn btn-success btn-xs btnResolve" style="margin-top:10px"><i class="bx bx-check"></i> Resolve</button>'
                  appendResolve = appendResolve + '<button type="button" id="btnReply" onclick="btnShowReply('+ value.id_draft_pr +','+ value.id +','+"'"+ value.operator+"'" +')" data-id="'+ value.id_draft_pr +'" data-value="'+ value.id +'" '+ disableReply +' class="btn btn-sm btn-secondary btn-xs" style="margin-top:10px"><i class="bx bx-reply"></i> Reply</button>'
                  appendResolve = appendResolve + '</div>'
                    if (value.reply.length > 0) {
                      style = 'display:block'
                    }else{
                      style = 'display:none'
                    }
                    appendResolve = appendResolve + '<div class="card-footer card-comments" style="'+ style +'">'
                    $.each(value.reply,function(items,values){
                      if (values.gambar != '' && values.gambar != '-' && values.gambar != null) {
                        gambar = values.gambar
                      }else{
                        gambar = 'place_profile_3.png'
                      }
                      appendResolve = appendResolve + '<div class="accordion-body">'
                        appendResolve += '<div class="d-flex">'
                          appendResolve = appendResolve + '<div class="avatar">'
                          appendResolve = appendResolve + '<img class="rounded-circle" src="{{ asset("image")}}/'+ gambar +'" alt="User Image">'
                          appendResolve = appendResolve + '</div>'
                          appendResolve = appendResolve + '<div class="comment-text" style="padding: 5px;width: 100%;">'
                          const cal = moment(values.date_add)
                              .calendar(null, {
                                  lastDay: '[Yesterday]',
                                  sameDay: '[Today]',
                                  nextDay: '[Tomorrow]',
                                  lastWeek: '[last] dddd',
                                  nextWeek: 'dddd',
                                  sameElse: 'L'
                              })
                          appendResolve = appendResolve + '<span class="username">'+ values.operator +'<span class="pull-right">'+ cal + '&nbspat&nbsp' + moment(values.date_add).format('hh:mm A') +'</span>'
                          appendResolve = appendResolve + '</span><p>'+ values.reply +'</p>'
                          appendResolve = appendResolve + '</div>'
                        appendResolve += '</div>'

                        appendResolve = appendResolve + '<button class="btn btn-sm btn-xs btn-secondary" id="btnReplyBottom" onclick="btnShowReply('+ value.id_draft_pr +','+ value.id +','+"'"+ values.operator+"'" +')" data-id="'+ value.id_draft_pr +'" data-value="'+ value.id +'" '+ disableReply +'><i class="bx bx-reply"></i>&nbspReply</button>'
                        appendResolve = appendResolve + " "
                      appendResolve = appendResolve + '</div>'
                    })            
                    appendResolve = appendResolve + '</div>'

                    //footer
                    if (value.resolve != 'True') {
                      appendResolve = appendResolve + '<div class="accordion-body" id="showFooter" data-value="'+ value.id +'" style="display:flex">'
                      appendResolve = appendResolve + '</div>'
                    }
                  //
                appendResolve = appendResolve + '</div>'
              appendResolve = appendResolve + '</div>'
            appendResolve = appendResolve + '</div>'
          appendResolve = appendResolve + '</div>'
          

          // appendResolve = appendResolve + '<div class="card card-widget">'
          // appendResolve = appendResolve + '<div class="card-header with-border">'
          

          // appendResolve = appendResolve + '<div class="collapse" data-value="'+ item +'">'
          // appendResolve = appendResolve + '<div class="card-body" style="">'
          // appendResolve = appendResolve + '<p style="display:inline">'+ value.notes +'</p><br>'
          // appendResolve = appendResolve + '<button type="button" value="'+ value.id +'" id="btnResolve" onclick="btnResolve('+ value.id +')" '+ disableResolve +' class="pull-right btn btn-success btn-xs btnResolve" style="margin-top:10px"><i class="bx bx-check"></i> Resolve</button>'
          // appendResolve = appendResolve + '<button type="button" id="btnReply" onclick="btnShowReply('+ value.id_draft_pr +','+ value.id +','+"'"+ value.operator+"'" +')" data-id="'+ value.id_draft_pr +'" data-value="'+ value.id +'" '+ disableReply +' class="btn btn-sm btn-secondary btn-xs" style="margin-top:10px"><i class="bx bx-reply"></i> Reply</button>'
          // appendResolve = appendResolve + '</div>'
          //   if (value.reply.length > 0) {
          //     style = 'display:block'
          //   }else{
          //     style = 'display:none'
          //   }
          //   appendResolve = appendResolve + '<div class="card-footer card-comments" style="'+ style +'">'
          //   $.each(value.reply,function(items,values){
          //     if (values.gambar != '' && values.gambar != '-' && values.gambar != null) {
          //       gambar = values.gambar
          //     }else{
          //       gambar = 'place_profile_3.png'
          //     }
          //     appendResolve = appendResolve + '<div class="card-comment">'
          //     appendResolve = appendResolve + '<img class="img-circle img-sm" src="{{ asset("image")}}/'+ gambar +'" alt="User Image">'
          //       appendResolve = appendResolve + '<div class="comment-text">'
          //       const cal = moment(values.date_add)
          //       .calendar(null, {
          //         lastDay: '[Yesterday]',
          //         sameDay: '[Today]',
          //         nextDay: '[Tomorrow]',
          //         lastWeek: '[last] dddd',
          //         nextWeek: 'dddd',
          //         sameElse: 'L'
          //       })
          //       appendResolve = appendResolve + '<span class="username">'+ values.operator +'<span class="text-muted pull-right">'+ cal + '&nbspat&nbsp' + moment(values.date_add).format('hh:mm A') +'</span>'
          //       appendResolve = appendResolve + '</span><p>'+ values.reply +'</p>'
          //       appendResolve = appendResolve + '</div>'
          //       appendResolve = appendResolve + '<button class="btn btn-sm btn-xs btn-secondary" id="btnReplyBottom" onclick="btnShowReply('+ value.id_draft_pr +','+ value.id +','+"'"+ values.operator+"'" +')" data-id="'+ value.id_draft_pr +'" data-value="'+ value.id +'" '+ disableReply +'><i class="bx bx-reply"></i>&nbspReply</button>'
          //       appendResolve = appendResolve + " "
          //     appendResolve = appendResolve + '</div>'
          //   })            
          //   appendResolve = appendResolve + '</div>'

          //   //footer
          //   if (value.resolve != 'True') {
          //     appendResolve = appendResolve + '<div class="card-footer" id="showFooter" data-value="'+ value.id +'" style="display:none">'
          //     appendResolve = appendResolve + '</div>'
          //   }
          //   appendResolve = appendResolve + '</div>'
          // appendResolve = appendResolve + '</div>'

        })
        $("#showResolve").append(appendResolve)

        if (window.location.href.split("?")[1] == "hide") {
          $(".btnResolve").attr('style','display:none!important')
        }
      }
    })
     
    $("#showPdf").attr("href","{{url('/admin/getPdfPRFromLink')}}/?no_pr="+window.location.href.split("/")[5]+"")

    $("#btnAddNotes").click(function(){
      $(".modal-dialog").removeClass('modal-lg')
      $("#ModalAddNote").modal("show")
    })

    document.getElementById("btnPembanding").onmousedown = function(event) {
      if (event.which == 3) {
        window.open("{{url('/admin/detailDraftPR')}}/"+window.location.href.split("/")[5],"_blank")
        localStorage.setItem('isLastStorePembanding',true)
        // pembanding()
      }
    }
  }  

  function num(value){
    alert("Number " + value);
  }

  function btnResolve(id){
    Swal.fire({
      title: 'Are you sure?',  
      text: "Resolve this",
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
          url: "{{url('/admin/storeResolveNotes')}}",
          data: {
            _token: "{{ csrf_token() }}",
            id:id,
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

  function btnShowReply(no_pr,id,person,disableReply){
    if ("{{Auth::User()->gambar}}" != null && "{{Auth::User()->gambar}}" != '' && "{{Auth::User()->gambar}}" != '-') {
      gambar = "{{Auth::User()->gambar}}"
    }else{
      gambar = "place_profile_3.png"
    }
     
    personDiv = '<strong<span>' + person + '</span></strong>'
    name = person
    

    
    var appendFooter = ''
    $("#showFooter[data-value='"+ id +"']").empty("")

    appendFooter = appendFooter + '<div class="avatar">'
      appendFooter = appendFooter + '<img class="rounded-circle img-sm" src="{{ asset("image/")}}/'+ gambar +'" alt="Alt Text">'
    appendFooter = appendFooter + '</div>'
    appendFooter = appendFooter + '<div class="img-push">'
    appendFooter = appendFooter + '<div class="input-group-mention">'
      appendFooter = appendFooter + '<textarea type="text" id="inputReply" data-id="'+ no_pr +'" data-value="'+ id +'" class="mention_reply input-md" placeholder="Type reply comment, @ mention member" style="border-left:none;border-right:none;border-top:none;resize:none"></textarea>'
      // appendFooter = appendFooter + '<span class="input-group-btn">'
      // appendFooter = appendFooter + '<input type="text" id="inputReply" data-id="'+ no_pr +'" data-value="'+ id +'" class="mention_reply form-control input-sm" placeholder="Type reply comment, @ mention member" style="border-left:none;border-right:none;border-top:none;resize:none">'
      appendFooter = appendFooter + '<span class="input-group-btn">'
        appendFooter = appendFooter + '<button onclick="pressReply('+ no_pr +','+ id +','+"'"+name+"'"+')" style="background-color: transparent;background-repeat: no-repeat;border: none; cursor: pointer;overflow: hidden;outline: none;" class="btn btn-sm btn-flat btn-sm"><i class="bx bx-send" style="color:#3c8dbc"></i></button>'
      appendFooter = appendFooter + '</span>'
      appendFooter = appendFooter + '<span class="input-group-btn">'
        appendFooter = appendFooter + '<button onclick="btnCloseReply('+ id +')" style="background-color: transparent;background-repeat: no-repeat;border: none; cursor: pointer;overflow: hidden;outline: none;" class="btn btn-sm btn-flat btn-sm"><i class="bx bx-trash" style="color:#dd4b39"></i></button>'
      appendFooter = appendFooter + '</span>'
      
    appendFooter = appendFooter + '</div>'          
    appendFooter = appendFooter + '</div>'
    $("#showFooter[data-value='"+ id +"']").append(appendFooter)
    $("#showFooter[data-value='"+ id +"']").show()

    
    $("#btnReply[data-value='"+ id +"']").prop("disabled",true)
    $("#btnReplyBottom[data-value='"+ id +"']").prop("disabled",true)

    mentionInput(name)
  }

  function btnCloseReply(id){
    $("#btnCloseReplyBottom[data-value='"+ id +"']").hide("slow")
    $("#btnReply[data-value='"+ id +"']").prop('disabled',false)
    $("#btnReplyBottom[data-value='"+ id +"']").prop('disabled',false)
    $("#showFooter[data-value='"+ id +"']").attr('style','display:none!important')
  }

  function mentionInput(){
    $.ajax({
      type:"GET",
      url:"{{url('/admin/getPerson')}}",
      data:{
        no_pr:window.location.href.split("/")[5]
      },
      success: function(result){
        var i = 0
        const results = result.map(item => {
          const container = {};
          container.id = i++;
          container.name = item.name;
          if (item.avatar == null) {
            container.avatar = '{{ asset("image/place_profile_3.png")}}';
          }else{
            container.avatar = item.avatar;
          }
          container.type = item.email;

          return container;
            

        })

        $('.mention_reply').mentionsInput({
          onDataRequest:function (mode, query, callback) {
            var data = results

            data = _.filter(data, function(item) { return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1 });

            callback.call(this, data);
          }
        });  

        if ($('html').hasClass('dark-style')) {
          // do something if it has the class
          console.log("betul")
          $(".mentions").attr('style','display:none!important')
        }  
      }
    })
  }

  function pressReply(no_pr,id,person){
    var emailMention = []
    //user procurement
    var user_proc = JSON.parse("{{App\RoleUser::join('users','users.nik','=','role_user.user_id')->join('roles','roles.id','=','role_user.role_id')->select('users.name')->where('roles.name','Procurement & Vendor Management')->where('status_karyawan','!=','dummy')->get()}}".replace(/&quot;/g,'"'))

    $.each(user_proc,function(item,value){
      emailMention.push({"name":value.name})
    })

    if ($("#inputReply").closest("div").find(".mentions").find("div").find("strong").length > 0) {
      obj_notes = $("#inputReply").closest("div").find(".mentions").find("div").find("span").splice("span")

      for (var i = 0; i < obj_notes.length; i++) {
        var item = {}; 
        
        if (obj_notes.length == 1) {
          if (obj_notes[i].textContent == person) {
            item["name"] = name;
            emailMention.push(item);
            

          }else{
            emailMention[0] = {"name":person};
            item["name"] = obj_notes[i].textContent;
            emailMention.push(item);
          }
        }else{
          if (obj_notes[i].textContent != person) {
            // obj_notes[i].textContent.remove()
            
            emailMention[0] = {"name":person};
            item["name"] = obj_notes[i].textContent;
            emailMention.push(item);
          }
        } 
      }      
    }else{
      emailMention.push({'name':name})
    }

    const uniqueIds = [];

    const filteredEmailMention = emailMention.filter(element => {
      const isDuplicate = uniqueIds.includes(element.name);

      if (!isDuplicate) {
        uniqueIds.push(element.name);

        return true;
      }
      return false;
    });
    
    $.ajax({
      type: "POST",
      url: "{{url('/admin/storeReply')}}",
      data: {
        _token: "{{ csrf_token() }}",
        id_notes:id,
        inputReply:$("#inputReply[data-value='"+ id +"']").prev('.mentions').find("div").html(),
        no_pr:no_pr,
        emailMention:filteredEmailMention
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

  function btnSubmitNotes(){
    var emailMention = []
    if ($("#inputNotes").closest("div").find(".mentions").find("div").find("strong").length > 1) {
      obj_notes = $("#inputNotes").closest("div").find(".mentions").find("div").find("span").splice("span")
      for (var i = 0; i < obj_notes.length; i++) {
        emailMention.push({'name':obj_notes[i].textContent})
      }      
    }else{
      emailMention.push({'name':$("#inputNotes").closest("div").find(".mentions").find("div").find("strong").text()})
    }
    $.ajax({
      type: "POST",
      url: "{{url('/admin/storeNotes')}}",
      data: {
        _token: "{{ csrf_token() }}",
        no_pr:window.location.href.split("/")[5],
        inputNotes:$("#inputNotes").prev('.mentions').find("div").html(),
        emailMention:emailMention,
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
          $("#ModalAddNote").modal("hide")
          Swal.close()
        })
        
      }
    })
  }

  function loadActivity(value,item){
    append = ""
      append = append + '<li class="timeline-event-time badge text-bg-secondary">'
        append = append + '<span>'
          append = append + value
        append = append + '</span>'
      append = append + '</li>'

      let colorBadge = ''

      $.each(item,function(value,item){
      append = append + '<li class="timeline-item">'
          if (item.status == 'SAVED') {
            colorBadge = 'text-bg-primary'

            append = append + '<span class="timeline-indicator timeline-indicator-primary" data-aos="zoom-in" data-aos-delay="200">'
              append = append + '<i class="bx bx-lock text-white"></i>'    
            append = append + '</span>'
          }else if (item.status == 'DRAFT') {
            colorBadge = 'text-bg-info'

            append = append + '<span class="timeline-indicator timeline-indicator-info" data-aos="zoom-in" data-aos-delay="200">'
              append = append + '<i class="bx bx-wallet text-white"></i>' 
            append = append + '</span>'
          }else if (item.status == 'REJECT' || item.status == 'CANCEL') {
            colorBadge = 'text-bg-danger'

            append = append + '<span class="timeline-indicator timeline-indicator-danger" data-aos="zoom-in" data-aos-delay="200">'
              append = append + '<i class="bx bx-x text-white"></i>' 
            append = append + '</span>'
          }else if (item.status == 'VERIFIED') {
            colorBadge = 'text-bg-success'

            append = append + '<span class="timeline-indicator timeline-indicator-success" data-aos="zoom-in" data-aos-delay="200">'
              append = append + '<i class="bx bx-check text-white"></i>'
            append = append + '</span>'
          }else if (item.status == 'COMPARING') {
            colorBadge = 'text-bg-primary'

            append = append + '<span class="timeline-indicator timeline-indicator-primary" data-aos="zoom-in" data-aos-delay="200">'
              append = append + '<i class="bx bx-network-chart text-white"></i>'
            append = append + '</span>'
          }else if (item.status == 'CIRCULAR') {
            colorBadge = 'text-bg-warning'

            append = append + '<span class="timeline-indicator timeline-indicator-warning" data-aos="zoom-in" data-aos-delay="200">'
              append = append + '<i class="bx bx-merge text-white"></i>'
            append = append + '</span>'
          }else if (item.status == 'DISAPPROVE') {
            colorBadge = 'text-bg-danger'

            append = append + '<span class="timeline-indicator timeline-indicator-danger" data-aos="zoom-in" data-aos-delay="200">'
              append = append + '<i class="bx bx-x text-white"></i>' 
            append = append + '</span>'
          }else if (item.status == 'FINALIZED') {
            colorBadge = 'text-bg-success'

            append = append + '<span class="timeline-indicator timeline-indicator-success" data-aos="zoom-in" data-aos-delay="200">'
              append = append + '<i class="bx bx-like text-white"></i>'
            append = append + '</span>'
          }else if (item.status == 'SENDED') {
            colorBadge = 'text-bg-success'

            append = append + '<span class="timeline-indicator timeline-indicator-success" data-aos="zoom-in" data-aos-delay="200">'
              append = append + '<i class="bx bx-envelope text-white"></i>'
            append = append + '</span>'
          }else if (item.status == 'UNAPPROVED') {
            colorBadge = 'text-bg-danger'

            append = append + '<span class="timeline-indicator timeline-indicator-danger" data-aos="zoom-in" data-aos-delay="200">'
              append = append + '<i class="bx bx-x text-white"></i>' 
            append = append + '</span>'
          }else if (item.status == 'RESOLVE_NOTES') {
            colorBadge = 'text-bg-success'

            append = append + '<span class="timeline-indicator timeline-indicator-success" data-aos="zoom-in" data-aos-delay="200">'
              append = append + '<i class="bx bx-check text-white"></i>' 
            append = append + '</span>'
          }else if (item.status == 'REPLY_NOTES') {
            colorBadge = 'text-bg-warning'

            append = append + '<span class="timeline-indicator timeline-indicator-warning" data-aos="zoom-in" data-aos-delay="200">'
              append = append + '<i class="bx bx-reply text-white"></i>'
            append = append + '</span>' 
          }else if (item.status == 'ADD_NOTES') {
            colorBadge = 'text-bg-info'

            append = append + '<span class="timeline-indicator timeline-indicator-info" data-aos="zoom-in" data-aos-delay="200">'
              append = append + '<i class="bx bx-plus text-white"></i>' 
            append = append + '</span>'
          }
        append = append + '<div class="timeline-event card p-2 ms-1 mt-2 mb-2">'
        append = append + '<span class="time"><i class="bx bx-clock-o"></i>&nbsp'+ moment(item.date_time).format('LT') +'</span>'
        append = append + '<label class="badge '+ colorBadge +'">' + item.status +'</label>'
        append = append + '<div class="crad-body p-2">'
          append = append + '<ul>'
            append = append + '<li>'
            append = append + '<span>'+ item.activity +'</span> by '
            append = append + '<span>'+ item.operator +'</span><br>'
            append = append + '</li>'
          append = append + '</ul>'
        })
          append = append + '</div>'
        append = append + '</div>'
      append = append + '</li>'

    $(".timeline").append(append)
  }

  function pembanding(){ 
    localStorage.setItem('status_tax',false)
    localStorage.setItem('tax_pb',0)
    localStorage.setItem('service_charge',0)
    localStorage.setItem('discount',0)
    localStorage.setItem('isPembanding',true)
    $("#showDetail").empty()
    arrReason = []
    loadData()
    getActivityTask()
    append = ""
    append = append + '<div class="col-md-6 tabGroup">'
      append = append + '<div class="card mb-4">'
        append = append + '<div class="card-header with-border">'
          append = append + '<a id="BtnBack" style="display:none">'
            append = append + '<button class="btn btn-sm btn-danger"><i class="bx bxs-chevron-left"></i>&nbsp;Back</button>'
          append = append + '<a>'
          append = append + '<label style="display:table;margin:0 auto">Draft</label>'
          append = append + '<div class="card-tools pull-right">'
            append = append + '<input value="'+ window.location.href.split("/")[5] +',draft" type="checkbox" class="cbDraft" name="chk" id="cbPriority"/><label>&nbspPriority <span class="bg-red statusComparisonSubmit"></span></label>'
              append = append + '</button>'
            append = append + '</div>'
          append = append + '</div>'
          append = append + '<div class="card-body">'
              append = append + '<div id="headerPreview">'
              append = append + '</div>'
              append = append + '<div class="card-header" style="display:block ruby"><h6 class="card-title" style="margin-top:15px">Products</h6><div class="card-tools pull-right"><button type="button" class="btn btn-sm btn-card-tool btnProductCollapsePembanding"><span class="bx bx-lg bx-chevron-down"></span></button></div></div>'
                append = append + '<div class="card-body" id="bodyCollapseProductPembanding">'
                  append = append + '<hr>'
                  append = append + '<div id="table-produk" class="table-responsive">'
                    append = append + '<table class="table no-wrap">'
                      append = append + '<thead>'
                        append = append + '<th>No</th>'
                        append = append + '<th width="20%">Product</th>'
                        append = append + '<th width="40%">Description</th>'
                        append = append + '<th width="5%">Qty</th>'
                        append = append + '<th width="5%">Type</th>'
                        append = append + '<th width="15%">Price</th>'
                        append = append + '<th width="15%">Total Price</th>'
                      append = append + '</thead>'
                      append = append + '<tbody id="bodyPreview">'
                      append = append + '</tbody>'
                    append = append + '</table>'
                  append = append + '</div>'
                append = append + '</div>'
                append = append + '<div id="bottomPreview">'
                append = append + '</div>'
              append = append + '</div>'
          append = append + '</div>'
        append = append + '</div>'
    append = append + '<div class="col-md-6" >'
    append = append + '<div id="divPembanding"></div>'
    append = append + '<div style="display:table;margin:0 auto"><button style="display:none" id="btnAddPembanding" class="btn btn-sm text-bg-primary" onclick="addPembanding()"><i class="bx bx-plus"></i>&nbspComparison</button</div>'        
    append = append + '</div>'
    $("#showDetail").append(append)

    $("#BtnBack").show()

    isPembanding = localStorage.getItem('isPembanding')
    $("#BtnBack").click(function(){
      if(localStorage.getItem('isPembanding') == 'true') {
        $("#showDetail").empty()
        localStorage.setItem('isPembanding',false)
        localStorage.setItem('isLastStorePembanding',false)
        showDetail()
        loadDataSubmitted()   

        if (window.location.href.split("?")[1] == "hide") {
          console.log("buak sial")
          $("#btnSirkulasi").attr('style','display:none!important')
          $("#btnFinalize").attr('style','display:none!important')
          $("#btnRevision").attr('style','display:none!important')
          $("#btnAddNotes").attr('style','display:none!important')
          $("#BtnBack").attr('style','display:none!important')
        }
      }else if (localStorage.getItem('isEmail') == 'true') {
        $("#showDetail").empty()
        localStorage.setItem('isEmail',false)
        showDetail()
        loadDataSubmitted()  
      }else{
        $("#BtnBack").attr("href", "{{url('/admin/draftPR')}}")
      }
    })

    $.ajax({
      type: "GET",
      url: "{{url('/admin/getPembanding')}}",
      data: {
        no_pr:window.location.href.split("/")[5],
      },
      success: function(result) {
        if (result[0].comparison.length == 0) {
          $(".cbDraft").prop('checked',true)
        }else{
          var statusSelected = []
          $.each(result[0].comparison,function(value,item){
            if (item.status == 'Selected') {
              statusSelected.push(item.status)
            }
          })

          if (statusSelected.length == 0) {
            $(".cbDraft").prop('checked',true)          
          }else{
            $(".cbDraft").prop('checked',false)          
          }
        }
        
        $.each(result[0].comparison,function(value,item){
          loadDataPembanding(value,item)
        })

        if (!accesable.includes('cbPriority')) {
          $(".cbDraft").prop('disabled',true)
          $(".cbPriority").prop('disabled',true)
          $(".cbPriority").closest('div').css('cursor','not-allowed')
          $(".cbDraft").closest('div').css('cursor','not-allowed') 
        }
      }
    })   

    accesable.forEach(function(item,index){
      if ((window.location.href.split("?")[1] == "hide") == false){
        $("#" + item).show()
      }
    })

  }

  function loadData(){
    $.ajax({
      type: "GET",
      url: "{{url('/admin/getPreviewPr')}}",
      data: {
        no_pr:window.location.href.split("/")[5],
      },
      success: function(result) {
        // if (result.pr.isCommit == 'True') {
        //   reasonReject("This supplier has been committed with us to supply this product.","block","tabGroup")
        // }

        type_of_letter = result.pr.type_of_letter
        if (type_of_letter == 'IPR') {
          PRType = '<b>Internal Purchase Request</b>'
        }else{
          PRType = '<b>External Purchase Request</b>'
        } 
        var appendHeader = ""
        appendHeader = appendHeader + '<div class="row">'
        appendHeader = appendHeader + '    <div class="col-md-6">'
        appendHeader = appendHeader + '        <div class="mb-2">To: '+ result.pr.to +'</div>'
        appendHeader = appendHeader + '        <div class="mb-2">Email: ' + result.pr.email + '</div>'
        appendHeader = appendHeader + '        <div class="mb-2">Phone: ' + result.pr.phone + '</div>'
        appendHeader = appendHeader + '        <div class="mb-2">Fax: '+ result.pr.fax +' </div>'
        appendHeader = appendHeader + '        <div class="mb-2">Attention: '+ result.pr.attention +'</div>'
        appendHeader = appendHeader + '        <div class="mb-2">From: '+ result.pr.name +'</div>'
        appendHeader = appendHeader + '        <div class="mb-2">Subject: '+ result.pr.title +'</div>'
        appendHeader = appendHeader + '        <div class="mb-2" style="width:fit-content;word-wrap: break-word;">Address: '+ result.pr.address +'</div>'

        appendHeader = appendHeader + '    </div>'
        if (window.matchMedia("(max-width: 767px)").matches)
        {
            appendHeader = appendHeader + '    <div class="col-md-6">'
            // The viewport is less than 768 pixels wide
            
        } else {
            appendHeader = appendHeader + '    <div class="col-md-6" style="text-align:end">'
            // The viewport is at least 768 pixels wide
            
        }
        appendHeader = appendHeader + '        <div class="mb-2">'+ PRType +'</div>'
        appendHeader = appendHeader + '        <div class="mb-2"><b>Request Methode</b></div>'
        appendHeader = appendHeader + '        <div class="mb-2">'+ result.pr.request_method +'</div>'
        appendHeader = appendHeader + '        <div class="mb-2">'+ moment(result.pr.created_at).format('DD MMMM') +'</div>'
        if (type_of_letter == 'EPR') {
          appendHeader = appendHeader + '        <div class="mb-2"><b>Project Id</b></div>'
          appendHeader = appendHeader + '        <div class="mb-2">'+ result.pr.pid +'</div>'
          appendHeader = appendHeader + '        <div class="mb-2"><b>Quote Number</b></div>'
          appendHeader = appendHeader + '        <div class="mb-2">'+ result.pr.quote_number +'</div>'
        }
        appendHeader = appendHeader + '    </div>'
        appendHeader = appendHeader + '</div>'

        $("#headerPreview").append(appendHeader)
        var append = ""
        var i = 0
        $.each(result.product,function(value,item){
          i++
          append = append + '<tr>'
            append = append + '<td>'
              append = append + '<span>'+ i +'</span>'
            append = append + '</td>'
            append = append + '<td>'
            append = append + "<input data-value='' disabled style='width:200px;font-size: 12px; important' class='form-control' type='' name='' value='"+ item.name_product + "'>"
            append = append + '</td>'
            append = append + '<td>'
              append = append + '<textarea style="width:500px;font-size:12px;height:150px;resize:none" class="form-control" disabled>' + item.description.replaceAll("<br>","\n") + '&#10;&#10;SN : ' + item.serial_number + '&#10;PN : ' + item.part_number +'</textarea>'
            append = append + '</td>'
            append = append + '<td>'
              append = append + '<input disabled class="form-control" type="" name="" value="'+ item.qty +'" style="width:70px;font-size:12px">'
            append = append + '</td>'
            append = append + '<td>'
              append = append + '<select disabled class="form-control" style="width:80px;font-size:12px">'
              append = append + '<option>'+ item.unit.charAt(0).toUpperCase() + item.unit.slice(1) +'</option>'
              append = append + '</select>'
            append = append + '</td>'
            append = append + '<td>'
              append = append + '<input disabled class="form-control" type="" name="" value="'+ formatter.format(item.nominal_product) +'" style="width:100px;font-size:12px">'
            append = append + '</td>'
            append = append + '<td>'
              append = append + '<input disabled class="form-control grandTotalPrice" id="grandTotalPrice" type="" name="" value="'+ formatter.format(item.grand_total) +'" style="width:100px;font-size:12px">'
            append = append + '</td>'
          append = append + '</tr>'
        })

        $("#bodyPreview").append(append)
        appendBottom = ""
        appendBottom = appendBottom + '<hr>'
        appendBottom = appendBottom + '<div class="row">'
        appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
        appendBottom = appendBottom + '    <form class="form-horizontal">'
        appendBottom = appendBottom + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottom = appendBottom + '        <label for="inputEmail3" class="col-sm-offset-6 col-sm-2 control-label">Total</label>'
        appendBottom = appendBottom + '        <input disabled type="text" class="form-control inputGrandTotalProductPreviewData w-auto text-end" id="inputGrandTotalProductPreviewData" data-value="'+i+'" style="text-align:right">'
        appendBottom = appendBottom + '      </div>'

        appendBottom = appendBottom + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottom = appendBottom + '        <label for="inputEmail4" class="col-sm-offset-6 col-sm-2 control-label">Discount <span class="title_discount"></span></label>'
        appendBottom = appendBottom + '         <input disabled type="text" class="form-control w-auto text-end" style="text-align:right" id="discount_previewData" data-value="'+i+'">'
        appendBottom = appendBottom + '      </div>'

        appendBottom = appendBottom + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottom = appendBottom + '        <label for="inputEmail4" class="col-sm-offset-6 col-sm-2 control-label">Tax Base Other </label>'
        appendBottom = appendBottom + '          <input disabled style="text-align:right" type="text" class="form-control tax_base_other_preview w-auto text-end" id="tax_base_other_previewData" data-value="'+i+'">'
        appendBottom = appendBottom + '      </div>'

        appendBottom = appendBottom + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottom = appendBottom + '        <label for="inputEmail4" class="col-sm-offset-6 col-sm-2 control-label">Vat <span class="title_tax"></span></label>'
        appendBottom = appendBottom + '        <input disabled style="text-align:right" type="text" class="form-control vat_tax_preview w-auto text-end" id="vat_tax_previewData" data-value="'+i+'">'
        appendBottom = appendBottom + '      </div>'

        appendBottom = appendBottom + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottom = appendBottom + '        <label for="inputEmail4" class="col-sm-offset-6 col-sm-2 control-label">PB1 <span class="title_pb1"></span></label>'
        appendBottom = appendBottom + '        <input disabled type="text" class="form-control w-auto text-end" style="text-align:right" id="pb1_previewData" data-value="'+i+'">'
        appendBottom = appendBottom + '      </div>'

        appendBottom = appendBottom + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottom = appendBottom + '        <label for="inputEmail4" class="col-sm-offset-6 col-sm-2 control-label">Service Charge <span class="title_service"></span></label>'
        appendBottom = appendBottom + '        <input disabled type="text" class="form-control w-auto text-end" style="text-align:right" id="service_previewData" data-value="'+i+'">'
        appendBottom = appendBottom + '      </div>'

        appendBottom = appendBottom + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottom = appendBottom + '        <label for="inputEmail5" class="col-sm-offset-6 col-sm-2 control-label">Grand Total</label>'
        appendBottom = appendBottom + '          <input disabled style="text-align:right" type="text" class="form-control inputFinalPageTotalPriceData w-auto text-end" id="inputFinalPageTotalPriceData" data-value="'+i+'">'
        appendBottom = appendBottom + '      </div>'
        appendBottom = appendBottom + '    </form>'
        appendBottom = appendBottom + '  </div>'
        appendBottom = appendBottom + '</div>'
        appendBottom = appendBottom + '<hr>'
        appendBottom = appendBottom + '<div class="card mb-4">'
          appendBottom = appendBottom + '<div class="card-header with-border" style="display:block ruby">'
            appendBottom = appendBottom + '<h6 class="card-title" style="margin-top:15px">Terms & Condition</h6>'
            appendBottom = appendBottom + '<div class="card-tools pull-right">'
                appendBottom = appendBottom + '<button type="button" class="btn btn-sm btn-card-tool btnTerm mt-1" data-value="draft"><span class="bx bx-lg bx-chevron-right"></span>'
                appendBottom = appendBottom + '</button>'
              appendBottom = appendBottom + '</div>'
            appendBottom = appendBottom + '</div>'
            appendBottom = appendBottom + '<div class="card-body collapse" id="bodyCollapse" data-value="draft">'
             appendBottom = appendBottom + '<div class="form-control" id="termPreview" style="padding:10px;width: 100%; height: 200px; font-size: 12px; line-height: 18px; border: 1px solid rgb(221, 221);overflow:auto"></div>'
          appendBottom = appendBottom + '</div>'
        appendBottom = appendBottom + '</div>'
        appendBottom = appendBottom + '<hr>'
        appendBottom = appendBottom + '<span><b>Attached Files</b></span>'
        var pdf = "bx bx-fw bxs-file-pdf"
        var image = "bx bx-fw bxs-file-image"
        if (result.pr.type_of_letter == 'IPR') {
          if (result.dokumen[0].dokumen_location.split(".")[1] == 'pdf') {
            var fa_doc = pdf
          }else{
            var fa_doc = image
          }
          appendBottom = appendBottom + '<div class="form-group" style="font-size: reguler;">'
            appendBottom = appendBottom + '<div class="row">'
              appendBottom = appendBottom + '<div class="col-md-6">'
                appendBottom = appendBottom + '<div style="border: 1px solid #dee2e6 !important;padding: 5px;"><a href="'+result.dokumen[0].link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ result.dokumen[0].dokumen_location.substring(0,15) + '....'+ result.dokumen[0].dokumen_location.split(".")[0].substring(result.dokumen[0].dokumen_location.length -10) + "." + result.dokumen[0].dokumen_location.split(".")[1] +'</a>'
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
                    appendBottom = appendBottom + '<div style="border: 1px solid #dee2e6 !important;padding: 5px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
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
                    appendBottom = appendBottom + '<div style="border: 1px solid #dee2e6 !important;padding: 10px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
                    appendBottom = appendBottom + '</div>'
                  appendBottom = appendBottom + '</div>'
                  appendBottom = appendBottom + '<div class="col-md-6">'
                    appendBottom = appendBottom + '<div style="padding: 5px;">Dokumen &nbsp'+ item.dokumen_name +'</div>'
                  appendBottom = appendBottom + '</div>'
                appendBottom = appendBottom + '</div>'
              appendBottom = appendBottom + '</div>'      
          })
        } 

        $("#bottomPreview").append(appendBottom)    

        $("#termPreview").html(result.pr.term_payment.replaceAll("&lt;br&gt;","<br>"))
        var tempVat = 0
        var tempPb1 = 0
        var tempService = 0
        var tempDiscount = 0
        var finalVat = 0
        var tempGrand = 0
        var finalGrand = 0
        var tempTotal = 0
        var sum = 0

        $('.grandTotalPrice').each(function() {
            var temp = parseFloat($(this).val() == "" ? "0" : parseFloat($(this).val().replace(/\./g,'').replace(',','.').replace(' ','')))
            sum += temp;
        });

        // if (result.pr.status_tax == 'True') {
        //   tempVat = formatter.format((parseFloat(sum) * 11) / 100)
        //   tempGrand = parseInt(sum) +  parseInt((parseInt(sum) * 11) / 100)
        // }else{
        //   tempVat = tempVat
        //   tempGrand = parseInt(sum)
        // }

        console.log(result.pr.status_tax)
        if (result.pr.status_tax == "false") {
          valueVat = ''
        }else{
          valueVat = result.pr.status_tax
        }
        if (!isNaN(valueVat)) {
          tempVat = result.pr.discount == null || result.pr.discount == "false" ? Math.round((parseFloat(sum) * (parseFloat(result.pr.status_tax)/100))) : Math.round(((parseFloat(sum) - (parseFloat(sum) * parseFloat(result.pr.discount)/100)) * (valueVat == false?0:parseFloat(valueVat) / 100)))

          finalVat = tempVat

          tempGrand = Math.round(parseInt(sum) +  tempVat)

          finalGrand = tempGrand

          tempTotal = sum

          $('.title_tax').text(valueVat == 0?"":valueVat + '%')
        }else{
          tempGrand = sum

          $('.title_tax').text("")
        }

        $('.title_pb1').text(result.pr.tax_pb == 'false'?"":result.pr.tax_pb+"%")
        $('.title_service').text(result.pr.service_charge == 'false'?"":result.pr.service_charge+"%")
        $('.title_discount').text(result.pr.discount == 'false'?"":parseFloat(result.pr.discount).toFixed(2)+"%")

        tempDiscount = Math.round((parseFloat(sum) * (result.pr.discount == 'false'?tempDiscount:parseFloat(result.pr.discount)) / 100))
        tempPb1 = Math.round(((parseFloat(sum) - tempDiscount) * (result.pr.tax_pb == 'false'?tempPb1:parseFloat(result.pr.tax_pb)) / 100))
        tempService = Math.round(((parseFloat(sum) - tempDiscount) * (result.pr.service_charge == 'false'?tempService:parseFloat(result.pr.service_charge)) / 100))
        
        // tempGrand = sum - tempDiscount + tempVat + tempPb1 + tempService

        $("#vat_tax_previewData").val(formatter.format(tempVat))
        $("#tax_base_other_previewData").val(formatter.format(customRound(formatter.format((tempTotal - tempDiscount)*11/12))))
        $("#inputGrandTotalProductPreviewData").val(formatter.format(sum))
        $("#pb1_previewData").val(formatter.format(tempPb1))
        $("#service_previewData").val(formatter.format(tempService))
        $("#discount_previewData").val(formatter.format(tempDiscount))
        $("#inputFinalPageTotalPriceData").val(formatter.format(result.grand_total))

        if (result.pr.tax_pb == 'false') {
          $("#pb1_previewData").closest(".form-group").attr('style','display:none!important')
        }else{
          $("#pb1_previewData").closest(".form-group").show()
        }

        if (result.pr.service_charge == 'false') {
          $("#service_previewData").closest(".form-group").attr('style','display:none!important')
        }else{
          $("#service_previewData").closest(".form-group").show()
        }

        if (result.pr.discount == 'false') {
          $("#discount_previewData").closest(".form-group").attr('style','display:none!important')
        }else{
          $("#discount_previewData").closest(".form-group").show()
        }
      }
    })
  } 

  $(document).on('click','.btnTerm[data-value="draft"]', function() {
    if ($("#bodyCollapse[data-value='draft']").is(':visible') == true) {
      $("#bodyCollapse[data-value='draft']").hide("slow")
      $(this).find('span').removeClass("bx-chevron-down").addClass("bx-chevron-right")

    }
    if ($("#bodyCollapse[data-value='draft']").is(':hidden') == true){
      $("#bodyCollapse[data-value='draft']").show('slow')
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

  $(document).on('click','.btnProductCollapsePembanding', function() {
    if ($("#bodyCollapseProductPembanding").is(':visible') == true) {
      $("#bodyCollapseProductPembanding").hide("slow")
      $(this).find('span').removeClass("bx-chevron-down").addClass("bx-chevron-right")

    }
    if ($("#bodyCollapseProductPembanding").is(':hidden') == true){
      $("#bodyCollapseProductPembanding").show('slow')
      $(this).find('span').removeClass("bx-chevron-right").addClass("bx-chevron-down")
    }
  })

  function customRound(num) {
    var parseNum = parseFloat(num.replace(/\./g, "").replace(",", "."));
    return Math.round(parseNum);
  } 

  function loadDataSubmitted(){
    $.ajax({
      type: "GET",
      url: "{{url('/admin/getDetailPr')}}",
      data: {
        no_pr:window.location.href.split("/")[5],
      },
      success: function(result) {
        //initiate btn finalize
        $("#btnFinalize").attr("onclick","finalize("+ '"' +result.pr.request_method+ '"' +")")

        if (accesable.includes('btnSirkulasi','btnPembanding','btnShowPdf') || accesable.includes('btnShowPdf')) {
          $.each(accesable,function(value,item){
            if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Procurement & Vendor Management')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Internal Chain Management')->exists()}}") {
              if(result.pr.status == 'FINALIZED'){
                $("#btnFinalize").prop('disabled',false)
                $("#btnSirkulasi").prop('disabled',true)
              }else{
                $("#btnFinalize").prop('disabled',true)
              }
            }
          })
        }  

        type_of_letter = result.pr.type_of_letter
        if (type_of_letter == 'IPR') {
          PRType = '<b>Internal Purchase Request</b>'
        }else{
          PRType = '<b>External Purchase Request</b>'
        } 

        if (result.getSign == '{{Auth::User()->name}}') {
          //bcd manager & pmo manager bisa circular meskipun belum diresolve
          if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Internal Chain Management')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Program & Project Management')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Solutions & Partnership Management')->exists()}}") {
            $("#btnSirkulasi").prop('disabled',false)
          }else{
            if (result.isNotes == 'False') {
              $("#btnSirkulasi").prop('disabled',true)
              reasonReject('Please resolve the notes, to continue circular process!','block','tabGroup')
            }else{
              
              $("#btnSirkulasi").prop('disabled',false)
            }
          }
        }

        if (result.pr.status == "UNAPPROVED" || result.pr.status == "CIRCULAR") {
          if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Procurement & Vendor Management')->exists()}}") {
            $("#btnSirkulasi").prop('disabled',true)
          }
        }else{
          if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Procurement & Vendor Management')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Internal Chain Management')->exists()}}") {
            if (result.pr.status == "FINALIZED" || result.pr.status == "SENDED") {
              $("#btnSirkulasi").prop('disabled',true)
            }else{
              $("#btnSirkulasi").prop('disabled',false)
            }
          }
        }

        if (result.pr.status == "REJECT" || result.pr.status == "UNAPPROVED" || result.pr.activity == 'Updating' && result.pr.status == 'COMPARING'){
          reasonReject(result.activity.reason,"block")
        }

        if (result.pr.isCommit == 'True') {
          
          reasonReject("This supplier has been committed with us to supply this product.","block","tabGroup","warning")
        }

        var appendHeader = ""
        appendHeader = appendHeader + '<div class="row">'
        appendHeader = appendHeader + '    <div class="col-md-6">'
        appendHeader = appendHeader + '        <div class="mb-2">To: '+ result.pr.to +'</div>'
        appendHeader = appendHeader + '        <div class="mb-2">Email: ' + result.pr.email + '</div>'
        appendHeader = appendHeader + '        <div class="mb-2">Phone: ' + result.pr.phone + '</div>'
        appendHeader = appendHeader + '        <div class="mb-2">Fax: '+ result.pr.fax +' </div>'
        appendHeader = appendHeader + '        <div class="mb-2">Attention: '+ result.pr.attention +'</div>'
        appendHeader = appendHeader + '        <div class="mb-2">From: '+ result.pr.name +'</div>'
        appendHeader = appendHeader + '        <div class="mb-2">Subject: '+ result.pr.title +'</div>'
        appendHeader = appendHeader + '        <div class="mb-2" style="width:fit-content;word-wrap: break-word;">Address: '+ result.pr.address +'</div>'

        appendHeader = appendHeader + '    </div>'
        if (window.matchMedia("(max-width: 767px)").matches)
        {
            appendHeader = appendHeader + '    <div class="col-md-6">'
            // The viewport is less than 768 pixels wide
            
        } else {
            appendHeader = appendHeader + '    <div class="col-md-6" style="text-align:end">'
            // The viewport is at least 768 pixels wide
            
        }
        appendHeader = appendHeader + '        <div class="mb-2">'+ PRType +'</div>'
        if (result.pr.no_pr != undefined) {
          appendHeader = appendHeader + '        <div class="mb-2">'+ result.pr.no_pr +'</div>'
        }
        appendHeader = appendHeader + '        <div class="mb-2"><b>Request Methode</b></div>'
        appendHeader = appendHeader + '        <div class="mb-2">'+ result.pr.request_method +'</div>'
        appendHeader = appendHeader + '        <div class="mb-2">'+ moment(result.pr.created_at).format('DD MMMM') +'</div>'
        if (type_of_letter == 'EPR') {
          appendHeader = appendHeader + '        <div class="mb-2"><b>Project Id</b></div>'
          appendHeader = appendHeader + '        <div class="mb-2">'+ result.pr.pid +'</div>'
          appendHeader = appendHeader + '        <div class="mb-2"><b>Quote Number</b></div>'
          appendHeader = appendHeader + '        <div class="mb-2">'+ result.pr.quote_number +'</div>'
        }
        appendHeader = appendHeader + '    </div>'
        appendHeader = appendHeader + '</div>'

        $("#headerPreview").append(appendHeader)
        var append = ""
        var i = 0
        $.each(result.product,function(value,item){
          i++
          append = append + '<tr>'
            append = append + '<td>'
              append = append + '<span>'+ i +'</span>'
            append = append + '</td>'
            append = append + '<td>'
            append = append + "<input data-value='' disabled style='width:200px;font-size: 12px; important' class='form-control' type='' name='' value='"+ item.name_product + "'>"
            append = append + '</td>'
            append = append + '<td>'
              append = append + '<textarea style="font-size:12px;width:200px;height:150px;resize:none" class="form-control" disabled>' + item.description.replaceAll("<br>","\n") + '&#10;&#10;SN : ' + item.serial_number + '&#10;PN : ' + item.part_number +'</textarea>'
            append = append + '</td>'
            append = append + '<td>'
              append = append + '<input disabled class="form-control" type="" name="" value="'+ item.qty +'" style="width:70px;font-size:12px">'
            append = append + '</td>'
            append = append + '<td>'
              append = append + '<select disabled class="form-control" style="width:80px;font-size:12px">'
              append = append + '<option>'+ item.unit.charAt(0).toUpperCase() + item.unit.slice(1) +'</option>'
              append = append + '</select>'
            append = append + '</td>'
            append = append + '<td>'
              append = append + '<input disabled class="form-control" type="" name="" value="'+ formatter.format(item.nominal_product) +'" style="width:100px;font-size:12px">'
            append = append + '</td>'
            append = append + '<td>'
              append = append + '<input disabled class="form-control grandTotalPrice" id="grandTotalPrice" type="" name="" value="'+ formatter.format(item.grand_total) +'" style="width:100px;font-size:12px">'
            append = append + '</td>'
          append = append + '</tr>'
        })

        $("#bodyPreview").append(append)
        appendBottomProduct = ""
        appendBottomProduct = appendBottomProduct + '<hr>'
        appendBottomProduct = appendBottomProduct + '<div class="row">'
        appendBottomProduct = appendBottomProduct + '  <div class="col-md-12 col-xs-12">'
        appendBottomProduct = appendBottomProduct + '    <form class="form-horizontal">'
        appendBottomProduct = appendBottomProduct + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottomProduct = appendBottomProduct + '        <label for="inputEmail3" class="col-sm-offset-8 col-sm-2 control-label">Total</label>'
        appendBottomProduct = appendBottomProduct + '        <input disabled type="text" class="form-control inputGrandTotalProductPreview w-auto text-end" id="inputGrandTotalProductPreview" data-value="'+i+'" style="text-align:right">'
        appendBottomProduct = appendBottomProduct + '      </div>'

        appendBottomProduct = appendBottomProduct + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottomProduct = appendBottomProduct + '        <label for="inputDiscount" class="col-sm-offset-8 col-sm-2 control-label">Discount <span class="title_discount"></span></label>'
        appendBottomProduct = appendBottomProduct + '          <input disabled style="text-align:right" type="text" class="form-control inputDiscount_preview w-auto text-end" id="inputDiscount_preview" data-value="'+i+'">'
        appendBottomProduct = appendBottomProduct + '      </div>'

        appendBottomProduct = appendBottomProduct + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottomProduct = appendBottomProduct + '        <label for="inputEmail4" class="col-sm-offset-8 col-sm-2 control-label">Tax Base Other</label>'
        appendBottomProduct = appendBottomProduct + '          <input disabled style="text-align:right" type="text" class="form-control tax_base_other w-auto text-end" id="tax_base_other_preview" data-value="'+i+'">'
        appendBottomProduct = appendBottomProduct + '      </div>'

        appendBottomProduct = appendBottomProduct + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottomProduct = appendBottomProduct + '        <label for="inputEmail4" class="col-sm-offset-8 col-sm-2 control-label">Vat <span class="title_tax"></span></label>'
        appendBottomProduct = appendBottomProduct + '          <input disabled style="text-align:right" type="text" class="form-control vat_tax w-auto text-end" id="vat_tax_preview" data-value="'+i+'">'
        appendBottomProduct = appendBottomProduct + '      </div>'

        appendBottomProduct = appendBottomProduct + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottomProduct = appendBottomProduct + '        <label for="inputPb1" class="col-sm-offset-8 col-sm-2 control-label">PB1 <span class="title_pb1"></span></label>'
        appendBottomProduct = appendBottomProduct + '          <input disabled style="text-align:right" type="text" class="form-control inputPb1_preview w-auto text-end" id="inputPb1_preview" data-value="'+i+'">'
        appendBottomProduct = appendBottomProduct + '      </div>'
        
        appendBottomProduct = appendBottomProduct + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottomProduct = appendBottomProduct + '        <label for="inputServiceCharge" class="col-sm-offset-8 col-sm-2 control-label">Service Charge <span class="title_service"></span></label>'
        appendBottomProduct = appendBottomProduct + '          <input disabled style="text-align:right" type="text" class="form-control inputServiceCharge_preview w-auto text-end" id="inputServiceCharge_preview" data-value="'+i+'">'
        appendBottomProduct = appendBottomProduct + '      </div>'

        appendBottomProduct = appendBottomProduct + '      <div class="d-flex justify-content-end align-items-center mb-2">'
        appendBottomProduct = appendBottomProduct + '        <label for="inputEmail5" class="col-sm-offset-8 col-sm-2 control-label">Grand Total</label>'
        appendBottomProduct = appendBottomProduct + '          <input disabled style="text-align:right" type="text" class="form-control inputFinalPageTotalPrice w-auto text-end" id="inputFinalPageTotalPrice" data-value="'+i+'">'
        appendBottomProduct = appendBottomProduct + '      </div>'

        appendBottomProduct = appendBottomProduct + '    </form>'
        appendBottomProduct = appendBottomProduct + '  </div>'
        appendBottomProduct = appendBottomProduct + '</div>'
        appendBottomProduct = appendBottomProduct + '<hr>'

        $("#bottomPreviewProduct").append(appendBottomProduct)    

        appendBottom = ""
        appendBottom = appendBottom + '<div class="card mb-4">'
          appendBottom = appendBottom + '<div class="card-header with-border" style="display:block ruby">'
            appendBottom = appendBottom + '<h6 class="card-title" style="margin-top:15px">Terms & Condition</h6>'
            appendBottom = appendBottom + '<div class="card-tools pull-right">'
                appendBottom = appendBottom + '<button type="button" class="btn btn-sm btn-card-tool btnTerm mt-1" data-value="submitted"><span class="bx bx-lg bx-chevron-right"></span>'
                appendBottom = appendBottom + '</button>'
              appendBottom = appendBottom + '</div>'
            appendBottom = appendBottom + '</div>'
            appendBottom = appendBottom + '<div class="card-body collapse" id="bodyCollapse" data-value="submitted">'
             appendBottom = appendBottom + '<div class="form-control" id="termPreview" style="width: 100%; height: 200px; font-size: 12px; line-height: 18px; border: 1px solid rgb(221, 221);overflow:auto"></div>'
          appendBottom = appendBottom + '</div>'
        appendBottom = appendBottom + '</div>'
        appendBottom = appendBottom + '<hr>'
        appendBottom = appendBottom + '<span><b>Attached Files</b></span>'
        var pdf = "bx bx-fw bxs-file-pdf"
        var image = "bx bx-fw bxs-file-image"
        
        if (result.pr.type_of_letter == 'IPR') {
          if (result.dokumen[0].dokumen_location.split(".")[1] == 'pdf') {
            var fa_doc = pdf
          }else{
            var fa_doc = image
          }
          appendBottom = appendBottom + '<div class="form-group" style="font-size: reguler;">'
            appendBottom = appendBottom + '<div class="row">'
              appendBottom = appendBottom + '<div class="col-md-6">'
                appendBottom = appendBottom + '<div style="border: 1px solid #dee2e6 !important;padding: 10px;"><a href="'+result.dokumen[0].link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ result.dokumen[0].dokumen_location.substring(0,15) + '....'+ result.dokumen[0].dokumen_location.split(".")[0].substring(result.dokumen[0].dokumen_location.length -10) + "." + result.dokumen[0].dokumen_location.split(".")[1] +'</a>'
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
                    appendBottom = appendBottom + '<div style="border: 1px solid #dee2e6 !important;padding: 10px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
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
                    appendBottom = appendBottom + '<div style="border: 1px solid #dee2e6 !important;padding: 10px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
                    appendBottom = appendBottom + '</div>'
                  appendBottom = appendBottom + '</div>'
                  appendBottom = appendBottom + '<div class="col-md-6">'
                    appendBottom = appendBottom + '<div style="padding: 5px;">Dokumen &nbsp'+ item.dokumen_name +'</div>'
                  appendBottom = appendBottom + '</div>'
                appendBottom = appendBottom + '</div>'
              appendBottom = appendBottom + '</div>'      
          })
        }
        
        if (result.show_ttd.length > 0) {
          appendBottom = appendBottom + '<hr>'
          appendBottom = appendBottom + '<div>'
          appendBottom = appendBottom + '<span><b>Approver Sign</b></span>'
          appendBottom = appendBottom + '</div>'
          $.each(result.show_ttd,function(value,item){
            appendBottom = appendBottom + '<div class="form-group" style="display:inline;float:left;text-align:center;margin:20px">'
            appendBottom = appendBottom + '<div><img src="{{asset("/")}}'+ item.ttd +'" style="width:100px;height:100px" /></div>'
            appendBottom = appendBottom + '<div><span style="text-align:center" disabled>'+ item.name +'</span></div>'
            appendBottom = appendBottom + '</div>'
          })
        }       

        $("#bottomPreview").append(appendBottom)    

        if (result.pr.term_payment != null) {
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

        $('.grandTotalPrice').each(function() {
            var temp = parseFloat($(this).val() == "" ? "0" : parseFloat($(this).val().replace(/\./g,'').replace(',','.').replace(' ','')))
            sum += temp;
        });

        if (result.pr.status_tax == false) {
          valueVat = 'false'
        }else{
          valueVat = result.pr.status_tax
        }

        console.log(tempVat)
        if (!isNaN(valueVat)) {
          tempVat = result.pr.discount == null || result.pr.discount == "false" ? Math.round((parseFloat(sum) * (parseFloat(result.pr.status_tax)/100))) : Math.round(((parseFloat(sum) - (parseFloat(sum) * result.pr.discount /100))) * (parseFloat(result.pr.status_tax)/100))

          finalVat = tempVat

          tempGrand = Math.round(parseInt(sum) +  tempVat)

          tempTotal = sum

          if (valueVat == 11) {
            valueVat = 12
          }else if(valueVat == 1.1) {
            valueVat = 1.2
          }else{
            valueVat = valueVat
          }

          $('.title_tax').text(valueVat + '%')
        }else{
          tempGrand = sum

          $('.title_tax').text("")
        }

        $('.title_pb1').text(result.pr.tax_pb == 'false'?"":result.pr.tax_pb+"%")
        $('.title_service').text(result.pr.service_charge == 'false'?"":result.pr.service_charge+"%")
        $('.title_discount').text(result.pr.discount == 'false'?"":parseFloat(result.pr.discount).toFixed(2)+"%")

        tempDiscount = Math.round((parseFloat(sum) * (result.pr.discount == 'false'?tempDiscount:parseFloat(result.pr.discount)) / 100))
        tempPb1 = Math.round(((parseFloat(sum) - tempDiscount) * (result.pr.tax_pb == 'false'?tempPb1:parseFloat(result.pr.tax_pb)) / 100))
        tempService = Math.round(((parseFloat(sum) - tempDiscount) * (result.pr.service_charge == 'false'?tempService:parseFloat(result.pr.service_charge)) / 100))
        
        // finalGrand = tempGrand + tempPb1 + tempService - tempDiscount

        $("#vat_tax_preview").val(formatter.format(tempVat))
        $("#tax_base_other_preview").val(formatter.format(customRound(formatter.format((tempTotal - tempDiscount)*11/12))))

        console.log(formatter.format((tempTotal - tempDiscount)*11/12))

        $("#inputGrandTotalProductPreview").val(formatter.format(sum))
        $("#inputPb1_preview").val(formatter.format(tempPb1))
        $("#inputServiceCharge_preview").val(formatter.format(tempService))
        $("#inputDiscount_preview").val(formatter.format(tempDiscount))
        $("#inputFinalPageTotalPrice").val(formatter.format(result.grand_total))

        if (result.pr.tax_pb == 'false') {
          console.log("testttt")
          $("#inputPb1_preview").closest(".form-group").attr('style','display:none!important')
        }else{
          $("#inputPb1_preview").closest(".form-group").show()
        }

        if (result.pr.service_charge == 'false') {
          $("#inputServiceCharge_preview").closest(".form-group").attr('style','display:none!important')
        }else{
          $("#inputServiceCharge_preview").closest(".form-group").show()
        }

        if (result.pr.discount == 'false') {
          $("#inputDiscount_preview").closest(".form-group").attr('style','display:none!important')
        }else{
          $("#inputDiscount_preview").closest(".form-group").show()
        }
      }
    })
  }  

  $(document).on('click','.btnTerm[data-value="submitted"]', function() {
    if ($("#bodyCollapse[data-value='submitted']").is(':visible') == true) {
      $("#bodyCollapse[data-value='submitted']").hide("slow")
      $(this).find('span').removeClass("bx-chevron-down").addClass("bx-chevron-right")

    }
    if ($("#bodyCollapse[data-value='submitted']").is(':hidden') == true){
      $("#bodyCollapse[data-value='submitted']").show('slow')
      $(this).find('span').removeClass("bx-chevron-right").addClass("bx-chevron-down")
    }
  })

  $("#TTD").click(function(){
      $("#selectTTD").prop("checked",true)
  })

  function loadDataPembanding(i,item){
    type_of_letter = item.type_of_letter
    if (type_of_letter == 'IPR') {
      PRType = '<b>Internal Purchase Request</b>'
    }else{
      PRType = '<b>External Purchase Request</b>'
    } 
    no = ++i
    append = ""

    append = append + '<div class="card mb-4">'
    append = append + '<div class="card-header with-border" style="display:block ruby">'
    append = append + '<label style="display:table;margin:0 auto">Comparisson #'+ no +'</label>'
    append = append + '<div class="card-tools pull-right">'
      append = append + '<input value="'+ item.id +',pembanding,'+ item.id_draft_pr +'" type="checkbox" data-value="'+ no +'" name="chk" id="cbPriority" style="display:none" class="cbPriority"/><label>&nbspPriority <span class="bg-blue statusComparison" data-value="'+ no +'"></span></label>'
        append = append + '<button type="button" class="btn btn-sm btn-card-tool btnMinus" onclick="btnMinus('+no+')" data-value="pembanding_'+ no +'"><span class="bx bx-lg bx-chevron-right"></span>'
        append = append + '</button>'
      append = append + '</div>'
    append = append + '</div>'
    append = append + '<div class="card-body">'
    append = append + '<div id="headerPreviewPembanding" data-value="'+i+'">'
    append = append + '<div class="row">'
    append = append + '    <div class="col-md-6">'
    append = append + '        <div class="mb-2">To: '+ item.to +'</div>'
    append = append + '        <div class="mb-2">Email: ' + item.email + '</div>'
    append = append + '        <div class="mb-2">Phone: ' + item.phone + '</div>'
    append = append + '        <div class="mb-2">Fax: '+ item.fax +' </div>'
    append = append + '        <div class="mb-2">Attention: '+ item.attention +'</div>'
    append = append + '        <div class="mb-2">From: '+ item.name +'</div>'
    append = append + '        <div class="mb-2">Subject: '+ item.title +'</div>'
    append = append + '        <div class="mb-2" style="width:fit-content;word-wrap: break-word;">Address: '+ item.address +'</div>'
    append = append + '    </div>'
    if (window.matchMedia("(max-width: 767px)").matches)
    {
        append = append + '    <div class="col-md-6">'
        // The viewport is less than 768 pixels wide
        
    } else {
        append = append + '    <div class="col-md-6" style="text-align:end">'
        // The viewport is at least 768 pixels wide
        
    }
    append = append + '        <div class="mb-2">'+ PRType +'</div>'
    append = append + '        <div class="mb-2"><b>Request Methode</b></div>'
    append = append + '        <div class="mb-2">'+ item.request_method +'</div>'
    append = append + '        <div class="mb-2">'+ moment(item.created_at).format('DD MMMM') +'</div>'
    if (type_of_letter == 'EPR') {
      append = append + '        <div class="mb-2"><b>Project Id</b></div>'
      append = append + '        <div class="mb-2">'+ item.pid +'</div>'
      append = append + '        <div class="mb-2"><b>Quote Number</b></div>'
      append = append + '        <div class="mb-2">'+ item.quote_number +'</div>'
    }
    append = append + '    </div>'
    append = append + '</div>'
    append = append + '</div>'
    append = append + '<hr id="hr_pembanding" data-value="'+i+'" style="display:none">'
    append = append + '<div id="bodyPreviewPembanding" data-value="'+i+'" style="display:none;overflow:auto" class="table-responsive">'
      append = append + '<table class="table no-wrap">'
        append = append + '<thead>'
          append = append + '<th>No</th>'
          append = append + '<th width="20%">Product</th>'
          append = append + '<th width="40%">Description</th>'
          append = append + '<th width="5%">Qty</th>'
          append = append + '<th width="5%">Type</th>'
          append = append + '<th width="15%">Price</th>'
          append = append + '<th width="15%">Total Price</th>'
        append = append + '</thead>'
        append = append + '<tbody>'
        var noProduct = 0
          $.each(item.product,function(value,item){
            noProduct++
            append = append + '<tr>'
              append = append + '<td>'
                append = append + '<span>'+ noProduct +'</span>'
              append = append + '</td>'
              append = append + '<td>'
              append = append + "<input data-value='' disabled style='width:200px;font-size: 12px; important' class='form-control' type='' name='' value='"+ item.name_product + "'>"
              append = append + '</td>'
              append = append + '<td>'
                append = append + '<textarea style="width:-webkit-fill-available;font-size:12px;height:150px;resize:none" class="form-control" disabled>' + item.description.replaceAll("<br>","\n") + '&#10;&#10;SN : ' + item.serial_number + '&#10;PN : ' + item.part_number + '</textarea>'
              append = append + '</td>'
              append = append + '<td>'
                append = append + '<input disabled class="form-control" type="" name="" value="'+ item.qty +'" style="width:70px;;font-size:12px">'
              append = append + '</td>'
              append = append + '<td>'
                append = append + '<select disabled class="form-control" style="width:80px;font-size:12px">'
                append = append + '<option>'+ item.unit.charAt(0).toUpperCase() + item.unit.slice(1) +'</option>'
                append = append + '</select>'
              append = append + '</td>'
              append = append + '<td>'
                append = append + '<input disabled class="form-control" type="" name="" value="'+ formatter.format(item.nominal_product) +'" style="width:100px;font-size:12px">'
              append = append + '</td>'
              append = append + '<td>'
                append = append + '<input disabled class="form-control" data-value="'+i+'" id="grandTotalPricePembanding" type="" name="" value="'+ formatter.format(item.grand_total) +'" style="width:100px;font-size:12px">'
              append = append + '</td>'
            append = append + '</tr>'
          })
        append = append + '</tbody>'
      append = append + '</table>'
    append = append + '</div>'
    append = append + '<div id="bottomPreviewPembanding" data-value="'+i+'" style="display:none">'
    append = append + '<hr>'
    append = append + '  <div class="row">'
    append = append + '    <div class="col-md-12 col-xs-12">'
    append = append + '      <div class="col-md-6 ms-auto">'
    append = append + '        <div class="form-group">'
    append = append + '          <label>Note Pembanding</label>'
    append = append + '           <textarea disabled class="form-control" style="resize:none;overflow-y:scroll" id="note_pembandingView" rows="4" data-value="'+i+'"></textarea>'
    append = append + '        </div>'
    append = append + '      </div>'
    append = append + '      <div class="col-md-6 ms-auto col-xs-12">'
    append = append + '    <form class="form-horizontal">'
    append = append + '      <div class="form-group">'
    append = append + '         <div class="row">'
    append = append + '            <label for="inputEmail3" class="col-sm-4 control-label">Total</label>'
    append = append + '            <div class="col-sm-8">'
    append = append + '              <input disabled type="text" class="form-control inputGrandTotalProductPembanding" id="inputGrandTotalProductPembanding" data-value="'+i+'" style="text-align:right">'
    append = append + '            </div>'
    append = append + '         </div>'
    append = append + '      </div>'

    append = append + '          <div class="form-group">'
    append = append + '           <div class="row">'
      append = append + '            <label for="inputDiscountPembanding" class="col-sm-4 control-label">Discount <span class="title_discount_pembanding" data-value="'+i+'"></span></label>'
      append = append + '            <div class="col-sm-8">'
      append = append + '              <input disabled type="text" class="form-control inputDiscountPembanding" style="text-align:right" id="inputDiscountPembanding" data-value="'+i+'">'
      append = append + '            </div>'
    append = append + '            </div>'
    append = append + '           </div>'

    append = append + '          <div class="form-group">'
    append = append + '           <div class="row">'
    append = append + '            <label for="inputEmail4" class="col-sm-4 control-label"> Tax Base Other</label>'
    append = append + '            <div class="col-sm-8">'
    append = append + '              <input disabled type="text" class="form-control tax_base_other_pembanding_preview_detail" style="text-align:right" id="tax_base_other_pembanding_preview_detail" data-value="'+i+'">'
    append = append + '            </div>'
    append = append + '          </div>'
    append = append + '          </div>'

    append = append + '          <div class="form-group">'
    append = append + '           <div class="row">'
    append = append + '            <label for="inputEmail4" class="col-sm-4 control-label">Vat <span class="title_tax_pembanding"></span></label>'
    append = append + '            <div class="col-sm-8">'
    append = append + '              <input disabled type="text" class="form-control vat_tax" style="text-align:right" id="vat_tax_pembanding" data-value="'+i+'">'
    append = append + '            </div>'
    append = append + '           </div>'
    append = append + '          </div>'

    append = append + '          <div class="form-group">'
    append = append + '           <div class="row">' 
      append = append + '            <label for="inputPb1Pembanding" class="col-sm-4 control-label">PB1 <span class="title_pb1_pembanding" data-value="'+i+'"></span></label>'
      append = append + '            <div class="col-sm-8">'
      append = append + '              <input disabled type="text" class="form-control inputPb1Pembanding" style="text-align:right" id="inputPb1Pembanding" data-value="'+i+'">'
      append = append + '            </div>'
    append = append + '            </div>'
    append = append + '          </div>'

    append = append + '          <div class="form-group">'
      append = append + '           <div class="row">' 
      append = append + '            <label for="inputServiceChargePembanding" class="col-sm-4 control-label">Service Charge <span class="title_service_pembanding" data-value="'+i+'"></span></label>'
      append = append + '            <div class="col-sm-8">'
      append = append + '              <input disabled type="text" class="form-control inputServiceChargePembanding" style="text-align:right" id="inputServiceChargePembanding" data-value="'+i+'">'
      append = append + '            </div>'
      append = append + '            </div>'
    append = append + '          </div>'

    append = append + '          <div class="form-group">'
    append = append + '           <div class="row">' 
    append = append + '            <label for="inputEmail5" class="col-sm-4 control-label">Grand Total</label>'
    append = append + '            <div class="col-sm-8">'
    append = append + '              <input disabled type="text" class="form-control inputFinalPageTotalPricePembanding" id="inputFinalPageTotalPricePembanding" data-value="'+i+'" style="text-align:right">'
    append = append + '            </div>'
    append = append + '           </div>'
    append = append + '          </div>'

    append = append + '        </form>'
    append = append + '      </div>'
    append = append + '    </div>'
    append = append + '  </div>'
    append = append + '<hr>'
    append = append + '<div class="card mb-4">'
      append = append + '<div class="card-header with-border" style="display:block ruby">'
        append = append + '<h6 class="card-title" style="margin-top:15px">Terms & Condition</h6>'
        append = append + '<div class="card-tools pull-right">'
            append = append + '<button type="button" class="btn btn-sm btn-card-tool btnTerm mt-1" onclick="btnTerm('+ i +')" data-value="'+i+'"><span class="bx bx-lg bx-chevron-right"></span>'
            append = append + '</button>'
          append = append + '</div>'
        append = append + '</div>'
        append = append + '<div class="card-body collapse" id="bodyCollapse" data-value="'+i+'">'
         append = append + '<div class="form-control" disabled id="termPreviewPembanding" data-value="'+i+'" style="width: 100%; height: 100%; font-size: 12px; line-height: 18px; border: 1px solid rgb(221, 221)"></div>'
      append = append + '</div>'
    append = append + '</div>'
    append = append + '<hr>'
    append = append + '<span><b>Attached Files</b></span>'
    var pdf = "bx bx-fw bxs-file-pdf"
    var image = "bx bx-fw bxs-file-image"
    
    if (item.document.length > 0) {
      if (item.document[0].dokumen_location.split(".")[1] == 'pdf') {
        var fa_doc = pdf
      }else{
        var fa_doc = image
      }

      if (type_of_letter == 'IPR') {
        append = append + '<div class="form-group" style="font-size: reguler;">'
          append = append + '<div class="row">'
            append = append + '<div class="col-md-6">'
              append = append + '<div style="border: 1px solid #dee2e6 !important;padding: 5px;"><a href="'+item.document[0].link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.document[0].dokumen_location.substring(0,15) + '....'+ item.document[0].dokumen_location.split(".")[0].substring(item.document[0].dokumen_location.length -10) + "." + item.document[0].dokumen_location.split(".")[1] +'</a>'
              append = append + '</div>'
            append = append + '</div>'
            append = append + '<div class="col-md-6">'
              append = append + '<div style="padding: 5px;">Penawaan Harga</div>'
            append = append + '</div>'
          append = append + '</div>'
        append = append + '</div>'
        
        $.each(item.document,function(value,item){
          if (item.dokumen_location.split(".")[1] == 'pdf') {
            var fa_doc = pdf
          }else{
            var fa_doc = image
          }

          
          if (value != 0) {
            
            append = append + '<div class="form-group" style="font-size: reguler;">'
              append = append + '<div class="row">'
                append = append + '<div class="col-md-6">'
                  append = append + '<div style="border: 1px solid #dee2e6 !important;padding: 5px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
                  append = append + '</div>'
                append = append + '</div>'
                append = append + '<div class="col-md-6">'
                  append = append + '<div style="padding: 5px;">Dokumen Pendukung : &nbsp'+ item.dokumen_name +'</div>'
                append = append + '</div>'
              append = append + '</div>'
            append = append + '</div>'
          }        
        })
      }else{        
        $.each(item.document,function(value,item){
          if (item.dokumen_location.split(".")[1] == 'pdf') {
              var fa_doc = pdf
            }else{
              var fa_doc = image
            }
            append = append + '<div class="form-group" style="font-size: reguler;">'
              append = append + '<div class="row">'
                append = append + '<div class="col-md-6">'
                  append = append + '<div style="border: 1px solid #dee2e6 !important;padding: 5px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1]+'</a>'
                  append = append + '</div>'
                append = append + '</div>'
                append = append + '<div class="col-md-6">'
                  append = append + '<div style="padding: 5px;">Dokumen &nbsp'+ item.dokumen_name +'</div>'
                append = append + '</div>'
              append = append + '</div>'
            append = append + '</div>'      
        })
      }
    }
    
    append = append + '</div>'
    append = append + '</div>'
    append = append + '</div>'
    append = append + '</div>'
    $("#divPembanding").append(append)  

    if (item.status == 'Selected') {
      $(".statusComparison[data-value='" + i + "']").text(item.status)
      $(".statusComparison[data-value='" + i + "']").show()
      $(".statusComparisonSubmit").text("Unselect")
      $(".statusComparisonSubmit").show()
      $("#cbPriority[data-value='" + i + "']").prop('checked',true)
      // $("#cbPriority[data-value='" + i + "']").prop('disabled',true)
      $("#cbPriority[data-value='" + i + "']").click(function() { return false; });
    }else{
      $(".statusComparison[data-value='" + i + "']").attr('style','display:none!important')
      $(".statusComparisonSubmit").attr('style','display:none!important')
    }

    $("input#cbPriority").on('change', function() {
      if (this.checked) {
        localStorage.setItem(isLastStorePembanding,false)
        Swal.fire({
          title: 'Are you sure?',  
          text: "Selecting '"+ $(this).closest('div.card-header').find("label").first().text() +"'" ,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }).then((result) => {
          if (result.value) {
            $(".cbPriority").prop("checked",false)
              $.ajax({
              type: "POST",
              url: "{{url('/admin/choosedComparison')}}",
              data: {
                _token: "{{ csrf_token() }}",
                no_pr:this.value.split(",")[0],
                status:this.value.split(",")[1],
                id_draft_pr:this.value.split(",")[2],
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
          }else{
            $(this).prop("checked",false)
          }
        })
      }
    });

    $("#termPreviewPembanding[data-value='" + i + "']").html(item.term_payment)

    $("#note_pembandingView[data-value='" + i + "']").html(item.note_pembanding) 

    var tempVat = 0
    var tempPb1 = 0
    var tempService = 0
    var tempDiscount = 0
    var finalVat = 0
    var tempGrand = 0
    var finalGrand = 0
    var tempTotal = 0
    var sum = 0

    $("#grandTotalPricePembanding[data-value='" + i + "']").each(function() {
        var temp = parseFloat($(this).val() == "" ? "0" : parseFloat($(this).val().replace(/\./g,'').replace(',','.').replace(' ','')))
        sum += temp;
    });


    if (item.status_tax == false) {
      valueVat = 'false'
    }else{
      valueVat = item.status_tax
    }
    // btnVatStatus = true
    localStorage.setItem('status_tax',valueVat)

    $('.inputTotalPriceEdit').each(function() {
        var temp = parseFloat($(this).val() == "" ? "0" : parseFloat($(this).val().replace(/\./g,'').replace(',','.').replace(' ','')))
        sum += temp;
    });

    if (!isNaN(valueVat)) {
      tempVat = item.discount == 'false' ? Math.round(((parseFloat(sum)) * (valueVat == false?0:parseFloat(valueVat) / 100))) : Math.round(((parseFloat(sum) - (parseFloat(sum) * parseFloat(item.discount)/100)) * (valueVat == false?0:parseFloat(valueVat) / 100)))

      finalVat = tempVat

      tempGrand = Math.round((parseFloat(sum) +  parseFloat((parseFloat(sum) * parseFloat(valueVat)) / 100)))

      finalGrand = tempGrand

      tempTotal = sum

      if (valueVat == 11) {
        valueVat = 12
      }else if (valueVat == 1.1) {
        valueVat = 1.2
      }else{
        valueVat = valueVat
      }

      $('.title_tax_pembanding').text(valueVat + '%')
    }else{
      tempVat = 0

      tempGrand = sum

      $('.title_tax_pembanding').text("")
    }

    $(".title_pb1_pembanding[data-value='" + i + "']").text(item.tax_pb == 'false'?"":item.tax_pb+"%")
    $(".title_service_pembanding[data-value='" + i + "']").text(item.service_charge == 'false'?"":item.service_charge+"%")
    $(".title_discount_pembanding[data-value='" + i + "']").text(item.discount == 'false'?"":parseFloat(item.discount).toFixed(2)+"%")

    tempDiscount = Math.round(tempTotal * (item.discount == null || item.discount == 'false'?0:parseFloat(item.discount) / 100))

    tempPb1 = Math.round(((parseFloat(sum) - tempDiscount) * (item.tax_pb == 'false'?tempPb1:parseFloat(item.tax_pb) / 100)))
    tempService = Math.round(((parseFloat(sum) - tempDiscount) * (item.service_charge == 'false'?tempService:parseFloat(item.service_charge) / 100)))
    // finalGrand = tempGrand + tempPb1 + tempService - tempDiscNominal

    $("#vat_tax_pembanding[data-value='" + i + "']").val(formatter.format(tempVat))
    $("#inputGrandTotalProductPembanding[data-value='" + i + "']").val(formatter.format(sum))
    $("#inputPb1Pembanding[data-value='" + i + "']").val(formatter.format(tempPb1))
    $("#inputServiceChargePembanding[data-value='" + i + "']").val(formatter.format(tempService))
    $("#inputDiscountPembanding[data-value='" + i + "']").val(formatter.format(tempDiscount))
    $("#inputFinalPageTotalPricePembanding[data-value='" + i + "']").val(formatter.format(item.nominal))
    $("#tax_base_other_pembanding_preview_detail[data-value='" + i + "']").val(formatter.format(customRound(formatter.format((sum - tempDiscount)*11/12))))

    if (item.tax_pb == 'false') {
      $("#inputPb1Pembanding[data-value='"+ i +"']").closest('.form-group').attr('style','display:none!important')
    }else{
      $("#inputPb1Pembanding[data-value='"+ i +"']").closest('.form-group').show()
    }

    if (item.service_charge == 'false') {
      $("#inputServiceChargePembanding[data-value='"+ i +"']").closest('.form-group').attr('style','display:none!important')
    }else{
      $("#inputServiceChargePembanding[data-value='"+ i +"']").closest('.form-group').show()
    }

    if (item.discount == 'false') {
      $("#inputDiscountPembanding[data-value='"+ i +"']").closest('.form-group').attr('style','display:none!important')
    }else{
      $("#inputDiscountPembanding[data-value='"+ i +"']").closest('.form-group').show()
    }

    accesable.forEach(function(item,index){
      $("." + item).show()
    })

    getActivityTask(i)
  }

  function getActivityTask(i){
    $.ajax({
      type: "GET",
      url: "{{url('/admin/getActivity')}}",
      data: {
        no_pr: window.location.href.split("/")[5],
      },
      success: function(result) {
        if (result[2].isCircular == 'True') {
          if (result[3] != null) {
            if (result[3].position != "VP Supply Chain, CPS & Asset Management") {
              //btn pembanding di procurement disabled
              $("#btnAddPembanding").prop('disabled',true)
              $("#cbPriority[data-value='" + i + "']").prop('disabled',true)
              $(".cbDraft").prop('disabled',true)
              $(".cbPriority").css('cursor','not-allowed')
              $(".cbDraft").css('cursor','not-allowed')     
            }
          }else{
            //btn pembanding di procurement disabled
              $("#btnAddPembanding").prop('disabled',true)
              $("#cbPriority[data-value='" + i + "']").prop('disabled',true)
              $(".cbDraft").prop('disabled',true)
              $(".cbPriority").css('cursor','not-allowed')
              $(".cbDraft").css('cursor','not-allowed') 
          }
          
        }  
      }
    })
  }
  

  function btnTerm(i){
    if ($("#bodyCollapse[data-value='" + i + "']").is(':visible') == true) {
      $("#bodyCollapse[data-value='" + i + "']").hide("slow")
      $(".btnTerm[data-value='" + i + "']").find('span').removeClass("bx-chevron-down").addClass("bx-chevron-right")

    }
    if ($("#bodyCollapse[data-value='" + i + "']").is(':hidden') == true){
      $("#bodyCollapse[data-value='" + i + "']").show("slow")
      $(".btnTerm[data-value='" + i + "']").find('span').removeClass("bx-chevron-right").addClass("bx-chevron-down")

    }
  }

  function btnMinus(i){
    if ($("#bottomPreviewPembanding[data-value='" + i + "']").is(':visible') == true) {
      $("#bottomPreviewPembanding[data-value='" + i + "']").hide('slow')
      $("#bodyPreviewPembanding[data-value='" + i + "']").hide('slow')
      $("#bodyCollapse[data-value='" + i + "']").hide("slow")
      $("#hr_pembanding[data-value='" + i + "']").hide('slow')
      $(".btnMinus[data-value='pembanding_" + i + "']").find('span').removeClass("bx-chevron-down").addClass("bx-chevron-right")
    }
    if ($("#bottomPreviewPembanding[data-value='" + i + "']").is(':hidden') == true){
      $("#bottomPreviewPembanding[data-value='" + i + "']").show('slow')
      $("#bodyPreviewPembanding[data-value='" + i + "']").show('slow')
      $("#hr_pembanding[data-value='" + i + "']").show('slow')
      $(".btnMinus[data-value='pembanding_" + i + "']").find('span').removeClass("bx-chevron-right").addClass("bx-chevron-down")
    }
  }  

  function btnMinusNotes(i){
    if ($("#bodyCollapse[data-value='" + i + "']").is(':visible') == true) {
      $("#bodyCollapse[data-value='" + i + "']").hide("slow")

    }
    if ($("#bodyCollapse[data-value='" + i + "']").is(':hidden') == true){
      $("#bodyCollapse[data-value='" + i + "']").show("slow")

    }
  }

  function sirkulasi(n){
    if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Procurement & Vendor Management')->exists()}}") {
      $.ajax({
        type: "GET",
        url: "{{url('/admin/getCountComparing')}}",
        data: {
          no_pr:window.location.href.split("/")[5],
        },
        success: function(result) {
          var x = document.getElementsByClassName("tab-sirkulasi");
          x[n].style.display = "inline";

          //nnti juga kasih rolenya siapa
          if (result > 0) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Circulating this PR",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                  $.ajax({
                    url: "{{'/admin/circulerPr'}}",
                    type: 'post',
                    data:{
                      _token:"{{ csrf_token() }}",
                      no_pr:window.location.href.split("/")[5],
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
                    success: function(data)
                    {
                      Swal.showLoading()
                      Swal.fire(
                          'Circulating PR Success by Admin/procurement!',
                          'PR will be signed soon, please wait for further progress',
                          'success'
                      ).then((result) => {
                          if (result.value) {
                            location.reload()
                          }
                      })
                    }
                  });
                }
            })
            
          }else{
            $("#ModalSirkulasiPr").modal('show')  
            $(".modal-dialog").removeClass('modal-lg')
            if (n == 0) {
              $("#nextBtnSirkulasi").click(function(){
                if ($("#reasonNoPembanding").val() == "") {
                  $("#reasonNoPembanding").closest('.form-group').addClass('needs-validation')
                  $("#reasonNoPembanding").closest('textarea').next('span').show();
                  $("#reasonNoPembanding").prev('.input-group-text').css("background-color","red");
                }else{
                  $.ajax({
                    url: "{{'/admin/circulerPrTanpaPembanding'}}",
                    type: 'post',
                    data:{
                      _token:"{{ csrf_token() }}",
                      no_pr:window.location.href.split("/")[5],
                      reason:$("#reasonNoPembanding").val()
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
                    success: function(data)
                    {
                      Swal.showLoading()
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
                  });
                }
                
              })
            }
          }
        }  
      })
    }else{
      $("#ModalSirkulasiPr").modal('show')
      $(".modal-dialog").addClass('modal-lg')

      n = 1
      currentTab = 0
      var x = document.getElementsByClassName("tab-sirkulasi");
      x[n].style.display = "inline";
      x[currentTab].style.display = "none";
      currentTab = currentTab + n;
      if (currentTab >= x.length) {
        x[n].style.display = "none";
        currentTab = 0;
      }
      $.ajax({
        type: "GET",
        url: "{{url('/admin/getDetailPr')}}",
        data: {
          no_pr:window.location.href.split("/")[5],
        },
        success: function(result) {
          var append = ""
          var i = 0
          $("#bodyPreviewSirkulasi").empty()

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
                append = append + '<textarea style="font-size: 12px; important;height:150px;resize:none" class="form-control" disabled>' + item.description.replaceAll("<br>","\n") + '&#10;&#10;SN : ' + item.serial_number + '&#10;PN : ' + item.part_number + '</textarea>'
              append = append + '</td>'
              append = append + '<td width="10%">'
                append = append + '<input class="form-control" type="" name="" value="'+ item.qty +'" style="width:70px;font-size:12px" disabled>'
              append = append + '</td>'
              append = append + '<td width="10%">'
                append = append + '<select style="width:80px;font-size:12px" class="form-control" disabled>'
                append = append + '<option>' + item.unit.charAt(0).toUpperCase() + item.unit.slice(1) + '</option>'
                append = append + '</select>'
              append = append + '</td>'
              append = append + '<td width="15%">'
                append = append + '<input class="form-control" type="" name="" value="'+ formatter.format(item.nominal_product) +'" style="width:100px;font-size:12px" disabled>'
              append = append + '</td>'
              append = append + '<td width="15%">'
                append = append + '<input class="form-control" type="" name="" value="'+ formatter.format(item.grand_total) +'" style="width:100px;font-size:12px" disabled>'
              append = append + '</td>'
            append = append + '</tr>'
          })

          $("#bodyPreviewSirkulasi").append(append) 

          $("#bottomPreviewSirkulasi").empty()

          appendBottom = ""
          appendBottom = appendBottom + '<hr>'
          appendBottom = appendBottom + '<span style="display:block;text-align:center"><b>Terms & Condition</b></span>'
          appendBottom = appendBottom + '<div id="textareaTOP" disabled class="form-control" style="width: 100%; height: 200px; font-size: 12px; line-height: 18px; border: 1px solid rgb(221, 221, 221);overflow:auto"></div>'

          $("#bottomPreviewSirkulasi").append(appendBottom) 

          $("#textareaTOP").html(result.pr.term_payment) 
        }
      })
    }
  }

  function finalize(reqMethode){
    if (reqMethode == 'Purchase Order') {
      $("#showDetail").empty()
      showEmail(reqMethode)
      localStorage.setItem('isEmail',true)
    }else{
      sendOpenEmail('sended')
    }
  }

  // $('#bodyOpenMail').slimScroll({
  //   height: '600px'
  // });

  // $('#table-produk').slimScroll({
  //   width: '600px'
  // });



  function showEmail(reqMethode){
    //restart arr reason
    arrReason = []
    append = ""
    append = append + '<div class="col-md-12">'
      append = append + '<div class="card mb-4">'
        append = append + '<div class="card-body">'
          append = append + '<div class="form-horizontal">'
            append = append + '<div class="form-group">'
              append = append + '<label class="col-sm-1 control-label">'
                append = append + 'To : '
              append = append + '</label>'
              append = append + '<div class="col-sm-11">'
                append = append + '<input class="form-control" name="emailTo" id="emailOpenTo">'
              append = append + '</div>'
              append = append + '<div class="col-sm-11 col-sm-offset-1 invalid-feedback" style="margin-bottom: 0px;">'
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
                  append = append + '<button class="btn btn-sm btn-flat text-bg-primary pull-right" style="display:inline" onclick="sendOpenEmail()"><i class="bx bx-envelope"></i> Send</button>'
                append = append + '</div>'
              append = append + '</div>'
            append = append + '</div>'
          append = append + '</div>'
        append = append + '</div>'
      append = append + '</div>'      
    append = append + '</div>'

    $("#showDetail").append(append)
    if (reqMethode == "Purchase Order") {
      createEmailBody('Elen Tania Ciputri')
    }else if (reqMethode == "Reimbursement") {
      createEmailBody('Clara Keneyzia')
    }else{
      createEmailBody('-')
    }
  }

  function createEmailBody(user){
    $('.emailMultiSelector').remove()
    
    $.ajax({
      url:"{{url('/admin/getEmailTemplate')}}",
      data:{
        no_pr:window.location.href.split("/")[5],
      },
      type:"GET",
      success: function (result){
        if (user == 'Elen Tania Ciputri') {
          $("#bodyOpenMail").html("<span style='font-family: Lucida Sans Unicode, sans-serif;'>Dear <b>"+ user +"</b></span><br><br><span style='font-family: Lucida Sans Unicode, sans-serif;'>Berikut Terlampir PR, Mohon untuk dibuatkan PO dengan detail berikut:</span><br><br>" + result)   
        }else if (user == 'Clara Keneyzia') {
          $("#bodyOpenMail").html("<span style='font-family: Lucida Sans Unicode, sans-serif;'>Dear <b>"+ user +"</b></span><br><br><span style='font-family: Lucida Sans Unicode, sans-serif;'>Berikut Terlampir PR, Mohon dilakukan pembayaran dengan detail berikut:</span><br><br>" + result)   
        }   
      }
    })

    $.ajax({
      type:"GET",
      url:"{{url('/admin/getDataSendEmail')}}",
      data:{
        no_pr:window.location.href.split("/")[5],
        user:user,
      },
      success: function(result){
        arrEmailCc = []
        arrEmailTo = []
        $.each(result.cc,function(value,item){
          
          arrEmailCc.push(item.email)
        })
        $.each(result.to,function(value,item){
          
          arrEmailTo.push(item.email)
        })
        arrEmailCcJoin = arrEmailCc.filter(function(i) {
            if (i != null || i != false)
                return i;
        }).join(";")
        arrEmailToJoin = arrEmailTo.filter(function(i) {
            if (i != null || i != false)
                return i;
        }).join(";")
       
        $("#emailOpenTo").val(arrEmailToJoin)
        $("#emailOpenCc").val(arrEmailCcJoin)
        $("#emailOpenSubject").val(result.subject);
      },complete: function(){
        $("#emailOpenTo").emailinput({ onlyValidValue: true, delim: ';' });
        $("#emailOpenCc").emailinput({ onlyValidValue: true, delim: ';' });
      }
    })
  }

  function sendOpenEmail(status=''){
    if (status == 'sended') {
      text = 'PR has been processed'
    }else{
      text = 'Email Sended'
    }
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
            url: "{{url('/admin/sendMailtoFinance')}}",
            data: {
              _token: "{{ csrf_token() }}",
              no_pr:window.location.href.split("/")[5],
              status:status,
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
                title: 'Successfully!',
                text: "Document has been circulated.",
                icon: 'success',
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
      text: "Circular this Process!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
          $("#ModalSirkulasiPr").modal("hide")
          $.ajax({
            type:"POST",
            url:"{{url('/admin/submitTtdApprovePR')}}",
            data:{
              _token:"{{ csrf_token() }}",
              no_pr:window.location.href.split("/")[5]
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
                  'Document has been circulated.',
                  'success'
              ).then((result) => {
                location.reload()
              })
            },
            error: function(resultAjax,errorStatus,errorMessage){
              Swal.hideLoading()
              Swal.fire({
                title: 'Successfully!',
                text: "Document has been circulated.",
                icon: 'success',
              }).then((result) => {
                location.reload()
              })
            }
          })          
        }
    })
    // $.ajax({
    //   type:"GET",
    //   url:"{{url('/admin/cekTTD')}}",
    //   data:{
    //     nik:"{{Auth::User()->nik}}",
    //   },
    //   success: function(result){
    //     if (result.ttd == null) {
    //       $("#ModalUploadNewTTD").modal("show")
    //     }else{
    //       $("#ModalAcceptSirkulasi").modal("show")
    //       $("#TTD").attr("src","{!! asset('"+result.ttd+"')!!}")
    //     }
    //   }
    // })
  })

  $("#btnReject").click(function(){
    $("#ModalSirkulasiPr").modal("hide")
    $(".modal-dialog").removeClass("modal-lg")
    $("#ModalRejectSirkulasi").modal("show")
  })

  $('#ModalSirkulasiPr').on('hidden.bs.modal', function () {
    $(".tab-sirkulasi").css('display','none')
    currentTab = 0
    n = 0
  })

  $('#ModalDraftPr').on('hidden.bs.modal', function () {
    $(".tab-add").css('display','none')
    currentTab = 0
    n = 0
  }) 

  $("#btnUploadNewTTD").click(function(){
    $("#ModalAcceptSirkulasi").modal("hide")
    $("#ModalUploadNewTTD").modal("show")
  })

  // $("#textAreaTOP").wysihtml5();
  snowEditor = new Quill('#snow-editor', {
    bounds: '#snow-editor',
    modules: {
      formula: true,
      toolbar: '#snow-toolbar'
    },
    theme: 'snow'
  });
  
  function addPembanding(){
    currentTab = 0
    addDraftPrPembanding(0)
  }

  const firstLaunch = localStorage.setItem('firstLaunch',true)

  function addDraftPrPembanding(n){
    localStorage.setItem('status_tax',false)
    localStorage.setItem('isStoreSupplier',false)
    var x = document.getElementsByClassName("tab-add");
    x[n].style.display = "inline";
    if (n == (x.length - 1)) {
      $(".modal-dialog").addClass('modal-lg')
      $("#prevBtnAdd").attr('onclick','nextPrevAddPembanding(-1)')        
      $("#nextBtnAdd").attr('onclick','nextPrevAddPembanding(1)')
      $(".modal-title").text('')
      document.getElementById("prevBtnAdd").style.display = "inline";
      $("#headerPreviewFinal").empty()
      
      document.getElementById("nextBtnAdd").innerHTML = "Create";
      $("#nextBtnAdd").attr('onclick','createPRPembanding()');  

      $.ajax({
        type: "GET",
        url: "{{url('admin/getPreviewPembanding')}}",
        data: {
            no_pr:localStorage.getItem('no_pembanding'),
        },
        success: function(result) {
          if (result.pr.type_of_letter  == 'IPR') {
            PRType = '<b>Internal Purchase Request</b>'
          }else{
            PRType = '<b>External Purchase Request</b>'
          }

          var appendHeader = ""
          appendHeader = appendHeader + '<div class="row">'
          appendHeader = appendHeader + '    <div class="col-md-6">'
          appendHeader = appendHeader + '        <div class="mb-2">To: '+ result.pr.to +'</div>'
          appendHeader = appendHeader + '        <div class="mb-2">Email: ' + result.pr.email + '</div>'
          appendHeader = appendHeader + '        <div class="mb-2">Phone: ' + result.pr.phone + '</div>'
          appendHeader = appendHeader + '        <div class="mb-2">Fax: '+ result.pr.fax +' </div>'
          appendHeader = appendHeader + '        <div class="mb-2">Attention: '+ result.pr.attention +'</div>'
          appendHeader = appendHeader + '        <div class="mb-2">From: '+ result.pr.name +'</div>'
          appendHeader = appendHeader + '        <div class="mb-2">Subject: '+ result.pr.title +'</div>'
          appendHeader = appendHeader + '        <div class="mb-2" style="width:fit-content;word-wrap: break-word;">Address: '+ result.pr.address +'</div>'

          appendHeader = appendHeader + '    </div>'
          if (window.matchMedia("(max-width: 768px)").matches)
          {
              appendHeader = appendHeader + '    <div class="col-md-6">'
              // The viewport is less than 768 pixels wide
              
          } else {
              appendHeader = appendHeader + '    <div class="col-md-6" style="text-align:end">'
              // The viewport is at least 768 pixels wide
              
          }
          appendHeader = appendHeader + '        <div class="mb-2">'+ PRType +'</div>'
          appendHeader = appendHeader + '        <div class="mb-2"><b>Request Methode</b></div>'
          appendHeader = appendHeader + '        <div class="mb-2">'+ result.pr.request_method +'</div>'
          appendHeader = appendHeader + '        <div class="mb-2">'+ moment(result.pr.created_at).format('DD MMMM') +'</div>'
          if (type_of_letter == 'EPR') {
            appendHeader = appendHeader + '        <div class="mb-2"><b>Project Id</b></div>'
            appendHeader = appendHeader + '        <div class="mb-2">'+ result.pr.pid +'</div>'
            appendHeader = appendHeader + '        <div class="mb-2"><b>Quote Number</b></div>'
            appendHeader = appendHeader + '        <div class="mb-2">'+ result.pr.quote_number +'</div>'
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
                append = append + '<textarea style="font-size: 12px; important;height:150px;resize:none" disabled class="form-control">' + item.description.replaceAll("<br>","\n") + '&#10;&#10;SN : ' + item.serial_number + '&#10;PN : ' + item.part_number + '</textarea>'
              append = append + '</td>'
              append = append + '<td width="10%">'
                append = append + '<input disabled class="form-control" type="" name="" value="'+ item.qty +'" style="width:70px;font-size: 12px; important">'
              append = append + '</td>'
              append = append + '<td width="10%">'
                append = append + '<select disabled style="width:75px;font-size: 12px; important" class="form-control">'
                append = append + '<option>' + item.unit.charAt(0).toUpperCase() + item.unit.slice(1) + '</option>'
                append = append + '</select>'
              append = append + '</td>'
              append = append + '<td width="15%">'
                append = append + '<input style="font-size: 12px; important" disabled class="form-control" type="" name="" value="'+ formatter.format(item.nominal_product) +'" style="width:100px">'
              append = append + '</td>'
              append = append + '<td width="15%">'
                append = append + '<input disabled class="form-control grandTotalPreviewPembandingModal" type="" name="" value="'+ formatter.format(item.grand_total) +'" style="width:100px;font-size: 12px; important">'
              append = append + '</td>'
            append = append + '</tr>'
          })

          $("#tbodyFinalPageProducts").append(append)

          $("#bottomPreviewFinal").empty()        
          appendBottom = ""
          appendBottom = appendBottom + '<hr>'
          appendBottom = appendBottom + '<div class="form-group">'
          appendBottom = appendBottom + '<div class="row">'
          appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
          appendBottom = appendBottom + '    <div class="pull-right">'
          appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Total</span>'
          appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;text-align:right" class="form-control inputGrandTotalProductPembandingModal" id="inputGrandTotalProductPembandingModal" name="inputGrandTotalProductPembandingModal">'
          appendBottom = appendBottom + '    </div>'
          appendBottom = appendBottom + '  </div>'
          appendBottom = appendBottom + '</div>'

          appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
            appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
            appendBottom = appendBottom + '    <div class="pull-right">'
            appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Discount <span class="title_discount"></span></span>'
            appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;text-align:right" class="form-control inputDiscountPembandingModal" id="inputDiscountPembandingModal" name="inputDiscountPembandingModal">'
            appendBottom = appendBottom + '    </div>'
            appendBottom = appendBottom + '  </div>'
          appendBottom = appendBottom + '</div>'

          appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
          appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
          appendBottom = appendBottom + '    <div class="pull-right">'
          appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Tax Base Other</span>'
          appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;text-align:right" class="form-control inputTaxBaseOtherPembandingModal" id="inputTaxBaseOtherPembandingModal" name="inputTaxBaseOtherPembandingModal">'
          appendBottom = appendBottom + '    </div>'
          appendBottom = appendBottom + '  </div>'
          appendBottom = appendBottom + '</div>'

          appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
          appendBottom = appendBottom + ' <div class="col-md-12 col-xs-12">'
          appendBottom = appendBottom + '   <div class="pull-right">'
            appendBottom = appendBottom + '   <span style="margin-right: 10px;display:inline">Vat <span class="title_tax"></span></span>'
            appendBottom = appendBottom + '       <input disabled type="text" class="form-control vat_tax" id="vat_tax_PembandingModal" name="vat_tax_PembandingModal" style="width:150px;text-align:right;display:inline">'
          appendBottom = appendBottom + '    </div>'
          appendBottom = appendBottom + ' </div>'
          appendBottom = appendBottom + '</div>'

          appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
            appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
            appendBottom = appendBottom + '    <div class="pull-right">'
            appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">PB1 <span class="title_pb1"></span></span>'
            appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;text-align:right" class="form-control inputPb1PembandingModal" id="inputPb1PembandingModal" name="inputPb1PembandingModal">'
            appendBottom = appendBottom + '    </div>'
            appendBottom = appendBottom + '  </div>'
          appendBottom = appendBottom + '</div>'
          appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
            appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
            appendBottom = appendBottom + '    <div class="pull-right">'
            appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Service Charge <span class="title_service"></span></span>'
            appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;text-align:right" class="form-control inputServiceChargePembandingModal" id="inputServiceChargePembandingModal" name="inputServiceChargePembandingModal">'
            appendBottom = appendBottom + '    </div>'
            appendBottom = appendBottom + '  </div>'
          appendBottom = appendBottom + '</div>'
          appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
            appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
            appendBottom = appendBottom + '    <div class="pull-right">'
            appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Grand Total</span>'
            appendBottom = appendBottom + '      <input disabled type="text" style="width:150px;display: inline;text-align:right" class="form-control inputFinalPageTotalPricePembandingModal" id="inputFinalPageTotalPricePembandingModal" name="inputFinalPageTotalPricePembandingModal">'
            appendBottom = appendBottom + '    </div>'
            appendBottom = appendBottom + '  </div>'
          appendBottom = appendBottom + '</div>'
          appendBottom = appendBottom + '</div>'
          appendBottom = appendBottom + '<hr>'
          appendBottom = appendBottom + '<span style="display:block;text-align:center"><b>Terms & Condition</b></span>'
          appendBottom = appendBottom + '<div class="form-control" id="termPreviewPembandingModal" style="width: 100%; height: 200px; font-size: 12px; line-height: 18px; border: 1px solid rgb(221, 221, 221);overflow:auto"></div>'
          appendBottom = appendBottom + '<hr>'
          appendBottom = appendBottom + '<span><b>Attached Files</b></span>'
          var pdf = "bx bx-fw bxs-file-pdf"
          var image = "bx bx-fw bxs-file-image"
          if (result.pr.type_of_letter == 'IPR') {
            appendBottom = appendBottom + '<div class="form-group" style="font-size: reguler;">'
              appendBottom = appendBottom + '<div class="row">'
                appendBottom = appendBottom + '<div class="col-md-6">'
                  appendBottom = appendBottom + '<div style="border: 1px solid #dee2e6 !important;padding: 10px;"><a href="'+result.dokumen[0].link_drive+'" target="blank"><i class="bx bx-fw bxs-file-pdf"></i>'+ result.dokumen[0].dokumen_location.substring(0,15) + '....'+ result.dokumen[0].dokumen_location.split(".")[0].substring(result.dokumen[0].dokumen_location.length -10) + "." + result.dokumen[0].dokumen_location.split(".")[1] +'</a>'
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
                      appendBottom = appendBottom + '<div style="border: 1px solid #dee2e6 !important;padding: 10px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
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
                      appendBottom = appendBottom + '<div style="border: 1px solid #dee2e6 !important;padding: 10px;"><a href="'+item.link_drive+'" target="blank"><i class="'+ fa_doc +'"></i>'+ item.dokumen_location.substring(0,15) + '....'+ item.dokumen_location.split(".")[0].substring(item.dokumen_location.length -10) + "." + item.dokumen_location.split(".")[1] +'</a>'
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

          $("#termPreviewPembandingModal").html(result.pr.term_payment.replaceAll("&lt;br&gt;","<br>"))

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

          $('.grandTotalPreviewPembandingModal').each(function() {
              var temp = parseFloat($(this).val() == "" ? "0" : parseFloat($(this).val().replace(/\./g,'').replace(',','.').replace(' ','')))
              sum += temp;
          });

          if (result.pr.status_tax == "false") {
            valueVat = ''
          }else{
            valueVat = result.pr.status_tax
          }
          
          // btnVatStatus = true
          finalVat = tempVat
          finalGrand = tempGrand
          localStorage.setItem('status_tax',valueVat)
          if (!isNaN(valueVat)) {
            tempVat = $("#inputDiscountNominal").val() == '' ? Math.round((parseFloat(sum)) * (valueVat == false?0:parseFloat(valueVat) / 100)) : Math.round((parseFloat(sum) - parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ',''))) * (valueVat == false?0:parseFloat(valueVat) / 100)) 
            // tempVat = Math.round((parseFloat(sum) * parseFloat(valueVat)) / 100)

            finalVat = tempVat

            tempGrand = parseInt(sum) +  tempVat

            finalGrand = tempGrand

            tempTotal = sum

            if (valueVat == 11) {
              valueVat = 12
            }else if (valueVat == 1.1) {
              valueVat = 1.2
            }else{
              valueVat = valueVat
            }

            $('.title_tax').text(valueVat == ''?'':valueVat + '%')
          }else{
            tempVat = 0

            tempGrand = sum

            $('.title_tax').text("")
          }

          tempDiscNominal = isNaN(parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ','')))?0:parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ',''))
          tempPb1 = Math.round(((parseFloat(sum) - tempDiscNominal)* (result.pr.tax_pb == 'false'?tempPb1:parseFloat(result.pr.tax_pb)) / 100))
          tempService = Math.round(((parseFloat(sum) - tempDiscNominal) * (result.pr.service_charge == 'false'?tempService:parseFloat(result.pr.service_charge)) / 100))

          console.log(tempGrand + 'tempgrand')
          console.log(tempPb1 + 'tempPb1')
          console.log(tempService + 'tempService')
          console.log(tempDiscNominal + 'tempDiscNominal')

          finalGrand = tempTotal + tempPb1 + tempService + tempVat - tempDiscNominal

          $('.title_pb1').text(result.pr.tax_pb == 'false' ?"":result.pr.tax_pb+"%")
          $('.title_service').text(result.pr.service_charge == 'false'?"":result.pr.service_charge+"%")
          $('.title_discount').text(result.pr.discount == 'false' || result.pr.discount == 0?"":parseFloat(result.pr.discount).toFixed(2)+"%")

          $("#vat_tax_PembandingModal").val(formatter.format(tempVat))
          $("#inputTaxBaseOtherPembandingModal").val(formatter.format(customRound(formatter.format((tempTotal - tempDiscNominal)*11/12))))

          $("#inputPb1PembandingModal").val(formatter.format(tempPb1))
          $("#inputServiceChargePembandingModal").val(formatter.format(tempService))
          $("#inputDiscountPembandingModal").val(formatter.format(tempDiscNominal))
          $("#inputGrandTotalProductPembandingModal").val(formatter.format(sum))
          $("#inputFinalPageTotalPricePembandingModal").val(formatter.format(finalGrand))
        }
      })
                    
    } else {
      if (n == 0) {
        $.ajax({
          url:"{{url('/admin/getSupplier')}}",
          type:"GET",
          success:function(result){
            console.log(result)
            $("#selectTo").select2({
              data:result,
              placeholder:"Select Supplier",
              dropdownParent:$("#ModalDraftPr")
            })
          }
        })

        $("#otherTo").click(function(){
          $("#divInputTo").show("slow")
        })

        $(".close").click(function(){
          $("#divInputTo").hide("slow")
        })

        $("#divNotePembanding").show()
        $("#selectType").attr("disabled",true)
        $("#selectCategory").attr("disabled",true)
        $("#selectMethode").attr("disabled",true)

        const firstLaunch = localStorage.getItem('firstLaunch')
        document.getElementById("prevBtnAdd").style.display = "none";
        $(".modal-title").text('Information Supplier')
        $(".modal-dialog").removeClass('modal-lg')

        $.ajax({
          type:"GET",
          url:"{{url('/admin/getPreviewPr')}}",
          data:{
            no_pr:window.location.href.split("/")[5]
          },success:function(result){
            $("#selectType").val(result.pr.type_of_letter)
            $("#selectCategory").val(result.pr.category)
            if (result.pr.request_method == 'Reimbursement') {
              $("#selectMethode").val('reimbursement')
            }else if (result.pr.request_method == 'Purchase Order') {
              $("#selectMethode").val('purchase_order')
            }else{
              $("#selectMethode").val('payment')
            }
            if(result.pr.type_of_letter == 'EPR'){
              localStorage.setItem('isPembandingEPR',true)
            }
          }
        })

        if (firstLaunch == 'true') {
          $("#nextBtnAdd").attr('onclick','nextPrevAddPembanding(1,'+ firstLaunch +')')
        }else{
          $("#nextBtnAdd").attr('onclick','nextPrevAddPembanding(2,'+ firstLaunch +')')
        }         
      }else if (n == 1) {
        select2TypeProduct()

        $(".modal-title").text('Information Product')
        $(".modal-dialog").removeClass('modal-lg')  
        $("#nextBtnAdd").attr('onclick','nextPrevAddPembanding(1)')
        $("#prevBtnAdd").attr('onclick','nextPrevAddPembanding(-1)')        
        document.getElementById("prevBtnAdd").style.display = "inline";
        $("#btnInitiateAddProduct").click(function(){
          $(".tabGroupInitiateAdd").attr('style','display:none!important')
          x[n].children[1].style.display = 'inline'

          localStorage.setItem('isProductInline',true)
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

      }else if(n == 2){
        $(".modal-title").text('')
        $("#nextBtnAdd").removeAttr('onclick')
        $(".modal-dialog").addClass('modal-lg')

        localStorage.setItem('firstLaunch',false)
        if (localStorage.getItem('firstLaunch') == 'false') {
          $("#prevBtnAdd").attr('onclick','nextPrevAddPembanding(-2)')
          $("#nextBtnAdd").attr('onclick','nextPrevAddPembanding(1)')
        }else{
          $("#prevBtnAdd").attr('onclick','nextPrevAddPembanding(-1)')
        } 
        document.getElementById("prevBtnAdd").style.display = "inline";
      }else if (n == 3) {
        $(".modal-dialog").removeClass('modal-lg')
        $.ajax({
          type: "GET",
          url: "{{url('/admin/getPreviewPembanding')}}",
          data: {
            no_pr:localStorage.getItem('no_pembanding'),
          },success:function(result){
            if (result.pr.type_of_letter == 'EPR') {
              $(".modal-title").text('External Purchase Request')
              $("#formForPrExternal").show()
              $("#formForPrInternal").attr('style','display:none!important')    
              $.ajax({
                type:"GET",
                url:"{{url('/admin/getPreviewPr')}}",
                data:{
                  no_pr:window.location.href.split("/")[5]
                },success:function(result){
                  var lead_id = result.pr.lead_id
                  var quote_number = result.pr.quote_number
                  var pid = result.pr.pid
                  $("#inputSPK").attr('disabled',true)
                  $("#inputSBE").attr('disabled',true)

                  $.ajax({
                    url: "{{url('/admin/getLead')}}",
                    type: "GET",
                    success: function(result) {
                      $("#selectLeadId").select2({
                        data: result.data,
                        placeholder: "Select Lead Register",
                        dropdownParent: $('#ModalDraftPr')
                      }).on('change', function() {
                        var data = $("#selectLeadId option:selected").text();
                        
                        $.ajax({
                          url: "{{url('/admin/getPid')}}",
                          type: "GET",
                          data: {
                            lead_id:data
                          },
                          success: function(result) {
                            $("#selectPid").select2({
                              data: result.data,
                              placeholder: "Select PID",
                              dropdownParent: $('#ModalDraftPr')
                            })

                            if (pid != "") {
                              $("#selectPid").val(pid).trigger("change").attr("disabled",true)      
                            }
                          }
                        }) 

                        $.ajax({
                          url: "{{url('/admin/getQuote')}}",
                          type: "GET",
                          data:{
                            lead_id:data
                          },
                          success: function(result) {
                            $("#selectQuoteNumber").select2({
                              data: result.data,
                              placeholder: "Select Quote Number",
                              dropdownParent: $('#ModalDraftPr')
                            })

                            if (quote_number != "") {
                              $("#selectQuoteNumber").val(quote_number).trigger("change").attr("disabled",true)
                            }
                          }
                        }) 
                      })

                      if (lead_id != "") {
                        $("#selectLeadId").val(lead_id).trigger("change").attr("disabled",true)
                      }
                    }
                  })

                  const fileSPK   = document.querySelector('input[type="file"][name="inputSPK"]');

                  const fileSBE   = document.querySelector('input[type="file"][name="inputSBE"]');

                  const fileQuote = document.querySelector('input[type="file"][name="inputQuoteSupplier"]');

                  if (result.dokumen.length > 0) {
                    if (result.dokumen[0] !== undefined) {
                      const myFileSpk = new File(['{{asset("/")}}"'+ result.dokumen[0].dokumen_location +'"'], '/'+ result.dokumen[0].dokumen_location,{
                          type: 'text/plain',
                          lastModified: new Date(),
                      });

                      // Now let's create a DataTransfer to get a FileList
                      const dataTransferSpk = new DataTransfer();
                      dataTransferSpk.items.add(myFileSpk);
                      fileSPK.files = dataTransferSpk.files;

                      if (result.dokumen[0].link_drive != null) {
                        $("#span_link_drive_spk").show()
                        $("#link_spk").attr("href",result.dokumen[0].link_drive) 
                      }
                    }

                    if (result.dokumen[1] !== undefined) {
                      const myFileSbe = new File(['{{asset("/")}}"'+ result.dokumen[1].dokumen_location +'"'], '/'+ result.dokumen[1].dokumen_location,{
                        type: 'text/plain',
                        lastModified: new Date(),
                      });
                      // Now let's create a DataTransfer to get a FileList
                      const dataTransferSbe = new DataTransfer();
                      dataTransferSbe.items.add(myFileSbe);
                      fileSBE.files = dataTransferSbe.files;

                      if (result.dokumen[1].link_drive != null) {
                        $("#span_link_drive_sbe").show()
                        $("#link_sbe").attr("href",result.dokumen[1].link_drive)
                      }
                    }

                    if(result.dokumen.splice(1).length > 0){
                      
                      $("#tableDocPendukung_epr").empty()
                      
                      $("#titleDoc_epr").css("display",'block')

                      appendDocPendukung = ""
                      $.each(result.dokumen,function(value,item){
                        if (value != 0 &&  value != 1 && value != 2) {
                          appendDocPendukung = appendDocPendukung + '<tr style="height:10px" class="trDocPendukung">'
                            appendDocPendukung = appendDocPendukung + "<td>"
                              appendDocPendukung = appendDocPendukung + '<button type="button" value="'+ item.id_dokumen +'" class="bx bx-x btnRemoveDocPendukung" data-value="remove_'+ value +'" style="display:inline;color:red;background-color:transparent;border:none"></button>&nbsp'
                                  appendDocPendukung = appendDocPendukung + '<div style="border: 1px solid #dee2e6 !important;padding: 5px;color: #337ab7;display: inline-block;width:200px;background-color:darkgrey;cursor:not-allowed">'
                                    appendDocPendukung = appendDocPendukung + "<input style='width: 90px;color:grey' type='file' name='inputDocPendukung' id='inputDocPendukung' data-value='"+ item.id_dokumen +"' class='inputDocPendukung_"+value+"' disabled>"
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
                    }
                  }
                }
              })              
              $("#makeId").attr('style','display:none!important')                 
            }else{
              $(".modal-title").text('Internal Purchase Request')
              $("#formForPrInternal").show()
              $("#formForPrExternal").attr('style','display:none!important') 

              $("#tableDocPendukung_ipr").empty()

              appendDocPendukung = ""
              $.each(result.dokumen,function(value,item){
                if (value != 0) {
                  appendDocPendukung = appendDocPendukung + '<tr style="height:10px" class="trDocPendukung">'
                    appendDocPendukung = appendDocPendukung + "<td>"
                      appendDocPendukung = appendDocPendukung + '<button type="button" value="'+ item.id_dokumen +'" class="bx bx-x btnRemoveDocPendukung" data-value="remove_'+ value +'" style="display:inline;color:red;background-color:transparent;border:none"></button>&nbsp'
                          appendDocPendukung = appendDocPendukung + '<div style="border: 1px solid #dee2e6 !important;padding: 5px;color: #337ab7;display: inline-block;width:200px;background-color:darkgrey;cursor:not-allowed">'
                            appendDocPendukung = appendDocPendukung + "<input style='width: 90px;color:grey' type='file' name='inputDocPendukung' id='inputDocPendukung' data-value='"+ item.id_dokumen +"' class='inputDocPendukung_"+value+"' disabled>"
                           appendDocPendukung = appendDocPendukung + '</div>'
                           appendDocPendukung = appendDocPendukung + "<br><a style='margin-left: 26px;font-family:Source Sans Pro,Helvetica Neue,Helvetica,Arial,sans-serif' href='"+ item.link_drive +"' target='_blank'><i class='bx bx-link'></i>&nbspLink drive</a>"
                    appendDocPendukung = appendDocPendukung + "</td>"
                    appendDocPendukung = appendDocPendukung + "<td>"
                      appendDocPendukung = appendDocPendukung + '<input style="width:250px;margin-left:20px" class="form-control inputNameDocPendukung_'+value+'" name="inputNameDocPendukung" id="inputNameDocPendukung" placeholder="ex : faktur pajak"><br>'
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
          }
        })

        $("#prevBtnAdd").attr('onclick','nextPrevAddPembanding(-1)')        
        $("#nextBtnAdd").attr('onclick','nextPrevAddPembanding(1)')
        document.getElementById("prevBtnAdd").style.display = "inline";
      }else if (n == 4) {
        $(".modal-title").text('Terms & Condition')   
        $(".modal-dialog").removeClass('modal-lg')   
        $("#prevBtnAdd").attr('onclick','nextPrevAddPembanding(-1)')        
        $("#nextBtnAdd").attr('onclick','nextPrevAddPembanding(1)')
        document.getElementById("prevBtnAdd").style.display = "inline";
      }
      document.getElementById("nextBtnAdd").innerHTML = "Next"
      $("#nextBtnAdd").prop("disabled",false)
      $("#addProduct").attr('onclick','nextPrevAddPembanding(-1)')
    }
    $("#ModalDraftPr").modal("show")  
  }

  function fillInput(val){
    if (val == "selectTo") {
        $("#selectTo").closest('.form-group').removeClass('needs-validation')
        $("#selectTo").closest('.form-group').find('.invalid-feedback').attr('style','display:none!important');
        $("#selectTo").prev('.input-group-text').css("background-color","red");
    }else if (val == "to") {
      $("#inputTo").closest('.divInputTo').closest('.form-group').removeClass('needs-validation')
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
        $("#inputEmail").closest('.form-group').removeClass('needs-validation')
        $("#inputEmail").closest('input').next('span').attr('style','display:none!important')
        $("#inputEmail").prev('.input-group-text').css("background-color","red")
      }else{
        switch(emails){
          case null:
            $("#inputEmail").closest('.form-group').addClass('needs-validation')
            $("#inputEmail").closest('input').next('span').show();
            $("#inputEmail").prev('.input-group-text').css("background-color","red");
            $("#inputEmail").closest('input').next('span').text("Enter a Valid Email Address!")
          break;
          default:
            $("#inputEmail").closest('.form-group').removeClass('needs-validation')
            $("#inputEmail").closest('input').next('span').attr('style','display:none!important')
        }
      }
    }else if (val == "phone") {
      $("#inputPhone").inputmask({"mask": "999-999-999-999"})
      $("#inputPhone").closest('.form-group').removeClass('needs-validation')
      $("#inputPhone").closest('input').next('span').attr('style','display:none!important');
      $("#inputPhone").prev('.input-group-text').css("background-color","red");
    }else if(val == "subject") {
      $("#inputSubject").closest('.form-group').removeClass('needs-validation')
      $("#inputSubject").closest('input').next('span').attr('style','display:none!important');
      $("#inputSubject").prev('.input-group-text').css("background-color","red");
    }else if(val == "attention") {
      $("#inputAttention").closest('.form-group').removeClass('needs-validation')
      $("#inputAttention").closest('input').next('span').attr('style','display:none!important');
      $("#inputAttention").prev('.input-group-text').css("background-color","red");
    }else if(val == "from") {
      $("#inputFrom").closest('.form-group').removeClass('needs-validation')
      $("#inputFrom").closest('input').next('span').attr('style','display:none!important');
      $("#inputFrom").prev('.input-group-text').css("background-color","red");
    }else if(val == "address") {
      $("#inputAddress").closest('.form-group').removeClass('needs-validation')
      $("#inputAddress").closest('input').next('span').attr('style','display:none!important');
      $("#inputAddress").prev('.input-group-text').css("background-color","red");  
    }

    if (val == "selectLeadId") {
      $("#selectLeadId").closest('.form-group').removeClass('needs-validation')
      $("#selectLeadId").closest('select').next('span').next('span').attr('style','display:none!important');
      $("#selectLeadId").prev('.input-group-text').css("background-color","red");
    }

    if (val == "selectPID") {
      $("#selectPID").closest('.form-group').removeClass('needs-validation')
      $("#selectPID").closest('select').next('span').next('span').attr('style','display:none!important');
      $("#selectPID").prev('.input-group-text').css("background-color","red");
    }

    if (val == "selectType") {
      $("#selectType").closest('.form-group').removeClass('needs-validation')
      $("#selectType").closest('select').next('span').attr('style','display:none!important');
      $("#selectType").prev('.input-group-text').css("background-color","red");
    }

    if (val == "selectCategory") {
      $("#selectCategory").closest('.form-group').removeClass('needs-validation')
      $("#selectCategory").closest('select').next('span').attr('style','display:none!important');
      $("#selectCategory").prev('.input-group-text').css("background-color","red");
    }

    if (val == "name_product") {
      $("#inputNameProduct").closest('.form-group').removeClass('needs-validation')
      $("#inputNameProduct").closest('input').next('span').attr('style','display:none!important');
      $("#inputNameProduct").prev('.input-group-text').css("background-color","red");
    }
    if (val == "desc_product") {
      $("#inputDescProduct").closest('.form-group').removeClass('needs-validation')
      $("#inputDescProduct").closest('textarea').next('span').attr('style','display:none!important');
      $("#inputDescProduct").prev('.input-group-text').css("background-color","red");
    }
    if (val == "qty_product") {
      if (localStorage.getItem('isRupiah') == 'true') {
        $("#inputTotalPrice").val(formatter.format(Math.round(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ','')))))
      }else{
        $("#inputTotalPrice").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
      }
      $("#inputQtyProduct").closest('.col-md-4').removeClass('needs-validation')
      $("#inputQtyProduct").closest('input').next('span').attr('style','display:none!important');
      $("#inputQtyProduct").prev('.input-group-text').css("background-color","red");
    }
    if (val == "price_product") {
      formatter.format($("#inputPriceProduct").val())
      if (localStorage.getItem('isRupiah') == 'true') {
        $("#inputTotalPrice").val(formatter.format(Math.round(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ','')))))
      }else{
        $("#inputTotalPrice").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
      }
      $("#inputPriceProduct").closest('.col-md-4').removeClass('needs-validation')
      $("#inputPriceProduct").closest('input').closest('.input-group').next('span').attr('style','display:none!important');
      $("#inputPriceProduct").prev('.col-md-4').css("background-color","red");
    }
    if (val == "spk") {
      $("#inputSPK").closest('.form-group').removeClass('needs-validation')
      $("#inputSPK").closest('input').next('span').attr('style','display:none!important');
      $("#inputSPK").prev('.input-group-text').css("background-color","red");
    }

    if (val == "sbe") {
      $("#inputSBE").closest('.form-group').removeClass('needs-validation')
      $("#inputSBE").closest('input').next('span').attr('style','display:none!important');
      $("#inputSBE").prev('.input-group-text').css("background-color","red");
    }

    if (val == "quoteSupplier") {
      $("#inputQuoteSupplier").closest('.form-group').removeClass('needs-validation')
      $("#inputQuoteSupplier").closest('input').next('span').attr('style','display:none!important');
      $("#inputQuoteSupplier").prev('.input-group-text').css("background-color","red");  
    }

    if (val == "quoteNumber") {
      $("#inputQuoteNumber").closest('.form-group').removeClass('needs-validation')
      $("#inputQuoteNumber").closest('input').next('span').attr('style','display:none!important');
      $("#inputQuoteNumber").prev('.input-group-text').css("background-color","red");  
    }

    if (val == "textArea_TOP") {
      $("#snow-editor").next('span').attr('style','display:none!important');
    }

    if (val == "reason_reject") {
      if (val == "reason_reject") {
        $("#reasonRejectSirkular").closest('.form-group').removeClass('needs-validation')
        $("#reasonRejectSirkular").closest('textarea').next('span').attr('style','display:none!important');
        $("#reasonRejectSirkular").prev('.input-group-text').css("background-color","red"); 
      }
    }
  }

  localStorage.setItem('isEditProduct',false)
  function nextPrevAddPembanding(n,value) {
    if (value == undefined) {
      if (value == 0) {
        $(".tabGroupInitiateAdd").attr('style','display:none!important')
        $(".tab-add")[1].children[1].style.display = 'inline'
      }
    }else{
      value = value
      if (value == true) {
        value = 'true'
      }else if (value == false) {
        value = 'false'
      }else{
        value = parseInt(value)
      }

      if (!isNaN(value)) {
        $(".tabGroupInitiateAdd").attr('style','display:none!important')
        $(".tab-add")[1].children[1].style.display = 'inline'
        $.ajax({
          type: "GET",
          url: "{{url('/admin/getProductCompareById')}}",
          data: {
            id_product:value,
          },
          success: function(result) {
            $.each(result,function(value,item){
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
      // if ($("#selectTo").val() == "") {
      //     $("#selectTo").closest('.form-group').addClass('needs-validation')
      //     $("#selectTo").closest('.form-group').find('.invalid-feedback').show()
      //     $("#selectTo").css("background-color","red");
      //   if ($("#inputTo").val() == "") {
      //     $("#inputTo").closest('.form-group').addClass('needs-validation')
      //     $("#inputTo").closest('input').next('span').show();
      //     $("#inputTo").prev('.input-group-text').css("background-color","red");
      //   }
      // }else 
      if ($("#inputEmail").val() == "") {
        $("#inputEmail").closest('.form-group').addClass('needs-validation')
        $("#inputEmail").closest('input').next('span').show();
        $("#inputEmail").prev('.input-group-text').css("background-color","red");
        $("#inputEmail").closest('input').next('span').text("Please fill an Email!")
      }
      else if ($("#selectPosition").val() == "") {
        $("#selectPosition").closest('.form-group').addClass('needs-validation')
        $("#selectPosition").closest('select').next('span').show();
        $("#selectPosition").prev('.input-group-text').css("background-color","red");
      }else if ($("#inputPhone").val() == "") {
        $("#inputPhone").closest('.form-group').addClass('needs-validation')
        $("#inputPhone").closest('input').next('span').show();
        $("#inputPhone").prev('.input-group-text').css("background-color","red");
      }else if($("#inputAttention").val() == "") {
        $("#inputAttention").closest('.form-group').addClass('needs-validation')
        $("#inputAttention").closest('input').next('span').show();
        $("#inputAttention").prev('.input-group-text').css("background-color","red");
      }else if($("#inputFrom").val() == "") {
        $("#inputFrom").closest('.form-group').addClass('needs-validation')
        $("#inputFrom").closest('input').next('span').show();
        $("#inputFrom").prev('.input-group-text').css("background-color","red");
      }else if($("#inputSubject").val() == "") {
        $("#inputSubject").closest('.form-group').addClass('needs-validation')
        $("#inputSubject").closest('input').next('span').show();
        $("#inputSubject").prev('.input-group-text').css("background-color","red");
      }else if($("#inputAddress").val() == "") {
        $("#inputAddress").closest('.form-group').addClass('needs-validation')
        $("#inputAddress").closest('textarea').next('span').show();
        $("#inputAddress").prev('.input-group-text').css("background-color","red");
      }else if($("#note_pembanding").val() == "") {
        $("#note_pembanding").closest('.form-group').addClass('needs-validation')
        $("#note_pembanding").closest('textarea').next('span').show();
        $("#note_pembanding").prev('.input-group-text').css("background-color","red");
      }else{
        let inputTo = ""
        if ($("#selectTo").val() == "") {
          inputTo = $("#inputTo").val()
        }else{
          inputTo = $("#selectTo").val()
        }

        if (value == 'true') {
          isStoreSupplier = localStorage.getItem('isStoreSupplier')
          if (isStoreSupplier == 'false') {            
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
                      url:"{{url('/admin/storePembandingSupplier')}}",
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
                        note_pembanding:$("#note_pembanding").val(),
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
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        })
                      },
                      success: function(result){
                        localStorage.setItem('isStoreSupplier',true)
                        localStorage.setItem('firstLaunch',false)
                        Swal.close()
                        var x = document.getElementsByClassName("tab-add");
                        x[currentTab].style.display = "none";
                        currentTab = currentTab + n;
                        if (currentTab >= x.length) {
                          x[n].style.display = "none";
                          currentTab = 0;
                        }
                        addDraftPrPembanding(currentTab);
                        localStorage.setItem('no_pembanding',result)
                        localStorage.setItem('id_draft_pr',window.location.href.split("/")[5])
                      }
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
            addDraftPrPembanding(currentTab);
          }
        }else{
          var x = document.getElementsByClassName("tab-add");
          x[currentTab].style.display = "none";
          currentTab = currentTab + n;
          if (currentTab >= x.length) {
            x[n].style.display = "none";
            currentTab = 0;
          }
          addDraftPrPembanding(currentTab);
        }
      }
    }else if (currentTab == 1) {
      if (($(".tab-add")[1].children[1].style.display == 'inline') == true) {
        if (n == 1) {
          if ($("#inputNameProduct").val() == "") {
            $("#inputNameProduct").closest('.form-group').addClass('needs-validation')
            $("#inputNameProduct").closest('input').next('span').show();
            $("#inputNameProduct").prev('.input-group-text').css("background-color","red");
          }else if ($("#inputDescProduct").val() == "") {
            $("#inputDescProduct").closest('.form-group').addClass('needs-validation')
            $("#inputDescProduct").closest('textarea').next('span').show();
            $("#inputDescProduct").prev('.input-group-text').css("background-color","red");
          }else if ($("#inputQtyProduct").val() == "") {
            $("#inputQtyProduct").closest('.col-md-4').addClass('needs-validation')
            $("#inputQtyProduct").closest('input').next('span').show();
            $("#inputQtyProduct").prev('.input-group-text').css("background-color","red");
          }else if ($("#selectTypeProduct").val() == "") {
            $("#selectTypeProduct").closest('.col-md-4').addClass('needs-validation')
            $("#selectTypeProduct").closest('select').next('span').show();
            $("#selectTypeProduct").prev('.input-group-text').css("background-color","red");
          }else if ($("#inputPriceProduct").val() == "") {
            $("#inputPriceProduct").closest('.col-md-4').addClass('needs-validation')
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

                  var x = document.getElementsByClassName("tab-add");
                  x[currentTab].style.display = "none";
                  currentTab = currentTab + n;
                  if (currentTab >= x.length) {
                    x[n].style.display = "none";
                    currentTab = 0;
                  }
                  addDraftPrPembanding(currentTab);
                  addTable(0)
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
                url: "{{url('/admin/storePembandingProduct')}}",
                type: 'post',
                data: {
                 _token:"{{ csrf_token() }}",
                 no_pr:localStorage.getItem('no_pembanding'),
                 inputNameProduct:$("#inputNameProduct").val(),
                 inputDescProduct:$("#inputDescProduct").val(),
                 inputSerialNumber:$("#inputSerialNumber").val(),
                 inputPartNumber:$("#inputPartNumber").val(),
                 inputQtyProduct:$("#inputQtyProduct").val(),
                 selectTypeProduct:$("#selectTypeProduct").val(),
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
                  var x = document.getElementsByClassName("tab-add");
                  x[currentTab].style.display = "none";
                  currentTab = currentTab + n;
                  if (currentTab >= x.length) {
                    x[n].style.display = "none";
                    currentTab = 0;
                  }
                  addDraftPrPembanding(currentTab);
                  $(".tabGroupInitiateAdd").show()
                  $(".tab-add")[1].children[1].style.display = 'none'
                  document.getElementsByClassName('tabGroupInitiateAdd')[0].childNodes[1].style.display = 'flex'
                  addTable(0)
                  
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
          var x = document.getElementsByClassName("tab-add");
          x[currentTab].style.display = "none";
          currentTab = currentTab + n;
          if (currentTab >= x.length) {
            x[n].style.display = "none";
            currentTab = 0;
          }
          addDraftPrPembanding(currentTab)
        }else{
          var dataForm = new FormData()
          dataForm.append('csv_file',$('#uploadCsv').prop('files')[0]);
          dataForm.append('_token','{{ csrf_token() }}');
          dataForm.append('no_pr',localStorage.getItem('no_pembanding'));
          dataForm.append('status','pembanding');

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
                x[currentTab].style.display = "none";
                currentTab = currentTab + n;
                if (currentTab >= x.length) {
                  x[n].style.display = "none";
                  currentTab = 0;
                }
                addDraftPrPembanding(currentTab)
                addTable(0)
              }
            }
          })
        }
      }       
    }else if (currentTab == 2) {
      $.ajax({
        type:"POST",
        url:"{{url('/admin/storeTaxComparing')}}",
        data:{
          no_pr:localStorage.getItem('no_pembanding'),
          isRupiah:localStorage.getItem('isRupiah'),
          status_tax:localStorage.getItem('status_tax'),
          discount:localStorage.getItem('discount'),
          tax_pb:localStorage.getItem('tax_pb'),
          service_charge:localStorage.getItem('service_charge'),
          _token:"{{csrf_token()}}"
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
          let x = document.getElementsByClassName("tab-add");
          x[currentTab].style.display = "none";
          currentTab = currentTab + n;
          if (currentTab >= x.length) {
            x[n].style.display = "none";
            currentTab = 0;
          }
          addDraftPrPembanding(currentTab);
        }
      })
    }else if (currentTab == 3) {
      if (n == 1) {
        $.ajax({
          type: "GET",
          url: "{{url('/admin/getPreviewPembanding')}}",
          data: {
            no_pr:localStorage.getItem('no_pembanding'),
          },success:function(result){
            if (result.pr.type_of_letter == 'IPR') {
              if ($("#inputPenawaranHarga").val() == "") {
                $("#inputPenawaranHarga").closest('.form-group').addClass('needs-validation')
                $("#inputPenawaranHarga").closest('div').next('span').show();
                $("#inputPenawaranHarga").prev('.input-group-text').css("background-color","red");
              }else{
                let formData = new FormData();
                const filepenawaranHarga = $('#inputPenawaranHarga').prop('files')[0];
                if (filepenawaranHarga!="") {
                  formData.append('inputPenawaranHarga', filepenawaranHarga);
                }

                $(".tableDocPendukung_ipr").empty()

                var arrInputDocPendukung = []
                $('#tableDocPendukung_ipr .trDocPendukung').each(function() {
                  var fileInput = $(this).find('#inputDocPendukung').val()
                  if (fileInput && fileInput !== '') {   
                    formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0])
                    arrInputDocPendukung.push({
                      nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
                      no_pr:localStorage.getItem('no_pembanding'),
                    })  
                  }
                });
                formData.append('_token',"{{csrf_token()}}")
                formData.append('arrInputDocPendukung',JSON.stringify(arrInputDocPendukung))
                formData.append('no_pr',localStorage.getItem('no_pembanding'))
                formData.append('id_draft_pr',localStorage.getItem('id_draft_pr'))

                if (n == 1) {
                  $.ajax({
                    type:"POST",
                    url:"{{url('/admin/storePembandingDokumen')}}",
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
                      var x = document.getElementsByClassName("tab-add");
                      x[currentTab].style.display = "none";
                      currentTab = currentTab + n;
                      if (currentTab >= x.length) {
                        x[n].style.display = "none";
                        currentTab = 0;
                      }
                      addDraftPrPembanding(currentTab);
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
                  addDraftPrPembanding(currentTab);
                }
              }
            }else{
              if ($("#selectLeadId").val() == "") {
                $("#selectLeadId").closest('.col-md-6').addClass('needs-validation')
                $("#selectLeadId").closest('select').next('span invalid-feedback').show();
                $("#selectLeadId").prev('.col-md-6').css("background-color","red");
              }else if ($("#selectPid").val() == "") {
                $("#selectPid").closest('.col-md-6').addClass('needs-validation')
                $("#selectPid").closest('select').next('span invalid-feedback').show();
                $("#selectPid").prev('.col-md-6').css("background-color","red");
              }else if ($("#inputQuoteSupplier").val() == "") {
                $("#inputQuoteSupplier").closest('.col-md-6').addClass('needs-validation')
                $("#inputQuoteSupplier").closest('div').next('span').show();
                $("#inputQuoteSupplier").prev('.col-md-6').css("background-color","red");
              }else if ($("#inputQuoteNumber").val() == "") {
                $("#inputQuoteNumber").closest('.col-md-6').addClass('needs-validation')
                $("#inputQuoteNumber").closest('input').next('span').show();
                $("#inputQuoteNumber").prev('.col-md-6').css("background-color","red");
              }else{
                let formData = new FormData();
                const fileQuoteSupplier = $('#inputQuoteSupplier').prop('files')[0];
                var nama_file_quote_supplier = $('#inputQuoteSupplier').val();
                if (nama_file_quote_supplier!="" && fileQuoteSupplier!="") {
                  formData.append('inputQuoteSupplier', fileQuoteSupplier);
                }

                var arrInputDocPendukung = []

                if (result.dokumen.length > 0) {
                  if (!(result.dokumen.slice(3).length == $('#tableDocPendukung_epr .trDocPendukung').length)) {
                    $('#tableDocPendukung_epr .trDocPendukung').slice(result.dokumen.slice(3).length).each(function(){
                      formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0])
                      arrInputDocPendukung.push({
                        nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
                        no_pr:localStorage.getItem('no_pembanding')
                      })
                    })

                  }else{
                    var fileInput = $(this).find('#inputDocPendukung').val()
                    if (fileInput && fileInput !== '') { 
                      formData.append('inputDocPendukung[]','-')
                    }
                  }                                 
                }else{
                  
                  $('#tableDocPendukung_epr .trDocPendukung').each(function() {
                    var fileInput = $(this).find('#inputDocPendukung').val()
                    if (fileInput && fileInput !== '') { 

                      formData.append('inputDocPendukung[]',$(this).find('#inputDocPendukung').prop('files')[0])
                      arrInputDocPendukung.push({
                        nameDocPendukung:$(this).find('#inputNameDocPendukung').val(),
                        no_pr:localStorage.getItem('no_pembanding')
                      })

                      
                    }
                  })
                }  

                formData.append('_token',"{{csrf_token()}}")
                formData.append('no_pr', localStorage.getItem('no_pembanding'))
                formData.append('selectLeadId', $("#selectLeadId").val())
                formData.append('selectPid', $("#selectPid").val())
                formData.append('inputPid',$("#projectIdInputNew").val())
                formData.append('selectQuoteNumber', $("#selectQuoteNumber").val())
                formData.append('arrInputDocPendukung',JSON.stringify(arrInputDocPendukung))

                if (n == 1) {
                  $.ajax({
                    type:"POST",
                    url:"{{url('/admin/storePembandingDokumen')}}",
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
                      var x = document.getElementsByClassName("tab-add");
                      x[currentTab].style.display = "none";
                      currentTab = currentTab + n;
                      if (currentTab >= x.length) {
                        x[n].style.display = "none";
                        currentTab = 0;
                      }
                      addDraftPrPembanding(currentTab);
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
                  addDraftPrPembanding(currentTab);
                }              
              } 
            }
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
        addDraftPrPembanding(currentTab);
      }
    }else if (currentTab == 4) {
      if (n == 1) {
        if (snowEditor.getText().trim() == "") {
          $("#snow-editor").next('span').show()
        }else{
          $("#snow-editor").next('span').attr('style','display:none!important')
          
          $.ajax({
            url: "{{'/admin/storePembandingTermPayment'}}",
            type: 'post',
            data:{
              no_pr:localStorage.getItem('no_pembanding'),
              _token:"{{csrf_token()}}",
              textAreaTOP:snowEditor.root.innerHTML,
            },
            success: function(data)
            {
              var x = document.getElementsByClassName("tab-add");
              x[currentTab].style.display = "none";
              currentTab = currentTab + n;
              if (currentTab >= x.length) {
                x[n].style.display = "none";
                currentTab = 0;
              }
              addDraftPrPembanding(currentTab);
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
        addDraftPrPembanding(currentTab);
      }
    }else{
      $(".divReasonRejectRevision").remove()
      
      var x = document.getElementsByClassName("tab-add");
      x[currentTab].style.display = "none";
      currentTab = currentTab + n;
      if (currentTab >= x.length) {
        x[n].style.display = "none";
        currentTab = 0;
      }
      addDraftPrPembanding(currentTab);
    }

  }  
  
  function createPRPembanding(){
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
          $.ajax({
            type:"POST",
            url:"{{url('/admin/storeLastStepPembanding')}}",
            data:{
              _token:"{{csrf_token()}}",
              no_pr:localStorage.getItem('no_pembanding'),
              inputGrandTotalProduct:$("#inputFinalPageTotalPricePembandingModal").val(),
              isRupiah:localStorage.getItem("isRupiah"),
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
              Swal.showLoading()
            },
            success: function(result){
              Swal.close()
              Swal.fire(
                  'Successfully!',
                  'Verify PR Successfully.',
                  'success'
              ).then((result) => {
                  if (result.value) {
                    location.replace("{{url('/admin/detailDraftPR')}}/"+ window.location.href.split("/")[5])
                    localStorage.setItem('isLastStorePembanding',true)
                  }
              })
            }
          })
      }
    })
  } 

  function changeVatValue(value=false){
    console.log(value)
    var tempVat = 0
    var finalVat = 0
    var tempGrand = 0
    var tempPb1 = 0
    var tempService = 0
    var tempDiscount = 0
    var finalGrand = 0
    var tempTotal = 0
    var sum = 0

    if (value == false) {
      valueVat = ''
    }else{
      if (value == 'service' || value == 'pb1') {
        valueVat = $("#vat_tax").val() == 0?false:parseFloat($('.title_tax_add_pembanding').text().replace("%",""))
      }else{
        valueVat = value
      }
    }
    
    $('.inputTotalPriceEdit').each(function() {
      var temp = parseFloat($(this).val() == "" ? "0" : parseFloat($(this).val().replace(/\./g,'').replace(',','.').replace(' ','')))
      console.log(isNaN(temp))
      sum += temp;
    });

    $("#inputGrandTotalProduct").val(formatter.format(sum))

    if (value == false) {
        valueVat = ''
        if ($("#inputDiscountNominal").val() != "") {
          tempDiscount = $("#inputDiscountNominal").val() == 0?false:parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ','') / parseFloat(sum) * 100)
          console.log(tempDiscount)
        }
      }else{
        if (value == 'service' || value == 'pb1') {
          valueVat = $("#vat_tax").val() == 0?false:parseFloat($('.title_tax_add_pembanding').text().replace("%",""))
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
            console.log(tempDiscount)
          }
        }
      }

    $('.money').mask('#.##0,00', {reverse: true})
    localStorage.setItem('status_tax',valueVat)


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
        $('.title_tax_add_pembanding').text(valueVat == '' || valueVat == 0?"":valueVat + '%')

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
      $('.title_tax_add_pembanding').text($("#vat_tax").val() == "" ||$("#vat_tax").val() == 0?"":$('.title_tax_add_pembanding').text().replace("%","") + '%')
    }

    setTimeout(function(){
      tempDiscNominal = isNaN(parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ','')))?0:parseFloat($("#inputDiscountNominal").val().replace(/\./g,'').replace(',','.').replace(' ',''))
      tempPb1 = Math.round(((parseFloat(sum) - tempDiscNominal)* ($("#inputPb1Final").val() == ""?0:parseFloat($("#inputPb1Final").val())) / 100))
      tempService = Math.round(((parseFloat(sum) - tempDiscNominal) * ($("#inputServiceChargeFinal").val() == ""?0:parseFloat($("#inputServiceChargeFinal").val())) / 100))
      
      $("#tax_base_other_pembanding").val(formatter.format(customRound(formatter.format((sum - tempDiscNominal)*11/12))))
      $("#inputPb1Nominal").val(formatter.format(tempPb1))
      $("#inputServiceChargeNominal").val(formatter.format(tempService))
      $("#inputDiscountFinal").val((tempDiscount))

      tempGrand = sum + tempVat + tempPb1 + tempService - tempDiscNominal
      changeValueGrandTotal(isNaN(tempGrand)?0:tempGrand)
    },500)

    console.log(tempGrand)
    console.log(tempPb1)

    // $("#inputGrandTotalProductFinal").val(formatter.format(tempGrand))
    localStorage.setItem('tax_pb',$("#inputPb1Final").val() == ""?0:parseFloat($("#inputPb1Final").val()))
    localStorage.setItem('service_charge',$("#inputServiceChargeFinal").val() == ""?0:parseFloat($("#inputServiceChargeFinal").
      val()))
    localStorage.setItem('discount',tempDiscount == ""?0:tempDiscount)
  }

  function changeValueGrandTotal(grandTotal){
    $("#inputGrandTotalProductFinal").val(formatter.format(grandTotal))
  }

  localStorage.setItem('isRupiah',true)
  function changeCurreny(value){
    if (value == "usd") {
      $("#inputPriceProduct").closest("div").find(".input-group-text").text("$")
      $("#inputTotalPrice").closest("div").find("div").text("$")

      localStorage.setItem('isRupiah',false)
      $('.money').mask('#0,00', {reverse: true})

    }else{
      $("#inputPriceProduct").closest("div").find(".input-group-text").text("Rp.")
      $("#inputTotalPrice").closest("div").find("div").text("Rp.")

      localStorage.setItem('isRupiah',true)

      $('.money').mask('#.##0,00', {reverse: true})
    }

    if (localStorage.getItem('isRupiah') == 'true') {
      $("#inputTotalPrice").val(formatter.format(Math.round(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ','')))))
    }else{
      $("#inputTotalPrice").val(formatter.format(Number($("#inputQtyProduct").val()) * parseFloat($("#inputPriceProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))))
    }
  }

  function addTable(n){ 
    var status_tax = localStorage.getItem('status_tax')
    var tax_pb = localStorage.getItem('tax_pb')
    var service_charge = localStorage.getItem('service_charge')
    var discount = localStorage.getItem('discount')
    $.ajax({
        type: "GET",
        url: "{{url('/admin/getProductPembanding')}}",
        data: {
          no_pr:localStorage.getItem('no_pembanding')
        },
        success: function(result) {
          $("#tbodyProducts").empty()
          var append = ""
          var i = 0
          var valueEdit = 0
          $.each(result.data,function(value,item){
            i++
            valueEdit++
            append = append + '<tr>'
              append = append + '<td>'
                append = append + '<span style="font-size: 12px; important">'+ i +'</span>'
              append = append + '</td>'
              append = append + '<td width="20%">'
                append = append + "<input id='inputNameProductEdit' data-value='' disabled style='font-size: 12px;width:200px' class='form-control' type='' name='' value='"+ item.name_product + "'>"
              append = append + '</td>'
              append = append + '<td width="30%">'
                append = append + '<textarea id="textAreaDescProductEdit" disabled data-value="" style="font-size: 12px; important;resize:none;height:150px;width:400px" class="form-control">'+ item.description.replaceAll("<br>","\n") + '&#10;&#10;SN : ' + item.serial_number + '&#10;PN : ' + item.part_number
                append = append + '</textarea>'
              append = append + '</td>'
              append = append + '<td width="7%">'
                append = append + '<input id="inputQtyEdit" data-value="" disabled style="font-size: 12px; important;width:70px" class="form-control" type="number" name="" value="'+ item.qty +'">'
              append = append + '</td>'
              append = append + '<td width="10%">'
              append = append + '<select id="inputTypeEdit" disabled data-value="" style="font-size: 12px; important;width:70px" class="form-control">'
              append = append + '<option>' + item.unit.charAt(0).toUpperCase() + item.unit.slice(1) + '</option>'
              append = append + '</select>' 
              append = append + '</td>'
              append = append + '<td width="15%">'
                append = append + '<input id="inputPriceEdit" disabled data-value="" style="font-size: 12px;width:150px" class="form-control" type="" name="" value="'+ formatter.format(item.nominal_product) +'">'
              append = append + '</td>'
              append = append + '<td width="15%">'
                append = append + '<input id="inputTotalPriceEdit" disabled data-value="" style="font-size: 12px;width:150px" class="form-control inputTotalPriceEdit" type="" name="" value="'+ formatter.format(item.grand_total) +'">'
              append = append + '</td>'
              append = append + '<td width="8%">'
                append = append + '<button type="button" onclick="nextPrevAddPembanding(-1,'+ item.id_product +')" id="btnEditProduk" data-id="'+ value +'" data-value="'+ valueEdit +'" class="btn btn-sm btn-xs btn-warning bx bx-edit btnEditProduk" style="width:25px;height:25px;margin-bottom:5px"></button>'
                append = append + '<button id="btnDeleteProduk" type="button" data-id="'+ item.id_product +'" data-value="'+ value +'" class="btn btn-sm btn-xs btn-danger bx bx-trash" style="width:25px;height:25px"></button>'
              append = append + '</td>'
            append = append + '</tr>'   
        })    

        $("#tbodyProducts").append(append)

        $("#bottomProducts").empty()

        var appendBottom = ""
        appendBottom = appendBottom + '<hr>'
          appendBottom = appendBottom + '<div class="row">'
            appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
            appendBottom = appendBottom + '    <div class="pull-right">'
            appendBottom = appendBottom + '      <span style="display: inline;margin-right: 15px;">Total</span>'
            appendBottom = appendBottom + '      <input disabled type="text" style="width:250px;display: inline;" class="form-control inputGrandTotalProduct" id="inputGrandTotalProduct" name="inputGrandTotalProduct">'
            appendBottom = appendBottom + '    </div>'
            appendBottom = appendBottom + '  </div>'
          appendBottom = appendBottom + '</div>'

          appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
            appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
            appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
            appendBottom = appendBottom + '      <div class="checkbox" style="margin-top:5px"><label><input type="checkbox" class="form-check-input" id="cbInputDiscountFinal">&nbsp&nbspDiscount</label></div>'
            appendBottom = appendBottom + '      <input disabled type="text" style="width:170px;display: inline;margin-left:15px" class="form-control inputDiscountNominal money" id="inputDiscountNominal" name="inputDiscountNominal" disabled onkeyup="changeVatValue('+ "'discount'"+')">'
            appendBottom = appendBottom + '      <input disabled type="text" style="width:80px;display: inline;" class="form-control inputDiscountFinal" id="inputDiscountFinal" name="inputDiscountFinal" disabled>'
            appendBottom = appendBottom + '    </div>'
            appendBottom = appendBottom + '  </div>'
          appendBottom = appendBottom + '</div>'

          appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
            appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
            appendBottom = appendBottom + '    <div class="pull-right">'
            appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Tax Base Other</span>'
            appendBottom = appendBottom + '      <input disabled type="text" style="width:250px;display: inline;" class="form-control tax_base_other_pembanding" id="tax_base_other_pembanding" name="tax_base_other_pembanding">'
            appendBottom = appendBottom + '    </div>'
            appendBottom = appendBottom + '  </div>'
          appendBottom = appendBottom + '</div>'

          appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
            appendBottom = appendBottom + ' <div class="col-md-12 col-xs-12">'
            appendBottom = appendBottom + ' <div class="pull-right d-flex">'
            appendBottom = appendBottom + '  <span style="margin-right: 15px;margin-top:8px;display:inline-flex">Vat <span class="title_tax_add_pembanding"></span>'
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
            appendBottom = appendBottom + '       <li>'
            appendBottom = appendBottom + '        <a class="dropdown-item" onclick="changeVatValue('+ parseFloat(1.1) +')">Vat 1,2%</a>'
            appendBottom = appendBottom + '       </li>'
            appendBottom = appendBottom + '      </ul>'
            appendBottom = appendBottom + '</div>'
            appendBottom = appendBottom + '</div>'
            appendBottom = appendBottom + '</div>'
          appendBottom = appendBottom + '</div>'

          appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
            appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
            appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
            appendBottom = appendBottom + '      <div class="checkbox" style="margin-top:5px"><label><input type="checkbox" class="form-check-input" id="cbInputPb1Final">&nbsp&nbspPB1</label></div>'
            appendBottom = appendBottom + '      <input disabled type="text" style="width:170px;display: inline;margin-left:15px" class="form-control inputPb1Nominal" id="inputPb1Nominal" name="inputPb1Nominal">'
            appendBottom = appendBottom + '      <input disabled type="text" style="width:80px;display: inline;" class="form-control inputPb1Final" id="inputPb1Final" name="inputPb1Final" onkeyup="changeVatValue('+ "'pb1'"+')">'
            appendBottom = appendBottom + '    </div>'
            appendBottom = appendBottom + '  </div>'
          appendBottom = appendBottom + '</div>'

          appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
            appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
            appendBottom = appendBottom + '    <div class="pull-right" style="display:flex">'
            appendBottom = appendBottom + '      <div class="checkbox" style="margin-top:5px"><label><input type="checkbox" class="form-check-input" id="cbInputServiceChargeFinal">&nbsp&nbspService Charge</label></div>'
            appendBottom = appendBottom + '      <input disabled type="text" style="width:170px;display: inline;margin-left:15px" class="form-control inputServiceChargeNominal" id="inputServiceChargeNominal" name="inputServiceChargeNominal">'
            appendBottom = appendBottom + '      <input disabled type="text" style="width:80px;display: inline;" class="form-control inputServiceChargeFinal" id="inputServiceChargeFinal" name="inputServiceChargeFinal" onkeyup="changeVatValue('+ "'service'"+')">'
            appendBottom = appendBottom + '    </div>'
            appendBottom = appendBottom + '  </div>'
          appendBottom = appendBottom + '</div>'

          appendBottom = appendBottom + '<div class="row" style="margin-top: 10px;">'
            appendBottom = appendBottom + '  <div class="col-md-12 col-xs-12">'
            appendBottom = appendBottom + '    <div class="pull-right">'
            appendBottom = appendBottom + '      <span style="display: inline;margin-right: 10px;">Grand Total</span>'
            appendBottom = appendBottom + '      <input disabled type="text" style="width:250px;display: inline;" class="form-control inputGrandTotalProductFinal" id="inputGrandTotalProductFinal" name="inputGrandTotalProductFinal">'
            appendBottom = appendBottom + '    </div>'
            appendBottom = appendBottom + '  </div>'
          appendBottom = appendBottom + '</div>'

        $("#bottomProducts").append(appendBottom) 

        if (status_tax != "") {
          changeVatValue(status_tax)
        }

        console.log(tax_pb)
        console.log(service_charge)
        console.log(discount)


        if (tax_pb == 0) {
          toggleIcheckPajak(false)
        }else{
          $("#inputPb1Nominal").val(formatter.format(Math.round(($("#inputGrandTotalProduct").val() == ""?0:parseFloat($("#inputGrandTotalProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))) * tax_pb / 100)))
          $("#inputPb1Product").val(tax_pb)
          toggleIcheckPajak(true)
        }

        if (service_charge == 0) {
          toggleIcheckPajak(false)
        }else{
          $("#inputServiceChargeNominal").val(formatter.format(Math.round(($("#inputGrandTotalProduct").val() == ""?0:parseFloat($("#inputGrandTotalProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))) * service_charge / 100)))
          $("#inputServiceChargeProduct").val(service_charge)
          toggleIcheckPajak(true)
        }

        if (discount == 0) {
          toggleIcheckPajak(false)
        }else{
          $("#inputDiscountNominal").val(formatter.format(Math.round(($("#inputGrandTotalProduct").val() == ""?0:parseFloat($("#inputGrandTotalProduct").val().replace(/\./g,'').replace(',','.').replace(' ',''))) * discount / 100)))
          $("#inputDiscountProduct").val(discount)
          toggleIcheckPajak(true)
        }

        // $("#inputPb1Final").inputmask("percentage", {
        //   radixPoint: ".",
        //   groupSeparator: ",",
        //   autoGroup: true,
        //   suffix: " %",
        //   clearMaskOnLostFocus: false
        // });

        // $("#inputServiceChargeFinal").inputmask("percentage", {
        //   radixPoint: ".",
        //   groupSeparator: ",",
        //   autoGroup: true,
        //   suffix: " %",
        //   clearMaskOnLostFocus: false
        // });

        $("#inputPb1Final").inputmask({
          alias:"percentage",
          integerDigits:2,
          digits:2,
          allowMinus:false,
          digitsOptional: false,
          placeholder: "0"
        });

        $("#inputServiceChargeFinal").inputmask({
          alias:"percentage",
          integerDigits:2,
          digits:2,
          allowMinus:false,
          digitsOptional: false,
          placeholder: "0"
        });

        $("#inputDiscountFinal").inputmask({
          alias:"percentage",
          integerDigits:2,
          digits:2,
          allowMinus:false,
          digitsOptional: false,
          placeholder: "0"
        });

          // var sum = 0
          // $('.inputTotalPriceEdit').each(function() {
          //     var temp = parseInt(($(this).val() == "" ? "0" : $(this).val()).replace(/\D/g, ""))
          //     sum += temp;
          // });

          // $("#inputGrandTotalProduct").val(formatter.format(sum))

          // // tempVat = (parseFloat(sum) * 11) / 100

          // // finalVat = tempVat

          // tempGrand = parseInt(sum)

          // // finalGrand = tempGrand

          // // tempTotal = sum

          // $("#vat_tax").val(0)

          // $("#inputGrandTotalProductFinal").val(formatter.format(tempGrand))
      }
    })
  }

  function toggleIcheckPajak(value){
    $('#cbInputPb1Final').on('change', function(event){
        if ($('#cbInputPb1Final').is(":checked")) {
          $("#inputPb1Final").prop("disabled",false)
        }
    });

    $('#cbInputPb1Final').on('change', function(event){
      if (!$('#cbInputPb1Final').is(":checked")) {
        $("#inputPb1Final").prop("disabled",true)
        if (value == false) {
          $("#inputPb1Final").val("")
          $("#inputPb1Nominal").val("")
          changeVatValue("pb1")
        }
      }
    });

    $('#cbInputServiceChargeFinal').on('change', function(event){
      if ($('#cbInputServiceChargeFinal').is(":checked")) {
        $("#inputServiceChargeFinal").prop("disabled",false)
      }
    });

    $('#cbInputServiceChargeFinal').on('change', function(event){
      if (!$('#cbInputServiceChargeFinal').is(":checked")) {
        $("#inputServiceChargeFinal").prop("disabled",true)
        if (value == false) {
          $("#inputServiceChargeFinal").val("")
          $("#inputServiceChargeNominal").val("")
          changeVatValue("service")
        }
      }
    });

    console.log("checked")

    $('#cbInputDiscountFinal').on('change', function(event){
      if ($('#cbInputDiscountFinal').is(":checked")) {
        $("#inputDiscountNominal").prop("disabled",false)
      }
    });

    $('#cbInputDiscountFinal').on('change', function(event){
      if (!$('#cbInputDiscountFinal').is(":checked")) {
        $("#inputDiscountNominal").prop("disabled",true)
        if (value == false) {
          $("#inputDiscountNominal").val("")
          changeVatValue("discount")
        }
      }
    });
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

  var incrementDoc = 0
  function addDocPendukung(value){
    // incrementDoc++
    // $("#titleDoc").show()
    // append = ""
    //   append = append + "<tr style='height:10px' class='trDocPendukung'>"
    //     append = append + "<td>"
    //       append = append + '<button type="button" class="bx bx-x btnRemoveAddDocPendukung" style="display:inline;color:red;background-color:transparent;border:none"></button>&nbsp'
    //       append = append + '<input style="display:inline;font-family: inherit;width: 90px;" class="bx bx-cloud-upload pull-right inputDocPendukung_'+incrementDoc+' files" type="file" name="inputDocPendukung[]" id="inputDocPendukung">'
    //     append = append + "</td>"
    //     append = append + "<td>"
    //       append = append + '<input style="margin-left:20px" class="form-control" name="inputNameDocPendukung" id="inputNameDocPendukung">'
    //     append = append + "</td>"
    //   append = append + "</tr>"
    // $("#tableDocPendukung_"+value).append(append)
    $("#titleDoc_"+value).show()
    append = ""
      append = append + "<tr style='height:10px' class='trDocPendukung'>"
        append = append + "<td>"
          append = append + '<button type="button" class="bx bx-x btnRemoveAddDocPendukung" style="display:inline;color:red;background-color:transparent;border:none"></button>&nbsp'
          append = append + '<label for="inputDocPendukung" style="margin-bottom:0px">'
          append = append + '<span class="bx bx-cloud-upload" style="display:inline"></span>'
          append = append + '<input style="display:inline;width: 90px;" class=" inputDocPendukung_'+ incrementDoc +' files" type="file" name="inputDocPendukung" id="inputDocPendukung" data-value="'+incrementDoc+'">'
          append = append + '</label>'
        append = append + "</td>"
        append = append + "<td>"
          append = append + '<input style="width:250px;margin-left:20px" class="form-control inputNameDocPendukung_'+ incrementDoc+'" name="inputNameDocPendukung" id="inputNameDocPendukung" placeholder="ex : faktur pajak">'
        append = append + "</td>"
      append = append + "</tr>"
    $("#tableDocPendukung_"+value).append(append) 
    incrementDoc++
  }  

  $(document).on('click', '.btnRemoveAddDocPendukung', function() {
    $(this).closest("tr").remove();
    if($('#tableDocPendukung tr').length == 0){
      $("#titleDoc").attr('style','display:none!important')
    }
  });

  function refreshTable(){
    addTable(0,localStorage.getItem('status_tax'))
  }

  function next(n){
    currentTab = 0
    var x = document.getElementsByClassName("tab-sirkulasi");
    x[currentTab].style.display = "none";
    currentTab = currentTab + n;
    if (currentTab >= x.length) {
      x[n].style.display = "none";
      currentTab = 0;
    }
    sirkulasi(currentTab);
  }

  function showPdf(){
    $.ajax({
      type:"GET",
      url:"{{url('/admin/getPdfPRFromLink')}}",
      data:{
        no_pr:window.location.href.split("/")[5],
      },success:function(result){
        window.open(result);
      }
    })
  }

  function rejectSirkulasi(){
    if ($("#reasonRejectSirkular").val() == "") {
      $("#reasonRejectSirkular").closest('.form-group').addClass('needs-validation')
      $("#reasonRejectSirkular").closest('textarea').next('span').show();
      $("#reasonRejectSirkular").prev('.input-group-text').css("background-color","red");
    }else{
      $.ajax({
        type: "POST",
        url: "{{url('/admin/rejectCirculerPR')}}",
        data: {
          _token: "{{ csrf_token() }}",
          no_pr:window.location.href.split("/")[5],
          reasonRejectSirkular:$("#reasonRejectSirkular").val(),
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
              location.replace("{{url('/admin/draftPR')}}/")
              Swal.close()
            }
          })
          
        }
      }) 
    }
  }

</script>
@endsection