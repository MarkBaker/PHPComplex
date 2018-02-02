<?php

include_once __DIR__ . '/Autoloader.php';

\Complex\Autoloader::Register();

$srcFolder = __DIR__ . DIRECTORY_SEPARATOR .
             'src' . DIRECTORY_SEPARATOR .
             'functions' . DIRECTORY_SEPARATOR;

$iterator = new FilesystemIterator($srcFolder);
$filter = new RegexIterator($iterator, '/^.*\.php$/');

foreach ($filter as $file) {
    include_once($srcFolder . $file->getFilename());
}
