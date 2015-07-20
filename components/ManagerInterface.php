<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\rbac\components;

use yii\rbac\ManagerInterface as BaseManagerInterface;

interface ManagerInterface extends BaseManagerInterface
{
    /**
     * @param  integer|null $type
     * @param  array        $excludeItems
     * @return mixed
     */
    public function getItems($type = null, $excludeItems = []);

    /**
     * @param  integer $userId
     * @return mixed
     */
    public function getItemsByUser($userId);

    /**
     * @param  string $name
     * @return mixed
     */
    public function getItem($name);
}
