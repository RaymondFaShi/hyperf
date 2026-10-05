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

class Index extends ServerController {

    /**
     * container
     */
    #[Inject] protected LoggerInterface $log;
    
    #[Inject] protected ConfigInterface $config;

    #[Inject] protected SessionInterface $session;

    #[Inject] protected Redis $redis;

    public function index() {
        $crypto = new Crypto( 'aes-256-cbc', 16, 0, 32 );
        devLog( $crypto->encrypt( '10001', generateUID( 16 ) ) );


        return $this->success( null );
    }
}