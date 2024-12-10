<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 02.03.15
 * Time: 21:13
 */
$this->title = "Прогноз по методу Винтерса";
?>


<div class="wrap-wait">
    <i class="fa fa-spinner fa-pulse fa-5x"></i>
</div>
<div class="content">
<div class="col-md-12">
    <h3 class="t1">Прогноз по методу <b>Винтерса</b> для валютной пары <b><?php echo $curentCureency->title; ?></b></h3>
    <hr>
</div>
<div class="col-md-9 col-md-offset-3">
    <button type="button"  data-toggle="modal" data-target="#minValues"   class="btn btn-success">Оптимальный прогноз по методу Винтерса</button>
    <br>
    <br>
</div>
<div class="row">
    <div class="col-md-9">
            <div class="btns">
                <div class="row">
                    <div class="col-md-1 col-md-offset-1">
                        <label>
                            <input type="checkbox" data-card-k="1" class="k"> <span class="label label-success kbut">k=0.1</span>
                        </label>
                    </div>
                    <div class="col-md-1">
                        <label>
                            <input type="checkbox" data-card-k="3" class="k"> <span class="label label-success kbut">k=0.3</span>
                        </label>
                    </div>
                    <div class="col-md-1">
                        <label>
                            <input type="checkbox" data-card-k="5" class="k"> <span class="label label-success kbut">k=0.5</span>
                        </label>
                    </div>
                    <div class="col-md-1">
                        <label>
                            <input type="checkbox" data-card-k="7" class="k"> <span class="label label-success kbut">k=0.7</span>
                        </label>
                    </div>
                    <div class="col-md-1" >
                        <label>
                            <input type="checkbox" data-card-k="9" class="k"> <span class="label label-success kbut">k=0.9</span>
                        </label>
                    </div>

                    <div class="col-md-1" id="one" >
                        <label>
                            <input type="checkbox" data-card-q="1" > <span class="label label-primary kbut">q=0.1</span>
                        </label>
                    </div>
                    <div class="col-md-1" >
                        <label>
                            <input type="checkbox" data-card-q="3"> <span class="label label-primary qbut">q=0.3</span>
                        </label>
                    </div>
                    <div class="col-md-1" >
                        <label>
                            <input type="checkbox" data-card-q="5"> <span class="label label-primary qbut">q=0.5</span>
                        </label>
                    </div>
                    <div class="col-md-1" >
                        <label>
                            <input type="checkbox" data-card-q="7"> <span class="label label-primary qbut">q=0.7</span>
                        </label>
                    </div>
                    <div class="col-md-1">
                        <label>
                            <input type="checkbox" data-card-q="9"> <span class="label label-primary qbut">q=0.9</span>
                        </label>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-2 col-md-offset-5">
                    <div class="dateVinters">
                        <span>31</span>
                        <small>March 2015</small>
                    </div>
                </div>

            </div>
         <div class="cards-vinters">
         </div>
    </div>

    <div class="col-md-3">
        <div id="datepicker-vinters"></div>
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
                <h4 class="modal-title" id="myModalLabel">Как расчичать прогноз по методу Винтерса</h4>
            </div>
            <div class="modal-body">
                <ol>
                    <li>
                        <p>Рассчитываем экспоненциально-сглаженный ряд:</p>
                        <p>Lt=k*Yt/St-s+(1-k)*(Lt-1+Tt-1)</p>
                    </li>
                    <li>
                        <p>Определяем значение тренда:</p>
                        <p>Tt=b*(Lt - Lt-1)+(1-b)*Tt-1</p>
                    </li>
                    <li>
                        <p>Оцениваем сезонность:</p>
                        <p>St=q*Yt/Lt+(1-q)*St-s</p>
                    </li>
                    <li>
                        <p>Делаем прогноз:</p>
                        <p>Ŷt+p = (Lt + p *Tt)*St-s+p</p>
                    </li>
                </ol>
                <p class="t3">Рассмотрим подробнее:</p>
                <ol>
                    <li>
                        <p><b>Рассчитываем экспоненциально-сглаженный ряд:</b></p>
                        <p>Lt=k*Yt/St-s+(1-k)*(Lt-1+Tt-1)</p>
                        <p>где</p>
                        <p>Lt – сглаженная величина на текущий период;</p>
                        <p>k – коэффициент сглаживания ряда;</p>
                        <p>St-s  — коэффициент сезонности предыдущего периода;</p>
                        <p>Yt – текущее значение ряда (например, объём продаж);</p>
                        <p>Lt-1 – сглаженная величина за предыдущий период;</p>
                        <p>Tt-1 – значение тренда за предыдущий период;</p>
                        <p>Tt-1 – значение тренда за предыдущий период;</p>
                        <div>
                            Lt (Сглаженная величина текущий период) = k(коэффициент сглаживания ряда)* Yt (текущее значение ряда (например, объём продаж))/St-s (коэффициент сезонности за этот же период в предыдущем сезоне) )+(1-коэфициент сглаживания ряда)*( Lt-1(сглаженная величина за предыдущий период) -Tt-1(тренд за предыдущий период)
                        </div>
                        <div>
                            Коэффициент сглаживания ряда k задается вами вручную и находится в диапазоне от 0 до 1.
                        </div>
                        <div>
                            Для первого периода в начале данных экспоненциально-сглаженный ряд равен первому значению ряда (например, объему продаж за первый месяц) L1=Y1;
                        </div>
                        <div>
                            Сезонность в первом и втором периоде St-s равна 1.
                        </div>
                    </li>
                    <li>
                        <p><b>Определяем значение тренда:</b></p>
                        <p>Tt=b*(Lt - Lt-1)+(1-b)*Tt-1</p>
                        <p>где</p>
                        <p>Tt – значение тренда на текущий период;</p>
                        <p> b – коэффициент сглаживания тренда;</p>
                        <p>Lt – экспоненциально сглаженная величина за текущий период;</p>
                        <p>Lt-1 – экспоненциально сглаженная величина за предыдущий период;</p>
                        <p>Tt-1 – значение тренда за предыдущий период.</p>
                        <div>Tt(значение тренда на текущий период)=b(коэффициент сглаживания тренда)*(Lt(экспоненциально сглаженная величина за текущий период) - Lt-1экспоненциально сглаженная величина за предыдущий период))+(1-b(коэффициент сглаживания тренда))*Tt-1 (значение тренда за предыдущий период)</div>
                        <div> Коэффициент сглаживания тренда b задается вами вручную и находится в диапазоне от 0 до 1</div>
                        <div> Значение тренда для первого периода равно 0 (T1 =0);</div>
                    </li>
                    <li>
                        <p><b>Оцениваем сезонность:</b></p>
                        <p>St=q*Yt/Lt+(1-q)*St-s</p>
                        <p>где</p>
                        <p>St — коэффициент сезонности для текущего периода;</p>
                        <p>q — коэффициент сглаживания сезонности;</p>
                        <p>Yt — текущее значение ряда (например, объём продаж));</p>
                        <p>Lt — сглаженная величина за текущий период;</p>
                        <p>St-s — коэффициент сезонности за этот же период в предыдущем сезоне;</p>
                        <div>
                            St(коэффициент сезонности для текущего периода)=q (коэффициент сглаживания сезонности)*Yt(текущее значение ряда (например, объём продаж))/Lt(Сглаженная величина за текущий период) +(1-q(коэффициент сглаживания сезонности)*)*St-s (коэффициент сезонности за этот же период в предыдущем сезоне)
                        </div>
                    </li>
                    <li>
                        <p><b>Сделаем прогноз по методу Хольта-Винтерса</b></p>
                        <p>Прогноз на p периодов вперед равен:</p>
                        <p>Ŷt+p =(Lt +p*Tt)*St-s+p</p>
                        <p>где</p>
                        <p>Ŷt+p — прогноз по методу Хольта-Винтерса на p периодов вперед;</p>
                        <p>Lt – экспоненциально сглаженная величина за последний период;</p>
                        <p>p – порядковый номер периода, на который делаем прогноз;</p>
                        <p>Tt – тренд за последний период;</p>
                        <p>Lt – экспоненциально сглаженная величина за последний период;St-s+p — коэффициент сезонности за этот же период в последнем сезоне;</p>
                        <div>
                            Ŷt+p (Прогноз по методу Хольта-Винтерса)=( Lt (экспоненциально сглаженная величина за последний период)+ p (количество периодов вперед, на которое делаем прогноз) *Tt (тренд за последний период))*St-s+p (коэффициент сезонности за этот же период в последнем сезоне)
                        </div>
                    </li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
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
                    <h4 class="modal-title" id="myModalLabel">Расчет прогноза на <?php echo $prognoz[$i]->date; ?> по методу Винтерса с коэффициентами k = <?php echo $prognoz[$i]->k; ?>, q = <?php echo $prognoz[$i]->q; ?></h4>
                </div>
                <div class="modal-body">
                    <ol>
                        <li>
                            <p>Рассчитываем экспоненциально-сглаженный ряд:</p>
                            <p>Lt = k * Yt/St-s+(1-k)*(Lt-1+Tt-1)</p>
                        </li>
                        <li>
                            <p>Определяем значение тренда:</p>
                            <p>Tt=b*(Lt - Lt-1)+(1-b)*Tt-1</p>
                        </li>
                        <li>
                            <p>Оцениваем сезонность:</p>
                            <p>St=q*Yt/Lt+(1-q)*St-s</p>
                        </li>
                        <li>
                            <p>Делаем прогноз:</p>
                            <p>Ŷt+p = (Lt + p *Tt)*St-s+p</p>
                        </li>
                    </ol>
                    <p class="t4"><b>Значения на <?php echo $valuesForDayBefore[$i]->date;?> для k=<?php echo $valuesForDayBefore[$i]->k;?>, q=<?php echo $valuesForDayBefore[$i]->q;?></b></p>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Значение курса</th>
                            <th>Экспоненциально-сглаженный ряд</th>
                            <th>Значение тренда</th>
                            <th>Значение сезонности</th>
                            <th>Прогноз</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $valuesForDayBefore[$i]->yt;?> <?php echo $curentCureency->valuta?></td>
                            <td><?php echo $valuesForDayBefore[$i]->lt;?> <?php echo $curentCureency->valuta?></td>
                            <td><?php echo $valuesForDayBefore[$i]->trend;?></td>
                            <td><?php echo $valuesForDayBefore[$i]->st;?></td>
                            <td><?php echo $valuesForDayBefore[$i]->yt_1;?> <?php echo $curentCureency->valuta?></td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="t3">Рассмотрим подробнее:</p>
                    <ol>
                        <li>
                            <p>Рассчитываем экспоненциально-сглаженный ряд:</p>
                            <p>L<small>t</small> = k * Y<small>t</small>/S<small>t-s</small>+(1-k)*(L<small>t-1</small>+T<smal>t-1</smal>) = </p>
                            <p>= <?php echo $prognoz[$i]->k; ?> * <?php echo $prognoz[$i]->yt; ?> / <?php echo $season[$i]->st?> + (1 - <?php echo  $prognoz[$i]->k; ?>) * (<?php echo $valuesForDayBefore[$i]->lt;?> * <?php echo $valuesForDayBefore[$i]->trend; ?>) = <?php echo $prognoz[$i]->lt; ?></p>
                        </li>
                        <li>
                            <p><b>Определяем значение тренда:</b></p>
                            <p>T<small>t</small>=b*(L<small>t</small> - L<small>t-1</small>)+(1-b)*T<small>t-1</small> = </p>
                            <p> = 0.9 * (<?php echo $prognoz[$i]->lt; ?> - <?php echo $valuesForDayBefore[$i]->lt; ?>) + (1 - 0.9) * <?php echo $valuesForDayBefore[$i]->trend?> = <?php echo $prognoz[$i]->trend ?></p>
                        </li>
                        <li>
                            <p><b>Оцениваем сезонность:</b></p>
                            <p>S<small>t</small>=q*Y<small>t</small>/L<small>t</small>+(1-q)*S<small>t-s</small> = </p>
                            <p>= <?php echo $prognoz[$i]->k; ?> * <?php echo $prognoz[$i]->yt; ?> / <?php echo $prognoz[$i]->lt; ?> + (1 - <?php echo $prognoz[$i]->q; ?>) * <?php echo $season[$i]->st; ?> = <?php echo $prognoz[$i]->st ?></p>
                        </li>
                        <li>
                            <p><b>Сделаем прогноз по методу Винтерса</b></p>
                            <p>Прогноз на 1 период вперед равен:</p>
                            <p>Ŷ<small>t+1</small> =(L<small>t</small> +1*T<small>t</small>)*S<small>t-s+1</small> = </p>
                            <p> = (<?php echo $prognoz[$i]->lt; ?> + 1*<?php echo $prognoz[$i]->trend; ?>) * <?php echo $seasonForTommorowMonthBefore[$i]->st; ?> = <?php echo $prognoz[$i]->yt_1; ?></p>
                        </li>
                    </ol>


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
                <h4 class="modal-title" id="myModalLabel">Результаты расчета по методу Винтерса</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>k</th>
                        <th>q</th>
                        <th>Прогноз</th>
                    </tr>
                    </thead>
                    <tbody class="bodyInner">
                    <?php foreach($prognoz as $item){?>
                        <tr>
                            <td><?php echo $item->k;?></td>
                            <td><?php echo $item->q;?></td>
                            <td><?php echo $item->yt_1;?> <?php echo $curentCureency->valuta?></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <div id="kq-chart" style="width: 550px;"></div>
                <div id="qk-chart" style="width: 550px;"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<div class="cards-hidden">
    <?php for($i=0; $i<count($prognoz); $i++){?>
        <?php $k= explode(".", $prognoz[$i]->k);?>
        <?php $q= explode(".", $prognoz[$i]->q);?>
        <div class="card<?php echo $k[1];?><?php echo $q[1];?>">
                <span class="label label-success"><?php echo "k=".$prognoz[$i]->k?></span>
                <span class="label label-primary"><?php echo "q=".$prognoz[$i]->q?></span>
                <div class="row">
                    <div class="col-md-5"> Tренд: </div>
                    <div class="col-md-7"> <?php echo $prognoz[$i]->trend?> </div>
                </div>
                <div class="row">
                    <div class="col-md-5"> Сезонность: </div>
                    <div class="col-md-7"> <?php echo $season[$i]->st?> </div>
                </div>
                <div class="row">
                    <div class="col-md-5"> Завтра: </div>
                    <div class="col-md-7"> <?php echo $dateTommorow?> </div>
                </div>
                <div class="row">
                    <div class="col-md-5"> Прогноз: </div>
                    <div class="col-md-7">за 1$ <?php echo $prognoz[$i]->yt_1?> <?php echo $curentCureency->valuta?> </div>
                </div>
                <a class="btn btn-default" data-toggle="modal" data-target="#popup-calculation<?php echo $i+1;?>" href="javascript:void(0)" title="Подробнее расчеты">
                    <span class="p-t-5 p-b-5">
                        <i class="fa fa-question"></i>
                    </span>
                </a>
        </div>
    <?php } ?>
</div>

<div class="modal fade" id="minValues" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Оптимальний прогноз для валютної пари <?php echo $curentCureency->title;?> по методу Винтерса</h4>
            </div>
            <div class="modal-body">
                <p>Оптимальный прогноз на <span class="optDate"><?php echo $minValuesVinters->date;?></span></p>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>k</th>
                        <th>q</th>
                        <th>Прогноз</th>
                        <th>Ошибка</th>
                    </tr>
                    </thead>
                    <tbody class="bodyInn">
                    <tr>
                        <td><?php echo $minValuesVinters->k;?></td>
                        <td><?php echo $minValuesVinters->q;?></td>
                        <td><?php echo $minValuesVinters->yt_1;?> <?php echo $curentCureency->valuta?></td>
                        <td><?php echo $minValuesVinters->e;?> % </td>
                    </tr>
                    </tbody>
                </table>
                <p> На основе оптимального прогноза на <span class="optDate"><?php echo $minValuesVinters->date;?></span>  можно сделать предположение,
                    что оптимальный прогноз для метода Хольта и Брауна считается с коеффициентом <span class="optKoef"> k = <?php echo $minValuesVinters->k; ?>, q = <?php echo $minValuesVinters->q; ?> </span></p>

                <p><b>Курс <span class="optDate"><?php echo $minValuesVinters->date;?></span> :</b>  <span class="optVal"><?php echo $minValuesVinters->yt." ".$curentCureency->valuta?> за 1$.</span></p>
                <p><b>Отпимальный прогноз на  <span class="optDateTommorow"><?php echo $dateTommorow;?>:</b>  <?php echo $minValuesVinters->yt_1." ".$curentCureency->valuta?> за 1$.</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
