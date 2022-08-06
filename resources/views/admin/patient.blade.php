@extends('layouts.admin')

@push('links')
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
<x-data-table-links />
@endpush

@section('header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Patient</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Patient</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <div class="card">
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
                    {{-- <tbody>
                        @foreach ($patients as $patient)
                        <tr>
                            <th>{{ $patient->patient_number }}</th>
                            <th>{{ $patient->name }}</th>
                            <th>{{ $patient->age }}</th>
                            <th>{{ $patient->phone }}</th>
                            <th>
                                <form action="{{ route('admin.patient.delete', $patient) }}" method="POST"
                                    onsubmit="return confirm('Do you want to delete this patient?');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="button" id="btn_edit_patient" data-toggle="modal" data-target="#modal-edit" data-patient-id="{{ $patient->id }}" class="btn bg-warning" value="Edit">
                                    <input type="submit" class="btn bg-danger" value="Delete">
                                </form>
                            </th>
                        </tr>
                        @endforeach
                    </tbody> --}}
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
            <form action="{{ route('admin.patient.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="name">Patient Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Patient Name">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" min="0" class="form-control" id="age" name="age"
                            placeholder="Enter Patient Age">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                            placeholder="Enter Patient Phone">
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
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content bg-warning">
            <div class="modal-header">
                <h4 class="modal-title">Update Patient</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.patient.update') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="text" class="form-control" id="patient_id" name="id" hidden>
                    <div class="form-group">
                        <label for="edit_name">Patient Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="edit_age">Age</label>
                        <input type="number" class="form-control" id="edit_age" name="age">
                    </div>
                    <div class="form-group">
                        <label for="edit_phone">Phone</label>
                        <input type="tel" class="form-control" id="edit_phone" name="phone">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-dark">Save</button>
                </div>
            </form>
        </div>        
    </div>    
</div>
@endsection

@push('scripts')
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
@if (session()->has('message'))
    @if(session()->get('result') == "success")
        <script>
            toastr.success("{{ session()->get('message') }}")
        </script>
    @else
        <script>
            toastr.error("{{ session()->get('message') }}")
        </script>
    @endif
@endif

<script>
    $(function(){
        $('body').on('click', '#btn_edit_patient', function(){
            var patient_id = $(this).data('patient-id')
            $('#patient_id').val("")
            $('#edit_name').val("")
            $('#edit_age').val("")
            $('#edit_phone').val("")              
            $.when($.ajax({
                method:"GET",
                url: "{{ route('admin.patient.edit') }}",
                data:{
                    id: patient_id
                }
            }))
            .then((data,textStatus,jqXHR)=>{
                $('#patient_id').val(data['id'])
                $('#edit_name').val(data['name'])
                $('#edit_age').val(data['age'])
                $('#edit_phone').val(data['phone'])                
            })
        })
    })
</script>
<x-data-table-scripts/>
<script>
    $(function () {
        $("#patientTable").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          ajax:{
            method:"POST",
            url: "{{ route('patient.data') }}",
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
                return `<form action="{{ route("admin.patient.delete") }}" method="POST" onsubmit="return confirm('Do you want to delete this patient?');"> @csrf @method("DELETE") <input type="hidden" name="id" value='+data+'> <input type="button" id="btn_edit_patient" data-toggle="modal" data-target="#modal-edit" data-patient-id="${data}" class="btn bg-warning" value="Edit"> <input type="submit" class="btn bg-danger" value="Delete"> </form>`
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