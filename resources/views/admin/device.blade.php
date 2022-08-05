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
                <h1 class="m-0">Device</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Device</li>
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
                            <th>NAME</th>
                            <th>MACHINE NUMBER</th>
                            <th>PATIENT</th>
                            <th>CONTROL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($devices as $device)
                        <tr>
                            <th>{{ $device->name }}</th>
                            <th>{{ $device->machine_number }}</th>
                            <th>
                                @if(!empty($device->patient->name))
                                {{ $device->patient->name }}
                                @endif
                            </th>
                            <th>
                                <form action="{{ route('admin.device.delete', $device) }}" method="POST"
                                    onsubmit="return confirm('Do you want to delete this device?');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="button" id="btn_edit_device" data-toggle="modal" data-target="#modal-edit" data-device-id="{{ $device->id }}" class="btn bg-warning" value="Edit">
                                    <input type="submit" class="btn bg-danger" value="Delete">
                                </form>
                            </th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content bg-info">
            <div class="modal-header">
                <h4 class="modal-title">Add Device</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.device.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="name">Device Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Device Name">
                    </div>
                    <div class="form-group">
                        <label for="machine_number">Device Number</label>
                        <input type="text" class="form-control" id="machine_number" name="machine_number"
                            placeholder="Enter Device Number">
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
                <h4 class="modal-title">Add Device</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.device.update') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="text" class="form-control" id="device_id" name="id" hidden>
                    <div class="form-group">
                        <label for="edit_name">Device Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="edit_machine_number">Device Number</label>
                        <input type="text" class="form-control" id="edit_machine_number" name="machine_number">
                    </div>
                    <div class="form-group">
                        <label for="edit_patient">Patient Name</label>                        
                        <select class="form-control" name="patient" id="edit_patient">
                            <option value=""></option>
                            @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name }}</option>                                
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-dark">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
        $('body').on('click', '#btn_edit_device', function(){
            var device_id = $(this).data('device-id')
            $.when($.ajax({
                method:"GET",
                url: "{{ route('admin.device.edit') }}",
                data:{
                    id: device_id
                }
            }))
            .then((data,textStatus,jqXHR)=>{
                $('#device_id').val(data['id'])
                $('#edit_name').val(data['name'])
                $('#edit_machine_number').val(data['machine_number'])
                $('#edit_patient').val(data['patient']['id'])
            })
        })
    })
</script>
<x-data-table-scripts id="#deviceTable"/>
@endpush