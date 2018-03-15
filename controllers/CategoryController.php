<?php
/**
 * Created by PhpStorm.
 * User: RUS9211689
 * Date: 14.03.2018
 * Time: 8:55
 */

namespace app\controllers;
use app\models\Product;
use app\models\Category;
use Yii;
use yii\data\Pagination;
use yii\web\HttpException;

class CategoryController extends AppController
{
    public function actionIndex()
    {
        // получаем из таблицы product все записи где стоблец имеет значение = 1
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        // выводим на главной страницы название нашего магазина фиксированно
        $this->setMeta('E-SHOPPER');
        // выводим шаблон index.php
        return $this->render('index', compact('hits'));
    }

    public function actionView($id)
    {
        // получаем id из запрашиваемой ссылки (как вариант)
//        $id = Yii::$app->request->get('id');

        // получаем категорию
        $category = Category::findOne($id);

        // если категории не существует выкидываем ошибку
        if (empty($category))
            throw new HttpException(404, 'Такой категории нет');

        // получамаем все где поле category_id равно переданому $id
        $query = Product::find()->where(['category_id' => $id]);

        // считаем длину массива
        $count = $query->count();
        // получаем данные для пагинатора и выставляем параметры для ЧПУ (последние два)
        $pagination  = new Pagination([
            'totalCount' => $count,
            'pageSize' => 3,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);

        // выгружаем продукты с учётом параметров пагинатора
        $products = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        // выводим на страницы категорий теги и заголоки
        $this->setMeta('E-SHOPPER | ' . $category->name, $category->keywords, $category->description);
        return $this->render('view', compact('products', 'pagination', 'category'));
    }

    public function actionSearch()
    {
        $search = trim(Yii::$app->request->get('search'));
        // выводим мета теги
        $this->setMeta('E-SHOPPER | Поиск: ' . $search);
        if (!$search)
            return $this->render('search');
        // получамаем все где поле name совпадает с $search
        $query = Product::find()->where(['like', 'name', $search]);

        // считаем длину массива
        $count = $query->count();
        // получаем данные для пагинатора и выставляем параметры для ЧПУ (последние два)
        $pagination  = new Pagination([
            'totalCount' => $count,
            'pageSize' => 3,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);

        // выгружаем продукты с учётом параметров пагинатора
        $products = $query->offset($pagination->offset)->limit($pagination->limit)->all();


        return $this->render('search', compact('products', 'pagination', 'search'));
    }
}