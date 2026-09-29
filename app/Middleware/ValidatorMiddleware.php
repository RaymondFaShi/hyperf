<?php
declare( strict_types = 1 );
namespace App\Middleware;

use App\Annotation\Scene;
use App\Annotation\Validator;
use App\Response\Constant\SystemCode;
use App\Response\Result\ServerResult;
use App\Response\ServerResponse;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\HttpServer\Router\Dispatched;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 请求验证器
 */
class ValidatorMiddleware implements MiddlewareInterface {

    /**
     * construct
     * @param ValidatorFactoryInterface $validationFactory 验证工厂
     */
    public function __construct( 
        public ValidatorFactoryInterface $validationFactory,
        public ServerResponse $response,
    ) {

    }

    /** handler */
    public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface {

        // 获取当前 控制器/方法
        $dispatched = $request->getAttribute( Dispatched::class );
        if( $dispatched && $dispatched->handler ) {
            $callback = $dispatched->handler->callback;
            
            // 控制器 & 方法
            [ $controllerClassName, $methodName ] = $callback;

            // 获取 类注解/ 方法注解
            $validatorAnnotation = AnnotationCollector::getClassAnnotation(
                $controllerClassName,
                Validator::class
            );

            $sceneAnnotation = AnnotationCollector::getClassMethodAnnotation(
                $controllerClassName,
                $methodName
            );

            // 如果有控制器注解
            if( $validatorAnnotation && class_exists( $validatorAnnotation->validatorClassName ) ) {
                // 初始化验证器
                $validator = new $validatorAnnotation->validatorClassName;

                // 获取验证场景
                $scene = $methodName;   // 场景默认取方法名
                if( $sceneAnnotation && isset( $sceneAnnotation[ Scene::class ] ) ) {
                    $scene = $sceneAnnotation[ Scene::class ]->scene;
                }

                // 如果存在场景则执行验证
                if( $validator->hasScene( $scene ) ) {
                    // 获取请求数据
                    $requestData = array_merge( $request->getQueryParams(), ( array ) $request->getParsedBody() );

                    // 获取验证规则
                    $rules = $validator->getSceneRule( $scene, $requestData );
                    
                    // 验证信息
                    $messages = $validator->messages();

                    // 执行验证
                    $validation = $this->validationFactory->make( $requestData, $rules, $messages );

                    // 验证结果
                    if( $validation->fails() ) {
                        // 初始化响应
                        $result = new ServerResult;

                        // 错误信息
                        $result->data = $validation->errors()->all();

                        // 初始化返回数据
                        return $this->response->error( SystemCode::INVALID_DATA, $result );
                    }
                }
            }
        }

        // 响应
        $response = $handler->handle( $request );
        
        // next
        return $response;
    }
}