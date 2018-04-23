<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 18/04/2018
 * Time: 12:53
 */

namespace maniakalen\admingui\actions;


use maniakalen\admingui\components\ModelManager;
use maniakalen\admingui\interfaces\ModelManagerInterface;
use yii\base\Action;
use yii\di\Instance;
use Yii;

class Delete extends Action
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
        if ($this->manager->deleteRecord($id)) {
            Yii::$app->session->addFlash('success', Yii::t('workflow', 'Record deleted successfully'));
        } else {
            Yii::$app->session->addFlash('danger', Yii::t('workflow', 'There was an issue deleting record'));
        }
        return $this->controller->goBack();
    }
}