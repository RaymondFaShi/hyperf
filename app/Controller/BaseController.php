<?php
declare( strict_types = 1 );    // 严格模式

namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

abstract class BaseController {
    /** 容器 */
    #[Inject] protected ContainerInterface $container;

    /** 请求 */
    #[Inject] protected RequestInterface $request;

    /** 响应 */
    #[Inject] protected ResponseInterface $response;

}