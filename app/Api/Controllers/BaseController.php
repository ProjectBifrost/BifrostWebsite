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

namespace Bifrost\Api\Controllers;

use Bifrost\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

abstract class BaseController extends Controller{
	use Helpers;

	public $transformer = '';

	protected function getTransformer(){
		return new $this->transformer;
	}

	public function edit($id){
		return $this->update($id);
	}

	public function getScopes(){
		return $auth = app('Dingo\Api\Auth\Auth')->getProviderUsed()->getScopes();
	}

	public function hasScope($scope){
		return app('Dingo\Api\Auth\Auth')->getProviderUsed()->hasScope($scope);
	}
}