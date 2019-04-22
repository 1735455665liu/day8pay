<?php

namespace App\Http\Controllers;

use App\Model\p_cart;
use App\Model\p_goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class CarController extends Controller
{
    //购物车页面
        public function index(){
            //查询购物车表中Uid和sessionid
            $cartInfo=p_cart::where(['id'=>Auth::id()],['session_id'=>Session::getId()])->get();
            //判断是否有数据
            if($cartInfo){               //有
                $arrcart=$cartInfo->toArray();
                //设定总价格
                $price=0;
                //foreach循环
                foreach ($arrcart as $k=>$v){
                    //查询goods里id和cartgoods_id
                    $goodsInfo=p_goods::where(['id'=>$v['goods_id']])->first()->toArray();
                     //设定的总价格+=
                    $price+=$goodsInfo['price'];
                    $goodlist[]=$goodsInfo;
                }
                //展示购物车
                $data = [
                    'goods_list' => $goodlist,
                    'total'     => $price
                ];
                //返回视图
                return view('cart.cart',$data);
            }else{
                //没有
//                提示并跳转到首页
                header('Refresh:3;url=/');
                die("购物车为空,跳转至首页");

            }

        }

        //添加购物车
    public function cartadd($goods_id=0)
    {
        //判断$goods_id是否为空
        if (empty($goods_id)) {
            header('Refresh:3;url=/');
            die('没有此商品');
        }
        $goodsInfo=p_goods::where(['id'=>$goods_id])->first();
//        var_dump($goodsInfo);
        //判断商品是否存在
        if($goodsInfo){
            //判断被下架的商品
            if($goodsInfo->is_delete=='1'){
                header('Refresh:3;url=/cart');
                die('此商品已下架');
            }
            //添加入库并跳转提示
            $add=[
                'goods_id'=>$goods_id,
                'goods_name'=>$goodsInfo->name,
                'goods_price'=>$goodsInfo->price,
                'uid'=>Auth::id(),
                'session_id'=>Session::getId(),
                'add_time'=>time()
            ];
            $addInfo=p_cart::insertGetId($add);
            if($addInfo){
                header('Refresh:3;url=/index');
                echo "添加成功";

            }else{
                header('Refresh:3;url=/cart');
                die('添加购物车失败');
            }
        }else{
            //不存在跳到首页
            echo '商品不存在';

        }


    }
}
