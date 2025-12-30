@extends('merlion::layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h1>Merlion Admin Dashboard</h1>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users Management</h3>
                </div>
                <div class="card-body">
                    <p>Manage application users</p>
                    <a href="{{ url('/admin/users') }}" class="btn btn-primary">Manage Users</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Roles Management</h3>
                </div>
                <div class="card-body">
                    <p>Manage user roles and permissions</p>
                    <a href="{{ url('/admin/roles') }}" class="btn btn-primary">Manage Roles</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permissions Management</h3>
                </div>
                <div class="card-body">
                    <p>Manage system permissions</p>
                    <a href="{{ url('/admin/permissions') }}" class="btn btn-primary">Manage Permissions</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection