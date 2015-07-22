<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\rbac;

use matacms\rbac\components\DbManager;
use matacms\rbac\components\ManagerInterface;
use matacms\rbac\behaviors\RoleAssignmentActiveFormBehavior;
use matacms\rbac\models\Assignment;
use matacms\user\Module as UserModule;
use matacms\widgets\ActiveField;
use matacms\controllers\module\Controller;
use matacms\user\controllers\AdminController as AdminController;
use mata\base\MessageEvent;
use yii\base\Application;
use yii\base\Event;
use yii\base\BootstrapInterface;

/**
 * Bootstrap class registers translations and needed application components.
 */
class Bootstrap implements BootstrapInterface
{
    /** @inheritdoc */
    public function bootstrap($app)
    {
        // register translations
        $app->get('i18n')->translations['rbac*'] = [
            'class'    => 'yii\i18n\PhpMessageSource',
            'basePath' => __DIR__ . '/messages',
        ];

        if ($this->checkRbacModuleInstalled($app)) {
            // register auth manager
            if (!$this->checkAuthManagerConfigured($app)) {
                $app->set('authManager', [
                    'class' => DbManager::className(),
                ]);
            }

            // if matacms/matacms-user extension is installed, copy admin list from there
            if ($this->checkUserModuleInstalled($app)) {
                $app->getModule('rbac')->admins = $app->getModule('user')->admins;
            }
        }

        Event::on(ActiveField::className(), ActiveField::EVENT_INIT_DONE, function(MessageEvent $event) {
            $event->getMessage()->attachBehavior('roleAssignments', new RoleAssignmentActiveFormBehavior());
        });

        Event::on(AdminController::class, Controller::EVENT_MODEL_UPDATED, function(\matacms\base\MessageEvent $event) {
            $this->processSave($event->getMessage());
        });

        Event::on(AdminController::class, Controller::EVENT_MODEL_CREATED, function(\matacms\base\MessageEvent $event) {
            $this->processSave($event->getMessage());
        });
    }

    /**
     * Verifies that matacms/matacms-rbac is installed and configured.
     * @param  Application $app
     * @return bool
     */
    protected function checkRbacModuleInstalled(Application $app)
    {
        return $app->hasModule('rbac') && $app->getModule('rbac') instanceof Module;
    }

    /**
     * Verifies that matacms/matacms-user is installed and configured.
     * @param  Application $app
     * @return bool
     */
    protected function checkUserModuleInstalled(Application $app)
    {
        return $app->hasModule('user') && $app->getModule('user') instanceof UserModule;
    }

    /**
     * Verifies that authManager component is configured.
     * @param  Application $app
     * @return bool
     */
    protected function checkAuthManagerConfigured(Application $app)
    {
        return $app->authManager instanceof ManagerInterface;
    }

    private function processSave($model) {

        if (empty($roles = \Yii::$app->request->post('RoleAssignments')))
            return;

        $userId = $model->getId();

        \Yii::$app->authManager->deleteAllItemsByUser($userId);

        if(is_array($roles)) {
            foreach ($roles as $role) {
                $this->saveRoleAssignment($role, $model, $userId);    
            }
        } elseif(is_string($roles)) {
            $this->saveRoleAssignment($roles, $model, $userId);
        }
    }

    private function saveRoleAssignment($roleName, $model, $userId)
    {
        $auth = \Yii::$app->authManager;
        $assignmentItem = $auth->getItemByUser($roleName, $userId);

        if ($assignmentItem == null) {

            $role = $auth->getRole($roleName);
            $assignment = $auth->assign($role, $userId);

            if(empty($assignment))
                throw new \yii\web\ServerErrorHttpException(\yii\helpers\CVarDumper::dumpAsString($assignment));

        }
    }
}
