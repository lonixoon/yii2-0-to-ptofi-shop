<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 15.05.2016
 * Time: 15:53
 */

namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;


class AppAdminController extends Controller
{
//    /*
//     * Испульзуем Поведение
//     * Ограничеваем доступ только для авторизованных пользователей
//     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                // наш класс фильт (приложение которое отчечает за проверку)
//                'class' => AccessControl::className(),
//                // правила
//                'rules' => [
//                    [
//                        // разрешаем все действия только для пользователей с ролью @
//                        'allow' => true,
//                        // @ занчит авторизованные, ? - не авторизованные!
//                        'roles' => ['@']
//                    ]
//                ]
//            ]
//        ];
//    }

}