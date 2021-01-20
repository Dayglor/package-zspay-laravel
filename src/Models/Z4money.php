<?php

namespace Dayglor\Z4Money\Models;

use Illuminate\Database\Eloquent\Model;

class Z4money extends Model
{
    //
    protected $fillable = ['name', 'email', 'json', 'url'];

    public function vendaNoCartao( $data )
    {
    	dd($data);
    }
}
