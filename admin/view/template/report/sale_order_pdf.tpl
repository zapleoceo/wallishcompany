<?php echo $header; ?>
<div id="content">
<br>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-bar-chart"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                  <?php if (isset($orders['titles'])) { ?>
                    <?php foreach ($orders['titles'] as $title): ?>
                        <td class="text-left"><?php echo $title; ?></td>
                    <?php endforeach; ?>
                  <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php if (isset($orders['data'])) { ?>
              <?php foreach ($orders['data'] as $order) { ?>
              <tr>
                  <?php foreach($order as $ord): ?>
                    <td class="text-left"><?php echo $ord; ?></td>
                  <?php endforeach; ?>


              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="row">
          <img id="url" />
          <div class="col-6 text-left" style="width: 95%!important;">



            <canvas id="myChart" width="400" height="400"></canvas>

            <script>
                var labels = <?= json_encode($orders['chart']['labels']); ?>;
                var data = <?= json_encode($orders['chart']['data']); ?>;



                function done(){
                    var url=myChart.toBase64Image();
                    document.getElementById("url").src=url;
                    //document.getElementById("myChart").style='display:none';
                }


                var config = {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: '',
                            fill: true,
                            backgroundColor: '#dac7c7',
                            borderColor: '#865555',
                            data: data,
                        }]
                    },
                    options: {
                        bezierCurve : false,
                        animation: {
                            onComplete: done
                        },

                        responsive: true,
                        maintainAspectRatio: false,
                        title: {
                            display: true,
                            text: ''
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: false,
                                    labelString: 'x'
                                },

                            }],
                            yAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: false,
                                    labelString: 'y'
                                },
                                ticks: {
                                    min: 0, // it is for ignoring negative step.
                                    beginAtZero: true,
                                    callback: function(value, index, values) {
                                        if (Math.floor(value) === value) {
                                            return value;
                                        }
                                    }
                                }
                            }]
                        }
                    }
                };

                var ctx = document.getElementById("myChart").getContext('2d');
                var myChart = new Chart(ctx, config);
            </script>



          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<style type="text/css">
  #header,.well,#footer {display:none;}

</style>
<?php echo $footer; ?>