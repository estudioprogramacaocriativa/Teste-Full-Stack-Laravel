@extends('layouts.app')
@section('title', 'Editando o post ' . $post->title)
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('post.index') }}"> Posts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editando o post <b>{{ $post->title }}</b></li>
            </ol>
        </nav>
        <section>
            <header class="app-header">
                <h1>Editando o post <b>{{ $post->title }}</b></h1>
                <p>As alterações refletem os resultados do site</p>
            </header>

            <form action="{{ route('post.update', $post->id) }}" class="j-submit" id="form-edit-post" method="post">
                @include('posts.partials.form')
                <div class="form-btn-actions d-flex align-items-center justify-content-between">
                    <a href="{{ route('post.index') }}">Voltar para lista</a>
                    <button type="submit" class="btn btn-outline-info">Atualizar post</button>
                </div>
            </form>
        </section>
    </div>
@endsection
