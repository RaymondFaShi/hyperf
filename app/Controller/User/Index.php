<?php
declare( strict_types = 1 );
namespace App\Controller\User;

use App\Controller\ServerController;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use Libaray\Crypto;
use Psr\Log\LoggerInterface;

use function Hyperf\Config\config;

class Index extends ServerController {

    /**
     * container
     */
    #[Inject] protected LoggerInterface $log;
    
    #[Inject] protected ConfigInterface $config;

    #[Inject] protected SessionInterface $session;

    #[Inject] protected Redis $redis;

    public function index() {
        devLog( generateUID( 20 ) );

        return $this->success( null );
    }
}