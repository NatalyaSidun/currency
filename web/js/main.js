myGeneric = [];

myGeneric.flag = true;

//check form fields
myGeneric.checkFields = function(elem) {
    $(".errors").remove(); //hide erorrs
    myGeneric.flag = true;
    var form = elem.parents("form");
    jQuery.each($(form).find('input[type="text"], input[type="password"], textarea'), function(i, val) {
        var attrType = $(this).attr("data-type");
        var val = $(this).val();
        var flag = true;
        switch (attrType) {
            case "text":
                if (val.length == 0)
                    flag = false;
                break

            case "pass":
                if (val.length == 0)
                    flag = false;
                break

            case "email":
                flag = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i.test(val);
                break
            case "number":
                flag = /\-?\d+(\.\d{0,})?$/i.test(val);
                break
        }
        if (!flag) {
            myGeneric.outputErrors(attrType, $(this));
            myGeneric.flag = false;
        }
        ;
    });
}

//show errors
myGeneric.outputErrors = function(attrType, element) {
    errorsArray = {
        "text": "Поле повинно бути заповнено",
        "email": "Неправильний формат",
        "pass": "Поле повинно бути заповнено",
        "number": "Неравильний формат"
    };
    $(element).after('<div class="errors">' + errorsArray[attrType] + '</div>');
}

myGeneric.login = function() {
    $('.btnLogin').on("click", function() {
        myGeneric.checkFields($(this));
        if (!myGeneric.flag) {
            return false;
        } else {

            var form = $(this).parents("form");
            $.getJSON("/ajax/login", {"login": $(form).find('[name="login"]').val(), "pass": $(form).find('[name="pass"]').val()}, function(response) {
                $(".alreadyExist").remove();
                if (response == "Неправильний логін або пароль") {
                    $(form).prepend("<p class='alreadyExist'>" + response + "</p>");
                    $(form).find('[name="pass"]').val('');
                } else {
                    window.location = "/currencies/change-currency";
                }
            });
            return false;
        }
        return false;
    });
}

myGeneric.logout = function() {
    $('.btnLogout').on("click", function() {
        window.location = "/index.php";
    });
}

myGeneric.getRates = function() {
    if($("div").is(".chart_container")){
        $.ajax({
            url: "/ajax/get-exchange-rates",
            dataType: 'json'}).
        success(function(response) {
            console.log(response);
            $('.chart_container').highcharts({
                chart: {
                    zoomType: 'x'
                },
                title: {
                    text: 'Коливання валютної пари '+ response.currency.title
                },
                subtitle: {
                    text: document.ontouchstart === undefined ?
                        'Натисніть і перетягніть курсор в кінець обраної ділянким, щоб збільшити' :
                        'Pinch the chart to zoom in'
                },
                xAxis: {
                    type: 'datetime',
                    // This is from the Highcharts Stock - Stock license required
                    ordinal: true,
                    labels: {
                        // Format the date
                        formatter: function() {
                            return Highcharts.dateFormat('%Y-%m-%d', this.value);
                        }
                    },
                    tickPositioner: function() {
                        return response.dates.map(function(date) {
                            return Date.parse(date);
                        });
                    }
                },
                yAxis: {
                    title: {
                        text: 'Курс Валюты, '+ response.currency.valuta
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                            ]
                        },
                        marker: {
                            radius: 2
                        },
                        lineWidth: 1,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        threshold: null
                    }
                },

                series: [{
                    type: 'area',
                    data: response.data
                }]
            });
        });
    }
}

myGeneric.forecastsHolt = function() {
    if($("div").is("#chart_forecast_holt")){
        $.getJSON("/ajax/get-forecasts", {}, function(response) {

                var dataFirst = [];
                var dataSecond = [];
                var dataThird = [];
                var dataFourth = [];
                var dataFifth = [];
                var dataSix = [];
                var dataSeven = [];
                var dataEight = [];
                var dataNine = [];
                for(var i= 0; i<response["dataFirst"].length; i++){
                    dataFirst[i] = response["dataFirst"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataSecond"].length; i++){
                    dataSecond[i] = response["dataSecond"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataThird"].length; i++){
                    dataThird[i] = response["dataThird"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataFourth"].length; i++){
                    dataFourth[i] = response["dataFourth"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataFifth"].length; i++){
                    dataFifth[i] = response["dataFifth"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataSix"].length; i++){
                    dataSix[i] = response["dataSix"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataSeven"].length; i++){
                    dataSeven[i] = response["dataSeven"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataEight"].length; i++){
                    dataEight[i] = response["dataEight"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataNine"].length; i++){
                    dataNine[i] = response["dataNine"][i]["yt_1"];
                }


                $('#chart_forecast_holt').highcharts({
                    title: {
                        text: 'Архив прогнозов валютной пары '+response["currency"]["title"],
                        x: -20 //center
                    },
                    subtitle: {
                        text: 'По методу Хольта и Брауна',
                        x: -20
                    },
                    xAxis: {
                        type: 'datetime',
                        minRange: 14 * 24 * 3600000 // fourteen days
                    },
                    yAxis: {
                        title: {
                            text: 'Значение курса'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        valueSuffix: ' '+response["currency"]["valuta"]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [{
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.1',
                        data: dataFirst
                    }, {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.2',
                        data: dataSecond
                    },{
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.3',
                        data: dataThird
                    },{
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.4',
                        data: dataFourth
                    }, {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.5',
                        data: dataFifth
                    },
                    {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.6',
                        data: dataSix
                    },
                    {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.7',
                        data: dataSeven
                    },
                    {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.8',
                        data: dataEight
                    },
                    {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.9',
                        data: dataNine
                    }
                    ]
                });
            });
    }
}

myGeneric.forecastsMedium = function() {
    if($("div").is("#chart_forecast_medium")){
        $.getJSON("/ajax/get-forecasts-medium", {}, function(response) {

            var dataFirst = [];
            var dataSecond = [];
            var dataThird = [];
            var dataFourth = [];
            var dataFifth = [];
            var dataSix = [];
            var dataSeven = [];
            var dataEight = [];
            var dataNine = [];
            for(var i= 0; i<response["dataFirst"].length; i++){
                dataFirst[i] = response["dataFirst"][i]["yt_1"];
            }
            for(var i= 0; i<response["dataSecond"].length; i++){
                dataSecond[i] = response["dataSecond"][i]["yt_1"];
            }
            for(var i= 0; i<response["dataThird"].length; i++){
                dataThird[i] = response["dataThird"][i]["yt_1"];
            }
            for(var i= 0; i<response["dataFourth"].length; i++){
                dataFourth[i] = response["dataFourth"][i]["yt_1"];
            }
            for(var i= 0; i<response["dataFifth"].length; i++){
                dataFifth[i] = response["dataFifth"][i]["yt_1"];
            }
            for(var i= 0; i<response["dataSix"].length; i++){
                dataSix[i] = response["dataSix"][i]["yt_1"];
            }
            for(var i= 0; i<response["dataSeven"].length; i++){
                dataSeven[i] = response["dataSeven"][i]["yt_1"];
            }
            for(var i= 0; i<response["dataEight"].length; i++){
                dataEight[i] = response["dataEight"][i]["yt_1"];
            }
            for(var i= 0; i<response["dataNine"].length; i++){
                dataNine[i] = response["dataNine"][i]["yt_1"];
            }


            $('#chart_forecast_medium').highcharts({
                title: {
                    text: 'Архив прогнозов валютной пары '+response["currency"]["title"],
                    x: -20 //center
                },
                subtitle: {
                    text: 'По методу скользящего среднего',
                    x: -20
                },
                xAxis: {
                    type: 'datetime',
                    minRange: 14 * 24 * 3600000 // fourteen days
                },
                yAxis: {
                    title: {
                        text: 'Значение курса'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: ' '+response["currency"]["valuta"]
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2015, 0, 2),
                    name: 'k=0.1',
                    data: dataFirst
                }, {
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2015, 0, 2),
                    name: 'k=0.2',
                    data: dataSecond
                },{
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2015, 0, 2),
                    name: 'k=0.3',
                    data: dataThird
                },{
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2015, 0, 2),
                    name: 'k=0.4',
                    data: dataFourth
                }, {
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2015, 0, 2),
                    name: 'k=0.5',
                    data: dataFifth
                },
                    {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.6',
                        data: dataSix
                    },
                    {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.7',
                        data: dataSeven
                    },
                    {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.8',
                        data: dataEight
                    },
                    {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.9',
                        data: dataNine
                    }
                ]
            });
        });
    }
}

myGeneric.forecastsVinters = function() {
    if($("div").is("#chart_forecast_vinters")){
        $.getJSON("/ajax/get-forecasts-vinters", {}, function(response) {

                var dataFirst = [];
                var dataSecond = [];
                var dataThird = [];
                var dataFourth = [];
                var dataFifth = [];
                var dataSix = [];
                var dataSeven = [];
                var dataEight = [];
                var dataNine = [];
                var dataTen = [];
                for(var i= 0; i<response["dataFirst"].length; i++){
                    dataFirst[i] = response["dataFirst"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataSecond"].length; i++){
                    dataSecond[i] = response["dataSecond"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataThird"].length; i++){
                    dataThird[i] = response["dataThird"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataFourth"].length; i++){
                    dataFourth[i] = response["dataFourth"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataFifth"].length; i++){
                    dataFifth[i] = response["dataFifth"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataSix"].length; i++){
                    dataSix[i] = response["dataSix"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataSeven"].length; i++){
                    dataSeven[i] = response["dataSeven"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataEight"].length; i++){
                    dataEight[i] = response["dataEight"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataNine"].length; i++){
                    dataNine[i] = response["dataNine"][i]["yt_1"];
                }
                for(var i= 0; i<response["dataTen"].length; i++){
                    dataTen[i] = response["dataTen"][i]["yt_1"];
                }


                $('#chart_forecast_vinters').highcharts({
                    title: {
                        text: 'Архив прогнозов валютной пары '+response["currency"]["title"],
                        x: -20 //center
                    },
                    subtitle: {
                        text: 'По методу Винтерса',
                        x: -20
                    },
                    xAxis: {
                        type: 'datetime',
                        minRange: 14 * 24 * 3600000 // fourteen days
                    },
                    yAxis: {
                        title: {
                            text: 'Значение курса'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        valueSuffix: ' '+response["currency"]["valuta"]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [{
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.1, q=0.1',
                        data: dataFirst
                    }, {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.1, q=0.7',
                        data: dataSecond
                    },{
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.3, q=0.3',
                        data: dataThird
                    },{
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.3, q=0.9',
                        data: dataFourth
                    }, {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.5, q=0.1',
                        data: dataFifth
                    },
                    {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.5, q=0.9',
                        data: dataSix
                    },
                    {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.7, q=0.3',
                        data: dataSeven
                    },
                    {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.7, q=0.7',
                        data: dataEight
                    },
                    {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.9, q=0.1',
                        data: dataNine
                    },
                     {
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2015, 0, 2),
                        name: 'k=0.9, q=0.9',
                        data: dataTen
                    }
                    ]
                });
            });
    }
}

myGeneric.tableChart = function(date) {
    if($("div").is("#k-chart")){
        $.getJSON("/ajax/get-forecast-for-date", {"date": date}, function(response) {

                var dataK = [];
                var dataVal = [];
                for(var i= 0; i<response["data"].length; i++){
                    dataVal[i] = response["data"][i]["yt_1"];
                    dataK[i] = response["data"][i]["k"];
//                    dataSecond[i] = response["dataSecond"][i]["value"];
                }

                $('#k-chart').highcharts({
                    title: {
                        text: 'Зависимость курса от коэффициента сглаживания (k)' ,
                        x: -20 //center
                    },
                    subtitle: {
                        text: 'для валютной пары ' + response["currency"]["title"],
                        x: -20
                    },
                    xAxis: {
                        title: {
                            text: 'Коэффициент сглаживания (k)'
                        },
                        categories: dataK
                    },
                    yAxis: {
                        title: {
                            text: 'Значение курса, '+response["currency"]["valuta"]
                        },
                        plotLines: [{
                            value: 1,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        valueSuffix: ' '+response["currency"]["valuta"]
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        data: dataVal
                    }]
                });
            });
    }
}

myGeneric.tableChartMedium = function(date) {
    if($("div").is("#medium-chart")){
        $.getJSON("/ajax/get-forecast-medium-for-date", {"date": date}, function(response) {

            var dataK = [];
            var dataVal = [];
            for(var i= 0; i<response["data"].length; i++){
                dataVal[i] = response["data"][i]["yt_1"];
                dataK[i] = response["data"][i]["a"];
//                    dataSecond[i] = response["dataSecond"][i]["value"];
            }

            $('#medium-chart').highcharts({
                title: {
                    text: 'Зависимость курса от постоянной сглаживания (a)' ,
                    x: -20 //center
                },
                subtitle: {
                    text: 'для валютной пары ' + response["currency"]["title"],
                    x: -20
                },
                xAxis: {
                    title: {
                        text: 'Постоянная сглаживания (a)'
                    },
                    categories: dataK
                },
                yAxis: {
                    title: {
                        text: 'Значение курса, '+response["currency"]["valuta"]
                    },
                    plotLines: [{
                        value: 1,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: ' '+response["currency"]["valuta"]
                },
                legend: {
                    enabled: false
                },
                series: [{
                    data: dataVal
                }]
            });
        });
    }
}

myGeneric.tableChartVinters = function(date) {
    if($("div").is("#kq-chart")){
        $.getJSON("/ajax/get-forecast-vinters-for-date", {"date": date}, function(response) {

            var dataValQ1 = [];
            var dataValQ2 = [];
            var dataValQ3 = [];
            var dataValQ4 = [];
            var dataValQ5 = [];
            for(var i= 0; i<response["q1"].length; i++){
                dataValQ1[i] = response["q1"][i]["yt_1"];
            }
            for(var i= 0; i<response["q2"].length; i++){
                dataValQ2[i] = response["q2"][i]["yt_1"];
            }
            for(var i= 0; i<response["q3"].length; i++){
                dataValQ3[i] = response["q3"][i]["yt_1"];
            }
            for(var i= 0; i<response["q4"].length; i++){
                dataValQ4[i] = response["q4"][i]["yt_1"];
            }
            for(var i= 0; i<response["q5"].length; i++){
                dataValQ5[i] = response["q5"][i]["yt_1"];
            }

            $('#kq-chart').highcharts({
                title: {
                    text: 'Зависимость курса от коэффициента сглаживания (k)' ,
                    x: -20 //center
                },
                subtitle: {
                    text: 'для валютной пары ' + response["currency"]["title"],
                    x: -20
                },
                xAxis: {
                    title: {
                        text: 'Коэффициент сглаживания (k)'
                    },
                    categories: [0.1, 0.3, 0.5, 0.7, 0.9]
                },
                yAxis: {
                    title: {
                        text: 'Значение курса, ' + response["currency"]["valuta"]
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: ' '+response["currency"]["valuta"]
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [
                {
                    name: 'при q = 0.1',
                    data: dataValQ1
                },
                {
                    name: 'при q = 0.3',
                    data: dataValQ2
                },
                {
                    name: 'при q = 0.5',
                    data: dataValQ3
                },
                {
                    name: 'при q = 0.7',
                    data: dataValQ4
                },
                {
                    name: 'при q = 0.9',
                    data: dataValQ5
                }]
            });
        });
    }
    if($("div").is("#qk-chart")){
        $.getJSON("/ajax/get-forecast-vinters-for-date", {"date": date}, function(response) {

            var dataValK1 = [];
            var dataValK2 = [];
            var dataValK3 = [];
            var dataValK4 = [];
            var dataValK5 = [];
            for(var i= 0; i<response["k1"].length; i++){
                dataValK1[i] = response["k1"][i]["yt_1"];
            }
            for(var i= 0; i<response["k2"].length; i++){
                dataValK2[i] = response["k2"][i]["yt_1"];
            }
            for(var i= 0; i<response["k3"].length; i++){
                dataValK3[i] = response["k3"][i]["yt_1"];
            }
            for(var i= 0; i<response["k4"].length; i++){
                dataValK4[i] = response["k4"][i]["yt_1"];
            }
            for(var i= 0; i<response["k5"].length; i++){
                dataValK5[i] = response["k5"][i]["yt_1"];
            }

            $('#qk-chart').highcharts({
                title: {
                    text: 'Зависимость курса от коэффициента сглаживания сезонности (q)' ,
                    x: -20 //center
                },
                subtitle: {
                    text: 'для валютной пары ' + response["currency"]["title"],
                    x: -20
                },
                xAxis: {
                    title: {
                        text: 'Коэффициент сглаживания сезонности (q)'
                    },
                    categories: [0.1, 0.3, 0.5, 0.7, 0.9]
                },
                yAxis: {
                    title: {
                        text: 'Значение курса ' + response["currency"]["valuta"]
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: ' '+response["currency"]["valuta"]
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [
                    {
                        name: 'при k = 0.1',
                        data: dataValK1
                    },
                    {
                        name: 'при k = 0.3',
                        data: dataValK2
                    },
                    {
                        name: 'при k = 0.5',
                        data: dataValK3
                    },
                    {
                        name: 'при k = 0.7',
                        data: dataValK4
                    },
                    {
                        name: 'при k = 0.9',
                        data: dataValK5
                    }]
            });
        });
    }
}
myGeneric.oprimalVinters = function(){
    if($("div").is("#ekq-chart")){
        $.getJSON("/ajax/optimal-vinters", {}, function(response) {
            var dataValK1 = [];
            var dataValK2 = [];
            var dataValK3 = [];
            var dataValK4 = [];
            var dataValK5 = [];
            for(var i= 0; i<response["valueQ1"].length; i++){
                dataValK1[i] = response["valueQ1"][i]["e"];
            }
            for(var i= 0; i<response["valueQ2"].length; i++){
                dataValK2[i] = response["valueQ2"][i]["e"];
            }
            for(var i= 0; i<response["valueQ3"].length; i++){
                dataValK3[i] = response["valueQ3"][i]["e"];
            }
            for(var i= 0; i<response["valueQ4"].length; i++){
                dataValK4[i] = response["valueQ4"][i]["e"];
            }
            for(var i= 0; i<response["valueQ5"].length; i++){
                dataValK5[i] = response["valueQ5"][i]["e"];
            }

            $('#ekq-chart').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Зависимость ошибки от коэффициентов <br/>  для Метода Винтерса'
                },
                xAxis: {
                    categories: ['k=0.1', 'k=0.3', 'k=0.5', 'k=0.7', 'k=0.9'],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Ошибка(e), %'
                    }
                },
                tooltip: {
                    valueSuffix: ' %'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'q=0.1',
                    data: dataValK1
                }, {
                    name: 'q=0.3',
                    data: dataValK2
                }, {
                    name: 'q=0.5',
                    data: dataValK3
                },
                {
                    name: 'q=0.7',
                    data: dataValK4
                },
                {
                    name: 'q=0.9',
                    data: dataValK5
                }]
            });
        });
    }
}

myGeneric.oprimalHolt = function(){
    if($("div").is("#ek-chart")){
        $.getJSON("/ajax/optimal-holt", {}, function(response) {
            var dataValK1 = [];
            for(var i= 0; i<response["valueQ1"].length; i++){
                dataValK1[i] = response["valueQ1"][i]["e"];
            }

            $('#ek-chart').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Зависимость ошибки от коэффициентов <br/> для Метода Хольта'
                },
                xAxis: {
                    categories: ['k=0.1', 'k=0.2', 'k=0.3', 'k=0.4', 'k=0.5', 'k=0.6', 'k=0.7', 'k=0.8', 'k=0.9'],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Ошибка(e), %'
                    }
                },
                tooltip: {
                    valueSuffix: ' %'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    data: dataValK1
                }]
            });
        });
    }
}

myGeneric.oprimalMedium = function(){
    if($("div").is("#ek-chart-medium")){
        $.getJSON("/ajax/optimal-medium", {}, function(response) {
            var dataValK1 = [];
            for(var i= 0; i<response["valueQ1"].length; i++){
                dataValK1[i] = response["valueQ1"][i]["e"];
            }

            $('#ek-chart-medium').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Зависимость ошибки от коэффициентов <br/> для Метода скользящего среднего'
                },
                xAxis: {
                    categories: ['a=0.1', 'a=0.2', 'a=0.3', 'a=0.4', 'a=0.5', 'a=0.6', 'a=0.7', 'a=0.8', 'a=0.9'],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Ошибка(e), %'
                    }
                },
                tooltip: {
                    valueSuffix: ' %'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    data: dataValK1
                }]
            });
        });
    }
}

myGeneric.setCurrency = function(){
    $( "#changeCurrency" ).change(function() {
        $(".selectedCur span").html($("#changeCurrency :selected").html());
        $.getJSON("/ajax/change-currency", {"id_currency": $(this).val()}, function(response) {
            $(".selectedCur").addClass("active");
        });
    });
};

myGeneric.kcheckbox = function(){

    var block = $('.cards-block');
    // var cards = block.children(".active");
    var defaultClasses = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    var curState = 'one';

    $(document).on('change', 'input[type="checkbox"]', function(e){
        if($("div").is("#datepicker-medium")){
            var i=0;
            var inner = "";
            $("input:checked").each(function(){
                var index = $(this).attr("data-card");
                $(".cards-block").html("");
                inner = inner+"<div class='card'>"+$('.card'+index).html()+"</div>";
                $(".cards-block").html(inner);
                i++;
            })
            getMagic(i);
        }
    });

    $(document).on('change', 'input[type="checkbox"]', function(e){
        if($("div").is("#datepicker-holt")){
            var i=0;
            var inner = "";
            $("input:checked").each(function(){
                var index = $(this).attr("data-card");
                $(".cards-block").html("");
                inner = inner+"<div class='card'>"+$('.card'+index).html()+"</div>";
                $(".cards-block").html(inner);
                i++;
            })
            getMagic(i);
        }
    });


    function getMagic(count) {
        clearOpacity();
        block.removeClass(curState);
        block.addClass(defaultClasses[count-1]);
        curState = defaultClasses[count-1];
        methods[count]();
    }
    function clearOpacity() {
        var cards = block.children();
        cards.each(function(){
            $(this).css('opacity', 0);
        });
    }
    var methods = [];
    methods[0] = function() {
//        $(".cards-block").html("");
    };
    methods[1] = function() {
        var cards = block.children();
        cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
            cards.eq(0).css('opacity', 1);
        });
    };
    methods[2] = function() {
        var cards = block.children();
        cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
            cards.eq(0).css('opacity', 1);
            cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(1).css('opacity', 1);
            });
        });
    };
    methods[3] = function() {
        var cards = block.children();
        cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
            cards.eq(0).css('opacity', 1);
            cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(1).css('opacity', 1);
                cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(2).css('opacity', 1);
                });
            });
        });
    };
    methods[4] = function() {
        var cards = block.children();
        cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
            cards.eq(0).css('opacity', 1);
            cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(1).css('opacity', 1);
                cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(2).css('opacity', 1);
                    cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(3).css('opacity', 1)
                    });
                });
            });
        });
    }
    methods[5] = function() {
        var cards = block.children();
        cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
            cards.eq(0).css('opacity', 1);
            cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(1).css('opacity', 1);
                cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(2).css('opacity', 1);
                    cards.eq(3).animo({animation: "fadeInLeft", duration: 0.2}, function() {
                        cards.eq(3).css('opacity', 1);
                        cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(4).css('opacity', 1)
                        });
                    });
                });
            });
        });
    }
    methods[6] = function() {
        var cards = block.children();
        cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
            cards.eq(0).css('opacity', 1);
            cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(1).css('opacity', 1);
                cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(2).css('opacity', 1);
                    cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(3).css('opacity', 1);
                        cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(4).css('opacity', 1);
                            cards.eq(5).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(5).css('opacity', 1)
                            });
                        });
                    });
                });
            });
        });
    }
    methods[7] = function() {
        var cards = block.children();
        cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
            cards.eq(0).css('opacity', 1);
            cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(1).css('opacity', 1);
                cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(2).css('opacity', 1);
                    cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(3).css('opacity', 1);
                        cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(4).css('opacity', 1);
                            cards.eq(5).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(5).css('opacity', 1);
                                cards.eq(6).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                    cards.eq(6).css('opacity', 1)
                                });
                            });
                        });
                    });
                });
            });
        });
    }
    methods[8] = function() {
        var cards = block.children();
        cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
            cards.eq(0).css('opacity', 1);
            cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(1).css('opacity', 1);
                cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(2).css('opacity', 1);
                    cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(3).css('opacity', 1);
                        cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(4).css('opacity', 1);
                            cards.eq(5).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(5).css('opacity', 1);
                                cards.eq(6).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                    cards.eq(6).css('opacity', 1);
                                    cards.eq(7).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                        cards.eq(7).css('opacity', 1)
                                    });
                                });
                            });
                        });
                    });
                });
            });
        });
    }

    methods[9] = function() {
        var cards = block.children();
        cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
            cards.eq(0).css('opacity', 1);
            cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(1).css('opacity', 1);
                cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(2).css('opacity', 1);
                    cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(3).css('opacity', 1);
                        cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(4).css('opacity', 1);
                            cards.eq(5).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(5).css('opacity', 1);
                                cards.eq(6).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                    cards.eq(6).css('opacity', 1);
                                    cards.eq(7).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                        cards.eq(7).css('opacity', 1);
                                        cards.eq(8).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                            cards.eq(8).css('opacity', 1)
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            });
        });
    }
};

myGeneric.kqcheckbox = function(){
    var block =  $(".cards-vinters")

    $(document).on('change', 'input[type="checkbox"]', function(e){
        if($("div").is("#datepicker-vinters")){
            var i=0;
            var j=0;
            var arrK =[];
            var arrQ =[];
            $("input:checked").each(function(){
                if($(this).is('[data-card-q]')){
                    arrQ[i] = $(this).attr('data-card-q');
                    i = i+1;
                }else{
                    arrK[j] = $(this).attr('data-card-k');
                    j = j+1;
                }
            });
            var inner = "";
            for(i=0; i<arrK.length; i++){
                for(j=0; j<arrQ.length; j++){
                    inner = inner+"<div class='little-card'>"+$('.card'+arrK[i]+arrQ[j]).html()+"</div>";
                }
            }
            $(".cards-vinters").html(inner);
            getMagic(arrK.length * arrQ.length);
        }
    });

    function clearOpacity() {
        var cards = block.children();
        cards.each(function(){
            $(this).css('opacity', 0);
        });
    };
    function getMagic(count) {
        clearOpacity();
        methods[count]();
    }
        var methods = [];
        methods[0] = function() {
//        $(".cards-block").html("");
        };
        methods[1] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
            });
        };
        methods[2] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
                cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(1).css('opacity', 1);
                });
            });
        };
        methods[3] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
                cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(1).css('opacity', 1);
                    cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(2).css('opacity', 1);
                    });
                });
            });
        };
        methods[4] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
                cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(1).css('opacity', 1);
                    cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(2).css('opacity', 1);
                        cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(3).css('opacity', 1)
                        });
                    });
                });
            });
        }
        methods[5] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
                cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(1).css('opacity', 1);
                    cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(2).css('opacity', 1);
                        cards.eq(3).animo({animation: "fadeInLeft", duration: 0.2}, function() {
                            cards.eq(3).css('opacity', 1);
                            cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(4).css('opacity', 1)
                            });
                        });
                    });
                });
            });
        }
        methods[6] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
                cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(1).css('opacity', 1);
                    cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(2).css('opacity', 1);
                        cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(3).css('opacity', 1);
                            cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(4).css('opacity', 1);
                                cards.eq(5).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                    cards.eq(5).css('opacity', 1)
                                });
                            });
                        });
                    });
                });
            });
        }
        methods[8] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
                cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(1).css('opacity', 1);
                    cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(2).css('opacity', 1);
                        cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(3).css('opacity', 1);
                            cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(4).css('opacity', 1);
                                cards.eq(5).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                    cards.eq(5).css('opacity', 1);
                                    cards.eq(6).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                        cards.eq(6).css('opacity', 1);
                                        cards.eq(7).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                            cards.eq(7).css('opacity', 1)
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            });
        }
        methods[9] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
                cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(1).css('opacity', 1);
                    cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(2).css('opacity', 1);
                        cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(3).css('opacity', 1);
                            cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(4).css('opacity', 1);
                                cards.eq(5).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                    cards.eq(5).css('opacity', 1);
                                    cards.eq(6).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                        cards.eq(6).css('opacity', 1);
                                        cards.eq(7).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                            cards.eq(7).css('opacity', 1);
                                            cards.eq(8).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                cards.eq(8).css('opacity', 1)
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            });
        }
        methods[10] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
                cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(1).css('opacity', 1);
                    cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(2).css('opacity', 1);
                        cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(3).css('opacity', 1);
                            cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(4).css('opacity', 1);
                                cards.eq(5).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                    cards.eq(5).css('opacity', 1);
                                    cards.eq(6).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                        cards.eq(6).css('opacity', 1);
                                        cards.eq(7).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                            cards.eq(7).css('opacity', 1);
                                            cards.eq(8).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                cards.eq(8).css('opacity', 1);
                                                cards.eq(9).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                    cards.eq(9).css('opacity', 1)
                                                });
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            });
        }
        methods[12] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
                cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(1).css('opacity', 1);
                    cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(2).css('opacity', 1);
                        cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(3).css('opacity', 1);
                            cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(4).css('opacity', 1);
                                cards.eq(5).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                    cards.eq(5).css('opacity', 1);
                                    cards.eq(6).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                        cards.eq(6).css('opacity', 1);
                                        cards.eq(7).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                            cards.eq(7).css('opacity', 1);
                                            cards.eq(8).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                cards.eq(8).css('opacity', 1);
                                                cards.eq(9).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                    cards.eq(9).css('opacity', 1);
                                                    cards.eq(10).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                        cards.eq(10).css('opacity', 1);
                                                        cards.eq(11).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                            cards.eq(11).css('opacity', 1);
                                                        });
                                                    });
                                                });
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            });
        }
        methods[15] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
                cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(1).css('opacity', 1);
                    cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(2).css('opacity', 1);
                        cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(3).css('opacity', 1);
                            cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(4).css('opacity', 1);
                                cards.eq(5).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                    cards.eq(5).css('opacity', 1);
                                    cards.eq(6).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                        cards.eq(6).css('opacity', 1);
                                        cards.eq(7).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                            cards.eq(7).css('opacity', 1);
                                            cards.eq(8).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                cards.eq(8).css('opacity', 1);
                                                cards.eq(9).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                    cards.eq(9).css('opacity', 1);
                                                    cards.eq(10).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                        cards.eq(10).css('opacity', 1);
                                                        cards.eq(11).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                            cards.eq(11).css('opacity', 1);
                                                            cards.eq(12).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                cards.eq(12).css('opacity', 1);
                                                                cards.eq(13).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                    cards.eq(13).css('opacity', 1);
                                                                    cards.eq(14).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                        cards.eq(14).css('opacity', 1);
                                                                    });
                                                                });
                                                            });
                                                        });
                                                    });
                                                });
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            });
        }
        methods[16] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
                cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(1).css('opacity', 1);
                    cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(2).css('opacity', 1);
                        cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(3).css('opacity', 1);
                            cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(4).css('opacity', 1);
                                cards.eq(5).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                    cards.eq(5).css('opacity', 1);
                                    cards.eq(6).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                        cards.eq(6).css('opacity', 1);
                                        cards.eq(7).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                            cards.eq(7).css('opacity', 1);
                                            cards.eq(8).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                cards.eq(8).css('opacity', 1);
                                                cards.eq(9).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                    cards.eq(9).css('opacity', 1);
                                                    cards.eq(10).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                        cards.eq(10).css('opacity', 1);
                                                        cards.eq(11).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                            cards.eq(11).css('opacity', 1);
                                                            cards.eq(12).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                cards.eq(12).css('opacity', 1);
                                                                cards.eq(13).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                    cards.eq(13).css('opacity', 1);
                                                                    cards.eq(14).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                        cards.eq(14).css('opacity', 1);
                                                                        cards.eq(15).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                            cards.eq(15).css('opacity', 1);
                                                                        });
                                                                    });
                                                                });
                                                            });
                                                        });
                                                    });
                                                });
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            });
        }
        methods[20] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
                cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(1).css('opacity', 1);
                    cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(2).css('opacity', 1);
                        cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(3).css('opacity', 1);
                            cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(4).css('opacity', 1);
                                cards.eq(5).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                    cards.eq(5).css('opacity', 1);
                                    cards.eq(6).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                        cards.eq(6).css('opacity', 1);
                                        cards.eq(7).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                            cards.eq(7).css('opacity', 1);
                                            cards.eq(8).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                cards.eq(8).css('opacity', 1);
                                                cards.eq(9).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                    cards.eq(9).css('opacity', 1);
                                                    cards.eq(10).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                        cards.eq(10).css('opacity', 1);
                                                        cards.eq(11).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                            cards.eq(11).css('opacity', 1);
                                                            cards.eq(12).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                cards.eq(12).css('opacity', 1);
                                                                cards.eq(13).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                    cards.eq(13).css('opacity', 1);
                                                                    cards.eq(14).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                        cards.eq(14).css('opacity', 1);
                                                                        cards.eq(15).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                            cards.eq(15).css('opacity', 1);
                                                                            cards.eq(16).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                                cards.eq(16).css('opacity', 1);
                                                                                cards.eq(17).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                                    cards.eq(17).css('opacity', 1);
                                                                                    cards.eq(18).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                                        cards.eq(18).css('opacity', 1);
                                                                                        cards.eq(19).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                                            cards.eq(19).css('opacity', 1);
                                                                                        });
                                                                                    });
                                                                                });
                                                                            });
                                                                        });
                                                                    });
                                                                });
                                                            });
                                                        });
                                                    });
                                                });
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            });
        }
        methods[25] = function() {
            var cards = block.children();
            cards.eq(0).animo({animation: "fadeInLeft", duration:0.2}, function() {
                cards.eq(0).css('opacity', 1);
                cards.eq(1).animo({animation: "fadeInLeft", duration:0.2}, function() {
                    cards.eq(1).css('opacity', 1);
                    cards.eq(2).animo({animation: "fadeInLeft", duration:0.2}, function() {
                        cards.eq(2).css('opacity', 1);
                        cards.eq(3).animo({animation: "fadeInLeft", duration:0.2}, function() {
                            cards.eq(3).css('opacity', 1);
                            cards.eq(4).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                cards.eq(4).css('opacity', 1);
                                cards.eq(5).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                    cards.eq(5).css('opacity', 1);
                                    cards.eq(6).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                        cards.eq(6).css('opacity', 1);
                                        cards.eq(7).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                            cards.eq(7).css('opacity', 1);
                                            cards.eq(8).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                cards.eq(8).css('opacity', 1);
                                                cards.eq(9).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                    cards.eq(9).css('opacity', 1);
                                                    cards.eq(10).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                        cards.eq(10).css('opacity', 1);
                                                        cards.eq(11).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                            cards.eq(11).css('opacity', 1);
                                                            cards.eq(12).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                cards.eq(12).css('opacity', 1);
                                                                cards.eq(13).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                    cards.eq(13).css('opacity', 1);
                                                                    cards.eq(14).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                        cards.eq(14).css('opacity', 1);
                                                                        cards.eq(15).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                            cards.eq(15).css('opacity', 1);
                                                                            cards.eq(16).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                                cards.eq(16).css('opacity', 1);
                                                                                cards.eq(17).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                                    cards.eq(17).css('opacity', 1);
                                                                                    cards.eq(18).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                                        cards.eq(18).css('opacity', 1);
                                                                                        cards.eq(19).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                                            cards.eq(19).css('opacity', 1);
                                                                                            cards.eq(20).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                                                cards.eq(20).css('opacity', 1);
                                                                                                cards.eq(21).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                                                    cards.eq(21).css('opacity', 1);
                                                                                                    cards.eq(22).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                                                        cards.eq(22).css('opacity', 1);
                                                                                                        cards.eq(23).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                                                            cards.eq(23).css('opacity', 1);
                                                                                                            cards.eq(24).animo({animation: "fadeInLeft", duration:0.2}, function() {
                                                                                                                cards.eq(24).css('opacity', 1)
                                                                                                            });
                                                                                                        });
                                                                                                    });
                                                                                                });
                                                                                            });
                                                                                        });
                                                                                    });
                                                                                });
                                                                            });
                                                                        });
                                                                    });
                                                                });
                                                            });
                                                        });
                                                    });
                                                });
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            });
        }
};

myGeneric.changeDay = function(){
   $("#datepicker-holt td.day").click(function(e){
       var day = $(this).html();
       var month = $(".picker-switch").html();
       $(".cards-block").html("");
       $('input[type="checkbox"]').attr('checked', false);
       $('input[type="checkbox"]').styler();
       $(".jq-checkbox").removeClass("checked");
       $(".date span").html(day);
       $(".date small").html(month);
       $(".wrap-wait").show();
       $.getJSON("/ajax/change-day", {"day": day, "month": month}, function(response) {
           $(".cards-hidden").html("");
           $(".bodyInner").html("");
           $(".popups").html("");
           var innerCards = "";
           var bodyInner = "";
           var bodyIn = "";
           var popupInner = "";
           for(var i=0; i<response["valueForDay"].length; i++){
               innerCards = innerCards +
                   '<div class="card'+(i+1)+'">' +
                        '<span class="label label-success">k='+response["valueForDay"][i]["k"]+'</span>' +
                        '<div class="row">'+
                            '<div class="col-md-4"> Tренд: </div>'+
                            '<div class="col-md-8">'+response["valueForDay"][i]["trend"]+'</div>'+
                        '</div>'+
                        '<div class="row">'+
                            '<div class="col-md-4"> Завтра: </div>'+
                            '<div class="col-md-8">'+response["date_tomorrow"]+'</div>'+
                        '</div>'+
                        '<div class="row">'+
                            '<div class="col-md-4"> Прогноз: </div>'+
                            '<div class="col-md-8"> за 1$'+response["valueForDay"][i]["yt_1"]+' '+response["curentCureency"]["valuta"]+'</div>'+
                        '</div>'+
                        '<a class="btn btn-default" data-toggle="modal" data-target="#popup-calculation'+i+'" href="javascript:void(0)" title="Подробнее расчеты">'+
                            '<span class="p-t-5 p-b-5">'+
                                '<i class="fa fa-question"></i>'+
                            '</span>'+
                        '</a>'+
                   '</div>';


               popupInner = popupInner +
                   '<div class="modal fade" id="popup-calculation'+(i)+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+
                        '<div class="modal-dialog">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header">'+
                                   '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                   '<h4 class="modal-title" id="myModalLabel">Расчет прогноза на '+response["date_tomorrow"]+' по методу Хольта И Брауна с коэффициентом '+response["valueForDay"][i]["k"]+'</h4>'+
                                '</div>'+
                                '<div class="modal-body">'+
                                   '<img src="/img/holt1.gif"/><br>'+
                                   '<img src="/img/holt2.gif"/><br>'+
                                   '<img src="/img/holt3.gif"/><br>'+
                                   '<p>где α – постоянная сглаживания;</p>'+
                                   '<p>Yпрогн., t, Yпрогн., t–1 – прогнозные значения показателя в последующий и предыдущий момент времени; </p>'+
                                   '<p>Yt – табличное значение показателя в момент времени t; </p>'+
                                   '<p>Тt–1 – значение тренда на момент времени t–1, которое определяется из второго уравнения.</p>'+
                                   '<p>где β – постоянная сглаживания.</p>'+
                                   '<p class="t4"><b>Значения на '+response["valuesForDayBefore"][i]["date"] +' для k='+response["valuesForDayBefore"][i]["k"]+'</b></p>'+
                                   '<table class="table">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>Значение курса</th>'+
                                                '<th>Сглаженное значение</th>'+
                                                '<th>Значение тренда</th>'+
                                                '<th>Прогноз</th>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>'+
                                            '<tr>'+
                                                '<td>'+response["valuesForDayBefore"][i]["yt"]+' '+response["curentCureency"]["valuta"]+'</td>'+
                                                '<td>'+response["valuesForDayBefore"][i]["yt_prognoz"]+' '+response["curentCureency"]["valuta"]+'</td>'+
                                                '<td>'+response["valuesForDayBefore"][i]["trend"]+'</td>'+
                                                '<td>'+response["valuesForDayBefore"][i]["yt_1"]+' '+response["curentCureency"]["valuta"]+'</td>'+
                                            '</tr>'+
                                        '</tbody>'+
                                   '</table>'+
                                   '<p class="t3"><b>Рассмотрим подробнее</b></p>'+
                                   '<ul>'+
                                        '<li>'+
                                            '<p>Находим сглаженный ряд для прогнозного значения Y на момент времени t с использованием информации на момент времени t–1</p>'+
                                            '<p>Y<small>прогн.t</small> = k * (Y<small>прогн.t-1</small> + T<small>t-1</small>) + (1-k) * Y<small>t</small> = '+response["valuesForDayBefore"][i]["k"]+' * ('+response["valuesForDayBefore"][i]["yt_prognoz"]+' + '+response["valuesForDayBefore"][i]["trend"]+') + (1 - '+ response["valuesForDayBefore"][i]["k"]+') * '+response["valueForDay"][i]["yt"]+' = '+response["valueForDay"][i]["yt_prognoz"]+'</p>'+
                                        '</li>'+
                                        '<li>'+
                                            '<p>Находим значение тренда</p>'+
                                            '<p>T<small>t</small> = (1-k) * (Y<small>прогн.t</small> - Y<small>прогн.t-1</small>) + k * T<small>t-1</small> = (1 - '+response["valuesForDayBefore"][i]["k"]+') * ('+response["valueForDay"][i]["yt_prognoz"]+' - '+response["valuesForDayBefore"][i]["yt_prognoz"]+') + '+response["valuesForDayBefore"][i]["k"]+' * '+ response["valuesForDayBefore"][i]["trend"]+' = '+response["valueForDay"][i]["trend"]+'</p>'+
                                        '</li>'+
                                        '<li>'+
                                            '<p>Находим прогноз на '+response["date_tomorrow"]+'</p>'+
                                            '<p>Y<small>прогн.t+1</small> = Y<small>прогн.t+1</small> + p * T<small>t</small> = '+response["valueForDay"][i]["yt_prognoz"]+' + 1 * '+response["valueForDay"][i]["trend"]+' = '+response["valueForDay"][i]["yt_1"]+' '+response["curentCureency"]["valuta"]+' за 1$</p>'+
                                        '</li>'+
                                   '</ul>'+
                                '</div>'+
                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
           }
           $(".cards-hidden").html(innerCards);
           $(".bodyInner").html(bodyInner);

           $(".popups").html(popupInner);
           bodyIn = bodyIn +
               '<tr>'+
                   '<td>'+response["minValuesHolt"]["k"]+'</td>'+
                   '<td>'+response["minValuesHolt"]["yt_1"]+' '+response["curentCureency"]["valuta"]+'</td>'+
                   '<td>'+response["minValuesHolt"]["e"]+' %'+
               '</tr>';
           $(".bodyInn").html(bodyIn);
           $(".optDate").html(response["minValuesHolt"]["date"]);
           $(".optKoef").html(response["minValuesHolt"]["k"]);
           $(".optVal").html(response["minValuesHolt"]["yt"]+" "+response["curentCureency"]["valuta"]+" за 1$");
           $(".optDateTommorow").html(response["date_tomorrow"]+":</b> "+response["minValuesHolt"]["yt_1"]+" "+response["curentCureency"]["valuta"]+" за 1$");

           myGeneric.tableChart(response["valueForDay"][0]["date"]);
           $(".wrap-wait").hide();
       });
    });
};
myGeneric.changeDayMedium = function(){
    $("#datepicker-medium td.day").click(function(e){
        var day = $(this).html();
        var month = $(".picker-switch").html();
        $(".cards-block").html("");
        $('input[type="checkbox"]').attr('checked', false);
        $('input[type="checkbox"]').styler();
        $(".jq-checkbox").removeClass("checked");
        $(".date span").html(day);
        $(".date small").html(month);
        $(".wrap-wait").show();
        $.getJSON("/ajax/change-day-medium", {"day": day, "month": month}, function(response) {
            $(".cards-hidden").html("");
            $(".bodyInner").html("");
            $(".popups").html("");
            var innerCards = "";
            var bodyInner = "";
            var bodyIn = "";
            var popupInner = "";
            for(var i=0; i<response["valueForDay"].length; i++){
                innerCards = innerCards +
                    '<div class="card'+(i+1)+'">' +
                        '<span class="label label-success">a='+response["valueForDay"][i]["a"]+'</span>' +
                        '<div class="row">'+
                            '<div class="col-md-4"> Завтра: </div>'+
                            '<div class="col-md-8">'+response["date_tomorrow"]+'</div>'+
                        '</div>'+
                        '<div class="row">'+
                            '<div class="col-md-4"> Прогноз: </div>'+
                            '<div class="col-md-8"> за 1$ '+response["valueForDay"][i]["yt_1"]+' '+response["curentCureency"]["valuta"]+'</div>'+
                        '</div>'+
                        '<a class="btn btn-default" data-toggle="modal" data-target="#popup-calculation'+i+'" href="javascript:void(0)" title="Подробнее расчеты">'+
                            '<span class="p-t-5 p-b-5">'+
                                '<i class="fa fa-question"></i>'+
                            '</span>'+
                        '</a>'+
                    '</div>';

                bodyInner = bodyInner +
                    '<tr>'+
                        '<td>'+response["valueForDay"][i]["a"]+'</td>'+
                        '<td>'+response["valueForDay"][i]["yt_1"]+' '+response["curentCureency"]["valuta"]+'</td>'+
                    '</tr>';

                popupInner = popupInner +
                    '<div class="modal fade" id="popup-calculation'+(i)+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+
                        '<div class="modal-dialog">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header">'+
                                    '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                '<h4 class="modal-title" id="myModalLabel">Расчет прогноза на '+response["date_tomorrow"]+' по методу скользящего среднего с коэффициентом '+response["valueForDay"][i]["a"]+'</h4>'+
                                '</div>'+
                                '<div class="modal-body">'+
                                    '<p>Y<small>t+1</small>=a*Y<small>t</small>+(1-a)*^Y<small>t</small></p>'+
                                    '<p>где Yt+1– прогноз на следующий период времени</p>'+
                                    '<p>Yt – реальное значение в момент времени t </p>'+
                                    '<p>^Yt – прошлый прогноз на момент времени t </p>'+
                                    '<p>a – постоянная сглаживания (0<=a<=1) </p>'+
                                    '<p class="t4"><b>Значения на '+response["valuesForDayBefore"][i]["date"] +' для a='+response["valuesForDayBefore"][i]["a"]+'</b></p>'+
                                    '<table class="table">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>Значение курса</th>'+
                                                '<th>Прогноз</th>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>'+
                                            '<tr>'+
                                                '<td>'+response["valuesForDayBefore"][i]["yt"]+' '+response["curentCureency"]["valuta"]+'</td>'+
                                                '<td>'+response["valuesForDayBefore"][i]["yt_1"]+' '+response["curentCureency"]["valuta"]+'</td>'+
                                            '</tr>'+
                                        '</tbody>'+
                                    '</table>'+
                                    '<p class="t3"><b>Рассмотрим подробнее</b></p>'+
                                    '<p>Находим прогноз на '+response["date_tomorrow"]+'</p>'+
                                    '<p> Y<small>t+1</small>=a*Y<small>t</small>+(1-a)*^Y<small>t</small> = </p>'+
                                    ' = '+response["valueForDay"][i]["a"]+' * '+response["valueForDay"][i]["yt"]+' + (1-a) * '+response["valuesForDayBefore"][i]["yt_1"]+' = '+response["valueForDay"][i]["yt_1"]+' '+response["curentCureency"]["valuta"]+' за 1$</p>'+
                                '</div>'+
                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
            }
            $(".cards-hidden").html(innerCards);
            $(".bodyInner").html(bodyInner);
            $(".popups").html(popupInner);
            bodyIn = bodyIn +
                '<tr>'+
                    '<td>'+response["minValuesMedium"]["a"]+'</td>'+
                    '<td>'+response["minValuesMedium"]["yt_1"]+' '+response["curentCureency"]["valuta"]+'</td>'+
                    '<td>'+response["minValuesMedium"]["e"]+' %'+
                '</tr>';
            $(".bodyInn").html(bodyIn);
            $(".optDate").html(response["minValuesMedium"]["date"]);
            $(".optKoef").html(response["minValuesMedium"]["a"]);
            $(".optVal").html(response["minValuesMedium"]["yt"]+" "+response["curentCureency"]["valuta"]+" за 1$");
            $(".optDateTommorow").html(response["date_tomorrow"]+":</b> "+response["minValuesMedium"]["yt_1"]+" "+response["curentCureency"]["valuta"]+" за 1$");

            myGeneric.tableChartMedium(response["valueForDay"][0]["date"]);
            $(".wrap-wait").hide();
        });
    });
};

myGeneric.changeDayVinters = function(){
    $("#datepicker-vinters td.day").click(function(e){
        var day = $(this).html();
        var month = $(".picker-switch").html();
        $(".cards-vinters").html("");
        $('input[type="checkbox"]').attr('checked', false);
        $(".jq-checkbox").removeClass("checked");
        $(".dateVinters span").html(day);
        $(".dateVinters small").html(month);
        $(".wrap-wait").show();
        $.getJSON("/ajax/change-day-vinters", {"day": day, "month": month}, function(response) {
            var innerCards = "";
            var bodyInner = "";
            var bodyIn = "";
            var popupInner = "";
            for(var i=0; i<response["valueForDay"].length; i++){
                var k = response["valueForDay"][i]["k"];
                var q = response["valueForDay"][i]["q"];

                k = k.toString().split('.');
                q = q.toString().split('.');
                innerCards = innerCards+
                    '<div class="card'+k[1]+''+q[1]+'">' +
                        '<span class="label label-success">k='+response["valueForDay"][i]["k"]+'</span>' +
                        '<span class="label label-primary">q='+response["valueForDay"][i]["q"]+'</span>' +
                        '<div class="row">'+
                            '<div class="col-md-4"> Tренд: </div>'+
                            '<div class="col-md-8">'+response["valueForDay"][i]["trend"]+'</div>'+
                        '</div>'+
                        ' <div class="row">'+
                            '<div class="col-md-5"> Сезонность: </div>'+
                            '<div class="col-md-7">' +response["valueForMonthBefore"][i]["st"]+'</div>'+
                        '</div>'+
                        '<div class="row">'+
                            '<div class="col-md-4"> Завтра: </div>'+
                            '<div class="col-md-8">'+response["date_tomorrow"]+'</div>'+
                        '</div>'+
                        '<div class="row">'+
                            '<div class="col-md-4"> Прогноз: </div>'+
                            '<div class="col-md-8"> за 1$ '+response["valueForDay"][i]["yt_1"]+' '+response["curentCureency"]["valuta"]+'</div>'+
                        '</div>'+
                        '<a class="btn btn-default" data-toggle="modal" data-target="#popup-calculation'+i+'" href="javascript:void(0)" title="Подробнее расчеты">'+
                            '<span class="p-t-5 p-b-5">'+
                                '<i class="fa fa-question"></i>'+
                            '</span>'+
                        '</a>'+
                    '</div>';
                ;

                bodyInner = bodyInner +
                    '<tr>'+
                    '<td>'+response["valueForDay"][i]["k"]+'</td>'+
                    '<td>'+response["valueForDay"][i]["q"]+'</td>'+
                    '<td>'+response["valueForDay"][i]["yt_1"]+' '+response["curentCureency"]["valuta"]+'</td>'+
                    '</tr>';

                popupInner = popupInner +
                    '<div class="modal fade" id="popup-calculation'+(i+1)+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+
                        '<div class="modal-dialog">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header">'+
                                    '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                '<h4 class="modal-title" id="myModalLabel">Расчет прогноза на '+response["date_tomorrow"]+' по методу Винтерса с коэффициентом '+response["valueForDay"][i]["k"]+'</h4>'+
                                '</div>'+
                                '<div class="modal-body">'+
                                    '<ol>'+
                                        '<li>'+
                                            '<p>Рассчитываем экспоненциально-сглаженный ряд:</p>'+
                                            '<p>Lt = k * Yt/St-s+(1-k)*(Lt-1+Tt-1)</p>'+
                                        '</li>'+
                                        '<li>'+
                                            '<p>Определяем значение тренда:</p>'+
                                            '<p>Tt=b*(Lt - Lt-1)+(1-b)*Tt-1</p>'+
                                        '</li>'+
                                        '<li>'+
                                            '<p>Оцениваем сезонность:</p>'+
                                            '<p>St=q*Yt/Lt+(1-q)*St-s</p>'+
                                        '</li>'+
                                        '<li>'+
                                            '<p>Делаем прогноз:</p>'+
                                            '<p>Ŷt+p = (Lt + p *Tt)*St-s+p</p>'+
                                        '</li>'+
                                    '</ol>'+
                                    '<p class="t4"><b>Значения на '+response["valuesForDayBefore"][i]["date"] +' для k='+response["valuesForDayBefore"][i]["k"]+', q='+response["valuesForDayBefore"][i]["q"]+'</b></p>'+
                                    '<table class="table">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>Значение курса</th>'+
                                                '<th>Экспоненциально-сглаженный ряд</th>'+
                                                '<th>Значение тренда</th>'+
                                                '<th>Значение сезонности</th>'+
                                                '<th>Прогноз</th>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>'+
                                            '<tr>'+
                                                '<td>'+response["valuesForDayBefore"][i]["yt"]+' '+response["curentCureency"]["valuta"]+'</td>'+
                                                '<td>'+response["valuesForDayBefore"][i]["lt"]+' '+response["curentCureency"]["valuta"]+'</td>'+
                                                '<td>'+response["valuesForDayBefore"][i]["trend"]+'</td>'+
                                                '<td>'+response["valuesForDayBefore"][i]["st"]+'</td>'+
                                                '<td>'+response["valuesForDayBefore"][i]["yt_1"]+' '+response["curentCureency"]["valuta"]+'</td>'+
                                            '</tr>'+
                                        '</tbody>'+
                                    '</table>'+
                                    '<p class="t3"><b>Рассмотрим подробнее</b></p>'+
                                    '<ul>'+
                                        '<li>'+
                                            '<p>Рассчитываем экспоненциально-сглаженный ряд с использованием информации на момент времени t–1</p>'+
                                            '<p>L<small>t</small> = k * Y<small>t</small>/S<small>t-s</small>+(1-k)*(L<small>t-1</small>+T<smal>t-1</smal>) = </p>' +
                                            '<p>= '+response["valuesForDayBefore"][i]["k"]+' * '+response["valueForDay"][i]["yt"]+' / '+response["valueForMonthBefore"][i]["st"]+') + (1 - '+ response["valuesForDayBefore"][i]["k"]+') * ('+response["valuesForDayBefore"][i]["lt"]+' + '+response["valuesForDayBefore"][i]["trend"]+' = '+response["valueForDay"][i]["lt"]+'</p>'+
                                        '</li>'+
                                        '<li>'+
                                            '<p>Определяем значение тренда:</p>'+
                                            '<p>T<small>t</small>=b*(L<small>t</small> - L<small>t-1</small>)+(1-b)*T<small>t-1</small> = </p>' +
                                            '<p> = 0.9 * ('+response["valueForDay"][i]["lt"]+' - '+response["valuesForDayBefore"][i]["lt"]+') + (1 - 0.9) * '+ response["valuesForDayBefore"][i]["trend"]+' = '+response["valueForDay"][i]["trend"]+'</p>'+
                                        '</li>'+
                                        '<li>'+
                                            '<p>Оцениваем сезонность:</p>'+
                                            '<p>S<small>t</small>=q*Y<small>t</small>/L<small>t</small>+(1-q)*S<small>t-s</small> = </p>' +
                                            '<p> = '+response["valuesForDayBefore"][i]["q"]+' * '+response["valueForDay"][i]["yt"]+' / '+response["valuesForDayBefore"][i]["lt"]+' + (1 - '+response["valuesForDayBefore"][i]["q"]+') * '+ response["valueForMonthBefore"][i]["st"]+' = '+response["valueForDay"][i]["st"]+'</p>'+
                                            '</li>'+
                                        '<li>'+
                                            '<p>Находим прогноз на '+response["date_tomorrow"]+'</p>'+
                                            '<p>Прогноз на 1 период вперед равен:</p>'+
                                            '<p><p>Ŷ<small>t+1</small> =(L<small>t</small> +1*T<small>t</small>)*S<small>t-s+1</small> = </p>' +
                                            ' = ('+response["valueForDay"][i]["lt"]+' + 1 * '+response["valueForDay"][i]["trend"]+')*'+response["valueForDay"][i]["trend"]+' = '+response["valueForTommorowMonthBefore"][i]["yt_1"]+' '+response["curentCureency"]["valuta"]+' за 1$</p>'+
                                        '</li>'+
                                    '</ul>'+
                                '</div>'+
                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
            }
            $(".cards-hidden").html(innerCards);
            $(".bodyInner").html(bodyInner);
            $(".popups").html(popupInner);

            bodyIn = bodyIn +
                '<tr>'+
                '<td>'+response["minValuesVinters"]["k"]+'</td>'+
                '<td>'+response["minValuesVinters"]["q"]+'</td>'+
                '<td>'+response["minValuesVinters"]["yt_1"]+' '+response["curentCureency"]["valuta"]+'</td>'+
                '<td>'+response["minValuesVinters"]["e"]+' %'+
                '</tr>';
            $(".bodyInn").html(bodyIn);
            $(".optDate").html(response["minValuesVinters"]["date"]);
            $(".optVal").html(response["minValuesVinters"]["yt"]+" "+response["curentCureency"]["valuta"]+" за 1$");
            $(".optKoef").html("k= "+response["minValuesVinters"]["k"]+", q=  "+response["minValuesVinters"]["q"]);
            $(".optDateTommorow").html(response["date_tomorrow"]+":</b> "+response["minValuesVinters"]["yt_1"]+" "+response["curentCureency"]["valuta"]+" за 1$");

            myGeneric.tableChartVinters(response["valueForDay"][0]["date"]);
            $(".wrap-wait").hide();
        });
    });
};


myGeneric.optimalVsReal = function() {
    if($("div").is("#optimal_va_real_container")){
        $.getJSON("/ajax/get-oprimal-and-real", {}, function(response) {

            var optimal = [];
            var real = [];

            for(var i= 0; i<response["optimal"].length; i++){
                optimal[i] = response["optimal"][i]["value"];
            }
            for(var i= 0; i<response["real"].length; i++){
                real[i] = response["real"][i]["value"];
            }

            $('#optimal_va_real_container').highcharts({
                title: {
                    text: 'Оптимальные прогнозы и реальные курсы валютной пары '+response["currency"]["title"],
                    x: -20 //center
                },
                subtitle: {
                    text: '',
                    x: -20
                },
                xAxis: {
                    type: 'datetime',
                    minRange: 14 * 24 * 3600000 // fourteen days
                },
                yAxis: {
                    title: {
                        text: 'Значение курса'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: ' '+response["currency"]["valuta"]
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2015, 0, 1),
                    name: 'Оптимальный прогноз',
                    data: optimal
                }, {
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2015, 0, 1),
                    name: 'Реальный курс',
                    data: real
                }
                ]
            });
        });
    }
}();

$(function () {
    $('#datepicker-holt').datetimepicker({
        inline: true
    });

    $('#datepicker-vinters').datetimepicker({
        inline: true
    });

    $('#datepicker-medium').datetimepicker({
        inline: true
    });

    $(".date span").html($("td.active").html());
    $(".date small").html($(".picker-switch").html());

    $(".dateVinters span").html($("td.active").html());
    $(".dateVinters small").html($(".picker-switch").html());


    myGeneric.getRates();
    myGeneric.setCurrency();
    myGeneric.forecastsHolt();
    myGeneric.forecastsVinters();
    myGeneric.forecastsMedium();
    myGeneric.tableChart("today");
    myGeneric.tableChartMedium("today");
    myGeneric.tableChartVinters("today");
    myGeneric.login();
    myGeneric.logout();
    myGeneric.kcheckbox();
    myGeneric.kqcheckbox();
    myGeneric.changeDay();
    myGeneric.changeDayVinters();
    myGeneric.changeDayMedium();
    myGeneric.oprimalVinters();
    myGeneric.oprimalHolt();
    myGeneric.oprimalMedium();

    $(".fancybox").fancybox();
    $(".ui-state-default").click(function() {
        console.log(1);
    });

    $("input[type='checkbox']").styler();
    $("select").styler();
});
