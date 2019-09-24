<?php


namespace maniakalen\admingui\controllers;
/**
 * CRUD controller class.
 *
 * This can be used to facilitade configurational definition for CRUD interface
 *
 * All you need is to define it in the app $controllerMap with all its components like
 *
 *      'users' => [
 *          'class' => 'maniakalen\admingui\controllers\AdminController',
 *          'actionsMap' => [
 *              ... //Actions definitions according to standard yii2 actions definition
 *          ],
 *          'as access' => [
 *              ... //access control behavior definition
 *          ],
 *          'as verb' => [
 *              ... //verbs definition
 *          ]
 *       ]
 */

use yii\web\Controller;

/**
 * Class AdminController
 * @package maniakalen\admingui\controllers
 */
class AdminController extends Controller
{
    public $actionsMap;

    public function actions()
    {
        return $this->actionsMap;
    }
}