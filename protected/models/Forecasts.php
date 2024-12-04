<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 10.02.15
 * Time: 21:26
 */
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Forecasts extends ActiveRecord
{
    public static function tableName()
    {
//        return 'forecasts';
        return 'forecast';
    }
}