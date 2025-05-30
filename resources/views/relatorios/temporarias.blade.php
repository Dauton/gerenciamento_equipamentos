@extends('layouts.content')

@section('content')

    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / Relatórios</h1>
            <i class="fa-solid fa-magnifying-glass"></i>
        </header>
        <article class="conteudo">

            <form method="post" action="{{ route("buscaRelatorio") }}">
                @csrf

                <h1>Busca de relatório</h1>

                <h5>Para obter todos os dados do seu site, deixe os campos em branco.</h5>

                <label for="data_inicio">
                    <p>De</p>
                    <div>
                        <i class="fa-solid fa-calendar-days"></i>
                        <input type="date" name="data_inicio" id="data_inicio" value="{{ old('data_inicio') }}">
                    </div>
                    @error('data_inicio')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='data_inicio'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <label for="data_final">
                    <p>Até</p>
                    <div>
                        <i class="fa-solid fa-calendar-days"></i>
                        <input type="date" name="data_final" id="data_final" value="{{ old('data_final') }}">
                    </div>
                    @error('data_final')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='data_final'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <label for="site">
                    <p>Site</p>
                    <div>
                        <i class="fa-solid fa-map-location-dot"></i>
                        <select name="site" id="site" class="select2">
                            <option value="">Selecione o site</option>
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

                <label for="equipamento">
                    <p>Equipamento<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-microchip"></i>
                        <select name="equipamento" id="equipamento" class="select2">
                            <option value="" {{ old('equipamento') ? '' : 'selected' }}>Selecione o equipamento</option>
                            @foreach ($equipamentos as $equipamento)
                                @php
                                    $valor = $equipamento->nome_tipo . ' - PAT ' . $equipamento->patrimonio . ' - SN ' . $equipamento->serialnumber;
                                @endphp
                                <option value="{{ $valor }}" {{ old('equipamento') == $valor ? 'selected' : '' }}>
                                    {{ $valor }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('equipamento')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='equipamento'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <div class="container-buttons">
                    <button type="submit">Buscar</button>
                    <a href="{{ route('relatorios-temporarias') }}"><button type="button" id="btn-cancelar">Resetar</button></a>
                </div>
            </form>
            @if (count($relatorios) > 0)
                <section class="table-container">

                    <h1>Resultado da busca</h1>

                    <table class="DataTableExcel">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Site</th>
                                <th>Equipamento</th>
                                <th>Entregue por</th>
                                <th>Entregue em</th>
                                <th>Para o colaborador</th>
                                <th>Departamento</th>
                                <th>Turno</th>
                                <th>Confirmou devolução</th>
                                <th>Devolvido em</th>
                                <th>Pelo colaborador</th>
                                <th>Avaria</th>
                                <th>Foto da avaria</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($relatorios as $exibe)
                                <tr>
                                    <td>
                                        @if (!empty($exibe->agente_devolucao))
                                            <i class="fa-solid fa-circle-check" id="table-icon-green"
                                                title="Equipamento devolvido."></i>
                                        @else
                                            <i class="fa-solid fa-clock" id="table-icon-blue"
                                                title="Equipamento pendente de devolução ou em uso."></i>
                                        @endif
                                    </td>
                                    <td>{{ $exibe->site }}</td>
                                    <td>{{ $exibe->equipamento }}</td>
                                    <td>{{ $exibe->agente_entrega }}</td>
                                    <td>{{ \Carbon\Carbon::parse($exibe->data_entrega)->format('d/m/Y - H:i') }}</td>
                                    <td>{{ $exibe->colaborador }}</td>
                                    <td>{{ $exibe->departamento }}</td>
                                    <td>{{ $exibe->turno }}</td>
                                    <td>{{ $exibe->agente_devolucao }}</td>
                                    <td>{{ $exibe->data_devolucao ? \Carbon\Carbon::parse($exibe->data_devolucao)->format('d/m/Y - H:i') : '' }}</td>
                                    <td>{{ $exibe->colaborador_devolucao }}</td>
                                    <td>{{ $exibe->avaria }}</td>
                                    <td>
                                        @if (!empty($exibe->foto_avaria))
                                            <a href="{{ $exibe->foto_avaria }}" target="_blank"
                                                title="Clique para abrir a foto">
                                                <i class="fa-solid fa-image" id="btn-table-blue"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            @endif
        </article>
        @include('layouts.rodape')
    </section>

@endsection
