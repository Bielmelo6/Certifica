@extends('layouts.app')

@section('title')
    Atividades
@endsection

@section('css')
    <link rel="stylesheet" href="/css/acoes/list.css">
@endsection

@section('content')
    <section class="view-list-acoes">

        <div class="container">

            <h1 class="text-center mb-4">Ação institucional: {{ $acao->titulo }}</h1>

            <div class="text-center mb-3">
                <h3>Atividades / funções</h3>
            </div>


            <div class="row d-flex align-items-center justify-content-between">

                <div class="col-1">
                    <a type="button" class="button d-flex align-items-center justify-content-around between"
                        href="{{ route('acao.index') }}">
                        Voltar
                        <img src="/images/acoes/listView/voltar.svg" alt="">
                    </a>
                </div>

                <div class="col-8 text-end">
                    @if($acao->status == null || $acao->status == 'Devolvida')
                        <a class="criar-acao-button" href="{{ route('atividade.create', ['acao_id' => $acao->id]) }}">
                            <img class="iconAdd" src="/images/acoes/listView/criar.svg" alt=""> Criar atividade
                        </a>
                    @endif
                </div>
            </div>


            <div class="row head-table d-flex align-items-center justify-content-center">
                <div class="col-2"><span class="spacing-col">Atividade / Função</span></div>
                <div class="col-2"><span>Período</span></div>
                <div class="col-6"><span>Integrantes</span></div>
                <div class="col-2"><span>Funcionalidades</span></div>
            </div>
        </div>

        <div class="list container">
            @foreach ($atividades as $atividade)
                <div class="row linha-table d-flex align-items-center justify-content-center">
                    <div class="col-2"><span class="spacing-col">{{ $atividade->descricao }}</span></div>
                    <div class="col-2">
                        <span>{{ collect(explode('-', $atividade->data_inicio))->reverse()->join('/') .
                            ' - ' .
                            collect(explode('-', $atividade->data_fim))->reverse()->join('/') }}</span>
                    </div>

                    <div class="col-6 titulo-span" title="{{ $atividade->lista_nomes }}">
                        {{ $atividade->nome_participantes }}
                    </div>



                    <div class="col-2 d-flex align-items-center justify-content-start">



                        <div class="col-8 d-flex align-items-center justify-content-around">
                            @if($atividade->descricao === 'Apresentação de Trabalho')
                                <a href="{{ route('trabalho.index', ['atividade_id' => $atividade->id]) }}"
                                   title="Trabalhos">
                                    <img src="/images/acoes/listView/clipboard-check.svg" alt="">
                                </a>
                            @else
                                <a href="{{ route('participante.index', ['atividade_id' => $atividade->id]) }}"
                                   title="Integrantes">
                                    <img src="/images/atividades/participantes.svg" alt="">
                                </a>
                            @endif

                            @if ($acao->status == null || $acao->status == 'Devolvida')
                                @if(!($atividade->descricao === 'Apresentação de Trabalho'))
                                    <a href="/files/modelo.xlsx" title="Baixar Modelo">
                                        <img src="/images/acoes/listView/anexo.svg">
                                    </a>

                                    <a href="" title="Importar Integrantes" data-bs-toggle="modal"
                                        data-bs-target="#modalImportCsv{{ $atividade->id }}">
                                        <img src="/images/acoes/listView/csvIcon.svg" alt="">
                                    </a>

                                @else
                                    <a href="/files/modelo_trabalho.xlsx" title="Baixar Modelo Trabalho">
                                        <img src="/images/acoes/listView/anexo.svg">
                                    </a>

                                    <a href="" title="Importar Autores/Coautores" data-bs-toggle="modal"
                                       data-bs-target="#modalImportTrabalhoCsv{{ $atividade->id }}">
                                        <img src="/images/acoes/listView/csvIcon.svg" alt="">
                                    </a>

                                @endif

                                <a href="{{ route('atividade.edit', ['atividade_id' => $atividade->id]) }}" title="Editar">
                                    <img src="/images/acoes/listView/editar.svg" alt="">
                                </a>

                                <a onclick="return confirm('Você tem certeza que deseja remover a atividade?')"
                                    href="{{ route('atividade.delete', ['atividade_id' => $atividade->id]) }}" title="Excluir">
                                    <img src="/images/acoes/listView/lixoIcon.svg" alt="">
                                </a>
                            @elseif(Auth::user()->perfil_id == 3)
                                <a href="{{ route('atividade.edit', ['atividade_id' => $atividade->id]) }}" title="Editar">
                                    <img src="/images/acoes/listView/editar.svg" alt="">
                                </a>
                            @endif

                            @if(Auth::user()->perfil_id == 3 && !$atividade->emissao_parcial && $acao->status != "Aprovada")
                                <a href="{{ Route('gestor.gerar_certificados_parcial', ['atividade_id' => $atividade->id]) }}"
                                   onclick="return confirm('Você tem certeza que deseja emitir os certificados desta atividade?')">
                                    <img src="/images/acoes/listView/submeter.svg" alt="emitir certificados"
                                         title="Emitir Certificados">
                                </a>
                            @endif

                        </div>

                        <div class="col-4"></div>
                    </div>
                </div>





                <!-- Modal -->
                <div class="modal fade" id="modalImportCsv{{ $atividade->id }}" tabindex="-1"
                    aria-labelledby="modalImportCsvLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalImportCsvLabel">Importar XLSX com os Dados dos Integrantes
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>


                            <div class="modal-body">
                                <div class="container">
                                    <form class="form"
                                        action="{{ Route('import_participantes', ['atividade_id' => $atividade->id]) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row align-items-start">
                                            <div>
                                                <input type="file" accept=".xlsx" name="participantes_xlsx"
                                                    id="participantes_xlsx" class="form-control form-control-sm"
                                                    style="margin-top:5%" required>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center mt-4">
                                            <div class="col-2">
                                                <button type="button" class="btn btn-sm btn-dark"
                                                    data-bs-dismiss="modal">Fechar</button>
                                            </div>
                                            <div class="col-2">
                                                <button type="submit" class="btn btn-sm btn-success">Importar</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modalImportTrabalhoCsv{{ $atividade->id }}" tabindex="-1"
                     aria-labelledby="modalImportCsvLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalImportCsvLabel">Importar XLSX com os Dados dos Trabalhos e Autores
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>


                            <div class="modal-body">
                                <div class="container">
                                    <form class="form"
                                          action="{{ Route('import_trabalhos', ['atividade_id' => $atividade->id]) }}"
                                          method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row align-items-start">
                                            <div>
                                                <input type="file" accept=".xlsx" name="trabalhos_xlsx"
                                                       id="trabalhos_xlsx" class="form-control form-control-sm"
                                                       style="margin-top:5%" required>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center mt-4">
                                            <div class="col-2">
                                                <button type="button" class="btn btn-sm btn-dark"
                                                        data-bs-dismiss="modal">Fechar</button>
                                            </div>
                                            <div class="col-2">
                                                <button type="submit" class="btn btn-sm btn-success">Importar</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
