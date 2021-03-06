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

namespace Bifrost\Database;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\Relation;
use LogicException;

use Terra\Events\ConfigureModelDates;
use Terra\Events\GetModelRelationship;

abstract class AbstractModel extends Eloquent{

	/**
	 * Indicates if the model should be timestamped. Turn off by default.
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * An array of callbacks to be run once after the model is saved.
	 * @var callable[]
	 */
	protected $afterSaveCallbacks = [];

	/**
	 * An array of callbacks to be run once after the model is deleted.
	 * @var callable[]
	 */
	protected $afterDeleteCallbacks = [];

	/**
	 * {@inheritdoc}
	 */
	public static function boot(){
		parent::boot();

		static::saved(function(AbstractModel $model){
			foreach ($model->releaseAfterSaveCallbacks() as $callback){
				$callback($model);
			}
		});

		static::deleted(function(AbstractModel $model){
			foreach ($model->releaseAfterDeleteCallbacks() as $callback){
				$callback($model);
			}
		});
	}

    /**
     * Get the attributes that should be converted to dates.
     *
     * @return array
     */
    public function getDates()
    {
        static $dates = [];
        $class = get_class($this);
        if (! isset($dates[$class])) {
            static::$dispatcher->fire(
                new ConfigureModelDates($this, $this->dates)
            );
            $dates[$class] = $this->dates;
        }
        return $dates[$class];
    }

    /**
     * Get an attribute from the model. If nothing is found, attempt to load
     * a custom relation method with this key.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (! is_null($value = parent::getAttribute($key))) {
            return $value;
        }
        // If a custom relation with this key has been set up, then we will load
        // and return results from the query and hydrate the relationship's
        // value on the "relationships" array.
        if (! $this->relationLoaded($key) && ($relation = $this->getCustomRelation($key))) {
            if (! $relation instanceof Relation) {
                throw new LogicException('Relationship method must return an object of type '
                    . 'Illuminate\Database\Eloquent\Relations\Relation');
            }
            return $this->relations[$key] = $relation->getResults();
        }
    }

    /**
     * Get a custom relation object.
     *
     * @param string $name
     * @return mixed
     */
    protected function getCustomRelation($name)
    {
        return static::$dispatcher->until(
            new GetModelRelationship($this, $name)
        );
    }

	/**
     * Register a callback to be run once after the model is saved.
     *
     * @param callable $callback
     * @return void
     */
    public function afterSave($callback)
    {
        $this->afterSaveCallbacks[] = $callback;
    }

    /**
     * Register a callback to be run once after the model is deleted.
     *
     * @param callable $callback
     * @return void
     */
    public function afterDelete($callback)
    {
        $this->afterDeleteCallbacks[] = $callback;
    }

    /**
     * @return callable[]
     */
    public function releaseAfterSaveCallbacks()
    {
        $callbacks = $this->afterSaveCallbacks;
        $this->afterSaveCallbacks = [];
        return $callbacks;
    }

    /**
     * @return callable[]
     */
    public function releaseAfterDeleteCallbacks()
    {
        $callbacks = $this->afterDeleteCallbacks;
        $this->afterDeleteCallbacks = [];
        return $callbacks;
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $arguments)
    {
        if ($relation = $this->getCustomRelation($method)) {
            return $relation;
        }
        return parent::__call($method, $arguments);
    }
}