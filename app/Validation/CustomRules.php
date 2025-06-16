<?php

namespace App\Validation;

use Config\Services;

class CustomRules
{
    /**
     * Checks if a password is strong enough
     * 
     * Requires at least:
     * - One number
     * - One letter
     * - Either one uppercase letter or one special character
     */
    public function strong_password(string $str, string &$error = null): bool
    {
        if (preg_match('#[0-9]#', $str) && 
            preg_match('#[a-zA-Z]#', $str) && 
            (preg_match('#[A-Z]#', $str) || preg_match('#[\W]#', $str))) {
            return true;
        }

        $error = 'Password must contain at least one number, one letter, and one uppercase or special character';
        return false;
    }
}