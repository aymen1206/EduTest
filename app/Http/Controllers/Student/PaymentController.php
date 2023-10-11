<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Admin\FinancialLogsController;
use App\Http\Controllers\Controller;
use App\Models\Adminfinanciallog;
use App\Models\Commission;
use App\Models\Financiallog;
use App\Models\Tabbyconfig;
use App\Models\TabbyPayment;
use App\Models\Tamaraconfig;
use App\Models\TamaraPayment;
use App\Models\Jeelconfig;
use Exception;
use Illuminate\Http\Request;
use beinmedia\payment\Parameters\PaymentParameters;
use Illuminate\Support\Facades\Http;
use MyFatoorahPayment;
use App\Models\Order;
use Vinkla\Hashids\Facades\Hashids;
use DB;
use Tap\TapPayment\Facade\TapPayment;
use GuzzleHttp\Client;

use Tamara\Configuration;
use Tamara\Client as TamaraClient;
use Tamara\Model\Order\Order as TmaraOrder;
use Tamara\Model\Money;
use Tamara\Model\Order\Address;
use Tamara\Model\Order\Consumer;
use Tamara\Model\Order\MerchantUrl;
use Tamara\Model\Order\OrderItemCollection;
use Tamara\Model\Order\OrderItem;
use Tamara\Model\Order\Discount;
use Tamara\Request\Checkout\CreateCheckoutRequest;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('student.auth:student', ['except' => ['testDestinationID', 'checkPayment','tamaraNotification','TamaraCallback','TamaraCallbackCancelation']]);
        $this->middleware('StudentPhoneVerified', ['except' => ['testDestinationID', 'checkPayment','tamaraNotification','TamaraCallback','TamaraCallbackCancelation']]);
    }


    public function getPaymentMethods($order_id)
    {
        $id = Hashids::decode($order_id)[0];
        $order = Order::find($id);
        $client = auth()->guard('student')->user();
        try {
            $payment = TapPayment::createCharge();
            $payment->setCustomerName($client->name);
            $payment->setCustomerPhone("965", convert2english($client->phone));
            //$payment->setCustomerEmail($client->email);
            $payment->setDescription($order->pricelist->name . ' ' . $order->pricelist->price . ' ريال سعودي ');
            $payment->setAmount($order->pricelist->price);
            $payment->setCurrency("SAR");
            $payment->setSource("src_card");
            $payment->setRedirectUrl(url('/successful-payment'));
            $invoice = $payment->pay();
            DB::table('bn_myfatoorah_payments')->insert([
                'payment_method' => 'src_card',
                'currency' => "SAR",
                'payment_url' => $invoice->getPaymetUrl(),
                'invoice_status' => NULL,
                'order_id' => $order->id,
                'invoice_id' => $invoice->getId(),
                'invoice_value' => $order->pricelist->price,
                'customer_name' => $client->name,
                'customer_email' => $client->email,
                'customer_phone' => convert2english($client->phone),
            ]);
        } catch (Exception $exception) {
        }
        header("Location:" . $invoice->getPaymetUrl());
        die();
    }

    public function checkPayment(Request $request)
    {
        try {

            $invoice = TapPayment::findCharge($request->tap_id);
        } catch (Exception $exception) {
            // your handling of request failure
        }
        $invoice->checkHash($request->header('Hashstring')); // check hashstring to make sure that request comes from Tap
        $invoice->isSuccess(); // check if invoice is paid
        $invoice->isInitiated(); // check if invoice is unpaid yet

        $invoiceData = $invoice->getData();

        $invoice_id = $request->tap_id;

        $flag = DB::table('bn_myfatoorah_payments')->where('invoice_id', $invoice_id)->first();

        DB::table('bn_myfatoorah_payments')->where('invoice_id', $invoice_id)->update([
            'status' => $invoiceData['status'],
            'message' => $invoiceData['response']['message'],
            'card_first_six' => $invoiceData['card']['first_six'],
            'card_brand' => $invoiceData['card']['brand'],
            'card_last_four' => $invoiceData['card']['last_four'],
            'receipt' => $invoiceData['receipt']['id'],
        ]);

        if ($invoice->isSuccess()) {


            DB::table('bn_myfatoorah_payments')->where('invoice_id', $invoice_id)->update([
                'invoice_status' => 'is_paid'
            ]);
            $order_id = $flag->order_id;

            $order = Order::find($order_id);
            $order->status = 'is_paid';
            $order->InvoiceId = $flag->invoice_id;
            $order->payment_type = 'pg';
            $order->update();

            $latest_logs = Financiallog::where('facility_id', $order->facility_id)->get()->last();

            if ($latest_logs != null) {
                $last_total = $latest_logs->total;
                $last_total_commission = $latest_logs->total_commission;
            } else {
                $last_total = 0;
                $last_total_commission = 0;
            }


            $adminlatest_logs = Adminfinanciallog::all()->last();

            if ($adminlatest_logs != null) {
                $adminlast_total = $adminlatest_logs->total;
                $adminlast_total_commission = $adminlatest_logs->total_commission;
                $final_total = $adminlatest_logs->final_total;
            } else {
                $adminlast_total = 0;
                $adminlast_total_commission = 0;
                $final_total = 0;
            }

            $commission_rate = Commission::first()->commission;
            $commission = ($commission_rate / 100) * $order->pricelist->price;
            $total_after_commission = $order->pricelist->price - $commission;

            //is log exist
            $flag = Financiallog::where('InvoiceId', $order->InvoiceId)->where('facility_id', $order->facility_id)->first();
            if ($flag == null) {
                // add logs to facility logs
                $financial_logs = new Financiallog;
                $financial_logs->facility_id = $order->facility_id;
                $financial_logs->InvoiceId = $order->InvoiceId;
                $financial_logs->Invoice_value = $order->pricelist->price;
                $financial_logs->text = " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة ";
                $financial_logs->withdraw = 0;
                $financial_logs->addition = $total_after_commission;
                $financial_logs->commission_rate = $commission_rate;
                $financial_logs->commission = $commission;
                $financial_logs->total = $last_total + $total_after_commission;
                $financial_logs->total_commission = $last_total_commission + $commission;
                $financial_logs->save();

                // add logs to admin logs
                $adminlog = new Adminfinanciallog;
                $adminlog->facility_id = $order->facility_id;
                $adminlog->InvoiceId = $order->InvoiceId;
                $adminlog->Invoice_value = $order->pricelist->price;
                $adminlog->text = " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة ";
                $adminlog->withdraw = $commission;
                $adminlog->addition = $total_after_commission;
                $adminlog->commission_rate = $commission_rate;
                $adminlog->commission = $commission;
                $adminlog->total = $adminlast_total + $total_after_commission;
                $adminlog->total_commission = $adminlast_total_commission + $commission;
                $adminlog->final_total = $final_total + $order->pricelist->price;
                $adminlog->save();

                DB::table('notifications')->insert([
                    'target' => 'facility',
                    'target_id' => $order->facility_id,
                    'title' => 'اضافة رصيد',
                    'text' => " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة "
                ]);

                DB::table('notifications')->insert([
                    'target' => 'student',
                    'target_id' => $order->student,
                    'title' => 'تم الدفع بنجاح واكتمال الطلب',
                    'text' => " تم الدفع بنجاح للطلب رقم  $order->id وعليه تم تغيير حالة الطلب الي مكتمل "
                ]);

            }
            $dt = 'true';
        } else {
            $dt = 'false';
        }

        return view('site.general-status', compact('dt'));
    }

    public function invoice($invoice_id, $order_id)
    {
        $client = auth()->guard('student')->user();
        $order = $data = $client->orders()->where('id', $order_id)->first();
        $invoice = DB::table('bn_myfatoorah_payments')->where('order_id', $order->id)->where('invoice_id', $invoice_id)->first();
        $contact = DB::table('contacts')->first();
        return view('student.invoice', compact('order', 'client', 'invoice', 'contact'));

    }

    public function tamaraPayment($order_id)
    {
        
        $config = Tamaraconfig::query()->first();
        if($config->status == 0){
            return redirect()->back()->with('toast_success',  trans('lang.not_available'));
        }
        $id = Hashids::decode($order_id)[0];
        $order = Order::find($id);
        $client = auth()->guard('student')->user();

        $dt = Http::withHeaders([
            'Authorization' => "Bearer $config->token"
        ])->post("$config->url/checkout/payment-options-pre-check", [
            "country" => "SA",
            "order_value" => [
                "amount" => $order->pricelist->price,
                "currency" => "SAR"
            ],
            "phone_number" => $client->phone,
        ]);
    
        
        $data = json_decode($dt);
        
        $error = null;
        $error_message = null;

        if (isset($data->errors)) {
            $error = $data->errors[0]->error_code;
            $error_message = $data->message;
        } else {
            $data = $data->has_available_payment_options;
        }
        return view('student.tamara', compact('data', 'error', 'error_message','order_id'));
    }

    public function Tamara($order_id)
    {
        $config = Tamaraconfig::query()->first();
        $id = Hashids::decode($order_id)[0];
        $myorder = Order::find($id);
        $myclient = auth()->guard('student')->user();

        $orderData = [];
        $order = new TmaraOrder;
        $order->setOrderReferenceId($id);
        $order->setLocale('en_US');
        $order->setCurrency('SAR');
        $order->setTotalAmount(new Money($myorder->pricelist->price, 'SAR'));
        $order->setCountryCode('SA');
        $order->setPaymentType('PAY_BY_INSTALMENTS');
        $order->setInstalments($config->instalments);
        $order->setDescription($myorder->pricelist->name_en);
        $order->setTaxAmount(new Money(0.00, 'SAR'));
        $order->setShippingAmount(new Money(0.00, 'SAR'));

        # order items
        $orderItemCollection = new OrderItemCollection();
        $orderItem = new OrderItem();
        $orderItem->setName($myorder->pricelist->name_en);
        $orderItem->setQuantity(1);
        $orderItem->setSku('SKU-123');
        $orderItem->setUnitPrice(new Money($myorder->pricelist->price, 'SAR'));
        $orderItem->setType($myorder->pricelist->name_en);
        $orderItem->setTotalAmount(new Money($myorder->pricelist->price, 'SAR'));
        $orderItem->setTaxAmount(new Money(0.0, 'SAR'));
        $orderItem->setDiscountAmount(new Money(0.0, 'SAR'));
        $orderItem->setReferenceId($myorder->id);

        $orderItemCollection->append($orderItem);
        $order->setItems($orderItemCollection);

        # shipping address
        $shipping = new Address();
        $shipping->setFirstName($myclient->name);
        $shipping->setLastName($myclient->name);
        $shipping->setLine1('المملكة العربية السعودية - الرياض');
        $shipping->setCity('الرياض');
        $shipping->setPhoneNumber($myclient->phone);
        $shipping->setCountryCode('SA');
        $order->setShippingAddress($shipping);

        # consumer
        $consumer = new Consumer();
        $consumer->setFirstName($myclient->name);
        $consumer->setLastName($myclient->name);
        $consumer->setEmail($myclient->email);
        $consumer->setPhoneNumber($myclient->phone);
        $order->setConsumer($consumer);

        # merchant urls
        $merchantUrl = new MerchantUrl();
        $merchantUrl->setSuccessUrl(url('/').'/tamara-success');
        $merchantUrl->setFailureUrl(url('/').'/tamara-failure');
        $merchantUrl->setCancelUrl(url('/').'/tamara-cancel');
        $merchantUrl->setNotificationUrl(url('/')."/tamara-notification");
        $order->setMerchantUrl($merchantUrl);

        # discount
        $order->setDiscount(new Discount('Coupon', new Money(0.00, 'SAR')));

        $client = TamaraClient::create(Configuration::create($config->url, $config->token));
        $request = new CreateCheckoutRequest($order);

        $response = $client->createCheckout($request);
        if (!$response->isSuccess()) {
           // $this->log($response->getErrors());
          //  return $this->handleError($response->getErrors());
            return false;
        }

        $checkoutResponse = $response->getCheckoutResponse();

        if ($checkoutResponse === null) {
           // $this->log($response->getContent());
            return false;
        }

        $tamaraOrderId = $checkoutResponse->getOrderId();
        $redirectUrl = $checkoutResponse->getCheckoutUrl();
        // do redirection to $redirectUrl

        $tp = TamaraPayment::query()
            ->where('student_id',$myclient->id)
            ->where('order_id', $myorder->id)
            ->first();

        if ($tp == null){
            $tp = new TamaraPayment;
        }

        $tp->student_id = $myclient->id;
        $tp->facility_id = $myorder->facility_id ;
        $tp->order_id = $myorder->id;
        $tp->status = 'new';
        $tp->checkout_url = $redirectUrl;
        $tp->tamaraOrderId = $tamaraOrderId;
        $tp->save();
        header("Location:" . $redirectUrl);
        die();
    }

    public function tamaraNotification(Request $request)
    {
        $token = $request->header('Authorization');
        $order_id = $request->order_id;
        $event_type = $request->event_type;
        if ($event_type === 'order_approved') {
            $this->autorize($order_id);
        }
    }


    public function autorize($id)
    {
        $config = Tamaraconfig::query()->first();

        $dt = Http::withHeaders([
            'Authorization' => "Bearer $config->token"
        ])->post("$config->url/orders/$id/authorise");
        $info = json_decode($dt);

        $tamara = TamaraPayment::query()->where('tamaraOrderId', $id)->first();
        $order = Order::find($tamara->order_id);
        if (isset($info->status) && $info->status == 'authorised') {
            $tamara->authorised_status = $info->status;
            $tamara->order_expiry_time = $info->order_expiry_time;
            $tamara->auto_captured = $info->auto_captured;
            $tamara->capture_id = $info->capture_id;
            $tamara->update();

            $payment = Http::withHeaders([
                'Authorization' => "Bearer $config->token"
            ])->post("$config->url/payments/capture", [
                "order_id" => $id,
                "total_amount" => [
                    "amount" => $order->pricelist->price,
                    "currency" => "SAR"
                ],
                "shipping_info" => [
                    "shipped_at" => date('Y-m-d H:i:s'),
                    "shipping_company" => "DHL"
                ]
            ]);
        }

        return redirect()->back()->with('toast_success', trans('lang.update_success'));
    }

    public function TamaraCallback(Request $request)
    {
        $tp = TamaraPayment::query()
            ->where('tamaraOrderId', $request->orderId)
            ->first();
        $tp->status = $request->paymentStatus;
        $tp->update();
        $dt = $request->paymentStatus == 'approved' ? true : false;
        $order = Order::where('id', $tp->order_id)->first();
        $order->tamara = 1;
        $order->payment_type = 'tamara';
        $order->status = 'is_paid';
        $order->update();




        $latest_logs = Financiallog::where('facility_id', $order->facility_id)->get()->last();

        if ($latest_logs != null) {
            $last_total = $latest_logs->total;
            $last_total_commission = $latest_logs->total_commission;
        } else {
            $last_total = 0;
            $last_total_commission = 0;
        }


        $adminlatest_logs = Adminfinanciallog::all()->last();

        if ($adminlatest_logs != null) {
            $adminlast_total = $adminlatest_logs->total;
            $adminlast_total_commission = $adminlatest_logs->total_commission;
            $final_total = $adminlatest_logs->final_total;
        } else {
            $adminlast_total = 0;
            $adminlast_total_commission = 0;
            $final_total = 0;
        }


        // Tamara
        $commission_rate = 8;
        $commission = ($commission_rate / 100) * $order->pricelist->price;
        $vat_from_commission = $commission * (15/100);
        $fixed_fee = 1.5;
        $total_after_commission = $order->pricelist->price - ($commission + $fixed_fee + $vat_from_commission);



        //is log exist
        $flag = Financiallog::where('InvoiceId', $request->orderId)->where('facility_id', $order->facility_id)->first();
        if ($flag == null) {
            // add logs to facility logs
            $financial_logs = new Financiallog;
            $financial_logs->facility_id = $order->facility_id;
            $financial_logs->InvoiceId = $request->orderId;
            $financial_logs->Invoice_value = $order->pricelist->price;
            $financial_logs->text = " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة ";
            $financial_logs->withdraw = 0;
            $financial_logs->addition = $total_after_commission;
            $financial_logs->commission_rate = $commission_rate;
            $financial_logs->commission = $commission;
            $financial_logs->total = $last_total + $total_after_commission;
            $financial_logs->total_commission = $last_total_commission + $commission;
            $financial_logs->save();

            // add logs to admin logs
            $adminlog = new Adminfinanciallog;
            $adminlog->facility_id = $order->facility_id;
            $adminlog->InvoiceId = $request->orderId;
            $adminlog->Invoice_value = $order->pricelist->price;
            $adminlog->text = " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة ";
            $adminlog->withdraw = $commission;
            $adminlog->addition = $total_after_commission;
            $adminlog->commission_rate = $commission_rate;
            $adminlog->commission = $commission;
            $adminlog->total = $adminlast_total + $total_after_commission;
            $adminlog->total_commission = $adminlast_total_commission + $commission;
            $adminlog->final_total = $final_total + $order->pricelist->price;
            $adminlog->save();

            DB::table('notifications')->insert([
                'target' => 'facility',
                'target_id' => $order->facility_id,
                'title' => 'اضافة رصيد',
                'text' => " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة "
            ]);

            DB::table('notifications')->insert([
                'target' => 'student',
                'target_id' => $order->student,
                'title' => 'تم الدفع بنجاح واكتمال الطلب',
                'text' => " تم الدفع بنجاح للطلب رقم  $order->id وعليه تم تغيير حالة الطلب الي مكتمل "
            ]);
        }


        return view('site.general-status',compact('dt'));
    }


    public function TamaraCallbackCancelation(Request $request){
        $tp = TamaraPayment::query()
            ->where('tamaraOrderId', $request->orderId)
            ->first();
        $tp->status = $request->paymentStatus;
        $tp->update();
        $dt = 'false';
        return view('site.general-status',compact('dt'));
    }

    public function TamaraInvoice($order_id){
        $id = Hashids::decode($order_id)[0];
        $client = auth()->guard('student')->user();
        $order = $data = $client->orders()->where('id', $id)->first();
        $contact = DB::table('contacts')->first();
        $tamara_payment = TamaraPayment::query()->where('order_id',$id)->first();
        $config = Tamaraconfig::query()->first();

        $dt = Http::withHeaders([
            'Authorization' => "Bearer $config->token"
        ])->get("$config->url/merchants/orders/reference-id/$id");
        $invoice = json_decode($dt);
        return view('student.tamara_invoice', compact('order', 'client', 'contact','invoice'));
    }


    public function alrajhiInstallements($order_id){
        $order_id = Hashids::decode($order_id)[0];
        $text =  DB::table('legal_agreements')->where('type', 'alrajhi-installments')->first();
        $data = ["order_id" => Hashids::encode($order_id), "text" => $text];
        return view('student.alrajhi-installments', compact('data'));
    }

    
    public function createAlrajhiInstallements(Request $request){
        $order_id = Hashids::decode($request->order_id)[0];
        $user = auth()->guard('student')->user();
        $order = Order::find($order_id);
        $order->payment_type = 'alrajhi_inst';
        $order->status='under_revision';
        $order->save();
        $data = ['status' => "success"];
        return view('student.alrajhi-installments', compact('data'));

    }



    public function TabbyPreScoring($order_id)
    {   
        $config = Tabbyconfig::query()->first();    
        $id = Hashids::decode($order_id)[0];
        $order = Order::find($id);
        $client = auth()->guard('student')->user();
        $date=date('yy-m-d');
        $time=date('h:m:s');
        $now=$date."T".$time."Z";

        $dt = Http::withHeaders([
            'Authorization' => "Bearer ".$config->token,
            'Content-Type' => 'application/json' 
        ])->post($config->url, [
            "payment" => [
                "amount" => $order->pricelist->price,
                "currency" => "SAR",
                "description" =>"Pay Edu-Facility installment",
                "buyer" => [
                      "phone"=> $client->phone,
                      "email"=> $client->email,
                      "name"=> $client->name
                ],
                "shipping_address" => [
                  "city"=> "الرياض",
                  "address"=> "المملكة العربية السعودية - الرياض",
                  "zip"=> "00000"
                ],
                "order" => [
                  "tax_amount"=> "0.00",
                  "shipping_amount"=> "0.00",
                  "discount_amount"=> "0.00",
                  "updated_at"=> $order->updated_at,
                  "reference_id"=> (string)$id,
                   "items" =>[
                    [
                    "title"=> $order->facility->name,
                    "description"=>$order->pricelist->name_en,
                    "quantity"=> 1,
                    "unit_price"=> $order->pricelist->price,
                    "discount_amount"=> "0.00",
                    "reference_id"=> (string)$id,
                    "category"=> $order->pricelist->subscriptionperiod->name,

                    ]
                    ]
                  ],                              
                "buyer_history" => [
                  "registered_since" => $client->created_at,
                  "loyalty_level" => 0,
                ],
                "order_history" => [  
                    [                     
                    "purchased_at"=> $now,
                    "amount" => $order->pricelist->price,
                    "status" => "new",
                    ]
                ],
                "meta" => [
                  "order_id" => $id,
                  "customer" => $client->id
                ]
            ],
            
            "lang" =>"ar",
            "merchant_code"=>$config->merchant_id,
            "merchant_urls"=>[
            "success"=>url('/')."/student/tabby-success/".$id,
            "cancel"=>url('/')."/student/tabby-cancel",
            "failure"=>url('/')."/student/tabby-failure"
            ], 
        ]);

        $response=$dt->json();
        $CheckoutStatus=$response['status'];
        if($CheckoutStatus=="created"){    return redirect('student/tabby/'.$order_id);       }
        else{ return view('student.TabbyPre-Scoring'); }
     }
     
    public function tabbyPayment($order_id)
    {   
        $config = Tabbyconfig::query()->first();    
        $id = Hashids::decode($order_id)[0];
        $order = Order::find($id);
        $client = auth()->guard('student')->user();
        $date=date('yy-m-d');
        $time=date('h:m:s');
        $now=$date."T".$time."Z";

        $dt = Http::withHeaders([
            'Authorization' => "Bearer ".$config->token,
            'Content-Type' => 'application/json' 
        ])->post($config->url, [
            "payment" => [
                "amount" => $order->pricelist->price,
                "currency" => "SAR",
                "description" =>"Pay Edu-Facility installment",
                "buyer" => [
                      "phone"=> $client->phone,
                      "email"=> $client->email,
                      "name"=> $client->name
                ],
                "shipping_address" => [
                  "city"=> "الرياض",
                  "address"=> "المملكة العربية السعودية - الرياض",
                  "zip"=> "00000"
                ],
                "order" => [
                  "tax_amount"=> "0.00",
                  "shipping_amount"=> "0.00",
                  "discount_amount"=> "0.00",
                  "updated_at"=> $order->updated_at,
                  "reference_id"=> (string)$id,
                   "items" =>[
                    [
                    "title"=> $order->facility->name,
                    "description"=>$order->pricelist->name_en,
                    "quantity"=> 1,
                    "unit_price"=> $order->pricelist->price,
                    "discount_amount"=> "0.00",
                    "reference_id"=> (string)$id,
                    "category"=> $order->pricelist->subscriptionperiod->name,

                    ]
                    ]
                  ],                              
                "buyer_history" => [
                  "registered_since" => $client->created_at,
                  "loyalty_level" => 0,
                ],
                "order_history" => [  
                    [                     
                    "purchased_at"=> $now,
                    "amount" => $order->pricelist->price,
                    "status" => "new",
                    ]
                ],
                "meta" => [
                  "order_id" => $id,
                  "customer" => $client->id
                ]
            ],
            
            "lang" =>"ar",
            "merchant_code"=>$config->merchant_id,
            "merchant_urls"=>[
            "success"=>url('/')."/student/tabby-success/".$id,
            "cancel"=>url('/')."/student/tabby-cancel",
            "failure"=>url('/')."/student/tabby-failure"
            ], 
        ]);

        $response=$dt->json();

        $CheckouId=$response['id'];
        $CheckoutStatus=$response['status'];
        $redirectUrl=$response['configuration']['available_products']['installments'][0]['web_url'];
        $next_payment_date=$response['configuration']['available_products']['installments'][0]['next_payment_date'];

        DB::table('tabby_payments')->insert([
            'student_id'=>$client->phone,
            'facility_id'=>$order->facility_id,
            'order_id'=>$id,
            'checkout_url'=>$redirectUrl,
            'tabbyOrderId'=>$CheckouId,
            'authorised_status'=>"Autorized",
            'can_authorised'=>"",
            'order_expiry_time'=>$next_payment_date,
            'auto_captured'=>null,
            'capture_id'=>null
        ]);
        header("Location:" . $redirectUrl);
        die();
     }
      public function jeelPay($order_id){


        $config = Jeelconfig::query()->first();   
        $response = Http::asForm()->post($config->Authurl, [
        'grant_type' => 'client_credentials',
        'client_id' => $config->client_id,
        'client_secret' => $config->client_secret,
        'scope' => '',
        ]);         
        $token=$response->json()['access_token'];

        if (isset($token) ) {
        $config->token=$token;
        $config->save();  
        $id = Hashids::decode($order_id)[0];
        $order = Order::find($id);
        $existChild=DB::table('childrens')->where('id',$order->children)->first();
        if($existChild!=null){
        $Studentname=DB::table('childrens')->where('id',$order->children)->first()->name;
        }else{

               $error="noChiled";

                return view('student.jeel-installments-Error', compact('error'));
        }
        $client = auth()->guard('student')->user();
        $phoneNumber=substr($client->phone, 3, 9);
        $dt = Http::withHeaders([
            'Authorization' => "Bearer ".$token
            ])->post($config->url, [
            "school_name"=>lng($order->facility,'name'),
            "customer"=>[
            "first_name"=>$client->name,
            "last_name"=>"  ",
            "phone_number"=> $phoneNumber,
            "national_id"=> $client->guardian_id_number,
            "email"=>$client->email,
            ], 
            "students"=>
        [
            [
            "national_id"=>$client->id_number,
            "name"=>$Studentname,
            "grade"=>lng($order->pricelist->_stage,'name'),
            "cost"=>$order->pricelist->price,
            ]
        ]
            , 
            "urls"=>[
            "redirect_url"=>url('/')."/student/Jeel-Payment/".$id,
            "notification_url"=>url('/')."/api/jeel/webhook/",
            ], 

            ]);

        $response=$dt->json();
        
         if(isset($response['redirect_url'])){
               
                $redirectUrl=$response['redirect_url'];
                $CheckouId=$response['id'];
                $Creationdate=$response['creation_date'];

                DB::table('Jeel_payments')->insert([
                    'student_id'=>$client->id,
                    'facility_id'=>$order->facility_id,
                    'order_id'=>$id,
                    'checkout_url'=>$redirectUrl,
                    'jeelOrderId'=>$CheckouId,
                    'status'=>"success",
                    'Jeel_response'=>$dt,
                    'created_at'=>$Creationdate
                ]);


               header("Location:" . $redirectUrl);
                die();

            }
            else{
             redirect()->back();
             if($response['errors'][0]['description']==null){
            
               $error=$response['errors'][0]['message'];

                return view('student.jeel-installments-Error', compact('error'));
               

             }
             else{

                  $error=$response['errors'][0]['description'];
                return view('student.jeel-installments-Error', compact('error'));
             }

            
            }
                

         } 
     }


//    public function getPaymentMethods($order_id)
//    {
//        $id = Hashids::decode($order_id)[0];
//        $order = Order::find($id);
//        $customer = auth()->guard('student')->user();
//        $facility = EduFacility::find($order->facility_id);
//        $business = DB::table('business')->where('facility_id', $facility->id)->first();
//        $json_data = json_decode($business->json, true);
//        $facility->destination_id = $json_data['destination_id'];
//
//        $_charge_data = $this->charge($order, $customer, $facility);
//        $charge_data = json_decode($_charge_data, true);
//
//        if (isset($charge_data['id'])) {
//
//            $charge_flag = DB::table('charges')->where('order_id',$order->id)->first();
//            if($charge_flag == null){
//                DB::table('charges')->insert([
//                    'order_id' => $order->id,
//                    'facility_id' => $facility->id,
//                    'student_id' => $customer->id,
//                    'charge' => $charge_data['id'],
//                    'json' => $_charge_data
//                ]);
//            }else{
//                DB::table('charges')->where('order_id',$order->id)->update([
//                    'charge' => $charge_data['id'],
//                    'json' => $_charge_data
//                ]);
//            }
//
//
//            $order->InvoiceId = $charge_data['id'];
//            $order->update();
//
//
//            header("Location:" . $charge_data['transaction']['url']);
//            die();
//        }else{
//            redirect()->back();
//        }
//    }
//
//    public function charge($order, $customer, $facility)
//    {
//        $URL = url('student/successful-payment');
//        $curl = curl_init();
//        $total = DB::table('facility_prices')->where('id', $order->price_id)->first()->price;
//        $commission = DB::table('commissions')->first()->commission;
//        $theedukey_total = ($total * ($commission / 100));
//        $school_total = $total - $theedukey_total;
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://api.tap.company/v2/charges",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_POSTFIELDS => "{
//            \"amount\":$total,
//            \"currency\":\"SAR\",
//            \"threeDSecure\":true,
//            \"save_card\":false,
//            \"description\":\"Order Payment Transaction\",
//            \"reference\":{\"transaction\":\"$order->id\",\"order\":\"$order->id\"},
//            \"receipt\":{\"email\":true,\"sms\":true},
//            \"customer\":{\"first_name\":\"$customer->name\",\"email\":\"$customer->email\",
//\"phone\":{\"country_code\":\"966\",\"number\":\"$customer->phone\"}},
//            \"source\":{\"id\":\"src_card\"},
//            \"destinations\": {
//                \"destination\": [
//                  {
//                  \"id\": \"$facility->destination_id\",
//                  \"amount\": $school_total,
//                  \"currency\": \"SAR\"
//                  }
//                ]
//            },
//            \"redirect\": {
//                \"url\": \"$URL\"
//              }
//            }",
//            CURLOPT_HTTPHEADER => array(
//                "authorization: Bearer sk_live_8XoRhyw6n3SB1maMqL42Czbg",
//                "content-type: application/json"
//            ),
//        ));
//
//        $response = curl_exec($curl);
//        $err = curl_error($curl);
//
//        curl_close($curl);
//
//        if ($err) {
//            return false;
//        } else {
//            return $response;
//        }
//    }
//
//    public function checkPayment(Request $request)
//    {
//        $_charge = $this->checkCharge($request->tap_id);
//        $charge = json_decode($_charge, true);
//
//        $flag = DB::table('charges')->where('charge', $request->tap_id)->first();
//
//        if ($flag != null){
//            DB::table('charges')->where('charge', $request->tap_id)->update(
//                ['json' => $_charge]
//            );
//        }
//
//        if ($charge['status'] == 'CAPTURED' ) {
//            $order_id = $flag->order_id;
//            $order = Order::find($order_id);
//            $order->status = 'is_paid';
//            $order->InvoiceId = $flag->charge;
//            $order->update();
//
//            $latest_logs = Financiallog::where('facility_id', $order->facility_id)->get()->last();
//
//            if ($latest_logs != null) {
//                $last_total = $latest_logs->total;
//                $last_total_commission = $latest_logs->total_commission;
//            } else {
//                $last_total = 0;
//                $last_total_commission = 0;
//            }
//
//
//            $adminlatest_logs = Adminfinanciallog::all()->last();
//
//            if ($adminlatest_logs != null) {
//                $adminlast_total = $adminlatest_logs->total;
//                $adminlast_total_commission = $adminlatest_logs->total_commission;
//                $final_total = $adminlatest_logs->final_total;
//            } else {
//                $adminlast_total = 0;
//                $adminlast_total_commission = 0;
//                $final_total = 0;
//            }
//
//            $commission_rate = Commission::first()->commission;
//            $commission = ($commission_rate / 100) * $order->pricelist->price;
//            $total_after_commission = $order->pricelist->price - $commission;
//
//            //is log exist
//            $flag = Financiallog::where('InvoiceId', $order->InvoiceId)->where('facility_id', $order->facility_id)->first();
//            if ($flag == null) {
//                // add logs to facility logs
//                $financial_logs = new Financiallog;
//                $financial_logs->facility_id = $order->facility_id;
//                $financial_logs->InvoiceId = $order->InvoiceId;
//                $financial_logs->Invoice_value = $order->pricelist->price;
//                $financial_logs->text = " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة ";
//                $financial_logs->withdraw = 0;
//                $financial_logs->addition = $total_after_commission;
//                $financial_logs->commission_rate = $commission_rate;
//                $financial_logs->commission = $commission;
//                $financial_logs->total = $last_total + $total_after_commission;
//                $financial_logs->total_commission = $last_total_commission + $commission;
//                $financial_logs->save();
//
//                // add logs to admin logs
//                $adminlog = new Adminfinanciallog;
//                $adminlog->facility_id = $order->facility_id;
//                $adminlog->InvoiceId = $order->InvoiceId;
//                $adminlog->Invoice_value = $order->pricelist->price;
//                $adminlog->text = " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة ";
//                $adminlog->withdraw = $commission;
//                $adminlog->addition = $total_after_commission;
//                $adminlog->commission_rate = $commission_rate;
//                $adminlog->commission = $commission;
//                $adminlog->total = $adminlast_total + $total_after_commission;
//                $adminlog->total_commission = $adminlast_total_commission + $commission;
//                $adminlog->final_total = $final_total + $order->pricelist->price;
//                $adminlog->save();
//
//                DB::table('notifications')->insert([
//                    'target' => 'facility',
//                    'target_id' => $order->facility_id,
//                    'title' => 'اضافة رصيد',
//                    'text' => " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة "
//                ]);
//
//                DB::table('notifications')->insert([
//                    'target' => 'student',
//                    'target_id' => $order->student,
//                    'title' => 'تم الدفع بنجاح واكتمال الطلب',
//                    'text' => " تم الدفع بنجاح للطلب رقم  $order->id وعليه تم تغيير حالة الطلب الي مكتمل "
//                ]);
//            }
//
//
//            $dt = 'true';
//
//        } else {
//            $dt = 'false';
//        }
//
//        return view('site.general-status',compact('dt'));
//    }
//
//    public function checkCharge($id)
//    {
//        $curl = curl_init();
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://api.tap.company/v2/charges/$id",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "GET",
//            CURLOPT_HTTPHEADER => array(
//                "authorization: Bearer sk_live_8XoRhyw6n3SB1maMqL42Czbg",
//                "content-type: application/json"
//            ),
//        ));
//
//        $response = curl_exec($curl);
//        $err = curl_error($curl);
//
//        curl_close($curl);
//
//        if ($err) {
//            return false;
//        } else {
//            return $response;
//        }
//    }
//
//    public function invoice($invoice_id, $order_id)
//    {
//        $client = auth()->guard('student')->user();
//        $order = $client->orders()->where('id', $order_id)->first();
//        $_invoice = DB::table('charges')->where('order_id', $order->id)->where('charge', $invoice_id)->first();
//        if ($_invoice == null){
//            return redirect()->back()->with('toast_error', 'لا توجد بيانات لهذه الفاتورة');
//        }
//        $invoice = json_decode($_invoice->json, true);
//        $contact = DB::table('contacts')->first();
//        return view('student.invoice', compact('order', 'client', 'invoice', 'contact'));
//    }


}
