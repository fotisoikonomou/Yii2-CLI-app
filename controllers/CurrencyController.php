<?php

namespace app\commands; 

use Yii;

use yii\console\ExitCode;
use yii\httpclient\Client;
use app\components\etl\implementations\CurrencyExtractor;

class CurrencyController extends \yii\console\Controller
{

    private $apiKey = 'a9af276867da4e66ba5ed4023a9fc9f1'; 
 
    public function actionImport($startDate = null, $endDate = null) {
        // Default to today's date if no dates are provided
        if (!$startDate) {
            $startDate = date('Y-m-d');
        }
        if (!$endDate) {
            $endDate = $startDate;
        }

        $extractor = new CurrencyExtractor($this->apiKey);
        $data = $extractor->fetch($startDate, $endDate);

        // Example of what to do next: Let's just print out the fetched data
        // In a real scenario, you would transform this data and load it into a database
        foreach ($data as $date => $rates) {
            echo "Rates for $date:\n";
            print_r($rates); // Or process $rates as needed
        }

        return ExitCode::OK;
    }
    public function actionIndex()
    {
        return $this->render('index');
    }

}
