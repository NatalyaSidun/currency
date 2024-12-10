<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 02.03.15
 * Time: 21:13
 */
$this->title = "Прогноз за методом Хольта і Брауна";
?>
<div class="wrap-wait">
    <i class="fa fa-spinner fa-pulse fa-5x"></i>
</div>
<div class="content">
        <div class="col-md-12">
            <h3 class="t1">Прогноз методом <b>Хольта і Брауна</b> для валютної пари <b><?php echo $curentCureency->title; ?></b></h3>
            <hr>
        </div>
        <div class="col-md-9 col-md-offset-2">
            <button type="button"  data-toggle="modal" data-target="#minValues"   class="btn btn-success">Оптимальний прогноз методом Хольта і Брауна</button>
            <br>
            <br>
        </div>
    <div class="row">
        <div class="col-md-9">
            <div class="cards">
                <div class="btns">
                    <div class="row">
                        <div class="col-md-1 col-md-offset-1" >
                            <label>
                                <input type="checkbox" data-card="1"> <span class="label label-success kbut">a=0.1</span>
                            </label>
                        </div>
                        <div class="col-md-1" id="two">
                            <label>
                                <input type="checkbox" data-card="2"> <span class="label label-success kbut">a=0.2</span>
                            </label>
                        </div>
                        <div class="col-md-1" id="three">
                            <label>
                                <input type="checkbox" data-card="3"> <span class="label label-success kbut">a=0.3</span>
                            </label>
                        </div>
                        <div class="col-md-1" id="four">
                            <label>
                                <input type="checkbox" data-card="4"> <span class="label label-success kbut">a=0.4</span>
                            </label>
                        </div>
                        <div class="col-md-1" id="five">
                            <label>
                                <input type="checkbox" data-card="5"> <span class="label label-success kbut">a=0.5</span>
                            </label>
                        </div>
                        <div class="col-md-1" id="six">
                            <label>
                                <input type="checkbox" data-card="6"> <span class="label label-success kbut">a=0.6</span>
                            </label>
                        </div>
                        <div class="col-md-1" id="seven">
                            <label>
                                <input type="checkbox" data-card="7"> <span class="label label-success kbut">a=0.7</span>
                            </label>
                        </div>
                        <div class="col-md-1"  id="eight">
                            <label>
                                <input type="checkbox" data-card="8"> <span class="label label-success kbut">a=0.8</span>
                            </label>
                        </div>
                        <div class="col-md-1" id="nine">
                            <label>
                                <input type="checkbox" data-card="9"> <span class="label label-success kbut">a=0.9</span>
                            </label>
                        </div>
                        <div class="col-lg-offset-1"></div>
                    </div>
                </div>

                <div class="cards-block">
                </div>

                <div class="date">
                        <span>25</span>
                        <small>Марта</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div id="datepicker-holt"></div>
            <div class="dop-btns">
                <div class="btn-group">
                    <a class="btn btn-default" data-toggle="modal" data-target="#myModal" href="javascript:void(0)" title="Інформація про метод Хольта і Брауна">
                            <span class="p-t-5 p-b-5">
                            <i class="fa fa-question"></i>
                            </span>
                            <br>
                            <span class="fs-11 font-montserrat text-uppercase lab">Довідка</span>
                    </a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default openPopup" data-toggle="modal" data-target="#dataTable" href="javascript:void(0)" title="Подивитись результати у вигляді таблиці">
                            <span class="p-t-5 p-b-5">
                            <i class="fa fa-table"></i>
                            </span>
                            <br>
                            <span class="fs-11 font-montserrat text-uppercase lab">Таблиця</span>
                    </a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default openPopup" href="javascript:void(0)" title="Зберегти звіт за методом">
                            <span class="p-t-5 p-b-5">
                            <i class="fa fa-floppy-o"></i>
                            </span>
                            <br>
                            <span class="fs-11 font-montserrat text-uppercase lab">Звіт</span>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Метод Хольта і Брауна</h4>
                </div>
                <div class="modal-body">
                    <p>У середині минулого століття Хольт запропонував удосконалений метод експоненційного згладжування, який згодом був названий його іменем. У запропонованому алгоритмі значення рівня та тренду згладжуються за допомогою експоненційного згладжування, причому параметри згладжування для них відрізняються. </p>

                    <p>Перше рівняння описує згладжений ряд для прогнозного значення Y на момент часу t з використанням інформації на момент часу t–1.</p>
                    <img src="/img/holt1.gif"/>
                    <p>де α – константа згладжування; Yпрогн., t, Yпрогн., t–1 – прогнозні значення показника у наступний та попередній моменти часу; Yt – табличне значення показника у момент часу t; Тt–1 – значення тренду на момент часу t–1, яке визначається з другого рівняння.</p>
                    <p></p>
                    <p>Друге рівняння використовується для оцінки тренду:</p>
                    <img src="/img/holt2.gif"/>
                    <p>де β – константа згладжування. Для визначення прогнозу на p відліків часу використовується третє рівняння:</p>
                    <p></p>
                    <img src="/img/holt3.gif"/>
                    <p>Приватним випадком методу Хольта є метод Брауна, коли α = β. Константи згладжування α та β підбираються шляхом перебору з певним кроком. При вищих значеннях α більшою мірою враховуються минулі значення ряду; аналогічно, вищі значення β оцінюють минулі зміни процесу у порівнянні з поточними.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
                </div>
            </div>
        </div>
    </div>

    <div class="popups">
        <?php for($i=0; $i<count($prognoz); $i++){?>
            <div class="modal fade" id="popup-calculation<?php echo $i+1;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Расчет прогноза на <?php echo $dateTommorow; ?> по методу Хольта И Брауна с коэффициентом <?php echo $prognoz[$i]->k; ?></h4>
                        </div>
                        <div class="modal-body">
                            <img src="/img/holt1.gif"/><br>
                            <img src="/img/holt2.gif"/><br>
                            <img src="/img/holt3.gif"/><br>
                            <p>где α – постоянная сглаживания;</p>
                            <p>Yпрогн., t, Yпрогн., t–1 – прогнозные значения показателя в последующий и предыдущий момент времени; </p>
                            <p>Yt – табличное значение показателя в момент времени t; </p>
                            <p>Тt–1 – значение тренда на момент времени t–1, которое определяется из второго уравнения.</p>
                            <p>где β – постоянная сглаживания.</p>
                                <p class="t4"><b>Значения на <?php echo $valuesForDayBefore[$i]->date;?> для k=<?php echo $valuesForDayBefore[$i]->k;?></b></p>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Значение курса</th>
                                            <th>Сглаженное значение</th>
                                            <th>Значение тренда</th>
                                            <th>Прогноз</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $valuesForDayBefore[$i]->yt;?> <?php echo $curentCureency->valuta?></td>
                                            <td><?php echo $valuesForDayBefore[$i]->yt_prognoz;?> <?php echo $curentCureency->valuta?></td>
                                            <td><?php echo $valuesForDayBefore[$i]->trend;?></td>
                                            <td><?php echo $valuesForDayBefore[$i]->yt_1;?> <?php echo $curentCureency->valuta?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <p class="t3"><b>Рассмотрим подробнее</b></p>
                            <ul>
                                <li>
                                   <p>Находим сглаженный ряд для прогнозного значения Y на момент времени t с использованием информации на момент времени t–1</p>
                                   <p>Y<small>прогн.t</small> = k * (Y<small>прогн.t-1</small> + T<small>t-1</small>) + (1-k) * Y<small>t</small> = <?php echo $valuesForDayBefore[$i]->k." * (".$valuesForDayBefore[$i]->yt_prognoz." + ".$valuesForDayBefore[$i]->trend.") + (1 - ". $valuesForDayBefore[$i]->k.") * ".$prognoz[$i]->yt. " = ".$prognoz[$i]->yt_prognoz;?></p>
                                </li>
                                <li>
                                   <p>Находим значение тренда</p>
                                   <p>T<small>t</small> = (1-k) * (Y<small>прогн.t</small> - Y<small>прогн.t-1</small>) + k * T<small>t-1</small> = <?php echo "(1 - ".$valuesForDayBefore[$i]->k.") * (".$prognoz[$i]->yt_prognoz." - ".$valuesForDayBefore[$i]->yt_prognoz.") + ".$valuesForDayBefore[$i]->k." * ". $valuesForDayBefore[$i]->trend." = ".$prognoz[$i]->trend;?></p>
                                </li>
                                <li>
                                   <p>Находим прогноз на <?php echo $dateTommorow; ?> </p>
                                   <p>Y<small>прогн.t+1</small> = Y<small>прогн.t+1</small> + p * T<small>t</small> = <?php echo $prognoz[$i]->yt_prognoz." + 1 * ".$prognoz[$i]->trend. " = ".$prognoz[$i]->yt_1;?> <?php echo $curentCureency->valuta?> за 1$</p>
                                </li>

                            </ul>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

        <div class="modal fade" id="dataTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Результаты расчета прогноза для валютной пары <?php echo $curentCureency->title;?> по методу Хольта и Брауна</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>k</th>
                                <th>Прогноз</th>
                            </tr>
                            </thead>
                            <tbody class="bodyInner">
                            <?php foreach($prognoz as $item){?>
                                <tr>
                                    <td><?php echo $item->k;?></td>
                                    <td><?php echo $item->yt_1;?> <?php echo $curentCureency->valuta?></td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                        <div id="k-chart" style="width: 550px;"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
</div>

<div class="cards-hidden">
    <?php $i=1; ?>
    <?php foreach($prognoz as $item){?>
        <div class="card<?php echo $i;?>">
            <span class="label label-success"><?php echo "k1=".$item->k?></span>
            <div class="row">
                <div class="col-md-4"> Tренд: </div>
                <div class="col-md-8"> <?php echo $item->trend?> </div>
            </div>
            <div class="row">
                <div class="col-md-4"> Завтра: </div>
                <div class="col-md-8"> <?php echo $dateTommorow?> </div>
            </div>
            <div class="row">
                <div class="col-md-4"> Прогноз: </div>
                <div class="col-md-8">за 1$ <?php echo $item->yt_1?> <?php echo $curentCureency->valuta?> </div>
            </div>
            <a class="btn btn-default" data-toggle="modal" data-target="#popup-calculation<?php echo $i;?>" href="javascript:void(0)" title="Подробнее расчеты">
                <span class="p-t-5 p-b-5">
                    <i class="fa fa-question"></i>
                </span>
            </a>
        </div>
        <?php $i++; ?>
    <?php } ?>
</div>

<div class="modal fade" id="minValues" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Оптимальний прогноз для валютної пари <?php echo $curentCureency->title;?> по методу Хольта и Брауна</h4>
            </div>
            <div class="modal-body">
                <p>Оптимальный прогноз на <span class="optDate"><?php echo $minValuesHolt->date;?></span></p>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>k</th>
                        <th>Прогноз</th>
                        <th>Ошибка</th>
                    </tr>
                    </thead>
                    <tbody class="bodyInn">
                        <tr>
                            <td><?php echo $minValuesHolt->k;?></td>
                            <td><?php echo $minValuesHolt->yt_1;?> <?php echo $curentCureency->valuta?></td>
                            <td><?php echo $minValuesHolt->e;?> % </td>
                        </tr>
                    </tbody>
                </table>
                <p> На основі оптимального прогнозу на <span class="optDate"><?php echo $minValuesHolt->date;?></span>  можна зробити припущення,
                    що оптимальний прогноз методом Хольта і Брауна вираховується з коефіцієнту <span class="optKoef"> <?php echo $minValuesHolt->k; ?></span></p>

                <p><b>Курс <span class="optDate"><?php echo $minValuesHolt->date;?></span> :</b>  <span class="optVal"><?php echo $minValuesHolt->yt." ".$curentCureency->valuta?> за 1$.</span></p>
                <p><b>Оптимальний прогноз на  <span class="optDateTommorow"><?php echo $dateTommorow;?>:</b>  <?php echo $minValuesHolt->yt_1." ".$curentCureency->valuta?> за 1$.</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
            </div>
        </div>
    </div>
</div>