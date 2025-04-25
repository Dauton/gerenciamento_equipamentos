@extends('layouts.content')

@section('content')
@include('layouts.menu-lateral')
<section class="centro">
    <header class="cabecalho">
        <h1 class="cabecalho-title">Homepage</h1>
        <i class="fa-solid fa-handshake-simple"></i>
    </header>
    <article class="conteudo">
        <form method="post" action="entregaEquipamentoPermanente" enctype="multipart/form-data">
            @csrf

            <h1>Entrega permanente de equipamento</h1>

            <label for="equipamento">
                <p>Equipamento<span> *</span></p>
                <div>
                    <i class="fa-solid fa-microchip"></i>
                    <select name="equipamento" id="equipamento" class="select2">
                        <option value="" {{ old('equipamento') ? '' : 'selected' }}>Selecione o equipamento</option>
                        @foreach ($equipamentos as $equipamento)
                            <option value="{{ $equipamento->patrimonio }}" {{ old('equipamento') == $equipamento->patrimonio ? 'selected' : '' }}>{{ $equipamento->patrimonio . ' - ' . $equipamento->modelo }}</option>
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
                        @foreach ($colaboradores as $colaborador)
                            <option value="{{ $colaborador['usu_numcad'] . ' - ' . $colaborador['usu_nomfun'] }}" {{ old('colaborador') == $colaborador['usu_numcad'] . ' - ' . $colaborador['usu_nomfun'] ? 'selected' : '' }}>{{ $colaborador['usu_numcad'] . ' - ' . $colaborador['usu_nomfun'] }}</option>
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

            <!--<label for="loginAmazon">
                <p>Login Amazon<span> *</span></p>
                <div>
                    <i class="fa-solid fa-user-tag"></i>
                    <input type="number" name="loginAmazon" id="loginAmazon">
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
            <p id="result">000,00000000000000000000000</p>
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

            <label for="termo_responsabilidade">
                <p>Termo de responsabilidade (.pdf ou .docx)</p>
                <div>
                    <i class="fa-solid fa-file-signature"></i>
                    <input type="file" name="termo_responsabilidade" id="termo_responsabilidade" accept=".pdf, .docx">
                </div>
                @error('termo_responsabilidade')
                    <p id="input-error">{{ $message }}</p>
                    <style>
                        label[for='termo_responsabilidade'] i {
                            background: #b90000
                        }
                    </style>
                @enderror
            </label>

            <div class="container-buttons">
                <button type="submit">Entregar</button>
                <a href="{{ route('entrega-permanente')}}"><button type="button" id="btn-cancelar">Cancelar</button></a>
            </div>
        </form>
        <section class="table-container">

            <h1>Equipamentos em uso permanente</h1>

            <table class="DataTable">
                <thead>
                    <tr>
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
                        <td>{{$exibe->site}}</td>
                        <td>{{$exibe->equipamento}}</td>
                        <td>{{$exibe->agente_entrega}}</td>
                        <td>{{\Carbon\Carbon::parse($exibe->data_entrega)->format('d/m/Y - H:i')}}</td>
                        <td>{{$exibe->colaborador}}</td>
                        <td>{{$exibe->departamento}}</td>
                        <td>{{$exibe->turno}}</td>
                        <td>{{$exibe->agente_devolucao}}</td>
                        <td>{{$exibe->data_devolucao ? \Carbon\Carbon::parse($exibe->data_devolucao)->format('d/m/Y - H:i') : ''}} </td>
                        <td>{{$exibe->avaria}}</td>
                        <td>
                            @if (!empty($exibe->foto_avaria))
                            <a href="{{ $exibe->foto_avaria }}" target="_blank" title="Clique para abrir a foto">
                                <i class="fa-solid fa-image" id="btn-table-blue"></i>
                            </a>
                            @endif
                        </td>
                        <td>
                            <a href="{{$exibe->termo_responsabilidade}}" download>
                                @if(str_ends_with($exibe->termo_responsabilidade, ".pdf"))
                                    <i class="fa-solid fa-file-pdf" id="btn-table-red"></i>
                                @else
                                    <i class="fa-solid fa-file-word" id="btn-table-blue"></i>
                                @endif
                            </a>
                        </td>
                        <td>
                            @if(empty($exibe->data_devolucao))
                                <a href="/devolve-permanente/{{Crypt::encrypt($exibe->id)}}"><i class="fa-solid fa-circle-down" id="btn-table-blue"></i></a>
                            @endif
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
