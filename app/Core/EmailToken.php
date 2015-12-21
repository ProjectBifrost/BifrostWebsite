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

namespace Bifrost\Core;

use Bifrost\Database\AbstractModel;
use Bifrost\Core\Exceptions\InvalidConfirmationTokenException;
use DateTime;

class EmailToken extends AbstractModel{

	protected $table = 'email_tokens';

	protected $dates = ['created_at'];

	public $incrementing = false;

	public static function generate($email, $accountId){
		$token = new static;

		$token->id = str_random(40);
		$token->account_id = $accountId;
		$token->email = $email;
		$token->created_at = time();

		return $token;
	}

	public function account(){
		return $this->belongsTo('Terra\Core\Account');
	}

	public function scopeValidOrFail($query, $id){
		$token = $query->find($id);
		
		if (! $token || $token->created_at < new DateTime('-1 day')){
			throw new InvalidConfirmationTokenException;
		}

		return $token;
	}

}