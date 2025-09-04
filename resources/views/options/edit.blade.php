@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Edit Options</h4>
        </div>            
    </div>

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('options.update', $option->id) }}" method="POST" id="myForm" class="forms-sample">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $option->category) }}" readonly>
                            @error('category')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Key</label>
                            <input type="text" name="key" class="form-control @error('key') is-invalid @enderror" value="{{ old('key', $option->key) }}">
                            @error('key')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Value</label>
                            <input type="text" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value', $option->value) }}">
                            @error('value')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                @foreach(getOptions('status') as $key => $value)
                                    <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('options.index') }}'">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#categoryInput').on('keyup', function() {
        let query = $(this).val();

        if (query.length > 1) {
            $.ajax({
                url: "{{ route('categories.search') }}",
                type: "GET",
                data: { query: query },
                success: function(data) {
                    let dropdown = $('#categorySuggestions');
                    dropdown.empty().show();
                    
                    if (data.length > 0) {
                        $.each(data, function(index, value) {
                            dropdown.append('<div class="dropdown-item category-item">' + value + '</div>');
                        });
                    } else {
                        dropdown.append('<div class="dropdown-item text-muted">No results found</div>');
                    }
                }
            });
        } else {
            $('#categorySuggestions').hide();
        }
    });

    // Handle category selection
    $(document).on('click', '.category-item', function() {
        $('#categoryInput').val($(this).text());
        $('#categorySuggestions').hide();
    });

    // Hide dropdown when clicking outside
    $(document).on('click', function(event) {
        if (!$(event.target).closest('#categoryInput, #categorySuggestions').length) {
            $('#categorySuggestions').hide();
        }
    });
});
</script>
@endsection
