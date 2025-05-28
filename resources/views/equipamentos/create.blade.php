@extends('layouts.content')

@section('content')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / <a href="{{ route('cadastros') }}">Cadastros</a> / Equipamentos</h1>
            <i class="fa-solid fa-microchip"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="{{ route("createEquipamento") }}">
                @csrf

                <h1>Cadastro de equipamento</h1>

                <label for="marca"><p>Marca<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-microchip"></i>
                        <input type="text" name="marca" id="marca" placeholder="Complete com a marca" value="{{ old('marca') }}">
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
                        <input type="text" name="modelo" id="modelo" placeholder="Complete com o modelo" value="{{ old('modelo') }}">
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
                        <input type="text" name="serial" id="serial" placeholder="Complete com o serial" value="{{ old('serial') }}">
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
                        <input type="text" name="patrimonio" id="patrimonio" placeholder="Complete com o patrimônio" value="{{ old('patrimonio') }}">
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
            </label>
            <label for="site_equipamento"><p>Site do equipamento<span> *</span></p>
                <div>
                    <i class="fa-solid fa-map-location-dot"></i>
                    <select name="site_equipamento" id="site_equipamento" class="select2">
                        <option value="{{ old('site_equipamento') }}">Selecione o site</option>
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
                            <option value="" disabled {{ old('status') ? '' : 'selected' }}>Selecione o status</option>
                            <option value="PRODUÇÃO" {{ old('status') == 'PRODUÇÃO' ? 'selected' : '' }}>PRODUÇÃO</option>
                            <option value="MANUTENÇÃO" {{ old('status') == 'MANUTENÇÃO' ? 'selected' : '' }}>MANUTENÇÃO</option>
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
                    <button type="submit">Cadastrar</button>
                    <a href="{{ route('cadastros')}}"><button type="button" id="btn-cancelar">Cancelar</button></a>
                </div>

            </form>

            <section class="table-container">

                <h1>Gerenciamento de equipamentos</h1>

                <table class="DataTable">
                    <thead>
                        <tr>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Serial</th>
                            <th>Patrimômio</th>
                            <th>Site</th>
                            <th>Status</th>
                            <th>Cadastrado em</th>
                            <th>Gerenciar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exibir as $exibe)
                            <tr>
                                <td>{{$exibe->marca}}</td>
                                <td>{{$exibe->modelo}}</td>
                                <td>{{$exibe->serial}}</td>
                                <td>{{$exibe->patrimonio}}</td>
                                <td>{{$exibe->site_equipamento}}</td>
                                <td>{{$exibe->status}}</td>
                                <td>{{ \Carbon\Carbon::parse($exibe->created_at)->format('d/m/Y - H:i') }}</td>
                                <td>
                                    <a href="{{route("edit-equipamento", Crypt::encrypt($exibe->id))}}"><i class="fa-solid fa-square-pen" id="btn-table-blue"></i></a>
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
