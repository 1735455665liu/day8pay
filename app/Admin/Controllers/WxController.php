<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
class WxController extends Controller
{
    //建立连接
    public function valid(){
        echo $_GET['echostr'];
    }

    public function Wxevent(){



    }

}
?>