<?php

use app\components\MenuWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <? //= $form->field($model, 'parent_id')->textInput() ?>

<!--штатный список select для категорий-->
    <? //= // делаем вывод списком всех доступных категории
    //    $form->field($model, 'parent_id')->dropDownList(
    //        \yii\helpers\ArrayHelper::map(\app\models\Category::find()->all(),
    //            'id', 'name')
    //    ) ?>

<!--наш кастомный список select для категорий-->
    <div class="form-group field-category-parent_id has-success">
        <label class="control-label" for="category-parent_id">Главная</label>
        <select id="category-parent_id" class="form-control" name="Category[parent_id]" aria-invalid="false">
            <option value="0">Главная</option>
            <?= MenuWidget::widget(['tpl' => 'select', 'model' => $model]) ?>
        </select>
    </div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
