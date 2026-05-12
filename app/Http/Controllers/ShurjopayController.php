<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ShurjopayPlugin\Shurjopay;
use ShurjopayPlugin\PaymentRequest;

class ShurjopayController extends Controller
{
    private $sp;

    public function __construct(Shurjopay $sp)
    {
        $this->sp = $sp;
    }

    public function index()
    {
        return view('shurjopay.index');
    }

    public function pay(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'customer_email' => 'required|email',
            'customer_address' => 'required|string',
        ]);

        $paymentRequest = new PaymentRequest();
        $paymentRequest->currency = 'BDT';
        $paymentRequest->amount = $request->amount;
        $paymentRequest->discountAmount = 0;
        $paymentRequest->discPercent = 0;
        $paymentRequest->customerName = $request->customer_name;
        $paymentRequest->customerPhone = $request->customer_phone;
        $paymentRequest->customerEmail = $request->customer_email;
        $paymentRequest->customerAddress = $request->customer_address;
        $paymentRequest->customerCity = 'Dhaka';
        $paymentRequest->customerState = 'Dhaka';
        $paymentRequest->customerPostcode = '1200';
        $paymentRequest->customerCountry = 'Bangladesh';
        
        // Optional shipping info
        $paymentRequest->shippingAddress = $request->customer_address;
        $paymentRequest->shippingCity = 'Dhaka';
        $paymentRequest->shippingCountry = 'Bangladesh';
        $paymentRequest->receivedPersonName = $request->customer_name;
        $paymentRequest->shippingPhoneNumber = $request->customer_phone;

        return $this->sp->makePayment($paymentRequest);
    }

    public function callback(Request $request)
    {
        $order_id = $request->get('order_id');
        
        if (!$order_id) {
            return redirect()->route('shurjopay.index')->with('error', 'Payment failed or cancelled.');
        }

        $response = $this->sp->verifyPayment($order_id);
        
        return view('shurjopay.response', compact('response'));
    }
}
