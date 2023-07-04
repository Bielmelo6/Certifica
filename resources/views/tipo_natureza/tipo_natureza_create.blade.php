@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/home/contato.css">
    <link rel="stylesheet" href="/css/acoes/create.css">
@endsection

@section('content')
    <div class='container'>
        <section class="section-view pb-3 pt-4">
            <h2 class="titulo-view mb-4">Cadastrar Tipo de Natureza</h2>

            <form action={{Route('tipo_natureza.store')}} method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row d-flex aligm-items-start justify-content-start mb-3">
                    <div class="col-md-6 input-create-box d-flex aligm-items-start justify-content-start flex-column">
                        <span class="tittle-input">Descrição <span class="ast">*</span> </span>
                        <input class="w-75 input-text" type="text" name="descricao" id="descricao" 
                            placeholder="Descrição" required>
                    </div>
                </div>
                <div class="row d-flex aligm-items-start justify-content-start mb-3">
                    <div class="col-md-6 input-create-box d-flex aligm-items-start justify-content-start flex-column">
                        <span class="tittle-input">Natureza <span class="ast">*</span> </span>

                        <select name="natureza_id" id="tipo_natureza"  class="select-form w-100 " required>
                            <option value="" selected hidden>-- Natureza --</option>
                            @foreach ($naturezas as $natureza)
                                <option value="{{ $natureza->id }}">{{ $natureza->descricao }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="">Cadastrar</button>
            </form>
        </section>
    </div>
@endsection
