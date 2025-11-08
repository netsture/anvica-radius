<!-- resources/views/advertisements/edit.blade.php -->
@extends('layouts.app')
@section('title','Edit Advertisement')
@section('content')
<h3 class="mb-3">Edit Advertisement</h3>
<form action="{{ route('advertisements.update',$ad) }}" method="post" enctype="multipart/form-data">
  @csrf @method('PUT')
  @include('advertisements._form', ['ad'=>$ad])
  <button class="btn btn-primary">Update</button>
  <a href="{{ route('advertisements.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
