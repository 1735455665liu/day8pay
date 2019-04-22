<?php

namespace App\Http\Controllers\redis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\p_goods;
use Illuminate\Support\Facades\Redis;
class RedisController extends Controller
{
    //浏览量
    public function index($goods_id=0){
        $goods_id=intval($goods_id);
        $goodsInfo=p_goods::where(['id'=>$goods_id])->get()->toArray();
        $key="redis:aa";
        var_dump($key);
        $arr=Redis::set($key,$goodsInfo);    //设置缓存  存入其中
        $incr=Redis::incr($arr,10);
        $data=[
            'incr'=>$incr, //浏览数量
            'goods_id'=>$goods_id //商品id
        ];


    return  view('redis.redis',$data);
    }



    //有序列表
    public function callAll($goods_id=0){
        $goods_id=intval($goods_id);
        $key='goods_all';
        $hgetall=Redis::HGetAll($key);
        if($hgetall){
                echo "Cache";
                echo '<pre>';print_r($hgetall);echo '<pre>';
        }else{
            echo "NoCache";
            $goodsInfo=p_goods::where(['id'=>$goods_id])->first()->toArray();
//            echo '<pre>';print_r($goodsInfo);echo '<pre>';
            Redis::hMset($key,$hgetall);
        }



        return view('redis.redisAll');
    }


//    //排序
//    public function getstor(){
//        $key="1";
//        $aaa=Redis::zAdd($key="1");
//        var_dump($aaa);die;
//        $annge=Redis::zRangeByScore($key,0-100000,['withscores'=>true]);
//        echo '<pre>';print_r($annge);echo '<pre>';
//
//
//    }
}
