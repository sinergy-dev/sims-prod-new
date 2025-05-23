@extends('template.main')
@section('head_css')
<!-- Select2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.css">
<!-- bootstrap datepicker -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet"/>
<!--datepicker-->
<link rel="stylesheet" type="text/css" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

<style type="text/css">
  .select2-selection__choice {
    color: white;
  }

  td.highlight {
    background-color: whitesmoke !important;
  }

  .transparant{
    background-color: Transparent;
    background-repeat:no-repeat;
    border: none;
    cursor:pointer;
    overflow: hidden;
    outline:none;
    width: 25px;
  }
  .alert-box {
      color:#555;
      border-radius:10px;
      font-family:Tahoma,Geneva,Arial,sans-serif;font-size:14px;
      padding:10px 36px;
      margin:10px;
  }
  .alert-box span {
      font-weight:bold;
      text-transform:uppercase;
  }
  .error {
      background:#ffecec;
      border:1px solid #f5aca6;
  }
  .success {
      background:#e9ffd9 ;
      border:1px solid #a6ca8a;
  }
  .warning {
      background:#fff8c4 ;
      border:1px solid #f2c779;
  }
  .notice {
      background:#e3f7fc;
      border:1px solid #8ed9f6;
  }

  .row:before, .row:after{
    display: inline-block; !important;
  }

  .dropbtn {
    background-color: #4CAF50;
    color: white;
    font-size: 12px;
    border: none;
    width: 140px;
    height: 30px;
    border-radius: 5px;
  }

  .dropbtn-date {
    background-color: #4CAF50;
    color: white;
    font-size: 12px;
    border: none;
    width: 150px;
    height: 35px;
    border-radius: 5px;
  }

  .dropbtn-add {
    background-color: #2fa8d8;
    color: white;
    font-size: 12px;
    border: none;
    width: 140px;
    height: 30px;
    border-radius: 5px;
  }
  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 140px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
  }
  .dropdown-content .year:hover {background-color: #ddd;}
  .dropdown:hover .dropdown-content {display: block;}
  .dropdown:hover .dropbtn {background-color: #3e8e41;}
  .transparant-filter{
    background-color: Transparent;
    background-repeat:no-repeat;
    border: none;
    cursor:pointer;
    overflow: hidden;
    outline:none;
  }
  div div ol li a{font-size: 14px;}
  div div i{font-size: 14px;}
  background-color:dodgerBlue;}
  .inputWithIconn.inputIconBg i{
    background-color:#aaa;
    color:#fff;
    padding:7px 4px;
    border-radius:4px 0 0 4px;
  }
  .inputWithIconn{
    position:relative;
  }
  .inputWithIconn i{
    position:absolute;
    left:0;
    top:28px;
    padding:9px 8px;
    color:#aaa;
    transition:.3s;
  }

  .modalIcon i{
    top:25px;
  }

  .inputWithIconn input[type=text]{
    padding-left:40px;
  }

  .stats_item_number {
    white-space: nowrap;
    font-size: 2.25rem;
    line-height: 2.5rem;

  }

  .txt_success {
    color: #2EAB6F;
  }

  .txt_warn {
    color: #f2562b;
  }

  .txt_sd {
    color: #04dda3;
  }

  .txt_tp{
    color: #f7e127;
  }

  .txt_win{
    color: #246d18;
  }

  .txt_lose{
    color: #e5140d;
  }

  .txt_smaller {
    font-size: .75em;
  }

  .flipY {
    transform: scaleY(-1);
    border-bottom-color: #fff;
  }

  .txt_faded {
    opacity: .65;
  }

  .txt_primary{
    color: #007bff;
  }

  .select2{
      width: 100%!important;
  }
   .margin-left-right{
  margin-left: 10px;
  margin-right: 10px;
 }

 .pading-left-right{
  padding-left: 10px;
  padding-right: 10px;
 }

 .margin-bottom{
  margin-bottom: 15px;
 }

 .margin-top{
  margin-top: 10px;
 }

 .margin-right-80{
   margin-right: -60px;
 }
 .margin-left{
  margin-left:10px;
 }

 .margin-left-sales{
  margin-left: -45px;
 }

.margin-right-sales{
  margin-right: -25px;
 }
.margin-top-form{
  margin-top: 15px;
 }

 .float-left{
  float: left;
 }

 .float-right{
  float: right;
 }

 .center{
  padding-left: 145px;
 }

.circle-container .dot
{
  height: 25px;
  width: 25px;
  background-color: #939a9b;
  border-radius: 50%;
  display: inline-block;
}

.circle-container .dot1
{
  height: 25px;
  width: 25px;
  background-color:#f2562b;
  border-radius: 50%;
  display: inline-block;
}

.circle-container .dot2
{
  height: 25px;
  width: 25px;

  background-color:#e0b416;
  border-radius: 50%;
  display: inline-block;
}

.circle-container .dot3
{
  height: 25px;
  width: 25px;
  background-color: #f7e127;
  border-radius: 50%;
  display: inline-block;
}

.circle-container .dot4
{
  height: 25px;
  width: 25px;
  background-color: #246d18;
  border-radius: 50%;
  display: inline-block;
}

.circle-container {
    position: relative;
    width: 17em;
    height: 17em;
    padding: 2.8em;
    border: solid 3px;
    border-radius: 50%;
    margin: 0.90em auto 0;
    border-color:#6dcae8;
}
.circle-container a {
    display: block;
    position: absolute;
    top: 50%; left: 50%;
    width: 4em; height: 4em;
    margin: -2em;
}

.inputWithIcon input[type=text]{
    padding-left:40px;
}

input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(3); /* IE */
  -moz-transform: scale(3); /* FF */
  -webkit-transform: scale(3); /* Safari and Chrome */
  -o-transform: scale(3); /* Opera */
      margin-top: 13px;
    margin-right: 8px;
  
}
input[type=text]:focus{
    border-color:dodgerBlue;
    box-shadow:0 0 8px 0 dodgerBlue;
  }

 .inputWithIcon.inputIconBg input[type=text]:focus + i{
    color:#fff;
    background-color:dodgerBlue;
  }

 .inputWithIcon.inputIconBg i{
    background-color:#aaa;
    color:#fff;
    padding:7px 4px;
    /*border-radius:4px 0 0 4px;*/
  }

 .inputWithIcon{
    position:relative;
  }

 .inputWithIcon i{
    position:absolute;
    left:0;
    top:47px;
    padding:9px 8px;
    color:#aaa;
    transition:.3s;
  }

  .profileInput input[type=number]{
    padding-left:40px;
  }

  input[type=number]:focus{
    border-color:dodgerBlue;
    box-shadow:0 0 8px 0 dodgerBlue;
  }

 .profileInput.inputIconBg input[type=number]:focus + i{
    color:#fff;
    background-color:dodgerBlue;
  }

 .profileInput.inputIconBg i{
    background-color:#aaa;
    color:#fff;
    padding:10px 7px;
    border-radius:4px 0 0 4px;
  }

 .profileInput{
    position:relative;
  }

 .profileInput i{
    position:absolute;
    left:0;
    top:52px;
    padding:9px 8px;
    color:#aaa;
    transition:.3s;
  }


 .inputsp.inputIconBg input[type=text]:focus + i{
    color:#fff;
    background-color:dodgerBlue;
  }



 .inputsp.inputIconBg input[type=text]:focus + i{
    color:#fff;
    background-color:dodgerBlue;
  }

 .inputsp.inputIconBg i{
    background-color:#aaa;
    color:#fff;
    padding:7px 4px;
    border-radius:4px 0 0 4px;
  }

 .inputsp{
    position:relative;
  }

 .inputsp i{
    position:absolute;
    left:0;
    top:65px;
    padding:9px 8px;
    color:#aaa;
    transition:.3s;
  }

  .inputsp input[type=text]{
    padding-left:40px;
  }


  .inputWithIconn.inputIconBg input[type=text]:focus + i{
    color:#fff;
    background-color:dodgerBlue;
  }

 .inputWithIconn.inputIconBg i{
    background-color:#aaa;
    color:#fff;
    padding:7px 4px;
    border-radius:4px 0 0 4px;
  }

 .inputWithIconn{
    position:relative;
  }

  .inputWithIconn i{
    position:absolute;
    left:0;
    top:28px;
    padding:9px 8px;
    color:#aaa;
    transition:.3s;
  }

  .inputWithIconn input[type=text]{
    padding-left:40px;
  }

  /*for percentage*/
   .percentageIcon.inputIconBg input[type=text]:focus + i{
    color:#fff;
    background-color:dodgerBlue;
  }

 .percentageIcon.inputIconBg i{
    background-color:#aaa;
    color:#fff;
    padding:7px 4px;
    border-radius:0 4px 4px 0;
  }

.percentageIcon{
    position:relative;
  }

 .percentageIcon i{
    position:absolute;
    right:0;
    top:47px;
    padding:9px 8px;
    color:#aaa;
    transition:.3s;
  }

/*for modal*/
  input[type=text]:focus{
    border-color:dodgerBlue;
    box-shadow:0 0 8px 0 dodgerBlue;
  }

  .modalIcon input[type=text]{
    padding-left:40px;
  }


  .modalIcon.inputIconBg input[type=text]:focus + i{
    color:#fff;
    background-color:dodgerBlue;
  }

 .modalIcon.inputIconBg i{
    background-color:#aaa;
    color:#fff;
    padding:7px 4px;
    border-radius:4px 0 0 4px;
  }

.modalIcon{
    position:relative;
  }

 .modalIcon i{
    position:absolute;
    left:0;
    top:24px;
    padding:9px 8px;
    color:#aaa;
    transition:.3s;
  }

  /*for slider*/
  input[type=text]:focus{
    border-color:dodgerBlue;
    box-shadow:0 0 8px 0 dodgerBlue;
  }

  .input63 input[type=text]{
    padding-left:40px;
  }


  .input63.inputIconBg input[type=text]:focus + i{
    color:#fff;
    background-color:dodgerBlue;
  }

 .input63.inputIconBg i{
    background-color:#aaa;
    color:#fff;
    padding:7px 4px;
    border-radius:4px 0 0 4px;
  }

.input63{
    position:relative;
  }

 .input63 i{
    position:absolute;
    left:0;
    top:68px;
    padding:9px 8px;
    color:#aaa;
    transition:.3s;
  }


.form-control-medium{
    display: block;
    width: 90%;
    padding: .375rem .75rem;
    padding-top: 0.375rem;
    padding-right: 0.75rem;
    padding-bottom: 0.375rem;
    padding-left: 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .40rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

td .form-control-small{
    display: block;
    width: 200%;
    padding: .375rem .75rem;
    padding-top: 0.375rem;
    padding-right: 0.75rem;
    padding-bottom: 0.375rem;
    padding-left: 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .40rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

.form-control-hr{
    display: block;
    width: 85%;
    padding: .375rem .75rem;
    padding-top: 0.375rem;
    padding-right: 0.75rem;
    padding-bottom: 0.375rem;
    padding-left: 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .40rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

.form-control-report{
    display: block;
    width: 15%;
    padding: .375rem .75rem;
    padding-top: 0.375rem;
    padding-right: 0.75rem;
    padding-bottom: 0.375rem;
    padding-left: 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .40rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

.form-control-date{
    display: block;
    width: 15%;
    padding: .375rem .75rem;
    padding-top: 0.370rem;
    padding-right: 0.75rem;
    padding-bottom: 0.375rem;
    padding-left: 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .40rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

.slider-control{
    display: block;
    width: 90%;
    padding: .375rem .75rem;
    padding-top: 0.375rem;
    padding-right: 0.75rem;
    padding-bottom: 0.375rem;
    padding-left: 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: none;
    border-radius: .40rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

.row{
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap:wrap;
  flex-wrap: wrap; 
}

.margin-left-custom{
  margin-left: 20px;
}

.margin-left-custom2{
  margin-left: 28px;
}


.form-control-small{
    display: block;
    width: 50%;
    padding: .375rem .75rem;
    padding-top: 0.375rem;
    padding-right: 0.75rem;
    padding-bottom: 0.375rem;
    padding-left: 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .40rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.circle-container span { display: block; width: 100%; }
.deg45 { transform: rotate(-21deg) translate(9.9em) rotate(-60deg); }
.deg135 { transform: rotate(185deg) translate(8.1em) rotate(-135deg); }
.deg180 { transform: rotate(399deg) translate(7.1em) rotate(-185deg);; }
.deg225 { transform: rotate(126deg) translate(7.0em) rotate(-185deg); }
.deg315 { transform: rotate(280deg) translate(7.3em) rotate(-185deg); }

 .deginitial
 {
  transform: translate(0.5em, -7.3em );
  color: #1b3868;
 }

 .circle-container .dot:after{
  transform: translate(8.1em, -2em );
  color: #1b3868; 
 }

 .degopen
 {
  transform: translate(9.8em, 2.8em);
  color: #1b3868; 
 }
 .degTP
 {
  transform:  translate(-4em, 6.4em);
  color:  #1b3868;  
 }
 .degSD
 {
  transform: translate(8.1em,8.0em);
  color:  #1b3868;  
 }
 .degwin
 {
  transform: translate(-2.5em,-0.5em);
  color:  #1b3868; 
 }

/*.tooltip {
    background-color:#000;
    border:1px solid #fff;
    padding:10px 15px;
    width:200px;
    display:none;
    color:#fff;
    text-align:left;
    font-size:12px;

    -moz-box-shadow:0 0 10px #000;
    -webkit-box-shadow:0 0 10px #000;
}
*/
button{
  width: 90px;
}

.btn-warning{
  color: white;
}

.btn-warning:hover{
  color: white;
}

.text-initial{
  color: #7735a3;
}

.text-open{
  color: #f2562b;
}

.text-sd{
  color: #04dda3;
}

.text-tp{
  color: #f7e127;
}

.text-win{
  color: #246d18;
}

.text-lose{
  color: #e5140d;
}

.status-sho{
    border-radius: 10%;
    background-color: #a03939;
    text-align: center;
    width: 150px;
    height: 25px;
    color: white;
    padding-top: 3px;
}


.status-initial{
    border-radius: 10%;
    background-color: #7735a3;
    text-align: center;
    width: 75px;
    height: 25px;
    color: white;
    padding-top: 3px;
}

.status-open{
    border-radius: 10%;
    background-color: #f2562b;
    text-align: center;
    width: 75px;
    height: 25px;
    color: white;
    padding-top: 3px;
}
.status-pending{
    border-radius: 10%;
    background-color: #e5ce22;
    text-align: center;
    width: 75px;
    height: 25px;
    color: white;
    padding-top: 3px;
}
.status-sd{
    border-radius: 10%;
    background-color: #04dda3;
    text-align: center;
    width: 75px;
    height: 25px;
    color: white;
    padding-top: 3px;
}
.status-tp{
    border-radius: 10%;
    background-color: #f7e127;
    text-align: center;
    width: 75px;
    height: 25px;
    color: white;
    padding-top: 3px;
}
.status-win{
    border-radius: 10%;
    background-color: #246d18;
    text-align: center;
    width: 75px;
    height: 25px;
    color: white;
    padding-top: 3px;
}
.status-lose{
    border-radius: 10%;
    background-color: #e5140d;
    text-align: center;
    width: 75px;
    height: 25px;
    color: white;
    padding-top: 3px;
}

.status-pending-claim{
      border-radius: 6%;
      background-color: #e5140d;
      text-align: center;
      width: 75px;
      height: 25px;
      color: white;
      font-size: 11px
      padding-top: 3px;
  }
.sho{
    background-color: black;
    color: white;
}

.sho:hover{
    color: #dee3e5;
}

.fa-search-plus{
  color: white;
}

button:hover.disabled {
  opacity: 0.65; 
  cursor: not-allowed;
}

.btn-win{
  width: 110px;
  height: 60px;
  padding-top: 5px;
  font-size: 30px;
}

.btn-lose{
  width: 110px;
  height: 60px;
  padding-top: 5px;
  font-size: 30px;
}

button.btn-sd{
  width: 150px;
}

.input-style{
  background-color: transparent;
  border: none;
  border-bottom: 1px solid #9e9e9e;
  border-radius: 0;
  outline: none;
  height: 2rem;
  width: 100%;
  font-size: 16px;
  margin: 0 0 8px 0;
  padding: 0;
  -webkit-box-shadow: none;
          box-shadow: none;
  -webkit-box-sizing: content-box;
          box-sizing: content-box;
  -webkit-transition: border .3s, -webkit-box-shadow .3s;
  transition: border .3s, -webkit-box-shadow .3s;
  transition: box-shadow .3s, border .3s;
  transition: box-shadow .3s, border .3s, -webkit-box-shadow .3s;
}

img{
  border-radius: 5%;
}

#ex6Slider .slider-selection {
  background: #BABABA;
}

#ex7Slider .slider-selection {
  background: #BABABA;
}

.btn-primary-custom {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    height: 35px;
    width: 100px;
    padding-top: 2px;
    font-size: 12px;
}

.btn-primary-pr_asset {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    height: 35px;
    width: 150px;
    padding-top: 2px;
    font-size: 12px;
}

.btn-primary-back{
    color: #fff;
    background-color: #e04141;
    border-color: #e04141;
    height: 36px;
    width: 195px;
    padding-top: 2px;
}

.btn-primary-back-en{
    color: #fff;
    background-color: #e04141;
    border-color: #e04141;
    height: 36px;
    width: 210px;
    padding-top: 2px;
    font-size: 12px;
}

.btn-success-absen {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;
    height: 35px;
    width: 100px;
    padding-top: 2px;
    margin-right: -16px;
}

.btn-success-raise {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;
    height: 37px;
    width: 98px;
    padding-top: 2px;
    margin-right: -16px;
    font-size: 12px;
}

.btn-success-engineer {
    color: #fff;
    background-color: #4caf50;
    border-color: #4caf50;
    height: 38px;
    width: 100px;
}

.btn-warning-eksport {
    color: #fff;
    background-color: #ffb523;
    border-color: #ffb523;
    height: 38px;
    width: 110px;
    font-size: 12px;
}

.btn-primary-lead {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    width: 140px;
    padding-left: 10px;
    padding-top: 4px;
    font-size: 12px;
}

.btn-primary-pr {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    width: 170px;
    padding-left: 10px;
    padding-top: 4px;
    font-size: 12px;
}

.btn-primary-sd {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    width: 170px;
    padding-left: 10px;
    padding-top: 4px;
    margin-top: 15px;
    margin-right: 20px;
    font-size: 12px;
}

.btn-primary-sho {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    height: 35px;
    width: 200px;
    padding-top: 4px;
    font-size: 12px;
}


.btn-success-sales {
    color: #fff;
    background-color: #4caf50;
    border-color: #4caf50;
    height: 38px;
    width: 130px;
    font-size: 12px;
}

/*dot*/
.circle-container .dot.active{
  background-color: #939a9b;
}

.circle-container .dot.active1{
  background-color: #f2562b;
}

.circle-container .dot.active2{
  background-color: #04dda3;
}

.circle-container .dot.active3{
  background-color: #f7e127;
}

.circle-container .dot.active4{
  background-color: #246d18;
}

.circle-container .dot.active5{
  background-color: #0e0f0f;
}

.circle-container .dot.active6{
  background-color: #FF0000;
}


/*contoh*/

.card {
  position: relative;
  margin-bottom: 24px;
  background-color: #fff;
  -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
}

.step-progress {
  padding: 16px;
  background-color: #FAFAFA;
  margin: 0 auto;
}

.step-progress .step-slider {
  width: 100%;
}

.step-progress .step-slider .step-slider-item {
  width: 25%;
  height: 1px;
  position: relative;
  float: left;
  background-color: #E0E0E0;
}

.step-progress .step-slider .step-slider-item:after {
  content: "";
  width: 10px;
  height: 10px;
  position: absolute;
  top: -6px;
  right: 0;
  background-color: #FAFAFA;
  border: 1px solid #E0E0E0;
  border-radius: 50%;
  transition: all 0.3s ease-out 0.5s;
  -webkit-transition: all 0.3s ease-out 0.5s;
}

.step-progress .step-slider .step-slider-item.active:after {
  border-color: #FF8F00;
}

.step-content .step-content-foot button.active {
  background-color: #00ACC1;
  color: white;
}

.step-content .step-content-body {
  padding: 16px 0;
  text-align: center;
  font-size: 18px;
}

.step-content .step-content-body.out {
  display: none;
}

.html{
  /*background: url('img.jpg') no-repeat center center fixed;*/
  -webkit-background-size:cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

/*body{
  background: url('img.jpg');
}*/

.title-sales a{
  font-size: 20px;
  font-family:  "sans-serif";
}

.field-icon {
  float: right;
  margin-top: 11px;
  z-index: 2;
}

.margin-left-custom-psw {
  margin-left: 35px;
}

.margin-right-custom-psw {
  margin-right: 35px;
}

.bg-start{
  background-color: pink !important;
}

.gridcontainer {
 max-height: 700px;
 overflow: auto;
}

.transparant{
      background-color: Transparent;
      background-repeat:no-repeat;
      border: none;
      cursor:pointer;
      overflow: hidden;
      outline:none;
      width: 25px;
}
button{
  font-size: 12px;
}

  
</style>

@endsection
@section('content')

<section class="content-header">
  <h1>
    Lead Register
  </h1>
  <ol class="breadcrumb">
    <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Lead Register</li>
  </ol>
</section>

<section class="content">

  @if(Auth::User()->id_division == "SALES" && Auth::User()->id_position != 'ADMIN' || Auth::User()->id_division == "TECHNICAL PRESALES" || Auth::User()->id_position == "DIRECTOR" || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER')
    <div class="row mb-3">
      <div class="col-lg-2 col-xs-6">

        <div class="small-box bg-purple">
            <div class="inner">
            <div class="txt_serif stats_item_number"><center><h6 class="counter" id="lead_all">{{$total_lead}}</h6></center></div>
              <center><p>Lead Register</p></center>
            </div>
            <div class="icon">
              <i class="fa fa-list"></i>
            </div>
            <div class="small-box-footer"></div>
        </div>
      </div>
      <div class="col-lg-2 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-orange">
            <div class="inner">
            <div class="txt_serif stats_item_number"><center><h6 class="counter" id="lead_open">{{$total_open}}</h6></center></div>
              <center><p>Open</p></center>
            </div>
            <div class="icon">
              <i class="fa fa-briefcase"></i>
            </div>
            <div class="small-box-footer"></div>
        </div>
      </div>
      <div class="col-lg-2 col-xs-6">
        <!-- small box -->

      <div class="small-box bg-aqua">
            <div class="inner">
            <div class="txt_serif stats_item_number"><center><h6 class="counter" id="lead_sd">{{$total_sd}}</h6></center></div>
              <center><p>Solution Design</p></center>
            </div>
            <div class="icon">
              <i class="fa fa-file-text-o"></i>
            </div>
            <div class="small-box-footer"></div>
      </div>
      </div>
      <div class="col-lg-2 col-xs-6">
        <!-- small box -->

        <div class="small-box bg-yellow">
            <div class="inner">
            <div class="txt_serif stats_item_number"><center><h6 class="counter" id="lead_tp">{{$total_tp}}</h6></center></div>
              <center><p>Tender Process</p></center>
            </div>
            <div class="icon">
              <i class="fa fa-file-text-o"></i>
            </div>
            <div class="small-box-footer"></div>
        </div>
      </div>
      <div class="col-lg-2 col-xs-6">
        <!-- small box -->

        <div class="small-box bg-green">
            <div class="inner">
            <div class="txt_serif stats_item_number"><center><h6 class="counter" id="lead_win">{{$total_win}}</h6></center></div>
              <center><p>Win</p></center>
            </div>
            <div class="icon">
              <i class="fa fa-calendar-check-o"></i>
            </div>
            <div class="small-box-footer"></div>
        </div>

      </div>
      <div class="col-lg-2 col-xs-6">
        <!-- small box -->

        <div class="small-box bg-red">
            <div class="inner">
            <div class="txt_serif stats_item_number"><center><h6 class="counter" id="lead_lose">{{$total_lose}}</h6></center></div>
              <center><p>Lose</p></center>
            </div>
            <div class="icon">
              <i class="fa fa-calendar-times-o"></i>
            </div>
            <div class="small-box-footer"></div>
        </div>

      </div>
    </div>
  @endif
    
  @if (Auth::User()->id_division != 'TECHNICAL PRESALES' && Auth::User()->id_position != 'STAFF' && session('success'))
    <!-- <div class="alert-box notice" id="alert"><span>notice: </span> {{ session('success') }}.</div> -->
  @elseif (Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'STAFF' && session('success'))
    <div class="alert-box warning notification-bar"><span>warning: </span> {{ session('success') }}.
    	<button   type="button" class="dismisbar transparant pull-right"><i class="fa fa-times"></i></button>
    </div>
  @endif

  @if (session('success'))
  <div class="alert alert-success" id="alert">
      {{ session('success') }}
  </div>
  @endif

  @if (session('update'))
  <div class="alert alert-warning" id="alert">
      {{ session('update') }}
  </div>
  @endif

<div class="box">
    <div class="box-header">
      @if(Auth::User()->id_division == 'SALES' && Auth::User()->id_position != 'ADMIN' || Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR'  || Auth::User()->id_division == 'MSM' && Auth::User()->id_position == 'MANAGER')
        <div class="dropdown pull-right" style="margin-left: 5px">
          <button type="button" class="dropbtn-add" id="btn_add_sales" data-toggle="modal" data-target="#modal_lead"><i class="fa fa-plus"> </i>&nbsp Lead Register</button>
        </div>

        <div class="dropdown pull-right">
            <select name="year_dif" id="year_dif" class="btn btn-md btn-success fa" style="font-size: 14px;background-color:#4CAF50;border-style: none;height: 30px;width: 145px">
            @foreach($year as $years)
              @if($years->year < $year_now)
                <option value="{{$years->year}}"> &#xf073 &nbsp&nbsp{{$years->year}}</option>
              @endif
            @endforeach
            <option selected value="{{$year_now}}"> &#xf073 &nbsp&nbsp{{$year_now}}</option>
          </select>
        </div>

        @if(Auth::User()->id_division != 'SALES' && Auth::User()->id_territory != 'OPERATION' && Auth::User()->id_division != 'TECHNICAL PRESALES' && Auth::User()->id_position != 'STAFF')
        <select id="table-filter" class="btn btn-primary pull-right" style="margin-right: 5px;height: 30px">
          <option value="">Filter By Territory</option>
          <option>TERRITORY 1</option>
          <option>TERRITORY 2</option>
          <option>TERRITORY 3</option>
          <option>TERRITORY 4</option>
          <option>TERRITORY 5</option>
        </select>
        @endif

        @if(Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'SALES' && Auth::User()->id_position != 'ADMIN' || Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position != 'STAFF' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' )
        <div style="max-width: 250px;width: 220px" class="pull-left">
          <select class="form-control" style="width: 50%" id="searchTags"></select>
        </div>
        <!-- <input type="" id="searchTagsProd" name=""> -->
        @endif        
      @endif

      @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'STAFF')
        <div class="dropdown pull-right">
            <select name="year_dif" id="year_dif" class="btn btn-md btn-success fa" style="font-size: 14px;background-color:#4CAF50;border-style: none;height: 30px;width: 145px">
            @foreach($year as $years)
              @if($years->year < $year_now)
                <option value="{{$years->year}}"> &#xf073 &nbsp&nbsp{{$years->year}}</option>
              @endif
            @endforeach
            <option selected value="{{$year_now}}"> &#xf073 &nbsp&nbsp{{$year_now}}</option>
          </select>
        </div>
      @endif
    </div>


    <div class="box-body">
      <div id="div_2019" style="display: none;"> 
        <div class="table-responsive">
            <p id="TotalPage"></p>
            <table class="table table-bordered table-striped no-wrap" id="datas2019" width="100%" cellspacing="0">
              <thead>
                <tr>
                  @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_company == '1' || Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_company == '1' || Auth::User()->id_territory == 'OPERATION' || Auth::User()->id_division == 'SALES')
                  @else
                  <th hidden></th>
                  @endif
                  <th>Lead ID</th>
                  <th>Customer</th>
                  <th>Opty Name</th>
                  <th>Create Date</th>
                  <th>Closing Date</th>
                  <th>Owner</th>
                  @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_company == '1' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_company == '2')
                  <th>Presales</th>
                  @endif
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Action</th>
                  @if(Auth::User()->id_division == 'SALES' || Auth::User()->id_company == '1' && Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_company == '2' && Auth::User()->id_division != 'TECHNICAL')
                  <th>Action</th>
                  @endif 
                  <th>Note</th>
                  <th hidden></th>
                  @if(Auth::User()->id_division != 'TECHNICAL PRESALES' && Auth::User()->id_position != 'STAFF')
                  <th hidden>15</th>
                  @endif
                </tr>
                @if(Auth::User()->id_territory == 'OPERATION')
                <tr id="status">
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th hidden></th>
                  <th hidden></th>
                </tr>
                @elseif( Auth::User()->id_division == 'SALES')
                <tr id="status">
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th hidden></th>
                  <th hidden></th>
                </tr>
                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                <tr id="status">
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_company == '1')
                  <th></th>
                  @endif
                  <th></th>
                  <th></th>
                  <th></th>
                  @if(Auth::User()->id_company == '1' && Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR')
                  <th></th>
                  @endif 
                  <th></th>
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                </tr>
                @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                <tr id="status">
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th hidden></th>
                </tr>
                @else
                <tr id="status">
                  <th></th>
                  <th hidden=""></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_company == '1' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_company == '2')
                  <th></th>
                  @endif
                  @if(Auth::User()->id_division == 'SALES' || Auth::User()->id_company == '1' && Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_company == '2' && Auth::User()->id_division != 'TECHNICAL')
                  <th></th>
                  @endif 
                  @if($cek_note > 0)
                  <th></th>
                  @else
                  @endif
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                </tr>
                @endif
              </thead>
              <tbody id="products-list" name="products-list">
                @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'MANAGER')        
                  @foreach($leadsnow as $data)
                    <tr>
                      <td>
                        @if($data->result != 'OPEN')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR')
                            @else
                            <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                            @endif
                        @else
                            {{ $data->lead_id }}
                        @endif
                      </td>
                      <td>{{ $data->brand_name}}</td>
                      <td>{{ $data->opp_name}}</td>
                      <td>{!!substr($data->created_at,0,10)!!}</td>
                      <td>{{ $data->closing_date}}</td>
                      <td>{{ $data->name }}
                      </td>
                      @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_company == '1')
                      <td>
                        @if($data->nik == $st->nik)
                          Satria Teguh Sentosa Mulyono
                        @elseif($data->nik == $rk->nik)
                          Muhammad Rizki Kurniawan
                        @elseif($data->nik == $gp->nik)
                          Ganjar Pramudya Wijaya
                        @elseif($data->nik == $rz->nik)
                          Rizaldo Frendy Kurniawan
                        @elseif($data->nik == $jh->nik)
                          Johan Ardi Wibisono
                        @endif
                      </td>
                      @endif
                        @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                          @if($data->deal_price == NULL)
                            <td><i></i><i class="money">{{$data->amount}}</i></td>
                          @else
                            <td><i></i><i class="money">{{$data->deal_price}}</i></td>
                          @endif
                        @else
                          @if($data->amount == '')
                            <td><i></i><i class="money"></i></td>
                          @elseif($data->amount != '')
                            <td><i></i><i class="money">{{$data->amount}}</i></td>
                          @endif
                        @endif

                        <td>
                          @if($data->result == 'OPEN')
                          <label class="btn-xs status-initial">INITIAL</label>
                          @elseif($data->result == '')
                          <label class="btn-xs status-open">OPEN</label>
                          @elseif($data->result == 'SD')
                            <label class="btn-xs status-sd">SD</label>
                          @elseif($data->result == 'TP')
                            <label class="btn-xs status-tp">TP</label>
                          @elseif($data->result == 'WIN')
                            <label class="btn-xs status-win">WIN</label>
                          @elseif($data->result == 'LOSE')
                            <label class="btn-xs status-lose">LOSE</label>
                          @elseif($data->result == 'CANCEL')
                            <label class="btn-xs status-lose" style="background-color: #071108">CANCEL</label>
                          @elseif($data->result == 'HOLD')
                            <label class="btn-xs status-initial" style="background-color: #919e92">HOLD</label>
                          @elseif($data->result == 'SPECIAL')
                            <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                          @endif
                        </td>
                        <td>
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES' && $data->result == 'WIN' && $data->status_handover != 'handover')
                          <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                          @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
                            @if($data->result != 'OPEN')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                              <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                            @endif
                          @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'MSM')
                            @if($data->result != 'OPEN')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                              <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                            @endif
                          @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
                            @if($data->result != 'OPEN')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                              <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                            @endif
                          @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result != 'OPEN')
                              @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'WIN')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'LOSE')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'TP')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @else
                              <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}','{{$data->name}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                              @endif
                            @else
                              <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                            @endif
                          @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'SALES')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result != 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN' || Auth::User()->id_division == 'SALES')
                              @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' || Auth::User()->id_division == 'SALES')
                                @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_division == 'SALES')
                                  @if($data->status_sho != 'PMO')
                                    <!-- <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button> -->
                                    <button class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button>
                                    @if($data->status_handover != 'handover')
                                      <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                                    @endif
                                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover == 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover == 'handover')
                                  @if($data->status_sho != 'PMO')
                                      <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                                    @elseif($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                      <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                      <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                    @else
                                      <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                          @if($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                          <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                        @else
                                          <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                                          @endif
                                    @endif
                                  @endif
                                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover != 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover != 'handover')
                                  <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                                @endif
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'LOSE' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'TP' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @else
                              <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                              @endif
                            @else
                              <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                            @endif
                          @elseif(Auth::User()->id_position == 'DIRECTOR')
                            @if(Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN')
                              @if(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @else
                              <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                              @endif
                            @else
                              <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                            @endif
                          @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'FINANCE' && $data->result == 'WIN' && $data->status_sho != 'SHO')
                            <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button>
                          @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->result == 'WIN')
                            @if($data->status_sho == 'PMO' && $data->status_engineer == NULL)
                              <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                            @else
                              @if($data->status_engineer == 'v' && Auth::User()->id_position == 'ENGINEER MANAGER')
                              <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                              @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER MANAGER')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER STAFF')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @else
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary disabled">Detail</button></a>
                              @endif
                            @endif
                          @elseif(Auth::User()->id_division != 'PMO')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            @if($data->status_sho == 'PMO' && Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'PMO')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button class="btn btn-xs btn-primary disabled">Detail</button>
                            @endif
                          @endif
                        </td>
                      @if(Auth::User()->id_division == 'SALES' || Auth::User()->id_company == '1' && Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_company == '2' && Auth::User()->id_division != 'TECHNICAL')
                        <td>
                          @if($data->result != 'LOSE' && $data->result != 'WIN' && $data->result != 'CANCEL')
                          <button class="btn btn-xs btn-primary " data-target="#edit_lead_register" data-toggle="modal" onclick="lead_id('{{$data->lead_id}}','{{$data->id_customer}}','{{$data->opp_name}}','{{$data->amount}}','{{$data->created_at}}','{{$data->closing_date}}','{{$data->keterangan}}')" style="width: 60px;">&nbspEdit</button>
                          @endif
                          @if(Auth::User()->name == $data->name && $data->result == 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'OPEN' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' && $data->result == 'OPEN')
                          <a href="{{ url('delete_sales', $data->lead_id) }}"><button class="btn btn-xs btn-danger" style="width: 60px;" onclick="return confirm('Are you sure want to delete this Lead Register? And this data is not used in other table')">&nbspDelete
                          </button></a>
                          @endif
                        </td>
                      @endif
                        <td>
                          @if($data->keterangan != '')
                          <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>
                          @else

                          @endif
                        </td>
                        <td hidden>
                          {{$data->year}}
                        </td>
                        <td hidden>
                          @if($data->result != 'CANCEL' && $data->result != 'LOSE')
                          {{$data->amount}}
                          @endif
                        </td>
                        <td hidden>
                          {{$data->id_territory}}
                        </td>
                    </tr>
                  @endforeach

                  @foreach($leadsprenow as $data)
                    <tr>
                      <td>
                        @if(Auth::User()->id_division == 'PMO')
                          @if($data->result != 'OPEN')
                            @if($data->status_sho == 'PMO')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}">{{$data->lead_id}}</a>
                            @else
                              {{$data->lead_id}}
                            @endif
                          @endif
                        @elseif(Auth::User()->id_position == 'ENGINEER MANAGER')
                          @if($data->result != 'OPEN')
                            @if($data->status_engineer == 'v')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                            @else
                              {{ $data->lead_id }}
                            @endif
                          @endif
                        @elseif(Auth::User()->id_position == 'ENGINEER STAFF')
                          @if($data->result != 'OPEN')
                            @if($data->status_engineer == 'v')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                            @else
                              {{ $data->lead_id }}
                            @endif
                          @endif
                        @else
                          @if(Auth::User()->id_division == 'PMO')
                            @if(Auth::User()->id_division == 'PMO' && $data->status_sho != 'PMO')
                            {{ $data->lead_id }}
                            @elseif(Auth::User()->id_division == 'PMO' && $data->status_handover != 'handover')
                            {{ $data->lead_id }}
                            @elseif($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                            @else
                            {{ $data->lead_id }}
                            @endif
                          @else
                            @if(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->status_sho != 'PMO')
                            {{ $data->lead_id }}
                            @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->status_handover != 'handover')
                            {{ $data->lead_id }}
                            @elseif(Auth::User()->id_position == 'ENGINEER STAFF' && $data->status_sho != 'PMO')
                            {{ $data->lead_id }}
                            @elseif(Auth::User()->id_position == 'ENGINEER STAFF' && $data->status_handover != 'handover')
                            {{ $data->lead_id }}
                            @elseif($data->result != 'OPEN')
                              @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR')
                                @if($data->status_sho == 'PMO' || $data->status_sho == '' || $data->status_handover == 'handover')
                                  <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                                @else
                                  {{ $data->lead_id }}
                                @endif
                              @else
                                <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                              @endif
                            @else
                            {{ $data->lead_id }}
                            @endif
                          @endif
                        @endif
                      </td>
                      <td>{{ $data->brand_name}}</td>
                      <td>{{ $data->opp_name}}</td>
                      <td>{!!substr($data->created_at,0,10)!!}</td>
                      <td>{{ $data->closing_date}}</td>
                      <td>{{ $data->name }}</td>
                      @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_company == '1')
                      <td>
                        @if($data->nik == $st->nik)
                          Satria Teguh Sentosa Mulyono
                        @elseif($data->nik == $rk->nik)
                          Muhammad Rizki Kurniawan
                        @elseif($data->nik == $gp->nik)
                          Ganjar Pramudya Wijaya
                        @elseif($data->nik == $rz->nik)
                          Rizaldo Frendy Kurniawan
                        @elseif($data->nik == $jh->nik)
                          Johan Ardi Wibisono
                        @endif
                      </td>
                      @elseif(Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_company == '2')
                      <td></td>
                      @endif
                        @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                          @if($data->deal_price == NULL)
                            <td><i></i><i class="money">{{$data->amount}}</i></td>
                          @else
                            <td><i></i><i class="money">{{$data->deal_price}}</i></td>
                          @endif
                        @else
                          @if($data->amount == '')
                            <td><i></i><i class="money"></i></td>
                          @elseif($data->amount != '')
                            <td><i></i><i class="money">{{$data->amount}}</i></td>
                          @endif
                        @endif
                      <td>
                        @if($data->result == 'OPEN')
                          <label class="btn-xs status-initial">INITIAL</label>
                        @elseif($data->result == '')
                          <label class="btn-xs status-open">OPEN</label>
                        @elseif($data->result == 'SD')
                          <label class="btn-xs status-sd">SD</label>
                        @elseif($data->result == 'TP')
                          <label class="btn-xs status-tp">TP</label>
                        @elseif($data->result == 'WIN')
                          <label class="btn-xs status-win">WIN</label>
                        @elseif($data->result == 'LOSE')
                          <label class="btn-xs status-lose">LOSE</label>
                        @elseif($data->result == 'CANCEL')
                        <label class="btn-xs status-lose" style="background-color: #071108">CANCEL</label>
                        @elseif($data->result == 'HOLD')
                          <label class="btn-xs status-initial" style="background-color: #919e92">HOLD</label>
                        @endif
                      </td>
                      <td>
                        @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES' && $data->result == 'WIN' && $data->status_handover != 'handover')
                        <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result != 'OPEN')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'WIN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}','{{$data->name}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'SALES')
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result != 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN' || Auth::User()->id_division == 'SALES')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' || Auth::User()->id_division == 'SALES')
                              @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_division == 'SALES')
                                @if($data->status_sho != 'PMO')
                                  <!-- <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button> -->
                                  <button class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button>
                                  @if($data->status_handover != 'handover')
                                    <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                                  @endif
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover == 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover == 'handover')
                                @if($data->status_sho != 'PMO')
                                    <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                                  @elseif($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                    <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                    <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                  @else
                                    <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                        @if($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                        <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                      @else
                                        <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                                        @endif
                                  @endif
                                @endif
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover != 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover != 'handover')
                                <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                              @endif
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'LOSE' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'TP' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'DIRECTOR')
                          @if(Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN')
                            @if(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'FINANCE' && $data->result == 'WIN' && $data->status_sho != 'SHO')
                          <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button>
                        @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->result == 'WIN')
                          @if($data->status_sho == 'PMO' && $data->status_engineer == NULL)
                            <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                          @else
                            @if($data->status_engineer == 'v' && Auth::User()->id_position == 'ENGINEER MANAGER')
                            <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                            @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER MANAGER')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER STAFF')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary disabled">Detail</button></a>
                            @endif
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO' && $data->result == 'WIN' && $data->status_handover == 'handover' && $data->status_sho != 'PMO')
                          <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                        @elseif(Auth::User()->id_division != 'PMO')
                        <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                        @else
                          @if($data->status_sho == 'PMO' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO')
                          
                          <button onclick="reassignPMO('{{$data->lead_id}}','@foreach($contributes as $cons) @if($data->lead_id == $cons->lead_id){{$cons->pmo_nik}}@endif @endforeach','@foreach($users as $pmo_owner) {{$pmo_owner->nik}} @endforeach')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO" >Re-Assign</button></a>
                          @elseif($data->status_sho == 'PMO' && Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'PMO')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                          <button class="btn btn-xs btn-primary disabled">Detail</button>
                          @endif
                        @endif
                      </td>
                      @if(Auth::User()->id_division == 'SALES' && Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER')
                        <td>
                          @if($data->result != 'LOSE' && $data->result != 'WIN' && $data->result != 'CANCEL')
                          <button class="btn btn-xs btn-primary " data-target="#edit_lead_register" data-toggle="modal" onclick="lead_id('{{$data->lead_id}}','{{$data->id_customer}}','{{$data->opp_name}}','{{$data->amount}}','{{$data->created_at}}','{{$data->closing_date}}','{{$data->keterangan}}')" style="width: 60px;">&nbspEdit</button>
                          @endif
                          @if(Auth::User()->name == $data->name && $data->result == 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'OPEN' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' && $data->result == 'OPEN')
                          <a href="{{ url('delete_sales', $data->lead_id) }}"><button class="btn btn-xs btn-danger" style="width: 60px;" onclick="return confirm('Are you sure want to delete this Lead Register? And this data is not used in other table')">&nbspDelete
                          </button></a>
                          @endif
                        </td>
                      @endif
                      <td>
                        @if($data->keterangan != '')
                        <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>
                        @endif
                      </td>
                      <td hidden>
                        {{$data->year}}
                      </td>
                      <td hidden>
                          @if($data->result != 'CANCEL' && $data->result != 'LOSE')
                          {{$data->amount}}
                          @endif
                      </td>
                      <td hidden>
                          {{$data->id_territory}}
                      </td>
                    </tr>
                  @endforeach
                @elseif(Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_territory == 'DPG')
                  @foreach($leads as $data)
                    <tr>
                      <td hidden>
                        {{$data->code_company}}
                      </td>
                      <td>
                        @if($data->result != 'OPEN')
                        <a href="{{ url ('/detail_project', $data->lead_id) }}">{{$data->lead_id}}</a>
                        @else
                        {{ $data->lead_id }}
                        @endif
                      </td>
                      <td>{{ $data->brand_name}}</td>
                      <td>{{ $data->opp_name}}</td>
                      <td>{!!substr($data->created_at,0,10)!!}</td>
                      <td>{{ $data->closing_date}}</td>
                      <td>{{ $data->name }}
                      @if(Auth::User()->id_division == 'PMO' && Auth::User()->id_position == 'STAFF' )
                        {{$data->pmo_nik}} </td>
                      @endif
                      <td>
                        @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                          @if($data->deal_price == NULL)
                            <i class="money">{{$data->amount}}</i>
                          @else
                            <i class="money">{{$data->deal_price}}</i>
                          @endif
                        @else
                          @if($data->amount == '')
                            <i class="money"></i>
                          @elseif($data->amount != '')
                            <i class="money">{{$data->amount}}</i>
                          @endif
                        @endif
                      </td>
                      <td>
                          @if($data->result == 'OPEN')
                            <label class="btn-xs status-initial">INITIAL</label>
                          @elseif($data->result == '')
                            <label class="btn-xs status-open">OPEN</label>
                          @elseif($data->result == 'SD')
                            <label class="btn-xs status-sd">SD</label>
                          @elseif($data->result == 'TP')
                            <label class="btn-xs status-tp">TP</label>
                          @elseif($data->result == 'WIN')
                            <label class="btn-xs status-win">WIN</label>
                          @elseif($data->result == 'LOSE')
                            <label class="btn-xs status-lose">LOSE</label>
                          @elseif($data->result == 'CANCEL')
                          <label class="btn-xs status-lose" style="background-color: #071108">CANCEL</label>
                          @elseif($data->result == 'HOLD')
                            <label class="btn-xs status-initial" style="background-color: #919e92">HOLD</label>
                          @elseif($data->result == 'SPECIAL')
                            <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                          @endif
                      </td>
                      <td>
                        @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES' && $data->result == 'WIN' && $data->status_handover != 'handover')
                        <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result != 'OPEN')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'WIN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}','{{$data->name}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'SALES')
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result != 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN' || Auth::User()->id_division == 'SALES')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' || Auth::User()->id_division == 'SALES')
                              @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_division == 'SALES')
                                @if($data->status_sho != 'PMO')
                                  @if($data->status == 'pending')
                                  <button class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button>
                                  @endif
                                  @if($data->status_handover != 'handover')
                                    <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                                  @endif
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover == 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover == 'handover')
                                @if($data->status_sho != 'PMO')
                                    <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                                  @elseif($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                    <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                    <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                  @else
                                    <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                        @if($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                        <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                      @else
                                        <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                                        @endif
                                  @endif
                                @endif
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover != 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover != 'handover')
                                <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                              @endif
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'LOSE' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'TP' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'DIRECTOR')
                          @if(Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN')
                            @if(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'FINANCE' && $data->result == 'WIN' && $data->status_sho != 'SHO')
                          <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button>
                        @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->result == 'WIN')
                          @if($data->status_sho == 'PMO' && $data->status_engineer == NULL)
                            <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                          @else
                            @if($data->status_engineer == 'v' && Auth::User()->id_position == 'ENGINEER MANAGER')
                            <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                            @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER MANAGER')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER STAFF')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary disabled">Detail</button></a>
                            @endif
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO' && $data->result == 'WIN' && $data->status_handover == 'handover' && $data->status_sho != 'PMO')
                          <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                        @elseif(Auth::User()->id_division != 'PMO')
                        <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                        @else
                          @if($data->status_sho == 'PMO' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO')
                            
                          <button onclick="reassignPMO('{{$data->lead_id}}','@foreach($contributes as $cons) @if($data->lead_id == $cons->lead_id){{$cons->pmo_nik}}@endif @endforeach','@foreach($users as $pmo_owner) {{$pmo_owner->nik}} @endforeach')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO" >Re-Assign</button></a>
                          @elseif($data->status_sho == 'PMO' && Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'PMO')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                          <button class="btn btn-xs btn-primary disabled">Detail</button>
                          @endif
                        @endif
                      </td>
                      @if(Auth::User()->id_division == 'SALES' || Auth::User()->id_company == '1' && Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_company == '2' && Auth::User()->id_division != 'TECHNICAL')
                        <td>
                          @if($data->result != 'LOSE' && $data->result != 'WIN' && $data->result != 'CANCEL')
                            <button class="btn btn-xs btn-primary " data-target="#edit_lead_register" data-toggle="modal" onclick="lead_id('{{$data->lead_id}}','{{$data->id_customer}}','{{$data->opp_name}}','{{$data->amount}}','{{$data->created_at}}','{{$data->closing_date}}','{{$data->keterangan}}')" style="width: 60px;">&nbspEdit</button>
                          @endif
                          @if(Auth::User()->name == $data->name && $data->result == 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'OPEN' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' && $data->result == 'OPEN')
                            <a href="{{ url('delete_sales', $data->lead_id) }}"><button class="btn btn-xs btn-danger" style="width: 60px;" onclick="return confirm('Are you sure want to delete this Lead Register? And this data is not used in other table')">&nbspDelete
                            </button></a>
                          @elseif(Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER')
                            @if($data->result == 'WIN')
                              <a href="{{ url('delete_update_status',$data->lead_id) }}"><button class="btn btn-xs btn-danger" style="width: 60px;" onclick="return confirm('Are you sure want to delete this Lead Register? And this data is not used in other table')" type="submit">&nbspDelete
                              </button></a>
                            @endif
                          @endif
                        </td>
                      @endif
                        <td>
                          @if($data->keterangan != '')
                          <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>

                          @else

                          @endif
                        </td>
                        <td hidden>
                          {{$data->year}}
                        </td>
                        <td hidden>
                          @if($data->result != 'CANCEL' && $data->result != 'LOSE')
                          {{$data->amount}}
                          @endif
                        </td>
                        <td hidden>
                          {{$data->id_territory}}
                        </td>
                    </tr>
                  @endforeach   
                @elseif(Auth::User()->id_territory == 'OPERATION')
                  @foreach($leads as $data)
                  <tr>
                    <!-- <a href="{{ url ('/detail_project', $data->lead_id) }}">{{$data->lead_id}}</a> -->
                    <td>
                    @if($data->result != 'OPEN')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}">{{$data->lead_id}}</a>
                    @else
                    {{ $data->lead_id }}
                    @endif
                    </td>
                    <td>{{ $data->brand_name}}</td>
                    <td>{{ $data->opp_name}}</td>
                    <td>{!!substr($data->created_at,0,10)!!}</td>
                    <td>{{ $data->closing_date}}</td>
                    <td>{{ $data->name }}</td>
                    @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                      @if($data->deal_price == NULL)
                        <td><i></i><i class="money">{{$data->amount}}</i></td>
                      @else
                        <td><i></i><i class="money">{{$data->deal_price}}</i></td>
                      @endif
                    @else
                      @if($data->amount == '')
                        <td><i></i><i class="money"></i></td>
                      @elseif($data->amount != '')
                        <td><i></i><i class="money">{{$data->amount}}</i></td>
                      @endif
                    @endif
                    <td>
                      @if($data->result == 'OPEN')
                          <label class="status-initial">INITIAL</label>
                        @elseif($data->result == '')
                          <label class="status-open">OPEN</label>
                        @elseif($data->result == 'SD')
                          <label class="status-sd">SD</label>
                        @elseif($data->result == 'TP')
                          <label class="status-tp">TP</label>
                        @elseif($data->result == 'WIN')
                          <label class="status-win">WIN</label>
                        @elseif($data->result == 'LOSE')
                          <label class="status-lose">LOSE</label>
                        @elseif($data->result == 'CANCEL')
                        <label class="status-lose" style="background-color: #071108">CANCEL</label>
                        @elseif($data->result == 'HOLD')
                          <label class="status-initial" style="background-color: #919e92">HOLD</label>
                        @elseif($data->result == 'SPECIAL')
                          <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                        @endif
                    </td>
                    <td>
                      <button class="btn btn-xs btn-primary disabled">Detail</button>
                    </td>
                    <td>
                      @if($data->keterangan != '')
                      <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>
                      @else

                      @endif
                    </td>
                    <td hidden>
                      {{$data->year}}
                    </td>
                    <td hidden>
                      @if($data->result != 'CANCEL' && $data->result != 'LOSE')
                      {{$data->amount}}
                      @endif
                    </td>
                  </tr>
                  @endforeach
                @elseif(Auth::User()->id_division == 'SALES')
                  @foreach($lead as $data)
                    <tr>
                      <!-- <td><a href="{{ url ('/detail_project', $data->lead_id) }}">{{$data->lead_id}}</a></td> -->
                      <td>
                        @if($data->result != 'OPEN')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                        @else
                          {{ $data->lead_id }}
                        @endif
                      </td>
                      <td>{{ $data->brand_name}}</td>
                      <td>{{ $data->opp_name}}</td>
                      <td>{!!substr($data->created_at,0,10)!!}</td>
                      <td>{{ $data->closing_date}}</td>
                      <td>{{ $data->name }}</td>
                      <td>
                        @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                          @if($data->deal_price == NULL)
                            <i class="money">{{$data->amount}}</i>
                          @else
                            <i class="money">{{$data->deal_price}}</i>
                          @endif
                        @else
                          @if($data->amount == '')
                            <i class="money"></i>
                          @elseif($data->amount != '')
                            <i class="money">{{$data->amount}}</i>
                          @endif
                        @endif
                      </td>
                      <td>
                          @if($data->result == 'OPEN')
                            <label class="btn-xs status-initial">INITIAL</label>
                          @elseif($data->result == '')
                            <label class="btn-xs status-open">OPEN</label>
                          @elseif($data->result == 'SD')
                            <label class="btn-xs status-sd">SD</label>
                          @elseif($data->result == 'TP')
                            <label class="btn-xs status-tp">TP</label>
                          @elseif($data->result == 'WIN')
                            <label class="btn-xs status-win">WIN</label>
                          @elseif($data->result == 'LOSE')
                            <label class="btn-xs status-lose">LOSE</label>
                          @elseif($data->result == 'CANCEL')
                          <label class="btn-xs status-lose" style="background-color: #071108">CANCEL</label>
                          @elseif($data->result == 'HOLD')
                            <label class="btn-xs status-initial" style="background-color: #919e92">HOLD</label>
                          @elseif($data->result == 'SPECIAL')
                            <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                          @endif
                      </td>
                      <td>
                        @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES' && $data->result == 'WIN' && $data->status_handover != 'handover')
                        <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @endif
                        @if($data->status == 'pending')
                          <button class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">Request PID</button>
                        @endif
                      </td>
                      <td>
                        @if(Auth::User()->id_position != 'ADMIN')
                          @if($data->result != 'LOSE' && $data->result != 'WIN' && $data->result != 'CANCEL' && $data->nik == Auth::User()->nik)
                            <button class="btn btn-xs btn-primary " data-target="#edit_lead_register" data-toggle="modal" onclick="lead_id('{{$data->lead_id}}','{{$data->id_customer}}','{{$data->opp_name}}','{{$data->amount}}','{{$data->created_at}}','{{$data->closing_date}}','{{$data->keterangan}}')" style="width: 60px;">&nbspEdit</button>
                          @else
                          <button class="btn btn-xs btn-primary" disabled style="width: 60px;">&nbspEdit</button>
                          @endif
                          @if(Auth::User()->name == $data->name && $data->result == 'OPEN')
                            <a href="{{ url('delete_sales', $data->lead_id) }}"><button class="btn btn-xs btn-danger" style="width: 60px;" onclick="return confirm('Are you sure want to delete this Lead Register? And this data is not used in other table')">&nbspDelete
                            </button></a>
                          @endif
                        @endif
                      </td>
                      <td>
                        @if($data->keterangan != '')
                        <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>
                        @endif
                      </td>
                      <td hidden>
                        {{$data->year}}
                      </td>
                      <td hidden>
                        @if($data->result != 'CANCEL' && $data->result != 'LOSE')
                        {{$data->amount}}
                        @endif
                      </td>
                    </tr>
                  @endforeach
                @else
                  @foreach($leads as $data)
                  <tr>
                    <td>
                      @if(Auth::User()->id_territory == 'OPERATION')
                        @if($data->result != 'OPEN')
                          @if($data->status_sho == 'PMO')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}">{{$data->lead_id}}</a>
                          @else
                            {{$data->lead_id}}
                          @endif
                      @endif
                      @elseif(Auth::User()->id_position == 'ENGINEER MANAGER')
                        @if($data->result != 'OPEN')
                          @if($data->status_engineer == 'v')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                          @else
                            {{ $data->lead_id }}
                          @endif
                        @endif
                      @elseif(Auth::User()->id_position == 'ENGINEER STAFF')
                        @if($data->result != 'OPEN')
                          @if($data->status_engineer == 'v')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                          @else
                            {{ $data->lead_id }}
                          @endif
                        @endif
                      @else
                        @if(Auth::User()->id_division == 'PMO')
                          @if(Auth::User()->id_division == 'PMO' && $data->status_sho != 'PMO')
                          {{ $data->lead_id }}
                          @elseif(Auth::User()->id_division == 'PMO' && $data->status_handover != 'handover')
                          {{ $data->lead_id }}
                          @elseif($data->result != 'OPEN')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                          @else
                          {{ $data->lead_id }}
                          @endif
                        @else
                          @if(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->status_sho != 'PMO')
                          {{ $data->lead_id }}
                          @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->status_handover != 'handover')
                          {{ $data->lead_id }}
                          @elseif(Auth::User()->id_position == 'ENGINEER STAFF' && $data->status_sho != 'PMO')
                          {{ $data->lead_id }}
                          @elseif(Auth::User()->id_position == 'ENGINEER STAFF' && $data->status_handover != 'handover')
                          {{ $data->lead_id }}
                          @elseif($data->result != 'OPEN')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR')
                              @if($data->status_sho == 'PMO' || $data->status_sho == '' || $data->status_handover == 'handover')
                                <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                              @else
                                {{ $data->lead_id }}
                              @endif
                            @else
                              <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                            @endif
                          @else
                          {{ $data->lead_id }}
                          @endif
                        @endif
                      @endif
                    </td>
                    <td>{{ $data->brand_name}}</td>
                    <td>{{ $data->opp_name}}</td>
                    <td>{!!substr($data->created_at,0,10)!!}</td>
                    <td>{{ $data->closing_date}}</td>
                    <td>{{ $data->name }}</td>
                      @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                        @if($data->deal_price == NULL)
                          <td><i></i><i class="money">{{$data->amount}}</i></td>
                        @else
                          <td><i></i><i class="money">{{$data->deal_price}}</i></td>
                        @endif
                      @else
                        @if($data->amount == '')
                          <td><i></i><i class="money"></i></td>
                        @elseif($data->amount != '')
                          <td><i></i><i class="money">{{$data->amount}}</i></td>
                        @endif
                      @endif
                    <td>
                      @if($data->result == 'OPEN')
                        <label class="status-initial">INITIAL</label>
                      @elseif($data->result == '')
                        <label class="status-open">OPEN</label>
                      @elseif($data->result == 'SD')
                        <label class="status-sd">SD</label>
                      @elseif($data->result == 'TP')
                        <label class="status-tp">TP</label>
                      @elseif($data->result == 'WIN')
                        <label class="status-win">WIN</label>
                      @elseif($data->result == 'LOSE')
                        <label class="status-lose">LOSE</label>
                      @elseif($data->result == 'CANCEL')
                      <label class="status-lose" style="background-color: #071108">CANCEL</label>
                      @elseif($data->result == 'HOLD')
                        <label class="status-initial" style="background-color: #919e92">HOLD</label>
                      @elseif($data->result == 'SPECIAL')
                        <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                      @endif
                    </td>
                    <td>
                      @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES' && $data->result == 'WIN' && $data->status_handover != 'handover')
                      <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                      @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
                        @if($data->result != 'OPEN')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                        @else
                          <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                        @endif
                      @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
                        @if($data->result != 'OPEN')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                        @else
                          <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                        @endif
                      @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                        @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result != 'OPEN')
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'WIN')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'LOSE')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'TP')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                          <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}','{{$data->name}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                          @endif
                        @else
                          <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                        @endif
                      @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'SALES')
                        @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result != 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN' || Auth::User()->id_division == 'SALES')
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' || Auth::User()->id_division == 'SALES')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_division == 'SALES')
                              @if($data->status_sho != 'PMO')
                                <!-- <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button> -->
                                <button class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button>
                                @if($data->status_handover != 'handover')
                                  <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                                @endif
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover == 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover == 'handover')
                              @if($data->status_sho != 'PMO')
                                  <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                                @elseif($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                  <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                  <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                @else
                                  <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                @endif
                              @endif
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover != 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover != 'handover')
                              <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                            @endif
                          @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'LOSE' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'TP' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                          <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                          @endif
                        @else
                          <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                        @endif
                      @elseif(Auth::User()->id_position == 'DIRECTOR')
                        @if(Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN')
                          @if(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                          <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                          @endif
                        @else
                          <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                        @endif
                      @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'FINANCE' && $data->result == 'WIN' && $data->status_sho != 'SHO')
                        <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button>
                      @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->result == 'WIN')
                        @if($data->status_sho == 'PMO' && $data->status_engineer == NULL)
                          <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                        @else
                          @if($data->status_engineer == 'v' && Auth::User()->id_position == 'ENGINEER MANAGER')
                          <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                          @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER MANAGER')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER STAFF')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary disabled">Detail</button></a>
                          @endif
                        @endif
                      @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO' && $data->result == 'WIN' && $data->status_handover == 'handover' && $data->status_sho != 'PMO')
                        <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                      @elseif(Auth::User()->id_division != 'PMO')
                        @if(Auth::User()->id_position == 'OPERATION DIRECTOR')
                          <button class="btn btn-xs disabled" style="background-color: black;color: white">No Action</button>
                        @else
                          <!-- status win dulu -->
                          <!-- PMO mau nambah progress -->
                          @if($data->result == 'WIN')
                          <a href="{{url('PMO/detail',$data->lead_id)}}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                          <a href="#"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @endif
                        @endif
                      @else
                        @if($data->status_sho == 'PMO' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO')
                          
                        <button onclick="reassignPMO('{{$data->lead_id}}','@foreach($contributes as $cons) @if($data->lead_id == $cons->lead_id){{$cons->pmo_nik}}@endif @endforeach','@foreach($users as $pmo_owner) {{$pmo_owner->nik}} @endforeach')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO" >Re-Assign</button></a>
                        @elseif($data->status_sho == 'PMO' && Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'PMO')
                        <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                        @else
                        <button class="btn btn-xs btn-primary disabled">Detail</button>
                        @endif
                      @endif
                    </td>
                    <td>
                      @if($data->keterangan != '')
                      <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>
                      @endif
                    </td>
                    <td hidden>
                      {{$data->year}}
                    </td>
                  </tr>
                  @endforeach
                @endif
              </tbody>
              <tfoot>
                @if(Auth::User()->id_territory != NULL)
                  @if(Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_territory == 'DPG')
                    <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                  @elseif(Auth::User()->id_territory == 'OPERATION')
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  @elseif(Auth::User()->id_division == 'SALES')
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="2"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  @else
                  <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                  @endif
                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                  <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                  <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th hidden></th>
                @else
                  <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                @endif
              </tfoot>
            </table>
        </div>
      </div>
      <div id="div_now">
        <div class="table-responsive">
            <p id="TotalPage"></p>
            <table class="table table-bordered table-striped no-wrap" id="datasnow" width="100%" cellspacing="0">
              <thead>
                <tr>
                  @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_company == '1' || Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_company == '1' || Auth::User()->id_territory == 'OPERATION' || Auth::User()->id_division == 'SALES' )
                  @else
                  <th hidden></th>
                  @endif
                  <th>Lead ID</th>
                  <th>Customer</th>
                  <th>Opty Name</th>
                  <th>Create Date</th>
                  <th>Closing Date</th>
                  <th>Owner</th>
                  @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_company == '1')
                  <th>Presales</th>
                  @endif
                  <th>Amount</th>
                  @if(Auth::User()->id_division != 'FINANCE')
                  <th>Status</th>
                  @endif
                  <th>Action</th>
                  @if(Auth::User()->id_division == 'SALES' || Auth::User()->id_company == '1' && Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR')
                  <th>Action</th>
                  @endif 
                  <th>Note</th>
                  <th hidden="">14</th>
                  <th hidden>15</th>
                  <th hidden></th>
                </tr>
                @if(Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_territory == 'DPG')
                <tr id="sekarang">
                  <th></th>
                  <th hidden=""></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_company == '1')
                  <th></th>
                  @endif
                  @if(Auth::User()->id_division == 'SALES' || Auth::User()->id_company == '1' && Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR')
                  <th></th>
                  @endif 
                  @if($cek_note > 0)
                  <th></th>
                  @else
                  @endif
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                </tr>
                @elseif( Auth::User()->id_division == 'SALES')
                <tr id="sekarang">
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                </tr>
                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                <tr id="sekarang">
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                </tr>
                @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                <tr id="sekarang">
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                </tr>
                @elseif(Auth::User()->id_territory == 'OPERATION')
                <tr id="sekarang">
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                </tr>
                @endif
              </thead>
              <tbody>
              @if(Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_territory == 'DPG')
                @foreach($lead as $data)
                  @if($data->year == $year_now-1)
                    @if($data->result != 'WIN' && $data->result != 'LOSE' && $data->result != 'CANCEL')
                      <tr>
                          <td hidden>
                            {{$data->code_company}}
                          </td>
                          <td>
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                          @else
                            {{ $data->lead_id }}
                          @endif
                          </td>
                          <td>{{ $data->brand_name}}</td>
                          <td>{{ $data->opp_name}}</td>
                          <td>{!!substr($data->created_at,0,10)!!}</td>
                          <td>{{ $data->closing_date}}</td>
                          <td>{{ $data->name }}</td>
                          <td>
                            @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                              @if($data->deal_price == NULL)
                                <i class="money">{{$data->amount}}</i>
                              @else
                                <i class="money">{{$data->deal_price}}</i>
                              @endif
                            @else
                              @if($data->amount == '')
                                <i class="money"></i>
                              @elseif($data->amount != '')
                                <i class="money">{{$data->amount}}</i>
                              @endif
                            @endif
                          </td>
                          <td>
                              @if($data->result == 'OPEN')
                                <label class="btn-xs status-initial">INITIAL</label>
                              @elseif($data->result == '')
                                <label class="btn-xs status-open">OPEN</label>
                              @elseif($data->result == 'SD')
                                <label class="btn-xs status-sd">SD</label>
                              @elseif($data->result == 'TP')
                                <label class="btn-xs status-tp">TP</label>
                              @elseif($data->result == 'WIN')
                                <label class="btn-xs status-win">WIN</label>
                              @elseif($data->result == 'LOSE')
                                <label class="btn-xs status-lose">LOSE</label>
                              @elseif($data->result == 'CANCEL')
                              <label class="btn-xs status-lose" style="background-color: #071108">CANCEL</label>
                              @elseif($data->result == 'HOLD')
                                <label class="btn-xs status-initial" style="background-color: #919e92">HOLD</label>
                              @elseif($data->result == 'SPECIAL')
                                <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                              @endif
                          </td>
                          <td>
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'SALES')
                              @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result != 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN' || Auth::User()->id_division == 'SALES')
                                @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' || Auth::User()->id_division == 'SALES')
                                  @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_division == 'SALES')
                                    @if($data->status == 'pending')
                                     	<!-- <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button> -->
                                     	<button class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}','{{$data->status}}')">ID Project</button>
                                      @if($data->status_handover != 'handover')
                                        <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                                      @endif
                                  @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover == 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover == 'handover')
                                    @if($data->status_sho != 'PMO')
                                        <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                                      @elseif($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                        <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                        <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                      @else
                                        <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                            @if($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                            <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                          @else
                                            <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                                            @endif
                                      @endif
                                    @endif
                                  @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover != 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover != 'handover')
                                    <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                                  @endif
                                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'LOSE' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                                <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'TP' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                                <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                                @else
                                <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                                @endif
                              @else
                                <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                              @endif
                            @elseif(Auth::User()->id_position == 'DIRECTOR')
                              @if(Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN')
                                @if(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN')
                                <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                                @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                                <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                                @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                                <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                                @else
                                <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                                @endif
                              @else
                                <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                              @endif
                            @endif
                          </td>
                          <td>
                            @if($data->result != 'LOSE' && $data->result != 'WIN' && $data->result != 'CANCEL')
                              <button class="btn btn-xs btn-primary " data-target="#edit_lead_register" data-toggle="modal" onclick="lead_id('{{$data->lead_id}}','{{$data->id_customer}}','{{$data->opp_name}}','{{$data->amount}}','{{$data->created_at}}','{{$data->closing_date}}','{{$data->keterangan}}')" style="width: 60px;">&nbspEdit</button>
                            @endif
                            @if(Auth::User()->name == $data->name && $data->result == 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'OPEN' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' && $data->result == 'OPEN')
                              <a href="{{ url('delete_sales', $data->lead_id) }}"><button class="btn btn-xs btn-danger" style="width: 60px;" onclick="return confirm('Are you sure want to delete this Lead Register? And this data is not used in other table')">&nbspDelete
                              </button></a>
                            @elseif(Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER')
                              @if($data->result == 'WIN')
                                <a href="{{ url('delete_update_status',$data->lead_id) }}"><button class="btn btn-xs btn-danger" style="width: 60px;" onclick="return confirm('Are you sure want to delete this Lead Register? And this data is not used in other table')" type="submit">&nbspDelete
                                </button></a>
                              @endif
                            @endif
                          </td>
                          <td>
                            @if($data->keterangan != '')
                            <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>
                            @else

                            @endif
                          </td>
                          <td hidden>
                            {{$data->year}}
                          </td>
                          <td hidden>
                            @if($data->result != 'CANCEL' && $data->result != 'LOSE')
                            {{$data->amount}}
                            @endif
                          </td>
                          <td hidden>{{$data->id_territory}}</td>
                          <td hidden>
                          {{$data->result_concat}}
                          {{$data->result_concat_2}}
                        </td>
                      </tr>
                    @endif
                  @else
                    <tr>
                        <td hidden>
                          {{$data->code_company}}
                        </td>
                        <td>
                        @if($data->result != 'OPEN')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                        @else
                          {{ $data->lead_id }}
                        @endif
                        </td>
                        <td>{{ $data->brand_name}}</td>
                        <td>{{ $data->opp_name}}</td>
                        <td>{!!substr($data->created_at,0,10)!!}</td>
                        <td>{{ $data->closing_date}}</td>
                        <td>{{ $data->name }}</td>
                        <td>
                          @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                            @if($data->deal_price == NULL)
                              <i class="money">{{$data->amount}}</i>
                            @else
                              <i class="money">{{$data->deal_price}}</i>
                            @endif
                          @else
                            @if($data->amount == '')
                              <i class="money"></i>
                            @elseif($data->amount != '')
                              <i class="money">{{$data->amount}}</i>
                            @endif
                          @endif
                        </td>
                        <td>
                            @if($data->result == 'OPEN')
                              <label class="btn-xs status-initial">INITIAL</label>
                            @elseif($data->result == '')
                              <label class="btn-xs status-open">OPEN</label>
                            @elseif($data->result == 'SD')
                              <label class="btn-xs status-sd">SD</label>
                            @elseif($data->result == 'TP')
                              <label class="btn-xs status-tp">TP</label>
                            @elseif($data->result == 'WIN')
                              <label class="btn-xs status-win">WIN</label>
                            @elseif($data->result == 'LOSE')
                              <label class="btn-xs status-lose">LOSE</label>
                            @elseif($data->result == 'CANCEL')
                            <label class="btn-xs status-lose" style="background-color: #071108">CANCEL</label>
                            @elseif($data->result == 'HOLD')
                              <label class="btn-xs status-initial" style="background-color: #919e92">HOLD</label>
                            @elseif($data->result == 'SPECIAL')
                              <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                            @endif
                        </td>
                        <td>
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'SALES')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result != 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN' || Auth::User()->id_division == 'SALES')
                              @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' || Auth::User()->id_division == 'SALES')
                                @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_division == 'SALES')
                                  @if($data->status == 'pending')
                                    <!-- <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button> -->
                                    <button class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}','{{$data->status}}')">ID Project</button>
                                    @if($data->status_handover != 'handover')
                                      <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                                    @endif
                                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover == 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover == 'handover')
                                  @if($data->status_sho != 'PMO')
                                      <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                                    @elseif($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                      <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                      <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                    @else
                                      <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                          @if($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                          <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                        @else
                                          <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                                          @endif
                                    @endif
                                  @endif
                                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover != 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover != 'handover')
                                  <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                                @endif
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'LOSE' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'TP' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @else
                              <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                              @endif
                            @else
                              <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                            @endif
                          @elseif(Auth::User()->id_position == 'DIRECTOR')
                            @if(Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN')
                              @if(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @else
                              <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                              @endif
                            @else
                              <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                            @endif
                          @endif
                        </td>
                        <td>
                          @if($data->result != 'LOSE' && $data->result != 'WIN' && $data->result != 'CANCEL')
                            <button class="btn btn-xs btn-primary " data-target="#edit_lead_register" data-toggle="modal" onclick="lead_id('{{$data->lead_id}}','{{$data->id_customer}}','{{$data->opp_name}}','{{$data->amount}}','{{$data->created_at}}','{{$data->closing_date}}','{{$data->keterangan}}')" style="width: 60px;">&nbspEdit</button>
                          @endif
                          @if(Auth::User()->name == $data->name && $data->result == 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'OPEN' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' && $data->result == 'OPEN')
                            <a href="{{ url('delete_sales', $data->lead_id) }}"><button class="btn btn-xs btn-danger" style="width: 60px;" onclick="return confirm('Are you sure want to delete this Lead Register? And this data is not used in other table')">&nbspDelete
                            </button></a>
                          @elseif(Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER')
                            @if($data->result == 'WIN')
                              <a href="{{ url('delete_update_status',$data->lead_id) }}"><button class="btn btn-xs btn-danger" style="width: 60px;" onclick="return confirm('Are you sure want to delete this Lead Register? And this data is not used in other table')" type="submit">&nbspDelete
                              </button></a>
                            @endif
                          @endif
                        </td>
                        <td>
                          @if($data->keterangan != '')
                          <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>
                          @else

                          @endif
                        </td>
                        <td hidden>
                          {{$data->year}}
                        </td>
                        <td hidden>
                          @if($data->result != 'CANCEL' && $data->result != 'LOSE')
                          {{$data->amount}}
                          @endif
                        </td>
                        <td hidden>{{$data->id_territory}}</td>
                        <td hidden>
                          {{$data->result_concat}}
                          {{$data->result_concat_2}}
                        </td>
                    </tr>
                  @endif
                @endforeach
              @elseif(Auth::User()->id_division == 'SALES')
                @foreach($leads as $datas => $data)
                  @if($data->year == $year_now-1)
                    @if($data->result != 'WIN' && $data->result != 'LOSE' && $data->result != 'CANCEL')
                      <tr>
                        <!-- <td><a href="{{ url ('/detail_project', $data->lead_id) }}">{{$data->lead_id}}</a></td> -->
                        <td>
                        @if($data->result != 'OPEN')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                        @else
                          {{ $data->lead_id }}
                        @endif
                        </td>
                        <td>{{ $data->brand_name}}</td>
                        <td>{{ $data->opp_name}}</td>
                        <td>{!!substr($data->created_at,0,10)!!}</td>
                        <td>{{ $data->closing_date}}</td>
                        <td>{{ $data->name }}</td>
                        <td>
                          @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                            @if($data->deal_price == NULL)
                              <i class="money">{{$data->amount}}</i>
                            @else
                              <i class="money">{{$data->deal_price}}</i>
                            @endif
                          @else
                            @if($data->amount == '')
                              <i class="money"></i>
                            @elseif($data->amount != '')
                              <i class="money">{{$data->amount}}</i>
                            @endif
                          @endif
                        </td>
                        <td>
                            @if($data->result == 'OPEN')
                              <label class="btn-xs status-initial">INITIAL</label>
                            @elseif($data->result == '')
                              <label class="btn-xs status-open">OPEN</label>
                            @elseif($data->result == 'SD')
                              <label class="btn-xs status-sd">SD</label>
                            @elseif($data->result == 'TP')
                              <label class="btn-xs status-tp">TP</label>
                            @elseif($data->result == 'WIN')
                              <label class="btn-xs status-win">WIN</label>
                            @elseif($data->result == 'LOSE')
                              <label class="btn-xs status-lose">LOSE</label>
                            @elseif($data->result == 'CANCEL')
                            <label class="btn-xs status-lose" style="background-color: #071108">CANCEL</label>
                            @elseif($data->result == 'HOLD')
                              <label class="btn-xs status-initial" style="background-color: #919e92">HOLD</label>
                            @elseif($data->result == 'SPECIAL')
                              <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                            @endif
                        </td>
                        <td>
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES' && $data->result == 'WIN' && $data->status_handover != 'handover')
                          <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                          @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
                            @if($data->result != 'OPEN')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                              <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                            @endif
                          @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
                            @if($data->result != 'OPEN')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                              <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                            @endif
                          @endif
                          @if($data->status == 'pending')
                            <button class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button>
                          @endif
                        </td>
                        <td>
                          @if(Auth::User()->id_position != 'ADMIN')
                            @if($data->result != 'LOSE' && $data->result != 'WIN' && $data->result != 'CANCEL' && $data->nik == Auth::User()->nik)
                              <button class="btn btn-xs btn-primary " data-target="#edit_lead_register" data-toggle="modal" onclick="lead_id('{{$data->lead_id}}','{{$data->id_customer}}','{{$data->opp_name}}','{{$data->amount}}','{{$data->created_at}}','{{$data->closing_date}}','{{$data->keterangan}}')" style="width: 60px;">&nbspEdit</button>
                            @else
                            <button class="btn btn-xs btn-primary" disabled style="width: 60px;">&nbspEdit</button>
                            @endif
                            @if(Auth::User()->name == $data->name && $data->result == 'OPEN')
                              <a href="{{ url('delete_sales', $data->lead_id) }}"><button class="btn btn-xs btn-danger" style="width: 60px;" onclick="return confirm('Are you sure want to delete this Lead Register? And this data is not used in other table')">&nbspDelete
                              </button></a>
                            @endif
                          @endif
                        </td>
                        <td>
                          @if($data->keterangan != '')
                          <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>
                          @endif
                        </td>
                        <td hidden>
                          {{$data->year}}
                        </td>
                        <td hidden>
                          @if($data->result != 'CANCEL' && $data->result != 'LOSE')
                          {{$data->amount}}
                          @endif
                        </td>
                        <td hidden>
                          {{$data->result_concat}}
                          {{$data->result_concat_2}}
                        </td>
                      </tr>
                    @endif
                  @elseif($data->year == $year_now)
                    <tr>
                        <td>
                        @if($data->result != 'OPEN')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                        @else
                          {{ $data->lead_id }}
                        @endif
                        </td>
                        <td>{{ $data->brand_name}}</td>
                        <td>{{ $data->opp_name}}</td>
                        <td>{!!substr($data->created_at,0,10)!!}</td>
                        <td>{{ $data->closing_date}}</td>
                        <td>{{ $data->name }}</td>
                        <td>
                          @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                            @if($data->deal_price == NULL)
                              <i class="money">{{$data->amount}}</i>
                            @else
                              <i class="money">{{$data->deal_price}}</i>
                            @endif
                          @else
                            @if($data->amount == '')
                              <i class="money"></i>
                            @elseif($data->amount != '')
                              <i class="money">{{$data->amount}}</i>
                            @endif
                          @endif
                        </td>
                        <td>
                            @if($data->result == 'OPEN')
                              <label class="btn-xs status-initial">INITIAL</label>
                            @elseif($data->result == '')
                              <label class="btn-xs status-open">OPEN</label>
                            @elseif($data->result == 'SD')
                              <label class="btn-xs status-sd">SD</label>
                            @elseif($data->result == 'TP')
                              <label class="btn-xs status-tp">TP</label>
                            @elseif($data->result == 'WIN')
                              <label class="btn-xs status-win">WIN</label>
                            @elseif($data->result == 'LOSE')
                              <label class="btn-xs status-lose">LOSE</label>
                            @elseif($data->result == 'CANCEL')
                            <label class="btn-xs status-lose" style="background-color: #071108">CANCEL</label>
                            @elseif($data->result == 'HOLD')
                              <label class="btn-xs status-initial" style="background-color: #919e92">HOLD</label>
                            @elseif($data->result == 'SPECIAL')
                              <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                            @endif
                        </td>
                        <td>
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES' && $data->result == 'WIN' && $data->status_handover != 'handover')
                          <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                          @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
                            @if($data->result != 'OPEN')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                              <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                            @endif
                          @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
                            @if($data->result != 'OPEN')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                              <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                            @endif
                          @endif
                          @if($data->status == 'pending')
                            <button class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button>
                          @endif
                        </td>
                        <td>
                          @if(Auth::User()->id_position != 'ADMIN')
                            @if($data->result != 'LOSE' && $data->result != 'WIN' && $data->result != 'CANCEL' && $data->nik == Auth::User()->nik)
                              <button class="btn btn-xs btn-primary " data-target="#edit_lead_register" data-toggle="modal" onclick="lead_id('{{$data->lead_id}}','{{$data->id_customer}}','{{$data->opp_name}}','{{$data->amount}}','{{$data->created_at}}','{{$data->closing_date}}','{{$data->keterangan}}')" style="width: 60px;">&nbspEdit</button>
                            @else
                            <button class="btn btn-xs btn-primary" disabled style="width: 60px;">&nbspEdit</button>
                            @endif
                            @if(Auth::User()->name == $data->name && $data->result == 'OPEN')
                              <a href="{{ url('delete_sales', $data->lead_id) }}"><button class="btn btn-xs btn-danger" style="width: 60px;" onclick="return confirm('Are you sure want to delete this Lead Register? And this data is not used in other table')">&nbspDelete
                              </button></a>
                            @endif
                          @endif
                        </td>
                        <td>
                          @if($data->keterangan != '')
                          <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>
                          @endif
                        </td>
                        <td hidden>
                          {{$data->year}}
                        </td>
                        <td hidden>
                          @if($data->result != 'CANCEL' && $data->result != 'LOSE')
                          {{$data->amount}}
                          @endif
                        </td>
                        <td hidden>
                          @foreach(explode(',', $data->result_concat_2) as $info) 
                              <option>{{$info}}</option>
                          @endforeach
                        </td>
                    </tr>
                  @endif
                @endforeach
              @elseif(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'MANAGER')        
                @foreach($leads as $datas => $data)
                    <tr>
                      <td>
                        @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                        @else
                          {{ $data->lead_id }}
                        @endif
                      </td>
                      <td>{{ $data->brand_name}}</td>
                      <td>{{ $data->opp_name}}</td>
                      <td>{!!substr($data->created_at,0,10)!!}</td>
                      <td>{{ $data->closing_date}}</td>
                      <td>{{ $data->name }}</td>
                      <td>-</td>
                      @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                        @if($data->deal_price == NULL)
                          <td><i></i><i class="money">{{$data->amount}}</i></td>
                        @else
                          <td><i></i><i class="money">{{$data->deal_price}}</i></td>
                        @endif
                      @else
                        @if($data->amount == '')
                          <td><i></i><i class="money"></i></td>
                        @elseif($data->amount != '')
                          <td><i></i><i class="money">{{$data->amount}}</i></td>
                        @endif
                      @endif
                      <td>
                        @if($data->result == 'OPEN')
                        <label class="btn-xs status-initial">INITIAL</label>
                        @elseif($data->result == '')
                        <label class="btn-xs status-open">OPEN</label>
                        @elseif($data->result == 'SD')
                          <label class="btn-xs status-sd">SD</label>
                        @elseif($data->result == 'TP')
                          <label class="btn-xs status-tp">TP</label>
                        @elseif($data->result == 'WIN')
                          <label class="btn-xs status-win">WIN</label>
                        @elseif($data->result == 'LOSE')
                          <label class="btn-xs status-lose" data-toggle="modal" data-target="#modal-reason" onclick="lose('{{$data->lead_id}}')">LOSE</label>
                        @elseif($data->result == 'CANCEL')
                          <label class="btn-xs status-lose" style="background-color: #071108">CANCEL</label>
                        @elseif($data->result == 'HOLD')
                          <label class="btn-xs status-initial" style="background-color: #919e92">HOLD</label>
                        @elseif($data->result == 'SPECIAL')
                          <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                        @endif
                      </td>
                      <td>
                        @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES' && $data->result == 'WIN' && $data->status_handover != 'handover')
                        <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result != 'OPEN')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'WIN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}','{{$data->name}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'SALES')
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result != 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN' || Auth::User()->id_division == 'SALES')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' || Auth::User()->id_division == 'SALES')
                              @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_division == 'SALES')
                                @if($data->status_sho != 'PMO')
                                  <!-- <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button> -->
                                  <button class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}','{{$data->status}}')">ID Project</button>
                                  @if($data->status_handover != 'handover')
                                    <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                                  @endif
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover == 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover == 'handover')
                                @if($data->status_sho != 'PMO')
                                    <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                                  @elseif($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                    <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                    <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                  @else
                                    <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                        @if($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                        <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                      @else
                                        <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                                        @endif
                                  @endif
                                @endif
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover != 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover != 'handover')
                                <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                              @endif
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'LOSE' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'TP' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'DIRECTOR')
                          @if(Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN')
                            @if(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'FINANCE' && $data->result == 'WIN' && $data->status_sho != 'SHO')
                          <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}','{{$data->status}}')">ID Project</button>
                        @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->result == 'WIN')
                          @if($data->status_sho == 'PMO' && $data->status_engineer == NULL)
                            <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                          @else
                            @if($data->status_engineer == 'v' && Auth::User()->id_position == 'ENGINEER MANAGER')
                            <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                            @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER MANAGER')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER STAFF')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary disabled">Detail</button></a>
                            @endif
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO' && $data->result == 'WIN' && $data->status_handover == 'handover' && $data->status_sho != 'PMO')
                          <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                        @elseif(Auth::User()->id_division != 'PMO')
                        <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                        @else
                          @if($data->status_sho == 'PMO' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO')
                          
                          <button onclick="reassignPMO('{{$data->lead_id}}','@foreach($contributes as $cons) @if($data->lead_id == $cons->lead_id){{$cons->pmo_nik}}@endif @endforeach','@foreach($users as $pmo_owner) {{$pmo_owner->nik}} @endforeach')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO" >Re-Assign</button></a>
                          @elseif($data->status_sho == 'PMO' && Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'PMO')
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                          <button class="btn btn-xs btn-primary disabled">Detail</button>
                          @endif
                        @endif
                      </td>
                      <td>
                        @if($data->keterangan != '')
                        <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>
                        @endif
                      </td>
                      <td hidden>
                        {{$data->year}}
                      </td>
                      <td hidden>
                          @if($data->result != 'CANCEL' && $data->result != 'LOSE')
                          {{$data->amount}}
                          @endif
                      </td>
                      <td hidden>{{$data->id_territory}}</td>
                      <td hidden>
                        {{$data->result_concat}}
                        {{$data->result_concat_2}}
                      </td>
                    </tr>
                @endforeach
                @foreach($leadspre as $key => $data)
                  @if($data->status != 'cont')
                      <tr>
                        <td>
                          @if($data->result != 'OPEN')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                          @else
                              {{ $data->lead_id }}
                          @endif
                        </td>
                        <td>{{ $data->brand_name}}</td>
                        <td>{{ $data->opp_name}}</td>
                        <td>{!!substr($data->created_at,0,10)!!}</td>
                        <td>{{ $data->closing_date}}</td>
                        <td>{{ $data->name }}</td>
                        <td>
                          {{ $data->name_presales }}
                        </td>
                        @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                          @if($data->deal_price == NULL)
                            <td><i></i><i class="money">{{$data->amount}}</i></td>
                          @else
                            <td><i></i><i class="money">{{$data->deal_price}}</i></td>
                          @endif
                        @else
                          @if($data->amount == '')
                            <td><i></i><i class="money"></i></td>
                          @elseif($data->amount != '')
                            <td><i></i><i class="money">{{$data->amount}}</i></td>
                          @endif
                        @endif
                        <td>
                          @if($data->result == 'OPEN')
                            <label class="btn-xs status-initial">INITIAL</label>
                          @elseif($data->result == '')
                            <label class="btn-xs status-open">OPEN</label>
                          @elseif($data->result == 'SD')
                            <label class="btn-xs status-sd">SD</label>
                          @elseif($data->result == 'TP')
                            <label class="btn-xs status-tp">TP</label>
                          @elseif($data->result == 'WIN')
                            <label class="btn-xs status-win">WIN</label>
                          @elseif($data->result == 'LOSE')
                            <label class="btn-xs status-lose">LOSE</label>
                          @elseif($data->result == 'CANCEL')
                          <label class="btn-xs status-lose" style="background-color: #071108">CANCEL</label>
                          @elseif($data->result == 'HOLD')
                            <label class="btn-xs status-initial" style="background-color: #919e92">HOLD</label>
                          @endif
                        </td>
                        <td>
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result != 'OPEN')
                              @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'WIN')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'LOSE')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'TP')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                              @else
                              <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}','{{$data->name}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                              @endif
                            @else
                              <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                            @endif
                          @else
                            @if($data->status_sho == 'PMO' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO')
                            
                            <button onclick="reassignPMO('{{$data->lead_id}}','@foreach($contributes as $cons) @if($data->lead_id == $cons->lead_id){{$cons->pmo_nik}}@endif @endforeach','@foreach($users as $pmo_owner) {{$pmo_owner->nik}} @endforeach')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO" >Re-Assign</button></a>
                            @elseif($data->status_sho == 'PMO' && Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'PMO')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button class="btn btn-xs btn-primary disabled">Detail</button>
                            @endif
                          @endif
                        </td>
                        <td>
                          @if($data->keterangan != '')
                          <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>
                          @endif
                        </td>
                        <td hidden>{{$data->year}}</td>
                        <td hidden>
                          @if($data->result != 'CANCEL' && $data->result != 'LOSE')
                          {{$data->amount}}
                          @endif
                        </td>
                        <td hidden>{{$data->id_territory}}</td>
                        <td hidden>
                          {{$data->name_product}}
                          {{$data->name_tech}}
                        </td>
                      </tr>
                  @endif
                @endforeach
              @else
                @foreach($leadsnow as $data)
                  @if($data->year == $year_now-1)
                    @if($data->result != 'WIN' && $data->result != 'LOSE' && $data->result != 'CANCEL')
                    <tr>
                      <td>
                        @if(Auth::User()->id_division == 'PMO')
                          @if($data->result != 'OPEN')
                            @if($data->status_sho == 'PMO')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}">{{$data->lead_id}}</a>
                            @else
                              {{$data->lead_id}}
                            @endif
                          @endif
                        @elseif(Auth::User()->id_position == 'ENGINEER MANAGER')
                          @if($data->result != 'OPEN')
                            @if($data->status_engineer == 'v')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                            @else
                              {{ $data->lead_id }}
                            @endif
                          @endif
                        @elseif(Auth::User()->id_position == 'ENGINEER STAFF')
                          @if($data->result != 'OPEN')
                            @if($data->status_engineer == 'v')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                            @else
                              {{ $data->lead_id }}
                            @endif
                          @endif
                        @else
                          @if(Auth::User()->id_division == 'PMO')
                            @if(Auth::User()->id_division == 'PMO' && $data->status_sho != 'PMO')
                            {{ $data->lead_id }}
                            @elseif(Auth::User()->id_division == 'PMO' && $data->status_handover != 'handover')
                            {{ $data->lead_id }}
                            @elseif($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                            @else
                            {{ $data->lead_id }}
                            @endif
                          @else
                            @if(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->status_sho != 'PMO')
                            {{ $data->lead_id }}
                            @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->status_handover != 'handover')
                            {{ $data->lead_id }}
                            @elseif(Auth::User()->id_position == 'ENGINEER STAFF' && $data->status_sho != 'PMO')
                            {{ $data->lead_id }}
                            @elseif(Auth::User()->id_position == 'ENGINEER STAFF' && $data->status_handover != 'handover')
                            {{ $data->lead_id }}
                            @elseif($data->result != 'OPEN')
                              @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR')
                                @if($data->status_sho == 'PMO' || $data->status_sho == '' || $data->status_handover == 'handover')
                                  <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                                @else
                                  {{ $data->lead_id }}
                                @endif
                              @else
                                <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                              @endif
                            @else
                            {{ $data->lead_id }}
                            @endif
                          @endif
                        @endif
                      </td>
                      <td>{{ $data->brand_name}}</td>
                      <td>{{ $data->opp_name}}</td>
                      <td>{!!substr($data->created_at,0,10)!!}</td>
                      <td>{{ $data->closing_date}}</td>
                      <td>{{ $data->name }}</td>
                        @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                          @if($data->deal_price == NULL)
                            <td><i></i><i class="money">{{$data->amount}}</i></td>
                          @else
                            <td><i></i><i class="money">{{$data->deal_price}}</i></td>
                          @endif
                        @else
                          @if($data->amount == '')
                            <td><i></i><i class="money"></i></td>
                          @elseif($data->amount != '')
                            <td><i></i><i class="money">{{$data->amount}}</i></td>
                          @endif
                        @endif
                      <td>
                        @if($data->result == 'OPEN')
                          <label class="status-initial">INITIAL</label>
                        @elseif($data->result == '')
                          <label class="status-open">OPEN</label>
                        @elseif($data->result == 'SD')
                          <label class="status-sd">SD</label>
                        @elseif($data->result == 'TP')
                          <label class="status-tp">TP</label>
                        @elseif($data->result == 'WIN')
                          <label class="status-win">WIN</label>
                        @elseif($data->result == 'LOSE')
                          <label class="status-lose">LOSE</label>
                        @elseif($data->result == 'CANCEL')
                        <label class="status-lose" style="background-color: #071108">CANCEL</label>
                        @elseif($data->result == 'HOLD')
                          <label class="status-initial" style="background-color: #919e92">HOLD</label>
                        @elseif($data->result == 'SPECIAL')
                          <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                        @endif
                      </td>
                      <td>
                        @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES' && $data->result == 'WIN' && $data->status_handover != 'handover')
                        <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'MSM')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result != 'OPEN')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'WIN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}','{{$data->name}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'SALES')
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result != 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN' || Auth::User()->id_division == 'SALES')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' || Auth::User()->id_division == 'SALES')
                              @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_division == 'SALES')
                                @if($data->status_sho != 'PMO')
                                  <!-- <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button> -->
                                  <button class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}','{{$data->status}}')">ID Project</button>
                                  @if($data->status_handover != 'handover')
                                    <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                                  @endif
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover == 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover == 'handover')
                                @if($data->status_sho != 'PMO')
                                    <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                                  @elseif($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                    <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                    <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                  @else
                                    <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                        @if($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                        <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                      @else
                                        <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                                        @endif
                                  @endif
                                @endif
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover != 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover != 'handover')
                                <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                              @endif
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'LOSE' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'TP' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'DIRECTOR')
                          @if(Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN')
                            @if(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'FINANCE' && $data->result == 'WIN' && $data->status_sho != 'SHO')
                          <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}','{{$data->status}}')">ID Project</button>
                        @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->result == 'WIN')
                          @if($data->status_sho == 'PMO' && $data->status_engineer == NULL)
                            <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                          @else
                            @if($data->status_engineer == 'v' && Auth::User()->id_position == 'ENGINEER MANAGER')
                            <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                            @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER MANAGER')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER STAFF')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary disabled">Detail</button></a>
                            @endif
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO' && $data->result == 'WIN' && $data->status_handover == 'handover' && $data->status_sho != 'PMO')
                          <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                        @elseif(Auth::User()->id_division != 'PMO')
                        @if(Auth::User()->id_position == 'OPERATION DIRECTOR')
                          <button class="btn btn-xs disabled" style="background-color: black;color: white">No Action</button>
                        @else
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                        @endif
                        @else
                          <!-- sementara yang win dulu status next lah -->
                          @if($data->result == 'WIN' && Auth::User()->email == 'pmo@sinergy.co.id' ||$data->result == 'WIN' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO' || Auth::User()->id_position == 'PM' && Auth::User()->id_division == 'PMO' && $data->result == 'WIN')
                          <a href="{{url ('/PMO/detail', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @elseif($data->result == 'WIN')
                          <a href="#"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                          <button class="btn btn-xs btn-primary disabled">Detail</button>
                          @endif
                        @endif
                      </td>
                      <td>
                        @if($data->keterangan != '')
                        <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>
                        @endif
                      </td>
                      <td hidden>
                        {{$data->year}}
                      </td>
                      <td hidden>
                          @if($data->result != 'CANCEL' && $data->result != 'LOSE')
                          {{$data->amount}}
                          @endif
                      </td>
                      <td hidden></td>
                    </tr>
                    @endif
                  @else
                    <tr>
                      <td>
                        @if(Auth::User()->id_division == 'PMO')
                          @if($data->result != 'OPEN')
                            @if($data->status_sho == 'PMO')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}">{{$data->lead_id}}</a>
                            @else
                              {{$data->lead_id}}
                            @endif
                          @endif
                        @elseif(Auth::User()->id_position == 'ENGINEER MANAGER')
                          @if($data->result != 'OPEN')
                            @if($data->status_engineer == 'v')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                            @else
                              {{ $data->lead_id }}
                            @endif
                          @endif
                        @elseif(Auth::User()->id_position == 'ENGINEER STAFF')
                          @if($data->result != 'OPEN')
                            @if($data->status_engineer == 'v')
                              <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                            @else
                              {{ $data->lead_id }}
                            @endif
                          @endif
                        @else
                          @if(Auth::User()->id_division == 'PMO')
                            @if(Auth::User()->id_division == 'PMO' && $data->status_sho != 'PMO')
                            {{ $data->lead_id }}
                            @elseif(Auth::User()->id_division == 'PMO' && $data->status_handover != 'handover')
                            {{ $data->lead_id }}
                            @elseif($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                            @else
                            {{ $data->lead_id }}
                            @endif
                          @else
                            @if(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->status_sho != 'PMO')
                            {{ $data->lead_id }}
                            @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->status_handover != 'handover')
                            {{ $data->lead_id }}
                            @elseif(Auth::User()->id_position == 'ENGINEER STAFF' && $data->status_sho != 'PMO')
                            {{ $data->lead_id }}
                            @elseif(Auth::User()->id_position == 'ENGINEER STAFF' && $data->status_handover != 'handover')
                            {{ $data->lead_id }}
                            @elseif($data->result != 'OPEN')
                              @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR')
                                @if($data->status_sho == 'PMO' || $data->status_sho == '' || $data->status_handover == 'handover')
                                  <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                                @else
                                  {{ $data->lead_id }}
                                @endif
                              @else
                                <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                              @endif
                            @else
                            {{ $data->lead_id }}
                            @endif
                          @endif
                        @endif
                      </td>
                      <td>{{ $data->brand_name}}</td>
                      <td>{{ $data->opp_name}}</td>
                      <td>{!!substr($data->created_at,0,10)!!}</td>
                      <td>{{ $data->closing_date}}</td>
                      <td>{{ $data->name }}</td>
                        @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                          @if($data->deal_price == NULL)
                            <td><i></i><i class="money">{{$data->amount}}</i></td>
                          @else
                            <td><i></i><i class="money">{{$data->deal_price}}</i></td>
                          @endif
                        @else
                          @if($data->amount == '')
                            <td><i></i><i class="money"></i></td>
                          @elseif($data->amount != '')
                            <td><i></i><i class="money">{{$data->amount}}</i></td>
                          @endif
                        @endif
                      <td>
                        @if($data->result == 'OPEN')
                          <label class="status-initial">INITIAL</label>
                        @elseif($data->result == '')
                          <label class="status-open">OPEN</label>
                        @elseif($data->result == 'SD')
                          <label class="status-sd">SD</label>
                        @elseif($data->result == 'TP')
                          <label class="status-tp">TP</label>
                        @elseif($data->result == 'WIN')
                          <label class="status-win">WIN</label>
                        @elseif($data->result == 'LOSE')
                          <label class="status-lose">LOSE</label>
                        @elseif($data->result == 'CANCEL')
                        <label class="status-lose" style="background-color: #071108">CANCEL</label>
                        @elseif($data->result == 'HOLD')
                          <label class="status-initial" style="background-color: #919e92">HOLD</label>
                        @elseif($data->result == 'SPECIAL')
                          <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                        @endif
                      </td>
                      <td>
                        @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES' && $data->result == 'WIN' && $data->status_handover != 'handover')
                        <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'MSM')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
                          @if($data->result != 'OPEN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                            <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result != 'OPEN')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'WIN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}','{{$data->name}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'SALES')
                          @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result != 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN' || Auth::User()->id_division == 'SALES')
                            @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' || Auth::User()->id_division == 'SALES')
                              @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_division == 'SALES')
                                @if($data->status_sho != 'PMO')
                                  <!-- <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button> -->
                                  <button class="btn btn-xs btn-primary lead_id_pro" value="{{$data->lead_id}}" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}','{{$data->status}}')">ID Project</button>
                                  @if($data->status_handover != 'handover')
                                    <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                                  @endif
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover == 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover == 'handover')
                                @if($data->status_sho != 'PMO')
                                    <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                                  @elseif($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                    <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                    <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                  @else
                                    <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                        @if($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                        <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                      @else
                                        <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                                        @endif
                                  @endif
                                @endif
                              @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover != 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover != 'handover')
                                <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                              @endif
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'LOSE' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'TP' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}', '{{$data->nik}}', '{{$data->created_at}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'DIRECTOR')
                          @if(Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN')
                            @if(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="reassign('{{$data->lead_id}}')" data-toggle="modal" data-target="#reassignModal" >Re-Assign</button>
                            @endif
                          @else
                            <button type="button" class="btn btn-xs btn-primary" onclick="assign('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModal">Assign</button>
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'FINANCE' && $data->result == 'WIN' && $data->status_sho != 'SHO')
                          <button data-target="#salesproject" data-toggle="modal" class="btn btn-xs btn-primary" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">ID Project</button>
                        @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->result == 'WIN')
                          @if($data->status_sho == 'PMO' && $data->status_engineer == NULL)
                            <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                          @else
                            @if($data->status_engineer == 'v' && Auth::User()->id_position == 'ENGINEER MANAGER')
                            <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                            @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER MANAGER')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER STAFF')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                            @else
                            <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary disabled">Detail</button></a>
                            @endif
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO' && $data->result == 'WIN' && $data->status_handover == 'handover' && $data->status_sho != 'PMO')
                          <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                        @elseif(Auth::User()->id_division != 'PMO')
                        @if(Auth::User()->id_position == 'OPERATION DIRECTOR')
                          <button class="btn btn-xs disabled" style="background-color: black;color: white">No Action</button>
                        @else
                          <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                        @endif
                        @else
                          <!-- sementara yang win dulu status next lah -->
                          @if($data->result == 'WIN' && Auth::User()->email == 'pmo@sinergy.co.id' ||$data->result == 'WIN' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO' || Auth::User()->id_position == 'PM' && Auth::User()->id_division == 'PMO' && $data->result == 'WIN')
                          <a href="{{url ('/PMO/detail', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @elseif($data->result == 'WIN')
                          <a href="#"><button class="btn btn-xs btn-primary">Detail</button></a>
                          @else
                          <button class="btn btn-xs btn-primary disabled">Detail</button>
                          @endif
                        @endif
                      </td>
                      <td>
                        @if($data->keterangan != '')
                        <div type="button" data-target="#modal_notes" style="cursor: pointer;" data-toggle="modal" id="notess" onclick="notes('{{$data->keterangan}}')">{!! substr($data->keterangan, 0, 20) !!}..</div>
                        @endif
                      </td>
                      <td hidden>
                        {{$data->year}}
                      </td>
                      <td hidden>
                          @if($data->result != 'CANCEL' && $data->result != 'LOSE')
                          {{$data->amount}}
                          @endif
                      </td>
                      <td hidden></td>
                    </tr>
                  @endif
                @endforeach
              @endif
              </tbody>
              <tfoot>
                @if(Auth::User()->id_territory != NULL)
                  @if(Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_territory == 'DPG')
                    <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                  @elseif(Auth::User()->id_territory == 'OPERATION')
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  @elseif(Auth::User()->id_division == 'SALES')
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="2"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  @elseif(Auth::User()->id_division == 'FINANCE' && Auth::User()->id_position == 'MANAGER')
                  <th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                  @else
                  <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                  @endif
                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th hidden=""></th>
                  <th hidden=""></th>
                  <th hidden=""></th>
                @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                  <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                @else
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                @endif
              </tfoot>
            </table>
        </div>
      </div>
   </div>
</div>

  @if(Auth::User()->id_division == 'SALES' || Auth::User()->id_division == 'TECHNICAL PRESALES')
      <div class="row">
          <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                  <table class="table table-bordered center" width="100%" cellspacing="0">
                      <thead style="background-color: #343a40!important">
                        <tr style="color: white">
                          <th>Object Privelege</th>
                          <th>Sales</th>
                          <th>Presales Manager</th>
                          <th>Presales</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th>Lead Register</th>
                          <td>CR</td>
                          <td>R</td>
                          <td>R</td>
                        </tr>
                        <tr>
                          <th>Solution Design</th>
                          <td>R</td>
                          <td>R</td>
                          <td>CRU</td>
                        </tr>
                        <tr>
                          <th>Tender Process</th>
                          <td>CRU</td>
                          <td>R</td>
                          <td>R</td>
                        </tr>
                        <tr>
                          <th>Result Win/Lose</th>
                          <td>RU</td>
                          <td>R</td>
                          <td>R</td>
                        </tr>
                        <tr>
                          <th>Sales Handover</th>
                          <td>CR</td>
                          <td>R</td>
                          <td>R</td>
                        </tr>
                        <tr>
                          <th>Assign Presales</th>
                          <td>-</td>
                          <td>CRU</td>
                          <td>-</td>
                        </tr>
                      </tbody>
                  </table>
                  <div>
                    <h6><b>Note :</b></h6>
                    <h6>C : CREATE</h6>
                    <h6>R : READ</h6>
                    <h6>U : UPDATE</h6>
                    <h6>D : DELETE</h6>
                  </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                  <table class="table table-bordered" width="100%" cellspacing="0" >
                      <thead style="background-color: #343a40!important">
                        <tr style="color: white">
                          <th>Status</th>
                          <th>Deskripsi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th>Initial</th>
                          <td>Lead Register pertama kali dibuat</td>
                        </tr>
                        <tr>
                          <th>
                            Open
                          </th>
                          <td>Presales Manager telah mengalokasikan presales</td>
                        </tr>
                        <tr>
                          <th>SD</th>
                          <td>(Solution Design) Presales yang di assign mengerjakan solution design</td>
                        </tr>
                        <tr>
                          <th>TP</th>
                          <td>(Tender Process) Proses Solution Design oleh Presales selesai dilakukan dan Sales mengisi form Tender Process</td>
                        </tr>
                        <tr>
                          <th>Win</th>
                          <td>Tender berhasil dimenangkan</td>
                        </tr>
                        <tr>
                          <th>Lose</th>
                          <td>Tender gagal</td>
                        </tr>
                        <tr>
                          <th>Hold</th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Cancel</th>
                          <td>Tender tidak dilanjutkan</td>
                        </tr>
                      </tbody>
                  </table>
                </div>
            </div>
          </div>
      </div>
  @elseif(Auth::User()->id_division != 'SALES' || Auth::User()->id_division != 'TECHNICAL PRESALES')
    <div class="card mb-3">
          <div class="card-body">
            <table class="table table-bordered" width="100%" cellspacing="0" >
                <thead style="background-color: #343a40!important">
                  <tr style="color: white">
                    <th>Status</th>
                    <th>Deskripsi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>Initial</th>
                    <td>Lead Register pertama kali dibuat</td>
                  </tr>
                  <tr>
                    <th>
                      Open
                    </th>
                    <td>Presales Manager telah mengalokasikan presales</td>
                  </tr>
                  <tr>
                    <th>SD</th>
                    <td>(Solution Design) Presales yang di assign mengerjakan solution design</td>
                  </tr>
                  <tr>
                    <th>TP</th>
                    <td>(Tender Process) Proses Solution Design oleh Presales selesai dilakukan dan Sales mengisi form Tender Process</td>
                  </tr>
                  <tr>
                    <th>Win</th>
                    <td>Tender berhasil dimenangkan</td>
                  </tr>
                  <tr>
                    <th>Lose</th>
                    <td>Tender gagal</td>
                  </tr>
                </tbody>
            </table>
          </div>
    </div>
  @endif

</section>

<!--modal notes-->
<div class="modal fade" id="modal_notes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <p id="notes"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--MODAL ADD PROJECT-->
<div class="modal fade" id="modal_lead" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Add Lead Register</h6>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('store')}}" id="modalSalesLead" name="modalSalesLead">
            @csrf
          
            @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_company == '1')
              <div class="form-group">
              <label for="">Owner</label>
              <select class="form-control" style="width: 100%;" id="owner_sales"  name="owner_sales" required>
                <option value="">-- Select Sales --</option>
                @foreach($owner as $data)
                  @if($data->id_division == 'SALES' && $data->id_company == '1' && $data->id_position != 'ADMIN' || $data->name == 'Presales')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
              </select>
              </div>
            @elseif(Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' && Auth::User()->name != "Operations Team")
              <div class="form-group">
              <label for="">Owner</label>
              <select class="form-control" style="width: 100%;" id="owner_sales" onkeyup="copytextbox();" name="owner_sales" required>
                <option value="">-- Select Sales --</option>
                @foreach($owner as $data)
                  @if($data->id_division == 'SALES' && $data->id_company == '1' && $data->id_position != 'ADMIN')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
              </select>
              </div>
            @elseif(Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '1' )
              <div class="form-group">
              <label for="">Owner</label>
              <select class="form-control" style="width: 100%;" id="owner_sales" onkeyup="copytextbox();" name="owner_sales" required>
                <option value="">-- Select Sales --</option>
                @foreach($owner as $data)
                  @if($data->id_division == 'SALES'  && $data->id_position != 'ADMIN' || $data->id_position == 'DIRECTOR' || $data->id_division == 'TECHNICAL' && $data->id_position == 'MANAGER' && $data->id_territory == '' && $data->name != 'TECH HEAD')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
              </select>
              </div>
            @elseif(Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '2')
              <div class="form-group">
              <label for="">Owner</label>
              <select class="form-control" style="width: 100%;" id="owner_sales" name="owner_sales" required>
                <option value="">-- Select Sales --</option>
                @foreach($owner as $data)
                  @if($data->id_division == 'SALES' && $data->id_company != '1')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
              </select>
              </div>
            @endif

          <div class="form-group">
            <label for="">Customer (Brand Name)</label>
             <select class="form-control" style="width: 100%;" id="contact" onkeyup="copytextbox();" name="contact" required>
              <option value="">-- Select Contact --</option>
              @foreach($code as $data)
                <option value="{{$data->id_customer}}">{{$data->brand_name}} </option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="">Opportunity Name</label>
            <input type="text" class="form-control" placeholder="Enter Opportunity Name" name="opp_name" id="opp_name" required>
          </div>

          <div class="form-group  modalIcon inputIconBg">
            <label for="">Amount</label>
            <input type="text" class="form-control money" placeholder="Enter Amount" name="amount" id="amount" required>
            <i class="" aria-hidden="true">Rp.</i>
          </div>

          <div class="form-group">
            <label for="">Closing Date</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right closing_date" name="closing_date" id="closing_date">
            </div>
          </div>

          @if(Auth::User()->email == "tech@sinergy.co.id")
            <div class="form-group">
              <label for="">Closing Date</label>
              <input type="text" class="form-control pull-right" id="datepicker">
            </div>
          @endif

          <div class="form-group">
            <label for="">Note</label>
            <input type="text" class="form-control" placeholder="Enter Note" name="note" id="note">
          </div>

          <!-- <div class="form-group">
            <label>Product Tag</label>
            <select class="js-product-multiple" name="product[]" id="product" multiple="multiple">
              @foreach($tag_product as $data)
              <option value="{{$data->id}}">{{$data->name_product}}</option>
              @endforeach
            </select>
          </div> -->

          <!-- <div>
            <label>Technology Tag</label>
            <select class="js-technology-multiple" name="technology[]" id="technology" multiple="multiple">
              @foreach($tag_technology as $data)
              <option value="{{$data->id}}">{{$data->name_tech}}</option>
              @endforeach
            </select>
          </div> -->

            <!-- @if(Auth::User()->id_division == 'MSM' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER')
            <div class="form-group" style="padding-left: 25px">
              <label class="checkbox">
                <input type="checkbox" name="po" id="po" value="PO" style="width: 7px;height: 9px">
                <span>Purchase Order <sup>(Optional)</sup></span>
              </label>
            </div>

            <div class="form-group" id="div_date_po" style="display: none;">
              <label for="">Date PO</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right closing_date" name="date_po" id="date_po">
              </div>
            </div>

            <div class="form-group" id="div_no_po" style="display: none;">
              <label for="">No PO</label>
              <input type="text" class="form-control" placeholder="Enter Note" name="no_po" id="no_po" required>
            </div>

            <div class="form-group  modalIcon inputIconBg" id="div_amount_po" style="display: none;">
              <label for="">Amount PO</label>
              <input type="text" class="form-control money" placeholder="Enter Amount" name="amount_po" id="amount_po" required>
              <i class="" aria-hidden="true">Rp.</i>
            </div>

            @endif -->
      
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" id="add_lead" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
        </form>
        </div>
      </div>
    </div>
</div>

<!-- MODAL EDIT PROJECT-->
<div class="modal fade" id="edit_lead_register" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Edit Lead Register</h6>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('update_lead_register')}}" id="modal_edit_saleslead" name="modal_edit_saleslead">
            @csrf

          <input type="" name="lead_id_edit" id="lead_id_edit" hidden>

          <!-- <div class="form-group">
            <label for="">Customer</label>
             <select class="form-control" style="width: 100%;" id="contact_edit" onkeyup="copytextbox();" name="contact_edit" required>
              <option value="">-- Select Contact --</option>
              @foreach($code as $data)
                <option value="{{$data->id_customer}}">{{$data->brand_name}}</option>
                @endforeach
            </select>
          </div> -->

         <div class="form-group">
          <label for="">Opportunity Name</label>
          <textarea type="text" class="form-control" placeholder="Enter Opportunity Name" name="opp_name_edit" id="opp_name_edit">
          </textarea>
         </div>

          <div class="form-group  modalIcon inputIconBg">
            <input type="text" name="amount_edit_before" id="amount_edit_before" hidden>
            <label for="">Amount</label>
            <input type="text" class="form-control money" placeholder="Enter Amount" name="amount_edit" id="amount_edit">
            <i class="" aria-hidden="true">Rp.</i>
          </div>

          <div class="form-group">
            <label for="">Closing Date</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" name="closing_date_edit" id="closing_date_edit">
            </div>
            {{-- <input type="date" name="closing_date_edit" id="closing_date_edit" class="form-control"> --}}
          </div>

          <div class="form-group">
            <label for="">Note (jika perlu)</label>
            <input type="text" class="form-control" placeholder="Enter Note" name="note_edit" id="note_edit">
          </div>

          <div class="form-group">
            <label>Product Tag</label>
            <select class="js-product-multiple" name="product_edit[]" id="product_edit" multiple="multiple">
      
            </select>
          </div>

          <div>
            <label>Technology Tag</label>
            <select class="js-technology-multiple" name="technology_edit[]" id="technology_edit" multiple="multiple">

            </select>
          </div>
 
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
          </div>
        </form>
        </div>
      </div>
    </div>
</div>

<!-- Presales Assignment -->
<div class="modal fade" id="assignModal" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content modal-md">
      <div class="modal-header">
        <h6 class="modal-title">Presales Assignment</h6>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{url('assign_to_presales')}}" id="modalAssign" name="modalAssign">
          @csrf
        <div class="form-group">
          <input type="text" name="cek_nik" id="cek_nik" value="" hidden>
          <input type="text" name="coba_lead" id="coba_lead" value=""  hidden>
          <input type="text" name="cek_created_at" id="cek_created_at" value=""  hidden>
          <h2 for="">Choose Presales</h2>
            <select class="form-control" id="owner" name="owner" required>
            <option>-- Choose --</option>
            @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_company == '1' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_company == '1' || Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '1')
              @foreach($owner as $data)
                @if($data->id_division == 'TECHNICAL PRESALES' && $data->id_company == '1')
                  <option value="{{$data->nik}}">{{$data->name}}</option>
                @endif
              @endforeach
            @elseif(Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_company == '2' || Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '2')
              @foreach($owner as $data)
                @if($data->id_division == 'TECHNICAL PRESALES' && $data->id_company == '2' || $data->id_division == 'TECHNICAL' && $data->id_company == '2')
                  <option value="{{$data->nik}}">{{$data->name}}</option>
                @endif
              @endforeach
            @endif
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp Close</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> </i>&nbspSubmit</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>

<!-- PMO Assignment -->
<div class="modal fade" id="assignModalPMO" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content modal-md">
      <div class="modal-header">
        <h6 class="modal-title">PMO Assignment</h6>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{url('assign_to_pmo')}}" id="modalAssignPMO" name="modalAssignPMO">
          @csrf
        <div class="form-group row">
          <input type="text" name="coba_lead_pmo" id="coba_lead_pmo" value="" hidden>
          <label for="">Choose PMO</label><br>
          <select class="form-control-small margin-left-custom" id="pmo_nik" name="pmo_nik" required>
            <option value="">-- Choose --</option>
              @foreach($owner as $data)
                @if($data->id_division == 'PMO')
                  <option value="{{$data->nik}}">{{$data->name}}</option>
                @endif
              @endforeach
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp Close</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> </i>&nbspSubmit</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade" id="assignEngineer" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content modal-md">
      <div class="modal-header">
        <h6 class="modal-title">Engineer Assignment</h6>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{url('engineer_assign')}}" id="modalAssignEngineer" name="modalAssignEngineer">
          @csrf
        <div class="form-group row">
          <input type="text" name="engineer_lead" id="engineer_lead" value="" hidden>
          <label for="">Choose Engineer</label><br>
          <select class="form-control-small margin-left-custom" id="engineer_nik" name="engineer_nik" required>
            <option>-- Choose Engineer--</option>
              @foreach($owner as $data)
                @if($data->id_position == 'ENGINEER MANAGER')
                  <option value="{{$data->nik}}">{{$data->name}}</option>
                @endif
              @endforeach
              @foreach($owner as $data)
                @if($data->id_position == 'ENGINEER STAFF')
                  <option value="{{$data->nik}}">{{$data->name}}</option>
                @endif
              @endforeach

          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp Close</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> </i>&nbspSubmit</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div> 

<!-- PMO reAssignment -->
<div class="modal fade" id="reassignModalPMO" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content modal-md">
      <div class="modal-header">
        <h6 class="modal-title">PMO Re-Assignment</h6>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{url('reassign_to_pmo')}}" id="modalreassignPMO" name="modalreassignPMO">
          @csrf
        <div class="form-group row">
          <div>
          </div>
          <input type="text" name="pmo_reassign" id="pmo_reassign" value="" hidden>

          <input type="text" name="pmo_nik_update" id="pmo_nik_update" value="" hidden>

          <input type="text" name="owner_pmo" id="owner_pmo" hidden>
            

          <label for="">Choose PMO</label><br>
          <select class="form-control-small margin-left-custom" id="upadte_pmo_nik" name="upadte_pmo_nik" required>
            <option value="">-- Choose PMO --</option>
            @if(Auth::User()->id_division == 'PMO' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR')
              @foreach($users as $data)
                  <option value="{{$data->nik}}">{{$data->name}}</option>
              @endforeach
            @endif
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp Close</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> </i>&nbspSubmit</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade" id="reassignEngineer" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content modal-md">
      <div class="modal-header">
        <h6 class="modal-title">Engineer Re-Assignment</h6>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{url('reassign_to_engineer')}}" id="modalreassignEngineer" name="modalreassignEngineer">
          @csrf
        <div class="form-group row">
          <input type="text" name="engineer_lead_reassign" id="engineer_lead_reassign" hidden>
          <label for="">Choose Engineer</label><br>
          <select class="form-control-small margin-left-custom" id="nik_engineer" name="nik_engineer" required>
            <option>-- Choose --</option>
              @foreach($owner as $data)
                @if($data->id_position == 'ENGINEER MANAGER')
                  <option value="{{$data->nik}}">{{$data->name}}</option>
                @endif
              @endforeach
              @foreach($owner as $data)
                @if($data->id_position == 'ENGINEER STAFF')
                  <option value="{{$data->nik}}">{{$data->name}}</option>
                @endif
              @endforeach
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp Close</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> </i>&nbspSubmit</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>  

<!-- Re-Presales Assignment -->
<div class="modal fade" id="reassignModal" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content modal-md">
      <div class="modal-header">
        <h6 class="modal-title">Presales Re-Assignment</h6>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{url('reassign_to_presales')}}" id="modalreAssign" name="modalreAssign">
          @csrf
        <div class="form-group">
          <input type="text" name="coba_lead_reassign" id="coba_lead_reassign" value="" hidden>
        <!--   <label for="">Current Presales</label><br>
          <input type="text" class="form-control margin-bottom" name="current_presales_update" id="current_presales_update" value="" readonly> -->
          <h2>Choose Presales</h2>
            <select class="form-control" id="owner_reassign" name="owner_reassign" required>
            <option>-- Choose Presales --</option>
            @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_company == '1' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_company == '1' || Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '1')
              @foreach($owner as $data)
                @if($data->id_division == 'TECHNICAL PRESALES' && $data->id_company == '1')
                  <option value="{{$data->nik}}">{{$data->name}}</option>
                @endif
              @endforeach
            @elseif(Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_company == '2' || Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '2')
              @foreach($owner as $data)
                @if($data->id_division == 'TECHNICAL PRESALES' && $data->id_company == '2' || $data->id_division == 'TECHNICAL' && $data->id_company == '2')
                  <option value="{{$data->nik}}">{{$data->name}}</option>
                @endif
              @endforeach
            @endif
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp Close</button>
            <!--  <button type="submit" class="btn btn-primary" id="btn-save" value="add"  data-dismiss="modal" >Submit</button>
            <input type="hidden" id="lead_id" name="lead_id" value="0"> -->
          <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> </i>&nbspSubmit</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>

<!-- Handover -->
<div class="modal fade" id="modal_sho" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content modal-md">
      <div class="modal-header">
        <h6 class="modal-title">Add Sales Handover</h6>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{url('store_sho')}}" id="modalCustomer" name="modalCustomer">
          @csrf
        
        <input type="" name="lead_to_sho" id="lead_to_sho" hidden>
        <!-- <div class="form-group">
          <label for="pid">PID</label>
          <input type="text" class="form-control" id="pid" name="pid" placeholder="PID" readonly>
        </div> -->
        <div class="form-group">
          <label for="name_contact">Scope Of Work</label>
          <textarea class="form-control" id="sow" name="sow"></textarea>
        </div>

        <div class="form-group">
          <label for="timeline">Timeline</label>
          <input type="text" class="form-control" id="timeline" name="timeline" placeholder="Enter Timeline">
        </div>

        <div class="form-group">
          <label for="top">Term of Payment</label>
          <textarea type="text" class="form-control" id="top" name="top" placeholder="" required> </textarea>
        </div>

        <div class="form-group inputWithIconn inputIconBg">
          <label for="budget">Budget</label>
          <input class="form-control money" type="text" placeholder="Enter Project Budget" name="pro_budget"  id="pro_budget" value="" />
              <i class="" style="margin-top: -3px" aria-hidden="true">Rp.</i>
        </div>

        <div class="form-group">
          <label for="meeting">Meeting Date</label>
          <input type="text" class="form-control meeting" id="meeting" name="meeting">
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspAdd</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="salesproject" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Request ID Project</h6>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('store_sp')}}">
            @csrf
          <div class="form-group">
            <label for="">Lead ID</label>
            <input type="" name="customer_name" class="leads" hidden>
            <input type="text" id="customer_name" name="" class="form-control customer_name" readonly>
          </div>

          <div class="form-group">
            <label for="">Project Name</label>
            <input type="text" name="name_project" id="name_project" class="form-control project_name" readonly>
          </div>

          <div class="form-group" hidden>
            <label for="">Sales</label>
            <input type="text" name="sales" id="sales" class="form-control" readonly>
          </div>

          <div class="form-group  modalIcon inputIconBg">
            <label for="">Amount PO</label>
            <input type="text" class="form-control money amount_pid" placeholder="Enter Amount" name="amount" id="amount_id_project" required>
            <i class="" aria-hidden="true">Rp.</i>
          </div>

          <div class="form-group">
            <label for="">Date PO</label>
            <input type="text" name="date" id="date" class="form-control date" required>
          </div>

          <!-- <div class="form-group" style="padding-left: 25px">
            <label class="checkbox">
              <input type="checkbox" name="payungs" id="payungs" value="SP" style="width: 7px;height: 7px">
              <span>Kontrak Payung <sup>(Optional)</sup></span>
            </label>
          </div> -->
   
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-primary-custom"><i class="fa fa-check">&nbsp</i>Submit</button>
            </div>
        </form>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="request_id" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Request ID Project</h6>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('update_result_idpro')}}">
            @csrf
          <div class="form-group">
            <label for="">Lead ID</label>
            <input type="" name="lead_id" class="leadss" hidden>
            <input type="text" id="customer_name" name="" class="form-control customer_names" readonly>
          </div>

          <div class="form-group">
            <label for="">Project Name</label>
            <input type="text" name="name_project" id="name_project" class="form-control project_names" readonly>
          </div>

          <div class="form-group" hidden>
            <label for="">Sales</label>
            <input type="text" name="sales" id="sales" class="form-control" readonly>
          </div>

          <div class="form-group  modalIcon inputIconBg">
            <label for="">Amount PO</label>
            <input type="text" class="form-control money amount_pids" placeholder="Enter Amount" name="amount" id="amount_id_project" required>
            <i class="" aria-hidden="true">Rp.</i>
          </div>

          <div class="form-group">
            <label for="">Date PO</label>
            <input type="text" name="date" id="date" class="form-control dates" required>
          </div>

          <!-- <div class="form-group" style="padding-left: 25px">
            <label class="checkbox">
              <input type="checkbox" name="payungs" id="payungs" value="SP" style="width: 7px;height: 7px">
              <span>Kontrak Payung <sup>(Optional)</sup></span>
            </label>
          </div> -->
   
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-primary-custom"><i class="fa fa-check">&nbsp</i>Submit</button>
            </div>
        </form>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modal-reason" role="dialog">
  <div class="modal-dialog modal-sd">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Reason of Lose</h6>
      </div>
        <div class="modal-body">
          <div class="form-group">
            <textarea class="form-control" readonly id="keterangan_lose" name="keterangan_lose"></textarea>
          </div>
        </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
      </div>
      </div>
    </div>
</div>

<div class="modal fade" id="tunggu" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-body">
          <div class="form-group">
            <div class="">Lead Register Anda Akan di Proses. . .</div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection

@section('scriptImport')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/sum().js')}}"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
  <!-- bootstrap datepicker -->
  <script src="{{asset('template2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

@endsection

@section('script')
<script type="">  
    $('.js-product-multiple').select2();

    $('.js-technology-multiple').select2();

    numeral.register('locale', 'id', {
        delimiters: {
            thousands: '.',
            decimal: ','
        },
        abbreviations: {
            thousand: 'k',
            million: 'm',
            billion: 'b',
            trillion: 't'
        },
        currency: {
            symbol: 'Rp '
        }
    });
    

    $('#date').datepicker();

    $('#po').click(function() {
      var po = this.value;
      console.log(po);
        $("#div_date_po").show();
        $("#div_no_po").show();
        $("#div_amount_po").show();
    })


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

    function notes(keterangan)
    {
      $('#notes').text(keterangan);
    }

    $(document).ready(function() {
      $('#contact').select2({
        dropdownParent: $('#modal_lead')
      });
      $('#contact_edit').select2();
      $('#owner_sales').select2();
    });

    $('#owner').select2();
    $('#owner_reassign').select2();

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    }).attr('readonly','readonly');

    $('.meeting').datepicker({
      autoclose: true
    }).attr('readonly','readonly');

    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

    $('#closing_date').datepicker({
      autoclose: true,
      startDate: today 
    }).attr('readonly','readonly').css('background-color','#fff');

    $('#date_po').datepicker({
      autoclose: true
    }).attr('readonly','readonly').css('background-color','#fff');

    $('#add_lead').click(function(){
      $('#tunggu').modal('show')
      $('#modal_lead').modal('hide')
      setTimeout(function() {$('#tunggu').modal('hide');}, 1000);
    });

    function assign(lead_id,nik,created_at){
      $('#coba_lead').val(lead_id);
      $('#cek_nik').val(nik);
      $('#cek_created_at').val(created_at);
    }
    function sho(lead_id,id_project){
      $('#lead_to_sho').val(lead_id);  
      $('#id_project_sho').val(id_project);     
    }
    function reassignEngineer(lead_id){
       $('#engineer_lead_reassign').val(lead_id);  
    }
    function assignEngineer(lead_id){
       $('#engineer_lead').val(lead_id);  
    }
    
    function assignPMO(lead_id){
      $('#coba_lead_pmo').val(lead_id);
    }
    function reassignPMO(lead_id,pmo_nik,nik){
      $('#pmo_reassign').val(lead_id);
      $('#pmo_nik_update').val(pmo_nik);
      $('#owner_pmo').val(nik);

      var b = document.getElementById("pmo_nik_update").value;
      var c = document.getElementById("owner_pmo").value;

    }
    function reassign(lead_id,nik,name){
      $('#coba_lead_reassign').val(lead_id);
      $('#current_presales_update').val(nik);
      $('#owner_reassign').val(users.name);
    }

    
    $.ajax({
      url:"sales/getProductTag",
      type:"GET",
      success:function(result){
        $("#product_edit").select2().val("");
        var arr = result.results;
        var selectOption = [];
        var otherOption;
        $.each(arr,function(key,value){
          if (value.text != "Others") {
            selectOption.push(value)
          }else{
            otherOption = value
          }
        })
        selectOption.push(otherOption)
        $("#product_edit").select2({
          multiple:true,
          data:selectOption
        })
      }
    })

    $.ajax({
      url:"sales/getTechTag",
      type:"GET",
      success:function(result){
        $("#technology_edit").select2().val("");
        var arr = result.results;
        var selectOption = [];
        var otherOption;
        $.each(arr,function(key,value){
          if (value.text != "Others") {
            selectOption.push(value)
          }else{
            otherOption = value
          }
        })
        selectOption.push(otherOption)
        $("#technology_edit").select2({
          multiple:true,
          data:selectOption
        })
      }
    })

    function lead_id(lead_id,id_customer,opp_name,amount,created_at,closing_date,keterangan){
      console.log(lead_id)
      $('#lead_id_edit').val(lead_id);
      $('#contact_edit').val(id_customer);
      $('#opp_name_edit').val(opp_name);
      $('#amount_edit').val(amount);
      $('#amount_edit_before').val(amount);
      $('#create_date_edit').val(created_at.substring(0,10));
      $("#closing_date_edit").datepicker({format: 'yyyy-mm-dd', startDate:today}).datepicker('setDate', closing_date).attr('readonly','readonly');
      $('#note_edit').val(keterangan);

      $("#product_edit").select2().val("");
      $.ajax({
        url:"sales/getProductEdit",
        type:"GET",
        data:{
          lead_id:lead_id
        },
        success:function(result){
          $("#product_edit").select2().val("");
          $.each(result['results'], function(key, value){
 
            var mainCategory   = $('#product_edit');
            var option = new Option(value.text, value.id, true, true);
            mainCategory.append(option).trigger('change');
          })
        }
      })
      
      $("#technology_edit").select2().val("");
      $.ajax({
        url:"sales/getTechEdit",
        type:"GET",
        data:{
          lead_id:lead_id
        },
        success:function(result){
          $("#technology_edit").select2().val("");
          $.each(result['results'], function(key, value){
            var mainCategory   = $('#technology_edit');
            var option = new Option(value.text, value.id, true, true);
            mainCategory.append(option).trigger('change');
          })
        }
      })

    }

    function lose(lead_id){
      $.ajax({
        url:"sales/getLoseReason",
        type:"GET",
        data:{
          lead_id:lead_id
        },
        success:function(result){
          $('#keterangan_lose').val(result.keterangan);
        }
      })
      // $('#keterangan_lose').val($('#notess').text());

    }

    function id_pro(lead_id,nik,opp_name){
      $('#customer_name').val(lead_id);
      $('#sales').val(nik);
      $('#name_project').val(opp_name);
    }

    $(".lead_id_pro").click(function(){
      var cn = this.value;
      console.log(cn);

        $.ajax({
          type:"GET",
          url:'getleadpid',
          data:{
            lead_sp:cn,
          },
          success: function(result){
            $.each(result[0], function(key, value){
              $('.leadss').val(value.lead_id);
              $('.customer_names').val(value.lead_id + '(' + value.no_po + ')');
              $('.project_names').val(value.opp_name);
              $('.dates').val(moment(value.date_po).format('L'));
              $('.amount_pids').val(value.amount_pid);
            }); 
          },
        }); 

      $("#request_id").modal("show");
    });

      $('.money').mask('000,000,000,000,000', {reverse: true});
      $('.total').mask('000,000,000,000,000,000.00', {reverse: true});

      $("#alert").fadeTo(2000, 500).slideUp(500, function(){
       $("#alert").slideUp(300);
      });

      $(".dismisbar").click(function(){
       $(".notification-bar").slideUp(300);
      }); 

      @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES') {
        var datasnow = $('#datasnow').DataTable({
           "responsive":true,
           "order": [[ "3", "desc" ]],
           pageLength: 50,
           "orderCellsTop": true,
           "footerCallback": function( row, data, start, end, display ) {
	            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;

	            var api = this.api(),data;
	            // Remove the formatting to get integer data for summation

	            var total = api.column(12, {page:'current'}).data().sum();

	            var filtered = api.column( 12, {"filter": "applied"} ).data().sum();

	            var totalpage = api.column(12).data().sum();

	            $( api.column( 5 ).footer() ).html("Total Amount");

	            $( api.column( 6 ).footer() ).html(numFormat(totalpage));

	            $( api.column( 6 ).footer() ).html(numFormat(filtered)+'');

	        },
	        initComplete: function () {
            this.api().columns([[0],[1],[5],[6],[8]]).every( function () {
                var column = this;
                var title = $(this).text();
                var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Show All '+ title +'</option></select>')
                    .appendTo($("#sekarang").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option>'+d+'</option>')
                });

                initkat();
                
            });

            $('#table-filter').on('change', function(){
              datasnow.columns(13).search( this.value ).draw(); 
            }); 
          }
        });

        $.ajax({
            url:"sales/getProductTechTag",
            type:"GET",
            success:function(result){
              console.log(result)
              $("#searchTags").select2().val("");
              var arr = result;
              var selectOption = [];
              var otherOption;
              $.each(arr,function(key,value){
                if (value.text != "Others") {
                  selectOption.push(value)
                }else{
                  otherOption = value
                }
              })

              selectOption.push(otherOption)
              var TagProduct = $("#searchTags").select2({
                placeholder: " Select #Tags#Product#Technology",
                allowClear: true,
                multiple:true,
                data:selectOption,
                templateSelection: function(selection,container) {
                  var selectedOption = selection.id.slice(0,1);
                  console.log(selection.id.slice(0,1))
                    if(selectedOption == 'p') {
                        $(container).css("background-color", "#32a852");
                        $(container).css("border-color","#32a852");
                        return selection.text;
                    }
                    else {
                        return $.parseHTML('<span>' + selection.text + '</span>');
                    }
                }
              })

              $('#searchTags').on('change', function(){
                  var search = "";

                  $.each($('#searchTags').select2('data'), function(key,value){
                      search = search+value.text+" "
                  });
                  datasnow.columns(14).search(search).draw(); 
              });
            }
        
        })

        var table = $('#datas2019').DataTable({
           "responsive":true,
           "columnDefs":[
            {"width": "20%", "targets":5},
            {"width": "20%", "targets":6},
            {"width": "7%", "targets":3},
            {"width": "20%", "targets":1},
            {"width": "25%", "targets":2},
           ],
           "order": [[ 3, "desc" ]],
           pageLength: 50,
           "orderCellsTop": true,
           	"footerCallback": function( row, data, start, end, display ) {
			  
  			  	var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp' ).display;

                var api = this.api(),data;
  	            // Remove the formatting to get integer data for summation
  	            var intVal = function ( i ) {
    				  return typeof i === 'string' ?
    				    i.replace(/[\$,]/g, '')*1 :
    				  typeof i === 'number' ?
    				    i : 0;
    				};

    				var total = api.column(12).data().sum();

    				var filtered = api.column( 12, {"filter": "applied"} ).data().sum();

            $( api.column( 6 ).footer() ).html("Total Amount");
	           
	          $( api.column( 7 ).footer() ).html(numFormat(filtered) + '');

			   },
         initComplete: function () {
            this.api().columns([[0],[1],[5],[6],[8]]).every( function () {
                var column = this;
                var title = $(this).text();
                var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Show All '+ title +'</option></select>')
                    .appendTo($("#status").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
                
                column.data().unique().sort().each(function (d, j) {
                    select.append('<option>'+d+'</option>')
                });

                initkat();
                
            });

            $('#table-filter').on('change', function(){
              table.columns(13).search( this.value ).draw(); 
            });
          }
        });

        // datasnow.on( 'draw', function () {
        //   var body = $(datasnow.table().body());

        //   body.unhighlight();
        //   body.highlight(datasnow.search('BBJB210601'));  
        // });

        if (localStorage.getItem('status') == "unread") {
          datasnow.search(localStorage.getItem('lead_id')).draw()
        }


        if (localStorage.getItem('status') == 'read') {
          datasnow.search("").draw()
        }

      }@elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'TECHNICAL PRESALES') {
        var datasnow = $('#datasnow').DataTable({
           "responsive":true,
           "columnDefs":[
            {"width": "20%", "targets":5},
            {"width": "20%", "targets":6},
            {"width": "7%", "targets":3},
            {"width": "20%", "targets":1},
            {"width": "25%", "targets":2},
           ],
           "order": [[ 3, "desc" ]],
           "orderCellsTop": true,
           pageLength: 50,
           "footerCallback": function( row, data, start, end, display ) {
        
            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp' ).display;

            var api = this.api(),data;
              // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
            return typeof i === 'string' ?
              i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
              i : 0;
          };

          var total = api.column(6).data().sum();

          var filtered = api.column( 6, {"filter": "applied"} ).data().sum();

          $( api.column( 5 ).footer() ).html("Total Amount");
             
          $( api.column( 6).footer() ).html(numFormat(filtered) + '');

         },
         initComplete: function () {
            this.api().columns([[1],[5],[7]]).every( function () {
                var column = this;
                var title = $(this).text();
                var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Filter '+ title +'</option></select>')
                    .appendTo($("#sekarang").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option>'+d+'</option>')
                });

                initkat();
                
            });

            $('#table-filter').on('change', function(){
              datasnow.columns(13).search( this.value ).draw(); 
            });
          }
        });

        var table = $('#datas2019').DataTable({
           // "scrollX": true,
           "responsive":true,
           "columnDefs":[
            {"width": "20%", "targets":5},
            {"width": "20%", "targets":6},
            {"width": "7%", "targets":3},
            {"width": "20%", "targets":1},
            {"width": "25%", "targets":2},
           ],
           "order": [[ 3, "desc" ]],
           "orderCellsTop": true,
           pageLength: 50,
          "footerCallback": function( row, data, start, end, display ) {
        
          var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp' ).display;

                var api = this.api(),data;
              // Remove the formatting to get integer data for summation
              var intVal = function ( i ) {
            return typeof i === 'string' ?
              i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
              i : 0;
          };

          var total = api.column(6).data().sum();

          var filtered = api.column( 6, {"filter": "applied"} ).data().sum();

          $( api.column( 5 ).footer() ).html("Total Amount");
             
          $( api.column( 6).footer() ).html(numFormat(filtered) + '');

         },
         initComplete: function () {
            this.api().columns([[1],[5],[7]]).every( function () {
                var column = this;
                var title = $(this).text();
                var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Filter '+ title +'</option></select>')
                    .appendTo($("#status").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option>'+d+'</option>')
                });

                initkat();
                
            });

            $('#table-filter').on('change', function(){
              table.columns(14).search( this.value ).draw(); 
            });
          }
        });

      }@else{

        @if(Auth::User()->id_territory == 'OPERATION')
          
          $('#datasnow').DataTable({
           "responsive":true,
           "order": [[ "3", "desc" ]],
           pageLength: 50,
           "orderCellsTop": true,
           "footerCallback": function( row, data, start, end, display ) {
        
            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;

                  var api = this.api(),data;
                // Remove the formatting to get integer data for summation

            var filtered = api.column(6, {"filter": "applied"} ).data().sum();

                $( api.column(5).footer() ).html("Total Amount");

                $( api.column(6).footer() ).html(numFormat(filtered)+'');


             },
             initComplete: function () {
                this.api().columns([[0],[1],[5],[7]]).every( function () {
                    var column = this;
                    var title = $(this).text();
                    var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Filter '+ title +'</option></select>')
                        .appendTo($("#sekarang").find("th").eq(column.index()))
                        .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val());                                     

                        column.search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option>'+d+'</option>')
                    });

                    initkat();
                    
                });
            },
            })


            var table = $('#datas2019').DataTable({
             "responsive":true,
             "order": [[ "3", "desc" ]],
             pageLength: 50,
             "orderCellsTop": true,
             "footerCallback": function( row, data, start, end, display ) {
          
            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;

                  var api = this.api(),data;
                // Remove the formatting to get integer data for summation

            var filtered = api.column(6, {"filter": "applied"} ).data().sum();

                $( api.column(5).footer() ).html("Total Amount");

                $( api.column(6).footer() ).html(numFormat(filtered)+'');


             },
             initComplete: function () {
                this.api().columns([[0],[1],[5],[7]]).every( function () {
                    var column = this;
                    var title = $(this).text();
                    var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Filter '+ title +'</option></select>')
                        .appendTo($("#status").find("th").eq(column.index()))
                        .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val());                                     

                        column.search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });
                    
                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option>' + d + '</option>')
                    });

                    initkat();
                    
                });
            },
          })
        
        @elseif(Auth::User()->id_division == 'SALES')
          var datasnow = $('#datasnow').DataTable({
           "responsive":true,
           "order": [[ "3", "desc" ]],
           pageLength: 50,
           "orderCellsTop": true,
           "footerCallback": function( row, data, start, end, display ) {
        
            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;

                  var api = this.api(),data;
                // Remove the formatting to get integer data for summation

            var filtered = api.column(12, {"filter": "applied"} ).data().sum();

                  $( api.column(5).footer() ).html("Total Amount");

                  $( api.column(6).footer() ).html(numFormat(filtered)+'');


             },
             initComplete: function () {
                this.api().columns([[1],[7]]).every( function () {
                    var column = this;
                    var title = $(this).text();
                    var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Filter '+ title +'</option></select>')
                        .appendTo($("#sekarang").find("th").eq(column.index()))
                        .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val());                                     

                        column.search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });
                    
                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option>'+d+'</option>')
                    });

                    initkat();
                    
                });
              },
          })

          $.ajax({
            url:"sales/getProductTechTag",
            type:"GET",
            success:function(result){
              console.log(result)
              $("#searchTags").select2().val("");
              var arr = result;
              var selectOption = [];
              var otherOption;
              $.each(arr,function(key,value){
                if (value.text != "Others") {
                  selectOption.push(value)
                }else{
                  otherOption = value
                }
              })

              selectOption.push(otherOption)
              var TagProduct = $("#searchTags").select2({
                placeholder: " Select #Tags#Product#Technology",
                multiple:true,
                allowClear: true,
                data:selectOption,
                templateSelection: function(selection,container) {
                  var selectedOption = selection.id.slice(0,1);
                  console.log(selection.id.slice(0,1))
                    if(selectedOption == 'p') {
                        $(container).css("background-color", "#32a852");
                        $(container).css("border-color","#32a852");
                        return selection.text;
                    }
                    else {
                        return $.parseHTML('<span>' + selection.text + '</span>');
                    }
                }
              })

              $('#searchTags').on('change', function(){
                  // var search = "";
                  var pattern =''; 
                  $.each($('#searchTags').select2('data'), function(key,value){
                      // search = search+value.text+" "
                      if (pattern!='') pattern+='|';
                          pattern+=value.text;
                  });
                  datasnow.columns(13).search(pattern, true, false, true).draw();
                  // datasnow.columns(13).search(search).draw(); 
              });

              $('#searchTagsProd').keyup(function(e){
                  // TagProduct.search($(this).val()).draw() ;
                  if(e.keyCode==13){
                      var arr = $('#searchTagsProd').val().split(' ');
                      var pattern ='';  
                      arr.forEach(function(item) {
                          if (pattern!='') pattern+='|';
                          pattern+=item;
                      });

                      datasnow.columns(13).search(pattern, true, false, true).draw();
                      // datasnow.columns(13).search(pattern).draw(); 
                   }
                    
              })
            }
          })

          var table =  $('#datas2019').DataTable({
             "responsive":true,
             "order": [[ "3", "desc" ]],
             pageLength: 50,
             "orderCellsTop": true,
             "footerCallback": function( row, data, start, end, display ) {
          
              var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;

                    var api = this.api(),data;
                  // Remove the formatting to get integer data for summation

              var filtered = api.column(12, {"filter": "applied"} ).data().sum();

                  $( api.column(5).footer() ).html("Total Amount");

                  $( api.column(6).footer() ).html(numFormat(filtered)+'');


               },
               initComplete: function () {
                  this.api().columns([[1],[5],[7]]).every( function () {
                      var column = this;
                      var title = $(this).text();
                      var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Filter '+ title +'</option></select>')
                          .appendTo($("#status").find("th").eq(column.index()))
                          .on('change', function () {
                          var val = $.fn.dataTable.util.escapeRegex(
                          $(this).val());                                     

                          column.search(val ? '^' + val + '$' : '', true, false)
                              .draw();
                      });

                      column.data().unique().sort().each(function (d, j) {
                          select.append('<option>'+d+'</option>')
                      });

                      initkat();
                      
                  });
              
                },
          })

        @else

          var datasnow = $('#datasnow').DataTable({
             "responsive":true,
             "order": [[ "4", "desc" ]],
             pageLength: 50,
             "orderCellsTop": true,
             "footerCallback": function( row, data, start, end, display ) {
                var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;

                var api = this.api(),data;
                // Remove the formatting to get integer data for summation

                var total = api.column(13, {page:'current'}).data().sum();

                var filtered = api.column(13, {"filter": "applied"} ).data().sum();

                var totalpage = api.column(13).data().sum();

                $( api.column( 5 ).footer() ).html("Total Amount");

                $( api.column( 6 ).footer() ).html(numFormat(totalpage));

                $( api.column( 6 ).footer() ).html(numFormat(filtered)+'');

            },
            initComplete: function () {
              this.api().columns([[0],[2],[6],[8]]).every( function () {                
                  var column = this;

                  if (column.index() == 8) {
                    column.columns([8]).every(function() {
                        // console.log(this.data()[0])
                        var statusLead = []
                        this.data().each(function(d,j){
                          statusLead.push(d.slice(d.indexOf(">") + 1,d.indexOf("</")))
                          // console.log(d.slice(d.indexOf(">") + 1,d.indexOf("</")))
                        })
                        function onlyUnique(value, index, self) {
                          return self.indexOf(value) === index;
                        }

                        var statusLeadUnique = statusLead.filter(onlyUnique);

                        // console.log(statusLeadUnique.sort())
                        // console.log(statusLead)
                        var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Show All '+ '</option></select>')
                            .appendTo($("#sekarang").find("th").eq(column.index()))
                            .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val());                                     

                            column.search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                        statusLeadUnique.sort().forEach(function(item) {
                          var title = item;
                          select.append('<option>'+item+'</option>')

                        });                        
                    })                    

                  }else{
                    var title = $(this).text();
                    var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Show All '+ title +'</option></select>')
                        .appendTo($("#sekarang").find("th").eq(column.index()))
                        .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val());                                     

                        column.search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option>'+d+'</option>')
                    });
                  }

                  initkat();
                  
              });              

              $.ajax({
                url:"sales/getProductTechTag",
                type:"GET",
                success:function(result){
                  console.log(result)
                  $("#searchTags").select2().val("");
                  var arr = result;
                  var selectOption = [];
                  var otherOption;
                  $.each(arr,function(key,value){
                    if (value.text != "Others") {
                      selectOption.push(value)
                    }else{
                      otherOption = value
                    }
                  })

                  selectOption.push(otherOption)
                  var TagProduct = $("#searchTags").select2({
                    placeholder: " Select #Tags#Product#Technology",
                    multiple:true,
                    data:selectOption,
                    allowClear: true,
                    templateSelection: function(selection,container) {
                      var selectedOption = selection.id.slice(0,1);
                      console.log(selection.id.slice(0,1))
                        if(selectedOption == 'p') {
                            $(container).css("background-color", "#32a852");
                            $(container).css("border-color","#32a852");
                            return selection.text;
                        }
                        else {
                            return $.parseHTML('<span>' + selection.text + '</span>');
                        }
                    }
                  })

                  $('#searchTags').on('change', function(){
                      // var search = "";

                      // $.each($('#searchTags').select2('data'), function(key,value){
                      //     search = search+value.text+" "

                      // });
                      // datasnow.columns(15).search(search).draw(); 
                        var pattern =''; 
                        $.each($('#searchTags').select2('data'), function(key,value){
                            // search = search+value.text+" "
                            if (pattern!='') pattern+='|';
                                pattern+=value.text;
                        });
                        datasnow.columns(15).search(pattern, true, false, true).draw();
                  });

                  $('#searchTagsProd').keyup(function(){
                      // TagProduct.search($(this).val()).draw() ;
                      datasnow.columns(15).search(this.value).draw(); 
                  })
                }
              })

              $('#table-filter').on('change', function(){
                  datasnow.columns(14).search( this.value ).draw(); 
              }); 

             },
             
          });

          var table = $('#datas2019').DataTable({
             "responsive":true,
             "order": [[ "4", "desc" ]],
             pageLength: 50,
             "orderCellsTop": true,
            "footerCallback": function( row, data, start, end, display ) {
                var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;

                var api = this.api(),data;
                // Remove the formatting to get integer data for summation

                var total = api.column(7, {page:'current'}).data().sum();

                var filtered = api.column( 13, {"filter": "applied"} ).data().sum();

                var totalpage = api.column(13).data().sum();

                $( api.column( 5 ).footer() ).html("Total Amount");

                $( api.column( 6 ).footer() ).html(numFormat(totalpage));

                $( api.column( 6 ).footer() ).html(numFormat(filtered)+'');


              },
            initComplete: function () {
                this.api().columns([[0],[2],[6],[8]]).every( function () {
                    var column = this;
                    var title = $(this).text();
                    var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Show All '+ title +'</option></select>')
                        .appendTo($("#status").find("th").eq(column.index()))
                        .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val());                                     

                        column.search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option>' + d + '</option>')
                    });

                    initkat();
                    
                });

                $('#table-filter').on('change', function(){
                  table.columns(14).search( this.value ).draw(); 
                }); 
            },
          })
        
        @endif

      }
      @endif
       
      @if (Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_territory == 'DPG' || Auth::User()->id_division == 'SALES' || Auth::User()->id_division == 'TECHNICAL PRESALES'  || Auth::User()->id_division == 'MSM' && Auth::User()->id_position == 'MANAGER')
       
  	    $('#year_dif').on('change', function() {

            if ($('#year_dif').val() == new Date().getFullYear()) {
              $('#div_now').css("display", "block");
              $('#div_2019').css("display", "none");
            }else{
              $('#div_now').css("display", "none");
              $('#div_2019').css("display", "block");
            }

  	      	table.draw();

  	      	var product = $('#year_dif').val();

  	  	  	$.ajax({
  	          type:"GET",
  	          url:'/year_initial',
  	          data:{
  	            product:this.value,
  	          },
  	          success: function(result){
  	          	$.each(result[0], function(key, value){
                if (result[0] == "null") {
                  $('#lead_all').text('0');    
                }else{
    	       			$('#lead_all').text(result[0].length);
                }
  	          	});
  	             
  	          }
  	      	});

  	      	$.ajax({
  	          type:"GET",
  	          url:'/year_open',
  	          data:{
  	            product:this.value,
  	          },
  	          success: function(result){
  	          	$.each(result[0], function(key, value){
                  if (result[0] == "null") {
                    $('#lead_open').text('0');    
                  }else{
                    $('#lead_open').text(result[0].length);    
                  }
  	          	});
  	             
  	          }
  	      	});

  	      	$.ajax({
  	          type:"GET",
  	          url:'/year_sd',
  	          data:{
  	            product:this.value,
  	          },
  	          success: function(result){
  	          	$.each(result[0], function(key, value){
                  if (result[0] == "null") {
                    $('#lead_sd').text('0');    
                  }else{
  	       			    $('#lead_sd').text(result[0].length);
  	          	  }
                });
  	             
  	          }
  	      	});

  	      	$.ajax({
  	          type:"GET",
  	          url:'/year_tp',
  	          data:{
  	            product:this.value,
  	          },
  	          success: function(result){
  	          	$.each(result[0], function(key, value){
                  if (result[0] == "null") {
                    $('#lead_tp').text('0');    
                  }else{
  	       			     $('#lead_tp').text(result[0].length);
  	          	  }
                });
  	             
  	          }
  	      	});

  	      	$.ajax({
  	          type:"GET",
  	          url:'/year_win',
  	          data:{
  	            product:this.value,
  	          },
  	          success: function(result){
  	          	$.each(result[0], function(key, value){
  	       			 if (result[0] == "null") {
                    $('#lead_win').text('0');    
                  }else{
                    $('#lead_win').text(result[0].length);
  	          	  }
                });
  	             
  	          }
  	      	});


  	      	$.ajax({
  	          type:"GET",
  	          url:'/year_lose',
  	          data:{
  	            product:this.value,
  	          },
  	          success: function(result){
  	          	$.each(result[0], function(key, value){
  	       			 if (result[0] == "null") {
                    $('#lead_lose').text('0');    
                  }else{
                    $('#lead_lose').text(result[0].length);
  	          	  }
                });
  	             
  	          }
  	      	});
  	    });

      @endif

      @if (Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_territory == 'DPG')
        $.fn.dataTable.ext.search.push(
          function(settings, data, dataIndex) {
              var years = parseInt($('#year_dif').val());
              var tahunbanding = parseInt(data[12]);
            if ( ( isNaN( years ) ) ||
               ( years  ==  tahunbanding ))           
            {
            return true;
            }
           
            return false;  
          }
        );
      @elseif(Auth::User()->id_division == 'SALES' || Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'MANAGER')
        $.fn.dataTable.ext.search.push(
          function(settings, data, dataIndex) {
              var years = parseInt($('#year_dif').val());
              var tahunbanding = parseInt(data[11]);
          if ( ( isNaN( years ) ) ||
               ( years  ==  tahunbanding ))
          {
          return true;
          }
          return false;  
          }
        );
      @elseif(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'STAFF' || Auth::User()->id_division == 'MSM' && Auth::User()->id_position == 'MANAGER')
        $.fn.dataTable.ext.search.push(
          function(settings, data, dataIndex) {
              var years = parseInt($('#year_dif').val());
              var tahunbanding = parseInt(data[10]);
          if ( ( isNaN( years ) ) ||
               ( years  ==  tahunbanding ))
          {
          return true;
          }
          return false;  
          }
        );
      @endif
      
    function initkat()
    {
        $('.kat_drop').select2();
    }

    $("#btn-filter").change(function(){
      console.log($("#btn-filter").val());
      $.ajax({
          type:"GET",
          url:'{{url("/getBtnFilter")}}',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#btn-filter-child').html(append)
                var append = "<option value=''>-- Select Option --</option>";

                if (result[1] == 'company') {
                  $.each(result[0], function(key, value){
                    append = append + "<option>" + value.code_company + "</option>";
                  });

                  $('#btn-filter-child').on('change', function(){
                    if (this.value == null) {
                      datasnow.reload();
                    }else{
                      datasnow.columns(0).search(this.value).draw();
                    }
                     
                     console.log(this.value);
                  });

                } else if (result[1] == 'territory') {
                  $.each(result[0], function(key, value){
                    append = append + "<option>" + value.name_territory + "</option>";
                  });

                  $('#btn-filter-child').on('change', function(){
                     datasnow.columns(14).search(this.value).draw();
                     console.log(this.value);
                  });
                }

                $('#btn-filter-child').html(append);
          },
      });
    })

  </script>
@endsection