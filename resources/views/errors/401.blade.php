@extends('layouts.app')

@section('content')

@extends('errors::minimal')

	@section('title', __('Unauthorized'))
	@section('code', '401')
	@section('message', __('Unauthorized'))

@endsection
