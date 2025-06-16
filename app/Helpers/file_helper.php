<?php

if (!function_exists('formatSizeUnits')) {
    /**
     * Formats bytes into human-readable file size (KB, MB, GB)
     * 
     * @param int $bytes File size in bytes
     * @return string Formatted size with unit
     */
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } else {
            return '0 bytes';
        }
    }
}