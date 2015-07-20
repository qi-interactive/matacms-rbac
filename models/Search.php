<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\rbac\models;

use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\db\Query;

class Search extends Model
{
    /** @var string */
    public $name;

    /** @var string */
    public $description;

    /** @var string */
    public $rule_name;

    /** @var \matacms\rbac\components\DbManager */
    protected $manager;

    /** @var int */
    protected $type;

    /** @inheritdoc */
    public function __construct($type, $config = [])
    {
        parent::__construct($config);
        $this->manager = \Yii::$app->authManager;
        $this->type    = $type;
    }

    /** @inheritdoc */
    public function scenarios()
    {
        return [
            'default' => ['name', 'description', 'rule_name'],
        ];
    }

    /**
     * @param  array              $params
     * @return ActiveDataProvider
     */
    public function search($params = [])
    {
        $dataProvider = \Yii::createObject(ArrayDataProvider::className());

        $query = (new Query)->select(['name', 'description', 'rule_name'])
                ->andWhere(['type' => $this->type])
                ->from($this->manager->itemTable);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'rule_name', $this->rule_name]);
        }

        $dataProvider->allModels = $query->all();

        return $dataProvider;
    }
}
