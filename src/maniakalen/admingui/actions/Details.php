<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 16/04/2018
 * Time: 12:11
 */

namespace maniakalen\admingui\actions;


use maniakalen\admingui\components\ModelManager;
use maniakalen\admingui\helpers\ModelHelper;
use maniakalen\admingui\interfaces\ModelManagerInterface;
use yii\base\Action;
use yii\base\Model;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class Details extends Action
{
    /** @var ModelManager $manager */
    public $manager;
    public $view;

    public $title;
    public $params;
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->manager = Instance::ensure($this->manager, ModelManagerInterface::class);
        \Yii::setAlias('@adminguiview', dirname(__DIR__) . '/views');
        if (!$this->view) {
            $this->view = '@adminguiview/details';
        }
    }

    /**
     * @param null $id
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function run($id = null)
    {
        if (!empty($this->params)) {
            \Yii::$app->params = ArrayHelper::merge(\Yii::$app->params, $this->params);
        }
        /** @var Model $record */
        $record = $id?$this->manager->getRecord($id):$this->manager->getObjectInstance();
        if (!$record) {
            throw new NotFoundHttpException("Model not found");
        }
        $record = ModelHelper::restore($record);
        return $this->controller->render(
            $this->view,
            [
                'title' => $this->title?:'',
                'model' => $record
            ]
        );
    }
}