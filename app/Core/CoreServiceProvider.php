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

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider{

	public function register(){

	}

	public function boot(){
		$this->app->make('Illuminate\Contracts\Bus\Dispatcher')->mapUsing(function ($command){
			$path = explode('\\',get_class($command));
			$name = array_pop($path);
			array_pop($path);
			$path = implode('\\', $path);
			$path .= '\\Handlers\\';
			$path .= $name . 'Handler@handle';

			return $path;
		});

		Account::setHasher($this->app->make('hash'));

		$events = $this->app->make('events');

		$events->subscribe('Bifrost\Core\Listeners\EmailConfirmationMailer');
	}

}