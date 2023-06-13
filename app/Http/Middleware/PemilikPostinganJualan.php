<?php

namespace App\Http\Middleware;

use App\Models\posts;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikPostinganJualan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id_penjual = posts::findOrFail($request->id);
        $user = Auth::user();
        
        if($id_penjual->penjual != $user->id ) {
            return response()->json('kamu bukan Penjualnya');
        }

        return $next($request);
    }
}
