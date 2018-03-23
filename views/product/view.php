<?php

/* @var $this yii\web\View */

use app\components\MenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Category</h2>
                    <!--Начало: виждет меню категорий-->
                    <ul class="catalog category-products">
                        <?= MenuWidget::widget(['tpl' => 'menu']) ?>
                    </ul>
                    <!--Конец: виждет меню категорий-->

                    <div class="brands_products"><!--brands_products-->
                        <h2>Brands</h2>
                        <div class="brands-name">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href=""> <span class="pull-right">(50)</span>Acne</a></li>
                                <li><a href=""> <span class="pull-right">(56)</span>Grüne Erde</a></li>
                                <li><a href=""> <span class="pull-right">(27)</span>Albiro</a></li>
                                <li><a href=""> <span class="pull-right">(32)</span>Ronhill</a></li>
                                <li><a href=""> <span class="pull-right">(5)</span>Oddmolly</a></li>
                                <li><a href=""> <span class="pull-right">(9)</span>Boudestijn</a></li>
                                <li><a href=""> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
                            </ul>
                        </div>
                    </div><!--/brands_products-->

                    <div class="price-range"><!--price-range-->
                        <h2>Price Range</h2>
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

            <?php // получаем все картинки продуктов
            // получаем главную картинку
            $mainImg = $product->getImage();
            // получаем остальные картинки
            $gallery = $product->getImages();
            ?>

            <div class="col-sm-9 padding-right">
                <div class="product-details"><!--product-details-->
                    <div class="col-sm-5">
                        <div class="view-product">
                            <? //= Html::img("@web/images/product/{$product->img}", ['alt' => $product->name]) ?>
                            <?= Html::img($mainImg->getUrl(), ['alt' => $product->name]) ?>

                            <h3>ZOOM</h3>
                        </div>

                        <div id="similar-product" class="carousel slide" data-ride="carousel">

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <?php $count = count($gallery);
                                // назначаем счётчик что бы определить каждый третий элемент
                                $i = 0;
                                // перебераем gallery на картинки
                                foreach ($gallery as $img): ?>
                                    <?php // если остаток от деления 0 добавляем к классу active
                                    if ($i % 3 == 0): ?>
                                        <div class="item <?php if ($i == 0) echo ' active' ?>">
                                    <?php endif; ?>
                                    <!--Выводим в цикле нашу картинку-->
                                    <a href="#"><?= Html::img($img->getUrl('84x85'), ['alt' => '']) ?></a>
                                    <?php
                                    // увиличиваем счётчик
                                    $i++;
                                    // если остаток от деления 0 добавляем закрываем div
                                    if ($i % 3 == 0 || $i == $count): ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <!-- Controls -->
                            <a class="left item-control" href="#similar-product" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right item-control" href="#similar-product" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>

                    </div>
                    <div class="col-sm-7">
                        <div class="product-information"><!--/product-information-->
                            <img src="/images/product-details/new.jpg" class="newarrival" alt="">
                            <!--выводим новинка и хит продаж по условию-->
                            <?php if ($product->new): ?>
                                <?= Html::img("@web/images/home/new.png",
                                    ['alt' => 'Новинка', 'class' => 'newarrival']) ?>
                            <?php endif; ?>
                            <h2><?= $product->name ?></h2>
                            <span>
                                <span>US $<?= $product->price ?></span>
                                <label>Quantity:</label>
                                <!--Добавляем id-->
                                <input type="text" value="1" id="qty">
                                <!--ссылка не нужна потому что мы отправляем запрос аясом в контроллер-->
									              <a href="#" data-id="<?= $product->id ?>" class="btn btn-fefault add-to-cart cart">
                                    <i class="fa fa-shopping-cart"></i>
                                        Add to cart
                                </a>
                            </span>
                            <p>
                                <b>Brand:</b> <a
                                        href="<?= Url::to(['category/view', 'id' => $product->category->id]) ?>"><?= $product->category->name ?></a>
                            </p>
                            <a href=""><img src="/images/product-details/share.png" class="share img-responsive"
                                            alt=""></a>
                            <div><?= $product->content ?></div>
                        </div><!--/product-information-->
                    </div>
                </div><!--/product-details-->

                <div class="recommended_items"><!--recommended_items-->
                    <h2 class="title text-center">Рекомендованные товары</h2>

                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php $i = 0;
                            $count = count($hits);
                            foreach ($hits as $hit): ?>
                                <?php if ($i % 3 == 0): ?>
                                    <div class="item <?php if ($i == 0) echo 'active' ?>">
                                <?php endif; ?>
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <?= Html::img("@web/images/product/{$hit->img}", ['alt' => $hit->name]) ?>
                                                <h2>$<?= $hit->price ?></h2>
                                                <p>
                                                    <a href="<?= Url::to(['product/view', 'id' => $hit->id]) ?>"><?= $hit->name ?></a>
                                                </p>
                                                <a href="#" data-id="<?= $hit->id ?>"
                                                   class="btn btn-default add-to-cart"><i
                                                            class="fa fa-shopping-cart"></i>Add to cart</a>
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
