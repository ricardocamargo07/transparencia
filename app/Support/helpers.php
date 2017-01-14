<?php

function array_utf8_encode($dat)
{
    if (is_string($dat)) {
        return utf8_encode($dat);
    }

    if (!is_array($dat)) {
        return $dat;
    }

    $ret = array();

    foreach ($dat as $i => $d) {
        $ret[$i] = array_utf8_encode($d);
    }

    return $ret;
}
