<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 06.02.15
 * Time: 21:44
 */

namespace app\controllers;

use yii\rest\ActiveController;

class TestController extends ActiveController
{
    public $modelClass = 'app\models\User';
}