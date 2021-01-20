<?php

namespace Dayglor\Z4Money;

use Illuminate\Support\ServiceProvider;

class Z4MoneyServiceProvider extends serviceProvider {

	public function boot()
	{
		$this->loadRoutesFrom(__DIR__.'/routes/web.php');
		$this->loadViewsFrom(__DIR__.'/views', 'z4money');
		$this->loadMigrationsFrom(__DIR__.'/database/migrations');
	}

	public function register()
	{

	}

}