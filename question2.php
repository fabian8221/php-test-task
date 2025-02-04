<?php
function sortNestedArray($array, $sortKeys) {
    // If not an array or empty array, return as is
    if (!is_array($array) || empty($array)) {
        return $array;
    }

    // Recursively sort nested arrays first
    foreach ($array as &$value) {
        if (is_array($value)) {
            $value = sortNestedArray($value, $sortKeys);
        }
    }
    unset($value); // Break the reference

    // Sort current level if it's a numeric-indexed array
    if (array_keys($array) === range(0, count($array) - 1)) {
        usort($array, function($a, $b) use ($sortKeys) {
            foreach ($sortKeys as $key) {
                $valueA = findValue($a, $key);
                $valueB = findValue($b, $key);
                
                // Skip if both values are null or not found
                if ($valueA === null && $valueB === null) {
                    continue;
                }
                
                // Handle null values (null should come last)
                if ($valueA === null) return 1;
                if ($valueB === null) return -1;
                
                if ($valueA != $valueB) {
                    return $valueA <=> $valueB;
                }
            }
            return 0;
        });
    }

    return $array;
}

function findValue($array, $key) {
    // If this is not an array, return null
    if (!is_array($array)) {
        return null;
    }

    // If the key exists at this level, return its value
    if (array_key_exists($key, $array)) {
        return $array[$key];
    }

    // Search in nested arrays
    foreach ($array as $value) {
        if (is_array($value)) {
            $result = findValue($value, $key);
            if ($result !== null) {
                return $result;
            }
        }
    }

    return null;
}

