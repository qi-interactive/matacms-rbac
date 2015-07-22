<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\rbac\behaviors;

use Yii;
use mata\category\models\Category;
use mata\category\models\CategoryItem;
use matacms\rbac\helpers\Html;
use yii\helpers\ArrayHelper;

class RoleAssignmentActiveFormBehavior extends \yii\base\Behavior {

	public function roleAssignments($options = []) {
		if(isset($this->owner->options['class'])) {
		    $this->owner->options['class'] .= ' multi-choice-dropdown partial-max-width-item';
		} else {
			$this->owner->options['class'] = ' multi-choice-dropdown partial-max-width-item';
		}

		$options = array_merge($this->owner->inputOptions, $options);

		$this->owner->adjustLabelFor($options);
		$this->owner->parts['{input}'] = Html::activeRoleAssignmentsField($this->owner->model, $this->owner->attribute, $options);

		return $this->owner;
	}

}
