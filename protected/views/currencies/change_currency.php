<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 02.03.15
 * Time: 21:13
 */
$this->title = "Оберіть валюту";
?>
<div class="content">
    <div class="col-md-12">
        <h3 class="t1">Оберіть валюту</h3>
        <hr>
    </div>
    <div class="row">
        <div class="col-md-6">
            <select class="form-control select-change" id="changeCurrency">
                <?php foreach($currencies as $item){ ?>
                    <?php $selected = ($curentCureency->id == $item["id"]) ? "selected": ""; ?>
                    <option <?php echo $selected; ?> value="<?php echo $item["id"]; ?>"><?php echo $item["title"];?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-7">
            <div class="selectedCur <?php echo ($curentCureency->id)? "active" : "";?>" >Обрана валютна пара: <span><?php echo $curentCureency->title ?></span></div>
        </div>
    </div>
    <hr/>
    <h4 class="t2">Курси валют за інформацією національних банків:</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Валютна пара</th>
                <th>Сайт</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Гривня - Долар</td>
                <td><a target="_blank" href="http://www.bank.gov.ua/control/uk/curmetal/detail/currency?period=daily">http://www.bank.gov.ua/</a></td>
            </tr>
            <tr>
                <td>Євро - Долар</td>
                <td><a target="_blank" href="https://www.ecb.europa.eu/rss/fxref-usd.html">https://www.ecb.europa.eu/</a> </td>
            </tr>
            <tr>
                <td>Фунт Стерлінгів - Доллр</td>
                <td><a target="_blank" href="http://www.bankofengland.co.uk/Pages/home.aspx">http://www.bankofengland.co.uk</a> </td>
            </tr>
        </tbody>
    </table>
    <hr>
</div>