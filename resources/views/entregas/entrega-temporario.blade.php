@extends('layouts.content')

@section('content')
@include('layouts.menu-lateral')
<section class="centro">
    <header class="cabecalho">
        <h1 class="cabecalho-title">Homepage</h1>
        <i class="fa-solid fa-house"></i>
    </header>
    <article class="conteudo">
        <form method="post" action="{{ route("entregaEquipamento") }}">
            @csrf

            <h1>Entrega de equipamento</h1>

            <label for="equipamento">
                <p>Equipamento<span> *</span></p>
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
                <p>Colaborador<span> *</span></p>
                <div>
                    <i class="fa-solid fa-user-tag"></i>
                    <select name="colaborador" id="colaborador" class="select2">
                        <option value="" {{ old('colaborador') ? '' : 'selected' }}>Selecione o colaborador</option>

                        <option disabled>Efetivos</option>
                        @foreach ($colaboradores as $colaborador)
                            <option value="{{ $colaborador['usu_numcad'] . ' - ' . $colaborador['usu_nomfun'] }}" {{ old('colaborador') == $colaborador['usu_numcad'] . ' - ' . $colaborador['usu_nomfun'] ? 'selected' : '' }}>{{ $colaborador['usu_numcad'] . ' - ' . $colaborador['usu_nomfun'] }}</option>
                        @endforeach

                        <option disabled>Temporários</option>
                        @foreach ($colaboradores_temporarios as $colaborador)
                            <option value="{{ $colaborador->matricula_colaborador . ' - ' . $colaborador->nome_colaborador }}" {{ old('colaborador') == $colaborador->matricula_colaborador . ' - ' . $colaborador->nome_colaborador ? 'selected' : '' }}>{{ $colaborador->matricula_colaborador . ' - ' . $colaborador->nome_colaborador }}</option>
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

            <!--
            <label for="loginAmazon">
                <p>Login Amazon<span> *</span></p>
                <div>
                    <i class="fa-solid fa-user-tag"></i>
                    <input type="number" name="loginAmazon" id="loginAmazon" value="">
                </div>
                @error('loginAmazon')
                    <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='loginAmazon'] i {
                                background: #b90000
                            }
                        </style>
                @enderror
            </label>


            <label for="loginAmazon">
                <p>Login Amazon Convertido<span> *</span></p>
                <div>
                    <i class="fa-solid fa-user-tag"></i>
                    <input type="text" name="loginAmazonConvertido" id="loginAmazonConvertido">
                </div>
                @error('loginAmazon')
                    <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='loginAmazon'] i {
                                background: #b90000
                            }
                        </style>
                @enderror
            </label>
            -->

            <label for="departamento">
                <p>Departamento<span> *</span></p>
                <div>
                    <i class="fa-solid fa-briefcase"></i>
                    <select name="departamento" id="departamento" class="select2">
                        <option value="" {{ old('departamento') ? '' : 'selected' }}>Selecione o departamento</option>
                        @foreach ($departamentos as $departamento)
                        <option value="{{ $departamento->departamento }}" {{ old('departamento') == $departamento->departamento ? 'selected' : '' }}>{{ $departamento->departamento }}</option>
                        @endforeach
                    </select>
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

            <label for="turno">
                <p>Turno<span> *</span></p>
                <div>
                    <i class="fa-solid fa-business-time"></i>
                    <select name="turno" id="turno" class="select2">
                        <option value="" {{ old('turno') ? '' : 'selected' }}>Selecione o turno</option>
                        @foreach ($turnos as $turno)
                            <option value="{{ $turno->turno }}" {{ old('turno') == $turno->turno ? 'selected' : '' }}>{{ $turno->turno }}</option>
                        @endforeach
                    </select>
                </div>
                @error('turno')
                    <p id="input-error">{{ $message }}</p>
                    <style>
                        label[for='turno'] i {
                            background: #b90000
                        }
                    </style>
                @enderror
            </label>

            <div class="container-buttons">
                <button type="submit">Entregar</button>
                <a href="{{ route('homepage')}}"><button type="button" id="btn-cancelar">Cancelar</button></a>
            </div>
        </form>

        <section class="table-container">

            <h1>Equipamento em uso no momento (pendente de devolução)</h1>

            <table class="DataTable">
                <thead>
                    <tr>
                        <th>Equipamento</th>
                        <th>Entregue pelo agente</th>
                        <th>Data/horário da entrega</th>
                        <th>Para o colaborador</th>
                        <th>Departamento</th>
                        <th>Turno</th>
                        <th>Devolução</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($relatorios as $exibe)
                    <tr>
                        <td>{{$exibe->equipamento}}</td>
                        <td>{{$exibe->agente_entrega}}</td>
                        <td>{{\Carbon\Carbon::parse($exibe->data_entrega)->format('d/m/Y - H:i')}}</td>
                        <td>{{$exibe->colaborador}}</td>
                        <td>{{$exibe->departamento}}</td>
                        <td>{{$exibe->turno}}</td>
                        <td>
                            <a href="{{route("devolve-temporario", Crypt::encrypt($exibe->id)) }}"><i class="fa-solid fa-circle-down" id="btn-table-blue"></i></a>
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
