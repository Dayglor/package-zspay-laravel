<?php

namespace Dayglor\ZSPay;

use Illuminate\Support\ServiceProvider;

class ZSPayServiceProvider extends serviceProvider {

	public function boot()
	{
		$this->loadRoutesFrom(__DIR__.'/routes/web.php');
		$this->loadViewsFrom(__DIR__.'/views', 'ZSPay');
		$this->loadMigrationsFrom(__DIR__.'/database/migrations');
	}

	public function register()
	{

	}

}