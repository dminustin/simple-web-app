<?php

namespace App\Data;

use \NoahBuscher\Macaw\Macaw;

class Router
{

    public function __construct()
    {
        Macaw::get('/', function() {
            echo 'Hello world!';
        });

        Macaw::dispatch();
    }


}