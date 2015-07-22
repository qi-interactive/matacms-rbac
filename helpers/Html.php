<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\rbac\helpers;

use yii\helpers\ArrayHelper;
use matacms\widgets\Selectize;
use matacms\helpers\Html as BaseHtml;
use yii\web\View;

class Html extends BaseHtml {

	public static function activeRoleAssignmentsField($model, $attribute, $options = []) {
        $authManager = \Yii::$app->authManager;
		$items = ArrayHelper::map($authManager->getItems(1), 'name', 'name');
		$value = $model->isNewRecord ? [] : ArrayHelper::getColumn($authManager->getItemsByUser($model->getId()), 'name');

		if ($value != null)
			$options["value"] = $value;

		if(!empty($_POST['RoleAssignments']))
			$options["value"] = $_POST[CategoryItem::REQ_PARAM_CATEGORY_ID];

		$options["name"] = 'RoleAssignments';

		$options['id'] = self::getInputId($model, $attribute);

		$prompt = 'Select ' . $model->getAttributeLabel($attribute);
        if(isset($options['prompt'])) {
            $prompt = $options['prompt'];
            unset($options['prompt']);
        }

		$options = ArrayHelper::merge([
			'items' => $items,
			'options' => ['multiple'=>true, 'prompt' => $prompt],
			'clientOptions' => [
			'plugins' => ["remove_button", "drag_drop", "restore_on_backspace"],
			'create' => false,
			'persist' => false,
			]
			], $options);

		return Selectize::widget($options);
	}

}
