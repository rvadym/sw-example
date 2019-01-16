<?php declare(strict_types=1);

namespace Sw\Util;

use Calcinai\Strut\Definitions\Header;
use Calcinai\Strut\Definitions\Headers;
use Calcinai\Strut\Definitions\Operation;
use Calcinai\Strut\Definitions\PathItem;
use Calcinai\Strut\Definitions\QueryParameterSubSchema;
use Calcinai\Strut\Definitions\Response;
use Calcinai\Strut\Definitions\Responses;
use Calcinai\Strut\Definitions\Schema;
use Calcinai\Strut\Definitions\Schema\Properties\Properties;
use Exception;
use ReflectionMethod;
use ReflectionClass;

class SwEndpoint
{
    /* <<< Endpoint configs */
    /** @var ReflectionClass  */
    private $reflectionClass;
    /** @var ReflectionMethod  */
    private $reflectionMethod;
    /** @var string  */
    private $endpoint;
    /** @var string */
    private $method;
    /** @var string  */
    private $summary;
    /** @var string  */
    private $operationId;
    /** @var string  */
    private $tag;
    /* Endpoint configs >>> */

    /* <<< Command/Query */
    /** @var QueryParameterSubSchema[]  */
    private $queryParameters = [];
    /* Command/Query >>> */

    /* <<< Response */
    /** @var Response[]  */
    private $responses = [];
    /* Response >>> */

    public function __construct(
        ReflectionClass $reflectionClass,
        ReflectionMethod $reflectionMethod,
        string $endpoint,
        string $method,
        string $summary,
        string $operationId,
        string $tag
    ) {
        $this->reflectionClass = $reflectionClass;
        $this->reflectionMethod = $reflectionMethod;
        $this->endpoint = $endpoint;
        $this->method = $method;
        $this->summary = $summary;
        $this->operationId = $operationId;
        $this->tag = $tag;
    }

    /**
     * @return ReflectionClass
     */
    public function getReflectionClass(): ReflectionClass
    {
        return $this->reflectionClass;
    }

    /**
     * @return ReflectionMethod
     */
    public function getReflectionMethod(): ReflectionMethod
    {
        return $this->reflectionMethod;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @param QueryParameterSubSchema $queryParameters
     */
    public function addParameters(QueryParameterSubSchema $queryParameters): void
    {
        $this->queryParameters[] = $queryParameters;
    }

    /**
     * @param int $code
     * @param Response $response
     */
    public function addResponse(int $code, Response $response): void
    {
        $this->responses[$code] = $response;
    }

    /**
     * @return PathItem
     * @throws Exception
     */
    public function getPathItem(): PathItem
    {
        $operation = Operation::create();
        $operation
            ->setSummary($this->summary)
            ->setOperationId($this->operationId)
            ->addTag($this->tag);

        /** @var QueryParameterSubSchema $queryParameter */
        foreach ($this->queryParameters as $queryParameter) {
            $operation->addParameter($queryParameter);
        }

        $responses = Responses::create();
        $operation->setResponses($responses);

        /** @var Response $response */
        foreach ($this->responses as $code => $response) {
            $responses->set($code, $response);
        }

        $pathItem = PathItem::create();
        $pathItem->setGet($operation);

        return $pathItem;
    }

//    /**
//     * @return Schema
//     * @throws Exception
//     */
//    protected function getErrorSchema(): Schema
//    {
//       // One result
//
//        return Schema::create()
//            ->addRequired('code')
//            ->addRequired('message')
//
//            ->setProperties(
//                Properties::create()
//                    ->set(
//                        'code',
//                        Schema::create()
//                            ->setType('integer')
//                            ->setFormat('int64')
//                    )
//                    ->set(
//                        'error',
//                        Schema::create()
//                            ->setType('string')
//                    )
//            );
//
//       // Collection
//
//        $pet = Schema::create()
//            ->addRequired('id')
//            ->addRequired('name')
//
//            ->setProperties(
//                Properties::create()
//                    ->set(
//                        'id',
//                        Schema::create()
//                            ->setType('integer')
//                            ->setFormat('int64')
//                    )
//                    ->set(
//                        'name',
//                        Schema::create()
//                            ->setType('string')
//                    )
//                    ->set(
//                        'tag',
//                        Schema::create()
//                            ->setType('string')
//                    )
//            );
//
//        return Schema::create()
//            ->setType('array')
//            ->setItems($pet);
//    }
}
