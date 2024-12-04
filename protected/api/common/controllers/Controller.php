<?php

namespace app\api\common\controllers;

use Yii;

class Controller extends \yii\rest\Controller
{
    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'index' => ['GET'],
            'view' => ['GET'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
            'search' => ['HEAD']
        ];
    }
}