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

use Bifrost\Core\Actor;

use Bifrost\Events\AccountWasDeleted;
use Bifrost\Events\AccountWasCreated;
use Bifrost\Events\AccountWasRenamed;
use Bifrost\Events\AccountEmailWasChanged;
use Bifrost\Events\AccountEmailChangeWasRequested;
use Bifrost\Events\AccountPasswordWasChanged;
use Bifrost\Events\AccountWasActivated;

use Illuminate\Contracts\Hashing\Hasher;

class Account extends Actor{

	protected $table = 'accounts';

	protected $dates = [
		'last_seen_at',
		'created_at',
		'updated_at',
	];

	protected $permissions = null;

	protected static $hasher;

	public static function boot(){
		parent::boot();

		static::deleted(function(Account $account){
			$user->raise(new AccountWasDeleted($account));
		});
	}

	public static function setHasher(Hasher $hasher){
		static::$hasher = $hasher;
	}

	public static function register($username, $email, $password){
		$account = new static;

		$account->username = $username;
		$account->email = $email;
		$account->password = $password;
		$account->created_at = time();

		$account->raise(new AccountWasCreated($account));

		return $account;
	}

	public function rename($username){
		if ($username !== $this->username){
			$this->username = $username;

			$this->raise(new AccountWasRenamed($this));
		}

		return $this;
	}

	public function changeEmail($email){
		if ($email !== $this->email){
			$this->email = $email;

			$this->raise(new AccountEmailWasChanged($this));
		}

		return $this;
	}

	public function requestEmailChange($email){
		if ($email !== $this->email){
			$this->raise(new AccountEmailChangeWasRequested($this, $email));
		}

		return $this;
	}

	public function changePassword($password){
		$this->password = $password;

		$this->raise(new AccountPasswordWasChanged($this));
		
		return $this;
	}

    public function checkPassword($password)
    {
        return static::$hasher->check($password, $this->password);
    }

	public function activate()
    {
        $this->is_activated = true;
        
        $this->raise(new AccountWasActivated($this));
        
        return $this;
    }

	public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $value ? static::$hasher->make($value) : '';
    }

    public function getLocaleAttribute($value)
    {
        return $value ?: Application::config('locale', 'en');
    }

    public function updateLastSeen(){
    	$this->last_seen_at = time();
    }

    public function isAdmin(){
    	return $this->is_admin;
    }

    public function isGuest(){
    	return false;
    }

}