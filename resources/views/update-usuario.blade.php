@extends('layouts.content')

@section('content')
    @include('layouts.menu-lateral')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / <a href="{{ route('cadastros') }}">Cadastros</a> / <a href='{{ route('usuarios') }}'>Usuários</a> / Ediçao de usuário</h1></h1>
            <i class="fa-solid fa-users-gear"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="/updateUser/{{ $exibir->id }}">
                @csrf

                <h1>Edição de usuário</h1>

                <label for="nome"><p>Nome<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-id-card"></i>
                        <input type="text" name="nome" id="nome" placeholder="Complete com o nome" value="{{ $exibir->nome }}">
                    </div>
                    @error('nome')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='nome'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <label for="usuario"><p>Usuário<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-user-tag"></i>
                        <input type="text" name="usuario" id="usuario" placeholder="Complete com o usuário" value="{{ $exibir->usuario }}">
                    </div>
                    @error('usuario')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='usuario'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>
                <label for="email"><p>E-mail<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" id="email" placeholder="Complete com o e-mail" value="{{ $exibir->email }}">
                    </div>
                    @error('email')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='email'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>
                <label for="site"><p>Site<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-map-location-dot"></i>
                        <select name="site" id="site" class="select2">
                            <option value="{{ $exibir->site }}">{{ $exibir->site }}</option>
                            @foreach ($sites as $site)
                                <option value="{{ $site['usu_nomfil'] }}">{{ $site['usu_nomfil'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('site')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='site'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>
                <label for="perfil"><p>Perfil<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-user-shield"></i>
                        <select name="perfil" id="perfil" class="select2">
                            <option value="{{ $exibir->perfil }}">{{ $exibir->perfil }}</option>
                            <option value="ADMIN">ADMIN</option>
                            <option value="TI SITES">TI SITES</option>
                        </select>
                    </div>
                    @error('perfil')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='perfil'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <div class="container-buttons">
                    <button type="submit">Submeter</button>
                    <a href="{{ route('usuarios')}}"><button type="button" id="btn-cancelar">Cancelar</button></a>
                </div>

            </form>

        </article>
        @include('layouts.rodape')
    </section>
    <div id="float-buttons">
        <a href="/update-senha/{{ Crypt::encrypt($exibir->id) }}"><button type="button" id="float-button"><i class="fa-solid fa-key"></i></button></a>
        <a><button type="button" id="float-button" class="float-button-red"><i class="fa-solid fa-trash"></i></button></a>
    </div>
    @section('executa-confirmacao')
        <a href="/deleteUsuario/{{ Crypt::encrypt($exibir->id) }}"><button type="button" id="btn-red">Excluir</button></a>
    @endsection
@endsection
