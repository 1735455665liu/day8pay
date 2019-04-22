<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class p_orders extends Model
{
    //
    protected $table="p_orders";
    public $timestamps = false;



    public static function getordersn(){

        $order_sn =md5(rand(111,999),time());
        return $order_sn;
    }
}
