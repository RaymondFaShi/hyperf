<?php
declare( strict_types = 1 );
namespace App\Controller\User;

use App\Controller\BaseController;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;
use Psr\Log\LoggerInterface;

class Index extends BaseController {

    #[Inject()] protected LoggerInterface $log;

    #[Inject] protected ConfigInterface $config;

    public function index() {
        $r = $this->config->get( 'custom.allowDomain' );
        devLog( $r );
        return 1;
    }
}
