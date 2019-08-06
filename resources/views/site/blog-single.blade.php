@extends('layouts.site')
@section('title', $post->title)
@section('content')
    <single-post :post="{{ $post }}" :recent="{{ $recent }}" style="margin-top: 140px;"></single-post>
@endsection
