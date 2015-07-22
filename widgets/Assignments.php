<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\rbac\widgets;

use matacms\rbac\components\DbManager;
use matacms\rbac\models\Assignment;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class Assignments extends Widget
{

    public $userModel;

    public $form;

    /** @var integer ID of the user to whom auth items will be assigned. */
    public $userId;

    /** @var DbManager */
    protected $manager;

    /** @inheritdoc */
    public function init()
    {
        parent::init();
        $this->manager = Yii::$app->authManager;

        if ($this->userModel === null) {
            throw new InvalidConfigException('You should set ' . __CLASS__ . '::$userModel');
        }

        if ($this->form === null) {
            throw new InvalidConfigException('You should set ' . __CLASS__ . '::$form');
        }
    }

    /** @inheritdoc */
    public function run()
    {
        return $this->form->field($this->userModel, 'RoleAssignments')->roleAssignments();
    }
}
