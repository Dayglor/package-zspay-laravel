<?php

/**
 * @docs https://docs.zspay.com.br/
 * @docs Plano - https://docs.zspay.com.br/#plans
 * @docs Assinatura - https://docs.zspay.com.br/#subscription
 * @docs Cliente - https://docs.zspay.com.br/#client
 */

namespace Dayglor\ZSPay\Http\Controllers;
use App\Http\Controllers\Controller;
use Dayglor\ZSPay\Models\ZSPay;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;


class ZSPayController extends Controller
{
    private static $uri = 'https://api.zsystems.com.br/';
    private static $devuri = 'https://api.zsystems.com.br/';

    public function index()
    {
    	return view('ZSPay::contact');
    }

    public static function makeRequest( $action, $type, $data = false) 
    {
        $token = env('Z4_TOKEN', 'f3bd8a2cabbeee52713c35f4bcc00775035a9635'); // Sandbox
        $env = env('Z4_ENV', 'development');
        $url = SELF::$uri;

        if (!$token) { throw new \Error('Nenhum token está definido'); }

        if ($env !== 'production') {
            $url = SELF::$devuri;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.$action);
        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        if ($type === 'post' || $type == 'put')
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            if( $data ){
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data) ); 
            }

            if($type == 'put')
            {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'PUT');
            }
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'authorization: Bearer '.$token
        ]);

        $output = curl_exec($ch);
    
        curl_close($ch);

        return json_decode($output);
    }
}
