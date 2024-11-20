<?php

// Fungsi Utilitas Session
function setSession($key, $value)
{
    $_SESSION[$key] = $value;
}

function getSession($key, $default = null)
{
    return $_SESSION[$key] ?? $default;
}

function removeSession($key)
{
    unset($_SESSION[$key]);
}

function destroySession()
{
    session_unset();
    session_destroy();
}
