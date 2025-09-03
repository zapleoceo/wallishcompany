<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-bar-chart"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-6">




              <div class="form-group">
                <label class="control-label">Тип результата</label>
                <select class="form-control" name="result_type">
                  <option value="summ"<?= $result_type == 'summ' ? ' selected' : ''; ?>>Сумма продаж</option>
                  <option value="count"<?= $result_type == 'count' ? ' selected' : ''; ?>>Количество продукции</option>
                  <option value="orders"<?= $result_type == 'orders' ? ' selected' : ''; ?>>Количество Заказов  (Категории)</option>
                  <option value="orders_total"<?= $result_type == 'orders_total' ? ' selected' : ''; ?>>Количество Заказов (По сумме)</option>
                </select>
              </div>

              <div class="form-group">
                <label class="control-label" for="input-date-start"><?php echo $entry_date_start; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" id="input-date-start" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-date-end"><?php echo $entry_date_end; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" id="input-date-end" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-group"><?php echo $entry_group; ?></label>
                <select name="filter_group" id="input-group" class="form-control">
                  <?php foreach ($groups as $group) { ?>
                  <?php if ($group['value'] == $filter_group) { ?>
                  <option value="<?php echo $group['value']; ?>" selected="selected"><?php echo $group['text']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $group['value']; ?>"><?php echo $group['text']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group" style="">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_order_status_id" id="input-status" class="form-control">
                  <option value="0"><?php echo $text_all_status; ?></option>
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-2 pull-right" style="margin-right: -33px;">
            <form method="post">
              <input type="hidden" name="topdf" value="1">

              <input type="hidden" name="rows[]" id="pdftable" value="">
              <input type="hidden" name="rows[]" id="pdfchart" value="">

              <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i>
                Распечатать PDF
              </button>
            </form>
            <br>
            <br>
          </div>
        </div>


        <div class="table-responsive tablepdf">
          <h3 style="text-align: center;"><?= $order_result_text; ?></h3>
          <br>
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
          <div class="col-6 text-left" style="width: 95%!important;">

            <?php if (!empty($orders['chart'])): ?>

            <canvas id="myChart" width="400" height="400"></canvas>


            <script>
                var labels = <?= json_encode($orders['chart']['labels']); ?>;
                var data = <?= json_encode($orders['chart']['data']); ?>;

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

                var myChart;

                function done(){
                    var url=myChart.toBase64Image();
                    $('#pdfchart').val(url);
                }

                setTimeout(function(){

                    var ctx = document.getElementById("myChart").getContext('2d');
                    myChart = new Chart(ctx, config);

                    html2canvas(document.querySelector(".tablepdf")).then(canvas => {
                        var img    = canvas.toDataURL("image/png");
                        $('#pdftable').val(img);
                    });

                }, 300);

            </script>

            <?php else: ?>
              <script>
                  setTimeout(function(){
                      html2canvas(document.querySelector(".tablepdf")).then(canvas => {
                          var img    = canvas.toDataURL("image/png");
                      $('#pdftable').val(img);
                      $('#pdfchart').remove();
                  });

                  }, 300);

              </script>

            <?php endif; ?>

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
$('#button-filter').on('click', function() {
	url = 'index.php?route=report/sale_order&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').val();
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').val();
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
		
	var filter_group = $('select[name=\'filter_group\']').val();
	
	if (filter_group) {
		url += '&filter_group=' + encodeURIComponent(filter_group);
	}

    var result_type = $('select[name=\'result_type\']').val();

    if (result_type) {
        url += '&result_type=' + encodeURIComponent(result_type);
    }
	
	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').val();
	
	if (filter_order_status_id != 0) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}	

	location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?>