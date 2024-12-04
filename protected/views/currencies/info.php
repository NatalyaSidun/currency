<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 02.03.15
 * Time: 21:13
 */
$this->title = "Справка";
?>

<div class="content">
    <div class="col-md-12">
        <h3 class="t1">Справка</h3>
        <hr>
    </div>
    <div class="col-md-12 info">
        <div role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#auth" aria-controls="auth" role="tab" data-toggle="tab">Авторизация и Выход</a></li>
                <li role="presentation"><a href="#choose" aria-controls="choose" role="tab" data-toggle="tab">Как выбрать валюту</a></li>
                <li role="presentation"><a href="#rates" aria-controls="rates" role="tab" data-toggle="tab">Как узнать курс</a></li>
                <li role="presentation"><a href="#forecast" aria-controls="forecast" role="tab" data-toggle="tab">Как узнать прогноз</a></li>
                <li role="presentation"><a href="#optimal" aria-controls="optimal" role="tab" data-toggle="tab">Как узнать оптимальный прогноз</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="auth">
                    <p></p>
                    <h4 class="label label-success">Авторизация и Выход <small>(Кликнув на любое фото, оно откроет в полный формате)</small></h4>
                    <p></p>
                    <p>Для того, чтоб начать пользоваться программой нужно сначала авторизироваться</p>
                    <p>Ввести логин и пароль в окне авторизации</p>
                    <a class="fancybox" rel="group1" href="/img/info1.jpg">
                        <img src="/img/info1.jpg" width="200" alt="" />
                    </a>
                    <p></p>
                    <p>Чтоб разлогиниться, нужно нажать кнопку "Выход"</p>
                    <a class="fancybox" rel="group1" href="/img/info2.jpg">
                        <img src="/img/info2.jpg" width="200" alt="" />
                    </a>
                </div>
                <div role="tabpanel" class="tab-pane" id="choose">
                    <p></p>
                    <h4 class="label label-success">Как выбрать валюту <small>(Кликнув на любое фото, оно откроется в полном формате)</small></h4>
                    <p></p>
                    <p>Для того, чтоб выбрать или изменить валюту, нужно в левом меню выбрать пункт "Изменить валюту"</p>
                    <a class="fancybox" rel="group2" href="/img/info3.jpg">
                        <img src="/img/info3.jpg" width="200" alt="" />
                    </a>
                    <p></p>
                    <p>Затем из выпадающего списка выбрать нужную валютную пару</p>
                    <a class="fancybox" rel="group2" href="/img/info4.jpg">
                        <img src="/img/info4.jpg" width="200" alt="" />
                    </a>
                </div>
                <div role="tabpanel" class="tab-pane" id="rates">
                    <p></p>
                    <h4 class="label label-success">Как узнать текущий курс валют <small>(Кликнув на любое фото, оно откроется в полном формате)</small></h4>
                    <p></p>
                    <p>Чтоб узнать сегодняшний курс или курс на любой предидущий день с 1 января 2015 года для выбранной валютной пары нужно зайти во вкладку архив прогнозов</p>
                    <a class="fancybox" rel="group3" href="/img/info5.jpg">
                        <img src="/img/info5.jpg" width="200" alt="" />
                    </a>
                    <p>А затем на графике навести на нужный день</p>
                    <a class="fancybox" rel="group3" href="/img/info6.jpg">
                        <img src="/img/info6.jpg" width="200" alt="" />
                    </a>
                    <p></p>
                    <p>Для того,чтоб просмотреть прогнозы за более короткий срок, нужно всего лишь нажать на графике на начало периода и потянуть мышь до конца нужного периода. </p>
                    <a class="fancybox" rel="group3" href="/img/info7.jpg">
                        <img src="/img/info7.jpg" width="200" alt="" />
                    </a>
                    <p></p>
                    <a class="fancybox" rel="group3" href="/img/info8.jpg">
                        <img src="/img/info8.jpg" width="200" alt="" />
                    </a>
                    <p></p>
                    <p>Чтоб сбросить зум, нужно нажать на графике на кнопку "Сбросить ЗУМ". </p>
                    <a class="fancybox" rel="group3" href="/img/info9.jpg">
                        <img src="/img/info9.jpg" width="200" alt="" />
                    </a>
                </div>
                <div role="tabpanel" class="tab-pane" id="forecast">
                    <p></p>
                    <h4 class="label label-success">Как узнать прогноз <small>(Кликнув на любое фото, оно откроется в полном формате)</small></h4>
                    <p></p>
                    <p>Прогноз можно сделать по трем методам: по методу Скользящего Среднего, по методу Хотьла и Брауна и по методу Винтерса. </p>
                    <p>Чтоб узнать прогноз по одному из методов нужно в верхнем меню кликнуть по одной из трех кнопок. </p>
                    <a class="fancybox" rel="group4" href="/img/info10.jpg">
                        <img src="/img/info10.jpg" width="200">
                    </a>
                    <p></p>
                    <p><b>1. Прогноз по методу скользящего среднего. </b></p>
                    <a class="fancybox" rel="group4" href="/img/info11.jpg">
                        <img src="/img/info11.jpg" width="200">
                    </a>
                    <p></p>
                    <p>В данном методе расчеты ведуться для девяти вариантов коэффициента а. Чтоб посмотреть результаты расчетов нужно поставить галочку, возле того коэффициента, для которого нужно узнать прогноз.</p>
                    <a class="fancybox" rel="group4" href="/img/info12.jpg">
                        <img src="/img/info12.jpg" width="200">
                    </a>
                    <p></p>
                    <p>Чтоб посмотреть подробные расчеты для каждого коэффициента, нужно нажать на кнопку в правом нижнем углу каждой карточки. </p>
                    <a class="fancybox" rel="group4" href="/img/info13.jpg">
                        <img src="/img/info13.jpg" width="200">
                    </a>
                    <p></p>
                    <p>Результаты расчета можно посмотреть в виде таблицы</p>
                    <a class="fancybox" rel="group4" href="/img/info14.jpg">
                        <img src="/img/info14.jpg" width="200">
                    </a>
                    <p></p>
                    <a class="fancybox" rel="group4" href="/img/info15.jpg">
                        <img src="/img/info15.jpg" width="200">
                    </a>
                    <p></p>
                    <p>Так же пролистав вниз можно увидеть, график зависимости курса валют от коэффициента а. </p>
                    <a class="fancybox" rel="group4" href="/img/info16.jpg">
                        <img src="/img/info16.jpg" width="200">
                    </a>
                    <p>Нажав на кнопку "справка", можно посмотреть информацию о методе. </p>
                    <a class="fancybox" rel="group4" href="/img/info17.jpg">
                        <img src="/img/info17.jpg" width="200">
                    </a>
                    <p></p>
                    <a class="fancybox" rel="group4" href="/img/info18.jpg">
                        <img src="/img/info18.jpg" width="200">
                    </a>
                    <p></p>
                    <p>Нажав на кнопку "отчет", можно сохранить отчет за текущий день. </p>
                    <a class="fancybox" rel="group4" href="/img/info19.jpg">
                        <img src="/img/info19.jpg" width="200">
                    </a>

                    <p></p>
                    <p>Выбрав в календаре любой день, можно посмотреть прогноз на этот день, сохранить отчет, посмотреть таблицу и графики зависимости. </p>
                    <a class="fancybox" rel="group4" href="/img/info20.jpg">
                        <img src="/img/info20.jpg" width="200">
                    </a>
                    <p></p>
                    <a class="fancybox" rel="group4" href="/img/info21.jpg">
                        <img src="/img/info21.jpg" width="200">
                    </a>
                    <p></p>
                    <p>Прогноз по методу Хольта и Бруна и по методу Винтрса происходит аналогичным образом.</p>
                    <p></p>
                    <p>Чтоб посмотреть, архив прогнозов за любые предидущие дни с различными коэффициентами, нужно выбрать в левом меню пункт "Архив прогнозов."</p>
                    <a class="fancybox" rel="group4" href="/img/info22.jpg">
                        <img src="/img/info22.jpg" width="200">
                    </a>
                    <p></p>
                    <a class="fancybox" rel="group4" href="/img/info23.jpg">
                        <img src="/img/info23.jpg" width="200">
                    </a>
                    <p></p>
                    <a class="fancybox" rel="group4" href="/img/info24.jpg">
                        <img src="/img/info24.jpg" width="200">
                    </a>
                    <p></p>
                    <a class="fancybox" rel="group4" href="/img/info25.jpg">
                        <img src="/img/info25.jpg" width="200">
                    </a>
                    <p></p>
                </div>
                <div role="tabpanel" class="tab-pane" id="optimal">
                </div>
            </div>

        </div>

    </div>
</div>