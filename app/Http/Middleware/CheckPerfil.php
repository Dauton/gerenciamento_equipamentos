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

        if(session('usuario.perfil') !== 'ADMIN') {
            return redirect('homepage')->with('alertError', 'Ops! você não tem premissão para acessar essa página ou realizar essa tarefa.');
        }

        return $next($request);
    }
}
