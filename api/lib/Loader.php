<?php

spl_autoload_register(function ($className) {

    $array_paths = array(
        '/models/',
        '/lib/',
    );

    foreach ($array_paths as $path) {
        $file = ROOT . $path . $className . '.php';
        if (file_exists($file)) {
            include_once($file);
        }
    }
});
