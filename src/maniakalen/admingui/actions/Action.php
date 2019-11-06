<?php


namespace maniakalen\admingui\actions;


use yii\base\ActionEvent;

class Action extends \yii\base\Action
{
    const EVENT_BEFORE_RUN = 'before_run';
    const EVENT_AFTER_RUN = 'after_run';
    /**
     * This method is called right before `run()` is executed.
     * You may override this method to do preparation work for the action run.
     * If the method returns false, it will cancel the action.
     *
     * @return bool whether to run the action.
     */
    protected function beforeRun()
    {
        $event = \Yii::createObject(['class' => ActionEvent::class], ['action' => $this]);
        $this->trigger(static::EVENT_BEFORE_RUN, $event);
        return $event->isValid;
    }

    /**
     * This method is called right after `run()` is executed.
     * You may override this method to do post-processing work for the action run.
     */
    protected function afterRun()
    {
        $event = \Yii::createObject(['class' => ActionEvent::class], ['action' => $this]);
        $this->trigger(static::EVENT_AFTER_RUN, $event);
    }
}