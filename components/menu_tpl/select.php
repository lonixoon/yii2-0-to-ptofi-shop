<option value="<?= $category['id'] ?>" <?php
// если id категории совпадёт с полем parent_id категории которая сечас редактируется
// добавляем на ней selected что бы выбралась родительская катеригия из списка по умолчанию
if ($category['id'] == $this->model->parent_id) echo ' selected' ?>
    <?php
    // если id категории совпадёт с полем id категории которая сечас редактируется
    // добавляем на ней disabled что бы категорию нельзя было выбрать
    if ($category['id'] == $this->model->id) echo ' disabled' ?>
><?= $tab . $category['name'] ?></option>
<!--если есть потомки делаем вложенный список-->
<?php if (isset($category['childs'])): ?>
    <ul>
        <?= $this->getMenuHtml($category['childs'], $tab . '|--> ') ?>
    </ul>
<?php endif; ?>