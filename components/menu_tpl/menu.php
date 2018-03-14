<?php

use yii\helpers\Url;

?>

<!--создаём родительскую категорию-->
<li>
    <a href="<?= Url::to(['category/view', 'id' => $category['id']]) ?>">
        <?= $category['name'] ?>
        <!--если существуют потом добавляем плюсик для раскрытия списка-->
        <?php if (isset($category['childs'])): ?>
            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
        <?php endif; ?>
    </a>
    <!--если есть потомки делаем вложенный список-->
    <?php if (isset($category['childs'])): ?>
        <ul>
            <?= $this->getMenuHtml($category['childs']) ?>
        </ul>
    <?php endif; ?>
</li>



