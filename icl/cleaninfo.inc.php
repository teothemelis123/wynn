<?php

function cleaninfo($str) {
    $str = str_replace("_", " ",$str);
    $str = str_replace("raw", "",$str);
    $str = str_replace("base", "",$str);
    $chars = str_split($str); 
    $word = "";
    foreach ($chars as $i => $char) {
        if ($i == 0) $char = strtoupper($char);
        else if ($char != ' ' && $char == strtoupper($char)) $word.=" ";
        $word.=$char;
    }
    $word = str_replace("Raw", '', $word);
    return ucwords($word);
}

