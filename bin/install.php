<?php
define("ROOT_PATH", dirname(dirname(dirname(dirname(__DIR__)))) . DIRECTORY_SEPARATOR);
define("APP_PATH", dirname(dirname(dirname(dirname(__DIR__)))) . DIRECTORY_SEPARATOR . "App" . DIRECTORY_SEPARATOR);
define("SRC_PATH", (dirname(__DIR__)) . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR);

//Update composer.json

$composer = json_decode(file_get_contents(ROOT_PATH . "composer.json"), true);
$composer['autoload']['psr-4']["App\\"] = "App" . DIRECTORY_SEPARATOR;
$composer['require']["noahbuscher/macaw"] = "dev-master";
$composer['require']["twig/twig"] = "^2.0";
$composer['require']["symfony/cache"] = "*";

file_put_contents(ROOT_PATH . "composer.json", json_encode($composer));


//Create dirs structures
$dirs = [
    "App" => [
        "Views",
        "Models",
        "Controllers",
        "Core",
        "Data",
        "Traits"
    ],
    "Cache"=>[],
    "public" => [
        "images",
        "js",
        "css"
    ]
];

foreach ($dirs as $dir => $subdirs) {
    $dir = ROOT_PATH . $dir . DIRECTORY_SEPARATOR;
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    foreach ($subdirs as $subdir) {
        if (!file_exists($dir . $subdir)) {
            mkdir($dir . $subdir, 0777, true);
        }
    }
}


//Create .htaccess

file_put_contents(ROOT_PATH . "public" . DIRECTORY_SEPARATOR . ".htaccess", <<<HTACCESS
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
    [SRC_PATH . "Application.php", APP_PATH . "Core" . DIRECTORY_SEPARATOR . "Application.php"],
    [SRC_PATH . "Config.php", APP_PATH . "Data" . DIRECTORY_SEPARATOR . "Config.php"],
    [SRC_PATH . "ConfigLocal.php", APP_PATH . "Data" . DIRECTORY_SEPARATOR . "ConfigLocal.php"],
    [SRC_PATH . "Router.php", APP_PATH . "Data" . DIRECTORY_SEPARATOR . "Router.php"],
    [SRC_PATH . "loader.php", ROOT_PATH . "loader.php"],
    [SRC_PATH . "index.php", ROOT_PATH . "public" . DIRECTORY_SEPARATOR . "index.php"],
];

foreach ($to_copy as $row) {
    if (!copy($row[0], $row[1])) {
        echo "Cannot copy {$row[0]} to {$row[1]}\n";
    }
}