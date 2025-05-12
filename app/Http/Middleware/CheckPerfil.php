<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPerfil
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // BLOQUEIA ACESSO AS PÁGINAS CASO O PERFIL DO USUÁRIO LOGADO SEJA IGUAL A 'OPERAÇÃO'
        if(session('usuario.perfil') === 'OPERAÇÃO') {
            return redirect(route('homepage'))->with('alertError', 'Ops! você não tem premissão para acessar essa página ou realizar essa tarefa.');
        }

        return $next($request);
    }
}
