@extends('layouts.content')

@section('content')
    @include('layouts.menu-lateral')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / <a href="{{ route('cadastros') }}">Cadastros</a> / <a href='{{ route('avarias') }}'>Avarias</a> / Ediçao de avaria</h1>
            <i class="fa-solid fa-users-gear"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="/updateAvaria/{{ $exibir->id }}">
                @csrf

                <h1>Edição de site</h1>

                <label for="avaria"><p>Avaria<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-burst"></i>
                        <input type="text" name="avaria" id="avaria" placeholder="Complete com a descrição da avaria" value="{{ $exibir->avaria }}">
                    </div>
                    @error('avaria')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='avaria'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <label for="tipo_avaria"><p>Tipo avaria<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-burst"></i>
                        <select name="tipo_avaria" id="tipo_avaria" class="select2">
                            <option value="{{ $exibir->tipo_avaria }}">{{ $exibir->tipo_avaria }}</option>
                            <option value="Sistêmico (Software)">Sistêmico (Software)</option>
                            <option value="Físico (Hardware)">Físico (Hardware)</option>
                        </select>
                    </div>
                    @error('tipo_avaria')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='tipo_avaria'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <div class="container-buttons">
                    <button type="submit">Submeter</button>
                    <a href="{{ route('avarias')}}"><button type="button" id="btn-cancelar">Cancelar</button></a>
                </div>

            </form>
        </article>
        @include('layouts.rodape')
    </section>
    <div id="float-buttons">
        <a><button type="button" id="float-button" class="float-button-red"><i class="fa-solid fa-trash"></i></button></a>
    </div>
    @section('executa-confirmacao')
        <a href="/deleteAvaria/{{ Crypt::encrypt($exibir->id) }}"><button type="button" id="btn-red">Excluir</button></a>
    @endsection
@endsection
