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
        $dateToday = date('Y-m-d',strtotime($date1 . "+1 days"));

        while($dateToday <= $today){

            $dateTomorrow = date('Y-m-d',strtotime($dateToday . "+1 days"));

            switch($id_currency){  //в зависимости от валюті на сколько округлять
                case 1:
                    $round = 2;
                    break;
                case 2:
                    $round = 4;
                    break;
                case 3:
                    $round = 1;
                    break;
                case 4:
                    $round = 4;
                    break;
            }

            $valueForThisDay = ExchangeRates::find()
                ->where(["date" => $dateToday, "id_currency" => $id_currency])
                ->one();

            die('<pre>' . print_r($valueForThisDay, true) . '</pre>');
            $valueForThisDay = $valueForThisDay->value;

            for($alpha=0.1; $alpha<=0.9; $alpha=$alpha+0.1){
                $beta = $alpha;
                $valueForDayBefore = ForecastsHolt::find()
                    ->where(["id_currency" => $id_currency, "date" => $dayBefore, "k" => $alpha])->one();

                if($valueForThisDay > $valueForDayBefore->yt_1){
                    $diff = $valueForThisDay - $valueForDayBefore->yt_1;
                }else{
                    $diff = $valueForDayBefore->yt_1 - $valueForThisDay;
                }
                $e = $diff*100/$valueForThisDay;

                $Yprognoz_t = $alpha*($valueForDayBefore->yt_prognoz+$valueForDayBefore->trend)+(1-$alpha)*$valueForThisDay;
                $trend = (1-$beta)*($Yprognoz_t - $valueForDayBefore->yt_prognoz)+$beta*$valueForDayBefore->trend;
                $prognozTomorrow = $Yprognoz_t+$trend;

                $forecast_holt = new ForecastsHolt();
                $forecast_holt->date = $dateToday;
                $forecast_holt->id_currency = $id_currency;
                $forecast_holt->k = $alpha;
                $forecast_holt->e = round($e, 2);
                $forecast_holt->yt = $valueForThisDay;
                $forecast_holt->yt_prognoz = round($Yprognoz_t, $round);
                $forecast_holt->trend = round($trend, $round);
                $forecast_holt->yt_1 = round($prognozTomorrow, $round);
                $forecast_holt->save();  // equivalent to $customer->insert();
            }


            $dayBefore = $dateToday;
            $dateToday = $dateTomorrow;
        }

        $lastDay = ForecastsHolt::find()
            ->where(["id_currency" => $id_currency, "date" => $today])
            ->orderBy('k ASC')
            ->limit(9)
            ->all();

        $date1 = str_replace('-', '/', $lastDay[0]->date);
        $dateYesterday = date('Y-m-d',strtotime($date1 . "-1 days"));

        $valuesForDayBefore = ForecastsHolt::find()
            ->where(["id_currency" => $id_currency, "date" => $dateYesterday])
            ->orderBy('k ASC')
            ->limit(9)
            ->all();

        $date1 = str_replace('-', '/', $lastDay[0]->date);
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

        switch($id_currency){  //в зависимости от валюті на сколько округлять
            case 1:
                $round = 2;
                break;
            case 2:
                $round = 4;
                break;
            case 3:
                $round = 1;
                break;
            case 4:
                $round = 4;
                break;
        }
        $beta = 0.9;
//        while($dateToday <= "2015-03-20"){

        while($dateToday <= $today){

            $dateTomorrow = date('Y-m-d',strtotime($dateToday . "+1 days"));

            $valueForThisDay = ExchangeRates::find()
                ->where(["date" => $dateToday, "id_currency" => $id_currency])
                ->one();

            $valueForThisDay = $valueForThisDay->value;

            for($k=0.1; $k<1; $k=$k+0.2){
                for($q=0.1; $q<1; $q=$q+0.2){
                    $valueForDayBefore = ForecastsVinters::find()
                        ->where(["id_currency" => $id_currency, "date" => $dayBefore, "k"=>$k, "q" => $q])->one();

                    $L_t = $k*($valueForThisDay/$valueForDayBefore->st)+(1-$k)*($valueForDayBefore->lt+$valueForDayBefore->trend);
                    $trend = $beta*($L_t - $valueForDayBefore->lt)+(1-$beta)*$valueForDayBefore->trend;

                    $dateMinusOneMonth = date('Y-m-d',strtotime($dateToday . "-1 months"));
                    $valueForMonthBefore = ForecastsVinters::find()
                        ->where(["id_currency" => $id_currency, "date" => $dateMinusOneMonth, "k"=>$k, "q" => $q])->one();
                    $s_t = $q*$valueForThisDay/$L_t+(1-$q)*$valueForMonthBefore->st;
//                      $s_t = 1;

                    $dateTomorrowMinusOneMonth = date('Y-m-d',strtotime($dateTomorrow . "-1 months"));
                    $valueForTommorowMonthBefore = ForecastsVinters::find()
                        ->where(["id_currency" => $id_currency, "date" => $dateTomorrowMinusOneMonth, "k"=>$k, "q" => $q])->one();

                  $prognozTomorrow = ($L_t+$trend)*$valueForTommorowMonthBefore->st;
//                    $prognozTomorrow = ($L_t+$trend)*$s_t;

                    if($valueForThisDay > $valueForDayBefore->yt_1){
                        $diff = $valueForThisDay - $valueForDayBefore->yt_1;
                    }else{
                        $diff = $valueForDayBefore->yt_1 - $valueForThisDay;
                    }
                    $e = $diff*100/$valueForThisDay;

                    $forecasts_vinters = new ForecastsVinters();
                    $forecasts_vinters->date = $dateToday;
                    $forecasts_vinters->id_currency = $id_currency;
                    $forecasts_vinters->k = $k;
                    $forecasts_vinters->q = $q;
                    $forecasts_vinters->yt = $valueForThisDay;
                    $forecasts_vinters->lt = round($L_t, $round);
                    $forecasts_vinters->trend = round($trend, $round);
                    $forecasts_vinters->st = round($s_t, $round);
                    $forecasts_vinters->yt_1 = round($prognozTomorrow, $round);
                    $forecasts_vinters->e = round($e, 2);
                    $forecasts_vinters->save();  // equivalent to $customer->insert();
                }
            }

            $dayBefore = $dateToday;
            $dateToday = $dateTomorrow;
        }

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

    public function  actionMedium(){
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
        $dayBefore = $lastDay->date;
        $date1 = str_replace('-', '/', $dayBefore);
        $dateToday = date('Y-m-d',strtotime($date1 . "+1 days"));
        switch($id_currency){  //в зависимости от валюті на сколько округлять
            case 1:
                $round = 2;
                break;
            case 2:
                $round = 4;
                break;
            case 3:
                $round = 1;
                break;
            case 4:
                $round = 4;
                break;
        }

        while($dateToday <= $today){
            $dateTomorrow = date('Y-m-d',strtotime($dateToday . "+1 days"));

            $valueForThisDay = ExchangeRates::find()
                ->where(["date" => $dateToday, "id_currency" => $id_currency])
                ->one();

            $valueForThisDay = $valueForThisDay->value;

            for($alpha=0.1; $alpha<=0.9; $alpha=$alpha+0.1){

                $valueForDayBefore = ForecastsMedium::find()
                    ->where(["id_currency" => $id_currency, "date" => $dayBefore, "a" => $alpha])->one();

                if($valueForThisDay > $valueForDayBefore->yt_1){
                    $diff = $valueForThisDay - $valueForDayBefore->yt_1;
                }else{
                    $diff = $valueForDayBefore->yt_1 - $valueForThisDay;
                }
                $e = $diff*100/$valueForThisDay;

                $yt_1=$alpha*$valueForThisDay+(1-$alpha)*$valueForDayBefore->yt_1;

                $forecast_medium = new ForecastsMedium();
                $forecast_medium->date = $dateToday;
                $forecast_medium->id_currency = $id_currency;
                $forecast_medium->a = $alpha;
                $forecast_medium->e = round($e, 2);
                $forecast_medium->yt = $valueForThisDay;
                $forecast_medium->yt_1 = round($yt_1, $round);
                $forecast_medium->save();  // equivalent to $customer->insert();
            }

            $dayBefore = $dateToday;
            $dateToday = $dateTomorrow;
        }

        $lastDay = ForecastsMedium::find()
            ->where(["id_currency" => $id_currency, "date" => $today])
            ->orderBy('a ASC')
            ->limit(9)
            ->all();

        $date1 = str_replace('-', '/', $lastDay[0]->date);
        $dateYesterday = date('Y-m-d',strtotime($date1 . "-1 days"));

        $valuesForDayBefore = ForecastsMedium::find()
            ->where(["id_currency" => $id_currency, "date" => $dateYesterday])
            ->orderBy('a ASC')
            ->limit(9)
            ->all();

        $date1 = str_replace('-', '/', $lastDay[0]->date);
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