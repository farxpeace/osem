if ($('#site_activities').size() != 0) {
    //site activities
    var previousPoint2 = null;
    $('#site_activities_loading').hide();
    $('#site_activities_content').show();

    


    var plot_statistics = $.plot($("#site_activities"),

        [{
            data: data1,
            lines: {
                fill: 0.2,
                lineWidth: 0,
            },
            color: ['#BAD9F5']
        }, {
            data: data1,
            points: {
                show: true,
                fill: true,
                radius: 4,
                fillColor: "#9ACAE6",
                lineWidth: 2
            },
            color: '#9ACAE6',
            shadowSize: 1
        }, {
            data: data1,
            lines: {
                show: true,
                fill: false,
                lineWidth: 3
            },
            color: '#9ACAE6',
            shadowSize: 0
        }],

        {

            xaxis: {
                tickLength: 0,
                tickDecimals: 0,
                mode: "categories",
                min: 0,
                font: {
                    lineHeight: 18,
                    style: "normal",
                    variant: "small-caps",
                    color: "#6F7B8A"
                }
            },
            yaxis: {
                ticks: 5,
                tickDecimals: 0,
                tickColor: "#eee",
                font: {
                    lineHeight: 14,
                    style: "normal",
                    variant: "small-caps",
                    color: "#6F7B8A"
                }
            },
            grid: {
                hoverable: true,
                clickable: true,
                tickColor: "#eee",
                borderColor: "#eee",
                borderWidth: 1
            }
        });

    $("#site_activities").bind("plothover", function(event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));
        if (item) {
            if (previousPoint2 != item.dataIndex) {
                previousPoint2 = item.dataIndex;
                $("#tooltip").remove();
                var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2);
                showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' visitor(s)');
            }
        }
    });

    $('#site_activities').bind("mouseleave", function() {
        $("#tooltip").remove();
    });
}

function showChartTooltip(x, y, xValue, yValue) {
                $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y - 40,
                    left: x - 40,
                    border: '0px solid #ccc',
                    padding: '2px 6px',
                    'background-color': '#fff'
                }).appendTo("body").fadeIn(200);
            }
/*
var data = {
    labels : ["SUN","MON","TUE","WED","THU","FRI","SAT"],
    datasets : [
        {
            fillColor : "rgba(255,255,255,0.1)",
            strokeColor : "rgba(0,0,0,0.25)",
            pointColor : "rgba(255,255,255,1)",
            pointStrokeColor : "#fe9d37",
            data : [135,185,225,385,275,215,265]
        }
    ]
}

var options = {
    scaleFontColor : "rgba(0,0,0,1)",
    scaleLineColor : "rgba(0,0,0,0.1)",
    scaleGridLineColor : "rgba(0,0,0,0.1)",
    scaleShowLabels : false,
    scaleShowHorizontalLines : false,
    bezierCurve : false,
    pointDot : true,
    pointDotRadius : 5,
    pointDotStrokeWidth : 2,
    scaleOverride : true,
    scaleSteps : 6,
    scaleStepWidth : 100,
    responsive : true,
    showTooltips: true,
    tooltipTemplate: "<%= value %> " + "Students",
    tooltipFontSize: 16,
    tooltipYPadding: 12,
    tooltipXPadding: 12,
    tooltipCornerRadius: 3,
    tooltipFillColor: "#3797d3",
        
    onAnimationComplete : function() {
        var arrSelector = [];
        this.datasets[0].points.forEach(function(point){
            if(point.label == 'WED'){
                arrSelector.push(point);
            }
        });

        this.showTooltip(arrSelector, true);          
    },
    tooltipEvents: []
}

new Chart(c1.getContext("2d")).Line(data,options);
*/
