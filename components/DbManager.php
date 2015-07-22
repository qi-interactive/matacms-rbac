<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\rbac\components;

use yii\db\Query;
use yii\rbac\DbManager as BaseDbManager;

/**
 * This Auth manager changes visibility and signature of some methods from \yii\rbac\DbManager.
 */
class DbManager extends BaseDbManager implements ManagerInterface
{
    /**
     * @param  int|null $type         If null will return all auth items.
     * @param  array    $excludeItems Items that should be excluded from result array.
     * @return array
     */
    public function getItems($type = null, $excludeItems = [])
    {
        $query = (new Query())
            ->from($this->itemTable);

        if ($type !== null) {
            $query->where(['type' => $type]);
        } else {
            $query->orderBy('type');
        }

        foreach ($excludeItems as $name) {
            $query->andWhere('name != :item', ['item' => $name]);
        }

        $items = [];

        foreach ($query->all($this->db) as $row) {
            $items[$row['name']] = $this->populateItem($row);
        }

        return $items;
    }

    /**
     * Returns both roles and permissions assigned to user.
     *
     * @param  integer $userId
     * @return array
     */
    public function getItemsByUser($userId)
    {
        if (empty($userId)) {
            return [];
        }

        $query = (new Query)->select('b.*')
            ->from(['a' => $this->assignmentTable, 'b' => $this->itemTable])
            ->where('{{a}}.[[item_name]]={{b}}.[[name]]')
            ->andWhere(['a.user_id' => (string) $userId]);

        $roles = [];
        foreach ($query->all($this->db) as $row) {
            $roles[$row['name']] = $this->populateItem($row);
        }
        return $roles;
    }

    /** @inheritdoc */
    public function getItem($name)
    {
        return parent::getItem($name);
    }

    /**
     * Deleted roles and permissions assigned to user.
     *
     * @param  integer $userId
     * @return array
     */
    public function deleteAllItemsByUser($userId)
    {
        if (empty($userId)) {
            return [];
        }

        $command = \Yii::$app->getDb()->createCommand();
        $command->delete($this->assignmentTable, 'user_id = :user_id', ['user_id' => $userId]);
        return $command->execute();
    }

    /**
     * Returns both roles and permissions assigned to user.
     *
     * @param  integer $userId
     * @return array
     */
    public function getItemByUser($itemName, $userId)
    {
        if (empty($userId)) {
            return [];
        }

        $query = (new Query)->select('b.*')
            ->from(['a' => $this->assignmentTable, 'b' => $this->itemTable])
            ->where('{{a}}.[[item_name]]={{b}}.[[name]]')
            ->andWhere(['{{a}}.[[item_name]]' => (string) $itemName, 'a.user_id' => (string) $userId]);

        $role = $query->one($this->db);
        
        if(!empty($role))
            $role = $this->populateItem($role);

        return $role;
    }


}
