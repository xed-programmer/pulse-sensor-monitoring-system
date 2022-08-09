@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Patients</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">
                    Add Patient
                </button>
                <table id="patientTable" class="table table-bordered table-striped">
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
        $("#patientTable").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          ajax:{
            method:"POST",
            url: "{{ route('user.patient.data', auth()->user()) }}",
            data:{
              api_key:"tPmAT5Ab3j7F9"
            }
          },
          columns:[
            {'data': 1},
            {'data': 2},
            {'data': 3},
            {'data': 4},
            {
              'data': 0,
              'render':function(data,type,row,meta){
                return `<form action="{{ route("user.patient.delete") }}" method="POST" onsubmit="return confirm('Do you want to remove this patient?');"> @csrf @method("DELETE") <input type="hidden" name="id" value=${data}> <input type="submit" class="btn bg-danger" value="Remove"> </form>`
              }
            },
          ]
        });

        setInterval(() => {            
            $("#patientTable").DataTable().ajax.reload();
        }, 3000);
      });    
</script>
@endpush