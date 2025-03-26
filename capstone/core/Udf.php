<?php

class Udf
{
    public static function removeKeysArray($array, $keysToRemove)
    {
        foreach ($keysToRemove as $key) {
            $index = array_search($key, $array);
            if ($index !== false) {
                unset($array[$index]);
            }
        }
        return $array;
    }
}
