<?php
declare( strict_types = 1 );
namespace App\Controller\User;

use App\Controller\ServerController;
use App\Response\Constant\SystemCode;
use App\Response\Result\ServerResult;
use Hyperf\Context\Context;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;
use Psr\Log\LoggerInterface;

class Index extends ServerController {

    #[Inject] protected LoggerInterface $log;

    #[Inject] protected ConfigInterface $config;

    public function index() {
        
        
        
        return $this->success();
    }
}