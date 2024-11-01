@extends('templates.base')

@section('title')
    {{ 'Login' }}
@endsection

@section('content')
<div class="d-flex flex-column align-items-center">
<form class="border rounded p-3 mt-2" action="{{ route('login') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" id="username">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password">
    </div>
    <div class="d-flex flex-column align-items-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
</div>
@endsection
