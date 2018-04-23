<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 17/04/2018
 * Time: 16:38
 */
/** @var \yii\db\ActiveRecord $model */
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
try {
    ?>
    <div><?= \maniakalen\widgets\Flash::widget() ?> </div>
    <?php
    echo \maniakalen\widgets\ActiveForm::widget(
        [
            'action' => $model->isNewRecord?$model->getCreateAction():$model->getUpdateAction(),
            'model' => $model,
            'resetButton' => ['label' => 'Reset', 'options' => ['class' => 'btn btn-danger ml-2']],
        ]
    );
} catch (\Exception $ex) {
    throw new \yii\web\BadRequestHttpException("Failed to render object. " . $ex->getMessage());
}
