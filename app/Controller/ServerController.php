<?php
declare( strict_types = 1 );    // 严格模式

namespace App\Controller;

use App\Response\Constant\SystemCode;
use App\Response\Interfaces\ResultInterface;
use App\Response\Result\ServerResult;
use App\Response\ServerResponse;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;

abstract class ServerController extends BaseController {
    /** 配置 */
    #[Inject] protected ConfigInterface $config;

    /** server响应 */
    #[Inject] protected ServerResponse $serverResponse;

    /**
     * 返回成功
     */
    public function success( ?ResultInterface $result = null ) {
        // 如果没有result, 新建一个
        if( !$result ) $result = new ServerResult;

        // 响应
        return $this->serverResponse->success( SystemCode::SUCCESS, $result );
    }

    /**
     * 返回失败
     */
    public function error( ?ResultInterface $result = null ) {
        // 如果没有result, 新建一个
        if( !$result ) $result = new ServerResult;

        // 响应
        return $this->serverResponse->error( SystemCode::SUCCESS, $result );
    }
}