<?php
/**
 * Created by PhpStorm.
 * User: RUS9211689
 * Date: 15.03.2018
 * Time: 9:55
 */

namespace app\controllers;

use app\models\Product;
use app\models\Category;
use Yii;
use yii\web\HttpException;

class ProductController extends AppController
{
    public function actionView($id)
    {
        // получаем id товара из get запроса от пользователя (как вариант)
//        $id = Yii::$app->request->get('id');

        // Ленивая загрузка. Получаем по переданому id данные в таблице product
        $product = Product::findOne($id);
        // Жадная загрузка. (в данном случае не оправдана)
//        $product = Product::find()->with('category')->where(['id' => $id])->limit(1)->one();

        //вывод ошибки если тора нет
        if (empty($product))
            throw new HttpException(404, 'Такого товара нет');

        // получаем из таблицы product все записи где стоблец имеет значение = 1
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();

        // выставляем метатеги
        $this->setMeta('E-SHOPPER | ' . $product->name, $product->keywords, $product->description);
        return $this->render('view', compact('product', 'hits' ));
    }
}