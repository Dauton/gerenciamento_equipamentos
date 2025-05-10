@extends('layouts.content')

@section('content')
    @include('layouts.menu-lateral')

    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / Relatórios de entregas permanentes
            </h1>
            <i class="fa-solid fa-magnifying-glass"></i>
        </header>
        <article class="conteudo">

            <form method="post" action="{{ route("buscaRelatorioPermanente") }}">
                @csrf

                <h1>Busca de relatório de entregas permanentes.</h1>

                <h5>Para obter todos os dados, deixe os campos em branco.</h5>

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
                    <p>Equipamento</p>
                    <div>
                        <i class="fa-solid fa-microchip"></i>
                        <select name="equipamento" id="equipamento" class="select2">
                            <option value="" {{ old('equipamento') ? '' : 'selected' }}>Selecione o equipamento</option>
                            @foreach ($equipamentos as $equipamento)
                                @php
                                    $valor = 'PAT ' . $equipamento->sde_inventory_number . ' - SN ' . $equipamento->sde_serial_number;
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

                <label for="colaborador">
                    <p>Colaborador</p>
                    <div>
                        <i class="fa-solid fa-id-card"></i>
                        <select name="colaborador" id="colaborador" class="select2">
                            <option value="">Selecione o equipamento</option>
                            @foreach ($colaboradores as $colaborador)
                                <option value="{{ $colaborador['usu_numcad'] . ' - ' . $colaborador['usu_nomfun'] }}">{{ $colaborador['usu_numcad'] . ' - ' . $colaborador['usu_nomfun'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('colaborador')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='colaborador'] i {
                                background: #b90000
                            }
                        </style>
                    @enderror
                </label>

                <div class="container-buttons">
                    <button type="submit">Buscar</button>
                    <a href="{{ route('relatorios-permanentes') }}"><button type="button" id="btn-cancelar">Resetar</button></a>
                </div>
            </form>
            @if (count($relatoriosPermanentes) > 0)
                <section class="table-container">

                    <h1>Equipamentos em uso permanente</h1>

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
                                <th>Devolvido por</th>
                                <th>Devolvido em</th>
                                <th>Avaria</th>
                                <th>Foto avaria</th>
                                <th>Termo de respons.</th>
                                <th>Devolução</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($relatoriosPermanentes as $exibe)
                                <tr>
                                    <td>
                                        @if (!empty($exibe->agente_devolucao))
                                            <i class="fa-solid fa-circle-check" id="table-icon-green"
                                                title="O colaborador já efetuou a devolução do equipamento."></i>
                                        @else
                                            <i class="fa-solid fa-clock" id="table-icon-blue"
                                                title="Este colaborador ainda está utilizando o equipamento."></i>
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
                                    <td>{{ $exibe->data_devolucao ? \Carbon\Carbon::parse($exibe->data_devolucao)->format('d/m/Y - H:i') : '' }}
                                    </td>
                                    <td>{{ $exibe->avaria }}</td>
                                    <td>
                                        @if (!empty($exibe->foto_avaria))
                                            <a href="{{ $exibe->foto_avaria }}" target="_blank"
                                                title="Clique para abrir a foto">
                                                <i class="fa-solid fa-image" id="btn-table-blue"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($exibe->termo_responsabilidade))
                                        <a href="{{ $exibe->termo_responsabilidade }}" download>
                                            @if (str_ends_with($exibe->termo_responsabilidade, '.pdf'))
                                                <i class="fa-solid fa-file-pdf" id="btn-table-red"></i>
                                            @else
                                                <i class="fa-solid fa-file-word" id="btn-table-blue-secondary"></i>
                                            @endif
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (empty($exibe->data_devolucao))
                                            <a href="{{ route("relatorios-permanentes", Crypt::encrypt($exibe->id)) }}"><i
                                                    class="fa-solid fa-circle-down" id="btn-table-blue"></i></a>
                                        @else
                                            Já devolvido
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
