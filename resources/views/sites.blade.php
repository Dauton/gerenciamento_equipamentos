@extends('layouts.content')

@section('content')
    @include('layouts.menu-lateral')
    <section class="centro">
        <header class="cabecalho">
            <h1 class="cabecalho-title"><a href="{{ route('homepage') }}">Homepage</a> / <a href="{{ route('cadastros') }}">Cadastros</a> / Sites</h1>
            <i class="fa-solid fa-map-location-dot"></i>
        </header>
        <article class="conteudo">
            <form method="post" action="createSite">
                @csrf

                <h1>Cadastro de site</h1>

                <label for="descricao"><p>Descrição<span> *</span></p>
                    <div>
                        <i class="fa-solid fa-map-location-dot"></i>
                        <input type="text" name="descricao" id="descricao" placeholder="Complete com o nome do site" value="{{ old('descricao') }}">
                    </div>
                    @error('descricao')
                        <p id="input-error">{{ $message }}</p>
                        <style>
                            label[for='descricao'] i {
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

                <header class="container-cabecalho">
                    <h1>Gerenciamento de sites</h1>
                </header>

                <table class="DataTable">
                    <thead>
                        <tr>
                            <th>ID site</th>
                            <th>Descrição</th>
                            <th>Cadastrado por</th>
                            <th>Data cadastro</th>
                            <th>Gerenciar</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($exibir as $exibe)
                            <tr>
                                <td>{{ $exibe->id }}</td>
                                <td>{{ $exibe->descricao }}</td>
                                <td>{{ $exibe->created_by }}</td>
                                <td>{{ date_format($exibe->created_at, 'd/m/Y - H:i') }}</td>
                                <td>
                                    <a href="update-site/{{Crypt::encrypt($exibe->id)}}"><i class="fa-solid fa-square-pen" id="btn-table-blue"></i></a>
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
