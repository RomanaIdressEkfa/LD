@extends('layouts.admin')
@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card-custom p-4">
            <h2 class="fw-bold mb-1">{{ $totalDebates }}</h2>
            <div class="text-muted small">TOTAL DEBATES</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4">
            <h2 class="fw-bold text-success mb-1">{{ $totalUsers }}</h2>
            <div class="text-muted small">TOTAL USERS</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4">
            <h2 class="fw-bold text-primary mb-1">{{ $proArgs }}</h2>
            <div class="text-muted small">PRO ARGUMENTS</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4">
            <h2 class="fw-bold text-danger mb-1">{{ $conArgs }}</h2>
            <div class="text-muted small">CON ARGUMENTS</div>
        </div>
    </div>
</div>
@endsection