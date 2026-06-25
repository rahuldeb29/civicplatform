@extends('layouts.admin')

@section('title', 'Create Department')

@section('content')

<style>
    .page-container {
        padding: 2rem;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.4rem;
    }

    .page-header p {
        color: #6B7280;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        max-width: 800px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: .5rem;
    }

    .form-control {
        width: 100%;
        padding: .85rem 1rem;
        border: 1px solid #D1D5DB;
        border-radius: 10px;
        font-size: .95rem;
        transition: .2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #2563EB;
        box-shadow: 0 0 0 3px rgba(37,99,235,.15);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 1.5rem;
    }

    .btn-primary {
        background: #2563EB;
        color: white;
        border: none;
        padding: .85rem 1.4rem;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-primary:hover {
        background: #1D4ED8;
    }

    .btn-secondary {
        background: #F3F4F6;
        color: #374151;
        padding: .85rem 1.4rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
    }

    .btn-secondary:hover {
        background: #E5E7EB;
    }

    .error-text {
        color: #DC2626;
        font-size: .85rem;
        margin-top: .3rem;
    }
</style>

<div class="page-container">

    <div class="page-header">
        <h1>Create Department</h1>
        <p>Add a new government department to CivicPulse.</p>
    </div>

    <div class="form-card">

        <form action="{{ route('admin.departments.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Department Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    placeholder="e.g. Public Works Department">

                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Department Code</label>
                <input
                    type="text"
                    name="code"
                    class="form-control"
                    value="{{ old('code') }}"
                    placeholder="e.g. PWD">

                @error('code')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Head Officer</label>
                <input
                    type="text"
                    name="head_officer"
                    class="form-control"
                    value="{{ old('head_officer') }}"
                    placeholder="Officer Name">

                @error('head_officer')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    placeholder="department@example.com">

                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input
                    type="text"
                    name="phone"
                    class="form-control"
                    value="{{ old('phone') }}"
                    placeholder="+91 XXXXX XXXXX">

                @error('phone')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea
                    name="description"
                    class="form-control"
                    placeholder="Describe the department...">{{ old('description') }}</textarea>

                @error('description')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-primary">
                    Create Department
                </button>

                <a href="{{ route('admin.departments.index') }}"
                   class="btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

@endsection