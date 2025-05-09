<?php

namespace App\Http\Controllers;

use BcMath\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Number as SupportNumber;

class GHNController extends Controller
{
    //
    private $token;
    private $shopId;
    // protected $order;
    // protected $items;
    public function __construct($order=null, $items=null){
        $this->token = env('GHN_TOKEN');
        $this->shopId =  env('GHN_SHOP_ID');
        // $this->order = $order;
        // $this->items = $items;
    }
    public function createShippingOrder()
    {   
        // dd(env('GHN_TOKEN'));
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => $this->token, // Thay bằng token thực tế
            'ShopId' => $this->shopId   // Thay bằng ShopId thực tế
        ])->post('https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/create', [
            "payment_type_id"=> 2,
            "note"=> "Tôi Là DEV Web Tôi Đang Test Đơn Hàng Ảo - Không Giao Hàng Xin Cảm Ơn Nhiều Nhiều!",
            "required_note"=> "KHONGCHOXEMHANG",
            "from_name"=> "TinTest124",
            "from_phone"=> "0987654321",
            "from_address"=> "72 Thành Thái, Phường 14, Quận 10, Hồ Chí Minh, Vietnam",
            "from_ward_name"=> "Phường 14",
            "from_district_name"=> "Quận 10",
            "from_province_name"=> "HCM",
            "return_phone"=> "0332190444",
            "return_address"=> "39 NTT",
            "return_district_id"=> null,
            "return_ward_code"=> "",
            "client_order_code"=> "",
            "to_name"=> "TinTest124",
            "to_phone"=> "0987654321",
            "to_address"=> "72 Thành Thái, Phường 14, Quận 10, Hồ Chí Minh, Vietnam",
            "to_ward_code"=> "20308",
            "to_district_id"=> 1444,
            "cod_amount"=> 200000, 
            "content"=> "Theo New York Times",
            "weight"=> 200,
            "length"=> 1,
            "width"=> 19,
            "height"=> 10,
            "pick_station_id"=> 1444,
            "deliver_station_id"=> null,
            "insurance_value"=> 100000,
            "service_id"=> 0,
            "service_type_id"=>2,
            "coupon"=>null,
            "pick_shift"=>[2],
            'items' => [
                [
                    'name' => 'Sản phẩm 1',
                    'code' => 'SP001',
                    'quantity' => 1,
                    'price' => 100000,
                    'weight' => 500,
                    'length' => 20,
                    'width' => 15,
                    'height' => 10
                ],
                [
                    'name' => 'Sản phẩm 2',
                    'code' => 'SP002',
                    'quantity' => 2,
                    'price' => 200000,
                    'weight' => 1000,
                    'length' => 30,
                    'width' => 20,
                    'height' => 15
                ]
            ]
        ]);

        return response()->json([
            'status' => $response->status(),
            'data' => $response->json()
        ]);
    }
    public function Cancel_Order($order_code){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => $this->token, 
            'ShopId' => $this->shopId
        ])->post('https://online-gateway.ghn.vn/shiip/public-api/v2/switch-status/cancel',[
            "order_codes" => [$order_code],
        ]);

        return response()->json([
           'status' => $response->status(),
            'data' => $response->json()
        ]);
    }
    // lấy danh sách tỉnh thành
    public function getAPITinh(){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => $this->token, 
        ])->post('https://online-gateway.ghn.vn/shiip/public-api/master-data/province');

        return response()->json([
           'status' => $response->status(),
            'data' => $response->json()
        ]);
    }
    // lấy danh sách quận huyện 
    public function getAPIDestrict($id_province){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => $this->token, 
        ])->post('https://online-gateway.ghn.vn/shiip/public-api/master-data/district',[
            'province_id' => (int)$id_province
        ]);

        return response()->json([
           'status' => $response->status(),
            'data' => $response->json()
        ]);
    }
    // lấy danh sách phường xã
    public function getAPIWard($id_destrict){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => $this->token, 
        ])->post('https://online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id',[
            'district_id' => (int)$id_destrict
        ]);

        return response()->json([
           'status' => $response->status(),
            'data' => $response->json()
        ]);
    }

    // lấy thông tin đơn hàng
    public function getImformationOrder($order_code){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => $this->token,
        ])->post('https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/detail',[
            "order_code" => $order_code
        ]);

        return response()->json([
           'status' => $response->status(),
            'data' => $response->json()
        ]);
    }
    // cập nhật đơn hàng
    public function updateOrder(Request $request,$order_code){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => $this->token,
        ])->post('https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/update',[
            "order_code" => $order_code,
            // "from_address" => "Sang"
        ]);

        return response()->json([
           'status' => $response->status(),
            'data' => $response->json()
        ]);
    }
    public function dayGiaoHang(){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => $this->token,
            'ShopId' => $this->shopId
        ])->post('https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/leadtime',[
            "from_district_id"=> 2264,
            "from_ward_code"=> "1A0706",
            "to_district_id"=> 1750,
            "to_ward_code"=> "511110",
            "service_id"=> 53320,
        ]);

        return response()->json([
           'status' => $response->status(),
            'data' => $response->json()
        ]);
    } 
}
