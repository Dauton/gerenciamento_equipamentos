@extends('layouts.content')

@section('content')
    @include('layouts.menu-lateral')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / <a href="{{ route('cadastros') }}">Cadastros</a> / Colaboradores temporários</h1>
            <i class="fa-solid fa-microchip"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="createColaborador">
                @csrf

                <h1>Cadastro de colaborador temporário</h1>

                <label for="nome_colaborador"><p>Nome<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-id-card"></i>
                        <input type="text" name="nome_colaborador" id="nome_colaborador" placeholder="Complete com o nome do colaborador" value="{{ old('nome_colaborador') }}">
                    </div>
                    @error('nome_colaborador')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='nome_colaborador'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <label for="matricula_colaborador"><p>Matrícula<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-user-tag"></i>
                        <input type="text" name="matricula_colaborador" id="matricula_colaborador" placeholder="Complete com a matrícula do colaborador" value="{{ old('matricula_colaborador') }}">
                    </div>
                    @error('matricula_colaborador')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='matricula_colaborador'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>
                <label for="site_colaborador"><p>Site do colaborador<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-map-location-dot"></i>
                        <select name="site_colaborador" id="site_colaborador" class="select2">
                            <option value="{{ old('site_colaborador') }}">Selecione o site</option>
                            @foreach ($sites as $site)
                                <option value="{{ $site['usu_nomfil'] }}">{{ $site['usu_nomfil'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('site_colaborador')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='site_colaborador'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <label for="desativar_em"><p>Ativo até (o colaborador será desativado conforme data informada.)<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-id-card"></i>
                        <input type="date" name="desativar_em" id="desativar_em" placeholder="Complete com o nome do colaborador" value="{{ old('desativar_em') }}">
                    </div>
                    @error('desativar_em')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='desativar_em'] i {
                                background: #b90000
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

                <h1>Gerenciamento de colaboradores temporários</h1>

                <table class="DataTable">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Nome</th>
                            <th>Matrícula</th>
                            <th>Site</th>
                            <th>Desativa em</th>
                            <th>Cadastrado em</th>
                            <th>Gerenciar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colaboradores as $exibe)
                            <tr>
                                <td>
                                    @if($exibe->status === 'ATIVADO')
                                        <i class="fa-solid fa-user-check" id="table-icon-green" title="Ativado"></i> Ativado
                                    @else
                                        <i class="fa-solid fa-user-xmark" id="table-icon-red" title="Desativado"></i> Desativado
                                    @endif
                                </td>
                                <td>{{ $exibe->nome_colaborador }}</td>
                                <td>{{ $exibe->matricula_colaborador }}</td>
                                <td>{{ $exibe->site_colaborador }} </td>
                                <td>{{ Carbon\Carbon::parse($exibe->desativar_em)->format('d/m/Y') }} </td>
                                <td>{{ \Carbon\Carbon::parse($exibe->created_at)->format('d/m/Y - H:i') }}</td>
                                <td>
                                    <a href="update-colaborador/{{Crypt::encrypt($exibe->id)}}"><i class="fa-solid fa-square-pen" id="btn-table-blue"></i></a>
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
