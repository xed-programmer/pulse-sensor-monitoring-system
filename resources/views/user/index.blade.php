@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mt-4">
            <div class="card-header">
                Patients
            </div>
            <div class="card-body">
                <div class="row">                    
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add">Add Patient</button>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Devices</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">
                                    Add Device
                                </button>
                                <table id="deviceTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>PATIENT NUMBER</th>
                                            <th>NAME</th>
                                            <th>AGE</th>
                                            <th>PHONE</th>
                                            <th>CONTROL</th>
                                        </tr>
                                    </thead>        
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content bg-info">
            <div class="modal-header">
                <h4 class="modal-title">Add Patient</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('user.patient.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="patient_number">Patient Number</label>
                        <input type="text" class="form-control" id="patient_number" name="patient_number"
                            placeholder="Enter Patients Number">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-light">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

@push('scripts')
<x-data-table-scripts/>
<script>
    $(function () {
        $("#deviceTable").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          ajax:{
            method:"POST",
            url: "{{ route('device.data') }}",
            data:{
              api_key:"tPmAT5Ab3j7F9"
            }
          },
          columns:[
            {'data': 1},
            {'data': 2},
            {'data': 3},
            {
              'data': 0,
              'render':function(data,type,row,meta){
                return `<form action="{{ route("admin.device.delete") }}" method="POST" onsubmit="return confirm('Do you want to delete this device?');"> @csrf @method("DELETE") <input type="hidden" name="id" value='+data+'> <input type="button" id="btn_edit_device" data-toggle="modal" data-target="#modal-edit" data-device-id="${data}" class="btn bg-warning" value="Edit"> <input type="submit" class="btn bg-danger" value="Delete"> </form>`
              }
            },
          ]
        });

        setInterval(() => {            
            $("#deviceTable").DataTable().ajax.reload();
        }, 3000);
      });    
</script>
@endpush