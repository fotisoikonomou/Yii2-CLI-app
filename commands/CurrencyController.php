<?php

namespace app\commands;

use Yii;
use app\components\etl\implementations\GetCurrencyData;
use app\components\etl\implementations\DatabaseLoad;

class CurrencyController extends \yii\console\Controller
{

    private $apiKey = 'a9af276867da4e66ba5ed4023a9fc9f1';

    public function actionImport($startDate = null, $endDate = null)
    {

        if (!$startDate) {
            $startDate = date('Y-m-d');
        }
        if (!$endDate) {
            $endDate = $startDate;
        }

        $getData = new GetCurrencyData($this->apiKey);

        $data = $getData->fetch($startDate, $endDate);



        $mainDate =  $startDate;

        // There are data for this day
        if (isset($data[$mainDate])) {

            //retrieve the eur rate
            $eurToUsdRate = $data[$mainDate]['rates']['EUR'];

           //procedure to change the base and the rate according to euro base.
            foreach ($data[$mainDate]['rates'] as $currency => &$rate) {

                if ($currency === 'USD') {

                    $rate = 1 / $eurToUsdRate; // 1 eur to how many dollars
                } else {

                    $rate /= $eurToUsdRate; // otherwise divide by the eur rate 
                }
            }
            // set eur rate to 1
            $data[$mainDate]['rates']['EUR'] = 1;
            //set base to eur from usd
            $data[$mainDate]['base'] = 'EUR';

            echo "The rates have successfully transformed to EUR base!\n";

            $dataForLoader = $data[$mainDate];

            $databaseLoader = new DatabaseLoad();

            if ($databaseLoader->load($dataForLoader)) {

                echo "Data successfully loaded to the database!\n";
            } else {
                echo "An error occured \n";
            }
        } else {
            echo "There is no data or it is something else.\n";
        }
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
}
