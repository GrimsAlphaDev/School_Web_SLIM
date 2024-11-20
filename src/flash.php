<?php


function setFlash($type, $message)
{
    if (!isset($_SESSION['__flash_messages'])) {
        $_SESSION['__flash_messages'] = [];
    }
    
    if (!isset($_SESSION['__flash_messages'][$type])) {
        $_SESSION['__flash_messages'][$type] = [];
    }
    
    $_SESSION['__flash_messages'][$type][] = $message;
}

function hasFlash($type = null)
{
    $flashMessages = $_SESSION['__flash_messages'] ?? [];
    
    if ($type === null) {
        return !empty($flashMessages);
    }
    
    return isset($flashMessages[$type]) && !empty($flashMessages[$type]);
}