<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Подтвердите удаление',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php // получем объект нашей картинки
    $image = $model->getImage(); ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'name',
            'content:html',
            'price',
            'keywords',
            'description',
            [
                'attribute' => 'image',
                'value' => '<img src="' . $image->getUrl() . '">',
                'format' => 'html',
            ],
            [
                'attribute' => 'hit',
                'value' => $model->hit ? 'Да' : 'Нет',
                'format' => 'html',
            ],
            [
                'attribute' => 'new',
                'value' => $model->new ? 'Да' : 'Нет',
                'format' => 'html',
            ],
            [
                'attribute' => 'sale',
                'value' => $model->sale ? 'Да' : 'Нет',
                'format' => 'html',
            ],
        ],
    ]) ?>

</div>
