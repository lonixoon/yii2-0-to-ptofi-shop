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
use app\models\OrderItems;
use app\models\Order;

use Yii;
use yii\web\Session;

class CartController extends AppController
{


    /*
     * Добавляем item  в козину
     * Принемает id товара и qty количество товара если оно было передано
     * Возвращает сессию где эти товары и количества перечислены
     */
    public function actionAdd($id, $qty = 1)
    {
//        $id = Yii::$app->request->get('id');

        // Если передано число приводим его к целому числу иначе $qty = 1
        $qty = is_numeric($qty) ? (int)$qty : $qty = 1;
//        $qty = (int)$qty;
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
        $cart->addToCart($product, $qty);
        // отключаем шаблон т.к. это мадальное окно
        $this->layout = false;

        return $this->render('cart-modal', compact('session'));
    }

    /*
     * Полностью очищаем корзину
     */
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

    /*
     * Удаляем конкретный item из корзины
     * принемает id товара, возвращаем html без этого товара
     */
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

    /*
     *  Показываем корзину модальным окном
     */
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

    /*
     * Показываем корзину стараницой где можно оформить заказ
     */
    public function actionView()
    {
        // получаем сессию
        $session = Yii::$app->session;
        // открваем сессию
        $session->open();
        // Заголовок
        $this->setMeta('Корзина');
        // создаём модель заказа т.к. нужна форма
        $order = new Order();
        // если пришёл пост запрос
        if ($order->load(Yii::$app->request->post())) {
            dump($order->load(Yii::$app->request->post()));
        }

        return $this->render('view', compact('session', 'order'));
    }
}