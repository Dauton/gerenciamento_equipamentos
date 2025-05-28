@extends('layouts.content')

@section('content')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / <a href="{{ route('cadastros') }}">Cadastros</a> / Avarias</h1>
            <i class="fa-solid fa-burst"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="{{ route('createAvaria') }}">
                @csrf

                <h1>Cadastro de avaria</h1>

                <label for="avaria"><p>Avaria<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-burst"></i>
                        <input type="text" name="avaria" id="avaria" placeholder="Complete com a descrição da avaria" value="{{ old('avaria') }}">
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

                <label for="avaria"><p>Tipo da varia<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-burst"></i>
                        <select name="tipo_avaria" id="tipo_avaria" class="select2">
                            <option value="" @selected(!old('tipo_avaria'))>Selecione o tipo da avaria</option>
                            <option value="Sistêmico (Software)" @selected(old('tipo_avaria') == 'Sistêmico (Software)')>Sistêmico (Software)</option>
                            <option value="Físico (Hardware)" @selected(old('tipo_avaria') == 'Físico (Hardware)')>Físico (Hardware)</option>
                        </select>
                    </div>
                    @error('tipo_avaria')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='tipo_avaria'] i {
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

                <h1>Gerenciamento de avarias</h1>

                <table class="DataTable">
                    <thead>
                        <tr>
                            <th>ID avaria</th>
                            <th>Avaria</th>
                            <th>Tipo da avaria</th>
                            <th>Data cadastro</th>
                            <th>Gerenciar</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($exibir as $exibe)
                            <tr>
                                <td>{{ $exibe->id }}</td>
                                <td>{{ $exibe->avaria }}</td>
                                <td>{{ $exibe->tipo_avaria }}</td>
                                <td>{{ date_format($exibe->created_at, 'd/m/Y - H:i') }}</td>
                                <td>
                                    <a href="{{route("edit-avaria", Crypt::encrypt($exibe->id))}}"><i class="fa-solid fa-square-pen" id="btn-table-blue"></i></a>
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
