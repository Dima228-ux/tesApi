<?php
require_once 'controller/BaseController.php';
require_once 'Hellpers/Params.php';
require_once 'Calculate/CalculateManager.php';
require_once 'Hellpers/Type.php';

/**
 * Class AffordableController
 */
class AffordableController extends BaseController
{
    public function slowAction()
    {
        return $this->mainAction(Type::SLOW_DELIVERI);
    }

    public function fastAction()
    {
        if(date('h:i')>'18') {
          echo json_encode(['message'=>'Requests are not accepted after 18:00']);
          return ;
        }
        return $this->mainAction(Type::FAST_DELIVERI);
    }

    public function mixedAction(){//смещенная доставка

        if(date('h:i')>'18') {
            echo json_encode(['message'=>'Requests are not accepted after 18:00']);
            return ;
        }

        return $this->mainAction(Type::MIXED_DELIVERI);
    }

    public function mainAction($type)
    {
        $params = [
            Params::TYPE        => $type,
            Params::COMPANY     => $this->getRequest()->getInt(Params::COMPANY),
            Params::SOURCEKLADR => $this->getRequest()->getString(Params::SOURCEKLADR),
            Params::TARGETKLADR => $this->getRequest()->getString(Params::TARGETKLADR),
            Params::WEIGHT      => $this->getRequest()->getFloat(Params::WEIGHT)
      ];

        if($type===Type::MIXED_DELIVERI){
            $params[Params::FAST_COPANY]=$this->getRequest()->getInt(Params::FAST_COPANY);
            $params[Params::SLOW_COMPANY]=$this->getRequest()->getInt(Params::SLOW_COMPANY);
        }

        if(is_null($params[Params::COMPANY])){
            if(is_null($params[Params::FAST_COPANY])||is_null($params[Params::SLOW_COMPANY])){
                echo json_encode(['message:'=>'Company is missing of mistake ']);
                return;
            }
        }

        if(is_null($params[Params::SOURCEKLADR])){
            echo json_encode(['message:'=>'Surce kladr is missing or mistake ']);
            return;
        }

        if(is_null($params[Params::TARGETKLADR])){
            echo json_encode(['message:'=>'Target kladr is missing or mistake ']);
            return;
        }

        if(is_null($params[Params::WEIGHT])){
            echo json_encode(['message:'=>'Weight is missing or mistake ']);
            return;
        }

        if($type===Type::MIXED_DELIVERI){
            $result['result']['slow delivery']=CalculateManager::calculateDelivery($params,$params[Params::SLOW_COMPANY]);

            $params[Params::TYPE]=Type::FAST_DELIVERI;
            $result['result']['fast delivery']=CalculateManager::calculateDelivery($params,$params[Params::FAST_COPANY]);
            echo json_encode( $result);
            die();
        }

        $result['result']=CalculateManager::calculateDelivery($params,$params[Params::COMPANY]);

        echo json_encode( $result);
    }
}