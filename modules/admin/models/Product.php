<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $content
 * @property double $price
 * @property string $keywords
 * @property string $description
 * @property string $img
 * @property string $hit
 * @property string $new
 * @property string $sale
 */
class Product extends ActiveRecord
{
    // т.к. с таблицы Product не будет братся поле Img создаём переменную под новое поле в таблице
    // для модуля загрузки картинок
    public $image;
    public $gallery;

    /*
     * метод поведения для модуля картинок
     */
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /*
     * Описываем связь один к одному с категорией
     * поле id связывает с полем в текущей таблецей category_id
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name'], 'required'],
            [['category_id'], 'integer'],
            [['content', 'hit', 'new', 'sale'], 'string'],
            [['price'], 'number'],
            [['name', 'keywords', 'description', 'img'], 'string', 'max' => 255],
            // поле для загрузки основной картинки
            [['image'], 'file', 'extensions' => 'png, jpg'],
            // поле для загрузки дополнительных картнок
//            [['gallery'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID товара',
            'category_id' => 'Категория',
            'name' => 'Название',
            'content' => 'Описание',
            'price' => 'Цена',
            'keywords' => 'Ключевые слова',
            'description' => 'Мета описание',
            'image' => 'Фото',
            'hit' => 'Хит',
            'new' => 'Новинка',
            'sale' => 'Распродажа',
        ];
    }

    /*
     *  загрузка картинки на сервер
     */
    public function upload()
    {
        // если вся волидация пройдена
        if ($this->validate()) {
            // указываем пуьть по котроому загружаем файл, его мия и разширение
            $patch = 'upload/store/' . $this->image->baseName . '.' . $this->image->extension;
            // загружаем файл по указанному выше пути
            $this->image->saveAs($patch);
            return true;
        } else {
            return false;
        }
    }
}
