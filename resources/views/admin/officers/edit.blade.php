@extends('layouts.admin')

@section('title', 'Edit Officer')

@section('content')

    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
        }

        .page-header p {
            color: #6B7280;
            margin-top: 4px;
        }

        .form-card {
            background: white;
            border: 1px solid #E5E7EB;
            border-radius: 18px;
            padding: 30px;
            max-width: 900px;
            margin: auto;
        }

        .profile-section {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 1px solid #E5E7EB;
        }

        .profile-img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #E5E7EB;
        }

        .avatar {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: #2563EB;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 42px;
            font-weight: bold;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
        }

        .form-control {
            padding: 12px 15px;
            border: 1px solid #D1D5DB;
            border-radius: 10px;
            font-size: 15px;
        }

        .form-control:focus {
            outline: none;
            border-color: #2563EB;
        }

        .full-width {
            grid-column: 1/-1;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 22px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
        }

        .btn-save {
            background: #2563EB;
            color: white;
        }

        .btn-cancel {
            background: #F3F4F6;
            color: #111827;
        }
    </style>

    <div class="page-header">

        <div>

            <h1>Edit Officer</h1>

            <p>Update officer information.</p>

        </div>

    </div>

    <div class="form-card">

        <form action="{{ route('admin.officers.update', $officer->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="profile-section">

                @if($officer->profile_image)

                    <img src="{{ asset('storage/' . $officer->profile_image) }}" class="profile-img">

                @else

                    <div class="avatar">

                        {{ strtoupper(substr($officer->name, 0, 1)) }}

                    </div>

                @endif

                <div>

                    <label style="font-weight:600;margin-bottom:10px;display:block;">
                        Profile Picture
                    </label>

                    <input type="file" name="profile_image" class="form-control">

                    <small style="color:#6B7280;">
                        Leave empty to keep existing photo.
                    </small>

                </div>

            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label>Name</label>

                    <input type="text" name="name" class="form-control" value="{{ old('name', $officer->name) }}">

                </div>

                <div class="form-group">

                    <label>Email</label>

                    <input type="email" name="email" class="form-control" value="{{ old('email', $officer->email) }}">

                </div>

                <div class="form-group">

                    <label>Phone</label>

                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $officer->phone) }}">

                </div>

                <div class="form-group">

                    <label>Designation</label>

                    <input type="text" name="designation" class="form-control"
                        value="{{ old('designation', $officer->designation) }}">

                </div>

                <div class="form-group">

                    <label>Department</label>

                    <select name="department_id" class="form-control">

                        @foreach($departments as $department)

                            <option value="{{ $department->id }}" {{ $officer->department_id == $department->id ? 'selected' : '' }}>

                                {{ $department->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="form-group">

                    <label>Role</label>

                    <select name="role" class="form-control">

                        <option value="officer" {{ $officer->role == 'officer' ? 'selected' : '' }}>
                            Officer
                        </option>

                        <option value="department_head" {{ $officer->role == 'department_head' ? 'selected' : '' }}>
                            Department Head
                        </option>

                        <option value="admin" {{ $officer->role == 'admin' ? 'selected' : '' }}>
                            Administrator
                        </option>

                        <option value="super_admin" {{ $officer->role == 'super_admin' ? 'selected' : '' }}>
                            Super Admin
                        </option>

                    </select>

                </div>

                <div class="form-group full-width">

                    <label>Status</label>

                    <select name="status" class="form-control">

                        <option value="active" {{ $officer->status == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="suspended" {{ $officer->status == 'suspended' ? 'selected' : '' }}>
                            Suspended
                        </option>

                    </select>

                </div>

            </div>

            <div class="actions">

                <a href="{{ route('admin.officers.index') }}" class="btn btn-cancel">

                    Cancel

                </a>

                <button type="submit" class="btn btn-save">

                    Save Changes

                </button>

            </div>

        </form>

    </div>

@endsection