<?php
/**
 * Created by PhpStorm.
 * User: RUS9211689
 * Date: 13.03.2018
 * Time: 16:18
 */

namespace app\components;

use yii\base\Widget;
use app\models\Category;

class MenuWidget extends Widget
{
    public $tpl;
    // массив категорий из таблицы категорий
    public $data;
    // из обычного массива в массив дерево
    public $tree;
    // готовый html код
    public $menuHtml;

    public function init()
    {
        parent::init();
        if ($this->tpl === null) {
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';
    }

    public function run()
    {
        $this->data = Category::find()->indexBy('id')->asArray()->all();
        $this->tree = $this->getTree();
        return $this->tpl;
    }

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

    protected function getMenuHtml($tree){
        $str = '';
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category);
        }
        return $str;
    }

    protected function catToTemplate($category){
        ob_start();
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }
}