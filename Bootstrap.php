<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\rbac;

use matacms\rbac\components\DbManager;
use matacms\rbac\components\ManagerInterface;
use matacms\user\Module as UserModule;
use yii\base\Application;
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
}
