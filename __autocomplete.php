<?php

class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication the application instance
     */
    public static $app;
}

/**
 * @property app\components\filekit\Storage $fileStorage
 * @property \yii\queue\sync\Queue $queue
 *
 */
abstract class BaseApplication extends yii\base\Application
{

}
