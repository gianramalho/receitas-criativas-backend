<?php

namespace App\Http\Middleware;

use App\Models\Device;
use Closure;
use Illuminate\Http\Request;

class VerifyDeviceExistsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $deviceId = $request->header('X-Device-Name');

        if (empty($deviceId)) {
            return response()->json(['error' => 'Erro! Entre em contato com o administrador para obter mais informações.'], 400);
        }

        $device = Device::where('name', $deviceId)->first();

        if (!$device) {
            $device = new Device();
            $device->name = $deviceId;
            $device->save();
        }
        
        return $next($request);
    }
}
