<?php

use yii\helpers\Html;

?>
<!--если корзина не пустая-->
<?php if (!empty($session['cart'])): ?>
    <!--выводим таблицу-->
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>Фото</th>
                <th>Наименование</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <!--    удалить предмет из карзины-->
                <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
            </tr>
            </thead>
            <tbody>
            <!--циклом выводим информация о товарах-->

            <?php foreach ($session['cart'] as $id => $item): ?>
                <!--потребуется id товара и информация-->
                <tr>
                    <!--по скольку работаем с сессиями выводим массив а не объект-->
                    <td><?= Html::img($item['img'], ['alt' => $item['name']]) ?></td>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['qty'] ?></td>
                    <td><?= $item['price'] ?></td>
                    <td><span data-id="<?= $id ?>" class="glyphicon glyphicon-remove text-danger del-item"
                              aria-hidden="true"></span></td>
                </tr>
            <?php endforeach ?>
            <tr>
                <td colspan="4">Итого:</td>
                <td><?= $session['cart.qty'] ?></td>
            </tr>
            <tr>
                <td colspan="4">На сумму:</td>
                <td><?= $session['cart.sum'] ?></td>
            </tr>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <h3>Корзина пуста</h3>
<?php endif; ?>
