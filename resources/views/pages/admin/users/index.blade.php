@extends('pages.admin.layouts.index')

@php
    $title = 'Users';
    $subtitle = 'Manage system users';
@endphp

@section('table-content')
    <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="kt-btn kt-btn-sm kt-btn-primary">Edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
@endsection
