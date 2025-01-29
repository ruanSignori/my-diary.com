<?php

namespace App\Services;

class StatusService
{
    public function getServerStatus(): array
    {
        return [
            'version' => phpversion(),
            'timezone' => date_default_timezone_get(),
            'current_timestamp' => date('Y-m-d H:i:s'),
        ];
    }
}
