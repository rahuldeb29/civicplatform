@extends('layouts.admin')

@section('title', 'Create Officer')

@section('content')

<style>

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:24px;
}

.page-header h1{
    font-size:28px;
    font-weight:700;
    color:#111827;
}

.page-header p{
    color:#6B7280;
    margin-top:4px;
}

.form-card{
    max-width:900px;
    background:#fff;
    border:1px solid #E5E7EB;
    border-radius:18px;
    padding:32px;
}

.form-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-bottom:20px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group.full{
    grid-column:1 / -1;
}

label{
    font-weight:600;
    color:#374151;
    margin-bottom:8px;
}

input,
select{
    padding:12px 14px;
    border:1px solid #D1D5DB;
    border-radius:10px;
    font-size:14px;
}

input:focus,
select:focus{
    outline:none;
    border-color:#2563EB;
}

.error{
    color:#DC2626;
    font-size:13px;
    margin-top:5px;
}

.btn-group{
    margin-top:30px;
    display:flex;
    gap:12px;
}

.btn-primary{
    background:#2563EB;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
}

.btn-secondary{
    background:#F3F4F6;
    color:#111827;
    text-decoration:none;
    padding:12px 20px;
    border-radius:10px;
    font-weight:600;
}

.profile-upload{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:15px;
}

.profile-preview{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #E5E7EB;
    background:#F3F4F6;
}

.upload-btn{
    background:#2563EB;
    color:#fff;
    border:none;
    padding:10px 20px;
    border-radius:8px;
    cursor:pointer;
    font-weight:600;
}

.upload-btn:hover{
    background:#1D4ED8;
}

</style>

<div class="page-header">

    <div>
        <h1>Create Officer</h1>
        <p>Add a new department officer or administrator.</p>
    </div>

</div>

<div class="form-card">

<form action="{{ route('admin.officers.store') }}" method="POST" enctype="multipart/form-data">

    @csrf
    <div class="form-row">

    <div class="form-group full">

        <label>Profile Picture</label>

        <div class="profile-upload">

            <img
                src="https://placehold.co/140x140?text=Photo"
                id="previewImage"
                class="profile-preview"
            >

            <input
                type="file"
                name="profile_image"
                id="profile_image"
                accept="image/*"
                hidden
            >

            <button
                type="button"
                class="upload-btn"
                onclick="document.getElementById('profile_image').click()"
            >
                Upload Photo
            </button>

        </div>

        @error('profile_image')
            <div class="error">{{ $message }}</div>
        @enderror

    </div>

</div>

    <div class="form-row">

        <div class="form-group">

            <label>Name</label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
            >

            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

        </div>

        <div class="form-group">

            <label>Email</label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
            >

            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

        </div>

    </div>

    <div class="form-row">

        <div class="form-group">

            <label>Password</label>

            <input
                type="password"
                name="password"
            >

            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

        </div>

        <div class="form-group">

            <label>Confirm Password</label>

            <input
                type="password"
                name="password_confirmation"
            >

        </div>

    </div>

    <div class="form-row">

        <div class="form-group">

            <label>Role</label>

            <select name="role">

    <option value="officer">Officer</option>

    <option value="department_head">Department Head</option>

    <option value="admin">Administrator</option>

    <option value="super_admin">Super Admin</option>

</select>

        </div>

        <div class="form-group">

            <label>Department</label>

            <select name="department_id">

                <option value="">Select Department</option>

                @foreach($departments as $department)

                    <option value="{{ $department->id }}">
                        {{ $department->name }}
                    </option>

                @endforeach

            </select>

        </div>

    </div>

    <div class="form-row">

        <div class="form-group">

            <label>Status</label>

            <select name="status">

                <option value="active">Active</option>

                <option value="suspended">Suspended</option>

            </select>

        </div>

        <div class="form-group">

            <label>Phone Number</label>

            <input
                type="text"
                name="phone"
            >

        </div>

    </div>

    <div class="form-row">

        <div class="form-group full">

            <label>Designation</label>

            <input
                type="text"
                name="designation"
                placeholder="Assistant Engineer, Executive Officer..."
            >

        </div>

    </div>

    <div class="btn-group">

        <button class="btn-primary">
            Create Officer
        </button>

        <a href="{{ route('admin.officers.index') }}"
           class="btn-secondary">
            Cancel
        </a>

    </div>

</form>

</div>


<script>

document
.getElementById('profile_image')
.addEventListener('change', function(e){

    const file = e.target.files[0];

    if(!file) return;

    const reader = new FileReader();

    reader.onload = function(event){

        document.getElementById('previewImage').src =
            event.target.result;

    };

    reader.readAsDataURL(file);

});

</script>

@endsection