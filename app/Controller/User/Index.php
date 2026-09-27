<?php
declare( strict_types = 1 );
namespace App\Controller\User;

use App\Annotation\Validator;
use App\Controller\ServerController;
use App\Validator\User\Index as UserIndex;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;
use Psr\Log\LoggerInterface;

class Index extends ServerController {

    /**
     * container
     */
    #[Inject] protected LoggerInterface $log;
    #[Inject] protected ConfigInterface $config;

    public function index() {

        return $this->success();
    }
}