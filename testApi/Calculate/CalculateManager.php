<?php
require_once 'Hellpers/Params.php';
require_once 'Hellpers/Hellper.php';

/**
 * Class CalculateManager
 */
class CalculateManager
{
    public static function calculateDelivery($params,$companies)
    {
       $calculate=[];
       $days=0;

       foreach ($companies as $company) {
           if ($params[Params::WEIGHT] < Hellper::LIGHT_WEIGT) {
               $calculate[$company]['data']  = (new \DateTime())->modify(Hellper::COUNT_DAYS_LIGHT_WEIGT)->format('Y-m-d');
               $calculate[$company]['price'] = Hellper::BASE_COST_SLOW_DELIVERI * Hellper::LIGHT_WEIGT_COFFICENT * Hellper::ITERCITY_COFFICENT;
           } elseif ($params[Params::WEIGHT] > Hellper::LIGHT_WEIGT && $params[Params::WEIGHT] < Hellper::HEAVY_WEIGHT) {
               $calculate[$company]['data']  = (new \DateTime())->modify(Hellper::COUNT_DAYS_AVERAGE_WEIGT)->format('Y-m-d');
               $calculate[$company]['price'] = Hellper::BASE_COST_SLOW_DELIVERI * Hellper::AVERAGE_WEIGT_COFFICENT * Hellper::ITERCITY_COFFICENT;
           } elseif ($params[Params::WEIGHT] > Hellper::HEAVY_WEIGHT) {
               $calculate[$company]['data']  = (new \DateTime())->modify(Hellper::COUNT_DAYS_HEAVY_WEIGT)->format('Y-m-d');
               $calculate[$company]['price'] = Hellper::BASE_COST_SLOW_DELIVERI * Hellper::HEAVY_WEIGT_COFFICENT * Hellper::ITERCITY_COFFICENT;
           }

           if ($params[Params::TYPE] === Type::FAST_DELIVERI) {
               $calculate[$company]['data']  = (new \DateTime())->modify(Hellper::COUNT_DAYS_FAST_DEKIVERY)->format('Y-m-d');
               $calculate[$company]['price'] = $calculate[$company]['price'] * Hellper::BASE_COST_FAST_DELIVERI;
           }
       }

        return $calculate;
    }

}