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

use Bifrost\Core\Transformers\AbstractTransformer;
use Bifrost\Core\Account;

class AccountTransformer extends AbstractTransformer{

	public function transform(Account $account){

		$result = array();

		$result['id'] = (int)$account->id;
		$result['username'] = $account->username;

		if ($this->hasScope('account.email')){
			$result['email'] = $account->email;
		}

		$result['created_at'] = (new \DateTime($account->created_at))->format(\DateTime::ATOM);
		$result['updated_at'] = (new \DateTime($account->updated_at))->format(\DateTime::ATOM);
		$result['last_seen_at'] = (new \DateTime($account->last_seen_at))->format(\DateTime::ATOM);

		return $result;
	}

}