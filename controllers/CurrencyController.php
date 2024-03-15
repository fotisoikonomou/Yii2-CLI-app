<?php

namespace app\commands; 

use Yii;

use yii\console\ExitCode;
use yii\httpclient\Client;
use app\components\etl\implementations\CurrencyExtractor;


    public function actionIndex()
    {
        return $this->render('index');
    }

}
