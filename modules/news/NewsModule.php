<?php

namespace app\modules\news;

use yii\base\Module;

/**
 * News module definition class
 */
class NewsModule extends Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\news\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
