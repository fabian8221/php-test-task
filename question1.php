<?php
function printNestedArray($array, $prefix = '') {
    foreach ($array as $key => $value) {
        // Handle arrays

        if (is_array($value)) {
            // If numeric key, add index number to prefix
            if (is_numeric($key)) {
                echo $prefix . "Item " . ($key + 1) . ":\n";
            } else {
                echo $prefix . $key . ":\n";
            }
            // Recursively print nested array with increased indentation
            printNestedArray($value, $prefix . "    ");
        } 
        // Handle non-array values
        else {
            // Convert null, boolean, and other types to readable strings
            if (is_null($value)) {
                $value = 'null';
            } elseif (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }
            echo $prefix . $key . ": " . $value . "\n";
        }
    }
}