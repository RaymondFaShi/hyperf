<?php
declare( strict_types = 1 );
namespace App\Controller\User;

use App\Annotation\Scene;
use App\Annotation\Validator;
use App\Controller\ServerController;
use App\Validator\User\Index as UserIndex;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Psr\Log\LoggerInterface;

#[Validator(UserIndex::class)]
class Index extends ServerController {

    /**
     * container
     */
    #[Inject] protected LoggerInterface $log;
    
    #[Inject]protected ConfigInterface $config;

    #[Scene('index')]
    public function index() {

        return $this->success();
    }
}