<?php

namespace Bank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use InvalidArgumentException;

class ApiController extends Controller
{
    private static array $allowedKeys = [
        'BUGSNAG_API_KEY_JS'
    ];

    /**
     * Get an Env key
     *
     * @param  Request  $request
     * @param $key
     *
     * @return InvalidArgumentException|string
     */
    public static function getKey(Request $request): mixed
    {
        $key = $request->get('key');
        $keyExists = preg_match('/^[A-Z_]+$/', $key);
        if ($keyExists) {
            if (in_array($key, self::$allowedKeys)) {
                $return = env($key);
            } else {
                $return = new InvalidArgumentException('You do not have access to this key');
            }
        } else {
            $return = new InvalidArgumentException('Key not recognised');
        }

        return $return;
    }
}
