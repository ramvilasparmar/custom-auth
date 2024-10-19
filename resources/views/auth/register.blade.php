@extends('layouts.app')

@section('title', 'Register Page')

@section('content')

<form class="form" action="{{ route('register') }}" method="post" enctype="multipart/form-data">
    <h2>Register</h2>
    @csrf
    <div class="form-group">
        <input type="text" name="name" id="name" placeholder="Name">
        @error('name')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <input type="email" name="email" id="email" placeholder="Email">
        @error('email')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <input type="tel" name="phone" id="phone" placeholder="Phone">
        @error('phone')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <input type="password" name="password" id="password" placeholder="Password">
        @error('password')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="image">Image:</label>
        <div class="col-sm-10">
            <input type="file" class="form-control" id="image"  name="image" >
        </div>
    </div>
    <div class="form-group">
        <button type="submit">Register</button>
    </div>
    <div class="form-group">
        <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
    </div>
</form>
    
@endsection