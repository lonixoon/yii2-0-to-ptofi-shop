<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'category_id',
            [
                // получаем вместо id категории её название из взязи с таблицей category
                'attribute' => 'category_id',
                'value' => function ($data) {
                    return $data->category->name;
                }

            ],
            'name',
//            'content:ntext',
            'price',
//            'keywords',
//            'description',
            //'img',
            [
                // получаем вместо id категории её название из взязи с таблицей category
                'attribute' => 'hit',
                'value' => function ($data) {
                    return $data->hit ? '<span class="text-success">Да</span>' : '<span class="text-danger">Нет</span>';
                },
                'format' => 'html',

            ],
            [
                // получаем вместо id категории её название из взязи с таблицей category
                'attribute' => 'new',
                'value' => function ($data) {
                    return $data->new ? '<span class="text-success">Да</span>' : '<span class="text-danger">Нет</span>';
                },
                'format' => 'html',

            ],
            [
                // получаем вместо id категории её название из взязи с таблицей category
                'attribute' => 'sale',
                'value' => function ($data) {
                    return $data->sale ? '<span class="text-success">Да</span>' : '<span class="text-danger">Нет</span>';
                },
                'format' => 'html',

            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
