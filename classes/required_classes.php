<?php
/*
 * @version $Id:  $
 *
 */

spl_autoload_register(function ($class) {
    $parts = explode('\\', $class, 2);
    if ($parts[0] == 'Cnc') {
        include_once __DIR__ . '/' . $parts[1] . '.php';
    }
});