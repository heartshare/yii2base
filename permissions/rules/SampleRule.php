<?php
namespace gxc\yii2base\permissions\rules;

use yii\rbac\Rule;

/**
 * A sample Rule used to demonstrate RBAC of GXC
 */
class SampleRule extends Rule
{
    public $name = 'sampleRule';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return true;
    }
}