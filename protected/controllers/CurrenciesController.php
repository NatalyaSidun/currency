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

        $date = $exchangeLastRate[0]->date;
        $date1 = str_replace('-', '/', $date);
        $date = date('Y-m-d',strtotime($date1 . "+1 days"));

//        while($date < $today){
//            $arrDate = explode("-", $date);
//            $dataFormat = $arrDate[2].$arrDate[1].$arrDate[0];
//
//            $url = "http://pfsoft.com.ua/service/currency/?date=".$dataFormat;
//            $xml = xml_parser_create(); //создаёт XML-разборщик
//            xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);  //устанавливает опции XML-разборщика
//            xml_parse_into_struct($xml, file_get_contents($url), $element, $index); //разбирает XML-данные в структуру массива
//            xml_parser_free($xml);  //освобождает XML-разборщик
//
//            $exchange_rates = new ExchangeRates();
//            $exchange_rates->date = $date;
//            $exchange_rates->id_currency = 1;
//            $exchange_rates->value = round($element[41]["value"]/100, 2);
//            $exchange_rates->save();  // equivalent to $customer->insert();
//
//            $date1 = str_replace('-', '/', $date);
//            $date = date('Y-m-d',strtotime($date1 . "+1 days"));
//        }

        if($exchangeLastRate[0]->date < $today){
            $url = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20%28%22USDEUR%22,%22USDBYR%22,%22USDGBP%22,%22USDUAH%22%29&env=store://datatables.org/alltableswithkeys';
            $xml = xml_parser_create(); //создаёт XML-разборщик
            xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);  //устанавливает опции XML-разборщика
            xml_parse_into_struct($xml, file_get_contents($url), $element, $index); //разбирает XML-данные в структуру массива
            xml_parser_free($xml);  //освобождает XML-разборщик

            //Для фунта стерлингов
            $exchange_rates = new ExchangeRates();
            $exchange_rates->date = $today;
            $exchange_rates->id_currency = 4;
            $exchange_rates->value = $element[20]["value"];
            $exchange_rates->save();  // equivalent to $customer->insert();

            //Для евро
            $exchange_rates = new ExchangeRates();
            $exchange_rates->date = $today;
            $exchange_rates->id_currency = 2;
            $exchange_rates->value = $element[4]["value"];
            $exchange_rates->save();  // equivalent to $customer->insert();

            //Для гривны
            $exchange_rates = new ExchangeRates();
            $exchange_rates->date = $today;
            $exchange_rates->id_currency = 1;
            $exchange_rates->value = round($element[28]["value"], 2);
            $exchange_rates->save();  // equivalent to $customer->insert();

            //Для белорусского рубля
            $exchange_rates = new ExchangeRates();
            $exchange_rates->date = $today;
            $exchange_rates->id_currency = 3;
            $exchange_rates->value = $element[12]["value"];
            $exchange_rates->save();  // equivalent to $customer->insert();
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