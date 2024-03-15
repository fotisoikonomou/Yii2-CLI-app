<?php 
namespace app\components\etl\interfaces;

interface LoadDataInterface {
     
    public function load(array $data): bool;
}
?>