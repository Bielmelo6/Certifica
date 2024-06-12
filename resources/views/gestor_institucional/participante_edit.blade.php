@extends('layouts.app')

@section('title')
    Editar Participante
@endsection

@section('css')
    <link rel="stylesheet" href="/css/acoes/create.css">
    <link rel="stylesheet" href="/css/cadastros/cadastrarAcao.css">
@endsection

@section('content')
    <section class="view-create-acao">
        <h1 class="text-center mb-4">Atividade / função: {{ $atividade->descricao }}</h1>
        <h2 class="text-center mb-4">Editar participante</h2>

        <form class="container form form-box" action="{{ Route('participante.update') }}" method="POST"
              enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="atividade_id" value="{{ $atividade->id }}">
            <input type="hidden" name="id" value="{{ $participante->id }}">

            <div class="row box">

                <div
                    class="col-xl-7 campo spacing-row1 input-create-box d-flex align-items-start justify-content-start flex-column">
                    <span class="tittle-input ">Nome</span>
                    <input class="w-100 h-100 input-text " type="text" name="nome" id=""
                           value="{{ $participante->user->name }}">
                </div>

                @if ($participante->user->cpf)
                    <div
                        class="col-xl-4 campo spacing-row1 input-create-box d-flex align-items-start justify-content-start flex-column">
                        <span class="tittle-input">CPF</span>
                        <input class="w-100 h-100 input-text " type="text" name="cpf" id=""
                               placeholder="000.000.000-00" value="{{ $participante->user->cpf }}">
                    </div>
                @else
                    <div
                        class="col-xl-4 campo spacing-row1 input-create-box d-flex align-items-start justify-content-start flex-column">
                        <span class="tittle-input">Passaporte</span>
                        <input class="w-100 h-100 input-text " type="text" name="passaporte" id="passaporte"
                               value="{{ $participante->user->passaporte }}">
                    </div>
                @endif

            </div>

            <div class="row box">
                <div
                    class="col-xl-7 campo spacing-row1 input-create-box d-flex align-items-start justify-content-start flex-column">
                    <span class="tittle-input ">E-mail</span>
                    <input class="w-100 h-100 input-text " type="email" name="email" id=""
                           placeholder="example@gmail.com" value="{{ $participante->user->email }}">
                </div>

                <div
                    class="col-xl-4 campo spacing-row1 input-create-box d-flex align-items-start justify-content-start flex-column">
                    <span class="tittle-input ">Carga Horária Total</span>
                    <input class="w-100 h-100 input-text " type="text" name="carga_horaria" id=""
                           value="{{ $participante->carga_horaria }}" pattern="[0-9]+" title="Digite um número válido"
                           required>
                </div>

            </div>

            <div class="row box">
                <div class="col d-flex justify-content-evenly align-items-center input-create-box border-0">
                    <a class="button d-flex justify-content-center align-items-center cancel"
                       href="{{ Route('participante.index', ['atividade_id' => $atividade->id]) }}">Voltar</a>
                    <button class="button submit" type="submit">Salvar</button>
                </div>
            </div>
        </form>
    </section>
@endsection
