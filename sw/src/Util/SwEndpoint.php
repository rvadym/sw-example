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

class SwEndpoint
{
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

    public function __construct(
        string $endpoint,
        string $method,
        string $summary,
        string $operationId,
        string $tag
    ) {
        $this->endpoint = $endpoint;
        $this->method = $method;
        $this->summary = $summary;
        $this->operationId = $operationId;
        $this->tag = $tag;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @return PathItem
     * @throws Exception
     */
    public function getPathItem(): PathItem
    {
        return PathItem::create()
            ->setGet(
                Operation::create()
                    ->setSummary($this->summary)
                    ->setOperationId($this->operationId)
                    ->addTag($this->tag)

                    ->addParameter(
                        QueryParameterSubSchema::create()
                            ->setName('Limit')
                            ->setDescription('How many items to return at one time (max 100)')
                            ->setRequired(false)
                            ->setType('integer')
                            ->setFormat('int64')
                    )

                    ->setResponses(
                        Responses::create()
                            ->set(
                                '200',
                                Response::create()
                                    ->setDescription('A paged array of pets')
                                    ->setHeaders(
                                        Headers::create()
                                            ->set('x-next',
                                                Header::create()
                                                    ->setType('string')
                                                    ->setDescription('A link to the next page of responses')
                                            )
                                    )
                                    ->setSchema(
                                        $this->getSuccessSchema()
                                    )
                            )
                            ->set('default', Response::create()
                                ->setDescription('Unexpected error')
                                ->setSchema(
                                    $this->getErrorSchema()
                                )
                            )
                    )
            );
    }

    /**
     * @return Schema
     * @throws Exception
     */
    protected function getSuccessSchema(): Schema
    {
        $pet = Schema::create()
            ->addRequired('id')
            ->addRequired('name')

            ->setProperties(
                Properties::create()
                    ->set(
                        'id',
                        Schema::create()
                            ->setType('integer')
                            ->setFormat('int64')
                    )
                    ->set(
                        'name',
                        Schema::create()
                            ->setType('string')
                    )
                    ->set(
                        'tag',
                        Schema::create()
                            ->setType('string')
                    )
            );

        return Schema::create()
            ->setType('array')
            ->setItems($pet);
    }

    /**
     * @return Schema
     * @throws Exception
     */
    protected function getErrorSchema(): Schema
    {
        return Schema::create()
            ->addRequired('code')
            ->addRequired('message')

            ->setProperties(
                Properties::create()
                    ->set(
                        'code',
                        Schema::create()
                            ->setType('integer')
                            ->setFormat('int64')
                    )
                    ->set(
                        'error',
                        Schema::create()
                            ->setType('string')
                    )
            );
    }

}
