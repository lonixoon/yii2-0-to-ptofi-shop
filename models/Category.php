<?php
/**
 * Created by PhpStorm.
 * User: RUS9211689
 * Date: 13.03.2018
 * Time: 16:09
 */

namespace app\models;


use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    // подключаем таблицу (необходимо если имя таблицы отличается от имени класса)
    public static function tableName()
    {
        return 'category';
    }

    // делаем в таблице связь полей (один к многим)
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

}