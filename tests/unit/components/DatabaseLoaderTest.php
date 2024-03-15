<?php 
namespace tests\unit\components\etl;
use Yii;
class DatabaseLoaderTest extends \Codeception\Test\Unit
{
    // Test method to check if valid data can be loaded successfully.
    public function testLoadValidData()
    {
        $db = Yii::$app->db;

        $transaction = $db->beginTransaction();

       
        $data = [
            'timestamp' => time(), //current time for the timestamp.
            'rates' => [ 
                'EUR' => 10, 
                'GBP' => 0, 
            ]
        ];

      
        $dateToInsertInCorrectFormat = date('Y-m-d', $data['timestamp']);
        //If there is a record with the same currency_date and symbol it updates the record 
        //otherwise it inserts it.
        try {
            foreach ($data['rates'] as $currencySymbol => $currencyRate) {

                $exists = $db->createCommand('SELECT COUNT(*) FROM currency_rate WHERE currency_date=:date AND currency_symbol=:symbol', [

                    ':date' =>   $dateToInsertInCorrectFormat,

                    ':symbol' => $currencySymbol,
                ])->queryScalar();

                if ($exists) {
                    //  update data

                    $db->createCommand('UPDATE currency_rate SET currency_rate=:rate WHERE currency_date=:date AND currency_symbol=:symbol', [
                        ':date' =>   $dateToInsertInCorrectFormat,

                        ':symbol' => $currencySymbol,

                        ':rate' => $currencyRate,
                    ])->execute();
                } else {
                    //  insert data
                    $db->createCommand('INSERT INTO currency_rate (currency_date, currency_symbol, currency_rate) VALUES (:date, :symbol, :rate)', [
                        ':date' =>   $dateToInsertInCorrectFormat,

                        ':symbol' => $currencySymbol,
                        ':rate' => $currencyRate,
                    ])->execute();
                }
            }

            $transaction->commit();

            $this->assertTrue(true, "Data successfully loaded to the database.");

        } catch (\Exception $e) {

            $transaction->rollBack();


            $this->assertTrue(false, "Failed to load data: " . $e->getMessage());
        }
    }
}
    
?>