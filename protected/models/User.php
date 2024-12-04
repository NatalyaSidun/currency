<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 06.02.15
 * Time: 21:57
 */
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord {

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['name', 'login'], 'string'],
            [['name', 'login'], 'safe']
        ];
    }

    public function getAllUsers(){
        return $this->find()->all();
    }
}