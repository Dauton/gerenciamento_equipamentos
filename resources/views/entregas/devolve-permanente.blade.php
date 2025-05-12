@extends('layouts.content')

@section('content')
@include('layouts.menu-lateral')

<section class="centro">
    <header class="cabecalho">
        <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / Devolução</h1>
        <i class="fa-solid fa-handshake-simple"></i>
    </header>
    <article class="conteudo">

        <form method="post" action="{{ route("devolveEquipamentoPermanente", $idRelatorio->id) }}" enctype="multipart/form-data">
            @csrf

            <h1>Devolução de equipamento permanente</h1>

            <label for="ha_avaria">
                <p>O equipamento está avariado?<span> *</span></p>
                <div>
                    <i class="fa-solid fa-burst"></i>
                    <select name="ha_avaria" id="ha_avaria" class="select2">
                        <option value="" {{ old('ha_avaria') ? '' : 'selected' }}>Selecione</option>
                        <option value="SIM" {{ old('ha_avaria') == 'SIM' ? 'selected' : '' }}>SIM</option>
                        <option value="NÃO" {{ old('ha_avaria') == 'NÃO' ? 'selected' : '' }}>NÃO</option>
                    </select>
                </div>
                @error('ha_avaria')
                    <p id="input-error">{{ $message }}</p>
                    <style>
                        label[for='ha_avaria'] i {
                            background: #b90000
                        }
                    </style>
                @enderror
            </label>
            <label for="avaria" id="label_descricao_avaria">
                <p>Descriçao da avaria<span> *</span></p>
                <div>
                    <i class="fa-solid fa-burst"></i>
                    <select name="avaria" id="avaria" class="select2">
                        <option value="" {{ old('avaria') ? '' : 'selected' }}>Selecione o tipo da avaria</option>
                        @foreach ($avarias as $avaria)
                            <option value="{{ $avaria->avaria . ' - ' . $avaria->tipo_avaria}}" {{ old('avaria') == $avaria->avaria ? 'selected' : '' }}>{{ $avaria->avaria . ' - ' . $avaria->tipo_avaria}}</option>
                        @endforeach
                    </select>
                </div>
                @error('avaria')
                    <p id="input-error">{{ $message }}</p>
                    <style>
                        label[for='avaria'] i {
                            background: #b90000
                        }
                    </style>
                @enderror
            </label>

            <label for="foto_avaria" id="label_foto_avaria">
                <p>Foto da avaria<span> *</span></p>
                <div>
                    <i class="fa-solid fa-image"></i>
                    <input type="file" name="foto_avaria" id="foto_avaria" accept=".png,.jpg,.jpeg">
                </div>
                @error('foto_avaria')
                    <p id="input-error">{{ $message }}</p>
                    <style>
                        label[for='foto_avaria'] i {
                            background: #b90000
                        }
                    </style>
                @enderror
            </label>

            <input type="hidden" name="equipamento" id="equipamento" value="{{ $exibir->first()->equipamento }}">

            <div class="container-buttons">
                <button type="submit">Devolver</button>
                <a href="{{ route('entrega-permanente')}}"><button type="button" id="btn-cancelar">Cancelar</button></a>
            </div>
        </form>

        <section class="table-container">

            <h1>Informações de uso</h1>

            <table>
                <thead>
                    <tr>
                        <th>Equipamento</th>
                        <th>Entregue por</th>
                        <th>Entregue em</th>
                        <th>Para o colaborador</th>
                        <th>Termo de responsabilidae</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exibir as $exibe)
                    <tr>
                        <td>{{$exibe->equipamento}}</td>
                        <td>{{$exibe->agente_entrega}}</td>
                        <td>{{\Carbon\Carbon::parse($exibe->data_entrega)->format('d/m/Y - H:i')}}</td>
                        <td>{{$exibe->colaborador}}</td>
                        <td>
                            @if(!empty($exibe->termo_responsabilidade))
                            <a href="{{$exibe->termo_responsabilidade}}" download>
                                @if(str_ends_with($exibe->termo_responsabilidade, ".pdf"))
                                    <i class="fa-solid fa-file-pdf" id="btn-table-red"></i>
                                @else
                                    <i class="fa-solid fa-file-word" id="btn-table-blue-secondary"></i>
                                @endif
                            </a>
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
