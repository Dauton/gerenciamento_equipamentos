@extends('layouts.content')

@section('content')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / <a href="{{ route('cadastros') }}">Cadastros</a> / Usuários</h1>
            <i class="fa-solid fa-users-gear"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="{{route("createUser")}}">
                @csrf

                <h1>Cadastro de usuário</h1>

                <label for="nome"><p>Nome<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-id-card"></i>
                        <input type="text" name="nome" id="nome" placeholder="Complete com o nome" value="{{ old('nome') }}">
                    </div>
                    @error('nome')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='nome'] i {
                                background: #b90000 !important
                            }
                        </style>
                    @enderror
                </label>

                <label for="usuario"><p>Usuário<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-user-tag"></i>
                        <input type="text" name="usuario" id="usuario" placeholder="Complete com o usuário" value="{{ old('usuario') }}">
                    </div>
                    @error('usuario')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='usuario'] i {
                                background: #b90000 !important
                            }
                        </style>
                    @enderror
                </label>
                <label for="email"><p>E-mail<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" id="email" placeholder="Complete com o e-mail" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='email'] i {
                                background: #b90000 !important
                            }
                        </style>
                    @enderror
                </label>
                @if(session('usuario.perfil') === 'ADMIN')
                <label for="site"><p>Site<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-map-location-dot"></i>
                        <select name="site" id="site" class="select2">
                            <option value="{{ old('site') }}">Selecione o site</option>
                            @foreach ($sites as $site)
                                <option value="{{ $site['usu_nomfil'] }}" {{ old('site') == $site['usu_nomfil'] ? 'selected' : '' }}>{{ $site['usu_nomfil'] }}</option>
                            @endforeach
                        </select>
                    </div>
                        @if ($errors->has('site'))
                            <p id="input-error">{{ $errors->first('site') }}</p>
                            <style>
                                label[for='site'] i {
                                    background: #b90000 !important
                                }
                            </style>
                        @endif
                    </label>
                    <label for="perfil"><p>Perfil<span> *</span></p>
                        <div>
                            <i class="fa-solid fa-user-shield"></i>
                            <select name="perfil" id="perfil" class="select2">
                                <option value="" disabled {{ old('perfil') ? '' : 'selected' }}>Selecione o perfil</option>
                                <option value="ADMIN" {{ old('perfil') == 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
                                <option value="TI SITES" {{ old('perfil') == 'TI SITES' ? 'selected' : '' }}>TI SITES</option>
                                <option value="OPERAÇÃO" {{ old('perfil') == 'OPERAÇÃO' ? 'selected' : '' }}>OPERAÇÃO</option>
                            </select>
                        </div>
                        @if ($errors->has('perfil'))
                            <p id="input-error">{{ $errors->first('perfil') }}</p>
                            <style>
                                label[for='perfil'] i {
                                    background: #b90000
                                }
                            </style>
                        @endif
                    </label>
                @endif

                <label for="senha"><p>Senha<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="senha" id="senha" placeholder="Complete a senha" value="{{ old('senha') }}" autocomplete="new-password">
                    </div>
                    @error('senha')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='senha'] i {
                                background: #b90000 !important
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
                                background: #b90000 !important
                            }
                        </style>
                    @enderror
                </label>

                <div class="container-buttons">
                    <button type="submit">Cadastrar</button>
                    <a href="{{ route('cadastros')}}"><button type="button" id="btn-cancelar">Cancelar</button></a>
                </div>

            </form>

            <section class="table-container">

                <h1>Gerenciamento de usuários</h1>

                <table class="DataTable">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Usuário</th>
                            <th>E-mail</th>
                            <th>Site</th>
                            <th>Perfil</th>
                            <th>Status</th>
                            <th>Último login</th>
                            <th>Cadastrado em</th>
                            <th>Gerenciar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exibir as $exibe)
                            <tr>
                                <td>{{$exibe->nome}}</td>
                                <td>{{$exibe->usuario}}</td>
                                <td>{{$exibe->email}}</td>
                                <td>{{$exibe->site}}</td>
                                <td>{{$exibe->perfil}}</td>
                                <td>{{$exibe->status}}</td>
                                <td>{{ \Carbon\Carbon::parse($exibe->ultimo_login)->format('d/m/Y - H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($exibe->created_at)->format('d/m/Y - H:i') }}</td>
                                <td>
                                    <a href="{{route("edit-usuario", Crypt::encrypt($exibe->id))}}"><i class="fa-solid fa-square-pen" id="btn-table-blue"></i></a>
                                    <a href="{{route("edit-senha", Crypt::encrypt($exibe->id))}}"><i class="fa-solid fa-key" id="btn-table-yellow"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>

        </article>
        @include('layouts.rodape')
    </section>
@endsection
