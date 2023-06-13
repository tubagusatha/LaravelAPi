<?php

namespace App\Http\Middleware;

use App\Models\Comments;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikComments
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id_komentator = Comments::findOrFail($request->id);
        $user = Auth::user();

        if ($id_komentator->users_id != $user->id) {
            return response()->json('kamu bukan pemilik Komen ini');
        }

        return $next($request);
    }
}
