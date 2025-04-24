@extends('layouts.content')

@section('content')
@include('layouts.menu-lateral')

<section class="centro">
    <header class="cabecalho">
        <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / Devolução</h1>
        <i class="fa-solid fa-users-gear"></i>
    </header>
    <article class="conteudo">

        <form method="post" action="/devolveEquipamento/{{ $idRelatorio->id }}" enctype="multipart/form-data">
            @csrf

            <h1>Devolução de equipamento</h1>

            <label for="ha_avaria">
                <p>O equipamento está avariado?<span> *</span></p>
                <div>
                    <i class="fa-solid fa-burst"></i>
                    <select name="ha_avaria" id="ha_avaria" class="select2">
                        <option value="" {{ old('ha_avaria') ? '' : 'selected' }}>Selecione</option>
                        <option value="SIM">SIM</option>
                        <option value="NÃO">NÃO</option>
                    </select>

                </div>
                @error('ha_avaria')
                    <p id="input-error">{{ $message }}</p>
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
                @enderror
            </label>

            <input type="hidden" name="equipamento" id="equipamento" value="{{ $exibir->first()->equipamento }}">

            <div class="container-buttons">
                <button type="submit">Devolver</button>
                <a href="{{ route('homepage')}}"><button type="button" id="btn-cancelar">Cancelar</button></a>
            </div>
        </form>

        <section class="table-container">

            <h1>Informações de uso</h1>

            <table>
                <thead>
                    <tr>
                        <th>Equipamento</th>
                        <th>Colaborador</th>
                        <th>Entregue por</th>
                        <th>Entregue em</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exibir as $exibe)
                    <tr>
                        <td>{{$exibe->equipamento}}</td>
                        <td>{{$exibe->colaborador}}</td>
                        <td>{{$exibe->agente_entrega}}</td>
                        <td>{{\Carbon\Carbon::parse($exibe->data_entrega)->format('d/m/Y - H:i')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </article>
    @include('layouts.rodape')
</section>
@endsection
