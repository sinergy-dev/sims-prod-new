@extends('template.main')
@section('tittle')
PMO
@endsection
@section('head_css')
    <style type="text/css">
        .select2{
            width:100%!important;
        }
        .selectpicker{
            width:100%!important;
        }
    </style>
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Project Manager
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Project Manager</li>
        </ol>
    </section>

    <section class="content">
        <div class="row mb-3">
            <div class="col-lg-2 col-xs-2">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <div class="txt_serif stats_item_number"><center><h6 class="counter" id="designs">{{ $count_d }}</h6></center></div>
                        <center><p>Design</p></center>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-xs-2">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <div class="txt_serif stats_item_number"><center><h6 class="counter" id="stagings">{{ $count_s }}</h6></center></div>
                        <center><p>Staging</p></center>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-xs-2">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <div class="txt_serif stats_item_number"><center><h6 class="counter" id="implementations">{{ $count_i }}</h6></center></div>
                        <center><p>Implementation</p></center>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-xs-2">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <div class="txt_serif stats_item_number"><center><h6 class="counter" id="migrations">{{ $count_m }}</h6></center></div>
                        <center><p>Migration</p></center>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-xs-2">
                <div class="small-box bg-green">
                    <div class="inner">
                        <div class="txt_serif stats_item_number"><center><h6 class="counter" id="testings">{{ $count_t }}</h6></center></div>
                        <center><p>Testing</p></center>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-xs-2">
                <div class="small-box bg-olive">
                    <div class="inner">
                        <div class="txt_serif stats_item_number"><center><h6 class="counter" id="testings">{{ $count_done }}</h6></center></div>
                        <center><p>Done</p></center>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h6 class="box-title">

                </h6>

                <div class="box-tools pull-right">
                    <button class="btn btn-xs btn-primary" id="btnAddProject" data-toggle="modal" data-target="#project_add" style="width: 75px; display: none;"><i class="fa fa-plus"> </i>&nbsp Project</button>
                </div>
            </div>
          
            <div class="box-body">
                <table class="table table-bordered table-striped" id="implementation_table">
                    <thead>
                        <tr>
                            <th style="width: 2%"><center>No.</center></th>
                            <th style="width: 10%"><center>Lead ID</center></th>
                            <th><center>Project Title</center></th>
                            <th style="width: 10%"><center>Status</center></th>
                            <th style="width: 10%"><center>Action</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach($data as $datas)
                            <tr>
                                <td><center>{{ $no++ }}</center></td>
                                <td><center>{{ $datas->lead_id }}</center></td>
                                <td>
                                    <a href="{{ url('/PMO/detail', $datas->lead_id) }}">{{ $datas->title }}</a>
                                </td>
                                <td><center>{{ $datas->current_phase }}</center></td>
                                <td><center>
                                    <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#project_edit" onclick="edit('{{$datas->id}}','{{$datas->lead_id}}','{{$datas->title}}')" style="width: 40px"><i class="fa fa-pencil"></i></button>
                                    <a href="{{ url('project_delete', $datas->id) }}">
                                        <button class="btn btn-xs btn-danger" style="vertical-align: top; width: 40px;" onclick="return confirm('Are you sure want to delete this Project? (Seluruh data absen dan progress akan terhapus secara PERMANEN)')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>
                                    </center>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{--  Project Add  --}}
        <div class="modal fade" id="project_add" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
                <form method="POST" action="{{url('store_phase')}}" id="project_add_form" name="project_add_form">
                {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalLongTitle">Project Manager</h6>
                        </div>
                        <div class="modal-body" >
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-xs-6">
                                        <label>Lead ID</label><br>
                                        <select name="pmo_lead_add" id="pmo_lead_add" class="form-control select" required>
                                            <option value="">- Select Lead ID -</option>
                                            @foreach($lead_win as $leads)
                                                <option value="{{ $leads->lead_id }}">[{{ $leads->lead_id }}] {{ $leads->opp_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-xs-6">
                                        <label>Project Title</label>
                                        <input type="text" class="form-control" id="add_project_title" name="add_project_title" placeholder="Enter title" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><span style="background-color: red;color: white">--Phase--</span></label>
                                <div class="row">
                                    <div class="col-xs-6 col-md-6">
                                        <label>Design</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" id="design_date" name="design_date">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-6">
                                        <label>Staging</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" id="staging_date" name="staging_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-md-6">
                                        <label>Implementation</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" id="implementation_date" name="implementation_date">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-6">
                                        <label>Migration</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" id="migration_date" name="migration_date">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6 col-md-6">
                                        <label>Testing</label>
                                        <div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                        <input type="text" class="form-control" id="testing_date" name="testing_date">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-6">
                                    </div>
                                </div>
                                                                
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6 col-md-6">
                                        <label>Project Leader</label><br>
                                        <select name="project_leader" id="project_leader" class="form-control select" required>
                                            <option value="">Nothing selected</option>
                                            <option value="{{ $engineer_manager->nik }}">{{ $engineer_manager->name }}</option>
                                            @foreach($engineer_staff as $engineer)
                                                <option value="{{ $engineer->nik }}">{{ $engineer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-xs-6">
                                        <label>Member</label><br>
                                        <select name="project_member[]" id="project_member" multiple="multiple" class="form-control select" multiple required>
                                            <option value="{{ $engineer_manager->nik }}">{{ $engineer_manager->name }}</option>
                                            @foreach($engineer_staff as $engineer)
                                                <option value="{{ $engineer->nik }}">{{ $engineer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" style="width: 15%" id="checkBtnAdd">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{--  Project Edit  --}}
        <div class="modal fade" id="project_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form method="POST" action="{{url('/implementation/update_project')}}" id="project_edit_form" name="project_edit_form">
                {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalLongTitle">Implementation (Edit)</h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" value="" id="id_project" name="id_project" hidden>
                                <label>Lead ID</label><br>
                                <input type="text" class="form-control" id="current_lead" name="current_lead" readonly><br>
                                <select class="selectpicker" data-live-search="true" name="edit_lead_id_win" id="edit_lead_id_win" class="form-control">
                                    <option value="">- Select Lead ID -</option>
                                    @foreach($lead_win as $leads)
                                        <option value="{{ $leads->lead_id }}">[{{ $leads->lead_id }}] {{ $leads->opp_name }}</option>
                                    @endforeach
                                </select><p style="color: red;"><small>*kosongi jika tidak ada perubahan</small></p>
                            </div>
                            <div class="form-group">
                                <label>Project Title</label>
                                <input type="text" class="form-control" id="edit_title" name="edit_title" placeholder="Enter title" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" style="width: 20%" id="checkBtnAdd">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>

@endsection

@section('scriptImport')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection

@section('script')

    <script type="text/javascript">

        $(document).ready(function(){
          var accesable = @json($feature_item);
          accesable.forEach(function(item,index){
            $("#" + item).show()
          })
          if (accesable.includes('col-action-2')) {
            var column = table.column(4);
            column.visible(column.visible());
          }else{
            var column = table.column(4);
            column.visible(!column.visible());
          }
        })

        var table = $('#implementation_table').DataTable();

        $('input[name="design_date"]').daterangepicker();
        $('input[name="staging_date"]').daterangepicker();
        $('input[name="implementation_date"]').daterangepicker();
        $('input[name="migration_date"]').daterangepicker();
        $('input[name="testing_date"]').daterangepicker();

        $('#pmo_lead_add, #project_leader, #project_member').select2({
            closeOnSelect: false
        });

        function edit(id, lead_id, title){
            $('#id_project').val(id);
            $('#current_lead').val(lead_id);
            $('#edit_title').val(title);
        }

    </script>

@endsection