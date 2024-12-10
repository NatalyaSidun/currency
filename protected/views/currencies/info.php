<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 02.03.15
 * Time: 21:13
 */
$this->title = "Довідка";
?>

<div class="content">
    <div class="col-md-12">
        <h3 class="t1">Довідка</h3>
        <hr>
    </div>
    <div class="col-md-12 info">
        <div role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#auth" aria-controls="auth" role="tab" data-toggle="tab">Авторизація і вихід</a></li>
                <li role="presentation"><a href="#choose" aria-controls="choose" role="tab" data-toggle="tab">Як обрати валютну пару</a></li>
                <li role="presentation"><a href="#rates" aria-controls="rates" role="tab" data-toggle="tab">Як дізнатися курс</a></li>
                <li role="presentation"><a href="#forecast" aria-controls="forecast" role="tab" data-toggle="tab">Як дізнатися прогноз</a></li>
                <li role="presentation"><a href="#optimal" aria-controls="optimal" role="tab" data-toggle="tab">Як дізнатись оптимальний прогноз</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="auth">
                    <p></p>
                    <h4 class="label label-success">Авторизація і вихід<small>(Клікніть на фото, і воно відкриється у повному розмірі)</small></h4>
                    <p></p>
                    <p>Щоб почати користуватись додатком, потрібно авторизуватись</p>
                    <p>Ввести логін та пароль і вікні авторизації</p>
                    <a class="fancybox" rel="group1" href="/img/info1.jpg">
                        <img src="/img/info1.jpg" width="200" alt="" />
                    </a>
                    <p></p>
                    <p>Щоб розлогінитись, натисніть кнопку "Вийти"</p>
                    <a class="fancybox" rel="group1" href="/img/info2.jpg">
                        <img src="/img/info2.jpg" width="200" alt="" />
                    </a>
                </div>
                <div role="tabpanel" class="tab-pane" id="choose">
                    <p></p>
                    <h4 class="label label-success">Як обрати валюту<small>(Клікніть на фото, і воно відкриється у повному розмірі)</small></h4>
                    <p></p>
                    <p>Для того, щоб обрати або змінити валюту, потрібно в лівому меню обрати пункт "Змінити валюту"</p>
                    <a class="fancybox" rel="group2" href="/img/info3.jpg">
                        <img src="/img/info3.jpg" width="200" alt="" />
                    </a>
                    <p></p>
                    <p>Потім із списку, що випадає обрати потрібну валютну пару</p>
                    <a class="fancybox" rel="group2" href="/img/info4.jpg">
                        <img src="/img/info4.jpg" width="200" alt="" />
                    </a>
                </div>
                <div role="tabpanel" class="tab-pane" id="rates">
                    <p></p>
                    <h4 class="label label-success">Як дізнатись поточний курс валют<small>(Клікніть на фото, і воно відкриється у повному розмірі)</small></h4>
                    <p></p>
                    <p>Щоб дізнатись поточний курс, або архівні значення для обраной пари зайдіть у вкладку "Архів прогнозів"
                    </p>
                    <a class="fancybox" rel="group3" href="/img/info5.jpg">
                        <img src="/img/info5.jpg" width="200" alt="" />
                    </a>
                    <p>На графіку навести курсов на обраний день</p>
                    <a class="fancybox" rel="group3" href="/img/info6.jpg">
                        <img src="/img/info6.jpg" width="200" alt="" />
                    </a>
                    <p></p>
                    <p>Щоб подивитись короткострокові прогнози, виділть курсором потрібний період на графіку</p>
                    <a class="fancybox" rel="group3" href="/img/info7.jpg">
                        <img src="/img/info7.jpg" width="200" alt="" />
                    </a>
                    <p></p>
                    <a class="fancybox" rel="group3" href="/img/info8.jpg">
                        <img src="/img/info8.jpg" width="200" alt="" />
                    </a>
                    <p></p>
                    <p>Щоб скинути зум, натиснить кнопку "Скинути" </p>
                    <a class="fancybox" rel="group3" href="/img/info9.jpg">
                        <img src="/img/info9.jpg" width="200" alt="" />
                    </a>
                </div>
                <div role="tabpanel" class="tab-pane" id="forecast">
                    <p></p>
                    <h4 class="label label-success">Як дізнатись прогноз <small>(Клікніть на фото, і воно відкриється у повному розмірі)</small></h4>
                    <p></p>
                    <p>Прогноз може бути виконаний трьома методами : методом ковзного середнього, методом Хольта-Брауна і методом Вінтерса. </p>
                    <p>Щоб дізнатись прогноз за обраним методом, зайдіть у відповідну вкладку </p>
                    <a class="fancybox" rel="group4" href="/img/info10.jpg">
                        <img src="/img/info10.jpg" width="200">
                    </a>
                    <p></p>
                    <p><b>1. Прогноз за методом ковзного середнього </b></p>
                    <a class="fancybox" rel="group4" href="/img/info11.jpg">
                        <img src="/img/info11.jpg" width="200">
                    </a>
                    <p></p>
                    <p>В даному методі розрахункі ведуться для девʼяти варіантів коефіцієнту а. Щоб подивитись результати розрахунків треба поставити галочку  біля обраного коефіцієнту</p>
                    <a class="fancybox" rel="group4" href="/img/info12.jpg">
                        <img src="/img/info12.jpg" width="200">
                    </a>
                    <p></p>
                    <p> Щоб подивитись детальні розрахунки для кожного коефіцієнту, натисніть кнопку в правому нижньому куті карточки </p>
                    <a class="fancybox" rel="group4" href="/img/info13.jpg">
                        <img src="/img/info13.jpg" width="200">
                    </a>
                    <p></p>
                    <p>Результати розрахунків можно подивитись у вигляді таблиці</p>
                    <a class="fancybox" rel="group4" href="/img/info14.jpg">
                        <img src="/img/info14.jpg" width="200">
                    </a>
                    <p></p>
                    <a class="fancybox" rel="group4" href="/img/info15.jpg">
                        <img src="/img/info15.jpg" width="200">
                    </a>
                    <p></p>
                    <p>Прокрутивши донизу можно побачити графік залежності курса валют від коефіцієнту а. </p>
                    <a class="fancybox" rel="group4" href="/img/info16.jpg">
                        <img src="/img/info16.jpg" width="200">
                    </a>
                    <p>Натиснуши на кнопку "довідка", можно подивитись інформацію про метод. </p>
                    <a class="fancybox" rel="group4" href="/img/info17.jpg">
                        <img src="/img/info17.jpg" width="200">
                    </a>
                    <p></p>
                    <a class="fancybox" rel="group4" href="/img/info18.jpg">
                        <img src="/img/info18.jpg" width="200">
                    </a>
                    <p></p>
                    <p>Натиснувши на кнопку "звіт", можна зберегти звіт за поточний день </p>
                    <a class="fancybox" rel="group4" href="/img/info19.jpg">
                        <img src="/img/info19.jpg" width="200">
                    </a>

                    <p></p>
                    <p>Обравши в календарі будь-який день, можна подивитись прогноз на даний день, зберегти звіт і подивитись аблиці і графіки</p>
                    <a class="fancybox" rel="group4" href="/img/info20.jpg">
                        <img src="/img/info20.jpg" width="200">
                    </a>
                    <p></p>
                    <a class="fancybox" rel="group4" href="/img/info21.jpg">
                        <img src="/img/info21.jpg" width="200">
                    </a>
                    <p></p>
                    <p>Щоб дізнатись прогноз за методами Хольта-Брауна і Вінтерса, зайдіть у відповідну вкладку </p>
                    <p></p>
                    <p>Щоб подивитись архів прогнозів за будь-які попередні дати требва обрати "Архів прогнозів"</p>
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