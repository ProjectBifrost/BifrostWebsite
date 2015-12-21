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

namespace Bifrost\Core\Listeners;

use Bifrost\Core;
use Bifrost\Core\Account;
use Bifrost\Events\AccountEmailChangeWasRequested;
use Bifrost\Events\AccountWasCreated;
use Illuminate\Contracts\Events\Dispatcher;
use Mail;
use Illuminate\Mail\Message;

class EmailConfirmationMailer{

	public function subscribe(Dispatcher $events){ 
		$events->listen(AccountWasCreated::class, [$this,'whenAccountWasCreated']);
		$events->listen(AccountEmailChangeWasRequested::class, [$this,'whenAccountEmailChangeWasRequested']);
	}

	public function whenAccountWasCreated(AccountWasCreated $event){
		$account = $event->account;
		if ($account->is_activated){
			return;
		}

		$this->sendMail($account, $account->email);
	}

	public function whenAccountEmailChangeWasRequested(AccountEmailChangeWasRequested $event){
		$this->sendMail($event->account, $event->email);
	}

	public function sendMail(Account $account, $email){
		Mail::send('emails.confirm', $this->getEmailData($account, $email), function ($m) use ($account, $email){
			$m->from('no-reply@projectbifrost.com', 'Project Bifrost');
			$m->to($email, $account->username)->subject('[ProjectBifrost] Email Confirmation');
		});
	}

 	protected function generateToken(Account $account, $email){
        $token = EmailToken::generate($email, $account->id);
        $token->save();
        return $token;
    }

	protected function getEmailData(Account $account, $email){
        $token = $this->generateToken($account, $email);
        return [
            'account' => $account,
            'token' => $token,
            'url' => url('account.emailconfirm', ['token' => $token->id]),
        ];
    }

}