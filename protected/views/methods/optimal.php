<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 02.03.15
 * Time: 21:13
 */
$this->title = "Оптимальный прогноз";
?>

<div class="content">
    <div class="col-md-12">
        <h3 class="t1">Оптимальный прогноз для валютной пары <b><?php echo $curentCureency->title; ?></b></h3>
        <hr>
    </div>

    <div class="row">
        <div class="col-md-5">
            <button type="button"  data-toggle="modal" data-target="#recomendation"   class="btn btn-success">Оптимальный прогноз и рекомендации от программы</button>
        </div>
        <div class="col-md-4 col-md-offset-3">
            <button type="button"  data-toggle="modal" data-target="#graphs" class="btn btn-info">Зависимость ошибки от коэффициента</button>
        </div>
    </div>
    <hr/>
<!---->
<!--        <div class="recomendation">-->
<!--            -->
<!--        </div>-->

    <p class="t2"><b>Розрахунок помилки <?php echo $lastValuesMedium[0]->date; ?> для валютної пари <b><?php echo $curentCureency->title; ?></b></p>
    <p class="t5 label label-success"><b>Методом ковзного середнього</b></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>k</th>
            <th>Прогноз на <?php echo $lastValuesMedium[0]->date; ?></th>
            <th>Значення курсу <?php echo $lastValuesMedium[0]->date; ?></th>
            <th>Помилка</th>
            <th>Прогноз на <?php echo $dateTommorow; ?></th>
        </tr>
        </thead>
        <tbody>
            <?php for($i=0; $i<count($lastValuesMedium); $i++){?>
            <tr>
                <td><?php echo $lastValuesMedium[$i]->a;?> </td>
                <td><?php echo $lastValuesMediumYesterday[$i]->yt_1;?> <?php echo $curentCureency->valuta?></td>
                <td><?php echo $lastValuesMedium[$i]->yt;?> <?php echo $curentCureency->valuta?></td>
                <td><?php echo $lastValuesMedium[$i]->e;?> % </td>
                <td><?php echo $lastValuesMedium[$i]->yt_1;?> <?php echo $curentCureency->valuta?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <p class="t5 label label-success"><b>Методом Хольта і Брауна</b></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>k</th>
            <th>Прогноз на <?php echo $lastValuesVinters[0]->date; ?></th>
            <th>Значення курсу <?php echo $lastValuesVinters[0]->date; ?></th>
            <th>Помилка</th>
            <th>Прогноз на <?php echo $dateTommorow; ?></th>
        </tr>
        </thead>
        <tbody>
        <?php for($i=0; $i<count($lastValuesHolt); $i++){?>
            <tr>
                <td><?php echo $lastValuesHolt[$i]->k;?> </td>
                <td><?php echo $lastValuesHoltYesterday[$i]->yt_1;?> <?php echo $curentCureency->valuta?></td>
                <td><?php echo $lastValuesHolt[$i]->yt;?> <?php echo $curentCureency->valuta?></td>
                <td><?php echo $lastValuesHolt[$i]->e;?> % </td>
                <td><?php echo $lastValuesHolt[$i]->yt_1;?> <?php echo $curentCureency->valuta?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <p class="t5  label label-success"><b>Методом Вінтерса</b></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>k</th>
            <th>q</th>
            <th>Прогноз на <?php echo $lastValuesVinters[0]->date; ?></th>
            <th>Значення курсу <?php echo $lastValuesVinters[0]->date; ?></th>
            <th>Помилка</th>
            <th>Прогноз на <?php echo $dateTommorow; ?></th>
        </tr>
        </thead>
        <tbody>
            <?php for($i=0; $i<count($lastValuesVinters); $i++){?>
            <tr>
                <td><?php echo $lastValuesVinters[$i]->k;?> </td>
                <td><?php echo $lastValuesVinters[$i]->q;?> </td>
                <td><?php echo $lastValuesVintersYesterday[$i]->yt_1;?> <?php echo $curentCureency->valuta?></td>
                <td><?php echo $lastValuesVinters[$i]->yt;?> <?php echo $curentCureency->valuta?></td>
                <td><?php echo $lastValuesVinters[$i]->e;?> % </td>
                <td><?php echo $lastValuesVinters[$i]->yt_1;?> <?php echo $curentCureency->valuta?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="recomendation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Оптимальний прогноз</h4>
            </div>
            <div class="modal-body">
                <div class="recomendation">
                    <p> На основі оптимального прогнозу на вчора можна зробити припущення,
                    що оптимальний прогноз по  <b> методу <?php echo $method;?> з <?php echo $koef; ?></b></p>
                    <hr/>
                    <p>Курс сьогодні :<b> <?php echo $minValues->yt." ".$curentCureency->valuta?> за 1$.</b></p>
                    <p>Оптимальний прогноз на <?php echo $dateTommorow; ?>:<b>  <?php echo $minValues->yt_1." ".$curentCureency->valuta?> за 1$.</b></p>
                    <p>Тренд:<b class="red"> Курс валют буде <?php echo $trend; ?></b></p>
                    <p>Порада від програми:<b class="red"> ЩЩоб заробити, валюту сюогодні краще  <?php echo $advice; ?></b> </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закритти</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="graphs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Зависимость ошибки от коэффициентов для различных методов</h4>
            </div>
            <div class="modal-body">
                <div role="tabpanel">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#medium" aria-controls="medium" role="tab" data-toggle="tab">М. скользящего среднего</a></li>
                        <li role="presentation"><a href="#holt" aria-controls="holt" role="tab" data-toggle="tab">М. Хольта и Брауна</a></li>
                        <li role="presentation"><a href="#vinters" aria-controls="vinters" role="tab" data-toggle="tab">М. Винтерса</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="medium">
                            <div id="ek-chart-medium" style="width: 550px;"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="holt">
                            <div id="ek-chart" style="width: 550px;"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="vinters">
                            <div id="ekq-chart" style="width: 550px;"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
