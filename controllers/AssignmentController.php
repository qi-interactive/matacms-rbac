<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\rbac\controllers;

use matacms\rbac\models\Assignment;
use Yii;
use yii\web\Controller;

class AssignmentController extends Controller
{
    /**
     * Show form with auth items for user.
     *
     * @param int $id
     */
    public function actionAssign($id)
    {
        $model = Yii::createObject([
            'class'   => Assignment::className(),
            'user_id' => $id,
        ]);

        if ($model->load(\Yii::$app->request->post()) && $model->updateAssignments()) {
        }

        return \matacms\rbac\widgets\Assignments::widget([
            'model' => $model,
        ]);
        /*$model = Yii::createObject([
            'class'   => Assignment::className(),
            'user_id' => $id,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->updateAssignments()) {

        }

        return $this->render('assign', [
            'model' => $model,
        ]);*/
    }
}
