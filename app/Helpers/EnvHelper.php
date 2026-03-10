<?php

namespace App\Helpers;

class EnvHelper
{
    public static function setEnvValue($key, $value)
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath))
            return false;
        $env = file_get_contents($envPath);
        $keyPattern = "/^{$key}=.*$/m";
        $newLine = "{$key}={$value}";
        if (preg_match($keyPattern, $env)) {
            $env = preg_replace($keyPattern, $newLine, $env);
        } else {
            $env .= "\n{$newLine}";
        }
        file_put_contents($envPath, $env);
        return true;
    }

    public static function isExistKey($key)
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath))
            return false;
        $env = file_get_contents($envPath);
        $keyPattern = "/^{$key}=.*$/m";
        return preg_match($keyPattern, $env) === 1;
    }
}


// Update SESSION_LIFETIME in .env if app_session_lifetime is present
// if ($request->has('app_session_lifetime')) {
//     $lifetime = (int) $request->input('app_session_lifetime');
//     \App\Helpers\EnvHelper::setEnvValue('SESSION_LIFETIME', $lifetime);
// }

// \App\Helpers\EnvHelper::isExistKey("SESSION_LIFETIME");
