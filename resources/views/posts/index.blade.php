@extends('layouts.app')
@section('title', 'Publicações para o blog')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"> Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Posts</li>
            </ol>
        </nav>
        <section>
            <header class="app-header">
                <h1>Posts</h1>
                <p>Publicações do blog</p>
            </header>
            <div class="app-options d-flex justify-content-between align-items-center">
                <div class="filters d-flex align-items-center">
                    <p><i class="fas fa-filter"></i> Filtrar por:</p>
                    <nav>
                        <ul class="d-flex align-items-center">
                            <li data-filter="all" class="active">Todos</li>
                            <li data-filter="published">Publicados</li>
                            <li data-filter="draft">Rascunho</li>
                        </ul>
                    </nav>
                </div>
                <div class="group d-flex justify-content-between align-items-center">
                    <a class="btn btn-outline-info mr-4" href="{{ url('posts/create') }}">Adicionar post</a>
                    <form class="form-search">
                        <input type="search" class="form-control" name="search" placeholder="Digite algo...">
                    </form>
                </div>
            </div>
            <div class="loading">
                <div class="content">
                    <img src="{{ asset('images/loading.gif') }}" alt="">
                </div>
            </div>
            <div class="hide-when-loading">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Situação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody class="reload-data">
                            @include('posts.partials.table-body')
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
