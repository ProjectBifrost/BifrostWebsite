<?php

/**
 * This file is part of ProjectBifrost.
 *
 * @author Ben Pilgrim <ben@terragaming.co.uk>
 * @copyright Terra Gaming Network <email@terragaming.co.uk>
 *
 * @package  ProjectBifrost/BifrostWebsite
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bifrost\Web;

use Config;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class WebServiceProvider extends ServiceProvider{
	
	protected $namespace = 'Bifrost\Web\Controllers';

	public function boot(Router $router){
		parent::boot($router);
	}

	public function map(Router $router){

		$router->group([
			'namespace' => $this->namespace,
			'domain' => Config::get('app.domain',''),
		], function($router){
			require 'routes.php';
		});

	}

}