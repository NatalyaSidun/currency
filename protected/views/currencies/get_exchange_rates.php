<?php
$this->title = "Архив курса";
?>
<div class="row">
    <div class="col-md-9">
        <button type="button"  data-toggle="modal" data-target="#allForecasts"   class="btn btn-info">Подивитись дані у вигляді таблиці</button>
        <br>
        <br>
    </div>
</div>
<div class="chart_container" style="width:100%; height:400px;"></div>

<div class="modal fade" id="allForecasts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Курс валют для обраної валютної пари <?php echo $curentCureency->title;?> </h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Курс</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($exchangeRates as $item){?>
                        <tr>
                            <td><?php echo $item->date;?></td>
                            <td><?php echo "за 1$ ". $item->value;?> <?php echo $curentCureency->valuta?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
