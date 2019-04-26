<?php

namespace App\Http\Controllers\Order;

use App\Model\p_cart;
use App\Model\p_detail;
use App\Model\p_orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
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
        $key="token";

        $data=[
            'orderInfo'=>$orderInfo,
        ];

        return view('order/orderlist',$data);
    }

//    订单状态
    public function orderstatus()
    {
        $oid = intval($_GET['oid']);
        $info = p_orders::where(['oid'=>$oid])->first();
        $response = [];
        if($info){
            if($info->pay_time>0){      //已支付
                $response = [
                    'status'    => 0,       // 0 已支付
                    'msg'       => 'ok'
                ];
            }
            //echo '<pre>';print_r($info->toArray());echo '</pre>';
        }else{
            die("订单不存在");
        }
        die(json_encode($response));


    }

<<<<<<< HEAD

    public function scorce(){
        $key='ss:goods:view';
//        $lista=Redis::zRangeByScore($key,0,10000,['withscores'=>true]);  //正序
//        echo '<pre>';print_r($lista);echo '<pre>';
//        $listb=Redis::zRevRange($key,0,10000,true   );//降序
//        echo '<pre>';print_r($listb);echo '<pre>';
        $liuziye1='liuziye1';
        $liuziye2='liuziye2';
        $liuziye3='liuziye3';
        $liuziye4='liuziye4';

        Redis::zadd($key,222,$liuziye1);
        Redis::zadd($key,333,$liuziye2);
        Redis::zadd($key,6666,$liuziye3);
        Redis::zadd($key,888,$liuziye4);

        $lisr= Redis::zSize($key);
        echo '<pre>';print_r($lisr);echo '<pre>';





    }



    public function detail(){
        $dete=p_detail::where(['uid'=>Auth::id()])->get()->toArray();
        echo '<pre>';print_r($dete);echo'<pre>';
        $incr=Redis::incr();






    }
=======
>>>>>>> liuziye
}
