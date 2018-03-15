<?php
/**
 * Created by PhpStorm.
 * User: RUS9211689
 * Date: 14.03.2018
 * Time: 8:55
 */

namespace app\controllers;

use app\models\Product;
use app\models\Cart;

use Yii;

class CartController extends AppController
{
    public function actionAdd($id)
    {
        // по переданому id ищем элемент в базе
        $product = Product::findOne($id);
        // если элемента не существует возвращаем false
        if (empty($product)) return false;

        // открываем сессию
        $session = Yii::$app->session;
        $session->open();

        $cart = new Cart();
        // передаём объект в модель
        $cart->addToCart($product);

        return $this->render('cart-modal', compact('session'));
    }
}