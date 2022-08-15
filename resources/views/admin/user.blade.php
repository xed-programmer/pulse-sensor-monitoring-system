@extends('layouts.admin')

@push('links')
<x-data-table-links />
@endpush

@section('header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">User</li>
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
                <h3 class="card-title">User</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">
                    Add User
                </button>
                <table id="userTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>                            
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>ROLE</th>
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
                <h4 class="modal-title">Add User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.user.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" name="role" class="form-control">
                            @foreach ($roles as $role)
                                <option  value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>                        
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirm Password</label>
                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation"
                            placeholder="Confirm Password" required>
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
                <h4 class="modal-title">Update User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.user.update') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" class="form-control" id="user_id" name="id" hidden>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" class="form-control">
                            @foreach ($roles as $role)
                                <option  value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>                        
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" disabled>
                    </div>
                    <div class="form-group">
                        <label for="edit_name">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name">
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
<script>
    $(function(){
        $('body').on('click', '#btn_edit_user', function(){
            var user_id = $(this).data('user-id')
            $('#user_id').val("")
            $('#edit_name').val("")
            $('#edit_email').val("")
            $.when($.ajax({
                method:"GET",
                url: "{{ route('admin.user.edit') }}",
                data:{
                    id: user_id
                }
            }))
            .then((data,textStatus,jqXHR)=>{                
                $('#user_id').val(data['id'])
                $('#role').val(data['role_id'])
                $('#edit_name').val(data['name'])
                $('#edit_email').val(data['email'])                
            })
        })
    })
</script>
<x-data-table-scripts/>
<script>
    $(function () {
        $("#userTable").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          order:[],
          ajax:{
            method:"POST",
            url: "{{ route('user.data') }}",
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
                return `<form action="{{ route("admin.user.delete") }}" method="POST" onsubmit="return confirm('Do you want to delete this patient?');"> @csrf @method("DELETE") <input type="hidden" name="id" value="${ data }"> <input type="button" id="btn_edit_user" data-toggle="modal" data-target="#modal-edit" data-user-id="${data}" class="btn bg-warning" value="Edit"> <input type="submit" class="btn bg-danger" value="Delete"> </form>`
              }
            },
          ]
        });

        setInterval(() => {            
            $("#userTable").DataTable().ajax.reload();
        }, 3000);
      });    
</script>
@endpush