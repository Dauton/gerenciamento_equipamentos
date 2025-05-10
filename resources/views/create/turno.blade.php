@extends('layouts.content')

@section('content')
    @include('layouts.menu-lateral')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / <a href="{{ route('cadastros') }}">Cadastros</a> / Turnos</h1>
            <i class="fa-solid fa-business-time"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="createTurno">
                @csrf

                <h1>Cadastro de turno</h1>

                <label for="turno"><p>Turno<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-business-time"></i>
                        <input type="text" name="turno" id="turno" placeholder="Complete com a descrição do turno" value="{{ old('turno') }}">
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
                    <button type="submit">Cadastrar</button>
                    <a href="{{ route('cadastros')}}"><button type="button" id="btn-cancelar">Cancelar</button></a>
                </div>

            </form>

            <section class="table-container">

                <h1>Gerenciamento de turnos</h1>

                <table class="DataTable">
                    <thead>
                        <tr>
                            <th>ID turno</th>
                            <th>Turno</th>
                            <th>Cadastrado por</th>
                            <th>Data cadastro</th>
                            <th>Gerenciar</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($exibir as $exibe)
                            <tr>
                                <td>{{ $exibe->id }}</td>
                                <td>{{ $exibe->turno }}</td>
                                <td>{{ $exibe->created_by }}</td>
                                <td>{{ date_format($exibe->created_at, 'd/m/Y - H:i') }}</td>
                                <td>
                                    <a href="{{route("update-turno", Crypt::encrypt($exibe->id))}}"><i class="fa-solid fa-square-pen" id="btn-table-blue"></i></a>
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
