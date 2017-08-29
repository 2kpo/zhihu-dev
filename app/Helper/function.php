<?php
if (!function_exists('user')){
    function user($driver = null)
    {
        if ($driver) {
            return Auth::guard($driver)->user();

        }
        return Auth::user();
    }
}