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
use Bifrost\Core\Actor;

use Bifrost\Events\Event;
use Illuminate\Queue\SerializesModels;

class AccountWasActivated extends Event{
	use SerializesModels;

	public $account;

	public $actor;

	public function __construct(Account $account, Actor $actor = null){
		$this->account = $account;
		$this->actor = $actor;
	}
}