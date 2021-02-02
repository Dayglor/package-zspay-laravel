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

class PlanController extends Controller
{
    /**
     * Cadastra um plano
     */
    public static function postPlan ($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required',
            'description' => 'required',
            'setup_amount' => 'required',
            'grance_period' => 'required',
            'tolerance_period' => 'required',
            'frequency' => 'required|max:1',
            'interval' => 'required',
            'logo' => 'required',
            'currency' => 'required',
            'payment_methods' => 'required',
        ]);

        if ($validator->fails()) 
        {
            throw new \Exception($validator->all()[0]);
        }

        $plano = ZSPayController::makeRequest('planos', 'post', $data);
        return $plano;
    }

    /**
     * Listar Planos
     */
    public static function getPlans ()
    {
        $plans = ZSPayController::makeRequest('planos/', 'get');
        return $plans;
    }

    /**
     * Pegar detalhes de um plano
     */
    public static function getPlan ($planoId)
    {
        if (!$planoId) { throw new \Exception('Informe o plano ID a ser pesquisado'); }

        $plan = ZSPayController::makeRequest('planos/'.$planoId, 'get');
        return $plan;
    }

    /**
     * Atualiza um plano
     */
    public static function updatePlan ($data, $planoId)
    {
        if (!$planoId) { throw new \Exception('Informe o plano ID a ser atualizado'); }

        $plano = ZSPayController::makeRequest('planos/'.$planoId, 'put', $data);
        return $plano;
    }

    /**
     * Assina um plano
     */
    public static function signPlan ($data)
    {
        $assinatura = ZSPayController::makeRequest('planos/assinar', 'post', $data);
        return $assinatura;
    }
}
