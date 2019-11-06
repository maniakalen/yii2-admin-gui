<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 16/04/2018
 * Time: 14:16
 */

namespace maniakalen\admingui\actions;


use maniakalen\admingui\components\ModelManager;
use maniakalen\admingui\interfaces\ModelManagerInterface;
use yii\di\Instance;
use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

class Create extends Action
{
    /** @var ModelManager $manager */
    public $manager;
    public $redirect;
    public $messages;
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->manager = Instance::ensure($this->manager, ModelManagerInterface::class);
    }

    /**
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $post = \Yii::$app->request->post();
        if (($id = $this->manager->createRecord($post)) !== false) {
            if (isset($this->messages['success'])) {
                Yii::$app->session->addFlash('success', $this->messages['success']);
            }
            return $this->controller->redirect(Url::to([$this->redirect, 'id' => $id]));
        } else {
            if (isset($this->messages['danger'])) {
                Yii::$app->session->addFlash('danger', $this->messages['danger']);
            }
            return $this->controller->refresh();
        }

    }
}