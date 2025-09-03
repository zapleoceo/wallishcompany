<?php echo $header; ?>

<main class="main">
    <!-- BEGIN: account -->
    <section class="account container">
        <h1 class="account__title">Персональный аккаунт</h1>
        <div class="row">

            <!-- BEGIN: sidebar-->
            <?= $account_menu; ?>
            <!-- END: sidebar -->

            <div class="col-xl-9 col-lg-9 col-12">

                <div class="row align">

                    <!-- BEGIN: content -->
                    <div class="delivery col-12">
                        <div class="row">
                            <h4 class="delivery__title col-12">Мои карты</h4>
                            <div class="delivery__btn-holder">
                                <button id="addCard" class="btn"><span class="text">Добавить карту</span></button>
                            </div>
                            <!-- BEGIN: ukraine address -->
                            <form class="delivery__data-holder col-7" method="post" action="index.php?route=account/address/mycards_save" id="addCardForm"<?= !empty($errors) ? ' style="display: block; height: initial;"' : ''; ?>>
                                <input type="hidden" name="id" id="card_id" value="0">
                                <div class="wrapper"<?= !empty($errors) ? ' style="opacity: 1;"' : ''; ?>>
                                    <span class="close" id="closeCardEditing"></span>
                                    <div class="col-12">
                                        <div class="contacts">
                                            <div class="contacts__input-holder ">
                                                <select name="type" class="contacts__input contacts__input--select" name="cardType" id="cardType" data-error=".error0">
                                                    <option value="visa"<?= isset($last['type']) ? ($last['type'] == 'visa') ? ' selected' : '' : ''; ?>>Visa</option>
                                                    <option value="master"<?= isset($last['type']) ? ($last['type'] == 'master') ? ' selected' : '' : ' selected'; ?>>Mastercard</option>
                                                </select>
                                                <label class="select has align--1">Выбрать тип карты</label>
                                                <label class="control" for="cardType"><i class="icon"></i></label>
                                                <span class="highlight"></span>
                                                <span class="bar"></span>
                                                <div class="error0"><?= isset($errors['type'])? $errors['type'] : ''; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="contacts contacts__input-holder">
                                            <input class="contacts__input" type="text" value="<?= isset($last['number']) ? $last['number'] : '' ?>" name="number" data-error=".error1"/>
                                            <label class="has">Номер карточки</label>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <div class="error1"><?= isset($errors['number'])? $errors['number'] : ''; ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="contacts contacts__input-holder">
                                            <input class="contacts__input" type="text"value="<?= isset($last['date']) ? $last['date'] : '' ?>" name="date" data-error=".error2"/>
                                            <label class="has">Дата действия карты</label>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <div class="error2"><?= isset($errors['date'])? $errors['date'] : ''; ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="contacts contacts__input-holder">
                                            <input class="contacts__input" type="text" value="<?= isset($last['cvv']) ? $last['cvv'] : '' ?>" name="cvv" data-error=".error3"/>
                                            <label class="has">CVV код</label>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <div class="error3"><?= isset($errors['cvv'])? $errors['cvv'] : ''; ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="contacts contacts__input-holder">
                                            <input class="contacts__input" type="text" value="<?= isset($last['name']) ? $last['name'] : '' ?>" name="name" data-error=".error4"/>
                                            <label class="has">Имя</label>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <div class="error4"><?= isset($errors['name'])? $errors['name'] : ''; ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="contacts contacts__input-holder">
                                            <input class="contacts__input" value="<?= isset($last['lastname']) ? $last['lastname'] : '' ?>" type="text" name="lastname" data-error=".error5"/>
                                            <label class="has">Фамилия</label>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <div class="error5"><?= isset($errors['lastname'])? $errors['lastname'] : ''; ?></div>
                                        </div>
                                    </div>
                                    <div class="d-card__control-holder">
                                        <div class="checkbox">

                                            <input id="subscribe-input_card" name="isdefault" value="1" class="checkbox__core" type="checkbox" <?= isset($last['isdefault']) ? ($last['isdefault'] == 1) ? ' checked' : '' : ''; ?>/>
                                            <label for="subscribe-input_card" class="checkbox__control checkbox__control--card"><i class="icon"></i></label>

                                        </div>
                                        <p class="d-card__c-text d-card__c-text--editForm">
                                            <span class="text">Установить картой по умолчанию</span>
                                        </p>
                                    </div>
                                    <div class="delivery__btn-holder">
                                        <button type="submit" id="addDelivery" class="btn btn--editForm"><span class="text">Сохранить</span></button>
                                    </div>
                                </div>
                            </form>
                            <!-- END: ukraine address -->

                            <?php if (!empty($cards)): ?>
                                <?php foreach($cards as $card): ?>
                                    <!-- BEGIN: d-card -->
                                    <div data-card='<?= $card['json_data']; ?>' class="d-card delivery__d-card col-5 d-card--credit" id="d-card_<?= $card['id']; ?>">

                                        <?php if ($card['type'] == 'master'): ?>
                                        <div class="d-card__type-icon" data-type="mastercard">
                                            <i class="icon"></i>
                                        </div>
                                        <?php endif; ?>

                                        <?php if ($card['type'] == 'visa'): ?>
                                        <div class="d-card__type-icon" data-type="visa">
                                            <i class="icon"></i>
                                        </div>
                                        <?php endif; ?>

                                        <div class="d-card__card-number">
                                            <input class="d-card__pairs first" type="text" name="fst-pairs" placeholder="XXXX" maxlength="4" pattern="\d*" readonly value="<?= $card['number_parts'][0]; ?>"/>
                                            <input class="d-card__pairs second" type="text" name="s-pairs" placeholder="XXXX" maxlength="4" pattern="\d*" readonly value="<?= $card['number_parts'][1]; ?>"/>
                                            <input class="d-card__pairs third" type="text" name="t-pairs" placeholder="XXXX" maxlength="4" pattern="\d*" readonly value="<?= $card['number_parts'][2]; ?>"/>
                                            <input class="d-card__pairs fourth" type="text" name="frth-pairs" placeholder="XXXX" maxlength="4" pattern="\d*" readonly value="<?= $card['number_parts'][3]; ?>"/>
                                            <input class="d-card__c-n-input" type="hidden" name="card-number" value="<?= $card['number']; ?>"/>
                                        </div>
                                        <div class="d-card__control-holder">
                                            <button class="d-control edit" id="0" data-edit="Редактировать" data-save="Сохранить">Редактировать</button>
                                            <button class="d-control remove" id="0" data-language="Удалить">Удалить</button>
                                        </div>
                                        <div class="d-card__control-holder">
                                            <div class="checkbox">
                                                <input id="subscribe-input_<?= $card['id']; ?>" class="checkbox__core" type="checkbox" <?= ($card['isdefault'] == 1) ? ' checked' : ''; ?>/>
                                                <label for="subscribe-input_<?= $card['id']; ?>" class="checkbox__control checkbox__control--card"><i class="icon"></i></label>
                                            </div>
                                            <p class="d-card__c-text">
                                                <span class="text">Установить адресом по умолчанию</span>
                                            </p>
                                        </div>
                                    </div>
                                    <!-- END: d-card -->
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                        <!-- END: left column -->
                    </div>

                </div>


            </div>
    </section>
    <!-- END: account -->
</main>

<?php echo $footer; ?>