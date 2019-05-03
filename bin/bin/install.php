<?php
define("APP_PATH", dirname(dirname(dirname(dirname(__DIR__)))) . DIRECTORY_SEPARATOR);
define("SRC_PATH", (dirname(__DIR__)) . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR);

//Update composer.json

$composer = json_decode(file_get_contents(APP_PATH . "composer.json"), true);
$composer['autoload']['psr-4']["App\\"] = "App" . DIRECTORY_SEPARATOR;
$composer['require']["noahbuscher/macaw"] = "dev-master";

file_put_contents(APP_PATH . "composer.json", json_encode($composer));


//Create dirs structures
$dirs = [
    "App" => [
        "Views",
        "Models",
        "Controllers",
        "Core",
        "Traits"
    ],
    "public" => [
        "images",
        "js",
        "css"
    ]
];

foreach ($dirs as $dir => $subdirs) {
    $dir = APP_PATH . $dir . DIRECTORY_SEPARATOR;
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    foreach ($subdirs as $subdir) {
        mkdir($dir . $subdir, 0777, true);
    }
}


//Create .htaccess

file_put_contents(APP_PATH . "public" . DIRECTORY_SEPARATOR . ".htaccess", <<<HTACCESS
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
HTACCESS
);


echo <<<UPDATE


====================================
Run 
composer update
====================================


UPDATE;

$to_copy = [
    [SRC_PATH . "Application.php", APP_PATH . "core" . DIRECTORY_SEPARATOR . "Application.php"]
];
