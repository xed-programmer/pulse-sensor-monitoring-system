@extends('layouts.admin')

@push('scripts')
    <x-data-table-links/>
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Devices</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="deviceTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>MACHINE NUMBER</th>
                            <th>PATIENT</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>NAME</th>
                            <th>MACHINE NUMBER</th>
                            <th>PATIENT</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<x-data-table-scripts id="#deviceTable"/>
@endpush