<?php

namespace Dayglor\ZSPay\Models;

use Illuminate\Database\Eloquent\Model;

class ZSPay extends Model
{
    //
    protected $fillable = ['name', 'email', 'json', 'url'];

    public function vendaNoCartao( $data )
    {
    	dd($data);
    }
}
