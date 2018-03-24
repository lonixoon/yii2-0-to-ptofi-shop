<?php

use app\components\MenuWidget;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;

// При встраивание без iframe возможен конфликт с bootstrap.js. Studio-42/elFinder#740
// Решение - добавляем в шаблон запись
mihaildev\elfinder\Assets::noConflict($this);

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">


    <?php // добавляем в форму возможность загрузки файлов (options - 'enctype' => 'multipart/form-data')
    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <? //= $form->field($model, 'category_id')->textInput() ?>

    <!--наш кастомный список select для категорий-->
    <div class="form-group field-product-category_id has-success">
        <select id="product-category_id" class="form-control" name="Product[parent_id]" aria-invalid="false">
            <option value="0">Главная</option>
            <?= // певый параметр какой шаблон использовать, стром передаём данные
            MenuWidget::widget(['tpl' => 'select_product', 'model' => $model]) ?>
        </select>
    </div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    <?php //echo $form->field($model, 'content')->widget(CKEditor::className(), [
    //            'editorOptions' => [
    //                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
    //                'inline' => false, //по умолчанию false
    //            ],
    //        ]); ?>

<?php //// прикручивае визульный редактор и файловый менеджер
//    echo $form->field($model, 'content')->widget(CKEditor::className(), [
//        'editorOptions' => ElFinder::ckeditorOptions(
//            [
//                'elfinder',
//                // допонительный путь по умолчанию
////                'path' => 'some/sub/path'
//            ],
//            [
//                'preset' => 'standard', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
//                'inline' => false, //по умолчанию false
//            ]
//        ),
//    ]); ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>


    <?= // загрузка главной картинки
    $form->field($model, 'image')->fileInput() ?>

    <?= // загрузка не основных картинок (галлерея)
    $form->field($model, 'gallery[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>


    <?= $form->field($model, 'hit')->checkbox(['0', '1',]) ?>

    <?= $form->field($model, 'new')->checkbox(['0', '1',]) ?>

    <?= $form->field($model, 'sale')->checkbox(['0', '1',]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
