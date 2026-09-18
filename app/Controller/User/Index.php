<?php
declare( strict_types = 1 );
namespace App\Controller\User;

use App\Controller\BaseController;
use Hyperf\Di\Annotation\Inject;
use Psr\Log\LoggerInterface;
use RuntimeException;
use stdClass;

class Index extends BaseController {

    #[Inject()]
    protected LoggerInterface $log;

    public function index() {
        return 123;
    }
}
