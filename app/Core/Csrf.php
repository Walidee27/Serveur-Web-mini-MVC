<?php

namespace Mini\Core;

class Csrf
{
    /**
     * Generate a new CSRF token and store it in the session.
     * If a token already exists, it returns the existing one.
     */
    public static function generateToken()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Get the current CSRF token.
     */
    public static function getToken()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['csrf_token'] ?? self::generateToken();
    }

    /**
     * Validate the provided token against the session token.
     */
    public static function validateToken($token)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['csrf_token']) || !is_string($token)) {
            return false;
        }

        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Render a hidden input field with the CSRF token.
     */
    public static function renderInput()
    {
        $token = self::getToken();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }
}
