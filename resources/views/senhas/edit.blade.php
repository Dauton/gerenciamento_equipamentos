@extends('layouts.content')

@section('content')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / Reset de senha</h1>
            <i class="fa-solid fa-key"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="{{ route("editSenha", Crypt::encrypt($exibir->id)) }}">
                @csrf

                <h1>Reset de senha</h1>

                <h5>Usuário <b>{{ $exibir->nome }}</b></h5>

                <label for="senha"><p>Senha<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="senha" id="senha" placeholder="Complete a senha" value="{{ old('senha') }}" autocomplete="new-password">
                    </div>
                    @error('senha')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='senha'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>
                <label for="repete_senha"><p>Repita a senha<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="repete_senha" id="repete_senha" placeholder="Repita a senha" value="{{ old('repete_senha') }}">
                    </div>
                    @error('repete_senha')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='repete_senha'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <div class="container-buttons">
                    <button type="submit">Submeter</button>
                    <a href="{{ route('create-usuario') }}"><button type="button" id="btn-cancelar">Cancelar</button></a>
                </div>

            </form>

        </article>
        @include('layouts.rodape')
    </section>
@endsection
