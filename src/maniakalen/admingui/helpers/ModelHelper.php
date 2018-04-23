<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 19/04/2018
 * Time: 18:18
 */

namespace maniakalen\admingui\helpers;

use yii\base\Model;

class ModelHelper
{
    public static function restore(Model $record)
    {
        $recordClass = get_class($record);
        if (\Yii::$app->session->has($recordClass)) {
            $recordData = unserialize(\Yii::$app->session->get($recordClass));
            \Yii::$app->session->remove($recordClass);
            if (isset($recordData['errors'])) {
                $record->addErrors($recordData['errors']);
            }
            if (isset($recordData['data'])) {
                $record->load($recordData['data']);
            }
        }
        return $record;
    }

    public static function archive(Model $record, array $data)
    {
        \Yii::$app->session->set(get_class($record), serialize(['data' => $data, 'errors' => !empty($record->errors)?$record->errors:[]]));
    }
}