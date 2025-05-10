@extends('layouts.content')

@section('content')
    @include('layouts.menu-lateral')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / <a href="{{ route('cadastros') }}">Cadastros</a> / <a href='{{ route('create-turno') }}'>Turnos</a> / Ediçao de turno</h1></h1>
            <i class="fa-solid fa-users-gear"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="{{route("updateTurno", $exibir->id) }}">
                @csrf

                <h1>Edição de turno</h1>

                <label for="turno"><p>Descrição<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-id-card"></i>
                        <input type="text" name="turno" id="turno" placeholder="Complete com a descrição do turno" value="{{ $exibir->turno }}">
                    </div>
                    @error('turno')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='turno'] i {
                                background: #b90000 !important
                            }
                        </style>
                    @enderror
                </label>

                <div class="container-buttons">
                    <button type="submit">Submeter</button>
                    <a href="{{ route('create-turno')}}"><button type="button" id="btn-cancelar">Cancelar</button></a>
                </div>

            </form>

        </article>
        @include('layouts.rodape')
    </section>
    <div id="float-buttons">
        <a><button type="button" id="float-button" class="float-button-red"><i class="fa-solid fa-trash"></i></button></a>
    </div>
    @section('executa-confirmacao')
        <a href="{{ route("deleteTurno", Crypt::encrypt($exibir->id)) }}"><button type="button" id="btn-red">Excluir</button></a>
    @endsection
@endsection
