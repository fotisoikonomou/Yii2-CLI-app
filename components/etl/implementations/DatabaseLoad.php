<?php

namespace app\components\etl\implementations;

use Yii;
use app\components\etl\abstracts\AbstractDatabaseLoad;


class DatabaseLoad extends AbstractDatabaseLoad
{

    /* This is the responsible save function and it extends the load method from 
     the abstract class.*/

    public function load(array $data): bool
    {

        // Make connection the Yii way
        $dataBaseConnection = Yii::$app->db;

        /* Default Yii method which starts a transaction and be able to 
           perform multiple queries like insert/update etc. 
           take a look here to have an idea: (https://www.yiiframework.com/doc/api/2.0/yii-db-connection#beginTransaction()-detail,
                             https://www.yiiframework.com/doc/api/2.0/yii-db-transaction)
        */
        $transactionProcess = $dataBaseConnection->beginTransaction();


        $dateToInsertInCorrectFormat = date('Y-m-d', $data['timestamp']);
        //If there is a record with the same currency_date and symbol it updates the record 
        //otherwise it inserts it.
        try {
            foreach ($data['rates'] as $currencySymbol => $currencyRate) {

                $exists = $dataBaseConnection->createCommand('SELECT COUNT(*) FROM currency_rate WHERE currency_date =:date AND currency_symbol= :symbol', [

                    ':date' =>   $dateToInsertInCorrectFormat,

                    ':symbol' => $currencySymbol,
                ])->queryScalar();

                if ($exists) {
                    //  update data

                    $dataBaseConnection->createCommand('UPDATE currency_rate  SET currency_rate=:rate WHERE currency_date =:date AND currency_symbol=:symbol', [
                        ':date' =>   $dateToInsertInCorrectFormat,

                        ':symbol' => $currencySymbol,

                        ':rate' => $currencyRate,
                    ])->execute();
                } else {
                    //  insert data
                    $dataBaseConnection->createCommand('INSERT INTO currency_rate  (currency_date, currency_symbol, currency_rate ) VALUES (:date, :symbol, :rate)', [
                        ':date' =>   $dateToInsertInCorrectFormat,

                        ':symbol' => $currencySymbol,
                        ':rate' => $currencyRate,
                    ])->execute();
                }
            }

            $transactionProcess->commit();

            return true; // This function load supposed to return true or false from the interface implementation

        } catch (\Exception $e) {

            $transactionProcess->rollBack();


            return false; // This function load supposed to return true or false from the interface implementation
        }
    }
}
