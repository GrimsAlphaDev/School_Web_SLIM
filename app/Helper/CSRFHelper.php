<?php

function csrf_field()
{
    $token = $_SESSION['csrf_token'] ?? null;
    return "<input type='hidden' name='_token' value='$token'>";
}

function csrf_token()
{
    return $_SESSION['csrf_token'] ?? null;
}