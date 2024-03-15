<?php
namespace app\components\etl\abstracts;

use app\components\etl\interfaces\ExtractInterface;

abstract class AbstractGetData implements ExtractInterface {
      
    abstract public function fetch($startDate, $endDate): array;
    
}
?>