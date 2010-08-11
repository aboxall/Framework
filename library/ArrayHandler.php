<?php
function is_assoc_array ($array)
{
    return (is_array($array) && (count($array) == 0 || 0 !== count(
    array_diff_key($array, array_keys(array_keys($array))))));
}
function isDimensional ($array)
{
    if (! is_array($array))
        trigger_error(
        'THE_PARSED_VALUES_ARE_NOT_ARRAY');
    else {
        $filter = array_filter($array, 
        'is_array');
        if (count($filter) > 0)
            return true;
    }
} 