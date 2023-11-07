<?php

    namespace Utils;
    function slashReplacer($subject): string {
        return str_replace('\\', '/', $subject);
    }

    function encrypt($pass): string {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    function slashReplacerB($subject): string {
        return str_replace('/', '\\', $subject);
    }
    function createMarkers() {}
    function debugger($var) {
        echo('<pre>');
        var_dump($var);
        echo('<pre>');
    }