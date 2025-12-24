@extends('layouts.admin')

@section('title', 'Invoice')
@section('breadcrumb', 'Invoice')
@section('page-title', 'Facture')

@section('content')
<div class="container-fluid mt-6">
@php
$primaryPath = '/tmp/invoice_extracted.txt';
$fallbackPath = storage_path('app/invoice_extracted.txt');
$source = file_exists($primaryPath) ? $primaryPath : (file_exists($fallbackPath) ? $fallbackPath : null);
$raw = $source ? @file_get_contents($source) : '';
echo str_replace([
    '{{ route("account.") }}settings.html',
    '{{ route("account.") }}invoice.html',
    '{{ route("account.") }}security.html'
], [
    route('account.settings'),
    route('account.invoice'),
    route('account.security')
], $raw);
@endphp
</div>
@endsection

