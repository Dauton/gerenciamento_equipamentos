@extends('layouts.content')

@section('content')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / <a href="{{ route('cadastros') }}">Cadastros</a> / <a href='{{ route('create-site') }}'>Sites</a> / Ediçao de site</h1></h1>
            <i class="fa-solid fa-users-gear"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="{{ route("editSite", $exibir->id) }}">
                @csrf

                <h1>Edição de site</h1>

                <label for="descricao"><p>Descrição<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-map-location-dot"></i>
                        <input type="text" name="descricao" id="descricao" placeholder="Complete com a descriçao do site" value="{{ $exibir->descricao }}">
                    </div>
                    @error('descricao')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='descricao'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <div class="container-buttons">
                    <button type="submit">Submeter</button>
                    <a href="{{ route('create-site') }}"><button type="button" id="btn-cancelar">Cancelar</button></a>
                </div>

            </form>

        </article>
        @include('layouts.rodape')
    </section>
    <div id="float-buttons">
        <a><button type="button" id="float-button" class="float-button-red"><i class="fa-solid fa-trash"></i></button></a>
    </div>
    @section('executa-confirmacao')
        <a href="{{ route("deleteSite", Crypt::encrypt($exibir->id)) }}"><button type="button" id="btn-red">Excluir</button></a>
    @endsection
@endsection
