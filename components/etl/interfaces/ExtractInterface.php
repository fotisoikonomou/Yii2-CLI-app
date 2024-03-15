<?php 

namespace app\components\etl\interfaces;

interface ExtractInterface
{
    public function fetch($startDate, $endDate): array;
}

?>
