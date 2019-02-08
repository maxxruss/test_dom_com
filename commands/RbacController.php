<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 08.02.19
 * Time: 21:08
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {$auth = Yii::$app->authManager;

        // добавляем разрешение "create"
        $createItem = $auth->createPermission('create');
        $createItem->description = 'create';
        $auth->add($createItem);

        // добавляем разрешение "update"
        $updateItem = $auth->createPermission('update');
        $updateItem->description = 'update';
        $auth->add($updateItem);

        // добавляем разрешение "view"
        $viewItem = $auth->createPermission('view');
        $viewItem->description = 'view';
        $auth->add($viewItem);

        // добавляем разрешение "delete"
        $deleteItem = $auth->createPermission('delete');
        $deleteItem->description = 'delete';
        $auth->add($deleteItem);

        // добавляем роль "operator" и даём роли разрешение "viewItem"
        $operator = $auth->createRole('operator');
        $auth->add($operator);
        $auth->addChild($operator, $viewItem);

        // добавляем роль "head" и даём роли разрешение "updateItem"
        // а также все разрешения роли "author"
        $head = $auth->createRole('head');
        $auth->add($head);
        $auth->addChild($head, $updateItem);
        $auth->addChild($head, $operator);

        // добавляем роль "admin" и даём роли разрешение "updateItem"
        // а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $createItem);
        $auth->addChild($admin, $deleteItem);
        $auth->addChild($admin, $head);


        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
//        $auth->assign($author, 2);
//        $auth->assign($admin, 1);
    }
}