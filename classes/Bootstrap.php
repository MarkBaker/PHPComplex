<?php

include_once __DIR__ . '/Autoloader.php';

\Complex\Autoloader::Register();

$functionSrcFolder = __DIR__ . DIRECTORY_SEPARATOR .
             'src' . DIRECTORY_SEPARATOR .
             'functions' . DIRECTORY_SEPARATOR;

$operationSrcFolder = __DIR__ . DIRECTORY_SEPARATOR .
             'src' . DIRECTORY_SEPARATOR .
             'operations' . DIRECTORY_SEPARATOR;

$functionIterator = new FilesystemIterator($functionSrcFolder);
$functionFilter = new RegexIterator($functionIterator, '/^.*\.php$/');

foreach($functionFilter as $file) {
    include_once($functionSrcFolder . $file->getFilename());
}

$operationIterator = new FilesystemIterator($operationSrcFolder);
$operationFilter = new RegexIterator($operationIterator, '/^.*\.php$/');

foreach($operationFilter as $file) {
    include_once($operationSrcFolder . $file->getFilename());
}
