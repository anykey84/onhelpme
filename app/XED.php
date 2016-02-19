<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XED extends Model
{
    public static function encrypt($string, $secret, $key = null) {
        $string = mt_rand() . ':' . $string . ':' . mt_rand();
        $key = $key ? $key : $secret;
        for($i = 0; $i < strlen($string); $i++) {
            $k = $key . substr($string, $i + 1) . ($i + 1) . "";
            for($j = 0; $j < strlen($k); $j++)
                $string[$i] = $string[$i] ^ $k[$j];
        }
        return self::base64encode($string);
    }
    public static function decrypt($string, $secret, $key = null) {
        $key = $key ? $key : $secret;
        $string = self::base64decode($string);
        for($i = strlen($string) - 1; $i >= 0; $i--) {
            $k = $key . substr($string, $i + 1) . ($i + 1) . "";
            for($j = 0; $j < strlen($k); $j++)
                $string[$i] = $string[$i] ^ $k[$j];
        }
        return preg_replace('~(^\d+:|:\d+$)~', '', $string);
    }
    private static function base64encode($data) { // URL
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    private static function base64decode($data) { // URL
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}
