<?php
 
namespace common\overrides\filters;

class AccessRule extends \yii\filters\AccessRule
{
    public $roleAttribute = 'role';
    /**
     * @inheritdoc
     */
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }
        if (in_array('?', $this->roles) && $user->getIsGuest()) {
            return true;
        }
        if (in_array('@', $this->roles) && !$user->getIsGuest()) {
            return true;
        }
        if (!$user->getIsGuest() && in_array($user->identity->{$this->roleAttribute}, $this->roles)) {
            return true;
        }
        return false;
    }
}
