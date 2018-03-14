<?php
/**
 * Created by PhpStorm.
 * User: RUS9211689
 * Date: 14.03.2018
 * Time: 10:55
 */

namespace app\controllers;


use yii\web\Controller;

class AppController extends Controller
{
    // делаем общий метод для установки параметров страницы
    protected function setMeta($title = null, $keywords = null, $description = null)
    {
        // добавляем заголовок
        $this->view->title = $title;
        // добавляем метатеги с ключивыми словами на страницу (обарачиваем переменные в двойные кавычки
        // т.к. она может быть пуской, выведятся просто кавычки)
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => "$keywords"]);
        // добавляем метатеги с описнаием товара на страницу
        $this->view->registerMetaTag(['name' => 'description', 'content' => "$description"]);
    }
}