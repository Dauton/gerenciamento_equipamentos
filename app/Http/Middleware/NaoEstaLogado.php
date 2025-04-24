<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NaoEstaLogado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // BLOQUEIA ACESSO SE NÃO ESTIVER LOGADO
        if(!session('usuario')) {
            return redirect('/')->with('loginError', 'Realize o login para acessar o sistema.');
        }

        return $next($request);
    }
}
