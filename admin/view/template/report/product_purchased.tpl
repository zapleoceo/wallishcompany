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

              <div class="form-group">
                <label class="control-label" for="input-category-name"><?php echo $entry_category; ?></label> <label class="control-label pull-right" for="input-sub-category"><?php echo $entry_sub_category; ?> <input type="checkbox" class="checkbox-inline" name="filter_sub_category" id="input-sub-category" class="form-control"<?php echo ($filter_sub_category)?' checked="checked"':''; ?> /></label>
                <div class="clearfix"></div>
                <div class="input-group">
                  <input type="text" name="filter_category_name" value="<?php echo $filter_category_name; ?>" placeholder="<?php echo $entry_category; ?>" id="input-category-name" class="form-control" />
                  <div class="input-group-btn">
                    <button type="button" id="button-clear-input-category-name" class="btn btn-default"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <input type="hidden" name="filter_category" value="<?php echo $filter_category; ?>" id="input-category" class="form-control" />
              </div>

            </div>
            <div class="col-sm-6">
              <div class="form-group">
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
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <td class="text-left"><?php echo $column_name; ?></td>
                <td class="text-left"><?php echo $column_model; ?></td>
                <td class="text-right"><?php echo $column_quantity; ?></td>
                <td class="text-right"><?php echo $column_total; ?></td>
              </tr>
            </thead>
            <tbody>
              <?php if ($products) { ?>
              <?php foreach ($products as $product) { ?>
              <tr>
                <td class="text-left"><?php echo $product['name']; ?></td>
                <td class="text-left"><?php echo $product['model']; ?></td>
                <td class="text-right"><?php echo $product['quantity']; ?></td>
                <td class="text-right"><?php echo $product['total']; ?></td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
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
	url = 'index.php?route=report/product_purchased&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').val();
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').val();
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
	
	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').val();
	
	if (filter_order_status_id != 0) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}

    var filter_category = $('input[name=\'filter_category\']').val();

    if (filter_category) {
        url += '&filter_category=' + encodeURIComponent(filter_category);
    }

    var filter_sub_category = $('input[name=\'filter_sub_category\']');

    if (filter_sub_category.prop('checked')) {
        url += '&filter_sub_category';
    }

	location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script>

  <script type="text/javascript"><!--
      /*$('input[name=\'filter_name\']').autocomplete({
          'source': function(request, response) {
              $.ajax({
                  url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                  dataType: 'json',
                  success: function(json) {
                      response($.map(json, function(item) {
                          return {
                              label: item['name'],
                              value: item['product_id']
                          }
                      }));
                  }
              });
          },
          'select': function(item) {
              $('input[name=\'filter_name\']').val(item['label']);
          }
      });

      $('#button-clear-input-name').on('click',function(){
          $('input[name=\'filter_name\']').val('');
          $('#button-filter').trigger('click');
      });*/

      /*$('input[name=\'filter_model\']').autocomplete({
          'source': function(request, response) {
              $.ajax({
                  url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request),
                  dataType: 'json',
                  success: function(json) {
                      response($.map(json, function(item) {
                          return {
                              label: item['model'],
                              value: item['product_id']
                          }
                      }));
                  }
              });
          },
          'select': function(item) {
              $('input[name=\'filter_model\']').val(item['label']);
          }
      });

      $('#button-clear-input-model').on('click',function(){
          $('input[name=\'filter_model\']').val('');
          $('#button-filter').trigger('click');
      });*/

      $('input[name=\'filter_category_name\']').autocomplete({
          'source': function(request, response) {
              if ($('input[name=\'filter_category_name\']').val().length==0) {
                  $('input[name=\'filter_category\']').val(null);
              }
              $.ajax({
                  url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                  dataType: 'json',
                  success: function(json) {
                      if (json.length>0) {
                          json.unshift({'category_id':null,'name':'<?php echo $text_all; ?>'},{'category_id':0,'name':'<?php echo $text_none_category; ?>'});
                      }
                      response($.map(json, function(item) {
                          return {
                              label: item['name'],
                              value: item['category_id']
                          }
                      }));
                  }
              });
          },
          'select': function(item) {
              if (item['label']!='<?php echo $text_all; ?>') {
                  $('input[name=\'filter_category_name\']').val(item['label']);
              } else {
                  $('input[name=\'filter_category_name\']').val('');
              }
              $('input[name=\'filter_category\']').val(item['value']);
          }
      });

      $('#button-clear-input-category-name').on('click',function(){
          $('input[name=\'filter_category_name\']').val('');
          $('input[name=\'filter_category\']').val(null);
          $('#button-filter').trigger('click');
      });

      /*$('input[name=\'filter_manufacturer_name\']').autocomplete({
          'source': function(request, response) {
              if ($('input[name=\'filter_manufacturer_name\']').val().length==0) {
                  $('input[name=\'filter_manufacturer\']').val(null);
              }
              $.ajax({
                  url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                  dataType: 'json',
                  success: function(json) {
                      if (json.length>0) {
                          json.unshift({'manufacturer_id':null,'name':'<?php echo $text_all; ?>'},{'manufacturer_id':0,'name':'<?php echo $text_none_manufacturer; ?>'});
                      }
                      response($.map(json, function(item) {
                          return {
                              label: item['name'],
                              value: item['manufacturer_id']
                          }
                      }));
                  }
              });
          },
          'select': function(item) {
              if (item['label']!='<?php echo $text_all; ?>') {
                  $('input[name=\'filter_manufacturer_name\']').val(item['label']);
              } else {
                  $('input[name=\'filter_manufacturer_name\']').val('');
              }
              $('input[name=\'filter_manufacturer\']').val(item['value']);
          }
      });*/

      /*$('#button-clear-input-manufacturer-name').on('click',function(){
          $('input[name=\'filter_manufacturer_name\']').val('');
          $('input[name=\'filter_manufacturer\']').val(null);
          $('#button-filter').trigger('click');
      });

      $('#button-clear-input-price-min').on('click',function(){
          $('input[name=\'filter_price_min\']').val('');
          $('#button-filter').trigger('click');
      });

      $('#button-clear-input-price-max').on('click',function(){
          $('input[name=\'filter_price_max\']').val('');
          $('#button-filter').trigger('click');
      });

      $('#button-clear-input-quantity-min').on('click',function(){
          $('input[name=\'filter_quantity_min\']').val('');
          $('#button-filter').trigger('click');
      });

      $('#button-clear-input-quantity-max').on('click',function(){
          $('input[name=\'filter_quantity_max\']').val('');
          $('#button-filter').trigger('click');
      });*/

      $('input[name=\'filter_name\'], input[name=\'filter_model\'], input[name=\'filter_category_name\'], input[name=\'filter_manufacturer_name\'], input[name=\'filter_price_min\'], input[name=\'filter_price_max\'], input[name=\'filter_quantity_min\'], input[name=\'filter_quantity_max\']').keypress(function (e) {
          if (e.which == 13) {
              $('#button-filter').trigger('click');
              return false;
          }
      });

      /*$(document).ready(function(){


          $('input[name*=\'selected_sale\']').on('change', function(){

              if ($(this).is(':checked')) {
                  $.ajax({
                      url: 'index.php?route=catalog/product/chsale&token=<?php echo $token; ?>&product_id=' + $(this).val() + '&st=1',
                  });
              } else {
                  $.ajax({
                      url: 'index.php?route=catalog/product/chsale&token=<?php echo $token; ?>&product_id=' + $(this).val() + '&st=0',
                  });
              }


          });

          $('input[name*=\'selected_new\']').on('change', function(){
              if ($(this).is(':checked')) {
                  $.ajax({
                      url: 'index.php?route=catalog/product/chnew&token=<?php echo $token; ?>&product_id=' + $(this).val() + '&st=1',
                  });
              } else {
                  $.ajax({
                      url: 'index.php?route=catalog/product/chnew&token=<?php echo $token; ?>&product_id=' + $(this).val() + '&st=0d',
                  });
              }
          });

      });*/
      //--></script>

</div>
<?php echo $footer; ?>