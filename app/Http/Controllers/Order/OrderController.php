<?php

namespace App\Http\Controllers\Order;

use App\Model\p_cart;
use App\Model\p_detail;
use App\Model\p_orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    //生成订单
    public function index(){
        //计算金额
        $goods=p_cart::where(['uid'=>Auth::id()],['session_id'=>Session::getId()])->get()->toArray();
//        var_dump($goods);
        $goods_price=0;
        foreach ($goods as $k=>$v){
            $goods_price+=$v['goods_price'];
        }
        //加入订单表
        $addorder=[
          'uid'=>Auth::id(),//用户id
            'order_amount'=>$goods_price,
            'add_time'=>time(),
            'order_sn'=>md5(rand(111,999)),
        ];
        $ordersInfo=p_orders::insertGetId($addorder); //写入订单表
        //加入订单详情表

        foreach($goods as $k=>$v){
            $adddetail=[
                'order_id'=>$ordersInfo,
                'uid'=>Auth::id(),
                'goods_name'=>$v['goods_name'],
                'goods_price'=>$v['goods_price'],
            ];
//            var_dump($adddetail);
        }
        $orderdetail=p_detail::insertGetId($adddetail);
    }

    //订单列表
    public function olist(){
        $orderInfo=p_orders::where(['uid'=>Auth::id()])->get()->toArray();
//    var_dump($orderInfo);
        $data=[
            'orderInfo'=>$orderInfo
        ];
        return view('order/orderlist',$data);
    }
}
