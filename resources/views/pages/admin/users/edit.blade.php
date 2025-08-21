@extends('pages.admin.layouts.edit')

@php
    $title = 'Edit User';
    $subtitle = 'Update user information';
    $backUrl = route('admin.users.index');
    $formAction = route('admin.users.update', $user->id);
@endphp

@section('form-content')
    <div class="row mb-5">
        <div class="col-6">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>
        <div class="col-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>
    </div>
@endsection
