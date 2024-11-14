<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class DatabaseTransaction
{
    public function handle($request, Closure $next)
    {
        DB::beginTransaction();

        try {
            $response = $next($request);

            if ($response->getStatusCode() < 400) {
                DB::commit();
            } else {
                DB::rollBack();
            }

            return $response;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
