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

use Dayglor\ZSPay\Http\Controllers\ZSPayController;

class SubscriptionController extends Controller
{
    /**
     * Assina um plano
     */
    public static function signPlan ($data)
    {
        $validator = Validator::make($data, [
            'planoId' => 'required',
            'cliente.nome' => 'required',
            'cliente.email' => 'required',
            'cliente.dataNascimento' => 'required',
            'cliente.cpf' => 'required',
            // 'cliente.telefone' => 'required',
            'cliente.celular' => 'required',
            'endereco.logradouro' => 'required',
            'endereco.numero' => 'required',
            'endereco.cep' => 'required',
            'endereco.cidade' => 'required',
            'endereco.estado' => 'required',
            'cartao.titular' => 'required',
            'cartao.numero' => 'required',
            'cartao.validade' => 'required',
            'cartao.codigoSeguranca' => 'required',
        ]);

        if ($validator->fails()) 
        {
            throw new \Exception($validator->errors()->all()[0]);
        }

        $assinatura = ZSPayController::makeRequest('planos/assinar', 'post', $data);
        return $assinatura;
    }

     /**
     * Suspender uma assinatura
     */
    public static function getSubscriptions ()
    {
        $assinaturas = ZSPayController::makeRequest('planos/assinaturas', 'get');
        return $assinaturas->assinaturas;
    }

    /**
     * Suspender uma assinatura
     */
    public static function suspendSubscription ($data)
    {
        $validator = Validator::make($data, [
            'assinatura_id' => 'required',
        ]);

        if ($validator->fails()) 
        {
            throw new \Exception($validator->errors()->all()[0]);
        }

        $assinatura = ZSPayController::makeRequest('planos/assinatura/suspender', 'post', $data);
        return $assinatura;
    }

    /**
     * Reativar uma assinatura
     */
    public static function activeSubscription ($data)
    {

        $validator = Validator::make($data, [
            'assinatura_id' => 'required',
        ]);

        if ($validator->fails()) 
        {
            throw new \Exception($validator->errors()->all()[0]);
        }
        $assinatura = ZSPayController::makeRequest('planos/assinatura/reativar', 'post', $data);
        return $assinatura;
    }

    /**
     * Remover uma assinatura
     */
    public static function removeSubscription ($assinaturaId)
    {
        if (!$assinaturaId)
        {
            throw new \Exception('Informa o ID da assinatura');
        }

        $assinatura = ZSPayController::makeRequest('planos/assinatura/'.$assinaturaId, 'delete');
        return $assinatura;
    }

    /**
     * Atualizar uma assinatura
     */
    public static function updateSubscription ($data, $assinaturaId)
    {
        $assinatura = ZSPayController::makeRequest('planos/assinatura/'.$assinaturaId, 'put', $data);
        return $assinatura;
    }
}
