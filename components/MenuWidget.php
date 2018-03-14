<?php
/**
 * Created by PhpStorm.
 * User: RUS9211689
 * Date: 13.03.2018
 * Time: 16:18
 */

namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\Category;

class MenuWidget extends Widget
{
    //шаблон меню
    public $tpl;
    // массив категорий из таблицы категорий
    public $data;
    // из обычного массива в массив дерево
    public $tree;
    // готовый html код
    public $menuHtml;

    // инициализируем наше меню..
    public function init()
    {
        parent::init();
        // ... вид меню в зависимости от тока админка или фронт
        if ($this->tpl === null) {
            $this->tpl = 'menu';
        }
        // добавляем указываем расширешение
        $this->tpl .= '.php';
    }

    // запускаем выгрузку в меню
    public function run()
    {
        // получаем меню из кеша (если оно там есть)
        $menu = Yii::$app->cache->get('menu');
        if ($menu) return $menu;

        // выгружаем все данные в виде масива и как индекс используем поле id
        $this->data = Category::find()->indexBy('id')->asArray()->all();
        // передаём все данные в дерево
        $this->tree = $this->getTree();
        // возвращаем html дерева
        $this->menuHtml = $this->getMenuHtml($this->tree);

        // записываем данные в кеш (ключ, данные, время в секундах)
        Yii::$app->cache->set('menu', $this->menuHtml, 60);

        // возвращаем шаблон меню
        return $this->menuHtml;
    }

    // получаем дерево (вложенные массивы по категориям)
    protected function getTree(){
        $tree = [];
        foreach ($this->data as $id=>&$node) {
            if (!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }

    // принемает дерево именно параметром, т.к. использует не всегда все дерево
    protected function getMenuHtml($tree){
        $str = '';
        // проходим в цикле по всему дереву
        foreach ($tree as $category) {
            // и передаём его параметром каждый конкретный элемент дерева
            $str .= $this->catToTemplate($category);
        }
        return $str;
    }

    // метод catToTemplate принемает параметром каждый элемент и помещает его в шаблон
    // который подключается по указанному пути (на экран не выводится!)
    protected function catToTemplate($category){
        ob_start();
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }
}