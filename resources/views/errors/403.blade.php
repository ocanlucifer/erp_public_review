@extends('layouts.app')

@section('content')

	@extends('errors::minimal')

	@section('title', __('Forbidden'))
	@section('code', '403')

	@section('message', __($exception->getMessage() ?: 'Forbidden'))

@endsection
