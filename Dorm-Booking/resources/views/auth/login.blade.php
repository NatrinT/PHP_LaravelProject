@extends('layouts.frontend')

@section('contenthome')
    @include('home.homepage')
@endsection

@section('contentBody')
    @include('home.mainpage')
    @include('auth.modal-login')
@endsection

