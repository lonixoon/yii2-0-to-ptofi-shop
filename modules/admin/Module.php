<?php

namespace app\modules\admin;

use yii\filters\AccessControl;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /*
     * Испульзуем Поведение
     * Ограничеваем доступ только для авторизованных пользователей
     */
    public function behaviors()
    {
        return [
            'access' => [
                // наш класс фильт (приложение которое отчечает за проверку)
                'class' => AccessControl::className(),
                // правила
                'rules' => [
                    [
                        // разрешаем все действия только для пользователей с ролью @
                        'allow' => true,
                        // @ занчит авторизованные, ? - не авторизованные!
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }
}
