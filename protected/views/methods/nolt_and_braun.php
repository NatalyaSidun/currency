<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 02.03.15
 * Time: 21:13
 */
$this->title = "Прогноз по методу Хольта и Брауна";
?>
<div class="wrap-wait">
    <i class="fa fa-spinner fa-pulse fa-5x"></i>
</div>
<div class="content">
        <div class="col-md-12">
            <h3 class="t1">Прогноз по методу <b>Хольта и Брауна</b> для валютной пары <b><?php echo $curentCureency->title; ?></b></h3>
            <hr>
        </div>
        <div class="col-md-9 col-md-offset-2">
            <button type="button"  data-toggle="modal" data-target="#minValues"   class="btn btn-success">Оптимальный прогноз по методу Хольта и Брауна</button>
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
                    <a class="btn btn-default" data-toggle="modal" data-target="#myModal" href="javascript:void(0)" title="Информация о методе Хольта и Брауна">
                            <span class="p-t-5 p-b-5">
                            <i class="fa fa-question"></i>
                            </span>
                            <br>
                            <span class="fs-11 font-montserrat text-uppercase lab">Справка</span>
                    </a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default openPopup" data-toggle="modal" data-target="#dataTable" href="javascript:void(0)" title="Посмотреть результаты в виде таблицы">
                            <span class="p-t-5 p-b-5">
                            <i class="fa fa-table"></i>
                            </span>
                            <br>
                            <span class="fs-11 font-montserrat text-uppercase lab">Таблица</span>
                    </a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default openPopup" href="javascript:void(0)" title="Сохранить отчет по методу">
                            <span class="p-t-5 p-b-5">
                            <i class="fa fa-floppy-o"></i>
                            </span>
                            <br>
                            <span class="fs-11 font-montserrat text-uppercase lab">Отчет</span>
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
                    <h4 class="modal-title" id="myModalLabel">Метод Хольта Брауна</h4>
                </div>
                <div class="modal-body">
                    <p> В середине прошлого века Хольт предложил усовершенствованный метод экспоненциального сглаживания, впоследствии названный его именем. В предложенном алгоритме значения уровня и тренда сглаживаются с помощью экспоненциального сглаживания. Причем параметры сглаживания у них различны. </p>

                    <p>Первое уравнение описывает сглаженный ряд для прогнозного значения Y на момент времени t с использованием информации на момент времени t–1.</p>
                    <img src="/img/holt1.gif"/>
                    <p>где α – постоянная сглаживания; Yпрогн., t, Yпрогн., t–1 – прогнозные значения показателя в последующий и предыдущий момент времени; Yt – табличное значение показателя в момент времени t; Тt–1 – значение тренда на момент времени t–1, которое определяется из второго уравнения.</p>
                    <p></p>
                    <p>Второе уравнение служит для оценки тренда:</p>
                    <img src="/img/holt2.gif"/>
                    <p>где β – постоянная сглаживания. Для определения прогноза на p отсчетов по времени используется третье уравнение:</p>
                    <p></p>
                    <img src="/img/holt3.gif"/>
                    <p>Частным случаем метода Хольта является метод Брауна, когда α = β. Постоянные сглаживания α и β подбираются путем перебора с определенным шагом. При более высоких значениях α в большей степени учитываются прошлые значения ряда; аналогично более высокие значения β оценивают прошлое движение процесса по сравнению с существующим.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
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
                <h4 class="modal-title" id="myModalLabel">Оптимальный прогноза для валютной пары <?php echo $curentCureency->title;?> по методу Хольта и Брауна</h4>
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
                <p> На основе оптимального прогноза на <span class="optDate"><?php echo $minValuesHolt->date;?></span>  можно сделать предположение,
                    что оптимальный прогноз для метода Хольта и Брауна считается с коеффициентом <span class="optKoef"> <?php echo $minValuesHolt->k; ?></span></p>

                <p><b>Курс <span class="optDate"><?php echo $minValuesHolt->date;?></span> :</b>  <span class="optVal"><?php echo $minValuesHolt->yt." ".$curentCureency->valuta?> за 1$.</span></p>
                <p><b>Отпимальный прогноз на  <span class="optDateTommorow"><?php echo $dateTommorow;?>:</b>  <?php echo $minValuesHolt->yt_1." ".$curentCureency->valuta?> за 1$.</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>