<?php echo $header; ?>
<?php $phones = explode(',', $telephone); ?>
<main class="main">
    <!-- BEGIN: breadcrumb -->
    <div class="category container d-xl-block d-lg-block d-md-block d-none">
        <div class="row">
            <div class="col-12">

                <ul class="breadcrumb contacts__breadcrumb">
                    <?php foreach($breadcrumbs as $bk => $br): ?>
                    <?php if ($bk == (count($breadcrumbs)-1)): ?>
                    <li class="breadcrumb__item last">
                        <?= $br['text']; ?>
                    </li>
                    <?php else: ?>
                    <li class="breadcrumb__item">
                        <a href="<?= $br['href']; ?>" class="breadcrumb__link">
                            <?= $br['text']; ?>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- END: breadcrumb -->

    <!-- BEGIN: contacts -->
    <section class="contacts contacts--contacts container">
        <h1 class="contacts__title"><?= $heading_title; ?></h1>
        <div class="row contacts__info">
        <!-- BEGIN: left column -->
            <div class="contacts__left-holder col-xl-4 col-lg-5 col-md-6 col-sm-6 col-12 offset-xl-2 offset-lg-1">
                <h6 class="contacts__caption"><?php echo $text_contact_info; ?></h6>
                <div class="row">
                    <div class="col-12 contacts__text"><?= $text_location; ?></div>
                    <div class="col-12 contacts__text"><a class="address" href="/contacts/#map"><?= $address; ?></a></div>
 					<?php if ($open): ?>
                      <div class="col-12 contacts__text"><?= $text_open; ?></div>
                      <div class="col-12 contacts__text"><?= $open; ?><br><?= $open2; ?></div>
  
					  <?php endif; ?>

                    <div class="col-12 contacts__text"><?= $text_el_email; ?></div>
                    <div class="col-12 contacts__text"><a href="mailto:<?= $email_contact; ?>"><?= $email_contact; ?></a></div>
                    <div class="col-12 contacts__text"><?= $text_telephone; ?></div>
                    <div class="col-12 contacts__text"><?php foreach($phones as $phone2): ?>
                      <a href="tel:<?= trim($phone2); ?>"><?= trim($phone2); ?></a>
                      <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <!-- END: left column -->

        <!-- BEGIN: right column -->
            <div class="contacts__right-holder col-xl-4 col-lg-5 col-md-6 col-sm-6 col-12 contacts-form">
                <h6 class="contacts__caption contacts__caption--margin"><?php echo $text_contact; ?></h6>
                <form id="contactForm" method="post" enctype="multipart/form-data" class="form-horizontal row">
                    <input type="hidden" name="contact_status" value="<?php echo $contact_status; ?>" />
                    <div class="contacts__input-holder col-12">
                        <input class="contacts__input<?= !empty($name)? ' valid': '';?>" type="text" name="cl_name" value="<?php echo $name; ?>" data-error=".error1"/>
                        <label class="has"><?php echo $entry_name; ?></label>
                        <span class="highlight"></span>
                        <span class="bar"></span>

                        <div class="errors-fields error1"><?= $error_name; ?></div>

                    </div>
                    <div class="contacts__input-holder col-12">
                        <input class="contacts__input<?= !empty($email)? ' valid': '';?>" type="email"name="cl_email" value="<?php echo $email; ?>" data-error=".error2"/>
                        <label class="has"><?php echo $entry_email; ?></label>
                        <span class="highlight"></span>
                        <span class="bar"></span>

                        <div class="errors-fields error2"><?= $error_email; ?></div>

                    </div>
                    <div class="contacts__input-holder col-12">
                        <input class="contacts__input<?= !empty($phone)? ' valid': '';?>" name="cl_phone" id="phone" value="<?php echo $phone; ?>" type="tel" name="phone" data-error=".error3"/>
                        <label class="has"><?php echo $entry_phone; ?></label>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <div class="error3"><?= $error_phone; ?></div>
                    </div>
                    <div class="contacts__input-holder col-12">
                        <textarea class="contacts__input<?= !empty($enquiry)? ' valid': '';?>" name="cl_enquiry" cols="30" rows="1"  data-error=".error4"><?php echo $enquiry; ?></textarea>
                        <label class="has4"><?php echo $entry_enquiry; ?></label>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <div class="errors-fields error4"><?= $error_enquiry; ?></div>
                    </div>
                    <?php echo $captcha; ?>
                    <div class="contacts__input-holder col-12">
                        <input class="btn btn--sendMess contacts__btn" type="submit" value="<?= $text_send_message; ?>" />
                    </div>
                </form>
            </div>
        <!-- END: right column -->
        </div>
    </section>
    <!-- END: contacts -->
    <section id="map" class="map"></section>
</main>
<?php echo $footer; ?>
