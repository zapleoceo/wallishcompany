<ul id="menu">
  <li id="dashboard"><a href="<?php echo $home; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li>
  <li id="catalog"><a class="parent"><i class="fa fa-tags fa-fw"></i> <span><?php echo $text_catalog; ?></span></a>
    <ul>
      <?php if($category): ?>
        <li><a href="<?php echo $category; ?>"><?php echo $text_category; ?></a></li>
      <?php endif; ?>

      <?php if($product): ?>
      <li><a href="<?php echo $product; ?>"><?php echo $text_product; ?></a></li>
      <?php endif; ?>

      <?php if($pricer): ?>
      <li><a href="<?php echo $pricer; ?>"><?php echo $text_pricer; ?></a></li>
      <?php endif; ?>

      <?php if($recurring): ?>
      <li><a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></li>
      <?php endif; ?>

      <?php if($filter): ?>
      <li><a href="<?php echo $filter; ?>"><?php echo $text_filter; ?></a></li>
      <?php endif; ?>


      <li><a class="parent"><?php echo $text_attribute; ?></a>
        <ul>
          <?php if($attribute): ?>
          <li><a href="<?php echo $attribute; ?>"><?php echo $text_attribute; ?></a></li>
          <?php endif; ?>

          <?php if($attribute_group): ?>
          <li><a href="<?php echo $attribute_group; ?>"><?php echo $text_attribute_group; ?></a></li>
          <?php endif; ?>
        </ul>
      </li>
      <?php if($option): ?>
      <li><a href="<?php echo $option; ?>"><?php echo $text_option; ?></a></li>
      <?php endif; ?>

      <?php if($manufacturer): ?>
      <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
      <?php endif; ?>

      <?php if($download): ?>
      <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
      <?php endif; ?>

      <?php if($review): ?>
      <li><a href="<?php echo $review; ?>"><?php echo $text_review; ?></a></li>
      <?php endif; ?>

      <?php if($information): ?>
      <li><a href="<?php echo $information; ?>"><?php echo $text_information; ?></a></li>
      <?php endif; ?>
    </ul>
  </li>
  <li id="blog"><a class="parent"><i class="fa fa-book fa-fw"></i> <span><?php echo $text_blog; ?></span></a>
    <ul>
      <?php if($blog_article): ?>
      <li><a href="<?php echo $blog_article; ?>"><?php echo $text_blog_article; ?></a></li>
      <?php endif; ?>

      <?php if($blog_category): ?>
	  <li><a href="<?php echo $blog_category; ?>"><?php echo $text_blog_category; ?></a></li>
      <?php endif; ?>

      <?php if($blog_review): ?>
      <li><a href="<?php echo $blog_review; ?>"><?php echo $text_blog_review; ?></a></li>
      <?php endif; ?>

      <?php if($blog_setting): ?>
      <li><a href="<?php echo $blog_setting; ?>"><?php echo $text_blog_setting; ?></a></li>
      <?php endif; ?>
	</ul>
  </li>
  <li id="extension"><a class="parent"><i class="fa fa-puzzle-piece fa-fw"></i> <span><?php echo $text_extension; ?></span></a>
    <ul>
      <?php if($installer): ?>
      <li><a href="<?php echo $installer; ?>"><?php echo $text_installer; ?></a></li>
      <?php endif; ?>

      <?php if($modification): ?>
      <li><a href="<?php echo $modification; ?>"><?php echo $text_modification; ?></a></li>
      <?php endif; ?>

      <?php if($analytics): ?>
      <li><a href="<?php echo $analytics; ?>"><?php echo $text_analytics; ?></a></li>
      <?php endif; ?>

      <?php if($captcha): ?>
      <li><a href="<?php echo $captcha; ?>"><?php echo $text_captcha; ?></a></li>
      <?php endif; ?>

      <?php if($feed): ?>
      <li><a href="<?php echo $feed; ?>"><?php echo $text_feed; ?></a></li>
      <?php endif; ?>

      <?php if($fraud): ?>
      <li><a href="<?php echo $fraud; ?>"><?php echo $text_fraud; ?></a></li>
      <?php endif; ?>

      <?php if($module): ?>
      <li><a href="<?php echo $module; ?>"><?php echo $text_module; ?></a></li>
      <?php endif; ?>

      <?php if($payment): ?>
      <li><a href="<?php echo $payment; ?>"><?php echo $text_payment; ?></a></li>
      <?php endif; ?>

      <?php if($shipping): ?>
      <li><a href="<?php echo $shipping; ?>"><?php echo $text_shipping; ?></a></li>
      <?php endif; ?>

      <?php if($total): ?>
      <li><a href="<?php echo $total; ?>"><?php echo $text_total; ?></a></li>
      <?php endif; ?>


      <?php if ($openbay_show_menu == 1) { ?>
      <li><a class="parent"><?php echo $text_openbay_extension; ?></a>
        <ul>

          <?php if($openbay_link_extension): ?>
          <li><a href="<?php echo $openbay_link_extension; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
          <?php endif; ?>

          <?php if($openbay_link_orders): ?>
          <li><a href="<?php echo $openbay_link_orders; ?>"><?php echo $text_openbay_orders; ?></a></li>
          <?php endif; ?>

          <?php if($openbay_link_items): ?>
          <li><a href="<?php echo $openbay_link_items; ?>"><?php echo $text_openbay_items; ?></a></li>
          <?php endif; ?>


          <?php if ($openbay_markets['ebay'] == 1) { ?>
          <li><a class="parent"><?php echo $text_openbay_ebay; ?></a>
            <ul>
              <?php if($openbay_link_ebay): ?>
              <li><a href="<?php echo $openbay_link_ebay; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
              <?php endif; ?>

              <?php if($openbay_link_ebay_settings): ?>
              <li><a href="<?php echo $openbay_link_ebay_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
              <?php endif; ?>
              <?php if($openbay_link_ebay_links): ?>
              <li><a href="<?php echo $openbay_link_ebay_links; ?>"><?php echo $text_openbay_links; ?></a></li>
              <?php endif; ?>

              <?php if($openbay_link_ebay_orderimport): ?>
              <li><a href="<?php echo $openbay_link_ebay_orderimport; ?>"><?php echo $text_openbay_order_import; ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
          <?php } ?>
          <?php if ($openbay_markets['amazon'] == 1) { ?>
          <li><a class="parent"><?php echo $text_openbay_amazon; ?></a>
            <ul>
              <?php if($openbay_link_amazon): ?>
              <li><a href="<?php echo $openbay_link_amazon; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
              <?php endif; ?>

              <?php if($openbay_link_amazon_settings): ?>
              <li><a href="<?php echo $openbay_link_amazon_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
              <?php endif; ?>

              <?php if($openbay_link_amazon_links): ?>
              <li><a href="<?php echo $openbay_link_amazon_links; ?>"><?php echo $text_openbay_links; ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
          <?php } ?>
          <?php if ($openbay_markets['amazonus'] == 1) { ?>
          <li><a class="parent"><?php echo $text_openbay_amazonus; ?></a>
            <ul>

              <?php if($openbay_link_amazonus): ?>
              <li><a href="<?php echo $openbay_link_amazonus; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
              <?php endif; ?>

              <?php if($openbay_link_amazonus_settings): ?>
              <li><a href="<?php echo $openbay_link_amazonus_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
              <?php endif; ?>

              <?php if($openbay_link_amazonus_links): ?>
              <li><a href="<?php echo $openbay_link_amazonus_links; ?>"><?php echo $text_openbay_links; ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
          <?php } ?>
          <?php if ($openbay_markets['etsy'] == 1) { ?>
          <li><a class="parent"><?php echo $text_openbay_etsy; ?></a>
            <ul>

              <?php if($openbay_link_etsy): ?>
              <li><a href="<?php echo $openbay_link_etsy; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
              <?php endif; ?>

              <?php if($openbay_link_etsy_settings): ?>
              <li><a href="<?php echo $openbay_link_etsy_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
              <?php endif; ?>

              <?php if($openbay_link_etsy_links): ?>
              <li><a href="<?php echo $openbay_link_etsy_links; ?>"><?php echo $text_openbay_links; ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>
    </ul>
  </li>
  <li id="sale"><a class="parent"><i class="fa fa-shopping-cart fa-fw"></i> <span><?php echo $text_sale; ?></span></a>
    <ul>

      <?php if($order): ?>
      <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
      <?php endif; ?>

      <?php if($order_recurring): ?>
      <li><a href="<?php echo $order_recurring; ?>"><?php echo $text_order_recurring; ?></a></li>
      <?php endif; ?>

      <?php if($return): ?>
      <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
      <?php endif; ?>
      <li><a class="parent"><?php echo $text_voucher; ?></a>
        <ul>

          <?php if($voucher): ?>
          <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
          <?php endif; ?>

          <?php if($voucher_theme): ?>
          <li><a href="<?php echo $voucher_theme; ?>"><?php echo $text_voucher_theme; ?></a></li>
          <?php endif; ?>
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_paypal ?></a>
        <ul>

          <?php if($paypal_search): ?>
          <li><a href="<?php echo $paypal_search ?>"><?php echo $text_paypal_search ?></a></li>
          <?php endif; ?>

        </ul>
      </li>
    </ul>
  </li>
  <li id="customer"><a class="parent"><i class="fa fa-user fa-fw"></i> <span><?php echo $text_customer; ?></span></a>
    <ul>
      <?php if($customer): ?>
      <li><a href="<?php echo $customer; ?>"><?php echo $text_customer; ?></a></li>
      <?php endif; ?>

      <?php if($customer_group): ?>
      <li><a href="<?php echo $customer_group; ?>"><?php echo $text_customer_group; ?></a></li>
      <?php endif; ?>

      <?php if($custom_field): ?>
      <li><a href="<?php echo $custom_field; ?>"><?php echo $text_custom_field; ?></a></li>
      <?php endif; ?>

    </ul>
  </li>
  <li><a class="parent"><i class="fa fa-share-alt fa-fw"></i> <span><?php echo $text_marketing; ?></span></a>
    <ul>
      <?php if($marketing): ?>
      <li><a href="<?php echo $marketing; ?>"><?php echo $text_marketing; ?></a></li>
      <?php endif; ?>

      <?php if($affiliate): ?>
      <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
      <?php endif; ?>

      <?php if($coupon): ?>
      <li><a href="<?php echo $coupon; ?>"><?php echo $text_coupon; ?></a></li>
      <?php endif; ?>

      <?php if($contact): ?>
      <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
      <?php endif; ?>

    </ul>
  </li>
  <li id="design"><a class="parent"><i class="fa fa-desktop fa-fw"></i> <span><?php echo $text_design; ?></span></a>
    <ul>

      <?php if($layout): ?>
      <li><a href="<?php echo $layout; ?>"><?php echo $text_layout; ?></a></li>
      <?php endif; ?>

      <?php if($menu): ?>
	  <li><a href="<?php echo $menu; ?>"><?php echo $text_menu; ?></a></li>
      <?php endif; ?>

      <?php if($banner): ?>
      <li><a href="<?php echo $banner; ?>"><?php echo $text_banner; ?></a></li>
      <?php endif; ?>

    </ul>
  </li>
  <li id="system"><a class="parent"><i class="fa fa-cog fa-fw"></i> <span><?php echo $text_system; ?></span></a>
    <ul>
      <?php if($setting): ?>
      <li><a href="<?php echo $setting; ?>"><?php echo $text_setting; ?></a></li>
      <?php endif; ?>

      <li><a class="parent"><?php echo $text_users; ?></a>
        <ul>

          <?php if($user): ?>
          <li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
          <?php endif; ?>

          <?php if($user_group): ?>
          <li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
          <?php endif; ?>

          <?php if($api): ?>
          <li><a href="<?php echo $api; ?>"><?php echo $text_api; ?></a></li>
          <?php endif; ?>

        </ul>
      </li>
      <li><a class="parent"><?php echo $text_localisation; ?></a>
        <ul>

          <?php if($location): ?>
          <li><a href="<?php echo $location; ?>"><?php echo $text_location; ?></a></li>
          <?php endif; ?>

          <?php if($language): ?>
          <li><a href="<?php echo $language; ?>"><?php echo $text_language; ?></a></li>
          <?php endif; ?>

          <?php if($currency): ?>
          <li><a href="<?php echo $currency; ?>"><?php echo $text_currency; ?></a></li>
          <?php endif; ?>

          <?php if($stock_status): ?>
          <li><a href="<?php echo $stock_status; ?>"><?php echo $text_stock_status; ?></a></li>
          <?php endif; ?>

          <?php if($order_status): ?>
          <li><a href="<?php echo $order_status; ?>"><?php echo $text_order_status; ?></a></li>
          <?php endif; ?>


          <li><a class="parent"><?php echo $text_return; ?></a>
            <ul>

              <?php if($return_status): ?>
              <li><a href="<?php echo $return_status; ?>"><?php echo $text_return_status; ?></a></li>
              <?php endif; ?>

              <?php if($return_action): ?>
              <li><a href="<?php echo $return_action; ?>"><?php echo $text_return_action; ?></a></li>
              <?php endif; ?>

              <?php if($return_reason): ?>
              <li><a href="<?php echo $return_reason; ?>"><?php echo $text_return_reason; ?></a></li>
              <?php endif; ?>
            </ul>
          </li>

          <?php if($country): ?>
          <li><a href="<?php echo $country; ?>"><?php echo $text_country; ?></a></li>
          <?php endif; ?>

          <?php if($zone): ?>
          <li><a href="<?php echo $zone; ?>"><?php echo $text_zone; ?></a></li>
          <?php endif; ?>

          <?php if($geo_zone): ?>
          <li><a href="<?php echo $geo_zone; ?>"><?php echo $text_geo_zone; ?></a></li>
          <?php endif; ?>

          <li><a class="parent"><?php echo $text_tax; ?></a>
            <ul>

              <?php if($tax_class): ?>
              <li><a href="<?php echo $tax_class; ?>"><?php echo $text_tax_class; ?></a></li>
              <?php endif; ?>

              <?php if($tax_rate): ?>
              <li><a href="<?php echo $tax_rate; ?>"><?php echo $text_tax_rate; ?></a></li>
              <?php endif; ?>

            </ul>
          </li>

          <?php if($length_class): ?>
          <li><a href="<?php echo $length_class; ?>"><?php echo $text_length_class; ?></a></li>
          <?php endif; ?>

          <?php if($weight_class): ?>
          <li><a href="<?php echo $weight_class; ?>"><?php echo $text_weight_class; ?></a></li>
          <?php endif; ?>
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_tools; ?></a>
        <ul>
          <?php if($upload): ?>
          <li><a href="<?php echo $upload; ?>"><?php echo $text_upload; ?></a></li>
          <?php endif; ?>

          <?php if($backup): ?>
          <li><a href="<?php echo $backup; ?>"><?php echo $text_backup; ?></a></li>
          <?php endif; ?>

          <?php if($seomanager): ?>
		  <li><a href="<?php echo $seomanager; ?>"><?php echo $text_seomanager; ?></a></li>
          <?php endif; ?>

          <?php if($error_log): ?>
          <li><a href="<?php echo $error_log; ?>"><?php echo $text_error_log; ?></a></li>
          <?php endif; ?>
        </ul>
      </li>
    </ul>
  </li>
  <li id="reports"><a class="parent"><i class="fa fa-bar-chart-o fa-fw"></i> <span><?php echo $text_reports; ?></span></a>
    <ul>
      <li><a class="parent"><?php echo $text_sale; ?></a>
        <ul>

          <?php if($report_sale_order): ?>
          <li><a href="<?php echo $report_sale_order; ?>"><?php echo $text_report_sale_order; ?></a></li>
          <?php endif; ?>

          <?php if($report_sale_tax): ?>
          <li><a href="<?php echo $report_sale_tax; ?>"><?php echo $text_report_sale_tax; ?></a></li>
          <?php endif; ?>

          <?php if($report_sale_shipping): ?>
          <li><a href="<?php echo $report_sale_shipping; ?>"><?php echo $text_report_sale_shipping; ?></a></li>
          <?php endif; ?>

          <?php if($report_sale_return): ?>
          <li><a href="<?php echo $report_sale_return; ?>"><?php echo $text_report_sale_return; ?></a></li>
          <?php endif; ?>

          <?php if($report_sale_coupon): ?>
          <li><a href="<?php echo $report_sale_coupon; ?>"><?php echo $text_report_sale_coupon; ?></a></li>
          <?php endif; ?>
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_product; ?></a>
        <ul>

          <?php if($report_product_viewed): ?>
          <li><a href="<?php echo $report_product_viewed; ?>"><?php echo $text_report_product_viewed; ?></a></li>
          <?php endif; ?>

          <?php if($report_product_purchased): ?>
          <li><a href="<?php echo $report_product_purchased; ?>"><?php echo $text_report_product_purchased; ?></a></li>
          <?php endif; ?>
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_customer; ?></a>
        <ul>

          <?php if($report_customer_online): ?>
          <li><a href="<?php echo $report_customer_online; ?>"><?php echo $text_report_customer_online; ?></a></li>
          <?php endif; ?>

          <?php if($report_customer_activity): ?>
          <li><a href="<?php echo $report_customer_activity; ?>"><?php echo $text_report_customer_activity; ?></a></li>
          <?php endif; ?>

          <?php if($report_customer_order): ?>
          <li><a href="<?php echo $report_customer_order; ?>"><?php echo $text_report_customer_order; ?></a></li>
          <?php endif; ?>

          <?php if($report_customer_reward): ?>
          <li><a href="<?php echo $report_customer_reward; ?>"><?php echo $text_report_customer_reward; ?></a></li>
          <?php endif; ?>

          <?php if($report_customer_credit): ?>
          <li><a href="<?php echo $report_customer_credit; ?>"><?php echo $text_report_customer_credit; ?></a></li>
          <?php endif; ?>
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_marketing; ?></a>
        <ul>
          <?php if($report_marketing): ?>
          <li><a href="<?php echo $report_marketing; ?>"><?php echo $text_marketing; ?></a></li>
          <?php endif; ?>

          <?php if($report_affiliate): ?>
          <li><a href="<?php echo $report_affiliate; ?>"><?php echo $text_report_affiliate; ?></a></li>
          <?php endif; ?>

          <?php if($report_affiliate_activity): ?>
          <li><a href="<?php echo $report_affiliate_activity; ?>"><?php echo $text_report_affiliate_activity; ?></a></li>
          <?php endif; ?>
        </ul>
      </li>
    </ul>
  </li>

  <li id="seo"><a class="parent"><i class="fa fa-comment-o fa-fw"></i> <span><?php echo $text_seo; ?></span></a>
    <ul>
      <li><a class="parent"><?php echo $text_gogettop; ?></a>
        <ul>
          <li><a href="http://gogettop.ru/?ref=16605" target="_blank"><?php echo $text_gogettop; ?></a></li>

          <?php if($gogettop): ?>
          <li><a href="<?php echo $gogettop; ?>"><?php echo $text_gogettop_help; ?></a></li>
          <?php endif; ?>
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_seopult; ?></a>
        <ul>
          <li><a href="http://seopult.ru/ref/f8924f1b27c4ffd6/aHR0cDovL3Nlb3B1bHQucnUvcmVnaXN0ZXIuaHRtbD9zPXRodG9w" target="_blank"><?php echo $text_seopult; ?></a></li>

          <?php if($seopult): ?>
          <li><a href="<?php echo $seopult; ?>"><?php echo $text_seopult_help; ?></a></li>
          <?php endif; ?>
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_blogun; ?></a>
        <ul>
          <li><a href="https://blogun.ru/unimpairedcedcdhg.html" target="_blank"><?php echo $text_blogun; ?></a></li>
          <?php if($blogun): ?>
          <li><a href="<?php echo $blogun; ?>"><?php echo $text_blogun_help; ?></a></li>
          <?php endif; ?>
        </ul>
      </li>
	  </ul>
  </li>
</ul>

<script>

  $(document).ready(function(){

      $('#menu > li > ul > li > ul > li').each(function(){

          var count = $(this).find('ul').length;
          var count2 = $(this).find('ul > li').length;
          if (count == 1 && count2 == 0) {
              console.log(this);
              $(this).remove();
          }
      });

      $('#menu > li > ul > li').each(function(){
          var count = $(this).find('ul').length;
          var count2 = $(this).find('ul > li').length;
          if (count == 1 && count2 == 0) {
              console.log(this);
              $(this).remove();
          }
      });

      $('#menu > li').each(function(){
          var count = $(this).find('ul').length;
          var count2 = $(this).find('ul > li').length;
          if (count == 1 && count2 == 0) {
              console.log(this);
              $(this).remove();
          }
      });

  });
</script>
