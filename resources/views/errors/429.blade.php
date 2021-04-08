@extends('layouts.app')

@section('content')

	@extends('errors::minimal')

	@section('title', __('Too Many Requests'))
	@section('code', '429')
	@section('message', __('Too Many Requests'))

@endsection
