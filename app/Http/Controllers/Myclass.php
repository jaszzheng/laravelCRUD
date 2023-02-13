<?php

namespace App\Http\Controllers;

use Run;
use Swim;

class Myclass implements run, Swim
{
    public function run()
    {
        echo "running!!";
    }

    public function swim()
    {
        echo "swimming!!";
    }
}
