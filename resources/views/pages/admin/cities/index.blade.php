@extends('pages.admin.layouts.index')

@php
    $title = 'Cities';
    $subtitle = 'Manage system cities';
@endphp

@section('table-content')
    <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th>Name</th>
            <th>Country</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cities as $city)
            <tr>
                <td>{{ $city->name }}</td>
                <td>{{ $city->country->name }}</td>
                <td>
                    <a href="{{ route('admin.cities.edit', $city->id) }}" class="kt-btn kt-btn-sm kt-btn-primary">Edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
@endsection
