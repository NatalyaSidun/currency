<?php
/**
 * Created by PhpStorm.
 * User: Екатерина
 * Date: 02.03.15
 * Time: 21:13
 */
$this->title = "Математическая модель";
?>

<div class="content">
    <div class="col-md-12">
        <h3 class="t1">Математична модель</h3>
        <hr>
    </div>
    <div class="col-md-10 col-md-offset-1 info">
        <div role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#medium" aria-controls="medium" role="tab" data-toggle="tab">Метод ковзного середнього</a></li>
                <li role="presentation"><a href="#holt" aria-controls="holt" role="tab" data-toggle="tab">Метод Хольта і Брауна</a></li>
                <li role="presentation"><a href="#vinters" aria-controls="vinters" role="tab" data-toggle="tab">Метод Вінтерса</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="medium">
                    <p class="t5 label label-success"><b>Метод Скользящего Среднего</b></p>
                    <div>
                        <div> <p>Найпростішою моделлю, що базується на простому усередненні, є:</p> <p><b>Y(t+1) = (1/t) * [Y(t) + Y(t-1) + ... + Y(1)], </b></p> <p>і, на відміну від найпростішої "наївної" моделі, яка ґрунтується на принципі "завтра буде так, як сьогодні", ця модель відповідає принципу "завтра буде так, як було в середньому за останній час". Така модель, безумовно, є більш стійкою до флуктуацій, оскільки випадкові викиди згладжуються відносно середнього значення. Попри це, цей метод є настільки ж ідеологічно примітивним, як і "наївні" моделі, та має майже ті самі недоліки.</p>
                            <p>У наведеній вище формулі передбачалося, що ряд усереднюється за досить тривалий часовий інтервал. Однак, як правило, значення часового ряду з недавнього минулого краще описують прогноз, ніж більш давні значення цього ж ряду. У такому разі для прогнозування можна використовувати ковзне середнє:</p>
                            <p><b>Y(t+1) = (1/(T+1)) * [Y(t) + Y(t-1) + ... + Y(t-T)], </b></p>
                            <p>Суть цього методу полягає в тому, що модель враховує лише найближче минуле (на T відліків у часі назад) і на основі цих даних будує прогноз.</p>

                            <p>Під час прогнозування досить часто використовується метод експоненціальних середніх, який постійно адаптується до нових даних. Формула, що описує цю модель, записується так:</p>
                            <p><b>Y(t+1) = a * Y(t) + (1-a) * ^Y(t), </b></p>
                            <p>де:</p>
                            <p>Y(t+1) – прогноз на наступний період часу,</p>
                            <p>Y(t) – фактичне значення в момент часу t,</p>
                            <p>^Y(t) – попередній прогноз на момент часу t,</p>
                            <p>a – постійна згладжування (0 ≤ a ≤ 1).</p>

                            <p>У цьому методі є внутрішній параметр a, який визначає залежність прогнозу від давніших даних. Вплив даних на прогноз експоненційно зменшується зі "старінням" цих даних. Залежність впливу даних на прогноз при різних значеннях коефіцієнта a проілюстрована на графіку.</p>
                        </div>
                        </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="holt">
                    <p class="t5 label label-success"><b>Метод Хольта и Брауна</b></p>
                    <div>
                        <img src="/img/holt1.gif"/><br>
                        <img src="/img/holt2.gif"/><br>
                        <img src="/img/holt3.gif"/><br>
                        <p>де α – постійна згладжування;</p>
                        <p>Y<sub>прогн.</sub>, t, Y<sub>прогн.</sub>, t–1 – прогнозовані значення показника на наступний та попередній моменти часу;</p>
                        <p>Y<sub>t</sub> – табличне значення показника у момент часу t;</p>
                        <p>T<sub>t–1</sub> – значення тренду на момент часу t–1, яке визначається з другого рівняння.</p>
                        <p>де β – постійна згладжування.</p>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="vinters">
                    <p class="t5 label label-success"><b>Метод Винтерса</b></p>
                    <div>
                        <div>
                            <p><b>1. Розрахунок експоненційно згладженого ряду:</b></p>
                            <p>Lt = k * Yt / St-s + (1 - k) * (Lt-1 + Tt-1)</p>
                            <p>де:</p>
                            <p>Lt — згладжена величина на поточний період;</p>
                            <p>k — коефіцієнт згладжування ряду;</p>
                            <p>St-s — коефіцієнт сезонності попереднього періоду;</p>
                            <p>Yt — поточне значення ряду (наприклад, обсяг продажів);</p>
                            <p>Lt-1 — згладжена величина за попередній період;</p>
                            <p>Tt-1 — значення тренду за попередній період.</p>
                            <div>
                                Lt (Згладжена величина на поточний період) = k (коефіцієнт згладжування ряду) * Yt (поточне значення ряду) / St-s (коефіцієнт сезонності для цього ж періоду у попередньому сезоні) + (1 - k) * (Lt-1 (згладжена величина за попередній період) + Tt-1 (тренд за попередній період)).
                            </div>
                            <div>
                                Коефіцієнт згладжування ряду k задається вручну і знаходиться в діапазоні від 0 до 1.
                            </div>
                            <div>
                                Для першого періоду в початкових даних експоненційно згладжений ряд дорівнює першому значенню ряду (наприклад, обсяг продажів за перший місяць): L1 = Y1.
                            </div>
                            <div>
                                Сезонність у першому і другому періодах St-s дорівнює 1.
                            </div>
                        </div>
                        <p></p>
                        <div>
                            <p><b>2. Визначення значення тренду:</b></p>
                            <p>Tt = b * (Lt - Lt-1) + (1 - b) * Tt-1</p>
                            <p>де:</p>
                            <p>Tt — значення тренду на поточний період;</p>
                            <p>b — коефіцієнт згладжування тренду;</p>
                            <p>Lt — експоненційно згладжена величина за поточний період;</p>
                            <p>Lt-1 — експоненційно згладжена величина за попередній період;</p>
                            <p>Tt-1 — значення тренду за попередній період.</p>
                            <div>
                                Tt (значення тренду на поточний період) = b (коефіцієнт згладжування тренду) * (Lt (експоненційно згладжена величина за поточний період) - Lt-1 (експоненційно згладжена величина за попередній період)) + (1 - b) * Tt-1 (значення тренду за попередній період).
                            </div>
                            <div>
                                Коефіцієнт згладжування тренду b задається вручну і знаходиться в діапазоні від 0 до 1.
                            </div>
                            <div>
                                Значення тренду для першого періоду дорівнює 0 (T1 = 0).
                            </div>
                        </div>
                        <p></p>
                        <div>
                            <p><b>3. Оцінка сезонності:</b></p>
                            <p>St = q * Yt / Lt + (1 - q) * St-s</p>
                            <p>де:</p>
                            <p>St — коефіцієнт сезонності для поточного періоду;</p>
                            <p>q — коефіцієнт згладжування сезонності;</p>
                            <p>Yt — поточне значення ряду (наприклад, обсяг продажів);</p>
                            <p>Lt — згладжена величина за поточний період;</p>
                            <p>St-s — коефіцієнт сезонності для цього ж періоду у попередньому сезоні.</p>
                            <div>
                                St (коефіцієнт сезонності для поточного періоду) = q (коефіцієнт згладжування сезонності) * Yt (поточне значення ряду) / Lt (згладжена величина за поточний період) + (1 - q) * St-s (коефіцієнт сезонності для цього ж періоду у попередньому сезоні).
                            </div>
                        </div>
                        <p></p>
                        <div>
                            <p><b>4. Прогноз за методом Хольта-Вінтерса:</b></p>
                            <p>Прогноз на p періодів уперед розраховується за формулою:</p>
                            <p>Ŷt+p = (Lt + p * Tt) * St-s+p</p>
                            <p>де:</p>
                            <p>Ŷt+p — прогноз за методом Хольта-Вінтерса на p періодів уперед;</p>
                            <p>Lt — експоненційно згладжена величина за останній період;</p>
                            <p>p — кількість періодів уперед, на які робиться прогноз;</p>
                            <p>Tt — тренд за останній період;</p>
                            <p>St-s+p — коефіцієнт сезонності для цього ж періоду у попередньому сезоні.</p>
                            <div>
                                Ŷt+p (Прогноз за методом Хольта-Вінтерса) = (Lt (експоненційно згладжена величина за останній період) + p (кількість періодів уперед) * Tt (тренд за останній період)) * St-s+p (коефіцієнт сезонності для цього ж періоду у попередньому сезоні).
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>