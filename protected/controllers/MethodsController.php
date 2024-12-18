<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 06.02.15
 * Time: 21:44
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Currencies;
use app\models\ForecastsHolt;
use app\models\ForecastsVinters;
use app\models\ForecastsMedium;
use app\models\ExchangeRates;
use app\models\OptimalForecast;
use yii\web\Session;

class MethodsController extends Controller
{
    public $layout = 'main_layout.php';

    public function actionIndex(){

        return $this->render('index', [
        ]);
    }

    public function  actionHoltAndBraun(){

        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        $today = date("Y-m-d");

        $curentCureency = Currencies::find()->where(["id" => $session['cur_id']])->one();
        $id_currency = $session['cur_id'];

        $lastDay = ForecastsHolt::find()
            ->where(["id_currency" => $id_currency])
            ->orderBy('date DESC')
            ->limit(1)
            ->one();

        $dayBefore = $lastDay->date;
        $date1 = str_replace('-', '/', $dayBefore);
        $lastDay = ForecastsHolt::find()
            ->where(["id_currency" => $id_currency, "date" => $today])
            ->orderBy('k ASC')
            ->limit(9)
            ->all();

        if ($lastDay) {
            $date1 = str_replace('-', '/', $lastDay[0]->date);
        } else {
            $date1 = date('Y/m/d');
        };
        $dateYesterday = date('Y-m-d',strtotime($date1 . "-1 days"));

        $valuesForDayBefore = ForecastsHolt::find()
            ->where(["id_currency" => $id_currency, "date" => $dateYesterday])
            ->orderBy('k ASC')
            ->limit(9)
            ->all();
        if ($lastDay) {
            $date1 = str_replace('-', '/', $lastDay[0]->date);
        } else {
            $date1 = date('Y/m/d');
        };
        $dateTomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));

        $minValuesHolt =  ForecastsHolt::find()
            ->where(["id_currency" => $id_currency, "date" =>$today])
            ->orderBy("e ASC")
            ->limit(1)
            ->one();

        return $this->render('nolt_and_braun', [
            "dateToday" => $today,
            "dateTommorow" => $dateTomorrow,
            "prognoz" => $lastDay,
            "valuesForDayBefore" => $valuesForDayBefore,
            "curentCureency" =>$curentCureency,
            "minValuesHolt" =>$minValuesHolt
        ]);
    }

    public function actionCalculateHolt(){
        $params = Yii::$app->request->queryParams;
        $id_currency = $params['currency_id'];
        switch($id_currency){  //в зависимости от валюті на сколько округлять
            case 1:
                $round = 2;
                $start = 40.0;
                break;
            case 2:
                $round = 4;
                $start = 0.95;
                break;
            case 3:
                $round = 1;
                $start = 0;
                break;
            case 4:
                $round = 4;
                $start = 0.9;
                break;
        }

            $values = ExchangeRates::find()
                ->where(["id_currency" => $id_currency])
                ->all();
            foreach ($values as $valueForThisDay) {
                $rateForThisDate = $valueForThisDay->value;
                $dayBefore = date( "Y-m-d" , strtotime($valueForThisDay->date . " +1 day")); ;
                for ($alpha = 0.1; $alpha <= 0.9; $alpha = $alpha + 0.1){
                    $beta = $alpha;
                    $valueForDayBefore = ForecastsHolt::find()
                        ->where(["id_currency" => $id_currency, "date" => $dayBefore, "k" => $alpha])->one();
                    $rateDayBefore = $valueForDayBefore ? $valueForDayBefore->yt_1 : $start;
                    $prognozDayBefore = $valueForDayBefore ? $valueForDayBefore->yt_prognoz : $start;
                    $trendDayBefore =  $valueForDayBefore ? $valueForDayBefore->trend : 0;
                    if($rateForThisDate > $rateDayBefore){
                        $diff = $rateForThisDate - $rateDayBefore;
                    }else{
                        $diff = $rateDayBefore - $rateForThisDate;
                    }
                    $e = $diff * 100 / $rateForThisDate;

                    $Yprognoz_t = $alpha * ($prognozDayBefore + $trendDayBefore) + (1-$alpha) * $rateForThisDate;
                    $trend = (1 - $beta) * ($Yprognoz_t - $prognozDayBefore) + $beta * $trendDayBefore;
                    $prognozTomorrow = $Yprognoz_t + $trend;

                    $forecast_holt = new ForecastsHolt();
                    $forecast_holt->date = $valueForThisDay->date;
                    $forecast_holt->id_currency = $id_currency;
                    $forecast_holt->k = $alpha;
                    $forecast_holt->e = round($e, $round);
                    $forecast_holt->yt = $rateForThisDate;
                    $forecast_holt->yt_prognoz = round($Yprognoz_t, $round);
                    $forecast_holt->trend = round($trend, $round);
                    $forecast_holt->yt_1 = round($prognozTomorrow, $round);
                    $forecast_holt->save();  // equivalent to $customer->insert();
                }
            }
        }

    public function  actionVinters(){

        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        $today = date("Y-m-d");

        $curentCureency = Currencies::find()->where(["id" => $session['cur_id']])->one();
        $id_currency = $session['cur_id'];

        $lastDay = ForecastsVinters::find()
            ->where(["id_currency" => $id_currency])
            ->orderBy('date DESC')
            ->limit(1)
            ->one();

        $dayBefore = $lastDay->date;
        $date1 = str_replace('-', '/', $dayBefore);
        $dateToday = date('Y-m-d',strtotime($date1 . "+1 days"));

        $lastDay = ForecastsVinters::find()
            ->where(["id_currency" => $id_currency, "date" => $today])
            ->orderBy('k ASC, q ASC')
            ->limit(25)
            ->all();


        $date1 = str_replace('-', '/', $lastDay[0]->date);
        $dateTomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));

        $dateYesterday = date('Y-m-d',strtotime($date1 . "-1 days"));

        $valuesForDayBefore = ForecastsVinters::find()
            ->where(["id_currency" => $id_currency, "date" => $dateYesterday])
            ->orderBy('k ASC, q ASC')
            ->limit(25)
            ->all();

        $dateForMonthBefore  = date('Y-m-d',strtotime($date1 . "-1 months"));

        $valueForMonthBefore = ForecastsVinters::find()
            ->where(["id_currency" => $id_currency, "date" => $dateForMonthBefore])
            ->orderBy('k ASC, q ASC')
            ->limit(25)
            ->all();

        $minValuesVinters =  ForecastsVinters::find()
            ->where(["id_currency" => $id_currency, "date" =>$today])
            ->orderBy("e ASC")
            ->limit(1)
            ->one();

        $dateTomorrowMinusOneMonth = date('Y-m-d',strtotime($dateTomorrow . "-1 months"));
        $valueForTommorowMonthBefore = ForecastsVinters::find()
            ->where(["id_currency" => $id_currency, "date" => $dateTomorrowMinusOneMonth])
            ->orderBy('k ASC, q ASC')
            ->limit(25)
            ->all();

        return $this->render('vinters', [
            "prognoz" => $lastDay,
            "dateTommorow" => $dateTomorrow,
            "seasonForTommorowMonthBefore" => $valueForTommorowMonthBefore,
            "season" => $valueForMonthBefore,
            "valuesForDayBefore" =>$valuesForDayBefore,
            "curentCureency" =>$curentCureency,
            "minValuesVinters" =>$minValuesVinters
        ]);
    }

    public function actionCalculateVinters(){
        $params = Yii::$app->request->queryParams;
        $id_currency = $params['currency_id'];
        switch($id_currency){  //в зависимости от валюті на сколько округлять
            case 1:
                $round = 2;
                $start = 40.0;
                break;
            case 2:
                $round = 4;
                $start = 0.95;
                break;
            case 3:
                $round = 1;
                $start = 0;
                break;
            case 4:
                $round = 4;
                $start = 0.9;
                break;
        }
        $beta = 0.9;


            $values = ExchangeRates::find()
                ->where(["id_currency" => $id_currency])
                ->all();
            foreach ($values as $valueForThisDay) {
                $rateForThisDate = $valueForThisDay->value;
                $dateTomorrow = date('Y-m-d',strtotime($valueForThisDay->date . "+1 days"));
                $dayBefore = date( "Y-m-d" , strtotime($valueForThisDay->date . " -1 day")); ;

                for($k = 0.1; $k < 1; $k = $k + 0.2){
                    for($q = 0.1; $q < 1; $q = $q + 0.2){
                        $valueForDayBefore = ForecastsVinters::find()
                            ->where(["id_currency" => $id_currency,
                                "date" => $dayBefore, "k" => $k, "q" => $q])
                            ->one();
                        $rateForTheDayBefore = $valueForDayBefore ? $valueForDayBefore->yt_1 : $start;
                        $rateForTheDayBeforeS = $valueForDayBefore ? $valueForDayBefore->st : $start;
                        $rateForTheDayBeforeL = $valueForDayBefore ? $valueForDayBefore->lt : $start;
                        $trenForTheDateBefore = $valueForDayBefore ? $valueForDayBefore->trend : 0;
                        if (!$rateForTheDayBeforeS) {
                            $rateForTheDayBeforeS = 1;
                        }
                        $L_t = $k * ($rateForThisDate / $rateForTheDayBeforeS) + (1 - $k) * ($rateForTheDayBeforeL + $trenForTheDateBefore);
                        $trend = $beta * ($L_t - $rateForTheDayBeforeL) + (1 - $beta) * $trenForTheDateBefore;

                        $dateMinusOneMonth = date('Y-m-d',strtotime($valueForThisDay->date . "-1 months"));

                        $valueForMonthBefore = ForecastsVinters::find()
                            ->where([
                                "id_currency" => $id_currency,
                                "date" => $dateMinusOneMonth,
                                "k" => $k,
                                "q" => $q])->one();
                        $rateForMonthBeforeS = $valueForMonthBefore ? $valueForMonthBefore->st : $start;
                        $s_t = $q * $rateForThisDate / $L_t + (1 - $q) * $rateForMonthBeforeS;

                        $dateTomorrowMinusOneMonth = date('Y-m-d',strtotime($dateTomorrow . "-1 months"));
                        $valueForTommorowMonthBefore = ForecastsVinters::find()
                            ->where(["id_currency" => $id_currency,
                                "date" => $dateTomorrowMinusOneMonth,
                                "k"=>$k,
                                "q" => $q])->one();
                        $rateForTomorrowMonthBeforeS = $valueForTommorowMonthBefore ? $valueForTommorowMonthBefore->st : $start;
                        $prognozTomorrow = ($L_t + $trend) * $rateForTomorrowMonthBeforeS;

                        if($rateForThisDate > $rateForTheDayBefore) {
                            $diff = $rateForThisDate - $rateForTheDayBefore;
                        } else {
                            $diff = $rateForTheDayBefore - $rateForThisDate;
                        }
                        $e = $diff * 100 / $rateForThisDate;

                        $forecasts_vinters = new ForecastsVinters();
                        $forecasts_vinters->date = $valueForThisDay->date;
                        $forecasts_vinters->id_currency = $id_currency;
                        $forecasts_vinters->k = $k;
                        $forecasts_vinters->q = $q;
                        $forecasts_vinters->yt = $rateForThisDate;
                        $forecasts_vinters->lt = round($L_t, $round);
                        $forecasts_vinters->trend = round($trend, $round);
                        $forecasts_vinters->st = round($s_t, $round);
                        $forecasts_vinters->yt_1 = round($prognozTomorrow, $round);
                        $forecasts_vinters->e = round($e, 2);
                        $forecasts_vinters->save();  // equivalent to $customer->insert();
                    }
                }

            }
    }

    public function  actionOptimal(){
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
        $dateTommorow = date('Y-m-d',strtotime($date1 . "+1 days"));

        $lastValuesVinters = ForecastsVinters::find()
            ->where(["id_currency" => $id_currency, "date" =>$today])
            ->orderBy("k ASC, q ASC")
            ->all();

        $lastValuesVintersYesterday = ForecastsVinters::find()
            ->where(["id_currency" => $id_currency, "date" =>$dateYesterday])
            ->orderBy("k ASC, q ASC")
            ->all();

        $lastValuesHolt = ForecastsHolt::find()
            ->where(["id_currency" => $id_currency, "date" =>$today])
            ->orderBy("k ASC")
            ->all();

        $lastValuesHoltYesterday = ForecastsHolt::find()
            ->where(["id_currency" => $id_currency, "date" =>$dateYesterday])
            ->orderBy("k ASC")
            ->all();

        $lastValuesMedium = ForecastsMedium::find()
            ->where(["id_currency" => $id_currency, "date" =>$today])
            ->orderBy("a ASC")
            ->all();

        $lastValuesMediumYesterday = ForecastsMedium::find()
            ->where(["id_currency" => $id_currency, "date" =>$dateYesterday])
            ->orderBy("a ASC")
            ->all();

        $minValuesHolt =  ForecastsHolt::find()
            ->where(["id_currency" => $id_currency, "date" =>$today])
            ->orderBy("e ASC")
            ->limit(1)
            ->one();

        $minValuesVinters =  ForecastsVinters::find()
            ->where(["id_currency" => $id_currency, "date" =>$today])
            ->orderBy("e ASC")
            ->limit(1)
            ->one();

        $minValuesMedium =  ForecastsMedium::find()
            ->where(["id_currency" => $id_currency, "date" =>$today])
            ->orderBy("e ASC")
            ->limit(1)
            ->one();

        if($minValuesHolt->e < $minValuesVinters->e){
            if($minValuesHolt->e <= $minValuesMedium->e){
                $minValues = $minValuesHolt;
                $method = "Хольта и Брауна";
                $koef = "коэффициентом k=".$minValues->k;
            }else{
                $minValues = $minValuesMedium;
                $method = "скользящих средних";
                $koef = "коэффициентом a=".$minValues->a;
            }
        }else{
            if($minValuesVinters->e <= $minValuesMedium->e){
                $minValues = $minValuesVinters;
                $method = "Винтерса";
                $koef = "коэффициентами k=".$minValues->k.", q=".$minValues->q; ;
            }else{
                $minValues = $minValuesMedium;
                $method = "скользящих средних";
                $koef = "коэффициентом a=".$minValues->a;
            }
        }
        if($minValues->yt_1 < $minValues->yt){
            $trend = "падать";
            $advice = "продать";
        }else{
            $trend = "возрастать";
            $advice = "купить";
        }

        return $this->render('optimal', [
            "lastValuesVinters" => $lastValuesVinters,
            "lastValuesVintersYesterday" => $lastValuesVintersYesterday,
            "lastValuesHolt" => $lastValuesHolt,
            "lastValuesHoltYesterday" => $lastValuesHoltYesterday,
            "lastValuesMedium" => $lastValuesMedium,
            "lastValuesMediumYesterday" => $lastValuesMediumYesterday,
            "curentCureency" => $curentCureency,
            "dateTommorow" => $dateTommorow,
            "minValues" => $minValues,
            "koef" => $koef,
            "method" => $method,
            "trend" => $trend,
            "advice" => $advice,
        ]);
    }

    public function  actionMedium() {
        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        $today = date("Y-m-d");

        $curentCureency = Currencies::find()->where(["id" => $session['cur_id']])->one();
        $id_currency = $session['cur_id'];

        $lastDay = ForecastsMedium::find()
            ->where(["id_currency" => $id_currency])
            ->orderBy('date DESC')
            ->limit(1)
            ->one();
        if ($lastDay) {
            $dayBefore = $lastDay->date;
        } else {
            $dayBefore = date("Y-m-d",strtotime( "1 days"));
        }

        $date1 = str_replace('-', '/', $dayBefore);

        $lastDay = ForecastsMedium::find()
            ->where(["id_currency" => $id_currency, "date" => $today])
            ->orderBy('a ASC')
            ->limit(9)
            ->all();
        if ($lastDay) {
            $date1 = str_replace('-', '/', $lastDay[0]->date);
        } else {
            $date1 = date("Y/m/d",strtotime( $today ));
        }
        $dateYesterday = date('Y-m-d',strtotime($date1 . "-1 days"));

        $valuesForDayBefore = ForecastsMedium::find()
            ->where(["id_currency" => $id_currency, "date" => $dateYesterday])
            ->orderBy('a ASC')
            ->limit(9)
            ->all();
        if ($lastDay) {
            $date1 = str_replace('-', '/', $lastDay[0]->date);
        } else {
            $date1 = date("Y/m/d",strtotime( $today ));
        }
        $dateTomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));

        $minValuesMedium =  ForecastsMedium::find()
            ->where(["id_currency" => $id_currency, "date" =>$today])
            ->orderBy("e ASC")
            ->limit(1)
            ->one();

        return $this->render('medium', [
            "dateToday" => $today,
            "dateTommorow" => $dateTomorrow,
            "prognoz" => $lastDay,
            "valuesForDayBefore" => $valuesForDayBefore,
            "minValuesMedium" => $minValuesMedium,
            "curentCureency" =>$curentCureency
        ]);
    }

    public function actionCalculateMedium() {
        $params = Yii::$app->request->queryParams;
        $id_currency = $params['currency_id'];
        switch($id_currency){  //в зависимости от валюті на сколько округлять
            case 1:
                $round = 2;
                $start = 40.0;
                break;
            case 2:
                $round = 4;
                $start = 0.95;
                break;
            case 3:
                $round = 1;
                $start = 0;
                break;
            case 4:
                $round = 4;
                $start = 0.9;
                break;
        }

            $values = ExchangeRates::find()
                ->where(["id_currency" => $id_currency])
                ->orderBy("date ASC")
                ->all();
            foreach ($values as $valueForThisDay) {
                echo '<pre>' . print_r($valueForThisDay, true) . '</pre>';
                //die();
                $rateForThisDay = $valueForThisDay->value;
                $dayBefore = date( "Y-m-d" , strtotime($valueForThisDay->date . " +1 day")); ;
                for( $alpha = 0.1; $alpha <= 0.9; $alpha = $alpha + 0.1) {

                    $valueForDayBefore = ForecastsMedium::find()
                        ->where(["id_currency" => $id_currency, "date" => $dayBefore, "a" => $alpha])->one();
                    $rateDayBefore = $valueForDayBefore ? $valueForDayBefore->yt_1 : $start;
                    if ($rateForThisDay > $rateDayBefore){
                        $diff = $rateForThisDay - $rateDayBefore;
                    } else {
                        $diff = $rateDayBefore- $rateForThisDay;
                    }
                    $e = $diff * 100 / $rateForThisDay;

                    $yt_1=$alpha * $rateForThisDay + (1-$alpha) * $rateDayBefore;

                    $forecast_medium = new ForecastsMedium();
                    $forecast_medium->date = $valueForThisDay->date;
                    $forecast_medium->id_currency = $id_currency;
                    $forecast_medium->a = $alpha;
                    $forecast_medium->e = round($e, 2);
                    $forecast_medium->yt = $rateForThisDay;
                    $forecast_medium->yt_1 = round($yt_1, $round);
                    $forecast_medium->save();  // equivalent to $customer->insert();
                }
            }
        }

    public function  actionFindOptimal(){
        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }
        $curentCureency = Currencies::find()->where(["id" => $session['cur_id']])->one();
        $id_currency = $session['cur_id'];

        $todaytoday = date("Y-m-d");
        $date1 = str_replace('-', '/', $todaytoday);
        $todaytodayTommorow = date('Y-m-d',strtotime($date1 . "+1 days"));

        $lastOptimal = OptimalForecast::find()
            ->where(["id_currency" => $id_currency])
            ->orderBy("date DESC")
            ->limit(1)
            ->one();
        $today = $lastOptimal->date;

        while($today < $todaytodayTommorow){
            $date1 = str_replace('-', '/', $today);
            $dateYesterday = date('Y-m-d',strtotime($date1 . "-1 days"));

            $minValuesHolt =  ForecastsHolt::find()
                ->where(["id_currency" => $id_currency, "date" =>$dateYesterday])
                ->orderBy("e ASC")
                ->limit(1)
                ->one();

            $minValuesVinters =  ForecastsVinters::find()
                ->where(["id_currency" => $id_currency, "date" =>$dateYesterday])
                ->orderBy("e ASC")
                ->limit(1)
                ->one();

            $minValuesMedium =  ForecastsMedium::find()
                ->where(["id_currency" => $id_currency, "date" =>$dateYesterday])
                ->orderBy("e ASC")
                ->limit(1)
                ->one();

            if($minValuesHolt->e < $minValuesVinters->e){
                if($minValuesHolt->e <= $minValuesMedium->e){
                    $minValues = $minValuesHolt;
                    $method = "Хольта и Брауна";
                    $koef = "k=".$minValues->k;
                }else{
                    $minValues = $minValuesMedium;
                    $method = "скользящих средних";
                    $koef = "a=".$minValues->a;
                }
            }else{
                if($minValuesVinters->e <= $minValuesMedium->e){
                    $minValues = $minValuesVinters;
                    $method = "Винтерса";
                    $koef = "k=".$minValues->k.", q=".$minValues->q; ;
                }else{
                    $minValues = $minValuesMedium;
                    $method = "скользящих средних";
                    $koef = "a=".$minValues->a;
                }
            }

            $forecast = new OptimalForecast();
            $forecast->date = $today;
            $forecast->id_currency = $id_currency;
            $forecast->value = $minValues->yt_1;
            $forecast->method = $method;
            $forecast->koefs = $koef;
            $forecast->save();  // equivalent to $customer->insert();

            $today = date('Y-m-d',strtotime($date1 . "+1 days"));
        }
        return $this->render('optimal-vs-real', [
        ]);
    }


}