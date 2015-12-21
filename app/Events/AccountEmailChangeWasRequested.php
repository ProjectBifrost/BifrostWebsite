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

namespace Bifrost\Events;

use Bifrost\Core\Account;

use Bifrost\Events\Event;
use Illuminate\Queue\SerializesModels;

class AccountPasswordWasChanged extends Event{
	use SerializesModels;

	public $account;

	public $email;

	public function __construct(Account $account, $email){
		$this->account = $account;
		$this->email = $email;
	}
}