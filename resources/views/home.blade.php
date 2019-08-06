@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
    <section>
        <article>
            <header class="app-header">
                <h4>Olá, <b>{{ auth()->user()->name }}</b>!</h4>
                <p>Bem-vindo ao painel administrativo da <b>{{ config('app.name') }}</b></p>
            </header>
        </article>
    </section>
    <section class="mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <header class="card-header">
                        <h4>Posts publicados</h4>
                    </header>
                    <div class="card-body">
                        <p>A <b>{{ config('app.name') }}</b> possui <b>{{ $published }}</b> post{{ $published > 1 ? 's' : '' }} publicado{{ $published > 1 ? 's' : '' }}</p>
                        <p><a class="mt-3 btn-outline-info btn d-block d-lg-inline-block d-md-inline-block" href="{{ route('post.index') }}">Ver publicações</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <header class="card-header">
                        <h4>Posts não publicados</h4>
                    </header>
                    <div class="card-body">
                        <p>A <b>{{ config('app.name') }}</b> possui <b>{{ $draft }}</b> post{{ $draft > 1 ? 's' : '' }} não publicado{{ $draft > 1 ? 's' : '' }}</p>
                        <p><a class="mt-3 btn-outline-info btn d-block d-lg-inline-block d-md-inline-block" href="{{ route('post.index') }}">Ver publicações</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <p class="mt-5 w-100 text-center"><a class="btn btn-success d-block d-lg-inline d-md-inline" href="{{ url('/') }}" target="_blank">Ir para o site</a></p>
</div>
@endsection
