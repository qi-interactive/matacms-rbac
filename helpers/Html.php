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

		$values = $model->isNewRecord ? [] : ArrayHelper::getColumn($authManager->getItemsByUser($model->getId()), 'name');

		$options["values"] = $values;

		if(!empty($_POST['RoleAssignments']))
			$options["values"] = $_POST['RoleAssignments'];

		$options["name"] = 'RoleAssignments';

		$options['id'] = self::getInputId($model, $attribute);

		$prompt = 'Select ' . $model->getAttributeLabel($attribute);
        if(isset($options['prompt'])) {
            $prompt = $options['prompt'];
            unset($options['prompt']);
        }

		$retFields = '<div class="role-assigments">';



		foreach($authManager->getItems(1) as $item) {
			if(empty($item->children)) {
				$retFields .= self::wrapCheckbox($options["name"], $item->name, $options["values"]);
			}
			else {
				$retFields .= self::wrapCheckbox($options["name"], $item->name, $options["values"]);
				foreach($item->children as $child) {
					$retFields .= self::wrapCheckbox($options["name"], $child->name, $options["values"], 1);
				}
			}

		}

		$retFields .= '</div>';


		return $retFields;
	}

	public static function wrapCheckbox($name, $itemName, $values, $level = 0) {
		$checked = in_array($itemName, $values);
		return '<div class="level-' . $level . '"><label class="checkbox-wrapper"><input type="checkbox" name="' . $name . '[]" value="' . $itemName . '" ' . ($checked == true ? 'checked="checked"': '') .'><div></div><span class="checkbox-label">' . $itemName . '</span></label></div>';
	}

}
