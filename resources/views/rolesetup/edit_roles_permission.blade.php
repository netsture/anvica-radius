@extends('layouts.app')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<style>
.form-check-label {
    text-transform: capitalize;
}
</style>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Edit Roles in Permission </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Roles in Permission</li>
                </ol>
            </nav>
        </div>

    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <form class="row g-3" action="{{ route('admin.roles.update', $role->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="col-md-6">
                                    <label for="input1" class="form-label">Roles Name </label>
                                    <h3>{{ $role->name }}</h3>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="CheckDefaultmain">
                                    <label class="form-check-label" for="CheckDefaultmain">Permission All </label>
                                </div>
                                <hr>
                                @foreach ($permission_groups as $group)
                                <div class="row">
                                    <div class="col-3">
                                        @php
                                        $permissions = App\Models\User::getpermissionByGroupName($group->group_name)
                                        @endphp
                                        <div class="form-check">
                                            <input class="form-check-input group-checkbox" type="checkbox" id="group_{{ $loop->index }}"
                                                data-group="group_{{ $loop->index }}" {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="group_{{ $loop->index }}">{{ $group->group_name }}</label>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input permission-checkbox group_{{ $loop->parent->index }}" type="checkbox" 
                                                name="permission[]" id="CheckDefault{{ $permission->id }}" value="{{ $permission->name }}"
                                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="CheckDefault{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                        @endforeach
                                        <br>
                                    </div>
                                </div>
                                @endforeach
                                {{-- // end row --}}
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">Save Changes </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    // Select/Deselect All
    $('#CheckDefaultmain').on('change', function() {
        $('.form-check-input').prop('checked', this.checked);
    });

    // Select/Deselect Group Checkboxes
    $('.group-checkbox').on('change', function() {
        let groupClass = $(this).data('group');
        $('.' + groupClass).prop('checked', this.checked);
    });

    // If a permission checkbox is unchecked, uncheck group and main checkboxes
    $('.permission-checkbox').on('change', function() {
        let groupClass = $(this).attr('class').split(' ').pop(); 
        let groupCheckbox = $('[data-group="' + groupClass + '"]');

        if (!$(this).is(':checked')) {
            groupCheckbox.prop('checked', false);
            $('#CheckDefaultmain').prop('checked', false);
        }

        // If all checkboxes in a group are checked, check the group checkbox
        if ($('.' + groupClass + ':checked').length === $('.' + groupClass).length) {
            groupCheckbox.prop('checked', true);
        }

        // If all permissions are selected, check the main checkbox
        if ($('.permission-checkbox:checked').length === $('.permission-checkbox').length) {
            $('#CheckDefaultmain').prop('checked', true);
        }
    });
});
</script>

@endsection