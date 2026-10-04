<?php
declare( strict_types = 1 );
namespace App\Controller\User;

use App\Controller\ServerController;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;
use Psr\Log\LoggerInterface;

class Index extends ServerController {

    /**
     * container
     */
    #[Inject] protected LoggerInterface $log;
    
    #[Inject] protected ConfigInterface $config;

    #[Inject] protected SessionInterface $session;

    public function index() {
        // devLog( $this->session->all() );

        return $this->success( null );
    }
}