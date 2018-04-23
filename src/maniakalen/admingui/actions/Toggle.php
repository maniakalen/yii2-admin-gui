<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 18/04/2018
 * Time: 12:49
 */

namespace maniakalen\admingui\actions;


use maniakalen\admingui\components\ModelManager;
use maniakalen\admingui\interfaces\ModelManagerInterface;
use yii\base\Action;
use yii\di\Instance;
use Yii;

class Toggle extends Action
{
    /** @var ModelManager $manager */
    public $manager;
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->manager = Instance::ensure($this->manager, ModelManagerInterface::class);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \maniakalen\admingui\exceptions\GuiException
     */
    public function run($id)
    {
        if ($this->manager->toggleRecordStatus($id)) {
            Yii::$app->session->addFlash('success', Yii::t('workflow', 'Record status toggled successfully'));
        } else {
            Yii::$app->session->addFlash('danger', Yii::t('workflow', 'There was an issue toggling record status'));
        }
        return $this->controller->redirect(Yii::$app->request->referrer);
    }
}