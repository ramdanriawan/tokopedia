<?php

function toIdTime(String $date): String
{

    return date('d-M-Y, H:i:s', strtotime($date)) . " WIB";
}

function toIdr(int $number): String
{
    
    return "Rp" . number_format($number, 0, ",", ".");
}
