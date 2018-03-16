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
use yii\web\Session;

class CartController extends AppController
{
    public function actionAdd($id)
    {
//        $id = Yii::$app->request->get('id');
        // по переданому id ищем элемент в базе
        $product = Product::findOne($id);
        // если элемента не существует возвращаем false
        if (empty($product)) return false;

        // получаем сессию
        $session = Yii::$app->session;
        // открываем сессию
        $session->open();

        $cart = new Cart();
        // передаём объект в модель
        $cart->addToCart($product);
        // отключаем шаблон т.к. это мадальное окно
        $this->layout = false;

        return $this->render('cart-modal', compact('session'));
    }

    public function actionClear()
    {
        // получаем сессию
        $session = Yii::$app->session;
        // открваем сессию
        $session->open();

        // удаляем все по ключу cart
        $session->remove('cart');
        // удаляем все количества
        $session->remove('cart.qty');
        // удаляем все суммы
        $session->remove('cart.sum');
        // убераем вывод шаблона
        $this->layout = false;

        return $this->render('cart-modal', compact('session'));
    }


    public function actionDelItem($id)
    {
        // получаем сессию
        $session = Yii::$app->session;
        // открваем сессию
        $session->open();

        // обращаемся к модели
        $cart = new Cart();
        // пересчитываем общее количества и общую цену
        $cart->recalc($id);
        // убераем вывод шаблона
        $this->layout = false;

        return $this->render('cart-modal', compact('session'));
    }

    public function actionShow()
    {
        // получаем сессию
        $session = Yii::$app->session;
        // открваем сессию
        $session->open();
        // убераем вывод шаблона
        $this->layout = false;

        return $this->render('cart-modal', compact('session'));
    }
}