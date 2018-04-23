<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 12/04/2018
 * Time: 17:38
 */

namespace maniakalen\admingui\actions;


use maniakalen\admingui\components\ModelManager;
use maniakalen\admingui\interfaces\ModelManagerInterface;
use yii\base\Action;
use yii\di\Instance;

class Grid extends Action
{
    /** @var ModelManager $manager */
    public $manager;
    public $createActionRoute;
    public $view;
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->manager = Instance::ensure($this->manager, ModelManagerInterface::class);
        \Yii::setAlias('@adminguiview', dirname(__DIR__) . '/views');
        if (!$this->view) {
            $this->view = '@adminguiview/grid';
        }
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        return $this->controller->render(
            $this->view,
            [
                'title' => '',
                'provider' => $this->manager->getProvider(\Yii::$app->request->get()),
                'model' => $this->manager->getSearchModel(),
                'columns' => $this->manager->getGridColumns(),
                'createAction' => $this->createActionRoute
            ]
        );
    }
}