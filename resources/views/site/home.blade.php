@extends('layouts.site')
@section('title', 'Home')
@section('content')
    <posts :recent="{{ $recent }}" style="margin-top: 140px;"></posts>
 @endsection
