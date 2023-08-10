<!--View apresentada em gestor -->

@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/acoes/create.css">
    <link rel="stylesheet" href="/css/modelo_certificado/modelo_certificado.css">
    <link rel="stylesheet" href="/css/cadastros/cadastrarAcao.css">
    <link rel="stylesheet" href="/css/modelo_certificado/modal-legendas.css">
@endsection

@section('content')
    <div class="row">

        <div class="container container-form-modelo">
            <h2 class="text-center">Atualizar modelo de certificado</h2>
            <!--icone p ativar o modal -->


            <p class="d-flex align-items-center justify-content-center">

                <span class="all-text">
                    Clique
                    <a class="link-modal" data-bs-toggle="modal" data-bs-target="#modal-Legenda">aqui</a>
                    para visualizar as variáveis
                </span>

                <a data-bs-toggle="modal" data-bs-target="#modal-Legenda">
                    <img class="lamp-legendas-icon" src="/images/modal-legenda/lamp.svg" alt="variaveis">
                </a>

            </p>

            <form action="{{ Route('certificado_modelo.update', ['id' => $modelo->id]) }}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="form-box-modelo-certificado form-row">
                    <input type="hidden" name="unidade_administrativa_id" value="{{ $modelo->unidade_administrativa_id }}">

                    <div class="row box col-xl-7">
                        <div class="campo input-create-box d-flex aligm-items-start justify-content-start flex-column">
                            <span class="tittle-input">Descrição</span>
                            <input class="w-100 h-100 input-text" name="descricao" type="text"
                                placeholder="Nome do modelo" value="{{ $modelo->descricao }}">
                        </div>
                    </div>


                    <div class="row box col-xl-7">
                        <div class="campo input-create-box d-flex aligm-items-start justify-content-start flex-column">
                            <span class="tittle-input">Unidade Administrativa</span>
                            <input class="w-75 input-text " type="text"
                                value="{{ $modelo->unidadeAdministrativa->descricao }}" disabled>
                        </div>
                    </div>

                    <div class="row box col-xl-7">
                        <div
                            class="campo spacing-row2 input-create-box d-flex align-items-start justify-content-start flex-column">
                            <span class="tittle-input">Tipo Certificado</span>
                            <select class="select-form w-100 " name="tipo_certificado" id="select_tipo_certificado"
                                required>
                                <option value="{{ $modelo->tipo_certificado }}"> {{ $modelo->tipo_certificado }}</option>
                                @foreach ($tipos_certificado as $tipo)
                                    <option value="{{ $tipo }}">{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row box col-xl-7" id="outro_tipo_certificado" style="display: none;">
                        <div class="campo input-create-box d-flex aligm-items-start justify-content-start flex-column">
                            <span class="tittle-input">Tipo Certificado (outro)</span>
                            <input class="w-75 input-text" type="text" name="outro">
                        </div>
                    </div>


                    <div class="row box d-flex flex-column col-xl-7">
                        <span class="tittle-input w-100">Texto padrão:</span>

                        <textarea name="texto" class="w-100 campo input-create-box text-area-campo" id="texto">
                            {{ $modelo->texto }}
                        </textarea>
                    </div>


                    <div class="row d-flex align-items-center justify-content-around">

                        <div class="col text-center">
                            <input hidden type="file" name="verso" id="plano_verso" accept="image/*"
                                value={{ $modelo->verso }}>

                            <label class="label" for="plano_verso">
                                <span>Verso</span>
                                <div id="card_verso" class="card-preview-create">

                                    <img id="img_verso" src="{{ $verso }}" alt="" width="100%"
                                        height="100%">
                                    <img id="img_verso_new" src="" alt="" width="100%" height="100%">
                                </div>
                            </label>
                        </div>

                        <div class="col text-center">
                            <input hidden type="file" name="fundo" id="plano_fundo" accept="image/*"
                                value={{ $modelo->fundo }}>

                            <label class="label" for="plano_fundo">
                                <span>Plano de fundo</span>

                                <div id="card_fundo" class="card-preview-create">
                                    <img id="img_fundo" src="{{ $fundo }}" alt="" width="100%"
                                        height="100%">
                                    <img id="img_fundo_new" src="" alt="" width="100%" height="100%">
                                </div>

                            </label>
                        </div>

                    </div>


                    <div class="row d-flex justify-content-start align-items-center mt-4 col-xl-7">

                        <div class="col d-flex justify-content-evenly align-items-center input-create-box border-0">
                            <a class="button d-flex justify-content-center align-items-center cancel"
                                href="{{ route('certificado_modelo.index') }}">Voltar</a>

                            <button class="button submit" type="submit">Salvar</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        <!--modal legendas -->
        @include('components.modal-Legenda')
    </div>

    <script>
        //Preview fundo
        var imgFundo = document.getElementById('img_fundo');
        var imgFundoNew = document.getElementById('img_fundo_new');
        var planoFundo = document.getElementById('plano_fundo');


        imgFundoNew.style.display = "none"

        planoFundo.addEventListener('change', (e) => {

            imgFundo.style.display = "none"
            imgFundoNew.style.display = ""

            imgFundoNew.src = URL.createObjectURL(e.target.files[0])
        })

        //Preview verso

        var imgVerso = document.getElementById('img_verso');
        var imgVersoNew = document.getElementById('img_verso_new');
        var planoVerso = document.getElementById('plano_verso');

        imgVersoNew.style.display = "none"

        planoVerso.addEventListener('change', (e) => {
            imgVerso.style.display = "none"
            imgVersoNew.style.display = ""

            imgVersoNew.src = URL.createObjectURL(e.target.files[0])
        })
    </script>

    <script>
        const select_tipo_certificado = document.getElementById("select_tipo_certificado");
        const outro_tipo_certificado = document.getElementById("outro_tipo_certificado");

        select_tipo_certificado.addEventListener("change", function() {
            if (select_tipo_certificado.value === "Outro") {
                outro_tipo_certificado.style.display = "block";
            } else {
                outro_tipo_certificado.style.display = "none";
            }
        });
    </script>


    <script>
        // correcao text area
        var textarea = document.getElementById("texto")
        textarea.innerHTML = textarea.innerHTML.trim()
    </script>
@endsection
