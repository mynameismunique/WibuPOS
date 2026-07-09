@extends('layouts.app')

@section('title', 'Offline - Wibu-POS')

@section('content')
<div class="text-center py-5">
    <div style="font-size: 5rem; margin-bottom: 1rem;">📡</div>
    <h2 class="text-muted">Anda Sedang Offline</h2>
    <p class="text-muted">Periksa koneksi internet Anda dan coba lagi.</p>
    <button onclick="location.reload()" class="btn btn-wibu-primary mt-3">
        <i class="bi bi-arrow-clockwise"></i> Refresh
    </button>
</div>
@endsection