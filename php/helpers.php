<?php

if (!function_exists('dd')) {
    function dd($_) {
        die(var_dump($_));
    }
}