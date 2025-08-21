@extends('pages.admin.layouts.index')

@php
    $title = 'Countries';
    $subtitle = 'Manage system countries';
@endphp

@section('table-content')
    <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th>Name</th>
            <th>Code</th>
            <th>Cities Count</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($countries as $country)
            <tr>
                <td>{{ $country->name }}</td>
                <td>{{ $country->code }}</td>
                <td>{{ $country->cities_count }}</td>
                <td>
                    <a href="{{ route('admin.countries.edit', $country->id) }}" class="kt-btn kt-btn-sm kt-btn-primary">Edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
@endsection
