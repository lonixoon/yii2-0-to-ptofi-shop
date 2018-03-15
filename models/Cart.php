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
                'qtv' => $qty,
                // имя
                'name' => $product->name,
                // цена
                'price' => $product->price,
                // картинка
                'img' => $product->img,
            ];
        }

        // проверяем есть ли элемент qtv, то прибавим к нему количесво которое пришло
        // параметром $qtv, иначе положем туда пришёдшее количество
        $_SESSION['cart.qtv'] = isset($_SESSION['cart.qtv']) ? $_SESSION['cart.qtv'] + $qty : $qty;

        // проверяем есть ли элемент sum, то прибавим к нему количесво которое пришло
        // параметром qty и умножаем на цену товара , что бы получить новую общую стоимость
        // иначе посчитаем сумму за количество которое пришло
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.qtv'] + $qty * $product->price : $qty * $product->price;

    }
}