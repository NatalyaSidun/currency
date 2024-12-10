<?php
$this->title = "Архив прогнозов";
?>
<!---->
<!--<div id="chart_forecast_holt" style="width:100%%; height:500px;"></div>-->
<!--<div id="chart_forecast_medium" style="width:100%; height:500px;"></div>-->
<!--<hr>-->
<!--<!--<div class="ct-chart ct-perfect-fourth"></div>-->
<!--<div id="chart_forecast_vinters" style="width:100%; height:500px;"></div>-->

<div role="tabpanel">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="#medium" aria-controls="medium" role="tab" data-toggle="tab">Метод ковзного середнього</a></li>
        <li role="presentation"><a href="#holt" aria-controls="holt" role="tab" data-toggle="tab">Метод Хольта і Брауна</a></li>
        <li role="presentation"><a href="#vinters" aria-controls="vinters" role="tab" data-toggle="tab">Метод Вінтерса</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="medium">
            <div id="chart_forecast_medium" style="width:1050px; height:500px;"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="holt">
            <div id="chart_forecast_holt" style="width:1050px; height:500px;"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="vinters">
            <div id="chart_forecast_vinters" style="width:1050px; height:500px;"></div>
        </div>
    </div>

</div>

