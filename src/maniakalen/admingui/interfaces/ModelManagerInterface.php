<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 12/04/2018
 * Time: 17:46
 */

namespace maniakalen\admingui\interfaces;



interface ModelManagerInterface
{
    const MODEL_SCENARIO_SEARCH = 'search';

    public function getProvider(array $params);
    public function getSearchModel();
    public function getGridColumns();

    public function getRecord($id);
    public function getObjectInstance();

    public function updateRecord($id, array $data);
    public function createRecord(array $post);
    public function deleteRecord($id);
    public function toggleRecordStatus($id);
}