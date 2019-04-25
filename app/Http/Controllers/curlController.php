<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\p_orders;
class curlController extends Controller
{
    //
    //定时删除订单
    public function curl(){
        $order=p_orders::all();//获取订单表数据
        $arr=$order->toArray();
        echo '<pre>';print_r($arr);echo '<pre>';
        foreach ($arr as $k=>$v){
            if(time()-$v['add_time'] >1800 && $v['pay_time']==0){
                p_orders::where(['oid'=>$v['oid']])->update(['is_delete'=>1]);
            }
        }
    }
}
