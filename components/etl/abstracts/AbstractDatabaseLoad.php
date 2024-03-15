<?php 
namespace app\components\etl\abstracts;

use app\components\etl\interfaces\LoadDataInterface;

abstract class AbstractDatabaseLoad implements LoadDataInterface {
    
    abstract public function load(array $data): bool;
}

?>