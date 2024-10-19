@extends('layouts.layout')
@section('title', 'Profile Page')
@section('content')
<h2>Profile</h2>
<form class="profile-form" method="post" action="{{ route('profile') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Name:</label>
        {{-- <input type="hidden" id="id" name="id" value="{{ auth()->user()->id }}"> --}}
        <input type="text" id="name" name="name" value="{{ auth()->user()->name }}">
        @error('name')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" disabled>
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone }}">
        @error('phone')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="image">Image:</label>
        <div class="col-sm-10">
            <input type="file" class="form-control" id="image"  name="image" >

            @if (auth()->user()->image != "")
            <img class="w-50 my-3" src="{{ asset('uploads/gallery/'.auth()->user()->image) }}">
            @endif
        </div>
    </div>
    <div class="form-group">
        <button type="submit">Save Changes</button>
    </div>
</form>
@endsection