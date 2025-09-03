<?php echo $header; ?>

    <main class="main main--contacts">
		<?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
		<?php } ?>

		<?php if ($error_warning) { ?>
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i>
				<?php echo $error_warning; ?></div>
		<?php } ?>


        <!-- BEGIN: contacts -->
        <section class="contacts contacts--login container animated">
            <!-- BEGIN: breadcrumb -->
            <div class="category d-xl-block d-lg-block d-md-block d-none">
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


            <h1 class="contacts__title"><?= $heading_title; ?></h1>
            <div class="row contacts__info">
                <!-- BEGIN: left column -->
                <div class="contacts__left-holder contacts__left-holder--signin col-xl-4 col-lg-5 col-md-6 col-sm-6 col-12 offset-xl-2 offset-lg-1">
                    <h6 class="contacts__caption contacts__caption--auth  contacts__caption--signin"><?= $text_account; ?></h6>
                    <div class="row text-holder text-holder--signin">
                        <p class="text col-12">
							<?= $text_i_am_returning_customer; ?>
                        </p>
                    </div>

                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="contactForm" class="row row--signin" >
                        <input type="hidden" name="sect" value="login">

                        <div class="contacts__input-holder col-12">
                            <input class="contacts__input" type="email" name="email" value="<?php echo $email; ?>" id="input-email" data-error=".errorLogin1"/>
                            <label class="has align--2"><?= $entry_email; ?></label>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <div class="errorLogin1"></div>
                        </div>
                        <div class="contacts__input-holder col-12">
                            <input class="contacts__input" type="password" name="password" value="<?php echo $password; ?>" id="pass" data-error=".errorLogin2"/>
                            <label class="has align--2"><?= $entry_password; ?></label>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <div class="errorLogin2"></div>
                            <span id="passVisible" class="contacts__pass-visible"><i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="18.969" height="12" viewBox="0 0 18.969 12">
                            <metadata>
                                <x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.6-c142 79.160924, 2017/07/13-01:06:39        ">
                                    <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
                                        <rdf:Description rdf:about=""/>
                                    </rdf:RDF>
                                </x:xmpmeta>
                                </metadata>
                            <path id="eye" class="cls-1" d="M883.878,920.634c-0.169-.23-4.214-5.634-9.379-5.634s-9.209,5.4-9.379,5.634a0.615,0.615,0,0,0,0,.732c0.17,0.23,4.214,5.634,9.379,5.634s9.21-5.4,9.379-5.634A0.615,0.615,0,0,0,883.878,920.634Zm-9.379,5.125c-3.805,0-7.1-3.587-8.075-4.76,0.974-1.173,4.262-4.758,8.075-4.758s7.1,3.586,8.076,4.759C881.6,922.174,878.312,925.759,874.5,925.759Zm0-8.483A3.724,3.724,0,1,0,878.257,921,3.745,3.745,0,0,0,874.5,917.276Zm0,6.207A2.483,2.483,0,1,1,877.005,921,2.5,2.5,0,0,1,874.5,923.483Z" transform="translate(-865.031 -915)"/>
                        </svg></i></span>
                            <a href="<?= $forgotten; ?>" class="forget-pass"><?= $text_forgotten; ?></a>
                        </div>

						<?php if ($redirect) { ?>
                            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
						<?php } ?>

                        <div class="contacts__input-holder col-12">
                            <input class="btn btn--authPage btn--signin" type="submit" value="<?= $text_login; ?>" />
                        </div>
                    </form>
                </div>
                <!-- END: left column -->

                <!-- BEGIN: right column -->
                <div class="contacts__right-holder contacts__right-holder--signin col-xl-4 col-lg-5 col-md-6 col-sm-6 col-12">
                    <h6 class="contacts__caption contacts__caption--auth contacts__caption--reg"><?= $text_new_customer; ?></h6>
                    <div class="row text-holder">
                        <p class="text col-12">
							<?= $text_register_account; ?>
                        </p>
                    </div>
                    <div class="contacts__input-holder col-12">
                        <button id="createUserButton" class="btn btn--authPage btn--createUser"><span class="text"><?= $text_new_customer; ?></span></a>
                    </div>
                </div>
                <!-- END: right column -->
            </div>
        </section>
        <!-- END: contacts -->

        <section class="contacts contacts--register container animated translated">
            <!-- BEGIN: breadcrumb -->
            <div class="category container d-xl-block d-lg-block d-md-block d-none">
                <div class="row">
                    <div class="col-12">

                        <ul class="breadcrumb contacts__breadcrumb">
							<?php foreach($breadcrumbs2 as $bk => $br): ?>
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

            <h1 class="contacts__title contacts__title--signup"><?= $reg_heading_title; ?></h1>
            <div class="row contacts__info">

            </div>
            <div class="row contacts__info justify-content-center">

                <!-- BEGIN: right column -->
                <div class="contacts__right-holder contacts__right-holder--signup col-xl-8 col-lg-10 col-12 offset-xl-3 offset-lg-1">
                    <div class="row">
                        <div class="contacts__title-holder col-12">
                            <div class="row">
                                <span id="loginUserButton" class="contacts__signin col-xl-1 col-lg-1 col-md-1 col-12"><?= $reg_text_account; ?></span>
                                <h6 class="contacts__caption contacts__caption--register col-xl-10 col-lg-10 col-md-9 col-12"><?= $reg_text_register; ?></h6>
                            </div>
                        </div>
                        <p class="text text--signup">
							<?= $reg_text_head_info; ?>
                        </p>

						<?php if(!empty($reg_error_warning)): ?>
                            <p style='border-radius: 5px;width: 100%;text-align: center;height: 50px;padding: 11px 0px 0px 0px;color: #fff;background: #d82525;'><?= $reg_error_warning; ?></p>
						<?php endif; ?>
                    </div>
                    <form class="row" id="contactFormRegister" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" >
                        <input type="hidden" name="sect" value="register">
                        <div class="contacts__input-holder contacts__input-holder--signup">
                            <input class="contacts__input" type="text" name="firstname" value="<?php echo $reg_firstname; ?>" data-error=".error3"/>
                            <label class="has align--1"><?php echo $reg_entry_firstname; ?></label>
                            <span class="highlight"></span>
                            <span class="bar"></span>

                            <div class="errors-fields error3"><?php echo $reg_error_firstname; ?></div>

                        </div>
                        <div class="contacts__input-holder contacts__input-holder--signup">
                            <input class="contacts__input" name="lastname" value="<?php echo $reg_lastname; ?>" type="text" data-error=".error4"/>
                            <label class="has align--1"><?php echo $reg_entry_lastname; ?></label>
                            <span class="highlight"></span>
                            <span class="bar"></span>

                            <div class="errors-fields error4"><?php echo $reg_error_lastname; ?></div>

                        </div>
                        <div class="contacts__input-holder contacts__input-holder--signup">
                            <input class="contacts__input" name="telephone" value="<?php echo $reg_telephone; ?>" id="phone" type="tel" data-error=".error5"/>
                            <label class="has align--3"><?php echo $reg_entry_telephone; ?></label>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <div class="errors-fields error5"><?php echo $reg_error_telephone; ?></div>
                        </div>
                        <div class="contacts__input-holder contacts__input-holder--signup">
                            <input class="contacts__input" type="email" name="email" value="<?php echo $reg_email; ?>" data-error=".error6"/>
                            <label class="has align--2"><?php echo $reg_entry_email; ?></label>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <div class="errors-fields error6"><?php echo $reg_error_email; ?></div>
                        </div>
                        <div class="contacts__input-holder contacts__input-holder--signup">
                            <input id="registerPass" class="contacts__input" type="password" name="password" value="<?php echo $reg_password; ?>" data-error=".error7"/>
                            <label class="has align--2"><?php echo $reg_entry_password; ?></label>
                            <span class="highlight"></span>
                            <span class="bar"></span>

                            <div class="errors-fields error7"><?php echo $reg_error_password; ?></div>

                            <span id="r-passVisible" class="contacts__pass-visible"><i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="18.969" height="12" viewBox="0 0 18.969 12">
                          <metadata>
                              <x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.6-c142 79.160924, 2017/07/13-01:06:39        ">
                                  <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
                                      <rdf:Description rdf:about=""/>
                                  </rdf:RDF>
                              </x:xmpmeta>
                          </metadata>
                          <path id="eye" class="cls-1" d="M883.878,920.634c-0.169-.23-4.214-5.634-9.379-5.634s-9.209,5.4-9.379,5.634a0.615,0.615,0,0,0,0,.732c0.17,0.23,4.214,5.634,9.379,5.634s9.21-5.4,9.379-5.634A0.615,0.615,0,0,0,883.878,920.634Zm-9.379,5.125c-3.805,0-7.1-3.587-8.075-4.76,0.974-1.173,4.262-4.758,8.075-4.758s7.1,3.586,8.076,4.759C881.6,922.174,878.312,925.759,874.5,925.759Zm0-8.483A3.724,3.724,0,1,0,878.257,921,3.745,3.745,0,0,0,874.5,917.276Zm0,6.207A2.483,2.483,0,1,1,877.005,921,2.5,2.5,0,0,1,874.5,923.483Z" transform="translate(-865.031 -915)"/>
                      </svg></i></span>
                        </div>

                        <div class="contacts__input-holder contacts__input-holder--checkbox">
                            <div class="row justify-content-between">
                                <div class="contacts__c-holder col-xl-6 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
                                    <div class="checkbox">
                                        <input id="subscribe-input" name="newsletter" value="1" class="checkbox__core" type="checkbox" checked/>
                                        <label for="subscribe-input" class="checkbox__control"><i class="icon"></i></label>
                                    </div>
                                    <p class="contacts__subscribe">
										<?= $reg_text_newsletter; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="contacts__input-holder contacts__input-holder--btn">
                            <input class="btn btn btn--authPage btn--register" type="submit" value="<?= $reg_text_register; ?>" />
                        </div>
                    </form>
                </div>
                <!-- END: right column -->
            </div>

        </section>
    </main>

<?php echo $footer; ?>