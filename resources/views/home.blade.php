@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
   <section>
       <header class="app-header">
           <h1>Mais que uma agência!</h1>
           <p>Nosso negócio é apoiar o seu negócio a atingir os objetivos e metas através de ações digitais.</p>
       </header>
       <div class="row d-flex align-items-center justify-content-center p-0 p-md-5 p-lg-5">
           <div class="col-md-6">
               <img src="{{ asset('images/RockSite.png') }}" alt="">
           </div>
           <div class="col-md-6">
               <article>
                    <header>
                        <h2>Criação de sites, webapps e apps mobile</h2>
                        <p>Traga seu projeto para a Rockbuzz e conheça nossa qualidade!</p>
                    </header>
                    <div class="text">
                       <p>Ofereça aos seus leads e clientes ambientes digitais integrados e otimizados para potencializar a experiência digital e de compra. Transforme seu site em uma máquina de geração de leads e de vendas.</p>
                    </div>
               </article>
           </div>
       </div>
   </section>
</div>
@endsection
