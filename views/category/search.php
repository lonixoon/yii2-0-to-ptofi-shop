<?php

/* @var $this yii\web\View */

use app\components\MenuWidget;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

?>

<section id="advertisement">
    <div class="container">
        <img src="/images/shop/advertisement.jpg" alt="">
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Категории</h2>
                    <!--Начало: виждет меню категорий-->
                    <ul class="catalog category-products">
                        <?= MenuWidget::widget(['tpl' => 'menu']) ?>
                    </ul>
                    <!--Конец: виждет меню категорий-->

                    <div class="price-range"><!--price-range-->
                        <h2>Фильтр по цене</h2>
                        <div class="well">
                            <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600"
                                   data-slider-step="5" data-slider-value="[250,450]" id="sl2"><br>
                            <b>$ 0</b> <b class="pull-right">$ 600</b>
                        </div>
                    </div><!--/price-range-->

                    <div class="shipping text-center"><!--shipping-->
                        <img src="/images/home/shipping.jpg" alt="">
                    </div><!--/shipping-->

                </div>
            </div>

            <!--Начло: вывод товаров-->
            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Поиск по запросу: <?= Html::encode($search) ?></h2>
                    <?php if (!empty($products)): ?>
                        <?php $i = 0;
                        foreach ($products as $product): ?>
                            <?php // получаем гланое изображение кажтого итема
                            $mainImg = $product->getImage();
                            $i++;
                            if ($i % 3 == 0): ?>
                                <div class="row">
                            <?php endif; ?>
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <?= Html::img($mainImg->getUrl('268x249'), ['alt' => $product->name]) ?>
                                            <h2>$<?= $product->price ?></h2>
                                            <p>
                                                <a href="<?= Url::to(['product/view', 'id' => $product->id]) ?>"><?= $product->name ?></a>
                                            </p>
                                            <a href="#" data-id="<?= $product->id ?>"
                                               class="btn btn-default add-to-cart"><i
                                                        class="fa fa-shopping-cart"></i>Add to cart</a>
                                        </div>
                                        <!--выводим новинка и хит продаж по условию-->
                                        <?php if ($product->new): ?>
                                            <?= Html::img("@web/images/home/new.png",
                                                ['alt' => 'Новинка', 'class' => 'new']) ?>
                                        <?php endif; ?>
                                        <?php if ($product->sale): ?>
                                            <?= Html::img("@web/images/home/sale.png",
                                                ['alt' => 'Распродажа', 'class' => 'new']) ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php if ($i % 3 == 0): ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h2>Товаров не найдено</h2>
                    <?php endif; ?>
                </div>
                <?php if ($pagination): ?>
                    <?= LinkPager::widget(['pagination' => $pagination,]); ?>
                <?php endif; ?>
                <!--Начло: вывод товаров-->
            </div>
        </div>
    </div>
</section>