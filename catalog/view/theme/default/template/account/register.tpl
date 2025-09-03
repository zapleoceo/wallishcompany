<?php echo $header; ?>
<main class="main">
    <!-- BEGIN: contacts -->
    <section class="contacts contacts--register container animated">
        <h1 class="contacts__title"><?= $heading_title; ?></h1>
        <div class="row contacts__info">

        </div>
        <div class="row contacts__info justify-content-center">

            <!-- BEGIN: right column -->
            <div class="contacts__right-holder col-xl-7 col-lg-8 col-12 offset-xl-3 offset-lg-2">
                <div class="contacts__input-holder row">
                    <div class="contacts__title-holder col-12">
                        <div class="row">
                            <span id="loginUserButton" class="contacts__signin col-xl-1 col-lg-1 col-md-1 col-12"><?= $text_account; ?></span>
                            <h6 class="contacts__caption contacts__caption--register col-xl-10 col-lg-10 col-md-10 col-12"><?= $text_account_already; ?></h6>
                        </div>
                    </div>
                    <p class="text text--signup col-12">
                        <?= $text_head_info; ?>
                    </p>

                    <?php if(!empty($error_warning)): ?>
                    <p style='border-radius: 5px;width: 100%;text-align: center;height: 50px;padding: 11px 0px 0px 0px;color: #fff;background: #d82525;'><?= $error_warning; ?></p>
                    <?php endif; ?>
                </div>
                <form class="row" id="contactForm" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" >
                    <div class="contacts__input-holder col-xl-6 col-lg-6 col-md-6 col-sm-10 col-12
                    offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
                        <input class="contacts__input" type="text" name="firstname" value="<?php echo $firstname; ?>" data-error=".error1"/>
                        <label class="has align--1"><?php echo $entry_firstname; ?></label>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <?php if ($error_firstname) { ?>
                            <div class="error1"><?php echo $error_firstname; ?></div>
                        <?php } ?>
                    </div>
                    <div class="contacts__input-holder col-xl-6 col-lg-6 col-md-6 col-sm-10 col-12
                    offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
                        <input class="contacts__input" name="lastname" value="<?php echo $lastname; ?>" type="text" data-error=".error2"/>
                        <label class="has align--1"><?php echo $entry_lastname; ?></label>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <?php if ($error_lastname) { ?>
                            <div class="error2"><?php echo $error_lastname; ?></div>
                        <?php } ?>
                    </div>
                    <div class="contacts__input-holder col-xl-6 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
                        <input class="contacts__input" name="telephone" value="<?php echo $telephone; ?>" id="phone" type="text" data-error=".error3"/>
                        <label class="has align--3"><?php echo $entry_telephone; ?></label>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <?php if ($error_telephone) { ?>
                            <div class="error3"><?php echo $error_telephone; ?></div>
                        <?php } ?>
                    </div>
                    <div class="contacts__input-holder col-xl-6 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
                        <input class="contacts__input" type="email" name="email" value="<?php echo $email; ?>" data-error=".error4"/>
                        <label class="has align--2"><?php echo $entry_email; ?></label>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <?php if ($error_email) { ?>
                            <div class="error4"><?php echo $error_email; ?></div>
                        <?php } ?>
                    </div>
                    <div class="contacts__input-holder col-xl-6 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
                        <input id="pass" class="contacts__input" type="password" name="password" value="<?php echo $password; ?>" data-error=".error5"/>
                        <label class="has align--2"><?php echo $entry_password; ?></label>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <?php if ($error_password) { ?>
                            <div class="error5"><?php echo $error_password; ?></div>
                        <?php } ?>
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
                    </div>

                    <div class="contacts__input-holder col-12">
                        <div class="row justify-content-between">
                            <div class="contacts__c-holder col-xl-6 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
                                <div class="checkbox">
                                    <input id="subscribe-input" name="newsletter" value="1" class="checkbox__core" type="checkbox"/>
                                    <label for="subscribe-input" class="checkbox__control"><i class="icon"></i></label>
                                </div>
                                <p class="contacts__subscribe">
                                    <?= $text_newsletter; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="contacts__input-holder col-xl-6 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-4 offset-0">
                        <input class="btn contacts__btn" type="submit" value="<?= $text_register; ?>" />
                    </div>
                </form>
            </div>
            <!-- END: right column -->
        </div>

    </section>
    <!-- END: contacts -->

</main>
<?php echo $footer; ?>
