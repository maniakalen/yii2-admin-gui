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
     * @param $id
     * @return \yii\web\Response
     * @throws \maniakalen\admingui\exceptions\GuiException
     */
    public function run($id)
    {
        if ($this->manager->deleteRecord($id)) {
            if (isset($this->messages['success'])) {
                Yii::$app->session->addFlash('success', $this->messages['success']);
            }
        } else {
            if (isset($this->messages['danger'])) {
                Yii::$app->session->addFlash('danger', $this->messages['danger']);
            }
        }
        return $this->controller->redirect(Yii::$app->request->referrer);
    }
}