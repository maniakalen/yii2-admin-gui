<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 13/04/2018
 * Time: 13:12
 */
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
try {
    ?>
    <div><?= \maniakalen\widgets\Flash::widget() ?> </div>
    <?php
    echo \yii\helpers\Html::a(Yii::t('workflow', 'Create'), $createAction, ['class' => 'btn btn-primary']);
    echo \yii\grid\GridView::widget([
        'dataProvider' => $provider,
        'filterModel' => $model,
        'columns' => $columns
    ]);
} catch (\Exception $ex) {
    throw new \yii\web\BadRequestHttpException("Failed to render object. " . $ex->getMessage());
}
