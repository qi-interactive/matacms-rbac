<?php

/*
 * This file is part of the mata project.
 *
 * (c) mata project <http://github.com/mata>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var $this yii\web\View
 */

use yii\bootstrap\Nav;

?>

<?= Nav::widget([
    'options' => [
        'class' => 'nav-tabs'
    ],
    'items' => [
        [
            'label'   => Yii::t('rbac', 'Users'),
            'url'     => ['/user/admin/index'],
            'visible' => isset(Yii::$app->extensions['matacms/user']),
        ],
        [
            'label' => Yii::t('rbac', 'Roles'),
            'url'   => ['/rbac/role/index'],
        ],
        [
            'label' => Yii::t('rbac', 'Permissions'),
            'url'   => ['/rbac/permission/index'],
        ],
        [
            'label' => Yii::t('rbac', 'Create'),
            'items' => [
                [
                    'label'   => Yii::t('rbac', 'New user'),
                    'url'     => ['/user/admin/create'],
                    'visible' => isset(Yii::$app->extensions['matacms/user']),
                ],
                [
                    'label' => Yii::t('rbac', 'New role'),
                    'url'   => ['/rbac/role/create']
                ],
                [
                    'label' => Yii::t('rbac', 'New permission'),
                    'url'   => ['/rbac/permission/create']
                ]
            ]
        ]
    ]
]) ?>
