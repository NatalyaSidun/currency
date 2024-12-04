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

class Currencies extends ActiveRecord
{
    public static function tableName()
    {
        return 'currencies';
    }
}