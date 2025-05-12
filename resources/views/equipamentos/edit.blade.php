@extends('layouts.content')

@section('content')
    @include('layouts.menu-lateral')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / <a href="{{ route('cadastros') }}">Cadastros</a> / <a href='{{ route('create-equipamento') }}'>Equipamentos</a> / Edição de equipamento</h1></h1>
            <i class="fa-solid fa-users-gear"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="{{ route("editEquipamento", $exibir->id) }}">
                @csrf

                <h1>Edição de equipamento</h1>

                <label for="marca"><p>Marca<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-microchip"></i>
                        <input type="text" name="marca" id="marca" placeholder="Complete com a marca" value="{{ $exibir->marca }}">
                    </div>
                    @error('marca')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='marca'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <label for="modelo"><p>Modelo<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-microchip"></i>
                        <input type="text" name="modelo" id="modelo" placeholder="Complete com o modelo" value="{{ $exibir->modelo }}">
                    </div>
                    @error('modelo')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='modelo'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>
                <label for="serial"><p>Serial<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-tag"></i>
                        <input type="text" name="serial" id="serial" placeholder="Complete com o serial" value="{{ $exibir->serial }}">
                    </div>
                    @error('serial')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='serial'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>
                <label for="patrimonio"><p>Patrimônio<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-tag"></i>
                        <input type="text" name="patrimonio" id="patrimonio" placeholder="Complete com o patrimonio" value="{{ $exibir->patrimonio }}">
                    </div>
                    @error('patrimonio')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='patrimonio'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>
                <label for="site_equipamento"><p>Site<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-map-location-dot"></i>
                        <select name="site_equipamento" id="site_equipamento" class="select2">
                            <option value="{{ $exibir->site_equipamento }}">{{ $exibir->site_equipamento }}</option>
                            @foreach ($sites as $site)
                                <option value="{{ $site['usu_nomfil'] }}">{{ $site['usu_nomfil'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('site_equipamento')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='site_equipamento'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>
                <label for="status"><p>Status<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-circle-check"></i>
                        <select name="status" id="status" class="select2">
                            <option value="{{ $exibir->status }}">{{ $exibir->status }}</option>
                            <option value="PRODUÇÃO">PRODUÇÃO</option>
                            <option value="MANUTENÇÃO">MANUTENÇÃO</option>
                        </select>
                    </div>
                    @error('status')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='status'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <div class="container-buttons">
                    <button type="submit">Submeter</button>
                    <a href="{{ route('create-equipamento')}}"><button type="button" id="btn-cancelar">Cancelar</button></a>
                </div>

            </form>

        </article>
        @include('layouts.rodape')
    </section>
    <div id="float-buttons">
        <a><button type="button" id="float-button" class="float-button-red"><i class="fa-solid fa-trash"></i></button></a>
    </div>
    @section('executa-confirmacao')
        <a href="{{ route("deleteEquipamento", Crypt::encrypt($exibir->id)) }}"><button type="button" id="btn-red">Excluir</button></a>
    @endsection
@endsection
