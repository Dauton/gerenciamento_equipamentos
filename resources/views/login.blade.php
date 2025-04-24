@extends('layouts.content')

@section('content')
<section class="container-login">
    <form method="post" action="{{ route('submitLogin') }}" id="login-form">
        @csrf

        <img src="{{ asset('assets/img/id-logo-extenso.png') }}" alt="logo-idl">

        <label for='usuario'>Usuário
            <div>
                <i class="fa-solid fa-user"></i>
                <input type="text" name="usuario" id="usuario" placeholder="Seu usuário" value="{{ old('usuario') }}">
            </div>
            @error('usuario')
                <p id="input-error">{{ $message }}</p>
            @enderror
        </label>
        <label for='senha'>Senha
            <div>
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="senha" id="senha" placeholder="Sua senha" value="{{ old('senha') }}">
            </div>
            @error('senha')
                <p id="input-error">{{ $message }}</p>
            @enderror
        </label>

        <div class="container-buttons">
            <button>Entrar</button>
        </div>

        @if (session('loginError'))
            <p class="login-error">
                {{ session('loginError') }}
            </p>
        @endif

    </form>
    @include('layouts.rodape')
</section>
@endsection
