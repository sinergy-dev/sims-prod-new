
@extends('template.main_sneat')
@section('tittle')
SBE Detail
@endsection
@section('pageName')
SBE Detail
@endsection
@section('head_css')
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"> -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
	<style type="text/css">
        textarea{
            resize: vertical;
        }

        input[name='priceItems'],input[name='totalItems'],input[name='inputGrandTotal']  {
            text-align: right;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }
        /* Chrome, Safari, Edge, Opera */

        /* Firefox */
        input[type=number] {
          -moz-appearance: textfield;
        }

        .wavy {
          animation-name: wavy;
          animation-duration: 1.3s;
          animation-timing-function: ease;
          animation-iteration-count: infinite;
          position: relative;
          top: 0;
          left: 0;
        }
        @keyframes wavy {
          0% {
            top: 0px;
          }
          50% {
            top: -2px;
          }
          100% {
            top: 0px;
          }
        }

        input[name='inputSumPriceGrandTotal']{
            color: white!important;
            background-color:#42855B!important;
        }

        /* Keep Select2 container fixed */

        select:not(#inputLead) + .select2-container {
          /* your styles here */
            width: 150px!important;
        }

        /* Prevent selected text from stretching the box */
        .select2-container--default .select2-selection--single {
          width: 100% !important;
          overflow: hidden !important;
        }

        /* Prevent long text from expanding the selected item */
        .select2-selection__rendered {
          display: block !important;
          white-space: nowrap !important;
          overflow: hidden !important;
          text-overflow: ellipsis !important;
        }
	</style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <section class="header">
        <a class="btn btn-sm text-bg-danger" id="btnBack">
            <i class="icon-base bx bx-arrow-back"></i> &nbsp;Back</a>
    </section>
    <section class="content mt-2">
    </section>
</div>

<!--modal notes-->
<div class="modal fade" id="ModalNotes" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <h6 class="modal-title">Notes</h6>
            </div>
            <div class="modal-body">
            <form action="" id="modal_notes" name="modal_notes">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="textareaNotes" id="textareaNotes" placeholder="Enter Notes" onkeyup="validateInput(this)"></textarea>
                    <span class="invalid-feedback" style="display:none!important">Please fill Notes!</span>

                </div>
            </form>
            <div class="modal-footer">
                <button class="btn btn-sm text-bg-danger" data-dismiss="modal">Cancel</button>
                <button class="btn btn-sm btn-linkedin" onclick="btnSendNotes()">Send</button>
            </div>
          </div>
      </div>
    </div>
</div>
@endsection
@section('scriptImport')
<!--select2-->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script> -->
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('script')
<script type="text/javascript">
    preventBack()
    var formatter = new Intl.NumberFormat(['ban', 'id']);

    var accesable = @json($feature_item);

    if (window.location.href.split("/")[3].split("?")[1] == 'create') {
        showCreateSBE()
        $("#btnBack").attr('href','{{url("/sbe_index")}}/')
    }else{
        showFunctionConfig()
        localStorage.setItem('isConfigPage',false)
        $("#btnBack").click(function(){
            if (localStorage.getItem('isConfigPage') == 'true') {
                $("#btnBack").removeAttr('href')
                // $("#btnBack").attr('onclick','showFunctionConfig()')
                // localStorage.setItem('isConfigPage',false)
            }else{
                $("#btnBack").removeAttr('onclick')
                $("#btnBack").attr('href','{{url("/sbe_index")}}/')
            }
        })
        $("#spanLeadId").html("Lead ID - "+ window.location.href.split("?")[1])            
    }

    accesable.forEach(function(item,index){
      $("#" + item).show()
    })

    function preventBack(){
        const beforeUnloadHandler = (event) => {
          // Recommended
          event.preventDefault();

          // Included for legacy support, e.g. Chrome/Edge < 119
          event.returnValue = true;
        };

        window.addEventListener("beforeunload", beforeUnloadHandler);
        // window.onbeforeunload = function() { 
        //     return "Your work will be lost."; 
        // };
    }


    function cancelConfig(){
        localStorage.setItem('isConfigPage',false)
        $(".content").empty("")
        showFunctionConfig()    
    }

    
    function showFunctionConfig(){
        localStorage.setItem('isConfigPage',false)

        $(".content").empty("")
        var append = ""
        var appendVersion = ""
        var data = ["PMO","PMO SID","PMO MSM"]
        var dataRadio = ["Ver 1","Ver 2","Ver 3"]

        append = append + '<div class="row" style="display:none!important">'
            append = append + '<div class="col-md-12 col-xs-12">'
                append = append + ' <div class="alert alert-danger alert-dismissible">'
                    append = append + '      <h6><i class="icon fa fa-ban"></i> Reject Notes!</h6>'
                    append = append + '      <span id="RejectAlertNotes">tes</span>'
                append = append + ' </div>'
            append = append + ' </div>'
        append = append + '</div>'
        append = append + '<div class="row">'
            append = append + '            <div class="col-md-6 col-xs-12">'
            append = append + '                <div class="card" id="temporaryFunction">'
            append = append + '                    <div class="card-header d-flex">'
            append = append + '                        <h6 class="card-title">Preview</h6>'
            append = append + '                        <div class="card-tools ms-auto">'
            append = append + '                         <button class="btn btn-sm btn-linkedin" style=";display:none!important" onclick="addNotes()" id="btnAddNotes">Notes</button>'
            append = append + '                        </div>'
            append = append + '                    </div>'
            append = append + '                    <div class="card-body" id="boxConfigTemp">'
            append = append + '                    </div>'
            append = append + '                </div>'
            append = append + '            </div>'
            append = append + '            <div class="col-md-6 col-xs-12">'
            append = append + '                <div class="card" id="configs">'
            append = append + '                    <div class="card-header d-flex">'
            append = append + '                        <h6 class="card-title">Temporary Config</h6>'
            append = append + '                        <div class="card-tools ms-auto">'
            append = append + '                             <span class="badge text-bg-success">Saved<span>'
            append = append + '                        </div>'
            append = append + '                    </div>'
            append = append + '                    <div class="card-body" id="showConfig" style="padding:20px">'
     
            $.ajax({
                type:"GET",
                url:"{{url('/sbe/getVersionConfig')}}",
                data:{
                    id_sbe:window.location.href.split("/")[4].split("?")[0] 
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
                success:function(item,result){
                    appendVersion = appendVersion + '    <div class="row mb-6" style="padding:10px">'
                    var arrChoosed = [], arrChoosedSO = [], arrChoosedImp = [], arrChoosedMnS = []
                    $.each(item,function(item,config){
                        appendVersion = appendVersion + '     <div class="col-md-4 col-xs-12">'
                        appendVersion = appendVersion + '        <div class="form-group">'
                        appendVersion = appendVersion + '            <label>'+ item +'</label>'
                        if (item == "Supply Only") {
                            var type = "SO"
                        }else if(item == "Implementation"){
                            var type = "Imp"
                        }else{
                            var type = "MnS"
                        }

                        var checked = ""
                        $.each(config,function(index,items){
                            if (items.status == "Choosed") {
                                var checked = "checked"
                            }
                            appendVersion = appendVersion + '     <div class="radio">'
                            appendVersion = appendVersion + '       <label>'
                            appendVersion = appendVersion + '         <input '+ checked +' type="radio" name="radio'+ type +'" id="radio'+ type +'" value="'+ items.id +'">'
                            appendVersion = appendVersion + "Ver " + parseInt(index+1)
                            appendVersion = appendVersion + '          </label>'
                            appendVersion = appendVersion + '            <a onclick="showUpdateConfigSO('+ items.id +')">'
                            appendVersion = appendVersion + '               <i class="icon-base bx bx-edit"></i>'
                            appendVersion = appendVersion + '            </a>'
                            appendVersion = appendVersion + '      </div>'
                        })  
                        appendVersion = appendVersion + '       </div>'
                        appendVersion = appendVersion + '     </div>'
                    })
                    appendVersion = appendVersion + '   </div>' 
                    $("#showConfig").append(appendVersion)

                    $("input[type='radio']").each(function(index,item){
                        $(item).each(function(indexes,itemRadio){
                            if (itemRadio.id == 'radioSO') {
                                if($(itemRadio).is(':checked')){
                                    arrChoosedSO.push(itemRadio.value)
                                }
                            }

                            if (itemRadio.id == 'radioImp') {
                                if($(itemRadio).is(':checked')){
                                    arrChoosedImp.push(itemRadio.value)
                                }
                            }

                            if (itemRadio.id == 'radioMnS') {
                                if($(itemRadio).is(':checked')){
                                    arrChoosedMnS.push(itemRadio.value)
                                }
                            }
                        })                           
                    })

                    $("input[type='radio']").change(function(){
                        $("#configs").find(".card-tools").html("<span class='badge text-bg-warning' id='status_unsaved'>Unsaved...</span>")
                        wavyText("unsaved...")
                        $("#boxConfigTemp").empty("")
                        
                        if (this.id == 'radioSO') {
                            arrChoosedSO = []
                            if($(this).is(':checked')){
                                arrChoosedSO.push(this.value)
                            }
                        }

                        if (this.id == 'radioImp') {
                            arrChoosedImp = []
                            if($(this).is(':checked')){
                                arrChoosedImp.push(this.value)
                            }
                        }

                        if (this.id == 'radioMnS') {
                            arrChoosedMnS = []
                            if($(this).is(':checked')){
                                arrChoosedMnS.push(this.value)
                            }
                        }
                        // arrChoosed.push($(this).value)
                        setTimeout(dynamicShowTempSbe(window.location.href.split("/")[4].split("?")[0],"/sbe/getConfigChoosed",JSON.stringify(arrChoosedSO.concat(arrChoosedImp, arrChoosedMnS))), 20000)
                        // dynamicShowTempSbe(window.location.href.split("/")[4].split("?")[0],"/sbe/getConfigChoosed",JSON.stringify(arrChoosedSO.concat(arrChoosedImp, arrChoosedMnS)))
                    })
                    
                    // checkInnerHeight()
                }
            })
            
            append = append + '                     <button class="btn btn-sm btn-warning" style="margin-bottom: 10px;margin-right:60px;position: absolute;right:10px;bottom: 0;display:none!important" onclick="resetConfig()" id="btnResetConfig">Reset</button>'
            append = append + '                     <button class="btn btn-sm text-bg-primary" style="margin-bottom: 10px;position: absolute;right: 10px;bottom: 0;display:none!important" onclick="saveFuncConf()" id="btnSaveConf">Save</button>'
            append = append + '                    </div>'            
            append = append + '                </div>'            
            append = append + '            </div>'
        append = append + '</div>'
        append = append + '<div class="row mt-5">'
            append = append + '<div class="col-md-12 col-xs-12">'
                append = append + '<div class="card">'
                append = append + '    <div class="card-header">'
                append = append + '        <h6>Change Log</h6>'
                append = append + '    </div>'
                append = append + '    <div class="card-body">'
                append = append + '        <div class="table-responsive" style="width:100%">'
                append = append + '            <table id="tbChangeLog" class="table table-striped table-bordered">'
                append = append + '            </table>'
                append = append + '        </div>'
                append = append + '    </div>'
                append = append + '</div>'
            append = append + '</div>'
        append = append + '</div>'
        $(".content").append(append)
        dynamicShowTempSbe(window.location.href.split("/")[4].split("?")[0],"/sbe/getConfigTemporary",arrChoosed="")

        $("#tbChangeLog").DataTable({
            "ajax":{
                "type":"GET",
                "url":"{{url('/sbe/getActivity')}}",
                "data":{
                    id_sbe:window.location.href.split("/")[4].split("?")[0] 
                }
            },
            columns: [
                {
                  title: "Name",
                  data: "name",
                  orderable: false
                },
                {
                  title: "Roles",
                  data: "role"
                },
                {
                  title: "Activity",
                  data: "activity"
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
            drawCallback: function(settings) {
                $.ajax({
                    type:"GET",
                    url:"{{url('/sbe/getActivity')}}",
                    "data":{
                        id_sbe:window.location.href.split("/")[4].split("?")[0] 
                    },success:function(result){
                        if (result.status[0].status == "Fixed") {
                            console.log("sinii")
                            $("#btnAddNotes").attr('style', 'display: none !important');
                            $("#btnGeneratePdf").attr('style', 'display: none !important');
                            $("#btnResetConfig").attr('style', 'display: none !important');
                            $("#btnSaveConf").attr('style', 'display: none !important');
                            $("input[type='radio']").prop("disabled",true)
                            $("input[type='radio']").each(function(index,item){
                                 $(item).each(function(indexes,itemRadio){
                                    $(itemRadio).closest("label").next().attr("onclick","showTemporarySBE("+ itemRadio.value +")")
                                 })                           
                            })
                        }else{
                            console.log("apa sinii")

                            if(accesable.includes('btnGeneratePdf')){
                                if (result.result != "WIN") {
                            console.log("apa iya")

                                    $("#btnGeneratePdf").attr('style', 'display: none !important');
                                }else{
                            console.log("apa engga")

                                    $("#btnGeneratePdf").show()
                                }
                            }
                        }

                        var nik = '"' + "{{Auth::User()->nik}}" + '"'
                        if (!accesable.includes('radioConfig') || result.presales.includes(nik)) {
                            $("#btnResetConfig").attr('style', 'display: none !important');
                            $("#btnSaveConf").attr('style', 'display: none !important');
                            $("input[type='radio']").prop("disabled",true)
                            $("input[type='radio']").each(function(index,item){
                                $(item).each(function(indexes,itemRadio){
                                    $(itemRadio).closest("label").next().attr("onclick","showTemporarySBE("+ itemRadio.value +")")
                                    $(itemRadio).closest("label").next().find("i").removeClass("fa-pencil-square-o").addClass("fa-search-plus")
                                })
                            })
                        }else{
                            if (result.getNotes.length > 0) {
                                $("#temporaryFunction").closest(".row").siblings().first().show()
                                $("#temporaryFunction").closest(".row").siblings().first().find(".alert").find("span").text(result.getNotes[0].notes)
                            }
                        }

                    }
                })
            },
            initComplete: function () {
               
            }
        });
    }

    function dynamicShowTempSbe(id_sbe,url,arrChoosed){
        if (arrChoosed == "") {
            var data = {id_sbe:id_sbe}
        }else{
            var data = {id_sbe:id_sbe,arrChoosed:arrChoosed}
        }

        $.ajax({
            type:"GET",
            url:"{{url('/')}}"+url,
            data:data,
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
                var appendTemporary = ""

                if (result.length == 0) {
                    showEmptyConfig()
                }else{
                    var sumTotalPrice = 0
                    var i = 0
                    $.each(result,function(index,items){
                        if (index == "Implementation") {
                            var bg_color = "#789de5"
                        }else if (index == "Maintenance") {
                            var bg_color = "#ea3323"
                        }else{
                            var bg_color = "#f19e38"
                        }
                        appendTemporary = appendTemporary + '<div class="row mb-4">'
                        appendTemporary = appendTemporary + '            <div class="col-md-3 col-xs-12" style="text-align:-webkit-center">'
                        appendTemporary = appendTemporary + '              <a onclick="showTemporarySBE('+ items[0].id +')">'
                        appendTemporary = appendTemporary + '                <div style="width: 100px;height: 100px;background-color: '+ bg_color +';color: white;text-align: center;vertical-align: middle;display: flex;">'
                        appendTemporary = appendTemporary + '                    <span style="'
                        appendTemporary = appendTemporary + '                        margin: auto;'
                        appendTemporary = appendTemporary + '                        display: flex;'
                        appendTemporary = appendTemporary + '                        text-align: center;'
                        appendTemporary = appendTemporary + '                        align-items: center;cursor:pointer">'+ index +'</span>'
                        appendTemporary = appendTemporary + '                </div>'
                        appendTemporary = appendTemporary + '              </a>'
                        appendTemporary = appendTemporary + '            </div>'
                        appendTemporary = appendTemporary + '            <div class="col-md-9 col-xs-12">'
                        appendTemporary = appendTemporary + '                <div class="table-responsive">'
                        appendTemporary = appendTemporary + '                    <table class="table table-bordered" id="tablePreviewConfig" width="100%">'
                        appendTemporary = appendTemporary + '                        <thead style="background-color:'+ bg_color +';color:white">'
                        appendTemporary = appendTemporary + '                            <tr>'
                        appendTemporary = appendTemporary + '                                <th style="color:white">No</th>'
                        appendTemporary = appendTemporary + '                                <th style="color:white">Function</th>'
                        appendTemporary = appendTemporary + '                                <th style="color:white" width="150">Total</th>'
                        appendTemporary = appendTemporary + '                            </tr>'
                        appendTemporary = appendTemporary + '                        </thead>'
                        appendTemporary = appendTemporary + '                        <tbody>'
                        $.each(items[0].get_function,function(index,itemsTemp){
                            appendTemporary = appendTemporary + '          <tr>'
                            appendTemporary = appendTemporary + '              <td>'+ ++i +'</td>'
                            appendTemporary = appendTemporary + '              <td>'+ index +'</td>'
                            appendTemporary = appendTemporary + '              <td>'+ formatter.format(itemsTemp.total_nominal) +'</td>'
                            appendTemporary = appendTemporary + '          </tr>'
                            appendTemporary = appendTemporary + '      </tbody>'

                        })
                        appendTemporary = appendTemporary + '      <tfoot>'
                        appendTemporary = appendTemporary + '          <tr>'
                        appendTemporary = appendTemporary + '              <th colspan="2" style="text-align:right">Total Price</th>'
                        appendTemporary = appendTemporary + '              <th>'+ formatter.format(items[0].detail_config_nominal) +'</th>'
                        appendTemporary = appendTemporary + '          </tr>'
                        appendTemporary = appendTemporary + '                        </tfoot>'
                        appendTemporary = appendTemporary + '                    </table>'
                        appendTemporary = appendTemporary + '                </div>'
                        appendTemporary = appendTemporary + '            </div>'
                        appendTemporary = appendTemporary + '        </div>'

                        sumTotalPrice += parseInt(items[0].detail_config_nominal) 
                    })

                    appendTemporary = appendTemporary + '     <button class="btn btn-sm btn-success mt-4" onclick="generatePDF()" id="btnGeneratePdf" style="display:none!important;float:right"><i class="bx bx-import"></i>&nbspGenerate</button>'
                    $("#boxConfigTemp").append(appendTemporary).fadeIn('slow')


                    var appendGrandTotal = ""
                    appendGrandTotal = appendGrandTotal + "<div class='row'>"
                    appendGrandTotal = appendGrandTotal + "     <div class='pull-right'>"
                    appendGrandTotal = appendGrandTotal + "         <div class='col-md-12'>"
                    appendGrandTotal = appendGrandTotal + "             <table class='table table-bordered text-bg-success'>"
                    appendGrandTotal = appendGrandTotal + "                 <tr>"
                    appendGrandTotal = appendGrandTotal + "                     <th colspan=2 style='color:white'>"
                    appendGrandTotal = appendGrandTotal + "                         Grand Total Price"
                    appendGrandTotal = appendGrandTotal + "                     </th>"
                    appendGrandTotal = appendGrandTotal + "                     <th width='150' style='color:white'>"
                    appendGrandTotal = appendGrandTotal + formatter.format(sumTotalPrice)
                    appendGrandTotal = appendGrandTotal + "                     </th>"
                    appendGrandTotal = appendGrandTotal + "                 </tr>"
                    appendGrandTotal = appendGrandTotal + "             </table>"

                    appendGrandTotal = appendGrandTotal + "         </div>"
                    appendGrandTotal = appendGrandTotal + "     </div>"
                    appendGrandTotal = appendGrandTotal + "</div>" 

                    $("#boxConfigTemp").find(".row").last().after(appendGrandTotal)
                }
                accesable.forEach(function(item,index){
                  $("#" + item).show()
                })

                // checkInnerHeight()
            }
        })
    }

    function showCreateSBE(){
        var append = ""

        append = append + '<div class="card">'
        append = append + '    <div class="card-body">'
        append = append + '<div class="row">'
        append = append + '    <div class="col-md-12 col-xs-12 mb-4">'
        append = append + '        <div class="form-group">'
        append = append + '            <label>Lead ID*</label>'
        append = append + '            <select onchange="validateInput(this)" class="form-control select2" name="inputLead" id="inputLead" style="width:100%!important"><option></option></select>'
        append = append + '            <span class="invalid-feedback" style="display:none!important">Please Select Lead Id!</span>'
        append = append + '        </div>'
        append = append + '    </div>'
        append = append + '    <div class="col-md-6 mb-4">'
        append = append + '        <div class="form-group">'
        append = append + '            <label>Estimated Running*</label>'
        append = append + '            <input onkeyup="validateInput(this)" type="text" class="form-control" name="inputEstimatedRun" id="inputEstimatedRun" placeholder="End of February">'
        append = append + '            <span class="invalid-feedback" style="display:none!important">Please Fill Estimated Running!</span>'
        append = append + '        </div>'
        append = append + '    </div>'
        append = append + '    <div class="col-md-6 mb-4">'
        append = append + '        <div class="form-group">'
        append = append + '            <label>Project Location*</label>'
        // append = append + '            <textarea onkeyup="validateInput(this)" class="form-control" style="resize: vertical;" name="textareaLoc" id="textareaLoc"></textarea>'
        append = append + '               <input class="form-control" name="textareaLoc" id="textareaLoc" placeholder="Jakarta" onkeyup="validateInput(this)">'
        append = append + '            <span class="invalid-feedback" style="display:none!important">Please Fill Project Location!</span>'
        append = append + '        </div>'
        append = append + '    </div>'
        append = append + '</div>'
        append = append + '<div class="row">'
        append = append + '    <div class="col-md-12 col-xs-12">'
        append = append + '        <label>Config*</label>'
        append = append + '<div class="form-group">'
            append = append + '    <div class="checkbox">'
        append = append + '             <label style="margin-right:10px">'
        append = append + '                 <input type="checkbox" class="cbConfig form-check-input" id="cbSO" onchange="validateInput(this)">'
        append = append + '                 Supply Only'
        append = append + '             </label>'
        append = append + '             <label style="margin-right:10px">'
        append = append + '                 <input type="checkbox" class="cbConfig form-check-input" id="cbImp" onchange="validateInput(this)">'
        append = append + '                 Implementation'
        append = append + '             </label>'
        append = append + '             <label style="margin-right:10px">'
        append = append + '                 <input type="checkbox" class="cbConfig form-check-input" id="cbMnS" onchange="validateInput(this)">'
        append = append + '                 Maintenance and Services'
        append = append + '             </label>'
        append = append + '         </div>'
        append = append + '         <span class="invalid-feedback" style="display:none!important">Please Select Config!</span>'
        append = append + '</div>'
        append = append + '        <div class="nav-align-top mt-5">'
        append = append + '            <ul class="nav nav-tabs">'
        append = append + '                <li class="nav-item disabled" disabled style="display:none!important"><button type="button" data-bs-toggle="tab"                data-bs-target="#tab_1" aria-controls="navs-tab-home" aria-selected="true" href="#tab_1" class="nav-link" role="tab">Supply Only</button></li>'
        append = append + '                <li class="nav-item disabled" disabled style="display:none!important"><button type="button" data-bs-toggle="tab"                data-bs-target="#tab_2" aria-controls="navs-tab-home" aria-selected="true" href="#tab_2" class="nav-link" role="tab">Implementation</button></</li>'
        append = append + '                <li class="nav-item disabled" disabled style="display:none!important"><button type="button" data-bs-toggle="tab"                data-bs-target="#tab_3" aria-controls="navs-tab-home" aria-selected="true" href="#tab_3" class="nav-link" role="tab">Maintenance & Managed Service</button></</li>'
        // append = append + '                <li style="float: right;display: inline-flex;">'
        // append = append + '                     <label style="vertical-align: middle;display: inline;margin-top: 10px;margin-right: 10px;'
        // append = append + '                         ">Duration*</label>'
        // append = append + '                     <input class="form-control" id="inputDuration" name="inputDuration" onkeyup="validateInput(this)" fdprocessedid="52jb4" style="display: inline;width:250px" placeholder="Input Duration">'
        // append = append + '                 </li>'
        append = append + '            </ul>'
        append = append + '            <div class="tab-content">'
        append = append + '                 <div class="tab-pane" id="tab_1">'
        append = append + '                     <div class="row">'
        append = append + '                         <div class="col-md-12 mb-4">'
        append = append + '                             <div class="form-group">'
        append = append + '                                 <label>Duration*</label>'
        append = append + '                                 <input class="form-control" id="durationSO" name="durationSO" onkeyup="validateInput(this)" fdprocessedid="52jb4" placeholder="Input Duration">'
        append = append + '                                         <span class="invalid-feedback" style="display:none!important">Please Fill Duration!</span>'
        append = append + '                             </div>'
        append = append + '                         </div>'
        append = append + '                         <div class="col-md-6 mb-4">'
        append = append + '                             <div class="form-group">'
        append = append + '                                 <label>Scope Of Work*</label>'
        append = append + '                                      <textarea onkeyup="validateInput(this)" class="form-control" style="resize: vertical;height: 150px;" name="textareaSOWSo" id="textareaSOWSo"></textarea>'
        append = append + '                                         <span class="invalid-feedback" style="display:none!important">Please Fill Scope of Work!</span>'
        append = append + '                             </div>'
        append = append + '                         </div>'
        append = append + '                         <div class="col-md-6 mb-4">'
        append = append + '                             <div class="form-group">'
        append = append + '                                 <label>Out Of Scope*</label>'
        append = append + '                                      <textarea onkeyup="validateInput(this)" class="form-control" style="resize: vertical;height: 150px;" row="20" name="textareaScopeSo" id="textareaScopeSo"></textarea>'
        append = append + '                                         <span class="invalid-feedback" style="display:none!important">Please Fill Out of Scope!</span>'
        append = append + '                              </div>'
        append = append + '                         </div>'
        append = append + '                     </div>'
        append = append + '                     <div class="table-responsive" name="divTableSO">'
        append = append + '                         <table class="table" name="tableSO" id="tableItemsSO_0">'
        append = append + '                             <thead>'
        append = append + '                                 <tr>'
            append = append + '                                <th>'
            append = append + '                                    Items'
            append = append + '                                </th>'
            append = append + '                                <th>'
            append = append + '                                    Detail Items'
            append = append + '                                </th>'
            append = append + '                                <th>'
            append = append + '                                    Qty'
            append = append + '                                </th>'
            append = append + '                                <th>'
            append = append + '                                    Price'
            append = append + '                                </th>'
            append = append + '                                <th>'
            append = append + '                                    Manpower'
            append = append + '                                </th>'
            append = append + '                                <th>'
            append = append + '                                    Total'
            append = append + '                                </th>'
            append = append + '                                <td>'
            append = append + '                                    <button class="btn btn-sm btn-linkedin" id="btnAddConfigSO" disabled="true" onclick="addConfigSO(0)" style="width: 35px;"><i class="icon-base bx bx-plus"></i></button>'
            append = append + '                                </td>'
        append = append + '                                 </tr>'
        append = append + '                             </thead>'
        append = append + '                        <tbody>'
        append = append + '                            <tr>'
        append = append + '                                <td>'
        append = append + '                                    <input type="" class="form-control" name="InputItems" id="InputItems" onkeyup="validateInput(this)" placeholder="Ex: PM Maintenance" style="width:150px">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <select type="" style="width:150px" class="select2 form-control detailItemsSO_0" name="detailItemsSO">'
        append = append + '                                        <option></option>'
        append = append + '                                    </select>'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <input type="number" style="width:60px" class="form-control qtyItems" name="qtyItems" id="qtyItems" onkeyup="changeQtyItems(this)">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <input type="" class="form-control" name="priceItems" id="priceItems" disabled="" style="width:150px">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <input type="" style="width:60px" class="form-control" name="manpowerItems" id="manpowerItems" onkeyup="changeManPower(this)">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <input type="" class="form-control" name="totalItems" id="totalItems" disabled style="width:150px">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                <button onclick="removeItemsDetailSO(this,0)" class="btn btn-sm text-bg-danger" style="width:35px"><i class="icon-base bx bx-trash-alt"></i></button>'
        append = append + '                                </td>'
        append = append + '                            </tr>'
        append = append + '                        </tbody>'
        append = append + '                        <tfoot>'
        append = append + '                            <tr>'
        append = append + '                                <td colspan="4"></td>'
        append = append + '                                <th>Grand Total</th>'
        append = append + '                                <td><input type="text" class="form-control" name="inputGrandTotal" disabled style="width:150px"></td>'
        append = append + '                            </tr>'
        append = append + '                        </tfoot>'
        // append = append + '                    <hr>'
        append = append + '                    </table>'
        append = append + '                     </div>'

        append = append + '                    <div style="text-align:center;margin-top:10px">'
        append = append + '                <button class="btn btn-sm text-bg-primary" id="addItemsSO" style="margin: 0 auto;" onclick="addItemsSO(0)"><i class="icon-base bx bx-plus"></i>&nbsp Add Items</button>'
        append = append + '                    </div>'
        append = append + '                </div>'
        append = append + '                <div class="tab-pane" id="tab_2">'
        append = append + '                     <div class="row">'
        append = append + '                         <div class="col-md-12 mb-4">'
        append = append + '                             <div class="form-group">'
        append = append + '                                 <label>Duration*</label>'
        append = append + '                                 <input class="form-control" id="durationImp" name="durationImp" onkeyup="validateInput(this)" fdprocessedid="52jb4" placeholder="Input Duration">'
        append = append + '                                         <span class="invalid-feedback" style="display:none!important">Please Fill Duration!</span>'
        append = append + '                             </div>'
        append = append + '                         </div>'
        append = append + '                         <div class="col-md-6 mb-4">'
        append = append + '                             <div class="form-group">'
        append = append + '                                 <label>Scope Of Work*</label>'
        append = append + '                                      <textarea onkeyup="validateInput(this)" class="form-control" style="resize: vertical;height: 150px;" name="textareaSOWImp" id="textareaSOWImp"></textarea>'
        append = append + '                                         <span class="invalid-feedback" style="display:none!important">Please Fill Scope of Work!</span>'
        append = append + '                             </div>'
        append = append + '                         </div>'
        append = append + '                         <div class="col-md-6 mb-4">'
        append = append + '                             <div class="form-group">'
        append = append + '                                 <label>Out Of Scope*</label>'
        append = append + '                                      <textarea onkeyup="validateInput(this)" class="form-control" style="resize: vertical;height: 150px;" row="20" name="textareaScopeImp" id="textareaScopeImp"></textarea>'
        append = append + '                                         <span class="invalid-feedback" style="display:none!important">Please Fill Out of Scope!</span>'
        append = append + '                              </div>'
        append = append + '                         </div>'
        append = append + '                     </div>'
        append = append + '                  <div class="table-responsive" name="divTableImp">'
        append = append + '                    <table class="table" name="tableImp" id="tableItemsImp_0">'
        append = append + '                        <thead>'
        append = append + '                            <tr>'
            append = append + '                            <th width=20%>'
            append = append + '                                Items'
            append = append + '                            </th>'
            append = append + '                            <th width=25%>'
            append = append + '                                Detail Items'
            append = append + '                            </th>'
            append = append + '                            <th width=5%>'
            append = append + '                                Qty'
            append = append + '                            </th>'
            append = append + '                            <th width=24%>'
            append = append + '                                Price'
            append = append + '                            </th>'
            append = append + '                            <th width=6%>'
            append = append + '                                Manpower'
            append = append + '                            </th>'
            append = append + '                            <th width=20%>'
            append = append + '                                Total'
            append = append + '                            </th>'
        append = append + '                                <td>'
        append = append + '                        <button class="btn btn-sm btn-linkedin" disabled id="btnAddConfigImp" onclick="addConfigImp(0)" style="width: 35px;"><i class="icon-base bx bx-plus"></i></button>'
        append = append + '                                </td>'
        append = append + '                            </tr>'
        append = append + '                        </thead>'
        append = append + '                        <tbody>'
        append = append + '                            <tr>'
        append = append + '                                <td>'
        append = append + '                                    <input type="" class="form-control" name="InputItemsImp" id="InputItemsImp" onkeyup="validateInput(this)" placeholder="Ex: PM Maintenance" style="width:150px">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <select type="" style="width:150px" class="select2 form-control detailItemsImp_0" name="detailItemsImp">'
        append = append + '                                        <option></option>'
        append = append + '                                    </select>'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <input type="number" style="width:60px" class="form-control" name="qtyItemsImp" id="qtyItemsImp" onkeyup="changeQtyItems(this)">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <input type="" class="form-control" name="priceItemsImp" id="priceItemsImp" disabled="" style="width:150px">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <input type="" style="width:60px" class="form-control" name="manpowerItemsImp" onkeyup="changeManPower(this)" id="manpowerItemsImp">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <input type="" class="form-control" name="totalItems" id="totalItems" disabled style="width:150px">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                <button class="btn btn-sm text-bg-danger" id="removeItemsDetailImp" onclick="removeItemsDetailImp(this,0)" style="width:35px;"><i class="icon-base bx bx-trash-alt"></i></button>'
        append = append + '                                </td>'
        append = append + '                            </tr>'
        append = append + '                        </tbody>'
        append = append + '                        <tfoot>'
        append = append + '                            <tr>'
        append = append + '                                <td colspan="4"></td>'
        append = append + '                                <th>Grand Total</th>'
        append = append + '                                <td><input style="width:150px" type="text" class="form-control" name="inputGrandTotal" disabled></td>'
        append = append + '                            </tr>'
        append = append + '                        </tfoot>'
        append = append + '                    </table>'
        append = append + '                  </div>'
        // append = append + '                    <hr>'
        append = append + '                    <div style="text-align:center;margin-top:10px">'
        append = append + '            <button class="btn btn-sm text-bg-primary" id="addItemsImp" style="margin: 0 auto;" onclick="addItemsImp(0)"><i class="icon-base bx bx-plus"></i>&nbsp Add Items</button>'
        append = append + '                    </div>'
        append = append + '                </div>'
        append = append + '                <div class="tab-pane" id="tab_3">'
        append = append + '                     <div class="row">'
        append = append + '                         <div class="col-md-12 mb-4">'
        append = append + '                             <div class="form-group">'
        append = append + '                                 <label>Duration*</label>'
        append = append + '                                 <input class="form-control" id="durationMnS" name="durationMnS" onkeyup="validateInput(this)" fdprocessedid="52jb4" placeholder="Input Duration">'
        append = append + '                                         <span class="invalid-feedback" style="display:none!important">Please Fill Duration!</span>'
        append = append + '                             </div>'
        append = append + '                         </div>'
        append = append + '                         <div class="col-md-6 mb-4">'
        append = append + '                             <div class="form-group">'
        append = append + '                                 <label>Scope Of Work*</label>'
        append = append + '                                      <textarea onkeyup="validateInput(this)" class="form-control" style="resize: vertical;height: 150px;" name="textareaSOWMnS" id="textareaSOWMnS"></textarea>'
        append = append + '                                         <span class="invalid-feedback" style="display:none!important">Please Fill Scope of Work!</span>'
        append = append + '                             </div>'
        append = append + '                         </div>'
        append = append + '                         <div class="col-md-6 mb-4">'
        append = append + '                             <div class="form-group">'
        append = append + '                                 <label>Out Of Scope*</label>'
        append = append + '                                      <textarea onkeyup="validateInput(this)" class="form-control" style="resize: vertical;height: 150px;" row="20" name="textareaScopeMnS" id="textareaScopeMnS"></textarea>'
        append = append + '                                         <span class="invalid-feedback" style="display:none!important">Please Fill Out of Scope!</span>'
        append = append + '                              </div>'
        append = append + '                         </div>'
        append = append + '                     </div>'
        append = append + '                     <div class="table-responsive" name="divTableMnS">'
        append = append + '                         <table class="table" name="tableMnS" id="tableItemsMnS_0" >'
            append = append + '                        <thead>'
            append = append + '                            <tr>'
                append = append + '                                <th width=20%>'
                append = append + '                                    Items'
                append = append + '                                </th>'
                append = append + '                                <th width=25%>'
                append = append + '                                    Detail Items'
                append = append + '                                </th>'
                append = append + '                                <th width=5%>'
                append = append + '                                    Qty'
                append = append + '                                </th>'
                append = append + '                                <th width=24%>'
                append = append + '                                    Price'
                append = append + '                                </th>'
                append = append + '                                <th width=6%>'
                append = append + '                                    Manpower'
                append = append + '                                </th>'
                append = append + '                                <th width=20%>'
                append = append + '                                    Total'
                append = append + '                                </th>'
            append = append + '                                <td>'
            append = append + '                              <button class="btn btn-sm btn-linkedin" disabled id="btnAddConfigMnS" onclick="addConfigMnS(0)" style="width: 35px;"><i class="icon-base bx bx-plus"></i></button>'
            append = append + '                                </td>'
            append = append + '                            </tr>'
            append = append + '                        </thead>'
        append = append + '                        <tbody>'
        append = append + '                            <tr>'
        append = append + '                                <td>'
        append = append + '                                    <input type="" class="form-control" name="InputItemsMnS" id="InputItemsMnS" onkeyup="validateInput(this)" placeholder="Ex: PM Maintenance" style="width:150px">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <select type="" style="width:150px" class="select2 form-control detailItemsMnS_0" name="detailItemsMnS">'
        append = append + '                                        <option></option>'
        append = append + '                                    </select>'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <input type="number" style="width:60px" class="form-control" name="qtyItemsMnS" id="qtyItemsMnS" onkeyup="changeQtyItems(this)">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <input type="" class="form-control" name="priceItemsMnS" id="priceItemsMnS" disabled="" style="width:150px">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <input type="" style="width:60px" class="form-control" name="manpowerItemsMnS" id="manpowerItemsMnS" onkeyup="changeManPower(this)">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                    <input type="" class="form-control" name="totalItems" id="totalItems" disabled style="width:150px">'
        append = append + '                                </td>'
        append = append + '                                <td>'
        append = append + '                                 <button class="btn btn-sm text-bg-danger" id="removeItemsDetailMnS" onclick="removeItemsDetailMnS(this,0)" style="width:35px;"><i class="icon-base bx bx-trash-alt"></i></button>'
        append = append + '                                </td>'
        append = append + '                            </tr>'
        append = append + '                        </tbody>'
        append = append + '                        <tfoot>'
        append = append + '                            <tr>'
        append = append + '                                <td colspan="4"></td>'
        append = append + '                                <th>Grand Total</th>'
        append = append + '                                <td><input type="text" class="form-control" name="inputGrandTotal" disabled style="width:150px"></td>'
        append = append + '                            </tr>'
        append = append + '                        </tfoot>'
        append = append + '                    </table>'
        append = append + '                   </div>'
        // append = append + '                    <hr>'
        append = append + '                    <div style="text-align:center;margin-top:10px">'
        append = append + '            <button class="btn btn-sm text-bg-primary" id="addItemsMns" style="margin: 0 auto;" onclick="addItemsMnS(0)"><i class="icon-base bx bx-plus"></i>&nbsp Add Items</button>'
        append = append + '                    </div>'
        append = append + '                </div>'
        append = append + '            </div>'
        append = append + '        </div>'
        append = append + '    </div>'
        append = append + '</div>'
        append = append + '<div class="row">'
        append = append + '    <div class="col-md-12 col-xs-12" style="text-align:right">'
        append = append + '        <a class="btn btn-sm text-bg-danger" style="margin-right:10px" href="{{url("/sbe_index")}}">Cancel</a>'
        append = append + '        <button class="btn btn-sm text-bg-primary" onclick="saveConfig()">Save</button>'
        append = append + '    </div>'
        append = append + '</div>'
        append = append + '            </div>'
        append = append + '        </div>'

        $(".content").append(append)
        $('input[name="qtyItems"]','input[name="qtyItemsImp"]','input[name="qtyItemsMnS"]').attr("type","number")         

        $.ajax({
            url: "{{'/sbe/getLead'}}",
            type: 'GET',success:function(result){
                $("#inputLead").select2({
                    data:result,
                    placeholder:'Select Lead Id',
                })
                // .on('select2:select', function (e) {
                //     var data = e.params.data

                    
                //     $.ajax({
                //         url: "{{'/sbe/getSoWbyLeadID'}}",
                //         data:{
                //             lead_id:data.id
                //         },
                //         type: 'GET',
                //         success:function(result){
                            
                //             if (result != null) {
                //                  $("#textareaSOW").val(result.sow)
                //                 $("#textareaScope").val(result.oos)
                //             }
                //         }
                //     })
                // })
            }
        })

        getDropdownDetailItems(0,"SO")
        getDropdownDetailItems(0,"Imp")
        getDropdownDetailItems(0,"MnS")
        
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var inputValue = $('ul li.active').find("input").val()
            $("#inputDuration").val(inputValue)
            cekTableLength(arrTableSO,arrTableImp,arrTableMnS,"tab")
            $("#inputDuration").css("border-color","#d2d6de")
        });
    }

    function checkInnerHeight(){
        // 
        var configs = $("#configs").innerHeight()
        var temporaryFunction = $("#temporaryFunction").innerHeight()

        if (configs > temporaryFunction) {
            $("#temporaryFunction").innerHeight($("#configs").innerHeight())
        }else{
            $("#configs").innerHeight($("#temporaryFunction").innerHeight())
        }
        
        // if (id == "configs") {
        //     $("#temporaryFunction").innerHeight($("#configs").innerHeight())
        // }

        // if (id == "temporaryFunction") {
        //     $("#configs").innerHeight($("#temporaryFunction").innerHeight())
        // }
        
       
    }

    function getDropdownDetailItems(value,type,item){
        $.ajax({
            url:"{{url('/sbe/getDropdownDetailItem')}}",
            type:"GET",
            success:function(result){
                $(".detailItems"+ type + "_" +value).select2({
                    placeholder:"Select Detail Items",
                    data:result.data,
                    width: 'resolve'
                }).on("change",function(e){
                
                    // var priceTotal = 0
                    // var priceGrandTotal = 0
                    // priceTotal += parseFloat($(this).closest("tr").find("td").eq(3).find("input").val().replaceAll(".","")) * $(this).closest("tr").find("td").eq(2).find("input").val() == '' ? 1 : parseFloat($(this).closest("tr").find("td").eq(2).find("input").val()) * $(this).closest("tr").find("td").eq(4).find("input").val() == '' ? 1 : parseFloat($(this).closest("tr").find("td").eq(4).find("input").val())

                    // 

                    // $(this).closest("tr").find("td").eq(5).find("input").val(priceTotal)

                    // $(this).closest("table").closest("tbody tr").each(function(item,result){
                    //     $(this).closest("table").find("input[name='inputGrandTotal']").val(priceGrandTotal)
                    // })

                    // 
                }).on('select2:select', function (e) {
                    var data = e.params.data;
                    
                    $(this).closest("tr").find("td").eq(3).find("input").val(formatter.format(data.price))

                    var priceTotal = 0
                    var priceGrandTotal = 0
                    priceTotal += parseInt(data.price)
                    priceTotal *= $(this).closest("tr").find("td").eq(2).find("input").val() == '' ? 1 : parseInt($(this).closest("tr").find("td").eq(2).find("input").val())  
                    priceTotal *= $(this).closest("tr").find("td").eq(4).find("input").val() == '' ? 1 : parseInt($(this).closest("tr").find("td").eq(4).find("input").val())

                    $(this).closest("tr").find("td").eq(5).find("input").val(formatter.format(priceTotal))

                    $(this).closest("table").find("tbody tr").each(function(item,result){
                        $(result).find(".form-control").each(function(itemInput,resultItem){
                            if(resultItem.name == "totalItems"){
                                priceGrandTotal += parseInt($(this).closest("tr").find("td").eq(5).find("input").val().replaceAll(".",""))
                                
                            }
                        })
                        $(this).closest("table").find("input[name='inputGrandTotal']").val(formatter.format(priceGrandTotal))
                    })

                });

                if (type == "Update") {
                    $("#tableItemsUpdateConfig_"+item).find(".detailItems"+ type +"_"+ value +":last").next().next().remove()
                }else{
                    $(".detailItems"+ type +"_"+ value +":last").next().next().remove()    
                }
            }
        })
    }

    function changeQtyItems(val){
        
        var priceTotal = 0
        var priceGrandTotal = 0
        var sumPriceGrandTotal = 0

        priceTotal += $(val).closest("tr").find("td").eq(2).find("input").val() == '' ? parseInt($(val).closest("tr").find("td").eq(3).find("input").val().replaceAll(".","")) : parseInt($(val).closest("tr").find("td").eq(2).find("input").val()) * parseInt($(val).closest("tr").find("td").eq(3).find("input").val().replaceAll(".",""))

        priceTotal *= $(val).closest("tr").find("td").eq(4).find("input").val() == '' ? 1 : parseInt($(val).closest("tr").find("td").eq(4).find("input").val()) 

        // priceTotal *= $(val).closest("tr").find("td").eq(4).find("input").val() == '' ? 1 : parseInt($(val).closest("tr").find("td").eq(4).find("input").val())
        
        $(val).closest("tr").find("td").eq(5).find("input").val(formatter.format(priceTotal))

        $(val).closest("table").find("tbody").each(function(item,result){
            $(result).find(".form-control").each(function(itemInput,resultItem){
                if(resultItem.name == "totalItems"){
                    priceGrandTotal += parseInt(resultItem.value.replaceAll(".",""))
                    
                }
            })
        })

        $(val).closest("table").find("input[name='inputGrandTotal']").val(formatter.format(priceGrandTotal))

        $("table[name='tableUpdateConfig']").find("input[name='inputGrandTotal']").each(function(index,item){
            sumPriceGrandTotal += parseInt(item.value.replaceAll(".",""))
        })

        $("#inputSumPriceGrandTotal").val(formatter.format(sumPriceGrandTotal))

    }

    function changeManPower(val){
        var priceTotal = 0
        var priceGrandTotal = 0
        var sumPriceGrandTotal = 0

        priceTotal += $(val).closest("tr").find("td").eq(4).find("input").val() == '' ? parseInt($(val).closest("tr").find("td").eq(3).find("input").val().replaceAll(".","")) : parseInt($(val).closest("tr").find("td").eq(4).find("input").val()) * parseInt($(val).closest("tr").find("td").eq(3).find("input").val().replaceAll(".",""))

        priceTotal *= $(val).closest("tr").find("td").eq(2).find("input").val() == '' ? 1 : parseInt($(val).closest("tr").find("td").eq(2).find("input").val())
        
        $(val).closest("tr").find("td").eq(5).find("input").val(formatter.format(priceTotal))

        $(val).closest("table").find("tbody").each(function(item,result){
            $(result).find(".form-control").each(function(itemInput,resultItem){
                if(resultItem.name == "totalItems"){
                    priceGrandTotal += parseInt(resultItem.value.replaceAll(".",""))
                    
                }
            })
        })

        $(val).closest("table").find("input[name='inputGrandTotal']").val(formatter.format(priceGrandTotal))

        $("table[name='tableUpdateConfig']").find("input[name='inputGrandTotal']").each(function(index,item){
            sumPriceGrandTotal += parseInt(item.value.replaceAll(".",""))
        })
        $("#inputSumPriceGrandTotal").val(formatter.format(sumPriceGrandTotal))
    }

    function showTemporarySBE(value){
        temporarySBE(value)
        localStorage.setItem('isConfigPage',true)
        $("#btnBack").removeAttr('href')
        $("#btnBack").attr('onclick','showFunctionConfig()')
    }

    function temporarySBE(value){
        $(".content").empty("")
        $.ajax({
            type:"GET",
            cache: false, 
            url:"{{url('/sbe/getDetailConfig')}}",
            data:{
                id_config_sbe:value
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
            // async: false,
            success:function(result){
                    var append = "", i = 0, z = 0, j = 0, loopInt = 0
                    append = append + '<div class="card">'
                    append = append + '    <div class="card-body">'
                    append = append + '<div class="row">'
                    append = append + '    <div class="col-md-6">'
                    append = append + '        <div class="form-group">'
                    append = append + '            <label>Project Location*</label>'
                    append = append + '            <textarea class="form-control" style="resize: vertical;">'+ result.project_location +'</textarea>'
                    append = append + '        </div>'
                    append = append + '        <div class="form-group">'
                    append = append + '            <label>Duration*</label>'
                    append = append + '            <input type="text" class="form-control" name="" value="'+ result.duration +'">'
                    append = append + '        </div>'
                    append = append + '        <div class="form-group">'
                    append = append + '            <label>Estimated Running*</label>'
                    append = append + '            <input type="text" class="form-control" name="" value="'+ result.estimated_running +'">'
                    append = append + '        </div>'
                    append = append + '    </div>'
                    append = append + '    <div class="col-md-6">'
                    append = append + '        <div class="form-group">'
                    append = append + '            <label>Scope Of Work*</label>'
                    append = append + '            <textarea class="form-control" style="resize: vertical;height: 150px;">'+ result.sow +'</textarea>'
                    append = append + '        </div>'
                    append = append + '        <div class="form-group">'
                    append = append + '            <label>Out Of Scope*</label>'
                    append = append + '            <textarea class="form-control" style="resize: vertical;height: 150px;" row="20">'+ result.oos +'</textarea>'
                    append = append + '        </div>'
                    append = append + '    </div>'
                    append = append + '</div>'
                    append = append + '<div class="row">'
                    append = append + ' <div class="col-md-12 col-xs-12">'
                    append = append + '     <label>Config*</label>'                                     
                    append = append + '<div class="table-responsive">'
                    $.each(result.detail_config, function(key, results){
                        i++
                        append = append + ' <table class="table" name="tableShowConfig" id="tableShowConfig_'+ i +'" style="width:100%">'
                        append = append + '    <thead>'
                        append = append + '        <tr>'
                        append = append + '            <th width=20%'
                        append = append + '                Items'
                        append = append + '            </th>'
                        append = append + '            <th width=30%>'
                        append = append + '                Detail Items'
                        append = append + '            </th>'
                        append = append + '            <th width=5%>'
                        append = append + '                Qty'
                        append = append + '            </th>'
                        append = append + '            <th width=20%>'
                        append = append + '                Price'
                        append = append + '            </th>'
                        append = append + '            <th width=5%>'
                        append = append + '                Manpower'
                        append = append + '            </th>'
                        append = append + '            <th width=20%>'
                        append = append + '                Total'
                        append = append + '            </th>'
                        append = append + '        </tr>'
                        append = append + '    </thead>'
                        append = append + '<tbody>'

                        Object.keys(results).forEach(function(keys) {
                            j++
                            var resultsDetail = results[keys];

                            append = append + ' <tr>'
                            append = append + '     <td>'
                            append = append + '       <input type="" style="width:150px" class="form-control" name="inputItemsTemporary" id="" value="'+ key +'" placeholder="Ex: PM Maintenance">'
                            append = append + '     </td>'
                            append = append + '     <td>'
                            append = append + '       <select type="" style="width:150px" class="select2 form-control detailItemsTemporary_'+ j +'" name="detailItemsTemporary" id="detailItemsTemporary">'
                            append = append + '             <option></option>'
                            append = append + '       </select>'
                            append = append + '     </td>'
                            append = append + '     <td>'
                            append = append + '         <input type="number" style="width:60px" class="form-control" name="" id="" value="'+ resultsDetail.qty +'">'
                            append = append + '     </td>'
                            append = append + '     <td>'
                            append = append + '         <input type="" class="form-control priceItemsUpdate_'+ j +'" name="" id="" disabled="" value="'+ formatter.format(resultsDetail.price) +'" style="width:150px">'
                            append = append + '     </td>'
                            append = append + '     <td>'
                            append = append + '         <input type="" style="width:60px" class="form-control" name="manpowerItemsUpdate" id="" value="'+ resultsDetail.manpower +'">'
                            append = append + '     </td>'
                            append = append + '     <td>'
                            append = append + '         <input type="" class="form-control totalItemsTemporary_'+ j +'" name="totalItems" id="totalItemsUpdate" disabled value="'+ formatter.format(resultsDetail.total_nominal) +'" style="width:150px">'
                            append = append + '     </td>'
                            append = append + '     <td></td>'
                            append = append + ' </tr>' 
                            // $(".detailItemsTemporary_"+z).select2().val(resultsDetail.detail_item).trigger("change")
                        });

                        $.ajax({
                            url:"{{url('/sbe/getDropdownDetailItem')}}",
                            type:"GET",
                            success:function(result){ 
                                Object.keys(results).forEach(function(keys) {
                                    var resultsDetail = results[keys];

                                    loopInt++ 
                                    $("#tableShowConfig_"+i).each(function(item,results){
                                        $(".detailItemsTemporary_"+loopInt).select2({
                                            placeholder:"Select Detail Items",
                                            data:result.data,
                                            disabled:true
                                        }).val(resultsDetail.detail_item).trigger("change")                                           
                                    })
                                })                                    
                            }
                        })

                        append = append + '        </tbody>'
                        append = append + '        <tfoot>'
                        append = append + '          <tr>'
                        append = append + '           <td colspan="4"></td>'
                        append = append + '           <th>Total Cost</th>'
                        append = append + '           <td colspan=2><input type="text" class="form-control" name="inputGrandTotal" id="inputGrandTotal" disabled style="width:150px"></td>'
                        append = append + '          </tr>'
                        append = append + '        </tfoot>'
                        append = append + ' </table>'
                    })
                    append = append + '</div>'
                    append = append + '         </div>'
                    append = append + '             </div>'
                    append = append + '      </div>'
                    append = append + '</div>'

                    $(".content").append(append)
                    $("table[name='tableShowConfig']:last").find("tr:last").after("<tr><th colspan=5 style='text-align:right'>Grand Total Cost</th><td colspan=2><input class='form-control' style='text-align:right;width: 150px;' id='inputSumPriceGrandTotal' name='inputSumPriceGrandTotal'/></td></tr>")

                    var j = 0
                    $.each(result.detail_config, function(key, results){
                        j++
                        var priceGrandTotal = 0
                        $("#tableShowConfig_"+j).find("tbody tr").each(function(item,result){
                            $(result).find(".form-control").each(function(itemInput,resultItem){
                                if(resultItem.name == "totalItems"){
                                    priceGrandTotal += parseInt($(this).closest("tr").find("td").eq(5).find("input").val().replaceAll(".",""))
                                }
                            })
                            $("#tableShowConfig_"+ j).find("input[name='inputGrandTotal']").val(formatter.format(priceGrandTotal))
                        })

                        $("#tableShowConfig_"+j).find("tbody tr:not(:first-child)").each(function(item,result){
                            $(result).find(".form-control").each(function(v,w){
                                if(w.name == "inputItemsTemporary"){
                                    $(w).attr('style', 'display: none !important');
                                }
                            })
                        })  
                    })

                    $("input,select,textarea").attr("disabled",true)  

                    var sumPriceGrandTotal = 0
                    $("table[name='tableShowConfig']").find("input[name='inputGrandTotal']").each(function(index,item){
                        sumPriceGrandTotal += parseInt(item.value.replaceAll(".",""))
                    })
                    $("#inputSumPriceGrandTotal").val(formatter.format(sumPriceGrandTotal))
            }
        })
    }

    function sortReponse(data)
    {
        data.sort(function(a, b) {
          var nameA = a.name.toUpperCase(); // ignore upper and lowercase
          var nameB = b.name.toUpperCase(); // ignore upper and lowercase
          if (nameA < nameB) {
            return -1;
          }
          if (nameA > nameB) {
            return 1;
          }
          // names must be equal
          return 0;
        });

    }

    //for create SBE
    //Supply Only
    function addConfigSO(val){
        var countable = $("table[name='tableSO']").length
        var cloneTr = $("#tableItemsSO_"+val).find("tbody tr:first").clone()
        // cloneTr
        cloneTr.find(":input[name='qtyItems']").val('').end().find(":input[name='priceItems']").val('').end().find(":input[name='manpowerItems']").val('').end().find(":input[name='totalItems']").val('').end()
        cloneTr.find(":input[name='InputItems']").attr('style', 'display: none !important');
        // cloneTr[0].children[0].firstElementChild.attr('style', 'display: none !important');
        cloneTr.find("td:last").html("<button onclick='removeItemsDetailSO(this,"+ val +")' class='btn btn-sm text-bg-danger' style='width:35px'><i class='icon-base bx bx-trash-alt'></i></button>")

        cloneTr.children("select")
            .select2("destroy")
            .end()

        $("#tableItemsSO_"+val).append(cloneTr)
        getDropdownDetailItems(val,"SO")
    }

    function removeItemsDetailSO(element,val){
        if ($("#tableItemsSO_"+val).find('tbody').find('tr').length == 1) {
            var whichtr = $(element).closest('td').closest('tr').closest('tbody').closest('table')
        }else{
            var whichtr = element.closest("tr");
        }
        
        var priceGrandTotal = 0
        $(element).closest("table").find("tbody tr:not(:eq("+$(element).closest('tr').index()+"))").each(function(item,result){
            $(result).find(".form-control").each(function(itemInput,resultItem){
                if(resultItem.name == "totalItems"){
                    priceGrandTotal += parseInt($(this).closest("tr").find("td").eq(5).find("input").val().replaceAll(".",""))
                }
            })
        })    

        $(element).closest("table").find("input[name='inputGrandTotal']").val(formatter.format(priceGrandTotal))
        whichtr.remove(); 
        if ($("#tableItemsSO_"+val).find('tbody').find('tr').length > 1) {
            $("#tableItemsSO_"+val).find('tbody').find('tr:first').find("td:first").find(":input[name='InputItems']").show()
        }
    }

    var arrTableSO = [], arrTableImp = [], arrTableMnS = []
    function addItemsSO(val){
        var countable = $("table[name='tableSO']").length + 1

        if (countable >= 1) {
            arrTableSO.push(countable)
            $(".nav-tabs-custom").find(".alert").remove()
        }

        // if ($("table[name='tableSO']").is(":visible") == false) {
        //     $("table[name='tableSO']").show()
        // }else{            
            var append = ""
            append = append + ' <table class="table" name="tableSO" id="tableItemsSO_'+ countable +'">'
            append = append + '     <thead>'
            append = append + '         <tr>'
            append = append + '        <th width=20%>'
            append = append + '            Items'
            append = append + '        </th>'
            append = append + '        <th width=25%>'
            append = append + '            Detail Items'
            append = append + '        </th>'
            append = append + '        <th width=5%>'
            append = append + '            Qty'
            append = append + '        </th>'
            append = append + '        <th width=24%>'
            append = append + '            Price'
            append = append + '        </th>'
            append = append + '        <th width=6%>'
            append = append + '            Manpower'
            append = append + '        </th>'
            append = append + '        <th width=20%>'
            append = append + '            Total'
            append = append + '        </th>'
                append = append + '        <th>'
                append = append + '           <button class="btn btn-sm btn-linkedin" disabled="true" id="btnAddConfigSO" onclick="addConfigSO('+ countable +')" style="width: 35px;"><i class="icon-base bx bx-plus"></i></button>'
                append = append + '        </th>'
                append = append + '  </tr>'
            append = append + '     </thead>'
            append = append + '     <tbody>'
            append = append + '         <tr>'
            append = append + '             <td>'
            append = append + '                 <input type="" class="form-control" name="InputItems" id="InputItems" onkeyup="validateInput(this)" placeholder="Ex: PM Maintenance" style="width:150px">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <select type="" style="width:150px" class="select2 form-control detailItemsSO_'+ countable +'" name="detailItemsSO">'
            append = append + '                     <option></option>'
            append = append + '                 </select>'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <input type="number" style="width:60px" class="form-control" name="qtyItems" id="qtyItems" onkeyup="changeQtyItems(this)">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <input type="" class="form-control" name="priceItems" id="priceItems" disabled="" style="width:150px">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <input type="" style="width:60px" class="form-control" name="manpowerItems" id="manpowerItems" onkeyup="changeManPower(this)">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <input type="" class="form-control" name="totalItems" id="totalItems" disabled style="width:150px">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + ' <button class="btn btn-sm text-bg-danger" id="removeItemsDetailSO" onclick="removeItemsDetailSO(this,'+ countable +')" style="width:35px;"><i class="icon-base bx bx-trash-alt"></i></button>'
            append = append + '             </td>'
            append = append + '         </tr>'
            append = append + '     </tbody>'
            append = append + '     <tfoot>'
            append = append + '         <tr>'
            append = append + '             <td colspan="4"></td>'
            append = append + '             <th>Grand Total</th>'
            append = append + '             <td><input type="text" class="form-control" name="inputGrandTotal" disabled style="width:150px"></td>'
            append = append + '         </tr>'
            append = append + '     </tfoot>'
            append = append + '</table>'

            if ($("table[name='tableSO']").is(":visible")) {
                $("table[name='tableSO']:last").after(append)
            }else{
                $('div[name="divTableSO"]').append(append)
            }
            getDropdownDetailItems(countable,"SO")
        // }   

        if (countable > 0) {
            if ($("#removeItemsSO").length < 1) {
                $("#addItemsSO").after("<button class='btn btn-sm text-bg-danger' id='removeItemsSO' onclick='removeItemsSO()' style='width:35px;margin-left:10px'><i class='icon-base bx bx-trash-alt'></i></button>")
            }
        }       

    }

    function removeItemsSO(){
        var countable = $("table[name='tableSO']").length
    
        if (countable == 1) {
            $("table[name='tableSO']").attr('style', 'display: none !important');
            arrTableSO = []
            $("#removeItemsSO").remove()
        }else{
            var whichtr = $("table[name='tableSO']:last");
            whichtr.remove();
        } 
    }

    //Implementation
    function addConfigImp(val){
        var cloneTr = $("#tableItemsImp_"+val).find("tbody tr:first").clone()
        // cloneTr
        cloneTr.find(":input[name='qtyItemsImp']").val('').end().find(":input[name='priceItemsImp']").val('').end().find(":input[name='manpowerItemsImp']").val('').end().find(":input[name='totalItems']").val('').end()
        cloneTr.find(":input[name='InputItemsImp']").attr('style', 'display: none !important');
        // cloneTr[0].children[0].firstElementChild.remove()
        cloneTr.find("td:last").html("<button onclick='removeItemsDetailImp(this,"+ val +")' class='btn btn-sm text-bg-danger' style='width:35px'><i class='icon-base bx bx-trash-alt'></i></button>")

        cloneTr.children("select")
            .select2("destroy")
            .end()

        $("#tableItemsImp_"+val).append(cloneTr)

        getDropdownDetailItems(val,"Imp")
        $(".detailItemsImp_"+val).last().next().next().remove()  
    }

    function removeItemsDetailImp(element,val){
        if ($("#tableItemsImp_"+val).find('tbody').find('tr').length == 1) {
            var whichtr = $(element).closest('td').closest('tr').closest('tbody').closest('table')
        }else{
            var whichtr = element.closest("tr");
        }

        var priceGrandTotal = 0
        $(element).closest("table").find("tbody tr:not(:eq("+$(element).closest('tr').index()+"))").each(function(item,result){
            $(result).find(".form-control").each(function(itemInput,resultItem){
                if(resultItem.name == "totalItems"){
                    priceGrandTotal += parseInt($(this).closest("tr").find("td").eq(5).find("input").val().replaceAll(".",""))
                }                
            })
        })    

        $(element).closest("table").find("input[name='inputGrandTotal']").val(formatter.format(priceGrandTotal))

        whichtr.remove();   
        if ($("#tableItemsImp_"+val).find('tbody').closest('tr').length > 1) {
            $("#tableItemsImp_"+val).find('tbody').find('tr:first').find("td:first").find(":input[name='InputItems']").show()
        }
    }

    function addItemsImp(val){
        // 
        var countable = $("table[name='tableImp']").length + 1

        if (countable > 0) {
            arrTableImp.push(countable)
            $(".nav-tabs-custom").find(".alert").remove()
        }

        // if ($("table[name='tableImp']").is(":visible") == false) {
        //     $("table[name='tableImp']").show()
        // }else{
            var append = ""
            append = append + '<table class="table" name="tableImp" id="tableItemsImp_'+ countable +'">'
            append = append + '<thead>'
            append = append + '   <tr>'
            append = append + '        <th width=20%>'
            append = append + '            Items'
            append = append + '        </th>'
            append = append + '        <th width=25%>'
            append = append + '            Detail Items'
            append = append + '        </th>'
            append = append + '        <th width=5%>'
            append = append + '            Qty'
            append = append + '        </th>'
            append = append + '        <th width=24%>'
            append = append + '            Price'
            append = append + '        </th>'
            append = append + '        <th width=6%>'
            append = append + '            Manpower'
            append = append + '        </th>'
            append = append + '        <th width=20%>'
            append = append + '            Total'
            append = append + '        </th>'
            append = append + '        <th>'
            append = append + '           <button class="btn btn-sm btn-linkedin" disabled="true" id="btnAddConfigImp" onclick="addConfigImp('+ countable +')" style="width: 35px;"><i class="icon-base bx bx-plus"></i></button>'
            append = append + '   </th>'
            append = append + '  </tr>'
            append = append + '</thead>'
            append = append + '     <tbody>'
            append = append + '         <tr>'
            append = append + '             <td>'
            append = append + '                 <input type="" class="form-control" name="InputItemsImp" id="InputItems" onkeyup="validateInput(this)" placeholder="Ex: PM Maintenance" style="width:150px">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <select type="" style="width:150px" class="select2 form-control detailItemsImp_'+ countable +'" name="detailItemsImp">'
            append = append + '                     <option></option>'
            append = append + '                 </select>'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <input type="number" style="width:60px" class="form-control" name="qtyItemsImp" id="qtyItems" onkeyup="changeQtyItems(this)">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <input type="" class="form-control" name="priceItemsImp" disabled="" id="priceItems" style="width:150px">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <input type="" style="width:60px" class="form-control" name="manpowerItemsImp" id="manpowerItems" onkeyup="changeManPower(this)">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <input type="" class="form-control" name="totalItems" id="totalItems" disabled style="width:150px">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '             <button class="btn btn-sm text-bg-danger" id="removeItemsDetailImp" onclick="removeItemsDetailImp(this,'+ countable +')" style="width:35px"><i class="icon-base bx bx-trash-alt"></i></button>'
            append = append + '             </td>'
            append = append + '         </tr>'
            append = append + '     </tbody>'
            append = append + '     <tfoot>'
            append = append + '         <tr>'
            append = append + '             <td colspan="4"></td>'
            append = append + '             <th>Grand Total</th>'
            append = append + '             <td><input type="text" class="form-control" name="inputGrandTotal" disabled style="width:150px"></td>'
            append = append + '         </tr>'
            append = append + '     </tfoot>'
            append = append + '</table>'
            // $("select").select2()
            if ($("table[name='tableImp']").is(":visible")) {

                $("table[name='tableImp']:last").after(append)
            }else{
                $('div[name="divTableImp"]').append(append)
            }
            getDropdownDetailItems(countable,"Imp")
        // }

        if (countable > 0) {
            if ($("#removeItemsImp").length < 1) {
                $("#addItemsImp").after("<button class='btn btn-sm text-bg-danger' id='removeItemsImp' onclick='removeItemsImp()' style='width:35px;margin-left:10px'><i class='icon-base bx bx-trash-alt'></i></button>")
            }
        }
        
    }

    function removeItemsImp(){
        var countable = $("table[name='tableImp']").length

        if (countable == 1) {
            $("table[name='tableImp']").attr('style', 'display: none !important');
            arrTableImp = []
            $("#removeItemsImp").remove()
        }else{
            var whichtr = $("table[name='tableImp']:last");
            whichtr.remove();
        }
    
    }

    //Maintenance
    function addConfigMnS(val){
        var cloneTr = $("#tableItemsMnS_"+val).find("tbody tr:first").clone()
        // cloneTr
        cloneTr.find(":input[name='qtyItemsMnS']").val('').end().find(":input[name='priceItemsMnS']").val('').end().find(":input[name='manpowerItemsMnS']").val('').end().find(":input[name='totalItems']").val('').end()
        cloneTr.find(":input[name='InputItemsMnS']").attr('style', 'display: none !important');
        // cloneTr[0].children[0].firstElementChild.remove()
        cloneTr.find("td:last").html("<button onclick='removeItemsDetailMnS(this,"+ val +")' class='btn btn-sm text-bg-danger' style='width:35px'><i class='icon-base bx bx-trash-alt'></i></button>")

        cloneTr.children("select")
            .select2("destroy")
            .end()

        $("#tableItemsMnS_"+val).append(cloneTr)

        getDropdownDetailItems(val,"MnS")
        $(".detailItemsMnS_"+val).last().next().next().remove()   
    }

    function removeItemsDetailMnS(element,val){
        if ($("#tableItemsMnS_"+val).find('tbody').find('tr').length == 1) {
            var whichtr = $(element).closest('td').closest('tr').closest('tbody').closest('table')
        }else{
            var whichtr = element.closest("tr");
        }

        var priceGrandTotal = 0
        $(element).closest("table").find("tbody tr:not(:eq("+$(element).closest('tr').index()+"))").each(function(item,result){
            $(result).find(".form-control").each(function(itemInput,resultItem){
                if(resultItem.name == "totalItems"){
                    priceGrandTotal += parseInt($(this).closest("tr").find("td").eq(5).find("input").val().replaceAll(".",""))
                }
            })
        })    

        $(element).closest("table").find("input[name='inputGrandTotal']").val(formatter.format(priceGrandTotal))

        whichtr.remove();
        if ($("#tableItemsMnS_"+val).find('tbody').find('tr').length > 1) {
            $("#tableItemsMnS_"+val).find('tbody').find('tr:first').find("td:first").find(":input[name='InputItems']").show()
        }
    }

    function addItemsMnS(val){
        // conMnSle.log(val)
        var countable = $("table[name='tableMnS']").length + 1

        if (countable > 0) {
            arrTableMnS.push(countable)
            $(".nav-tabs-custom").find(".alert").remove()
        }

        // if ($("table[name='tableMnS']").is(":visible") == false) {
        //     $("table[name='tableMnS']").show()
        // }else{
            var append = ""
            append = append + '<table class="table" name="tableMnS" id="tableItemsMnS_'+ countable +'">'
            append = append + '<thead>'
            append = append + '   <tr>'
            append = append + '        <th width=20%>'
            append = append + '            Items'
            append = append + '        </th>'
            append = append + '        <th width=25%>'
            append = append + '            Detail Items'
            append = append + '        </th>'
            append = append + '        <th width=5%>'
            append = append + '            Qty'
            append = append + '        </th>'
            append = append + '        <th width=24%>'
            append = append + '            Price'
            append = append + '        </th>'
            append = append + '        <th width=6%>'
            append = append + '            Manpower'
            append = append + '        </th>'
            append = append + '        <th width=20%>'
            append = append + '            Total'
            append = append + '        </th>'
            append = append + '        <th>'
            append = append + '           <button class="btn btn-sm btn-linkedin" disabled="true" id="btnAddConfigMnS" onclick="addConfigMnS('+ countable +')" style="width: 35px;"><i class="icon-base bx bx-plus"></i></button>'
            append = append + '   </th>'
            append = append + '  </tr>'
            append = append + '</thead>'
            append = append + '     <tbody>'
            append = append + '         <tr>'
            append = append + '             <td>'
            append = append + '                 <input type="" class="form-control" style="width:150px" name="InputItemsMnS" id="InputItems" onkeyup="validateInput(this)" placeholder="Ex: PM Maintenance">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <select type="" style="width:150px" class="select2 form-control detailItemsMnS_'+ countable +'" name="detailItemsMnS">'
            append = append + '                     <option></option>'
            append = append + '                 </select>'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <input type="number" style="width:60px" class="form-control" name="qtyItemsMnS" id="qtyItems" onkeyup="changeQtyItems(this)">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <input type="" class="form-control" name="priceItemsMnS" id="priceItems" disabled="" style="width:150px">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <input type="" style="width:60px" class="form-control" id="manpowerItems" name="manpowerItemsMnS" onkeyup="changeManPower(this)">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '                 <input type="" class="form-control" name="totalItems" id="totalItems" disabled style="width:150px">'
            append = append + '             </td>'
            append = append + '             <td>'
            append = append + '<button class="btn btn-sm text-bg-danger" id="removeItemsDetailMnS" onclick="removeItemsDetailMnS(this,'+ countable +')" style="width:35px"><i class="icon-base bx bx-trash-alt"></i></button>'
            append = append + '             </td>'
            append = append + '         </tr>'
            append = append + '     </tbody>'
            append = append + '     <tfoot>'
            append = append + '         <tr>'
            append = append + '             <td colspan="4"></td>'
            append = append + '             <th>Grand Total</th>'
            append = append + '             <td><input type="text" class="form-control" name="inputGrandTotal" disabled style="width:150px"></td>'
            append = append + '         </tr>'
            append = append + '     </tfoot>'
            append = append + '</table>'

            if ($("table[name='tableMnS']").is(":visible")) {
                $("table[name='tableMnS']:last").after(append)
            }else{
                console.log(val)
                $('div[name="divTableMnS"]').append(append)
            }
            getDropdownDetailItems(countable,"MnS")
        // }

        $("#addItemsMns").after("<button class='btn btn-sm text-bg-danger' id='removeItemsMnS' onclick='removeItemsMnS()' style='width:35px;margin-left:10px'><i class='icon-base bx bx-trash-alt'></i></button>")
        if (countable > 0) {
            if ($("#removeItemsMnS").length < 1) {
                $("#addItemsMns").after("<button class='btn btn-sm text-bg-danger' id='removeItemsMnS' onclick='removeItemsMnS()' style='width:35px;margin-left:10px'><i class='icon-base bx bx-trash-alt'></i></button>")
            }
        }
    }

    function removeItemsMnS(){
        var countable = $("table[name='tableMnS']").length

        if (countable == 1) {
            $("table[name='tableMnS']").attr('style', 'display: none !important');
            arrTableMnS = []
            $("#removeItemsMnS").remove()
        }else{
            var whichtr = $("table[name='tableMnS']:last");
            whichtr.remove();
        }
    }

    //re-initiate show update config
    function showUpdateConfigSO(value){
        updateConfigSBE(value)
        localStorage.setItem('isConfigPage',true)
        $("#btnBack").removeAttr('href')
        $("#btnBack").attr('onclick','showFunctionConfig()')
    }

    function updateConfigSBE(value){
        $(".content").empty("")

        var append = ""
        $.ajax({
            type:"GET",
            cache:false,
            url:"{{url('/sbe/getDetailConfig')}}",
            data:{
                id_config_sbe:value
            },success:function(result){
                append = append + '<div class="card">'
                append = append + '    <div class="card-body">'
                append = append + '<div class="row">'
                append = append + '    <div class="col-md-6">'
                append = append + '        <div class="form-group mb-4">'
                append = append + '            <label>Project Location*</label>'
                append = append + '            <textarea class="form-control" style="resize: vertical;" name="textareaLocUpdate" id="textareaLocUpdate">'+ result.project_location +'</textarea>'
                append = append + '        </div>'
                append = append + '        <div class="form-group mb-4">'
                append = append + '            <label>Duration*</label>'
                append = append + '            <input type="text" class="form-control" name="inputDurationUpdate" id="inputDurationUpdate" value="'+ result.duration +'">'
                append = append + '        </div>'
                append = append + '        <div class="form-group mb-4">'
                append = append + '            <label>Estimated Running*</label>'
                append = append + '            <input type="text" class="form-control" name="inputEstimateRunUpdate" id="inputEstimatedRunUpdate" value="'+ result.estimated_running +'">'
                append = append + '        </div>'
                append = append + '    </div>'
                append = append + '    <div class="col-md-6">'
                append = append + '        <div class="form-group mb-4">'
                append = append + '            <label>Scope Of Work*</label>'
                append = append + '            <textarea class="form-control" style="resize: vertical;height: 150px;" name="textareaSOWUpdate" id="textareaSOWUpdate">'+ result.sow +'</textarea>'
                append = append + '        </div>'
                append = append + '        <div class="form-group mb-4">'
                append = append + '            <label>Out Of Scope*</label>'
                append = append + '            <textarea class="form-control" style="resize: vertical;height: 150px;" row="20" name="textareaScopeUpdate" id="textareaScopeUpdate">'+ result.oos +'</textarea>'
                append = append + '        </div>'
                append = append + '    </div>'
                append = append + '</div>'
                append = append + '<div class="row">'
                append = append + ' <div class="col-md-12 col-xs-12">'
                append = append + ' <label>Config*</label>'                  
                    var i = 0, j = 0, z = 0, tempInc = 0, tempInc2 = 0, resultAlias = "", arrDetailItems = []
                    // var priceGrandTotalUpdate = 0
                    append = append + '<div class="table-responsive">'
                    $.each(result.detail_config, function(key, results){
                        i++
                        append = append + ' <table class="table" name="tableUpdateConfig" id="tableItemsUpdateConfig_'+ i +'">'
                        append = append + '    <thead>'
                        append = append + '        <tr>'
                        append = append + '            <th width=20%>'
                        append = append + '                Items'
                        append = append + '            </th>'
                        append = append + '            <th width=25%>'
                        append = append + '                Detail Items'
                        append = append + '            </th>'
                        append = append + '            <th width=5%>'
                        append = append + '                Qty'
                        append = append + '            </th>'
                        append = append + '            <th width=24%>'
                        append = append + '                Price'
                        append = append + '            </th>'
                        append = append + '            <th width=6%>'
                        append = append + '                Manpower'
                        append = append + '            </th>'
                        append = append + '            <th width=20%>'
                        append = append + '                Total'
                        append = append + '            </th>'
                        append = append + '            <td>'
                        append = append + '                <button class="btn btn-sm btn-linkedin" id="btnAddUpdateItemsDetail" onclick="updateItemsDetail('+ i +')" style="width: 35px;"><i class="icon-base bx bx-plus"></i></button>'
                        append = append + '            </td>'
                        append = append + '        </tr>'
                        append = append + '    </thead>'
                        append = append + '<tbody id="tbodyItems">'

                        Object.keys(results).forEach(function(keys) {
                            arrDetailItems.push(result.detail_config[key][keys])
                            var resultsDetail = results[keys];
                            j++
                            append = append + ' <tr>'
                            append = append + '     <td>'
                            append = append + '       <input type="" class="form-control" name="inputItemsUpdate" id="inputItemsUpdate" value="'+ key +'" placeholder="Ex: PM Maintenance" style="width:150px" data-attr="'+ i +'">'
                            append = append + '     </td>'
                            append = append + '     <td>'
                            append = append + '       <select type="" style="width:150px" class="select2 form-control detailItemsUpdate_'+ j +'" name="detailItemsUpdate">'
                            append = append + '             <option></option>'
                            append = append + '       </select>'
                            append = append + '     </td>'
                            append = append + '     <td>'
                            append = append + '         <input type="number" style="width:60px" class="form-control qtyItemsUpdate_'+ j +'" name="qtyItemsUpdate" id="qtyItemsUpdate" onkeyup="changeQtyItems(this)" value="'+ resultsDetail.qty +'">'
                            append = append + '     </td>'
                            append = append + '     <td>'
                            append = append + '         <input type="" class="form-control priceItemsUpdate_'+ j +'" name="priceItemsUpdate" id="priceItemsUpdate" disabled="" value="'+ formatter.format(resultsDetail.price) +'" style="width:150px">'
                            append = append + '     </td>'
                            append = append + '     <td>'
                            append = append + '         <input type="" style="width:60px;margin-left:10px" class="form-control manpowerItems_'+ j +'" name="manpowerItemsUpdate" id="manpowerItemsUpdate" onkeyup="changeManPower(this)" value="'+ resultsDetail.manpower +'">'
                            append = append + '     </td>'
                            append = append + '     <td>'
                            append = append + '         <input type="" class="form-control totalItems_'+ j +'" name="totalItems" id="totalItemsUpdate" data-value="'+ i +'" disabled value="'+ formatter.format(resultsDetail.total_nominal) +'" style="width:150px">'
                            append = append + '     </td>'
                            append = append + '     <td>'
                            append = append + '<button onclick="removeUpdateItemsDetail(this,'+ i +')" class="btn btn-sm text-bg-danger" style="width:35px"><i class="icon-base bx bx-trash-alt"></i></button>'
                            append = append + '     </td>'
                            append = append + ' </tr>'
                        })

                        append = append + '        </tbody>'
                        append = append + '        <tfoot>'
                        append = append + '          <tr>'
                        append = append + '           <td colspan="4"></td>'
                        append = append + '           <th>Total Cost</th>'
                        append = append + '           <td colspan=2><input type="text" class="form-control" name="inputGrandTotal" id="inputGrandTotal" disabled style="width:150px"></td>'
                        append = append + '          </tr>'
                        append = append + '        </tfoot>'
                        append = append + ' </table>'
                    })
                    append = append + '</div>'
                    
                    $.each(result.detail_config,function(key,results) {
                        $.ajax({
                            url:"{{url('/sbe/getDropdownDetailItem')}}",
                            type:"GET",
                            success:function(resultDetailItem){  
                                $.each(arrDetailItems,function(key,itemDetails) {
                                    z++
                                    
                                    $("#tableItemsUpdateConfig_"+i).each(function(item,data){
                                        $(".detailItemsUpdate_"+z).select2({
                                            placeholder:"Select Detail Items",
                                            data:resultDetailItem.data
                                        }).on('select2:select', function (e) {
                                        var data = e.params.data;
                                        
                                        $(this).closest("tr").find("td").eq(3).find("input").val(formatter.format(data.price))

                                        var priceTotal = 0
                                        var priceGrandTotal = 0
                                        priceTotal += parseInt(data.price)
                                        priceTotal *= $(this).closest("tr").find("td").eq(2).find("input").val() == '' ? 1 : parseInt($(this).closest("tr").find("td").eq(2).find("input").val())  
                                        priceTotal *= $(this).closest("tr").find("td").eq(4).find("input").val() == '' ? 1 : parseInt($(this).closest("tr").find("td").eq(4).find("input").val())

                                        $(this).closest("tr").find("td").eq(5).find("input").val(formatter.format(priceTotal))

                                        $(this).closest("table").find("tbody tr").each(function(item,result){
                                            $(result).find(".form-control").each(function(itemInput,resultItem){
                                                if(resultItem.name == "totalItems"){
                                                    priceGrandTotal += parseInt($(this).closest("tr").find("td").eq(5).find("input").val().replaceAll(".",""))
                                                }
                                            })
                                                $(this).closest("table").find("input[name='inputGrandTotal']").val(formatter.format(priceGrandTotal))
                                            })
                                                
                                        })

                                        $(".detailItemsUpdate_"+z).val(itemDetails.detail_item).trigger("change")
                                    })
                                })                                                          
                            }
                        })
                    })
                    // append = append + '                    <hr>'

                append = append + '  <div style="text-align:center" class="mt-4">'
                append = append + '     <button class="btn btn-sm text-bg-primary" id="updateItems" style="margin: 0 auto;" onclick="updateItems(0)"><i class="icon-base bx bx-plus"></i>&nbsp Add Items</button>'
                append = append + '  </div>'
                append = append + '    </div>'
                append = append + '</div>'
                    append = append + '     <div class="row" style="margin-top:20px">'
                    append = append + '         <div class="col-md-12 col-xs-12" style="text-align:right">'
                    append = append + '             <button class="btn btn-sm btn-danger" style="margin-right:10px" onclick="cancelConfig()">Cancel</button>'
                    append = append + '             <button class="btn btn-sm btn-warning" onclick="updateConfig('+ value +')">Update</button>'
                    append = append + '         </div>'
                    append = append + '     </div>'
                append = append + '      </div>'
                append = append + '</div>'
                
                $(".content").append(append)
                $("table[name='tableUpdateConfig']:last").find("tr:last").after("<tr><th colspan=5 style='text-align:right'>Grand Total Cost</th><td colspan=2><input class='form-control' style='text-align:right;width: 150px;' id='inputSumPriceGrandTotal' name='inputSumPriceGrandTotal' disabled/></td></tr>")

                $.each(result.detail_config, function(key, results){
                    tempInc++
                    ++tempInc2

                    var grandPriceTotalUpdatetempInc = 0

                    if ($("#tableItemsUpdateConfig_"+tempInc).find("tbody tr").length > 1) {
                        $("#tableItemsUpdateConfig_"+tempInc).find("tbody tr").each(function(item,result){
                            $(result).find("td").eq(6).html("<button onclick='removeUpdateItemsDetail(this,"+ tempInc +")' class='btn btn-sm text-bg-danger' style='width:35px'><i class='icon-base bx bx-trash-alt'></i></button>")
                        })
                    }
                    

                    $("#tableItemsUpdateConfig_"+tempInc).find("tbody tr").each(function(item,result){
                        $(result).find(".form-control").each(function(v,w){
                            if ($(w).attr("data-value") == tempInc){
                                if(w.name == "totalItems"){
                                    $("#tableItemsUpdateConfig_"+tempInc).find("input[name='inputGrandTotal']").val(formatter.format(grandPriceTotalUpdatetempInc += parseInt($(w).attr("data-value",$(w).attr("data-value")).val().replaceAll(".",""))))
                                    
                                }
                            }
                        })
                    })

                    $("#tableItemsUpdateConfig_"+tempInc2).find("tbody tr:not(:first-child)").each(function(item,result){
                        $(result).find(".form-control").each(function(v,w){
                            if(w.name == "inputItemsUpdate"){
                                $(w).attr('style', 'display: none !important');
                            }
                        })
                    })
                })

                
                // $('table[name="tableUpdateConfig"] tbody tr:not(:first-child)').each(function(item,result){
                //     $(this).find("td").eq(6).html("<button onclick='removeUpdateItemsDetail(this)' class='btn btn-sm text-bg-danger' style='width:35px'><i class='icon-base bx bx-trash-alt'></i></button>")
                // })

                if ($('table[name="tableUpdateConfig"]').length > 1) {
                    $("#updateItems").after("<button class='btn btn-sm text-bg-danger' id='removeItemsDetailforUpdate' onclick='removeItemsDetailforUpdate()' style='width:35px;margin-left:10px'><i class='icon-base bx bx-trash-alt'></i></button>")
                }

                var sumPriceGrandTotal = 0
                $("table[name='tableUpdateConfig']").find("input[name='inputGrandTotal']").each(function(index,item){
                    sumPriceGrandTotal += parseInt(item.value.replaceAll(".",""))
                })

                $("#inputSumPriceGrandTotal").val(formatter.format(sumPriceGrandTotal))
                              

            }
        })
    }

    //updateConfig function
    function updateItemsDetail(val){
        var cloneTr = $("#tableItemsUpdateConfig_"+val).find("tbody tr:first").clone()
        // cloneTr
        cloneTr.find("#qtyItemsUpdate").val('').end().find("#priceItemsUpdate").val('').end().find("#manpowerItemsUpdate").val('')
        cloneTr.find("#totalItemsUpdate").val('').end()
        cloneTr.find(":input[name='inputItemsUpdate']").attr('data-attr',val)
        cloneTr.find(":input[name='inputItemsUpdate']").attr('style', 'display: none !important');
        cloneTr.find("select[name='detailItemsUpdate']").addClass("detailItemsUpdate_"+val)
        cloneTr.find("td:last").html("<button onclick='removeUpdateItemsDetail(this,"+ val +")' class='btn btn-sm text-bg-danger' style='width:35px'><i class='icon-base bx bx-trash-alt'></i></button>")

        cloneTr.children("select")
            .select2("destroy")
            .end()

        $("#tableItemsUpdateConfig_"+val).append(cloneTr)
        getDropdownDetailItems(val,"Update",val)

        // if ($("#tableItemsUpdateConfig_"+val).find("tbody tr").length > 1) {
        //     $("#tableItemsUpdateConfig_"+val).find("tbody").find("tr:first").find("td:last").html("<button onclick='removeUpdateItemsDetail(this)' class='btn btn-sm text-bg-danger' style='width:35px'><i class='icon-base bx bx-trash-alt'></i></button>")
        // }
    }

    function removeUpdateItemsDetail(element,val){
        if ($("#tableItemsUpdateConfig_"+val).find('tbody').find('tr').length == 1) {
            var whichtr = $(element).closest('td').closest('tr').closest('tbody').closest('table')
        }else{
            var whichtr = element.closest("tr");
        }
        // var whichtr = val.closest("tr");
        var table   = element.closest("table").id

        var priceGrandTotal = 0, sumPriceGrandTotal = 0
        var latesItems = $("#"+table).find("tbody").find("tr:first").find("td:first").find(".form-control").val()

        $(element).closest("table").find("tbody tr:not(:eq("+$(element).closest('tr').index()+"))").each(function(item,result){
            $(result).find(".form-control").each(function(itemInput,resultItem){
                if(resultItem.name == "totalItems"){
                    priceGrandTotal += parseInt($(this).closest("tr").find("td").eq(5).find("input").val().replaceAll(".",""))
                } 
            })
        }) 

        $(element).closest("table").find("input[name='inputGrandTotal']").val(formatter.format(priceGrandTotal))
        whichtr.remove(); 
        $("#"+table).find("tbody").find("tr:first").find("td:first").find(".form-control").val(latesItems)

        if ($("#"+table).find("tbody tr").length == 1) {
            $("#"+table).find("tbody").find("tr:first").find("td:last").find(".text-bg-danger").attr('style', 'display: none !important');
        }

        $("#"+table).find("tbody").find("tr:first").find("td:first").find(".form-control").show()

        $("input[name='inputGrandTotal']").each(function(item,result){
            sumPriceGrandTotal += parseInt(result.value.replaceAll(".",""))
        })  

        $("input[name='inputSumPriceGrandTotal']").val(formatter.format(sumPriceGrandTotal))
    }

    function updateItems(val){
        // conMnSle.log(val)
        $("table[name='tableUpdateConfig']:last").find("tr:last").remove()
        var countable = $("table[name='tableUpdateConfig']").length + 1

        var append = ""
        append = append + '<div id="divTable">'
        append = append + '<table class="table" name="tableUpdateConfig" id="tableItemsUpdateConfig_'+ countable +'">'
        append = append + '<thead>'
        append = append + '   <tr>'
        append = append + '        <th>'
        append = append + '            '
        append = append + '        </th>'
        append = append + '        <th>'
        append = append + '            Detail Items'
        append = append + '        </th>'
        append = append + '        <th>'
        append = append + '            Qty'
        append = append + '        </th>'
        append = append + '        <th>'
        append = append + '            Price'
        append = append + '        </th>'
        append = append + '        <th>'
        append = append + '            Manpower'
        append = append + '        </th>'
        append = append + '        <th>'
        append = append + '            Total'
        append = append + '        </th>'
        append = append + '        <th>'
        append = append + '           <button class="btn btn-sm btn-linkedin" disabled="true" id="btnAddUpdateItemsDetail" onclick="updateItemsDetail('+ countable +')" style="width: 35px;"><i class="icon-base bx bx-plus"></i></button>'
        append = append + '        </th>'
        append = append + '  </tr>'
        append = append + '</thead>'
        append = append + '     <tbody>'
        append = append + '         <tr>'
        append = append + '             <td>'
        append = append + '                 <input type="" class="form-control" name="inputItemsUpdate" id="inputItemsUpdate" onkeyup="validateInput(this)" placeholder="Ex: PM Maintenance" style="width:150px" data-attr="'+ countable +'">'
        append = append + '             </td>'
        append = append + '             <td>'
        append = append + '                 <select type="" style="width:150px" class="select2 form-control detailItemsUpdate_'+ countable +'" name="detailItemsUpdate">'
        append = append + '                     <option></option>'
        append = append + '                 </select>'
        append = append + '             </td>'
        append = append + '             <td>'
        append = append + '                 <input type="number" style="width:60px" class="form-control" name="qtyItemsUpdate" id="qtyItemsUpdate" onkeyup="changeQtyItems(this)">'
        append = append + '             </td>'
        append = append + '             <td>'
        append = append + '                 <input type="" class="form-control" name="priceItemsUpdate" id="priceItemsUpdate" disabled="" style="width:150px">'
        append = append + '             </td>'
        append = append + '             <td>'
        append = append + '                 <input type="" style="width:60px;margin-left:10px" class="form-control" name="manpowerItemsUpdate" id="manpowerItemsUpdate" onkeyup="changeManPower(this)">'
        append = append + '             </td>'
        append = append + '             <td>'
        append = append + '                 <input type="" style="width:150px" class="form-control" name="totalItems" id="totalItemsUpdate" disabled>'
        append = append + '             </td>'
        append = append + '             <td>'
        append = append + '             <button class="btn btn-sm text-bg-danger" id="removeItemsDetailforUpdate" onclick="removeItemsDetailforUpdate()" style="width:35px"><i class="icon-base bx bx-trash-alt"></i></button>'
        append = append + '             </td>'
        append = append + '         </tr>'
        append = append + '     </tbody>'
        append = append + '     <tfoot>'
        append = append + '         <tr>'
        append = append + '             <td colspan="4"></td>'
        append = append + '             <th>Grand Total</th>'
        append = append + '             <td><input type="text" class="form-control" name="inputGrandTotal" disabled style="width:150px"></td>'
        append = append + '         </tr>'
        append = append + '     </tfoot>'
        append = append + '</table>'
        append = append + '</div>'

        if ($("table[name='tableUpdateConfig']:visible")) {
            $("table[name='tableUpdateConfig']:last").after(append)
        }else{
            $(".table-responsive").append(append)
        }
        // $("table[name='tableUpdateConfig']:last").after(append)
        getDropdownDetailItems(countable,"Update")


        $("#tableItemsUpdateConfig_"+countable).find("tr").eq(0).find("td").find("#updateItemsDetail").attr("onclick","updateItemsDetail("+ countable +")")

        // if (countable > 1) {
        //     if ($("#removeItemsDetailforUpdate").length < 1) {
        //         $("#updateItems").after("<button class='btn btn-sm text-bg-danger' id='removeItemsDetailforUpdate' onclick='removeItemsDetailforUpdate()' style='width:35px;margin-left:10px'><i class='icon-base bx bx-trash-alt'></i></button>")
        //     }
        // }

        $("table[name='tableUpdateConfig']:last").find("tr:last").after("<tr><th colspan=5 style='text-align:right'>Grand Total Cost</th><td colspan=2><input class='form-control' style='text-align:right;width: 150px;' id='inputSumPriceGrandTotal' name='inputSumPriceGrandTotal' disabled/></td></tr>")

        var sumPriceGrandTotal = 0
        $("table[name='tableUpdateConfig']").find("input[name='inputGrandTotal']").each(function(index,item){
            if (item.value != "") {
                sumPriceGrandTotal += parseInt(item.value.replaceAll(".",""))
            }
        })

        $("#inputSumPriceGrandTotal").val(formatter.format(sumPriceGrandTotal))

    }

    function removeItemsDetailforUpdate(){
        var whichtr = $("table[name='tableUpdateConfig']:last");
        whichtr.remove();

        var countable = $("table[name='tableUpdateConfig']").length

        if (countable == 1) {
            $("#removeItemsDetailforUpdate").remove()
        } 

         $("table[name='tableUpdateConfig']:last").find("tr:last").after("<tr><th colspan=5 style='text-align:right'>Grand Total Cost</th><td colspan=2><input class='form-control' style='text-align:right;width: 150px;' id='inputSumPriceGrandTotal' name='inputSumPriceGrandTotal' disabled/></td></tr>")

        var sumPriceGrandTotal = 0
        $("table[name='tableUpdateConfig']").find("input[name='inputGrandTotal']").each(function(index,item){
            if (item.value != "") {
                sumPriceGrandTotal += parseInt(item.value.replaceAll(".",""))
            }
        })

        $("#inputSumPriceGrandTotal").val(formatter.format(sumPriceGrandTotal))
    }

    //saveCOnfig
    function saveConfig(){
        var arrItemSO = [], arrItemImp = [], arrItemMnS = [], arrSelectConf = [], isCompleteFillSO = false, isCompleteFillImp = false, isCompleteFillMnS = false, arrCompleteFill = [], isReadyStore = false

        if ($("#inputLead").val() == "") {
            $("#inputLead").next().next().show()
            $("#inputLead").closest("div").addClass("needs-validation")
        }else if ($("#inputEstimatedRun").val() == "") {
            $("#inputEstimatedRun").next().show()
            $("#inputEstimatedRun").closest("div").addClass("needs-validation")
        }else if ($("#textareaLoc").val() == "") {
            $("#textareaLoc").next().show()
            $("#textareaLoc").closest("div").addClass("needs-validation")
        }else if ($(".cbConfig").is(":checked") == false) {
            $(".cbConfig").last().closest("div").next().show()
            $(".cbConfig").last().closest("div").closest(".form-group").addClass("needs-validation")
        }
        // else if ($("#textareaSOW").val() == "") {
        //     $("#textareaSOW").next().show()
        //     $("#textareaSOW").closest("div").addClass("needs-validation")
        // }else if ($("#textareaScope").val() == "") {
        //     $("#textareaScope").next().show()
        //     $("#textareaScope").closest("div").addClass("needs-validation")
        // }
        else{
            // var append = ""
            // append = append + ' <div class="alert alert-danger alert-dismissible" style="display:none!important">'
            // append = append + '      <h6><i class="icon-base bx bx-message-alt-error"></i> Alert!</h6>'
            // append = append + '      Please fill the empty row!'
            // append = append + ' </div>'
            var arrFalse = []
            $("table").each(function(items,results){
                if (results.id.split("_")[0] == "tableItemsSO") {
                    $("#"+results.id).find("tbody tr").each(function(itemTbody,resultTbodyTr){
                        var itemsSO = "", detailItemsSO = "", qtyItemsSO = "", manpowerSO = "", priceItemsSO=""
                        $(resultTbodyTr).each(function(itemInput,resultItemTd){
                            $(resultItemTd).find(".form-control").each(function(itemInput,resultItem){ 
                                if ($("#durationSO").val() != '') {
                                    if ($("#textareaSOWSo").val() == "") {
                                        $("#textareaSOWSo").next().show()
                                        $("#textareaSOWSo").closest("div").addClass("needs-validation")
                                    }else if ($("#textareaScopeSo").val() == "") {
                                        $("#textareaScopeSo").next().show()
                                        $("#textareaScopeSo").closest("div").addClass("needs-validation")
                                    }else{
                                        if(resultItem.id != "totalItems"){
                                            if ($(resultItem).val() == "") {
                                                isReadyStore = false
                                                isCompleteFillSO = false
                                                $("table[name='tableSO']:first").closest("div").prepend('<div class="alert alert-danger alert-dismissible"><h6><i class="icon-base bx bx-message-alt-error"></i> Alert!</h6>Please fill the empty row!</div>')
                                                $(".alert-danger:not(:first-child)").remove()
                                            }else{
                                                if (resultItem.name == 'InputItems') {
                                                    itemsSO = resultItem.value
                                                }

                                                if (resultItem.name == 'detailItemsSO') {
                                                    detailItemsSO = resultItem.value
                                                }

                                                if (resultItem.name == 'qtyItems') {
                                                    qtyItemsSO = resultItem.value
                                                }

                                                if (resultItem.name == 'priceItems') {
                                                    priceItemsSO = resultItem.value
                                                }

                                                if (resultItem.name == "manpowerItems") {
                                                    manpowerSO = resultItem.value
                                                }

                                                // arrCompleteFill.push("complete")
                                                isCompleteFillSO = true

                                            }
                                        }
                                    }
                                }else{
                                    $("#durationSO").next().show()
                                    $("#durationSO").closest("div").addClass("needs-validation")
                                }
                            })
                            
                        })

                        if ($("#durationSO").val() != "") {
                            arrItemSO.push({items:itemsSO,detailItems:detailItemsSO,qtyItems:qtyItemsSO,priceItems:priceItemsSO,manpower:manpowerSO})
                        }
                        
                        // readyToPost(arrItemSO)
                    })
                }

                if (results.id.split("_")[0] == "tableItemsImp") {
                    $("#"+results.id).find("tbody tr").each(function(itemTbody,resultTbodyTr){
                        
                        var itemsImp = "", detailItemsImp = "", qtyItemsImp = "", manpowerImp = "", priceItemsImp=""

                        $(resultTbodyTr).each(function(itemInput,resultItemTd){
                            $(resultItemTd).find(".form-control").each(function(itemInput,resultItem){ 
                                if ($("#durationImp").val() != '') {
                                    if ($("#textareaSOWImp").val() == "") {
                                        $("#textareaSOWImp").next().show()
                                        $("#textareaSOWImp").closest("div").addClass("needs-validation")
                                    }else if ($("#textareaScopeImp").val() == "") {
                                        $("#textareaScopeImp").next().show()
                                        $("#textareaScopeImp").closest("div").addClass("needs-validation")
                                    }else{
                                        if(resultItem.id != "totalItems"){
                                            if ($(resultItem).val() == "") {
                                                isReadyStore = false
                                                isCompleteFillImp = false

                                                arrFalse.push($(resultItem).val())

                                                $("table[name='tableImp']:first").closest("div").prepend('<div class="alert alert-danger alert-dismissible"><h6><i class="icon fa fa-ban"></i> Alert!</h6>Please fill the empty row!</div>')
                                                $(".alert-danger:not(:first-child)").remove()
                                            }else{
                                                if (resultItem.name == 'InputItemsImp') {
                                                    itemsImp = resultItem.value
                                                }

                                                if (resultItem.name == 'detailItemsImp') {
                                                    detailItemsImp = resultItem.value
                                                }

                                                if (resultItem.name == 'qtyItemsImp') {
                                                    qtyItemsImp = resultItem.value
                                                }

                                                if (resultItem.name == 'priceItemsImp') {
                                                    priceItemsImp = resultItem.value
                                                }

                                                if (resultItem.name == "manpowerItemsImp") {
                                                    manpowerImp = resultItem.value
                                                }

                                                // arrCompleteFill.push("complete")
                                                isCompleteFillImp = true

                                            }
                                        }
                                    }
                                    
                                }else{
                                    $("#durationImp").next().show()
                                    $("#durationImp").closest("div").addClass("needs-validation")
                                }
                            })
                        })

                        if ($("#durationImp").val() != '') {
                            arrItemImp.push({items:itemsImp,detailItems:detailItemsImp,qtyItems:qtyItemsImp,priceItems:priceItemsImp,manpower:manpowerImp})
                        }                        
                    })
                }

                if(results.id.split("_")[0] == "tableItemsMnS"){
                    $("#"+results.id).find("tbody tr").each(function(itemTbody,resultTbodyTr){
                        var itemsMnS = "", detailItemsMnS = "", qtyItemsMnS = "", manpowerMnS = "", priceItemsMnS=""

                        $(resultTbodyTr).each(function(itemInput,resultItemTd){
                            $(resultItemTd).find(".form-control").each(function(itemInput,resultItem){ 
                                if ($("#durationMnS").val() != '') {
                                    if ($("#textareaSOWMnS").val() == "") {
                                        $("#textareaSOWMnS").next().show()
                                        $("#textareaSOWMnS").closest("div").addClass("needs-validation")
                                    }else if ($("#textareaScopeMnS").val() == "") {
                                        $("#textareaScopeMnS").next().show()
                                        $("#textareaScopeMnS").closest("div").addClass("needs-validation")
                                    }else{
                                        if(resultItem.id != "totalItems"){
                                            
                                            if ($(resultItem).val() == "") {
                                                isReadyStore = false
                                                isCompleteFillMnS = false
                                                arrFalse.push($(resultItem).val())
                                                // 
                                                $("table[name='tableMnS']:first").closest("div").prepend('<div class="alert alert-danger alert-dismissible"><h6><i class="icon fa fa-ban"></i> Alert!</h6>Please fill the empty row!</div>')
                                                $(".alert-danger:not(:first-child)").remove()
                                                
                                            }else{
                                                if (resultItem.name == 'InputItemsMnS') {
                                                    itemsMnS = resultItem.value
                                                }

                                                if (resultItem.name == 'detailItemsMnS') {
                                                    detailItemsMnS = resultItem.value
                                                }

                                                if (resultItem.name == 'qtyItemsMnS') {
                                                    qtyItemsMnS = resultItem.value
                                                }

                                                if (resultItem.name == 'priceItemsMnS') {
                                                    priceItemsMnS = resultItem.value
                                                }

                                                if (resultItem.name == "manpowerItemsMnS") {
                                                    manpowerMnS = resultItem.value
                                                }

                                                // arrCompleteFill.push("complete")
                                                isCompleteFillMnS = true

                                            }
                                        }
                                    }
                                }else{
                                    $("#durationMnS").next().show()
                                    $("#durationMnS").closest("div").addClass("needs-validation")
                                }
                            })
                        })

                        if ($("#durationMnS").val() != '') {
                            arrItemMnS.push({items:itemsMnS,detailItems:detailItemsMnS,qtyItems:qtyItemsMnS,priceItems:priceItemsMnS,manpower:manpowerMnS})                        
                        }                        
                    })
                }
                
            })
            
            $(".cbConfig").each(function(item,value){
                if ($("#"+value.id).is(":checked") == true) {
                    arrSelectConf.push(value.id)

                    if (value.id == "cbSO") {
                        if (isCompleteFillSO == true) {
                            arrCompleteFill.push("completeSO")
                        }else{
                            arrCompleteFill = []
                        }
                    }

                    if (value.id == "cbImp") {
                        if (isCompleteFillImp == true) {
                            arrCompleteFill.push("completeImp")
                        
                        }else{
                            arrCompleteFill = []
                        }
                    }

                    if (value.id == "cbMnS") {
                        if (isCompleteFillMnS == true) {
                            arrCompleteFill.push("completeMnS")
                        }else{
                            arrCompleteFill = []
                        }
                    }
                }
            })

            arrSelectConf = $.unique(arrSelectConf)
            arrCompleteFill = $.unique(arrCompleteFill)

            if (arrSelectConf.length == arrCompleteFill.length) {
                isReadyStore = true
            }else{
                isReadyStore = false
            }
            // if(arrFalse.length == 0){
            //     isReadyStore = true
            // }else{
            //     arrItemSO = []
            //     arrItemImp = []
            //     arrItemMnS = []
            // }

            formData = new FormData
            formData.append("_token","{{ csrf_token() }}")      
            // formData.append("id_sbe",window.location.href.split("/")[6].split("?")[0])  
            formData.append("inputLead",$("#inputLead").val())
            formData.append("textareaLoc",$("#textareaLoc").val())     
            formData.append("inputDuration",$("#inputDuration").val())     
            formData.append("inputEstimatedRun",$("#inputEstimatedRun").val())     
            formData.append("textareaSOWSo",$("#textareaSOWSo").val())     
            formData.append("textareaScopeSo",$("#textareaScopeSo").val())  
            formData.append("textareaSOWImp",$("#textareaSOWImp").val())     
            formData.append("textareaScopeImp",$("#textareaScopeImp").val())  
            formData.append("textareaSOWMnS",$("#textareaSOWMnS").val())     
            formData.append("textareaScopeMnS",$("#textareaScopeMnS").val())  
            formData.append("durationSO",$("#durationSO").val())  
            formData.append("durationImp",$("#durationImp").val())  
            formData.append("durationMnS",$("#durationMnS").val())  
            formData.append("arrItemSO",JSON.stringify(arrItemSO)) 
            formData.append("arrItemImp",JSON.stringify(arrItemImp)) 
            formData.append("arrItemMnS",JSON.stringify(arrItemMnS))

            swalFireCustom = {
              title: 'Are you sure?',
              text: "Submit Config for Temporary SBE",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes',
              cancelButtonText: 'No',
            }

            swalSuccess = {
                icon: 'success',
                title: 'Config has been created!',
                text: 'Click Ok to reload page',
            }

            var url = "/sbe/createConfig"

            cekTableLength(arrTableSO,arrTableImp,arrTableMnS,isReadyStore,formData,swalFireCustom,swalSuccess,url)
        }
        
    }

    function cekTableLength(arrTableSO,arrTableImp,arrTableMnS,isReadyStore,formData,swalFireCustom,swalSuccess,url){
        if (isReadyStore == true) {
            createPost(swalFireCustom,formData,swalSuccess,url)
        }else{
            if ($(".nav-tabs-custom").find('.alert-danger').length == 0) {
                $(".nav-tabs-custom").prepend('<div class="alert alert-danger alert-dismissible"><h6><i class="icon fa fa-ban"></i> Alert!</h6>Please Add Config!</div>') 
            }
        }
    }

    var arrItems = []
    function updateConfig(id_config_sbe){            
        if ($("#textareaLocUpdate").val() == "") {
            $("#textareaLocUpdate").next().show()
            $("#textareaLocUpdate").closest("div").addClass("needs-validation")
        }else if ($("#inputDurationUpdate").val() == "") {
            $("#inputDurationUpdate").next().show()
            $("#inputDurationUpdate").closest("div").addClass("needs-validation")
        }else if ($("#inputEstimatedRunUpdate").val() == "") {
            $("#inputEstimatedRunUpdate").next().show()
            $("#inputEstimatedRunUpdate").closest("div").addClass("needs-validation")
        }else if ($("#textareaSOWUpdate").val() == "") {
            $("#textareaSOWUpdate").next().show()
            $("#textareaSOWUpdate").closest("div").addClass("needs-validation")
        }else if ($("#textareaScopeUpdate").val() == "") {
            $("#textareaScopeUpdate").next().show()
            $("#textareaScopeUpdate").closest("div").addClass("needs-validation")
        }else{
            var arrFalse = [], itemsUpdateConfig = "", detailItemsUpdateConfig = "", qtyItemsUpdateConfig = "", manpowerUpdateConfig = "", priceItemsUpdateConfig = ""
            $("table").each(function(items,results){
                if (results.id.split("_")[0] == "tableItemsUpdateConfig") {
                    $("#"+results.id).find("tbody tr").each(function(itemTbody,resultTbodyTr){
                        //
                        $(resultTbodyTr).each(function(itemInputTr,resultItemTd){
                            $(resultItemTd).find(".form-control").each(function(itemInputTd,resultItem){ 
                                console.log(itemInputTr)
                                if (resultItem.name != "totalItems") {
                                    if ($(resultItem).val() == "") {

                                        $("table[name='tableUpdateConfig']:first").closest("div").prepend('<div class="alert alert-danger alert-dismissible"><h6><i class="icon fa fa-ban"></i> Alert!</h6>Please fill the empty row!</div>')
                                        $(".alert-danger:not(:first-child)").remove()

                                        isReadyStore = false
                                        arrFalse.push($(resultItem).val())
                                    }else{
                                        if (resultItem.name == 'inputItemsUpdate') {
                                            var uniqAttrId = $(resultItem).attr("data-attr")
                                            console.log(uniqAttrId)
                                            itemsUpdateConfig = $("td").find(".form-control[name='inputItemsUpdate'][data-attr='"+ uniqAttrId +"']").first().val()
                                            // itemsUpdateConfig = resultItem.value
                                        }

                                        if (resultItem.name == 'detailItemsUpdate') {
                                            detailItemsUpdateConfig = resultItem.value
                                        }

                                        if (resultItem.name == 'qtyItemsUpdate') {
                                            qtyItemsUpdateConfig = resultItem.value
                                        }

                                        if (resultItem.name == "manpowerItemsUpdate") {
                                            manpowerUpdateConfig = resultItem.value
                                        }

                                        if (resultItem.name == 'priceItemsUpdate') {
                                            priceItemsUpdateConfig = resultItem.value
                                        }
                                    }
                                }
                            })
                        }) 
                        // if ($("table[name='tableUpdateConfig']").is(":visible") == true) {
                            
                        // }
                        arrItems.push({items:itemsUpdateConfig,detailItems:detailItemsUpdateConfig,qtyItems:qtyItemsUpdateConfig,priceItems:priceItemsUpdateConfig,manpower:manpowerUpdateConfig})  
                    })
                }                
            })
            
            
            if(arrFalse.length == 0){
                isReadyStore = true
                arrTableSO.push(['update'])
            }else{
                arrItems = []
            }

            
            cekTableLength(arrTableSO,arrTableImp,arrTableMnS,isReadyStore)
        }
    

        formData = new FormData
        formData.append("_token","{{ csrf_token() }}")      
        formData.append("id_sbe",window.location.href.split("/")[4].split("?")[0])
        formData.append("id_config_sbe",id_config_sbe)  
        // formData.append("inputLead",$("#inputLead").val())
        formData.append("textareaLocUpdate",$("#textareaLocUpdate").val())     
        formData.append("inputDurationUpdate",$("#inputDurationUpdate").val())     
        formData.append("inputEstimatedRunUpdate",$("#inputEstimatedRunUpdate").val())     
        formData.append("textareaSOWUpdate",$("#textareaSOWUpdate").val())     
        formData.append("textareaScopeUpdate",$("#textareaScopeUpdate").val())   
        formData.append("arrItemsUpdate",JSON.stringify(arrItems))
        
        swalFireCustom = {
          title: 'Are you sure?',
          text: "Update Config for Temporary SBE",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }

        swalSuccess = {
            icon: 'success',
            title: 'Config has been updated!',
            text: 'Click Ok to reload page',
        }           

        url="/sbe/updateConfig"

        cekTableLength(arrTableSO,arrTableImp,arrTableMnS,isReadyStore,formData,swalFireCustom,swalSuccess,url)
    }

    //postEvent
    function createPost(swalFireCustom,data,swalSuccess,url){
        Swal.fire(swalFireCustom).then((result) => {
          if (result.value) {
            $.ajax({
              type:"POST",
              url:"{{url('/')}}"+url,
              processData: false,
              contentType: false,
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
              success: function(result)
              {
                Swal.fire(swalSuccess).then((result) => {
                  if (result.value) {
                    if (url == "/sbe/createConfig") {
                        window.location.href = "{{url('/sbe_index')}}"
                    }else{
                        location.reload()
                    }
                  }
                })
              }
            })
          }else{
            if (url == "/sbe/resetVersion") {
                $(".content").empty("")
                showFunctionConfig()
            }
          }
      })
    }

    function addNotes(){
        $("#ModalNotes").modal("show")
    }

    function validateInput(val){
        if ($(val).is("select")) {
            if (val.value != "") {
                $("#"+val.id).next().next().attr('style', 'display: none !important');
                $("#"+val.id).closest("div").removeClass("needs-validation")
            }
        }else if(val.type == "checkbox"){
            $(val).last().closest("div").next().attr('style', 'display: none !important');
            $(val).last().closest("div").closest(".form-group").removeClass("needs-validation")

            if ($(".cbConfig:checked").length == 1) {
                if ($(".cbConfig:checked")[0].id == "cbSO") {
                    $('.nav-tabs li:nth-child(1)').find('button').addClass("active")
                    $('.tab-content div:nth-child(1)').addClass('fade show active')
                }else if ($(".cbConfig:checked")[0].id== "cbImp") {
                    $('.nav-tabs li:nth-child(2)').find('button').addClass("active")
                    $('.tab-content div:nth-child(2)').addClass('fade show active')
                }else{
                    $('.nav-tabs li:nth-child(3)').find('button').addClass("active")
                    $('.tab-content div:nth-child(3)').addClass('fade show active')
                }
            }

            if (val.id == "cbSO") {
                if ($("#"+val.id).is(":checked") == true) {
                    $('.nav-tabs li:nth-child(1)').show()
                    $('.nav-tabs li:nth-child(1)').prop('disabled', false).removeClass('disabled').find("a").attr("data-toggle","tab")
                }else{
                    $('.nav-tabs li:nth-child(1)').attr('style', 'display: none !important').prop('disabled', true).removeClass('active').addClass('disabled').find("a").removeAttr("data-toggle")
                    $('.tab-content div:nth-child(1)').removeClass('active')

                    if ($(".cbConfig:checked").length >= 1) {
                        if ($('.tab-content .tab-pane.active').attr("id") == "tab_1") {
                            if ($(".cbConfig:checked")[0].id == "cbSO") {
                                $('.nav-tabs li:nth-child(1)').find('button').addClass("active")
                                $('.tab-content div:nth-child(1)').addClass('fade show active')
                            }else if ($(".cbConfig:checked")[0].id== "cbImp") {
                                $('.nav-tabs li:nth-child(2)').find('button').addClass("active")
                                $('.tab-content div:nth-child(2)').addClass('fade show active')
                            }else{
                                $('.nav-tabs li:nth-child(3)').find('button').addClass("active")
                                $('.tab-content div:nth-child(3)').addClass('fade show active')
                            }
                        }else if ($('.tab-content .tab-pane.active').attr("id") == "tab_2") {
                            $('.nav-tabs li:nth-child(2)').find('button').addClass("active")
                            $('.tab-content div:nth-child(2)').addClass('fade show active')
                        }else {
                            $('.nav-tabs li:nth-child(3)').find('button').addClass("active")
                            $('.tab-content div:nth-child(3)').addClass('fade show active')
                        }
                    }

                }
            }else if (val.id == "cbImp") {
                if ($("#"+val.id).is(":checked") == true) {
                    $('.nav-tabs li:nth-child(2)').show()
                    $('.nav-tabs li:nth-child(2)').prop('disabled', false).removeClass('disabled').find("a").attr("data-toggle","tab");

                }else{
                    $('.nav-tabs li:nth-child(2)').attr('style', 'display: none !important').prop('disabled', true).removeClass('active').addClass('disabled').find("a").removeAttr("data-toggle")
                    $('.tab-content div:nth-child(2)').removeClass('active')

                    if ($(".cbConfig:checked").length >= 1) {
                        if ($('.tab-content .tab-pane.active').attr("id") == "tab_1") {
                            $('.nav-tabs li:nth-child(1)').find('button').addClass("active")
                            $('.tab-content div:nth-child(1)').addClass('fade show active')
                        }else if ($('.tab-content .tab-pane.active').attr("id") == "tab_2") {
                            if ($(".cbConfig:checked")[0].id == "cbSO") {
                                $('.nav-tabs li:nth-child(1)').find('button').addClass("active")
                                $('.tab-content div:nth-child(1)').addClass('fade show active')
                            }else if ($(".cbConfig:checked")[0].id== "cbImp") {
                                $('.nav-tabs li:nth-child(2)').find('button').addClass("active")
                                $('.tab-content div:nth-child(2)').addClass('fade show active')
                            }else{
                                $('.nav-tabs li:nth-child(3)').find('button').addClass("active")
                                $('.tab-content div:nth-child(3)').addClass('fade show active')
                            }
                        }else{
                            $('.nav-tabs li:nth-child(3)').find('button').addClass("active")
                            $('.tab-content div:nth-child(3)').addClass('fade show active')
                        }
                    }
                }
            }else{
               if ($("#"+val.id).is(":checked") == true) {
                    $('.nav-tabs li:nth-child(3)').show()
                    $('.nav-tabs li:nth-child(3)').prop('disabled', false).removeClass('disabled').find("a").attr("data-toggle","tab");

                }else{
                    $('.nav-tabs li:nth-child(3)').attr('style', 'display: none !important').prop('disabled', true).removeClass('active').addClass('disabled').find("a").removeAttr("data-toggle")
                    $('.tab-content div:nth-child(3)').removeClass('active');

                   
                    if ($(".cbConfig:checked").length >= 1) {
                        if ($('.tab-content .tab-pane.active').attr("id") == "tab_1") {
                            $('.nav-tabs li:nth-child(1)').find('button').addClass("active")
                            $('.tab-content div:nth-child(1)').addClass('fade show active')
                        }else if ($('.tab-content .tab-pane.active').attr("id") == "tab_2") {
                            $('.nav-tabs li:nth-child(2)').find('button').addClass("active")
                            $('.tab-content div:nth-child(2)').addClass('fade show active')
                        }else{
                            if ($(".cbConfig:checked")[0].id == "cbSO") {
                                $('.nav-tabs li:nth-child(1)').find('button').addClass("active")
                                $('.tab-content div:nth-child(1)').addClass('fade show active')
                            }else if ($(".cbConfig:checked")[0].id== "cbImp") {
                                $('.nav-tabs li:nth-child(2)').find('button').addClass("active")
                                $('.tab-content div:nth-child(2)').addClass('fade show active')
                            }else{
                                $('.nav-tabs li:nth-child(3)').find('button').addClass("active")
                                $('.tab-content div:nth-child(3)').addClass('fade show active')
                            }
                            
                        }
                    }
                }
            }
        }else{
            if (val.value != "") {
                $("#"+val.id).next().attr('style', 'display: none !important');
                $("#"+val.id).closest("div").removeClass("needs-validation")

                if (val.name == "inputDuration") {
                    if (val.value.length == 1) {
                        $('ul li.active').find("input").val("")  

                        document.body.onkeyup = function(e){
                          if(e.keyCode == 32){
                            console.log(true)
                          }
                        }
                    }else{
                        $('ul li.active').find("input").val(val.value)  
                    }
                    // $('ul li.active').find("input").val(val.value)  
                    $(val).css("border-color","#d2d6de")                  
                }

                if (val.name == "InputItems" || val.name == "InputItemsImp" || val.name == "InputItemsMnS" || val.name == "inputItemsUpdate") {
                    // $("#btnAddConfigSO").prop("disabled",false)
                    // 
                    if (val.value.length > 1) {
                        $(val).closest("table").find("tr")[0].cells[6].children[0].disabled = false
                        // $("#btnAddConfigSO").prop("disabled",false)
                    }else{
                        $(val).closest("table").find("tr")[0].cells[6].children[0].disabled = true
                        // $("#btnAddConfigSO").prop("disabled",true)
                    }
                }
            }
        }
    }

    function btnSendNotes(){
        if ($("#textareaNotes").val() == "") {
            $("#textareaNotes").closest("div").find("span").show()
            $("#textareaNotes").closest("div").addClass("needs-validation")
        }else{
            formData = new FormData
            formData.append("_token","{{ csrf_token() }}")  
            formData.append("inputNotes",$("#textareaNotes").val())
            formData.append("id_sbe",window.location.href.split("/")[4].split("?")[0]) 

            swalFireCustom = {
              title: 'Are you sure?',
              text: "Send Notes",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes',
              cancelButtonText: 'No',
            }

            swalSuccess = {
                icon: 'success',
                title: 'Notes has been send!',
                text: 'Click Ok to reload page',
            }           

            createPost(swalFireCustom,formData,swalSuccess,url="/sbe/storeNotes")
        } 
    }

    function resetConfig(){
        $("input[type='radio']:checked").each(function(index,items){
            $(items).prop("checked",false)
        })

        $("#boxConfigTemp").empty("")
        showEmptyConfig()       

        formData = new FormData
        formData.append("_token","{{ csrf_token() }}")
        formData.append("id_sbe",window.location.href.split("/")[4].split("?")[0]) 

        swalFireCustom = {
          title: 'Are you sure?',
          text: "Reset Config function, send to Sol Manager!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }

        swalSuccess = {
            icon: 'success',
            title: 'Reset Config has been successfully!',
            text: 'Click Ok to reload page',
        }          

        createPost(swalFireCustom,formData,swalSuccess,url="/sbe/resetVersion")
    }

    function showEmptyConfig(){
        var appendTemporary = ""

        appendTemporary = appendTemporary + '<div class="row">'
        appendTemporary = appendTemporary + '            <div class="col-md-3 col-xs-12" style="text-align:-webkit-center">'
        appendTemporary = appendTemporary + '              <a>'
        appendTemporary = appendTemporary + '                <div style="width: 100px;height: 100px;background-color: blue;color: white;text-align: center;vertical-align: middle;display: flex;">'
        appendTemporary = appendTemporary + '                    <span style="'
        appendTemporary = appendTemporary + '                        margin: auto;'
        appendTemporary = appendTemporary + '                        display: flex;'
        appendTemporary = appendTemporary + '                        text-align: center;'
        appendTemporary = appendTemporary + '                        align-items: center;cursor:pointer">X</span>'
        appendTemporary = appendTemporary + '                </div>'
        appendTemporary = appendTemporary + '              </a>'
        appendTemporary = appendTemporary + '            </div>'
        appendTemporary = appendTemporary + '            <div class="col-md-9 col-xs-12">'
        appendTemporary = appendTemporary + '                <div class="table-responsive">'
        appendTemporary = appendTemporary + '                    <table class="table table-bordered" width="100%">'
        appendTemporary = appendTemporary + '                        <thead>'
        appendTemporary = appendTemporary + '                            <tr>'
        appendTemporary = appendTemporary + '                                <th>No</th>'
        appendTemporary = appendTemporary + '                                <th>Function</th>'
        appendTemporary = appendTemporary + '                                <th>Total</th>'
        appendTemporary = appendTemporary + '                            </tr>'
        appendTemporary = appendTemporary + '                        </thead>'
        appendTemporary = appendTemporary + '                        <tbody>'
        appendTemporary = appendTemporary + '          <tr>'
        appendTemporary = appendTemporary + '              <td>-</td>'
        appendTemporary = appendTemporary + '              <td>-</td>'
        appendTemporary = appendTemporary + '              <td>-</td>'
        appendTemporary = appendTemporary + '          </tr>'
        appendTemporary = appendTemporary + '      </tbody>'
        appendTemporary = appendTemporary + '      <tfoot>'
        appendTemporary = appendTemporary + '          <tr>'
        appendTemporary = appendTemporary + '              <th colspan="2" style="text-align:right">Grand Total</th>'
        appendTemporary = appendTemporary + '              <th>-</th>'
        appendTemporary = appendTemporary + '          </tr>'
        appendTemporary = appendTemporary + '                        </tfoot>'
        appendTemporary = appendTemporary + '                    </table>'
        appendTemporary = appendTemporary + '                </div>'
        appendTemporary = appendTemporary + '            </div>'
        appendTemporary = appendTemporary + '        </div>'

        $("#boxConfigTemp").append(appendTemporary)
        // checkInnerHeight()
    }

    function saveFuncConf(){
        var arrVersion = []

        $("input[type='radio']:checked").each(function(index,items){
            arrVersion.push(items.value)
        })

        if (arrVersion.length < 1) {
            Swal.fire(
              'Warning!',
              'Please select minimal 1 config!',
              'warning'
            )
        }else{
            formData = new FormData
            formData.append("_token","{{ csrf_token() }}")
            formData.append("arrVersion",JSON.stringify(arrVersion))    

            swalFireCustom = {
              title: 'Are you sure?',
              text: "Save this config function, send to Sol Manager!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes',
              cancelButtonText: 'No',
            }

            swalSuccess = {
                icon: 'success',
                title: 'Config function has been saved!',
                text: 'Click Ok to reload page',
            }           

            createPost(swalFireCustom,formData,swalSuccess,url="/sbe/updateVersion")
        }

        
    }

    function generatePDF(){
        formData = new FormData
        formData.append("_token","{{ csrf_token() }}")
        formData.append("id_sbe",window.location.href.split("/")[4].split("?")[0]) 

        swalFireCustom = {
          title: 'Are you sure?',
          text: "Generate SBE!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }

        swalSuccess = {
            icon: 'success',
            title: 'SBE has been generated!',
            text: 'Click Ok to reload page',
        }           

        createPost(swalFireCustom,formData,swalSuccess,url="/sbe/uploadPdfConfig")
    }

    function wavyText(text){
    let delay = 200;

        let h1 = document.getElementById("status_unsaved");

        h1.innerHTML = text
            .split("")
            .map(letter => {
              
              return `<span>` + letter + `</span>`;
            })
            .join("");

          Array.from(h1.children).forEach((span, index) => {
            setTimeout(() => {
              span.classList.add("wavy");
            }, index * 10 + delay);
          });

    }
</script>
@endsection