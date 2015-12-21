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

namespace Bifrost\Core\Traits;

trait EventGeneratorTrait{

	/**
	 * @var array
	 */
	protected $pendingEvents = [];

	/**
	 * Raise a new event.
	 * 
	 * @param  mixed $event
	 */
	public function raise($event){
		$this->pendingEvents[] = $event;
	}

	/**
	 * Return and reset all pending events.
	 * 
	 * @return array
	 */
	public function releaseEvents(){
		$events = $this->pendingEvents;

		$this->pendingEvents = [];

		return $events;
	}
}