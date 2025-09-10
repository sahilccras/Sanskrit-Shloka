@extends('layouts.app')

@section('title', 'Approver Dashboard')

@section('content')
<h1 class="mb-4">Approver Dashboard</h1>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-warning">
            <div class="card-body">
                <h5 class="card-title">Pending Fixed Entries</h5>
                <p class="card-text">Review and approve fixed shloka data entries.</p>
                <a href="{{ route('approver.fixed-entries.pending') }}" class="btn btn-warning btn-sm">Review</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body">
                <h5 class="card-title">Pending Variable Entries</h5>
                <p class="card-text">Review and approve Q&A/context entries.</p>
                <a href="{{ route('approver.variable-entries.pending') }}" class="btn btn-danger btn-sm">Review</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-info">
            <div class="card-body">
                <h5 class="card-title">Export Data</h5>
                <p class="card-text">Export all approved data as JSON.</p>
                <a href="{{ route('export.index') }}" class="btn btn-light btn-sm">Go</a>
            </div>
        </div>
    </div>
</div>
@endsection
