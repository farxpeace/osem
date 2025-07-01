<div id="monthly_pay_datatable_container"></div>
<table id="monthly_pay_datatable" style="display: none">
    <thead>
    <tr>
        <th></th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($list_pay as $a => $b){ ?>
        <tr>
            <td><?php echo $b['nicedate'] ?></td>
            <td><?php echo $b['total_pay'] ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script>
    $(function(){
        Highcharts.chart('monthly_pay_datatable_container', {
            data: {
                table: 'monthly_pay_datatable'
            },
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                allowDecimals: true,
                title: {
                    text: 'RM'
                }
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        color: '#000',
                        formatter: function() {return 'RM ' + this.y},
                        inside: false,
                        rotation: -60
                    },
                    pointPadding: 0.1,
                    groupPadding: 0
                }
            },
        });

    })
</script>