@extends('layouts.content')

@section('content')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / <a href="{{ route('cadastros') }}">Cadastros</a> / <a href='{{ route('create-departamento') }}'>Departamentos</a> / Ediçao de departamento</h1>
            <i class="fa-solid fa-users-gear"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="{{ route("editDepartamento", $exibir->id) }}">
                @csrf

                <h1>Edição de departamento</h1>

                <label for="departamento"><p>Departamento<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-briefcase"></i>
                        <input type="text" name="departamento" id="departamento" placeholder="Complete com o departamento" value="{{ $exibir->departamento }}">
                    </div>
                    @error('departamento')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='departamento'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <div class="container-buttons">
                    <button type="submit">Submeter</button>
                    <a href="{{ route('create-departamento')}}"><button type="button" id="btn-cancelar">Cancelar</button></a>
                </div>

            </form>

        </article>
        @include('layouts.rodape')
    </section>
    <div id="float-buttons">
        <a><button type="button" id="float-button" class="float-button-red"><i class="fa-solid fa-trash"></i></button></a>
    </div>
    @section('executa-confirmacao')
        <a href="{{ route("deleteDepartamento", Crypt::encrypt($exibir->id)) }}"><button type="button" id="btn-red">Excluir</button></a>
    @endsection
@endsection
