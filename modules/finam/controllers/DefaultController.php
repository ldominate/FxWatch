<?php

namespace app\modules\finam\controllers;

use app\modules\catalog\models\SourceCode;
use app\modules\finam\models\FinData;
use Yii;
use yii\db\Query;
use yii\web\Controller;

/**
 * Default controller for the `finam` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionWidget()
    {
	    $result = [];

    	return $this->render('widget', [
		    'result' => $result
	    ]);
	}
}
