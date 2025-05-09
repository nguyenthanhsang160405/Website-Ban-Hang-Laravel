<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class VNPayController extends Controller
{
    //
    private $vnp_TmnCode; //Mã định danh merchant kết nối (Terminal Id)
    private $vnp_HashSecret; //Secret key
    private $vnp_Url;
    private $vnp_Returnurl;
    private $vnp_apiUrl;
    private $apiUrl;
    public function __construct(){
        $this->vnp_TmnCode = "P0T6YMCE"; //Mã định danh merchant kết nối (Terminal Id)
        $this->vnp_HashSecret = "MMQ3QTU3U2M64SXL52P8KPYQFDOBPDLL"; //Secret key
        $this->vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $this->vnp_Returnurl = "http://127.0.0.1:8000/vnpay_php/vnpay_result";
        $this->vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        $this->apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
    }
    public function createOrdeṛ̣(){
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

        /**
         * 
         *
         * @author CTT VNPAY
         */
        // require_once("./config.php");
        $id_order = $_POST['order_id'];
        $vnp_TxnRef = rand(1,10000); //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $_POST['amount']; // Số tiền thanh toán
        $vnp_Locale = $_POST['language']; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = $_POST['bankCode']; //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount* 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            //
            "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef ."|order_id:".$id_order,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $this->vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $this->vnp_Url . "?" . $query;
        if (isset($this->vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $this->vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();
    }

    public function result(){
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $this->vnp_HashSecret);

        if ($secureHash == $vnp_SecureHash) {

            if ($_GET['vnp_ResponseCode'] == '00') {

                preg_match('/order_id:(\d+)/',$_GET['vnp_OrderInfo'],$matches); 

                $id_Order = $matches[1];

                preg_match('/^Thanh toan GD:(\d+)/',$_GET['vnp_OrderInfo'],$matches2); 

                $codeOrder = $matches2[1];

                $order = Order::find($id_Order);

                $order->status_payments = "completed";

                $order->transaction_id = $codeOrder;

                $order->paypal_response = null;

                $order->save();

                return redirect('/accountUser')->with('success','Thanh toán thành công');

            } else {

                return redirect('/accountUser')->with('error','Thanh toán không thành công');

            }
        } else {

            return redirect('/accountUser')->with('tb','Chữ ký không hợp lệ');

        }
    }
}
