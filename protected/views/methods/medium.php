<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 02.03.15
 * Time: 21:13
 */
$this->title = "Прогноз по методу скользящего среднего";
?>
<div class="wrap-wait">
    <i class="fa fa-spinner fa-pulse fa-5x"></i>
</div>
<div class="content">
        <div class="col-md-12">
            <h3 class="t1">Прогноз по методу <b>скользящего среднего</b> для валютной пары <b><?php echo $curentCureency->title; ?></b></h3>
            <hr>
        </div>
        <div class="col-md-9 col-md-offset-2">
            <button type="button"  data-toggle="modal" data-target="#minValues"   class="btn btn-success">Оптимальный прогноз по методу скользящего среднего</button>
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
                        <span>31</span>
                        <small>Марта 2015</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div id="datepicker-medium"></div>
            <div class="dop-btns">
                <div class="btn-group">
                    <a class="btn btn-default" data-toggle="modal" data-target="#myModal" href="javascript:void(0)" title="Информация о методе скользящего среднего">
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

        <div class="popups">
            <?php for($i=0; $i<count($prognoz); $i++){?>
                <div class="modal fade" id="popup-calculation<?php echo $i+1;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Расчет прогноза на <?php echo $dateTommorow; ?> по методу скользящих средних с коэффициентом <?php echo $prognoz[$i]->a; ?></h4>
                            </div>
                            <div class="modal-body">
                                <p>Y<small>t+1</small>=a*Y<small>t</small>+(1-a)*^Y<small>t</small></p>
                                <p>где Yt+1– прогноз на следующий период времени </p>
                                <p>Yt – реальное значение в момент времени t </p>
                                <p>^Yt – прошлый прогноз на момент времени t </p>
                                <p>a – постоянная сглаживания (0<=a<=1) </p>
                                <p class="t4"><b>Значения на <?php echo $valuesForDayBefore[$i]->date;?> для k=<?php echo $valuesForDayBefore[$i]->a;?></b></p>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Значение курса</th>
                                        <th>Прогноз</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $valuesForDayBefore[$i]->yt;?> <?php echo $curentCureency->valuta?></td>
                                        <td><?php echo $valuesForDayBefore[$i]->yt_1;?> <?php echo $curentCureency->valuta?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <p class="t3"><b>Рассмотрим подробнее</b></p>
                                <p>Находим прогноз на <?php echo $dateTommorow; ?> </p>
                                <p> Y<small>t+1</small>=a*Y<small>t</small>+(1-a)*^Y<small>t</small> = </p>
                                <p><?php echo $prognoz[$i]->a." * ".$prognoz[$i]->yt." + (1 - a) * ".$valuesForDayBefore[$i]->yt_1. " = ".$prognoz[$i]->yt_1;?> <?php echo $curentCureency->valuta?> за 1$</p>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Метод Скользящего среднего</h4>
                </div>
                <div class="modal-body">
                    <p>Самой простой моделью, основанной на простом усреднении является </p>
                    <p><b>Y(t+1)=(1/(t))*[Y(t)+Y(t-1)+...+Y(1)], </b></p>
                    <p>и в отличии от самой простой "наивной" модели, которой соответствовал принцип "завтра будет как сегодня", этой модели соответствует принцип "завтра будет как было в среднем за последнее время". Такая модель, конечно более устойчива к флуктуациям, поскольку в ней сглаживаются случайные выбросы относительно среднего. Несмотря на это, этот метод идеологически настолько же примитивен как и "наивные" модели и ему свойственны почти те же самые недостатки. </p>

                    <p>В приведенной выше формуле предполагалось, что ряд усредняется по достаточно длительному интервалу времени. Однако как правило, значения временного ряда из недалекого прошлого лучше описывают прогноз, чем более старые значения этого же ряда. Тогда можно использовать для прогнозирования скользящее среднее </p>
                    <p><b>Y(t+1)=(1/(T+1))*[Y(t)+Y(t-1)+...+Y(t-T)], </b></p>
                    <p>Смысл его заключается в том, что модель видит только ближайшее прошлое (на T отсчетов по времени в глубину) и основываясь только на этих данных строит прогноз. </p>

                    <p> При прогнозировании довольно часто используется метод экспоненциальных средних, который постоянно адаптируется к данным за счет новых значений. Формула, описывающая эту модель записывается как </p>
                    <p><b>Y(t+1)=a*Y(t)+(1-a)*^Y(t), </b></p>
                    <p>где Y(t+1) – прогноз на следующий период времени </p>
                    <p>Y(t) – реальное значение в момент времени t </p>
                    <p>^Y(t) – прошлый прогноз на момент времени t </p>
                    <p>a – постоянная сглаживания (0<=a<=1)) </p>
                    <p>В этом методе есть внутренний параметр a, который определяет зависимость прогноза от более старых данных, причем влияние данных на прогноз экспоненциально убывает с "возрастом" данных. Зависимость влияния данных на прогноз при разных коэффициентах a приведена на графике. </p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>



        <div class="modal fade" id="dataTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Результаты расчета прогноза для валютной пары <?php echo $curentCureency->title;?> по методу скользящего среднего</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>a</th>
                                <th>Прогноз</th>
                            </tr>
                            </thead>
                            <tbody class="bodyInner">
                            <?php foreach($prognoz as $item){?>
                                <tr>
                                    <td><?php echo $item->a;?></td>
                                    <td><?php echo $item->yt_1;?> <?php echo $curentCureency->valuta?></td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                        <div id="medium-chart" style="width: 550px;"></div>

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
            <span class="label label-success"><?php echo "a=".$item->a?></span>
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
                <h4 class="modal-title" id="myModalLabel">Оптимальный прогноза для валютной пары <?php echo $curentCureency->title;?> по методу скользящего среднего</h4>
            </div>
            <div class="modal-body">
                <p>Оптимальный прогноз на <span class="optDate"><?php echo $minValuesMedium->date;?></span></p>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>a</th>
                        <th>Прогноз</th>
                        <th>Ошибка</th>
                    </tr>
                    </thead>
                    <tbody class="bodyInn">
                    <tr>
                        <td><?php echo $minValuesMedium->a;?></td>
                        <td><?php echo $minValuesMedium->yt_1;?> <?php echo $curentCureency->valuta?></td>
                        <td><?php echo $minValuesMedium->e;?> % </td>
                    </tr>
                    </tbody>
                </table>
                <p> На основе оптимального прогноза на <span class="optDate"><?php echo $minValuesMedium->date;?></span>  можно сделать предположение,
                    что оптимальный прогноз для метода Хольта и Брауна считается с коэффициентом <span class="optKoef"> <?php echo $minValuesMedium->a; ?></span></p>

                <p><b>Курс <span class="optDate"><?php echo $minValuesMedium->date;?></span> :</b>  <span class="optVal"><?php echo $minValuesMedium->yt." ".$curentCureency->valuta?> за 1$.</span></p>
                <p><b>Отпимальный прогноз на  <span class="optDateTommorow"><?php echo $dateTommorow;?>:</b>  <?php echo $minValuesMedium->yt_1." ".$curentCureency->valuta?> за 1$.</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>