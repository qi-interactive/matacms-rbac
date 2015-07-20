<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\rbac\validators;

use yii\validators\Validator;

class RbacValidator extends Validator
{
    /** @var \matacms\rbac\components\DbManager */
    protected $manager;

    /** @inheritdoc */
    public function init()
    {
        parent::init();
        $this->manager = \Yii::$app->authManager;
    }

    /** @inheritdoc */
    protected function validateValue($value)
    {
        if (!is_array($value)) {
            return [\Yii::t('rbac', 'Invalid value'), []];
        }

        foreach ($value as $val) {
            if ($this->manager->getItem($val) == null) {
                return [\Yii::t('rbac', 'There is neither role nor permission with name "{0}"', [$val]), []];
            }
        }
    }
}
