@extends('layouts.content')

@section('content')
    @include('layouts.menu-lateral')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / <a href="{{ route('cadastros') }}">Cadastros</a> / Departamentos</h1>
            <i class="fa-solid fa-map-location-dot"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="createDepartamento">
                @csrf

                <h1>Cadastro de departamento</h1>

                <label for="departamento"><p>Departamento<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-briefcase"></i>
                        <input type="text" name="departamento" id="departamento" placeholder="Complete com o nome do departamento" value="{{ old('departamento') }}">
                    </div>
                    @error('departamento')
                        <p id="input-error">{{ $message }}</p>
                    @enderror
                </label>

                <div class="container-buttons">
                    <button type="submit">Cadastrar</button>
                    <a href="{{ route('cadastros')}}"><button type="button" id="btn-cancelar">Cancelar</button></a>
                </div>

            </form>

            <section class="table-container">

                <h1>Gerenciamento de departamentos</h1>

                <table class="DataTable">
                    <thead>
                        <tr>
                            <th>ID site</th>
                            <th>Departamento</th>
                            <th>Cadastrado por</th>
                            <th>Data cadastro</th>
                            <th>Gerenciar</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($exibir as $exibe)
                            <tr>
                                <td>{{ $exibe->id }}</td>
                                <td>{{ $exibe->departamento }}</td>
                                <td>{{ $exibe->created_by }}</td>
                                <td>{{ date_format($exibe->created_at, 'd/m/Y - H:i') }}</td>
                                <td>
                                    <a href="update-departamento/{{Crypt::encrypt($exibe->id)}}"><i class="fa-solid fa-square-pen" id="btn-table-blue"></i></a>
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
