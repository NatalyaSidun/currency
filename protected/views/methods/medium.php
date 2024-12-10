<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 02.03.15
 * Time: 21:13
 */
$this->title = "Прогноз методом ковзного середнього";
?>
<div class="wrap-wait">
    <i class="fa fa-spinner fa-pulse fa-5x"></i>
</div>
<div class="content">
        <div class="col-md-12">
            <h3 class="t1">Прогноз методом <b>ковзного середнього</b> для валютної пари <b><?php echo $curentCureency->title; ?></b></h3>
            <hr>
        </div>
        <div class="col-md-9 col-md-offset-2">
            <button type="button"  data-toggle="modal" data-target="#minValues"   class="btn btn-success">Оптимальний прогноз методом ковзного середнього</button>
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
                    <a class="btn btn-default" data-toggle="modal" data-target="#myModal" href="javascript:void(0)" title="Інформація про метод ковзного середнього">
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

        <div class="popups">
            <?php for($i=0; $i<count($prognoz); $i++){?>
                <div class="modal fade" id="popup-calculation<?php echo $i+1;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Розрахунок прогнозу на  <?php echo $dateTommorow; ?> методом ковзних середніх з коефіцієнтом <?php echo $prognoz[$i]->a; ?></h4>
                            </div>
                            <div class="modal-body">
                                <p>Y<small>t+1</small>=a*Y<small>t</small>+(1-a)*^Y<small>t</small></p>
                                <p>где Yt+1– прогноз наступний період часу </p>
                                <p>Yt – реальне значення в момент  t </p>
                                <p>^Yt – минулий прогноз на момент t </p>
                                <p>a – константа згладження (0<=a<=1) </p>
                                <p class="t4"><b>Значення на <?php echo $valuesForDayBefore[$i]->date;?> для k=<?php echo $valuesForDayBefore[$i]->a;?></b></p>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Значення курсу</th>
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
                                <p class="t3"><b>Розглянемо детальніше</b></p>
                                <p>Вираховуємо прогноз на <?php echo $dateTommorow; ?> </p>
                                <p> Y<small>t+1</small>=a*Y<small>t</small>+(1-a)*^Y<small>t</small> = </p>
                                <p><?php echo $prognoz[$i]->a." * ".$prognoz[$i]->yt." + (1 - a) * ".$valuesForDayBefore[$i]->yt_1. " = ".$prognoz[$i]->yt_1;?> <?php echo $curentCureency->valuta?> за 1$</p>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
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
                    <h4 class="modal-title" id="myModalLabel">Метод ковзного середнього</h4>
                </div>
                <div class="modal-body">
                    <p>Найпростішою моделлю, заснованою на простому усередненні, є </p>
                    <p><b>Y(t+1)=(1/(t))*[Y(t)+Y(t-1)+...+Y(1)], </b></p>
                    <p>і на відміну від найпростішої "наївної" моделі, якій відповідав принцип "завтра буде так само, як сьогодні", цій моделі відповідає принцип "завтра буде так, як було в середньому за останній час". Така модель, звісно, більш стійка до флуктуацій, оскільки в ній згладжуються випадкові викиди відносно середнього. Незважаючи на це, цей метод ідеологічно настільки ж примітивний, як і "наївні" моделі, і йому притаманні майже ті самі недоліки. </p>

                    <p>У наведеній вище формулі припускалося, що ряд усереднюється за достатньо тривалий інтервал часу. Проте, як правило, значення часових рядів із недалекого минулого краще описують прогноз, ніж більш старі значення цього ж ряду. Тоді можна використовувати для прогнозування ковзне середнє </p>
                    <p><b>Y(t+1)=(1/(T+1))*[Y(t)+Y(t-1)+...+Y(t-T)], </b></p>
                    <p>Суть його полягає в тому, що модель "бачить" лише найближче минуле (на T відліків часу вглиб) і, спираючись лише на ці дані, формує прогноз. </p>

                    <p>При прогнозуванні досить часто використовується метод експоненційних середніх, який постійно адаптується до даних завдяки новим значенням. Формула, що описує цю модель, записується як </p>
                    <p><b>Y(t+1)=a*Y(t)+(1-a)*^Y(t), </b></p>
                    <p>де Y(t+1) – прогноз на наступний період часу </p>
                    <p>Y(t) – реальне значення в момент часу t </p>
                    <p>^Y(t) – минулий прогноз на момент часу t </p>
                    <p>a – константа згладжування (0<=a<=1) </p>
                    <p>У цьому методі є внутрішній параметр a, який визначає залежність прогнозу від більш старих даних, причому вплив даних на прогноз експоненційно зменшується з "віком" даних. Залежність впливу даних на прогноз при різних коефіцієнтах a наведено на графіку. </p>
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
                        <h4 class="modal-title" id="myModalLabel">Результати розрахунків для валютної пари <?php echo $curentCureency->title;?> методом ковзного середнього</h4>
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
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
                <h4 class="modal-title" id="myModalLabel">Оптимальний прогноз для валютної пари <?php echo $curentCureency->title;?> методом ковзного середнього</h4>
            </div>
            <div class="modal-body">
                <p>Оптимальний прогноз на <span class="optDate"><?php echo  $minValuesMedium ? $minValuesMedium->date : date('Y-m-d');?></span></p>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>a</th>
                        <th>Прогноз</th>
                        <th>Помилка</th>
                    </tr>
                    </thead>
                    <tbody class="bodyInn">
                    <tr>
                        <td><?php echo $minValuesMedium ?  $minValuesMedium->a : '';?></td>
                        <td><?php echo $minValuesMedium ? $minValuesMedium->yt_1 : '';?> <?php echo $curentCureency->valuta?></td>
                        <td><?php echo $minValuesMedium ? $minValuesMedium->e : '';?> % </td>
                    </tr>
                    </tbody>
                </table>
                <p> На основі оптимального прогнозу на <span class="optDate"><?php echo $minValuesMedium ? $minValuesMedium->date : '';?></span>  можна зробити припущення,
                    що оптимальний прогноз для методу Хольта і Брауна вираховується з коефіцієнтом <span class="optKoef"> <?php echo $minValuesMedium ? $minValuesMedium->a : ''; ?></span></p>

                <p><b>Курс <span class="optDate"><?php echo $minValuesMedium ? $minValuesMedium->date : '';?></span> :</b>  <span class="optVal"><?php echo ($minValuesMedium ? $minValuesMedium->yt : '') ." ". ($curentCureency->valuta ? $curentCureency->valuta : '0,00') ?> за 1$.</span></p>
                <p><b>Оптимальний прогноз на  <span class="optDateTommorow"><?php echo $dateTommorow ? $dateTommorow : date("Y-m-d", strtotime("+1 day")); ?>:</b>  <?php echo ($minValuesMedium ? $minValuesMedium->yt_1 : '' )." ". ($curentCureency ? $curentCureency->valuta : '0,00') ?> за 1$.</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
            </div>
        </div>
    </div>
</div>