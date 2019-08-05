@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('post.index') }}"> Posts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Adicionando novo post</li>
            </ol>
        </nav>
        <section>
            <header class="app-header">
                <h1>Adicionando um novo post</h1>
                <p>Adicione um novo post ao blog do site</p>
            </header>

            <form action="{{ url('posts/store') }}" method="post">
                {{ csrf_field() }}
                @include('posts.partials.form')
                <div class="form-btn-actions d-flex align-items-center justify-content-between">
                    <a href="{{ route('post.index') }}">Voltar para lista</a>
                    <button type="submit" class="btn btn-outline-info float-right">Inserir post</button>
                </div>
            </form>
        </section>
    </div>
@endsection
