<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">

        <!--header -->
        <div class="app-header navbar ng-scope">
            <div class="navbar-header bg-black">
                <!-- brand -->
                <a href="#" class="navbar-brand text-lt">
                    <i class="fa fa-btc"></i>
                    <img src="/img/logo.png" alt="." class="hide">
                    <span class="hidden-folded m-l-xs">Диплом</span>
                </a>
                <!-- / brand -->
            </div>
            <!-- / navbar header -->

            <!-- navbar collapse -->
            <div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only">
                <!-- nabar right -->
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href class="dropdown-toggle clear">
                          <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                            <i class="fa fa-user fa-2x"></i>
                          </span>

                            <span class="hidden-sm hidden-md">Вітаю, адміністратора.</span>
                        </a>
                    </li>
                    <li class="logout">
                        <button class="btn btn-info btnLogout">Вийти <i class="fa fa-sign-out"></i>
                         </button>
                    </li>
                </ul>
                <!-- / navbar right -->
                <div class="prognozInfo">
                    <ul>
                        <li>
                            <a href="<?php echo Yii::$app->urlManager->createUrl('methods/medium'); ?>">
                                Прогноз методом ковзного середнього
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Yii::$app->urlManager->createUrl('methods/holt-and-braun'); ?>">
                                Прогноз методом Хольта-Брауна
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Yii::$app->urlManager->createUrl('methods/vinters'); ?>">
                                Прогноз методом Вінтерса
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>


        <!-- end header-->

        <!--navbar -->
        <div class="app-aside hidden-xs bg-black">
            <div class="aside-wrap ng-scope">
                <div class="navi-wrap">
                    <nav class="navi ng-scope" ng-include="'tpl/blocks/nav.html'">
                        <ul class="nav">
                             <li>
                                <a href="<?php echo Yii::$app->urlManager->createUrl('currencies/change-currency'); ?>">
<!--                                    <i class="glyphicon glyphicon-th-large icon text-success"></i>-->
<!--                                    <i class="glyphicon glyphicon-calendar icon text-info-dker"></i>-->
                                    <i class="fa fa-calendar"></i>
                                    <span class="font-bold">Змінити валюту</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo Yii::$app->urlManager->createUrl('methods/optimal'); ?>">

                                    <i class="fa fa-line-chart"></i>
                                    <span class="font-bold">Оптимальний прогноз</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo Yii::$app->urlManager->createUrl('currencies/get-exchange-rates'); ?>">
                                    <i class="fa fa-area-chart"></i>
                                    <span class="font-bold">Архів курсу</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo Yii::$app->urlManager->createUrl('currencies/get-forecasts'); ?>">
<!--                                    <i class="glyphicon glyphicon-list"></i>-->
                                    <i class="glyphicon glyphicon-signal"></i>
                                    <span class="font-bold">Архів прогнозів</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo Yii::$app->urlManager->createUrl('methods/find-optimal'); ?>">
<!--                                    <i class="glyphicon glyphicon-list"></i>-->
                                    <i class="fa fa-bar-chart"></i>
                                    <span class="font-bold">Прогнози vs Курси</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo Yii::$app->urlManager->createUrl('currencies/mat-model'); ?>">
                                    <i class="fa fa-book"></i>
                                    <span class="font-bold">Мат.модель</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo Yii::$app->urlManager->createUrl('currencies/info'); ?>">
                                    <i class="fa fa-info"></i>
                                    <span class="font-bold">Довідка</span>
                                </a>
                            </li> <li>
                                <a href="<?php echo Yii::$app->urlManager->createUrl('currencies/about'); ?>">
                                    <i class="glyphicon glyphicon-briefcase icon"></i>
                                    <span class="font-bold">Про программу</span>
                                </a>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- end navbar -->
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
