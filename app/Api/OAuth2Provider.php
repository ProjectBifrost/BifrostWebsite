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

use Dingo\Api\Auth\Provider\OAuth2;

class OAuth2Provider extends OAuth2{

	public function getScopes(){
		return $this->resource->getAccessToken()->getScopes();
	}

	public function hasScope($scope){
		return $this->resource->getAccessToken()->hasScope($scope);
	}

	public function token(){
		return $this->resource->getAccessToken();
	}
	
}