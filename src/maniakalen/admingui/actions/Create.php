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
use yii\base\Action;
use yii\di\Instance;
use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

class Create extends Action
{
    /** @var ModelManager $manager */
    public $manager;
    public $redirect;
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
            Yii::$app->session->addFlash('success', Yii::t('workflow', 'Record created successfully'));
            return $this->controller->redirect(Url::to([$this->redirect, 'id' => $id]));
        } else {
            Yii::$app->session->addFlash('danger', Yii::t('workflow', 'There was an issue saving record'));
            return $this->controller->refresh();
        }

    }
}