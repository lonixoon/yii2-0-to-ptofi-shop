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
            // помещаем их сессии в таблизу заказа количество и ...
            $order->qty = $session['cart.qty'];
            // ... общую сумму
            $order->sum = $session['cart.sum'];

            // Если заказ сохранён
            if ($order->save()) {
                // если всё хорошо, вызываем функцию сохранение заказа в БД
                $this->saveOrderItems($session['cart'], $order->id);
                // выводим сообщение что заказ принят
                Yii::$app->session->setFlash('success', 'Ваш заказ принят. Менеджер вскоре свяжется с Вами.');
                // отправляем письмо
                // указваем вид () находится в папке mailer
                Yii::$app->mailer->compose('order', compact('session'))
                    // с какого емайла будет отправлена почта (первый параметр адрес почты второй
                    // параметр обёртка, что увидит получаетль)
                    ->setFrom(['postmaster@sandbox5dad7209af824bef809f41db566c8746.mailgun.org' => 'yii2-0-to-ptofi-shop:800'])
                    // куда отправляем (поле из формы)
                    ->setTo($order->email)
                    // утсанавливаем тему письма
                    ->setSubject('Заказ')
                    // отправляем письмо
                    ->send();
                // очищаем данные из сессии по крзине
                $session->remove('cart');
                $session->remove('cart.qty');
                $session->remove('cart.sum');
                // перезагружаем страницу
                return $this->refresh();
            } else {
                // иначе выдавать ошибку
                Yii::$app->session->setFlash('error', 'Ошибка оформления заказа');
            }
        }

        return $this->render('view', compact('session', 'order'));
    }

    /*
     * Сохранение заказа в БД
     */
    protected function saveOrderItems($items, $order_id)
    {
        // проходимся циклом по товарам из корзины и получаем id товара и всю инфу по заказу
        foreach ($items as $id => $item) {
            // создаём модель в цикле т.к. один обънет на одну строку записи
            $order_items = new OrderItems();
            // id заказа
            $order_items->order_id = $order_id;
            //id товара
            $order_items->product_id = $id;
            // имя товара
            $order_items->name = $item['name'];
            // цену
            $order_items->price = $item['price'];
            // количества этого товара
            $order_items->qty_item = $item['qty'];
            // общую цену этого товара
            $order_items->sum_item = $item['qty'] * $item['price'];
            // сохраняем
            $order_items->save();
        }
    }
}