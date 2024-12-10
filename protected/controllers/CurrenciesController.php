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
use yii\helpers\Json;
use app\models\Forecasts;
use app\models\ExchangeRates;
use yii\web\Session;

class CurrenciesController extends Controller
{
    public $layout = 'main_layout.php';

    public function actionIndex(){

        return $this->render('index', [
        ]);
    }

    public function  actionGetExchangeRates(){ //метод получения курсов валют

        $today = date("Y-m-d");

        $session = new Session();
        $session->open();

        $exchangeLastRate = ExchangeRates::find()
            ->where(["id_currency" => $session['cur_id']])
            ->orderBy('date DESC')
            ->limit(1)
            ->all();

        if ($exchangeLastRate) {
            $date = $exchangeLastRate[0]->date;

            $date1 = str_replace('-', '/', $date);
            $date = date('Y-m-d',strtotime($date1 . "+1 days"));
        }
        $exchangeRates = ExchangeRates::find()
            ->where(["id_currency" => $session['cur_id']])
            ->orderBy('date DESC')
            ->all();
        $curentCureency = Currencies::find()->where(["id" => $session['cur_id']])->one();

        return $this->render('get_exchange_rates', [
            "exchangeRates" => $exchangeRates,
            "exchangeLastRate" => $exchangeLastRate,
            "curentCureency" => $curentCureency
        ]);
    }

    public function actionLoadExchangeRates(){
        $today = date("Y-m-d");
        $session = new Session();
        $session->open();

        $exchangeLastRate = ExchangeRates::find()
            ->where(["id_currency" => $session['cur_id']])
            ->orderBy('date DESC')
            ->limit(1)
            ->all();

        if ($exchangeLastRate) {
            $date = $exchangeLastRate[0]->date;

            $date1 = str_replace('-', '/', $date);
            $date = date('Y-m-d',strtotime($date1 . "+1 days"));
        }

        if(!$exchangeLastRate || $exchangeLastRate[0]->date < $today){


            $url = "https://query1.finance.yahoo.com/v8/finance/chart/EUR=X?period1=1671404400&period2=1733353200&interval=1d&includePrePost=true&events=div%7Csplit%7Cearn&useYfid=true&lang=en-US&region=US";
            // Initialize cURL session
            $ch = curl_init($url);

            // Set options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',));
            // Execute and get response
            $response = curl_exec($ch);

            // Check for errors
            if (curl_errno($ch)) {
                Yii::error("Curl error: " . curl_error($ch));
                curl_close($ch);
                return $this->render('error', ['message' => curl_error($ch)]);
            }

            curl_close($ch);
            $result = JSON::decode($response);

            //Euro
            foreach ($result['chart']['result'][0]['timestamp'] as $key => $value) {
                if (is_null($result['chart']['result'][0]['indicators']['adjclose'][0]['adjclose'][$key])) {
                    continue;
                }
                $exchange_rates = new ExchangeRates();
                $exchange_rates->date = date('Y-m-d', $value); ;
                $exchange_rates->id_currency = 2;
                $exchange_rates->value =  !is_null($result['chart']['result'][0]['indicators']['adjclose'][0]['adjclose'][$key]) ? round($result['chart']['result'][0]['indicators']['adjclose'][0]['adjclose'][$key], 2): 0;
                $exchange_rates->save();  // equivalent to $customer->insert();
            }

            $url = "https://query1.finance.yahoo.com/v8/finance/chart/EUR=X?period1=1671404400&period2=1733353200&interval=1d&includePrePost=true&events=div%7Csplit%7Cearn&useYfid=true&lang=en-US&region=US";
            // Initialize cURL session
            $ch = curl_init($url);

            // Set options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',));
            // Execute and get response
            $response = curl_exec($ch);

            // Check for errors
            if (curl_errno($ch)) {
                Yii::error("Curl error: " . curl_error($ch));
                curl_close($ch);
                return $this->render('error', ['message' => curl_error($ch)]);
            }

            curl_close($ch);
            $result = JSON::decode($response);
            //Для фунта стерлингов
            foreach ($result['chart']['result'][0]['timestamp'] as $key => $value) {
                if (is_null($result['chart']['result'][0]['indicators']['adjclose'][0]['adjclose'][$key])) {
                    continue;
                }
                $exchange_rates = new ExchangeRates();
                $exchange_rates->date = date('Y-m-d', $value); ;
                $exchange_rates->id_currency = 4;
                $exchange_rates->value = round($result['chart']['result'][0]['indicators']['adjclose'][0]['adjclose'][$key], 2);
                $exchange_rates->save();  // equivalent to $customer->insert();
            }

            $url = "https://query1.finance.yahoo.com/v8/finance/chart/UAH=X?period1=1673823600&period2=1733353200&interval=1d&includePrePost=true&events=div%7Csplit%7Cearn&useYfid=true&lang=en-US&region=US";
            // Initialize cURL session
            $ch = curl_init($url);

            // Set options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',));
            // Execute and get response
            $response = curl_exec($ch);

            // Check for errors
            if (curl_errno($ch)) {
                Yii::error("Curl error: " . curl_error($ch));
                curl_close($ch);
                return $this->render('error', ['message' => curl_error($ch)]);
            }

            curl_close($ch);
            $result = JSON::decode($response);
            foreach ($result['chart']['result'][0]['timestamp'] as $key => $value) {
                if (is_null($result['chart']['result'][0]['indicators']['adjclose'][0]['adjclose'][$key])) {
                    continue;
                }
                $exchange_rates = new ExchangeRates();
                $exchange_rates->date = date('Y-m-d', $value); ;
                $exchange_rates->id_currency = 1;
                $exchange_rates->value = round($result['chart']['result'][0]['indicators']['adjclose'][0]['adjclose'][$key], 2);
                $exchange_rates->save();  // equivalent to $customer->insert();
            }
        }
    }
    public function  actionGetForecasts(){ //метод получения прогнозов
        return $this->render('get_forecasts', [
        ]);
    }

    public function  actionChangeCurrency(){ // сетод изменения валютной пары

        $session = new Session();
        $session->open();

        if(!$session['cur_id']){
            $session['cur_id'] = 1;
        }

        $currencies = Currencies::find()
            ->orderBy('id')
            ->all();

        $curentCureency = Currencies::find()->where(["id" => $session['cur_id']])->one();


        return $this->render('change_currency', [
            "currencies" => $currencies,
            "curentCureency" => $curentCureency
        ]);
    }

    public function  actionInfo(){ //Справка
        return $this->render('info', [
        ]);
    }

    public function  actionAbout(){ //О программе
        return $this->render('about', [
        ]);
    }

    public function  actionMatModel(){ //Мат модель
        return $this->render('mat-model', [
        ]);
    }
}