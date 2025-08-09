<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Evaluasi;
use Symfony\Component\HttpFoundation\Response;

class EvaluasiOwnerMiddleware
{
     /**
      * Handle an incoming request.
      *
      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
      */
     public function handle(Request $request, Closure $next): Response
     {
          $evaluasiId = $request->route('evaluasi');

          if ($evaluasiId) {
               $evaluasi = Evaluasi::find($evaluasiId);

               if (!$evaluasi) {
                    abort(404, 'Evaluasi tidak ditemukan.');
               }

               // Jika user adalah pegawai, pastikan hanya bisa akses evaluasi miliknya
               if (auth()->user()->isPegawai() && $evaluasi->user_id !== auth()->id()) {
                    abort(403, 'Anda tidak memiliki akses ke evaluasi ini.');
               }
          }

          return $next($request);
     }
}
