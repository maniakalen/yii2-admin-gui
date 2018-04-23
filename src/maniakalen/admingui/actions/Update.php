<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 16/04/2018
 * Time: 12:12
 */

namespace maniakalen\admingui\actions;


use maniakalen\admingui\components\ModelManager;
use maniakalen\admingui\interfaces\ModelManagerInterface;
use yii\base\Action;
use yii\di\Instance;
use yii\helpers\Url;
use Yii;

class Update extends Action
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
     * @param $id
     * @return \yii\web\Response
     * @throws \maniakalen\admingui\exceptions\GuiException
     */
    public function run($id)
    {
        $post = Yii::$app->request->post();
        if ($this->manager->updateRecord($id, $post)) {
            Yii::$app->session->addFlash('success', Yii::t('workflow', 'Record updated successfully'));
        } else {
            Yii::$app->session->addFlash('danger', Yii::t('workflow', 'There was an issue saving record'));
        }
        return $this->controller->redirect(Url::to([$this->redirect, 'id' => $id]));
    }
}