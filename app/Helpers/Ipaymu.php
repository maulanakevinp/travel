<?php

namespace App\Helpers;

class Ipaymu
{
    public static function checkAccount()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://my.ipaymu.com/api/saldo",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'key' => config('ipaymu.key'),
                'format' => 'json'
            ),
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public static function checkTransaction($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://my.ipaymu.com/api/transaksi",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'key' => config('ipaymu.key'),
                'id' => $id,
                'format' => 'json'
            ),
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public static function getIdCsStore($product, $quantity, $price)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "api.ipaymu.com/api/direct/get-sid",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'key' => config('ipaymu.key'),
                'pay_method' => 'cstore',
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price,
                'ureturn' => url('/'),
                'unotify' => url('/notify'),
                'ucancel' => url('/')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public static function payCsStore($sessionID, $channel, $name, $phone, $email)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "api.ipaymu.com/api/direct/pay/cstore",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'key' => config('ipaymu.key'),
                'sessionID' => $sessionID,
                'channel' => $channel,
                'name' => $name,
                'phone' => $phone,
                'email' => $email
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function virtualAccount($bank, $name, $email, $phone, $price)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://my.ipaymu.com/api/" . $bank,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'key' => config('ipaymu.key'),
                'uniqid' => date('YmdHis'),
                'customer_name' => $name,
                'customer_email' => $email,
                'customer_phone' => $phone,
                'price' => $price,
                'notify_url' => url('/notify'),
                'expired' => '24'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function bcaTransfer($amount, $name, $phone, $email)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://my.ipaymu.com/api/bcatransfer",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'key' => config('ipaymu.key'),
                'amount' => $amount,
                'uniqid' => date('YmdHis'),
                'notifyUrl' => url('/notify'),
                'name' => $name,
                'phone' => $phone,
                'email' => $email
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public static function qr($name, $phone, $email, $amount, $zipCode, $city)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://my.ipaymu.com/api/payment/qris",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'key' => config('ipaymu.key'),
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'amount' => $amount,
                'notifyUrl' => url('/notify'),
                'referenceId' => date('YmdHis'),
                'zipCode' => $zipCode,
                'city' => $city
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
