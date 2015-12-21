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
 use Bifrost\Core\Traits\EventGeneratorTrait;

 abstract class Actor extends AbstractModel{
 	use EventGeneratorTrait;

 	public function isGuest(){
 		return false;
 	}

 }