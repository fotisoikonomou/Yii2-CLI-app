<?php

namespace app\components\etl\implementations;

use app\components\etl\abstracts\AbstractGetData;
use yii\httpclient\Client;
USE Yii;
class GetCurrencyData extends AbstractGetData
{
    private $mykey;

    // Initiazation of the api key
    public function __construct($mykey)
    {
        $this->mykey = $mykey;
    }


    public function fetch($startDate, $endDate): array
    {
        $client = new Client(); // new HTTP client instance.
        
        $data = []; // Array to store the fetched data

        // Here I Create DateTime objects 
        
        $firstDay = new \DateTime($startDate);
        
        $LastDate = new \DateTime($endDate);

        /* Here I use the modify function to increase by one the date object in order to catch all the possible
           values in the given date range. If we set start date 1st of March and the end date 3rd of march 
           the loop will check for values between 1 and 2 march. So by adding one more +1 in the end date we make sure 
           it will catch all the possible matches! */

        $LastDate->modify('+1 day');


        // Loop over each day in the date range, fetching data for each day.
        for ($date = $firstDay; $date < $LastDate; $date->modify('+1 day')) {

            $stringDates = $date->format("Y-m-d"); // I save data as string  string in Y-m-d format in order to use it in the GET Request

            // The GET Request
            $response = $client->get("https://openexchangerates.org/api/historical/{$stringDates}.json?app_id={$this->mykey}")->send();

            // If success store the fetched data to the array
            if ($response->isOk) {
                
                 $data[$stringDates] = $response->data;

            }  else {

                // Error!!
                Yii::error("No data fetched" . $response->getContent());
            }
        }

        return $data;
    }
}
