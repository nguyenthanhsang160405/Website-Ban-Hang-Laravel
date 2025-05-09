<?php

use App\Http\Controllers\AIController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\DetaiOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GHNController;
use App\Mail\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VNPayController;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Srmklive\PayPal\Services\PayPal;



// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/testUserApi/{user}',[UserController::class,'testUserApi']);
Route::get('/goComment/{detaiorder}',[DetaiOrderController::class,'goComment']);

Route::post('/update-accout/{user}',[UserController::class,'updateImformation']);
Route::post('/update-password-acccount/{user}',[UserController::class,'updatePassword']);
Route::get('/',[ProductController::class,'index'])->name('index');
Route::get('/contact',[PageController::class,'contact'])->name('contact');
Route::get('/products/{id}',[ProductController::class,'pageProduct']);
Route::get('/product/{product}',[ProductController::class,'show']);
Route::get('/login',[UserController::class,'pageLogin'])->name('login')->middleware('returnAccountUser');
Route::get('/register',[UserController::class,'pageRegister']);
Route::post('/login/actionLogin',[UserController::class,'actionLogin']);
Route::post('/actionRegister',[UserController::class,'actionRegister']);
Route::get('/logout',[UserController::class,'actionLogout']);
Route::get('/detail-order-user/{order}',[OrderController::class,'show']);
Route::get('/accountUser',[UserController::class,'pageAccountUser'])->name('accountUser');
Route::get('/admin/repost',[PageController::class,'pageReport'])->name('pageReport')->middleware(['auth','checkAdmin']);

Route::post('/contact/sendEmail',[PageController::class,'sendEmail'])->name('productsAdmin');


Route::get('/auth/google', [GoogleController::class,'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [UserController::class,'loginWithGoogle']);

Route::get('/test', [TestController::class,'test']); 

Route::get('/cart', [PageController::class,'cart']); 

Route::get('/deleteCart/{id}', [CartController::class,'deleteCart']); 



Route::post('/addtocart', [CartController::class,'addToCart']); 

Route::post('/cart/update', [CartController::class,'updateCart']); 

Route::get('/forgetPassword', [PageController::class,'forgetPassword']); 

Route::get('/confirm', [PageController::class,'pageConfirm']); 



Route::post('/confirmCode', [PageController::class,'confirmCode']);

Route::get('/confirmPassword', [PageController::class,'confirmPassword']);




Route::post('/changePassword', [PageController::class,'checkCodePassWord']);




Route::post('/actionPayment',[OrderController::class,'store']);




Route::get('/payment/vn-pay',[PageController::class,'pageVNPay'])->middleware('signed')->name('vnpay');
Route::post('/vnpay_php/vnpay_create_payment',[VNPayController::class,'createOrdeṛ̣']);
Route::get('/vnpay_php/vnpay_result',[VNPayController::class,'result']);

//VNPay
//
Route::middleware('auth')->group(function () {
    Route::get('/payment', [PageController::class,'pagePayment']); 
    Route::get('/paymentSuccess',[PayPalController::class,'paymentSuccess'])->name('paypal.success');
    Route::get('/paymentCancel',[PayPalController::class,'paymentCancel'])->name('paypal.cancel');
    Route::post('/comment',[CommentController::class,'store']);

}); 

Route::middleware(['auth','checkAdmin'])->group(function (){
    Route::post('/user/update/{user}',[UserController::class,'update']);
    Route::get('/user/delete/{user}',[UserController::class,'destroy']);
    Route::get('/adduser',[UserController::class,'pageAddUser']);
    Route::get('/user/{user}',[UserController::class,'show']);
    Route::post('/users/store',[UserController::class,'store']);
    Route::get('/admin',[UserController::class,'pageIndexAdmin'])->name('admin');
    Route::get('/listproduct/{id}',[ProductController::class,'pageAdminProducts'])->name('admin.listproduct');
    Route::get('/listproduct',[ProductController::class,'pageAdminProducts'])->name('admin.listproduct.page');;
    Route::post('/product/store',[ProductController::class,'store']);
    Route::get('/addproduct',[ProductController::class,'create']);
    Route::get('/product/delete/{product}',[ProductController::class,'destroy']);
    Route::get('/product/edit/{product}',[ProductController::class,'edit']);
    Route::post('/product/update/{product}',[ProductController::class,'update']);

    Route::get('/listorder',[OrderController::class,'index'])->name('listorder');
    Route::get('/order/accept/{order}',[OrderController::class,'Accept']);
    Route::post('order/update-status/{order}',[OrderController::class,'UpdateStatus']);
    Route::get('/order/view/{order}',[OrderController::class,'show']);

    Route::get('/listcategory/{category}',[CategoryProductController::class,'index']);
    Route::get('/addcategory',[CategoryProductController::class,'create']);
    Route::post('/category/store',[CategoryProductController::class,'store']);
    Route::get('/category/edit/{category}',[CategoryProductController::class,'edit']);
    Route::post('/category/update/{category}',[CategoryProductController::class,'update']);
    Route::get('/category/delete/{category}/{idPage}',[CategoryProductController::class,'destroy']);

    Route::get('/listcomment/{idPage}',[CommentController::class,'index'])->name('admin.comment.listcomment');
    Route::get('/addcomment',[CommentController::class,'create'])->name('admin.comment.addcomment');
    Route::post('/addcommentAdmin',[CommentController::class,'createAdmin'])->name('admin.comment.create');
    Route::get('/comment/delete/{comment}/{idPgae}',[CommentController::class,'destroy'])->name('admin.comment.delete');
    Route::get('/comment/edit/{comment}',[CommentController::class,'edit'])->name('admin.comment.edit');
    Route::post('/comment/update/{comment}',[CommentController::class,'update'])->name('admin.comment.update');
});



// Route::fallback(function () {
//     return "Đường dẫn của bạn không hợp lệ";
// });



Route::get('/guidonhang',[GHNController::class,'createShippingOrder']);
Route::get('/huydonhang/{ghn}',[GHNController::class,'Cancel_Order']);
Route::get('/apitinh',[GHNController::class,'getAPITinh']);
Route::get('/apidestrict/{province}',[GHNController::class,'getAPIDestrict']);
Route::get('/apiward/{destrict}',[GHNController::class,'getAPIWard']);
Route::get('/getImformationGHN/{ghn}',[GHNController::class,'getImformationOrder']);
Route::get('/updateOrder/{ghn}',[GHNController::class,'updateOrder']);
Route::get('/dayGiaoHang',[GHNController::class,'dayGiaoHang']);

// Route::resource('/product',ProductController::class);
Route::get('/chat',[AIController::class,'index']);
Route::post('/chat/send',[AIController::class,'sendMessage']);