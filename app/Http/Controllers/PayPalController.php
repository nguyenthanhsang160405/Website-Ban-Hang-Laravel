<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    protected $paypal;

    public function __construct()
    {
        $this->paypal = new PayPalClient();
        $this->paypal->setApiCredentials(config('paypal'));
        $token = $this->paypal->getAccessToken();
        $this->paypal->setAccessToken($token);
    }

    public function createPayment($order)
    {   
        try {
            $response = $this->paypal->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "amount" => [
                        "currency_code" => env('PAYPAL_CURRENCY', 'USD'),
                        "value" => $order->total_order,
                    ]
                ]],
                "application_context" => [
                    "return_url" => route('paypal.success', ['id_order' => $order->id]),
                    "cancel_url" => route('paypal.cancel', ['id_order' => $order->id]),
                ]
            ]);
            if (isset($response['id']) && isset($response['links'])) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        $order->update([
                            $order->paypal_transaction_id = $response['id'],
                            $order->paypal_response = $link['href']
                        ]);
                        header("Location: {$link['href']}");
                        exit;
                    }
                }
            }

            return redirect('/cart')->withError(['error_cart'=> 'Không thể tạo đơn hàng PayPal.']);

        } catch (\Exception $e) {
            echo 'Lỗi PayPal: ' . $e->getMessage();
        }
    }

    public function paymentSuccess(Request $request)
    {   
        $idOrder = $request->id_order;

        $order = Order::find($idOrder);

        if (!$order) {

            echo 'Đơn hàng không tồn tại.';
            
        }

        try {
            
            $capture = $this->paypal->capturePaymentOrder($request->query('token'));

            if (isset($capture['status']) && $capture['status'] == "COMPLETED"){
                $order->update([
                    'paypal_response' => null,
                    'status_payments' => 'completed',
                ]);

                return redirect('/accountUser')->with('success', 'Thanh toán thành công! Cảm ơn bạn đã mua hàng.');
            }

            return redirect('/accountUser')->with('error', 'Thanh toán thất bại! Vui lòng thử lại.');

        } catch (\Exception $e) {
            echo 'Lỗi khi xác nhận thanh toán: ' . $e->getMessage();
        }
    }

    public function paymentCancel(Request $request)
    {
        return redirect('/accountUser')->with('error', 'Thanh toán thất bại! Bạn có thể thanh toán lại trong phần đơn hàng.');

    }
}