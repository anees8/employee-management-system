<!-- resources/views/login.blade.php -->
@extends('layouts.app')
@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center" style="height:100vh">
<div class="col-4 card py-3">
        <h2 class="text-center">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            @error('error')
                <div class="text-danger my-1">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>
@endsection
