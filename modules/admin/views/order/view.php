<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Order */

$this->title = '№' . $model->id . ' заказ';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1>Просмотр заказа №<?= $model->id ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'updated_at',
            'qty',
            'sum',
//            'status',
        // делаем вывод заказа вместо 0,1 = Активен,Завершен
            [
                'attribute' => 'status',
                'value' => !$model->status ? '<span class="text-danger">Активен</span>' : '<span class="text-success">Завершен</span>',
                'format' => 'html',
            ],
            'name',
            'email:email',
            'phone',
            'address',
        ],
    ]) ?>


    <?php // заводим переменную под наше виртуальное свойство orderItems (вызывается из связанной таблицы)
    $items = $model->orderItems; ?>
    <!--Вставляем шаблон корзины для вывода товаров в просмотре заказа-->
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>Наименование</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <th>Сумма</th>
            </tr>
            </thead>
            <tbody>
            <?php // выводем все содежимое из свзи и перебеоаем его циклом
            foreach ($items as $item): ?>
                <tr>
                    <!--Выводим название товара и сслку на него (ссылку прописывать обсалютно! т.к. мы в админке)-->
                    <td>
                        <a href="<?= Url::to(['/product/view', 'id' => $item->product_id]) ?>"><?= $item['name'] ?></a>
                    </td>
                    <!--Количество товара-->
                    <td><?= $item['qty_item'] ?></td>
                    <!--Цена за единицу-->
                    <td><?= $item['price'] ?></td>
                    <!--Цена общая-->
                    <td><?= $item['sum_item'] ?></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>

</div>
