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
use yii\di\Instance;
use yii\helpers\Url;
use Yii;

class Update extends Action
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
     * @param $id
     * @return \yii\web\Response
     * @throws \maniakalen\admingui\exceptions\GuiException
     */
    public function run($id)
    {
        $post = Yii::$app->request->post();
        if ($this->manager->updateRecord($id, $post)) {
            if (isset($this->messages['success'])) {
                Yii::$app->session->addFlash('success', $this->messages['success']);
            }
        } else {
            if (isset($this->messages['danger'])) {
                Yii::$app->session->addFlash('danger', $this->messages['danger']);
            }
        }
        return $this->controller->redirect(Url::to([$this->redirect, 'id' => $id]));
    }
}