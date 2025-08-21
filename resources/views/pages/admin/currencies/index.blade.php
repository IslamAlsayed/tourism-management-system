@extends('pages.admin.layouts.index')

@php
    $title = 'Currencies';
    $subtitle = 'Manage system currencies';
@endphp

@section('table-content')
    <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th>Name</th>
            <th>Code</th>
            <th>Symbol</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($currencies as $currency)
            <tr>
                <td>{{ $currency->name }}</td>
                <td>{{ $currency->code }}</td>
                <td>{{ $currency->symbol }}</td>
                <td>
                    <a href="{{ route('admin.currencies.edit', $currency->id) }}" class="kt-btn kt-btn-sm kt-btn-primary">Edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
@endsection
