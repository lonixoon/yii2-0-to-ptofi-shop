<?php
/**
 * Created by PhpStorm.
 * User: RUS9211689
 * Date: 13.03.2018
 * Time: 16:09
 */

namespace app\models;

use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
    public function addToCart($product, $qty = 1)
    {
        // если тавар есть в корзине и нажать добавить товар, то количество будет +1
        if (isset($_SESSION['cart'][$product->id])) {
            $_SESSION['cart'][$product->id]['qty'] += $qty;
        } else {
            // если товара небыло в корзине
            $_SESSION['cart'][$product->id] = [
                // количество
                'qty' => $qty,
                // имя
                'name' => $product->name,
                // цена
                'price' => $product->price,
                // картинка
                'img' => $product->img,
            ];
        }

        // проверяем есть ли элемент qty, то прибавим к нему количесво которое пришло
        // параметром $qty, иначе положем туда пришёдшее количество
        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;

        // проверяем есть ли элемент sum, то прибавим к нему количесво которое пришло
        // параметром qty и умножаем на цену товара , что бы получить новую общую стоимость
        // иначе посчитаем сумму за количество которое пришло
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $product->price : $qty * $product->price;
    }

    public function recalc($id)
    {
        // если в сессии нет товара с переданным ID (защита от пользователя) останавливаем выполнение
        if (!isset($_SESSION['cart'][$id])) return false;

        // вычисляем сколько этого товара было в корзине
        $qtyMinus = $_SESSION['cart'][$id]['qty'];

        // вычисляем стоимость товара которое мы отнимем
        $sumMinus = $qtyMinus * $_SESSION['cart'][$id]['price'];
        // отнимаем от общего количества, то количсва которое было в $qtyMinus
        $_SESSION['cart.qty'] -= $qtyMinus;
        // отнимаем от общейстоимости, ту цену которую мы поличили в $sumMinus
        $_SESSION['cart.sum'] -= $sumMinus;
        // после того как пересчитали общую цену и количство, удаляем товар с указанным id  из массива
        unset($_SESSION['cart'][$id]);
    }
}