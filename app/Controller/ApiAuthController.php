<?php
declare( strict_types = 1 );    // 严格模式

namespace App\Controller;

use App\Response\ServerResponse;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;
use Override;

abstract class ApiAuthController extends ServerController {
    /** 配置 */
    #[Inject] protected ConfigInterface $config;

    public function __construct(
        protected ServerResponse $serverResponse,   // 响应
    ) {

    }
}