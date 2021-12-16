<?php

spl_autoload_register(function($class) {
    if (strpos($class, 'ZxcvbnPhp\\') != 0) return false;
    include(
	__DIR__. DIRECTORY_SEPARATOR .
        str_replace(
            "\\", DIRECTORY_SEPARATOR,
            substr($class, 10)
        ).".php"
    );
});
