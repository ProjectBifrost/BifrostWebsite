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


use Dingo\Api\Facade\Route;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Terra\Api\Transformers\AccountTransformer;
use Terra\Core\Account;

use Dingo\Api\Routing\Helpers;

// Accounts

Route::resource('accounts', 'AccountController');