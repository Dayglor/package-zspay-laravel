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


class ZSPayController extends Controller
{
    private static $uri = 'https://api.zsystems.com.br/';
    private static $devuri = 'https://api.zsystems.com.br/';

    public function index()
    {
    	return view('ZSPay::contact');
    }

    private static function makeRequest( $action, $type, $data = false) 
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

    /**
     * Pesquisa um cliente por CPF/CNPJ
     */
    public static function searchClientByDocument ($document) 
    {
        $cliente = self::makeRequest(`clientes/por_documento/${documento}`, 'get');


        if(!$cliente->success){
            if(isset($cliente->errors)){
                throw new \Exception( implode(' - ', $cliente->errors));
            }
            throw new \Exception($cliente->error);
        }

        return $cliente->cliente;
    }

    /**
     * Cadastra um cliente por CPF/CNPJ
     */
    public static function postClient ($cliente) 
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

    /**
     * Vincula um cartão a um cliente.
     */
    public static function postCard ($clienteId, $dataCartao)
    {
        $cartao = self::makeRequest('clientes/'.$clienteId.'/cartoes', 'post', $dataCartao);
        return $cartao;
    }

    /**
     * Realiza uma venda por boleto
     */
    public static function postSaleTicket( $data )
    {
        $data['tipoPagamentoId'] = 1;
        $venda = self::makeRequest('vendas', 'post', $data);
        return $venda;
    }

    /**
     * Realiza uma venda por cartão de crédito
     */
    public static function postSaleCredit ($data)
    {   
        $data['tipoPagamentoId'] = 3;
        $venda = self::makeRequest('vendas', 'post', $data);
        return $venda;
    }

    /**
     * Realiza o estorno de uma venda
     */
    public static function reverseSale ($vendaId)
    {
        $estorno = self::makeRequest('vendas/'.$vendaId.'/estornar', 'post');
        return $estorno;
    }

    /**
     * Cadastra um plano
     */
    public static function postPlan ($data)
    {
        $plano = self::makeRequest('planos', 'post', $data);
        return $plano;
    }

    /**
     * Atualiza um plano
     */
    public static function updatePlan ($data, $planoId)
    {
        $plano = self::makeRequest('planos/'.$planoId, 'put', $data);
        return $plano;
    }

    /**
     * Assina um plano
     */
    public static function signPlan ($data)
    {
        $assinatura = self::makeRequest('planos/assinar', 'post', $data);
        return $assinatura;
    }

    /**
     * Suspender uma assinatura
     */
    public static function suspendSubscription ($data)
    {
        $assinatura = self::makeRequest('planos/assinatura/suspender', 'post', $data);
        return $assinatura;
    }

    /**
     * Reativar uma assinatura
     */
    public static function activeSubscription ($data)
    {
        $assinatura = self::makeRequest('planos/assinatura/reativar', 'post', $data);
        return $assinatura;
    }

    /**
     * Remover uma assinatura
     */
    public static function removeSubscription ($assinaturaId)
    {
        $assinatura = self::makeRequest('planos/assinatura/'.$assinaturaId, 'delete');
        return $assinatura;
    }

    /**
     * Atualizar uma assinatura
     */
    public static function updateSubscription ($data, $assinaturaId)
    {
        $assinatura = self::makeRequest('planos/assinatura/'.$assinaturaId, 'put', $data);
        return $assinatura;
    }
}
