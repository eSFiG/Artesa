@extends('templates.base')

@section('title')
    {{ 'Main' }}
@endsection

@section('content')
    <div class="d-flex flex-row-reverse p-3 me-4">
        <a class="btn btn-primary btn-sm" href="{{ route('logout') }}">Logout</a>
    </div>
    <div class="d-flex flex-column align-items-center">
        <p>Welcome {{ $user['username'] }}!</p>
    </div>
@endsection
