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

namespace Terra\Core\Traits;

use Terra\Core\Actor;
use Illuminate\Contracts\Events\Dispatcher;

trait DispatchEventsTrait
{

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * Dispatch all events for an entity.
     *
     * @param object $entity
     * @param User $actor
     */
    public function dispatchEventsFor($entity, Actor $actor = null)
    {
        foreach ($entity->releaseEvents() as $event) {
            $event->actor = $actor;
            $this->events->fire($event);
        }
    }
}