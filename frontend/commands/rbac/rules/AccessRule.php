<?php
/**
 * Created by PhpStorm.
 * User: Edson
 * Date: 07/02/2016
 * Time: 03:17
 */

namespace frontend\commands\rbac\rules;
use common\models\User;


class AccessRule extends \yii\filters\AccessRule
{
    public $role_admin="isAdmin";
    public $rele_sysadmin="isSysAdmin";
    protected function matchRole($user)
    {

       if (empty($this->roles)) {
            print_r($this->roles);
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role === '?') {
                if ($user->getIsGuest()) {
                    return true;
                }
            } elseif ($role === '@') {
                if (!$user->getIsGuest()) {
                    return true;
                }
                // Check if the user is logged in, and the roles match
            } elseif (!$user->getIsGuest() && $role === $user->identity->role) {
                print($role);
                return true;
            }
        }

        return false;
    }
}
