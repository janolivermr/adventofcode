<?php

if (!function_exists('dd')) {
    function dd($_) {
        die(var_dump($_));
    }
}

if (!function_exists('echo_dbg')) {
    function echo_dbg(string $message, $level = 8) {
        if (intval(getenv('ECHO_LVL')) > $level) {
            echo $message;
        }
    }
}