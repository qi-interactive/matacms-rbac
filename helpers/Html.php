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
				$retFields .= self::wrapCheckbox($options["name"], $item->name, null, $options["values"]);
			}
			else {
				$retFields .= self::wrapCheckbox($options["name"], $item->name, null, $options["values"]);
				foreach($item->children as $child) {
					$retFields .= self::wrapCheckbox($options["name"], $child->name, $item->name, $options["values"], 1);
				}
			}

		}

		$retFields .= '</div>';

		\Yii::$app->view->registerJs("

			$('.role-assigments input:checkbox').change(function() {
				var isChecked = $(this).attr('checked') !== undefined,
				parentItem = $(this).attr('data-parent');

				if(isChecked && parentItem != null) {
					var parentCheckedOnInit = $('input[value=\"' + parentItem + '\"]').attr('data-checked') !== undefined;

					if(!parentCheckedOnInit)
						$('input[value=\"' + parentItem + '\"]').prop('checked', false).removeAttr('checked').removeAttr('data-checked');

					$(this).prop('checked', false).removeAttr('checked').removeAttr('data-checked');
				}

				if(!isChecked && parentItem != null) {
					var parentCheckedOnInit = $('input[value=\"' + parentItem + '\"]').attr('data-checked') !== undefined;
					if(!parentCheckedOnInit)
						$('input[value=\"' + parentItem + '\"]').prop('checked', true).attr('checked', 'checked');
					$(this).prop('checked', true).attr('checked', 'checked').attr('data-checked', 'true');
				}

				if(!isChecked && parentItem == null) {
					$(this).attr('checked', 'checked');
				}

				if(isChecked && parentItem == null) {
					$(this).removeAttr('checked').removeAttr('data-checked');
					$('input[data-parent=\"' + $(this).val() + '\"]').prop('checked', false).removeAttr('checked').removeAttr('data-checked');
				}
			});
		", View::POS_READY);


		return $retFields;
	}

	public static function wrapCheckbox($name, $itemName, $parentName = null, $values, $level = 0) {
		$checked = in_array($itemName, $values);
		return '<div class="level-' . $level . '"><label class="checkbox-wrapper"><input type="checkbox" name="' . $name . '[]" value="' . $itemName . '" ' . ($checked == true ? 'checked="checked" data-checked="true"': '') .' ' . ($parentName!=null ? 'data-parent="' . $parentName . '"' : '') . '><div></div><span class="checkbox-label">' . $itemName . '</span></label></div>';
	}

}
