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

 namespace Bifrost\Core\Transformers;

use League\Fractal\TransformerAbstract as BaseTransform;

abstract class AbstractTransform extends BaseTransform{

	public function getScopes(){
		return $auth = app('Dingo\Api\Auth\Auth')->getProviderUsed()->getScopes();
	}

	public function hasScope($scope){
		return app('Dingo\Api\Auth\Auth')->getProviderUsed()->hasScope($scope);
	}

}