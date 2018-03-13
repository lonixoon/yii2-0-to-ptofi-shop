<?php
/**
 * Created by PhpStorm.
 * User: RUS9211689
 * Date: 13.03.2018
 * Time: 16:09
 */

namespace app\models;


use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    // подключаем таблицу (необходимо если имя таблицы отличается от имени класса)
    public static function tableName()
    {
        return 'product';
    }

    // делаем в таблице связь полей
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'category_id']);
    }

}