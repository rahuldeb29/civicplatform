@extends('layouts.admin')

@section('title', 'Edit Department')

@section('content')

<style>
    .page-container{
        padding:2rem;
    }

    .page-header{
        margin-bottom:2rem;
    }

    .page-header h1{
        font-size:28px;
        font-weight:700;
        color:#111827;
        margin-bottom:6px;
    }

    .page-header p{
        color:#6B7280;
    }

    .form-card{
        background:white;
        border-radius:16px;
        padding:2rem;
        box-shadow:0 2px 12px rgba(0,0,0,.08);
        max-width:900px;
    }

    .form-group{
        margin-bottom:1.5rem;
    }

    .form-label{
        display:block;
        font-weight:600;
        margin-bottom:.5rem;
        color:#374151;
    }

    .form-control{
        width:100%;
        padding:.9rem 1rem;
        border:1px solid #D1D5DB;
        border-radius:10px;
    }

    .form-control:focus{
        outline:none;
        border-color:#2563EB;
    }

    textarea.form-control{
        min-height:120px;
        resize:vertical;
    }

    .btn-row{
        display:flex;
        gap:12px;
        margin-top:2rem;
    }

    .btn-save{
        background:#2563EB;
        color:white;
        border:none;
        padding:12px 20px;
        border-radius:10px;
        cursor:pointer;
        font-weight:600;
    }

    .btn-cancel{
        background:#F3F4F6;
        color:#374151;
        text-decoration:none;
        padding:12px 20px;
        border-radius:10px;
        font-weight:600;
    }

    .error{
        color:#DC2626;
        font-size:.85rem;
        margin-top:4px;
    }
</style>

<div class="page-container">

    <div class="page-header">
        <h1>Edit Department</h1>
        <p>Update department information and contact details.</p>
    </div>

    <div class="form-card">

        <form action="{{ route('admin.departments.update', $department) }}"
      method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Department Name</label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $department->name) }}"
                >

                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Department Code</label>

                <input
                    type="text"
                    name="code"
                    class="form-control"
                    value="{{ old('code', $department->code) }}"
                >

                @error('code')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Head Officer</label>

                <input
                    type="text"
                    name="head_officer"
                    class="form-control"
                    value="{{ old('head_officer', $department->head_officer) }}"
                >

                @error('head_officer')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $department->email) }}"
                >

                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>

                <input
                    type="text"
                    name="phone"
                    class="form-control"
                    value="{{ old('phone', $department->phone) }}"
                >

                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>

                <textarea
                    name="description"
                    class="form-control"
                >{{ old('description', $department->description) }}</textarea>

                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="btn-row">

                <button type="submit" class="btn-save">
                    Update Department
                </button>

                <a href="{{ route('admin.departments.index') }}"
                   class="btn-cancel">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection