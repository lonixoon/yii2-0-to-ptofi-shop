<?php

/* @var $this yii\web\View */

use app\components\MenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>

                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-sm-6">
                                <h1><span>E</span>-SHOPPER</h1>
                                <h3>Лучшие товары, с самыми большими скидками.</h3>
<!--                                <p>Лучшие распродажи, с самым глубоким дисконтом.</p>-->
                                <button type="button" class="btn btn-default get">Get it now</button>
                            </div>
                            <div class="col-sm-6">
                                <img src="/images/home/girl1.jpg" class="girl img-responsive" alt="">
                                <img src="/images/home/pricing.png" class="pricing" alt="">
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-sm-6">
                                <h1><span>E</span>-SHOPPER</h1>
                                <h3>100% гарантия качества и только настоящие бренды</h3>
<!--                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor-->
<!--                                    incididunt ut labore et dolore magna aliqua. </p>-->
                                <button type="button" class="btn btn-default get">Get it now</button>
                            </div>
                            <div class="col-sm-6">
                                <img src="/images/home/girl2.jpg" class="girl img-responsive" alt="">
                                <img src="/images/home/pricing.png" class="pricing" alt="">
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-sm-6">
                                <h1><span>E</span>-SHOPPER</h1>
                                <h3>Все последние тенденции моды в одном месте</h3>
<!--                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor-->
<!--                                    incididunt ut labore et dolore magna aliqua. </p>-->
                                <button type="button" class="btn btn-default get">Get it now</button>
                            </div>
                            <div class="col-sm-6">
                                <img src="/images/home/girl3.jpg" class="girl img-responsive" alt="">
                                <img src="/images/home/pricing.png" class="pricing" alt="">
                            </div>
                        </div>

                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section><!--/slider-->

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Категории</h2>

                    <!--начало виждет меню категорий-->
                    <ul class="catalog category-products">
                        <?= MenuWidget::widget(['tpl' => 'menu']) ?>
                    </ul>
                    <!--конец виждет меню категорий-->



                    <div class="price-range"><!--price-range-->
                        <h2>Фильтр по цене</h2>
                        <div class="well text-center">
                            <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600"
                                   data-slider-step="5" data-slider-value="[250,450]" id="sl2"><br>
                            <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
                        </div>
                    </div><!--/price-range-->

                    <div class="shipping text-center"><!--shipping-->
                        <img src="/images/home/shipping.jpg" alt="">
                    </div><!--/shipping-->

                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <!--Начало: популярные категории-->
                <?php if (!empty($hits)): ?>
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center">Популярные товары</h2>

                        <?php // проходимся по всем Хитам
                        foreach ($hits as $hit): ?>
                            <?php // получаем изображение
                            $mainImg = $hit->getImage();?>
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <?= // выводим наше изображение
                                            Html::img($mainImg->getUrl('268x249'), ['alt' => $hit->name]) ?>
                                            <h2>$<?= $hit->price ?></h2>
                                            <p>
                                                <a href="<?= Url::to(['product/view', 'id' => $hit->id]) ?>"><?= $hit->name ?></a>
                                            </p>
                                            <a href="<?= Url::to(['cart/add', 'id' => $hit->id]) ?>" data-id="<?= $hit->id ?>" class="btn btn-default add-to-cart"><i
                                                        class="fa fa-shopping-cart"></i>Добавить</a>
                                        </div>
                                        <!--выводим новинка и хит продаж по условию-->
                                        <?php if ($hit->new): ?>
                                            <?= Html::img("@web/images/home/new.png",
                                                ['alt' => 'Новинка', 'class' => 'new']) ?>
                                        <?php endif; ?>
                                        <?php if ($hit->sale): ?>
                                            <?= Html::img("@web/images/home/sale.png",
                                                ['alt' => 'Распродажа', 'class' => 'new']) ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div><!--features_items-->
                <?php endif; ?>
                <!--Конец: популярные категории-->


                <div class="recommended_items"><!--recommended_items-->
                    <h2 class="title text-center">Рекомендованные товары</h2>

                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php $i = 0;
                            $count = count($hits);
                            foreach ($hits as $hit): ?>
                                <?php $mainImg = $hit->getImage() ?>
                                <?php if ($i % 3 == 0): ?>
                                    <div class="item <?php if ($i == 0) echo 'active' ?>">
                                <?php endif; ?>
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <?= Html::img($mainImg->getUrl('268x249'), ['alt' => $hit->name]) ?>
                                                <h2>$<?= $hit->price ?></h2>
                                                <p>
                                                    <a href="<?= Url::to(['product/view', 'id' => $hit->id]) ?>"><?= $hit->name ?></a>
                                                </p>
                                                <a href="#" data-id="<?= $hit->id ?>"
                                                   class="btn btn-default add-to-cart"><i
                                                            class="fa fa-shopping-cart"></i>Добавить</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++;
                                if ($i % 3 == 0 || $i == $count): ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <a class="left recommended-item-control" href="#recommended-item-carousel"
                           data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right recommended-item-control" href="#recommended-item-carousel"
                           data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div><!--/recommended_items-->

            </div>
        </div>
    </div>
</section>