@php
    use \App\Http\Controllers\ComponentesControllers\SapiensController;
@endphp

<div id="back-menu"></div>
<nav class="menu-lateral">
    <div class="usuario-info">
        <i class="fa-solid fa-circle-user"></i>
        <h2>Bem vindo(a)!</h2>
        <p>{{ session('usuario.nome') }}</p>

        @if (
                session('usuario.perfil') === 'ADMIN' ||
                session('usuario.perfil') === 'TI SITES'
            )
            <form method="post" action="{{route('alterarSite')}}">
                @csrf
                <select name="site" id="site" class="select2">
                    <option value="{{session('usuario.site')}}">Exibindo {{session('usuario.site')}}</option>
                    @php
                        $sites = SapiensController::listaSites()
                    @endphp
                    @foreach ($sites as $site)
                        <option value="{{ $site['usu_nomfil'] }}" {{ old('site') == $site['usu_nomfil'] ? 'selected' : '' }}>{{ $site['usu_nomfil'] }}</option>
                    @endforeach
                </select>
                @error('site')
                    <p id="input-error">{{ $message }}</p>
                    <style>
                        label[for='site'] i {
                            background: #b90000
                        }
                    </style>
                @enderror

                <button type="submit">Alternar site</button>

            </form>
        @else
            <p>{{ session('usuario.site') }}</p>
        @endif

    </div>
    <ul>
        @if (session('usuario.perfil') === 'OPERAÇÃO')
            <li><a href="{{ route('homepage') }}"><i class="fa-solid fa-handshake"></i>Entregar / Devolver</a></li>
            <li><a href="{{ route('relatorios-temporarias') }}"><i class="fa-solid fa-magnifying-glass"></i>Relatórios</a></li>
        @elseif(session('usuario.perfil') !== 'OPERAÇÃO')
            <li class="menu-active-drop-01"><a><i class="fa-solid fa-handshake"></i>Entregar / Devolver</a></li>
            <ol class="menu-dropdown-01">
                <li><a href="{{ route('homepage') }}"><i class="fa-solid fa-handshake"></i>Entrega temporária</a></li>
                <li><a href="{{ route('entrega-permanente') }}"><i class="fa-solid fa-handshake"></i>Entrega
                        permanente</a></li>
            </ol>

            <li class="menu-active-drop-02"><a><i class="fa-solid fa-magnifying-glass"></i>Relatórios</a></li>
            <ol class="menu-dropdown-02">
                <li><a href="{{ route('relatorios-temporarias') }}"><i class="fa-solid fa-hourglass-half"></i>Entregas temporárias</a></li>
                <li><a href="{{ route('relatorios-permanentes') }}"><i class="fa-solid fa-calendar-days"></i>Entregas permanentes</a></li>
            </ol>
            <li><a href="{{ route('cadastros') }}"><i class="fa-solid fa-database"></i>Cadastros</a></li>
        @endif

        <li><a href="{{ route('edit-senha', Crypt::encrypt(session('usuario.id'))) }}"><i
                    class="fa-solid fa-key"></i>Minha senha</a></li>
        <hr>
        <li><a href="{{ route('logout', Crypt::encrypt(session('usuario.id'))) }}"><i
                    class="fa-solid fa-right-from-bracket"></i>Sair</a></li>
    </ul>
    <div class="bottom-menu">
        <img src="{{ asset('assets/img/id-logo-branco-extenso.png') }}" alt="logo-idl">
        <p>{{ now()->format('d/m/Y') }}
    </div>
</nav>
