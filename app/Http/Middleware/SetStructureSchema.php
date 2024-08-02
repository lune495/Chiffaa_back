<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SetStructureSchema
{
    public function handle($request, Closure $next)
    {
        \Log::info("SetStructureSchema middleware triggered");
        $user = Auth::user();
        \Log::info("User: " . json_encode($user));

        if ($user && $user->structure) {
            $schemaName = $user->structure->schema_name;
            DB::statement("SET search_path TO {$schemaName}");
            \Log::info("Schema set to: " . $schemaName);
        }

        return $next($request);
    }
}