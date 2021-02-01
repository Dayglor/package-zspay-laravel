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
use Dayglor\ZSPay\Http\Controllers\ZSPayController;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{
    /**
     * Pesquisa um cliente por CPF/CNPJ
     */
    public static function searchClientByDocument ($document) 
    {
        if (!$document) 
        {
            throw new \Exception('Informe o número do documento');
        }

        $cliente = ZSPayController::makeRequest("clientes/por_documento/${document}", 'get');


        if (!$cliente->success) 
        {
            if (isset($cliente->errors)) 
            {
                throw new \Exception( implode(' - ', $cliente->errors));
            }
            throw new \Exception('Cliente não encontrado');
        }

        return $cliente->cliente;
    }

    /**
     * Cadastra um cliente por CPF/CNPJ
     */
    public static function postClient ($cliente) 
    {
        $validator = Validator::make($client, [
            'nome' => 'required',
            'documento' => 'required',
            'dataNascimento' => 'required',
            'email' => 'required',
            'celular' => 'required',
            'sexo' => 'required|max:1',
            'endereco.logradouro' => 'required',
            'endereco.numero' => 'required',
            'endereco.cep' => 'required',
            'endereco.cidade' => 'required',
            'endereco.estado' => 'required',
        ]);

        if ($validator->fails()) 
        {
            dd($validator);
        }

        $cliente = ZSPayController::makeRequest('clientes', 'post', $cliente);

        if (!$cliente->success) {
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
        $validator = Validator::make($client, [
            'numero' => 'required|numeric',
            'titular' => 'required|min:3',
            'codigoSeguranca' => 'required|max:4|min:3',
            'validade' => 'required|min:7',
        ]);

        if ($validator->fails()) 
        {
            dd($validator);
        }

        $cartao = ZSPayController::makeRequest('clientes/'.$clienteId.'/cartoes', 'post', $dataCartao);
        return $cartao;
    }
}
