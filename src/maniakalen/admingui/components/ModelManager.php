<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 13/04/2018
 * Time: 10:27
 */

namespace maniakalen\admingui\components;



use maniakalen\admingui\exceptions\GuiException;
use maniakalen\admingui\helpers\ModelHelper;
use maniakalen\admingui\interfaces\GridModelInterface;
use maniakalen\admingui\interfaces\ModelManagerInterface;
use yii\base\Component;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\di\Instance;
use yii\grid\SerialColumn;
use yii\helpers\ArrayHelper;
use Yii;

class ModelManager extends Component implements ModelManagerInterface
{

    public $model;
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->model = Instance::ensure($this->model, 'yii\db\ActiveRecord');
    }

    public function getProvider(array $params)
    {
        $model = $this->model;
        $query = $model::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $model = $this->model;
        $model->load($params);
        if (!$model->validate()) {
            return $dataProvider;
        }
        foreach ($model->attributes() as $attribute) {
            if (strpos($model->$attribute, '%') !== false) {
                $query->andFilterWhere(['like', $attribute, $model->$attribute]);
            } else {
                $query->andFilterWhere([$attribute => $model->$attribute?:null]);
            }
        }

        return $dataProvider;
    }

    /**
     * @return object
     * @throws \yii\base\InvalidConfigException
     */
    public function getSearchModel()
    {
        $model = \Yii::createObject([
            'class' => get_class($this->model),
            'scenario' => static::MODEL_SCENARIO_SEARCH
        ]);
        return $model;
    }

    /**
     * @param $id
     * @param array $data
     * @param bool $validate
     * @return bool
     * @throws GuiException
     */
    public function updateRecord($id, array $data, $validate = true)
    {
        $model = $this->model;
        $model = $model::findOne($id);
        if (!$model) {
            throw new GuiException("Missing workflow model");
        }
        $result = $model->load($data) && $model->save($validate);
        if (!$result) {
            ModelHelper::archive($model, $data);
        }
        return $result;
    }

    /**
     * @param array $post
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function createRecord(array $post)
    {
        try {
            $model = $this->model;
            /** @var ActiveRecord $model */
            $model = \Yii::createObject(['class' => $model::className()]);
            if ($model->load($post) && $model->save()) {
                return $model->id;
            } else if (!empty($model->errors)) {
                ModelHelper::archive($model, $post);
                Yii::error("Model errors: " . print_r($model->errors));
            }
            return false;
        } catch (\Exception $ex) {
            \Yii::error('Failed to generate object of class: ' . $model::className(), 'workflow');
            return false;
        }
    }

    public function deleteRecord($id)
    {
        $model = $this->model;
        return $model::deleteAll(['id' => $id]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws GuiException
     */
    public function toggleRecordStatus($id)
    {
        $model = $this->model;
        if (in_array('status', $model->attributes())) {
            $model = $model::findOne($id);
            $model->status = !$model->status;
            if (!$model->save()) {
                Yii::error("Record errors: \n\t" . print_r($model->errors, 1));
                return false;
            }
            return true;
        }

        throw new GuiException("Model class does not support status toggle");
    }

    public function getGridColumns()
    {
        /** @var GridModelInterface $model */
        $model = $this->model;
        return ArrayHelper::merge(
                [['class' => SerialColumn::class]],
                $model->getGridColumnsDefinition()
        );
    }

    public function getRecord($id)
    {
        $model = $this->model;
        return $model::findOne($id);
    }

    /**
     * @return object
     * @throws \yii\base\InvalidConfigException
     */
    public function getObjectInstance()
    {
        return \Yii::createObject(['class' => get_class($this->model)]);
    }
}