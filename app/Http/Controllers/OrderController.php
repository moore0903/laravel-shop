<?php
/**
 * Created by PhpStorm.
 * User: hg
 * Date: 2017/4/17
 * Time: 17:17
 */

namespace App\Http\Controllers;


use App\Models\Address;
use App\Models\Comment;
use App\Models\Config;
use App\Models\Giftcode;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShopItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * 订单确认页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cartsubmitquick(Request $request){
        if(\Cart::count() <= 0){
            return \Redirect::intended('cart/list')->withInput()->withErrors(['msg' => '请重新下单']);
        }
        $address_list = Address::where('user_id', '=', \Auth::user()->id)->orderBy('created_at')->get();
        $now = date('Y-m-d H:i:s');
        $gift_list = Giftcode::where('user_id', '=', \Auth::user()->id)->where('start_time','<',$now)->where('end_time','>=',$now)->whereColumn('usecountmax','>','usecount')->get();
        $cart_list = [];
        $cartids = explode(',', $request['rowids']);
        foreach ($cartids as $cartid) {
            $cart_list[$cartid] = \Cart::get($cartid);
        }
        $dillCart = collect(\Cart::all())->diffKeys(collect($cart_list));
        foreach ($dillCart as $raw_id => $cart) {
            \Cart::remove($raw_id);
        }
        //物流费用
        $configs = \App\Models\Config::all();
        $post_price = $configs->where('key', 'post_price')->first();
        $include_postage = $configs->where('key', 'include_postage')->first();
        $since_address = $configs->where('key', 'since_address')->first();
        $since_realname = $configs->where('key', 'since_realname')->first();
        $since_phone = $configs->where('key', 'since_phone')->first();
        $postage = 0.00;
        if (!empty($post_price) && (empty($include_postage) || (!empty($include_postage) && \Cart::totalPrice() < $include_postage->value))) {
            $postage = $post_price->value;
        }
        return view('cartsubmitquick', [
            'address_list' => $address_list,
            'address' => $address_list->first(),
            'gift_list' => $gift_list,
            'cart_list' => \Cart::all(),
            'cart_count' => \Cart::count(),
            'cart_totalPrice' => \Cart::totalPrice(),
            'postage' => $postage,
            'since' => collect(['address' => $since_address->value??'', 'realname' => $since_realname->value??'', 'phone' => $since_phone->value??''])
        ]);
    }


    /**
     * 添加订单页面
     * @param Request $request
     * @return $this
     */
    public function addOrder(Request $request){

        if (\Cart::count() <= 0) return \Redirect::intended('cart/list')->withInput()->withErrors(['msg' => '由于长时间未操作,购物车已过期,请重新下单']);

        $orders = $shopItems = [];
        $total = \Cart::totalPrice();
        $discount = $get_total = 0;

        foreach (\Cart::all() as $cartitem) {
            if (!$cartitem) continue;
            $shopItem = ShopItem::find($cartitem->id);
            if (!$shopItem) continue;
            if ($shopItem->count <= 0 && $shopItem->show) return back()->withInput($request->toArray())->withErrors(['msg' => '商品[' . $shopItem->title . ']已下架或库存不足，不能购买！']);
            if ($shopItem->count < $cartitem->qty) return back()->withInput($request->toArray())->withErrors(['msg' => '商品[' . $shopItem->title . ']库存不足，不能购买！']);
            $detail = new OrderDetail([
                'shop_item_id' => $shopItem->id,
                'product_title' => $shopItem->title,
                'product_num' => $cartitem->qty,
                'thumbnail' => $shopItem->img,
                'product_price' => $shopItem->price,
                'shop_item_catalog' => $shopItem->catalog->title,
            ]);
            $get_total += $shopItem->price * $cartitem->qty;
            $details[] = $detail;
            $shopItems[$shopItem->id]['count'] = $shopItem->count - $cartitem->qty;
        }
        \Cart::destroy();

        $order = Order::create([
            'user_id' => \Auth::user()->id,
            'serial' => date('YmdHis') . str_random(6),
            'stat' => Order::STAT_NOTPAY,
            'remark' => $request['remark'],
            'giftcode_id' => !empty($gift) ? $gift->id : 0,
            'memo' => '',
            'paytype'=>Order::paytypeString($request['paytype']),
            'address' => \Auth::user()->address,
            'realname' => \Auth::user()->user_name,
            'phone' => \Auth::user()->phone,
        ]);

        foreach ($details as $detail) {
            $detail->order_id = $order->id;
        }


        $order->details()->saveMany($details);
        $order->total = $get_total;
        $order->discount = $get_total - $total;
        $order->totalpay = $total;

        if ($order->totalpay == 0) $order->stat = Order::STAT_PAYED;

        $order->save();

        return redirect('/order/list');
    }

    /**
     * 获取订单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orderList(Request $request){
        $stat = $request['stat'];
        if($stat){
            $stat = (int)$stat;
            $orderList = Order::where('user_id','=',\Auth::user()->id)->where('stat','=',$stat)->with('details')->orderBy('created_at','desc')->get();
        }else{
            $orderList = Order::where('user_id','=',\Auth::user()->id)->with('details')->orderBy('created_at','desc')->get();
        }
        return view('order_list',[
            'orders'=>$orderList,
            'stat'=>$stat
        ]);
    }

    public function orderDetail($id){
        $order = Order::find($id);
        return view('order_detail',[
            'order' => $order,
            'details' => $order->details
        ]);
    }

    /**
     * 收货
     * @param Request $request
     * @return array
     */
    public function confirmReceipt(Request $request){
        if(!\Auth::check()) return ['stat'=>0,'msg'=>'请先登录!'];
        $orderInfo = Order::find($request['id']);
        if(empty($orderInfo)) return ['stat'=>0,'msg'=>'找不到该订单'];
        $orderInfo->stat = Order::STAT_EVALUATE;
        $orderInfo->save();
        return ['stat'=>1,'msg'=>'已收货,请评价'];
    }

    public function confirmService(Request $request){
        if(!\Auth::check()) return ['stat'=>0,'msg'=>'请先登录!'];
        $orderInfo = Order::find($request['id']);
        if(empty($orderInfo)) return ['stat'=>0,'msg'=>'找不到该订单'];
        $orderInfo->stat = Order::STAT_SERVICE;
        $orderInfo->save();
        return ['stat'=>1,'msg'=>'已提交退货申请,请等待人员联系'];
    }

    /**
     * 评价
     * @param Request $request
     * @return array
     */
    public function evaluation(Request $request){
        if(!\Auth::check()) return back()->withInput($request->toArray())->withErrors(['msg' => '请先登录']);
        $orderDetailInfo = OrderDetail::with('order')->find($request['detail_id']);
        if(empty($orderDetailInfo)) return back()->withInput($request->toArray())->withErrors(['msg' => '找不到该订单']);
        if($orderDetailInfo->order->user_id != \Auth::user()->id)  return back()->withInput($request->toArray())->withErrors(['msg' => '请确认你购买过此商品']);
        if($request->method() == 'GET'){
            return view('order_evaluation',[
                'detail'=>$orderDetailInfo
            ]);
        }else{
            $comment = Comment::create([
                'user_id'=>\Auth::user()->id,
                'shop_item_id'=>$orderDetailInfo->shop_item_id,
                'content'=>$request['content'],
                'images'=>$request['images'],
                'star'=>$request['star'],
                'order_id'=>$orderDetailInfo->order->id,
                'order_detail_id'=>$request['detail_id']
            ]);
            if(!$comment) return back()->withInput($request->toArray())->withErrors(['msg' => '评价失败,请联系管理员!']);
            $order = Order::find($orderDetailInfo->order_id);
            if($order->evaluationStat()){
                $order->stat = Order::STAT_FINISH;
                $order->save();
            }

            return redirect('/order/list');
        }
    }

    /**
     * 取消订单
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function cancel(Request $request){
        if(!\Auth::check()) return back()->withInput($request->toArray())->withErrors(['msg' => '请先登录']);
        $order = Order::find($request['id']);
        if(empty($order)) return back()->withInput($request->toArray())->withErrors(['msg' => '找不到该订单']);
        $order->stat = Order::STAT_CANCEL;
        $order->save();
        return redirect('/order/list');
    }

}