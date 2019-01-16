<?php declare(strict_types=1);

namespace Sw\Util;

use ReflectionMethod;
use Exception;

class SwClassMethod
{
    use MergedPropertiesTrait;

    /** @var SwEndpoint  */
    private $swEndpoint;
    /** @var MethodSignature */
    private $methodSignature;

    /**
     * SwClassMethod constructor.
     * @param SwEndpoint $swEndpoint
     */
    public function __construct(SwEndpoint $swEndpoint)
    {
        $this->swEndpoint = $swEndpoint;
    }

    /**
     * @throws Exception
     */
    public function process(): void
    {
        $this->methodSignature = $this->createMethodSignature(
            $this->swEndpoint->getReflectionMethod()
        );

        $this->addCommandQueryParameters();
        $this->addViewModelParameters();
    }

    /**
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    protected function addCommandQueryParameters(): void
    {
        $commandQuery = new SwClassMethodCommandQuery(
            $this->methodSignature->getParameters(),
            $this->swEndpoint
        );

        $commandQuery->process();
    }

    /**
     * @throws Exception
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    protected function addViewModelParameters(): void
    {
        $viewModel = new SwClassMethodViewModel(
            $this->swEndpoint,
            $this->methodSignature->getReturnType()
        );

        $viewModel->process();
    }

    /**
     * @param ReflectionMethod $method
     * @return MethodSignature
     */
    protected function createMethodSignature(ReflectionMethod $method): MethodSignature
    {
        return new MethodSignature(
            $method->getParameters(),
            $method->getReturnType()
        );
    }
}
