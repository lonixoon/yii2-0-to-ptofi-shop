<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<div class="container">
    <!--    НАЧАЛО: Выводм сообщение об успешном оформлении заказа -->
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>
    <!--    КОНЕЦ: Выводм сообщение об успешном оформлении заказа -->

    <!--    НАЧАЛО: Выводм сообщение об ошибке при оформлении заказа -->
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('error'); ?>
        </div>
    <?php endif; ?>
    <!--    КОНЕЦ: Выводм сообщение об ошибке при оформлении заказа -->

    <!--    НАЧАЛО: выводим нашу корзину-->
    <?php if (!empty($session['cart'])): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>Фото</th>
                    <th>Наименование</th>
                    <th>Кол-во</th>
                    <th>Цена</th>
                    <th>Сумма</th>
                    <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
                </tr>
                </thead>
                <tbody>

                <!--НАЧАЛО: Берём все что есть в массиве корзина внутри сессии-->
                <?php foreach ($session['cart'] as $id => $item): ?>
                    <tr>
                        <td><?= Html::img("@web/images/product/{$item['img']}", ['alt' => $item['name'], 'height' => 50]) ?></td>
                        <td><a href="<?= Url::to(['product/view', 'id' => $id]) ?>"><?= $item['name'] ?></a></td>
                        <td><?= $item['qty'] ?></td>
                        <td><?= $item['price'] ?></td>
                        <td><?= $item['qty'] * $item['price'] ?></td>

                        <!--НАЧАЛО: Удалить товар из корзины-->
                        <td><span data-id="<?= $id ?>" class="glyphicon glyphicon-remove text-danger del-item"
                                  aria-hidden="true"></span></td>
                        <!--КОНЕЦ: Удалить товар из корзины-->

                    </tr>
                <?php endforeach ?>
                <!--КОНЕЦ: Берём все что есть в массиве корзина внутри сессии-->

                <tr>
                    <td colspan="5">Итого:</td>
                    <td><?= $session['cart.qty'] ?></td>
                </tr>
                <tr>
                    <td colspan="5">На сумму:</td>
                    <td><?= $session['cart.sum'] ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <hr/>

        <!--НАЧАЛО: Вывдом форму заказа-->
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($order, 'name') ?>
        <?= $form->field($order, 'email')->input('email'); ?>
        <?= $form->field($order, 'phone') ?>
        <?= $form->field($order, 'address') ?>
        <?= Html::submitButton('Заказать', ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end() ?>
        <!--КОНЕЦ: Вывдом форму заказа-->

    <?php else: ?>
        <h3>Корзина пуста</h3>
    <?php endif; ?>
    <!--КОНЕЦ: выводим нашу корзину-->
</div>