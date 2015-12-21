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

namespace Bifrost\Api;

use Config;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Routing\Router;
use Dingo\Api\Provider\LaravelServiceProvider as BaseApiProvider;
use Dingo\Api\Routing\Adapter\Laravel as LaravelAdapter;
use League\Fractal\Manager as Fractal;
use League\Fractal\Serializer\JsonApiSerializer;
use Dingo\Api\Transformer\Adapter\Fractal as FractalAdapter;

use Bifrost\Api\OAuth2Provider;

class ApiServiceProvider extends BaseApiProvider{

	protected $namespace = 'Bifrost\Api\Controllers';

	/**
	 * {@inheritdoc}
	 */
	public function boot(){

		parent::boot();

		app(Auth::class)->extend('oauth', function($app){
			$provider = new OAuth2Provider(app('oauth2-server.authorizer')->getChecker());

			$provider->setUserResolver(function($id){
				return Account::find($id)->first();
			});

			$provider->setClientResolver(function($id){
				return Client::find($id)->first();
			});

			return $provider;
		});

		app('Dingo\Api\Transformer\Factory')->setAdapter(function ($app) {
		    $fractal = new Fractal;
		    $fractal->setSerializer(new JsonApiSerializer(
		    	Config::get('api.domain', '')
		    ));
		    return new FractalAdapter($fractal);
		});

		app('Dingo\Api\Transformer\Factory')->register(
			'Bifrost\Core\Account',
			'Bifrost\Core\Transformers\AccountTransformer'
		);

		app('Dingo\Api\Routing\Router')->version('v1',[
			'namespace' => $this->namespace,
		], function($router){
			require 'routes.php';
		});

	}

	/**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    	parent::register();
    }
}