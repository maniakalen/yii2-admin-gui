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
use yii\web\NotFoundHttpException;

class Details extends Action
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
     * @param null $id
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function run($id = null)
    {
        /** @var Model $record */
        $record = $id?$this->manager->getRecord($id):$this->manager->getObjectInstance();
        if (!$record) {
            throw new NotFoundHttpException("Model not found");
        }
        $record = ModelHelper::restore($record);
        return $this->controller->render(
            'details',
            [
                'title' => '',
                'model' => $record
            ]
        );
    }
}