<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 06.02.15
 * Time: 21:44
 */

namespace app\controllers;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function actionIndex(){
        return $this->render('index', [
        ]);
    }
}