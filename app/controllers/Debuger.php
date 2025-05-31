<?php

class Debuger
{
    public static function show($data)
    {
        echo '<div style="color:black; background:#f5f5f5;border:1px solid #ccc;padding:10px;border-radius:5px;font-family:monospace;">';
        echo '<pre style="margin:0;">';
        var_dump($data);
        echo '</pre>';
        echo '</div>';
    }

    public static function showWithExit($data)
    {
        echo '<div style="color:black;background:#f5f5f5;border:1px solid #ccc;padding:10px;border-radius:5px;font-family:monospace;">';
        echo '<pre style="margin:0;">';
        var_dump($data);
        echo '</pre>';
        echo '</div>';
        exit;
    }
}
