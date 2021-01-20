<?php

namespace Dayglor\ZSPay\Http\Controllers;
use App\Http\Controllers\Controller;
use Dayglor\ZSPay\Models\ZSPay;
use Illuminate\Http\Request;

class ZSPayController extends Controller
{
    private static $uri = 'https://api.zsystems.com.br/';
    private static $devuri = 'https://api.zsystems.com.br/';

    public function index()
    {
    	return view('ZSPay::contact');
    }

    private static function makeRequest( $action, $type, $data = false){

        //phpinfo();
        //die();  
        $token = env('ZSPayToken', 'f3bd8a2cabbeee52713c35f4bcc00775035a9635');
        $env = env('ZSPayEnviroment', 'development');
        $url = SELF::$uri;

        if(!$token){ throw new \Error('Nenhum token está definido'); }

        if($env === 'development') {
            $url = SELF::$devuri;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.$action);
        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        if($type === 'post' || $type == 'put')
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
        // if(curl_error($ch)){
        //     dd(curl_error($ch));
        // }
        // dd($output);
        curl_close($ch);

        return json_decode($output);
    }

    public static function criarCliente ($cliente) 
    {
        $cliente = self::makeRequest('clientes', 'post', $cliente);


        if(!$cliente->success){
            if(isset($cliente->errors)){
                throw new \Exception( implode(' - ', $cliente->errors));
            }
            throw new \Exception($cliente->error);
        }

        return $cliente->cliente;
    }

    public static function cadastrarCartao ($clienteId, $dataCartao)
    {
        $cartao = self::makeRequest('clientes/'.$clienteId.'/cartoes', 'post', $dataCartao);
        return $cartao;
    }

    public static function vendaBoleto( $data )
    {
        $data['tipoPagamentoId'] = 1;
        $venda = self::makeRequest('vendas', 'post', $data);
        return $venda;
    }

    public static function vendaCredito ($data)
    {   
        $data['tipoPagamentoId'] = 3;
        $venda = self::makeRequest('vendas', 'post', $data);
        return $venda;
    }

    public static function estornarVenda ($vendaId)
    {
        $estorno = self::makeRequest('vendas/'.$vendaId.'/estornar', 'post');
        return $estorno;
    }

    public static function cadastrarPlano ($data)
    {
        $plano = self::makeRequest('planos', 'post', $data);
        return $plano;
    }

    public static function atualizarPlano ($data, $planoId)
    {
        $plano = self::makeRequest('planos/'.$planoId, 'put', $data);
        return $plano;
    }

    public static function assinarPlano ($data)
    {
        $assinatura = self::makeRequest('planos/assinar', 'post', $data);
        return $assinatura;
    }

    public static function suspenderAssinatura ($data)
    {
        $assinatura = self::makeRequest('planos/assinatura/suspender', 'post', $data);
        return $assinatura;
    }

    public static function reativarAssinatura ($data)
    {
        $assinatura = self::makeRequest('planos/assinatura/reativar', 'post', $data);
        return $assinatura;
    }

    public static function removerAssinatura ($assinaturaId)
    {
        $assinatura = self::makeRequest('planos/assinatura/'.$assinaturaId, 'delete');
        return $assinatura;
    }

    public static function editarAssinatura ($data, $assinaturaId)
    {
        $assinatura = self::makeRequest('planos/assinatura/'.$assinaturaId, 'put', $data);
        return $assinatura;
    }
}
