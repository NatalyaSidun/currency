<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 06.02.15
 * Time: 21:44
 */

namespace app\controllers;

use app\models\ForecastsMedium;
use app\models\ForecastsVinters;
use Yii;
use yii\web\Controller;
use app\models\ExchangeRates;
use yii\helpers\Json;
use app\models\ForecastsHolt;
use app\models\Currencies;
use app\models\OptimalForecast;
use app\models\User;
use yii\web\Session;

class AjaxController extends Controller
{


    public function  actionGetExchangeRates(){

        $session = new Session();
        $session->open();
        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $currency = Currencies::find()->where(["id" => $session['cur_id']])->one();

        $exchangeRates = ExchangeRates::find()
            ->where(["id_currency"=> $session['cur_id']])
            ->orderBy('date')
            ->all();
        $exchangeData = [];
        $dates = [];
        foreach ($exchangeRates as $exchangeRate){
            $exchangeData[] = [$exchangeRate->date, $exchangeRate->value];
            $dates[] = $exchangeRate->date;
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = ['data' => $exchangeData, 'dates' => $dates,'currency' => $currency];
        return $data;
    }

    public function  actionGetForecastForDate(){

        $session = new Session();
        $session->open();
        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $today = $_GET["date"];
        if($_GET["date"] == "today"){
            $today = date("Y-m-d");
        }else{
            $today = $_GET["date"];
        }
        $currency = Currencies::find()->where(["id" => $session['cur_id']])->one();
        $lastDay = ForecastsHolt::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $today])
            ->orderBy('k ASC')
            ->limit(9)
            ->all();


        $data = ['data' => $lastDay, 'currency' => $currency];
        return $data;
    }

    public function  actionGetForecastMediumForDate(){

        $session = new Session();
        $session->open();
        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $today = $_GET["date"];
        if($_GET["date"] == "today"){
            $today = date("Y-m-d");
        }else{
            $today = $_GET["date"];
        }
        $currency = Currencies::find()->where(["id" => $session['cur_id']])->one();
        $lastDay = ForecastsMedium::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $today])
            ->orderBy('a ASC')
            ->limit(9)
            ->all();


        $data = ['data' => $lastDay, 'currency' => $currency];
        return $data;
    }

    public function  actionGetForecastVintersForDate(){

        $session = new Session();
        $session->open();
        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $today = $_GET["date"];
        if($_GET["date"] == "today"){
            $today = date("Y-m-d");
        }else{
            $today = $_GET["date"];
        }
        $currency = Currencies::find()->where(["id" => $session['cur_id']])->one();

        $forecastForQ1 = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $today, "q" =>0.1])
            ->orderBy('k ASC')
            ->all();

        $forecastForQ2 = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $today, "q" =>0.3])
            ->orderBy('k ASC')
            ->all();

        $forecastForQ3 = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $today, "q" =>0.5])
            ->orderBy('k ASC')
            ->all();

        $forecastForQ4 = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $today, "q" =>0.7])
            ->orderBy('k ASC')
            ->all();

        $forecastForQ5 = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $today, "q" =>0.9])
            ->orderBy('k ASC')
            ->all();

        $forecastForK1 = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $today, "k" =>0.1])
            ->orderBy('q ASC')
            ->all();

        $forecastForK2 = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $today, "k" =>0.3])
            ->orderBy('q ASC')
            ->all();

        $forecastForK3 = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $today, "k" =>0.5])
            ->orderBy('q ASC')
            ->all();

        $forecastForK4 = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $today, "k" =>0.7])
            ->orderBy('q ASC')
            ->all();

        $forecastForK5 = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $today, "k" =>0.9])
            ->orderBy('q ASC')
            ->all();

        $data = ['q1' => $forecastForQ1,
                'q2' => $forecastForQ2,
                'q3' => $forecastForQ3,
                'q4' => $forecastForQ4,
                'q5' => $forecastForQ5,
                'k1' => $forecastForK1,
                'k2' => $forecastForK2,
                'k3' => $forecastForK3,
                'k4' => $forecastForK4,
                'k5' => $forecastForK5,
                'currency' => $currency];
        return $data;
    }

    public function  actionGetForecasts(){

        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $currency = Currencies::find()->where(["id" => $session['cur_id']])->one();

        $forecastsForFirst = ForecastsHolt::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.1])
            ->orderBy('date')
            ->all();

        $forecastsForSecond = ForecastsHolt::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.2])
            ->orderBy('date')
            ->all();

        $forecastsForThird = ForecastsHolt::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.3])
            ->orderBy('date')
            ->all();

        $forecastsForFourth = ForecastsHolt::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.4])
            ->orderBy('date')
            ->all();

        $forecastsForFifth = ForecastsHolt::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.5])
            ->orderBy('date')
            ->all();

        $forecastsForSix = ForecastsHolt::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.6])
            ->orderBy('date')
            ->all();

        $forecastsForSeven = ForecastsHolt::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.7])
            ->orderBy('date')
            ->all();

        $forecastsForEight = ForecastsHolt::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.8])
            ->orderBy('date')
            ->all();

        $forecastsForNine = ForecastsHolt::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.9])
            ->orderBy('date')
            ->all();


        $data = ['dataFirst' => $forecastsForFirst,
                'dataSecond' => $forecastsForSecond,
                'dataThird' => $forecastsForThird,
                'dataFourth' => $forecastsForFourth,
                'dataFifth' => $forecastsForFifth,
                'dataSix' => $forecastsForSix,
                'dataSeven' => $forecastsForSeven,
                'dataEight' => $forecastsForEight,
                'dataNine' => $forecastsForNine,

            'currency' => $currency];
        return $data;
    }

    public function  actionGetForecastsMedium(){

        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $currency = Currencies::find()->where(["id" => $session['cur_id']])->one();

        $forecastsForFirst = ForecastsMedium::find()
            ->where(["id_currency" => $session['cur_id'], "a"=> 0.1])
            ->orderBy('date')
            ->all();

        $forecastsForSecond = ForecastsMedium::find()
            ->where(["id_currency" => $session['cur_id'], "a"=> 0.2])
            ->orderBy('date')
            ->all();

        $forecastsForThird = ForecastsMedium::find()
            ->where(["id_currency" => $session['cur_id'], "a"=> 0.3])
            ->orderBy('date')
            ->all();

        $forecastsForFourth = ForecastsMedium::find()
            ->where(["id_currency" => $session['cur_id'], "a"=> 0.4])
            ->orderBy('date')
            ->all();

        $forecastsForFifth = ForecastsMedium::find()
            ->where(["id_currency" => $session['cur_id'], "a"=> 0.5])
            ->orderBy('date')
            ->all();

        $forecastsForSix = ForecastsMedium::find()
            ->where(["id_currency" => $session['cur_id'], "a"=> 0.6])
            ->orderBy('date')
            ->all();

        $forecastsForSeven = ForecastsMedium::find()
            ->where(["id_currency" => $session['cur_id'], "a"=> 0.7])
            ->orderBy('date')
            ->all();

        $forecastsForEight = ForecastsMedium::find()
            ->where(["id_currency" => $session['cur_id'], "a"=> 0.8])
            ->orderBy('date')
            ->all();

        $forecastsForNine = ForecastsMedium::find()
            ->where(["id_currency" => $session['cur_id'], "a"=> 0.9])
            ->orderBy('date')
            ->all();


        $data = ['dataFirst' => $forecastsForFirst,
            'dataSecond' => $forecastsForSecond,
            'dataThird' => $forecastsForThird,
            'dataFourth' => $forecastsForFourth,
            'dataFifth' => $forecastsForFifth,
            'dataSix' => $forecastsForSix,
            'dataSeven' => $forecastsForSeven,
            'dataEight' => $forecastsForEight,
            'dataNine' => $forecastsForNine,

            'currency' => $currency];
        return $data;
    }

    public function  actionGetForecastsVinters(){

        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $currency = Currencies::find()->where(["id" => $session['cur_id']])->one();

        $forecastsForFirst = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.1, "q" => 0.1])
            ->orderBy('date')
            ->all();

        $forecastsForSecond = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.1, "q" => 0.7])
            ->orderBy('date')
            ->all();

        $forecastsForThird = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.3, "q" => 0.3])
            ->orderBy('date')
            ->all();

        $forecastsForFourth = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.3, "q" => 0.9])
            ->orderBy('date')
            ->all();

        $forecastsForFifth = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.5, "q" => 0.1])
            ->orderBy('date')
            ->all();

        $forecastsForSix = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.5, "q" => 0.9])
            ->orderBy('date')
            ->all();

        $forecastsForSeven = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.7, "q" => 0.3])
            ->orderBy('date')
            ->all();

        $forecastsForEight = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.7, "q" => 0.7])
            ->orderBy('date')
            ->all();

        $forecastsForNine = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.9, "q" => 0.1])
            ->orderBy('date')
            ->all();

        $forecastsForTen = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "k"=> 0.9, "q" => 0.9])
            ->orderBy('date')
            ->all();


        $data = ['dataFirst' => $forecastsForFirst,
            'dataSecond' => $forecastsForSecond,
            'dataThird' => $forecastsForThird,
            'dataFourth' => $forecastsForFourth,
            'dataFifth' => $forecastsForFifth,
            'dataSix' => $forecastsForSix,
            'dataSeven' => $forecastsForSeven,
            'dataEight' => $forecastsForEight,
            'dataNine' => $forecastsForNine,
            'dataTen' => $forecastsForTen,

            'currency' => $currency];
        return $data;
    }

    public function  actionChangeCurrency(){
        $session = new Session();
        $session->open();
        $session['cur_id'] = $_GET["id_currency"];
        $currency = Currencies::find()->where(["id" => $session['cur_id']])->one();
        return $currency->title;
    }

    public function actionLogin(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $user = User::find()->where(["login" => $_GET["login"], "pass" => md5("123a".$_GET["pass"])])->one();
        $session = new Session();
        $session->open();

        if($user){
            $data =  $user;
            //$session->user = $user;
        }else{
            $data =  "Неправильный логин или пароль";
        }
        return $data;
    }

    public function  actionChangeDay(){

        $day = $_GET["day"];
        $month = explode(" ", $_GET["month"]);
        $month = $month[0];

        switch($month){
            case "January":
                $monthNum = 01;
                break;
            case "February":
                $monthNum = 02;
                break;
            case "March":
                $monthNum = 03;
                break;
            case "April":
                $monthNum = 04;
                break;
            case "May":
                $monthNum = 05;
                break;
            case "June":
                $monthNum = 06;
                break;
            case "Jule":
                $monthNum = 07;
                break;
            case "August":
                $monthNum = 8;
                break;
            case "September":
                $monthNum = 9;
                break;
            case "October":
                $monthNum = 10;
                break;
            case "Novwmber":
                $monthNum = 11;
                break;
            case "December":
                $monthNum = 12;
                break;
        }

        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }

        $date = "2015-".$monthNum."-".$day;

        $valueForDay = ForecastsHolt::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $date])
            ->orderBy('k ASC')
            ->limit(9)
            ->all();

        $date1 = str_replace('-', '/', $date);
        $dateTomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));

        $date1 = str_replace('-', '/', $date);
        $dateYesterday = date('Y-m-d',strtotime($date1 . "-1 days"));

        $valuesForDayBefore = ForecastsHolt::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $dateYesterday])
            ->orderBy('k ASC')
            ->limit(9)
            ->all();

        $minValuesHolt =  ForecastsHolt::find()
            ->where(["id_currency" => $session['cur_id'], "date" =>$date])
            ->orderBy("e ASC")
            ->limit(1)
            ->one();

        $curentCureency = Currencies::find()->where(["id" => $session['cur_id']])->one();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = ['valueForDay' => $valueForDay, 'date_tomorrow' => $dateTomorrow, "valuesForDayBefore" => $valuesForDayBefore, "curentCureency"=>$curentCureency, "minValuesHolt" => $minValuesHolt ];
        return $data;
    }

    public function  actionChangeDayMedium(){

        $day = $_GET["day"];
        $month = explode(" ", $_GET["month"]);
        $month = $month[0];

        switch($month){
            case "January":
                $monthNum = 01;
                break;
            case "February":
                $monthNum = 02;
                break;
            case "March":
                $monthNum = 03;
                break;
            case "April":
                $monthNum = 04;
                break;
            case "May":
                $monthNum = 05;
                break;
            case "June":
                $monthNum = 06;
                break;
            case "Jule":
                $monthNum = 07;
                break;
            case "August":
                $monthNum = 8;
                break;
            case "September":
                $monthNum = 9;
                break;
            case "October":
                $monthNum = 10;
                break;
            case "Novwmber":
                $monthNum = 11;
                break;
            case "December":
                $monthNum = 12;
                break;
        }

        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }

        $date = "2015-".$monthNum."-".$day;
        $today = date("Y-m-d");
//        if($date > $today){
//          $error = "Этот день еще не наступил";
//        }else{
//
//        }
        $valueForDay = ForecastsMedium::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $date])
            ->orderBy('a ASC')
            ->limit(9)
            ->all();


        $date1 = str_replace('-', '/', $date);
        $dateTomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));

        $date1 = str_replace('-', '/', $date);
        $dateYesterday = date('Y-m-d',strtotime($date1 . "-1 days"));

        $valuesForDayBefore = ForecastsMedium::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $dateYesterday])
            ->orderBy('a ASC')
            ->limit(9)
            ->all();

        $minValuesMedium =  ForecastsMedium::find()
            ->where(["id_currency" => $session['cur_id'], "date" =>$date])
            ->orderBy("e ASC")
            ->limit(1)
            ->one();

        $curentCureency = Currencies::find()->where(["id" => $session['cur_id']])->one();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = ['valueForDay' => $valueForDay, 'date_tomorrow' => $dateTomorrow, "valuesForDayBefore" => $valuesForDayBefore, "curentCureency"=>$curentCureency, "minValuesMedium"=> $minValuesMedium ];
        return $data;
    }

    public function  actionChangeDayVinters(){

        $day = $_GET["day"];
        $month = explode(" ", $_GET["month"]);
        $month = $month[0];

        switch($month){
            case "January":
                $monthNum = 01;
                break;
            case "February":
                $monthNum = 02;
                break;
            case "March":
                $monthNum = 03;
                break;
            case "April":
                $monthNum = 04;
                break;
            case "May":
                $monthNum = 05;
                break;
            case "June":
                $monthNum = 06;
                break;
            case "Jule":
                $monthNum = 07;
                break;
            case "August":
                $monthNum = 8;
                break;
            case "September":
                $monthNum = 9;
                break;
            case "October":
                $monthNum = 10;
                break;
            case "Novwmber":
                $monthNum = 11;
                break;
            case "December":
                $monthNum = 12;
                break;
        }

        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }

        $date = "2015-".$monthNum."-".$day;

        $lastDay = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $date])
            ->orderBy('k ASC, q ASC')
            ->limit(25)
            ->all();

        $date1 = str_replace('-', '/', $date);
        $dateTomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));

        $dateYesterday = date('Y-m-d',strtotime($date1 . "-1 days"));
        $valuesForDayBefore = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $dateYesterday])
            ->orderBy('k ASC, q ASC')
            ->limit(25)
            ->all();

        $dateForMonthBefore  = date('Y-m-d',strtotime($date1 . "-1 months"));
        $valueForMonthBefore = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $dateForMonthBefore])
            ->orderBy('k ASC, q ASC')
            ->limit(25)
            ->all();

        $dateTomorrowMinusOneMonth = date('Y-m-d',strtotime($dateTomorrow . "-1 months"));
        $valueForTommorowMonthBefore = ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" => $dateTomorrowMinusOneMonth])
            ->orderBy('k ASC, q ASC')
            ->limit(25)
            ->all();

        $minValuesVinters =  ForecastsVinters::find()
            ->where(["id_currency" => $session['cur_id'], "date" =>$date])
            ->orderBy("e ASC")
            ->limit(1)
            ->one();

        $curentCureency = Currencies::find()->where(["id" => $session['cur_id']])->one();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = ['valueForDay' => $lastDay,
                'date_tomorrow' => $dateTomorrow,
                "valuesForDayBefore" => $valuesForDayBefore,
                "valueForTommorowMonthBefore" => $valueForTommorowMonthBefore,
                "valueForMonthBefore" => $valueForMonthBefore,
                "minValuesVinters" => $minValuesVinters,
                "curentCureency"=>$curentCureency ];
        return $data;
    }

    public function actionOptimalVinters(){
        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        $today = date("Y-m-d");

        $curentCureency = Currencies::find()->where(["id" => $session['cur_id']])->one();
        $id_currency = $session['cur_id'];

        $date1 = str_replace('-', '/', $today);
        $dateYesterday = date('Y-m-d',strtotime($date1 . "-1 days"));

        $valueQ1 = ForecastsVinters::find()
            ->where(["id_currency" => $id_currency, "date" =>$dateYesterday, "q" => 0.1])
            ->orderBy("k ASC")
            ->all();

        $valueQ2 = ForecastsVinters::find()
            ->where(["id_currency" => $id_currency, "date" =>$dateYesterday, "q" => 0.3])
            ->orderBy("k ASC")
            ->all();

        $valueQ3 = ForecastsVinters::find()
            ->where(["id_currency" => $id_currency, "date" =>$dateYesterday, "q" => 0.5])
            ->orderBy("k ASC")
            ->all();

        $valueQ4 = ForecastsVinters::find()
            ->where(["id_currency" => $id_currency, "date" =>$dateYesterday, "q" => 0.7])
            ->orderBy("k ASC")
            ->all();

        $valueQ5 = ForecastsVinters::find()
            ->where(["id_currency" => $id_currency, "date" =>$dateYesterday, "q" => 0.9])
            ->orderBy("k ASC")
            ->all();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = ["valueQ1" => $valueQ1,
            "valueQ2" => $valueQ2,
            "valueQ3" => $valueQ3,
            "valueQ4"=> $valueQ4,
            "valueQ5" => $valueQ5,
            "curentCureency"=>$curentCureency ];
        return $data;

    }

    public function actionOptimalHolt(){
        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        $today = date("Y-m-d");

        $curentCureency = Currencies::find()->where(["id" => $session['cur_id']])->one();
        $id_currency = $session['cur_id'];

        $date1 = str_replace('-', '/', $today);
        $dateYesterday = date('Y-m-d',strtotime($date1 . "-1 days"));

        $valueQ1 = ForecastsHolt::find()
            ->where(["id_currency" => $id_currency, "date" =>$dateYesterday,])
            ->orderBy("k ASC")
            ->all();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = ["valueQ1" => $valueQ1,
            "curentCureency"=>$curentCureency ];
        return $data;
    }

    public function actionOptimalMedium(){
        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        $today = date("Y-m-d");

        $curentCureency = Currencies::find()->where(["id" => $session['cur_id']])->one();
        $id_currency = $session['cur_id'];

        $date1 = str_replace('-', '/', $today);
        $dateYesterday = date('Y-m-d',strtotime($date1 . "-1 days"));

        $valueQ1 = ForecastsMedium::find()
            ->where(["id_currency" => $id_currency, "date" =>$dateYesterday,])
            ->orderBy("a ASC")
            ->all();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = ["valueQ1" => $valueQ1,
            "curentCureency"=>$curentCureency ];
        return $data;
    }

    public function  actionGetOprimalAndReal(){

        $session = new Session();
        $session->open();
        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $currency = Currencies::find()->where(["id" => $session['cur_id']])->one();

        $exchangeRates = ExchangeRates::find()
            ->where(["id_currency"=> $session['cur_id']])
            ->orderBy('date')
            ->all();

        $optimal = OptimalForecast::find()
            ->where(["id_currency"=> $session['cur_id']])
            ->orderBy('date')
            ->all();
        $data = ['real' => $exchangeRates, 'optimal'=> $optimal, 'currency' => $currency];
        return $data;
    }
}