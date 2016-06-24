<?php

namespace common\components\traits;

use Yii;

/**
 * trait BackendBehaviorTrait
 * Use this trait to manage behaviors
 *
 * @property array $behaviors
 */
trait BehaviorTrait 
{

    public $behaviors;

    /**
     * Loads parent behavior if its empty
     */
    public function initBehaviors()
    {
        if (!$this->behaviors) {
            $this->behaviors = parent::behaviors();
        }
    }

    /**
     * Unset Behavior by its Id
     *
     * @param $behavior_id
     */
    public function unsetBehavior($behavior_id)
    {
        $this->initBehaviors();
        unset($this->behaviors[$behavior_id]);
    }
    
    /**
     * Attach new Behavior with its Id as key
     * 
     * @param type $behavior_id
     * @param type $behavior
     */
    public function attachBehavior($behavior_id, $behavior)
    {
        $this->initBehaviors();
        $this->behaviors[$behavior_id] = $behavior;
    }

    /**
     * return parent behaviors and new (if modified)
     *
     * @return array
     */
    public function getBehaviors()
    {
        return $this->behaviors;
    }
}