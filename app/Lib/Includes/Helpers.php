<?php


function strError($errno)
{
    return array_flip(array_slice(get_defined_constants(true)['Core'], 0, 16, true))[$errno];
}