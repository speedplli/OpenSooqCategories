<?php

namespace app\controllers;

use app\models\Category;
use moonland\phpexcel\Excel;
use yii\filters\auth\HttpBasicAuth;

class CategoryController extends \yii\rest\ActiveController {

    public $modelClass = 'app\models\Category';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
        ];
        return $behaviors;
    }

}
