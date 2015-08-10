<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\rbac\models;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;

class Permission extends Item
{
    /** @inheritdoc */
    public function getUnassignedItems()
    {
        return ArrayHelper::map($this->manager->getItems(Item::TYPE_PERMISSION, $this->item !== null ? [$this->item->name] : []), 'name', function ($item) {
            return empty($item->description) ? $item->name : $item->name . ' (' . $item->description . ')';
        });
    }

    /** @inheritdoc */
    protected function createItem($name)
    {
        return $this->manager->createPermission($name);
    }
}
