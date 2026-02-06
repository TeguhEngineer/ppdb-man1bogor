<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait HasActivityLog
{
    /**
     * Log activity to Laravel log
     */
    public static function logActivity(string $action, string $description, array $data = []): void
    {
        $user = auth()->user();
        
        $logData = [
            'user_id' => $user?->id,
            'user_name' => $user?->name,
            'user_email' => $user?->email,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ];

        if (!empty($data)) {
            $logData['data'] = $data;
        }

        Log::channel('stack')->info('Activity Log', $logData);
    }
}
