<?php declare(strict_types=1);

namespace Api\Application\ViewModel;

class ValidationErrorViewModel
{
    /** @var integer */
    private $code;
    /** @var array */
    private $message;

    /**
     * ValidationErrorViewModel constructor.
     * @param int $code
     * @param array $message
     */
    public function __construct(
        int $code,
        array $message
    ) {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getMessage(): array
    {
        return $this->message;
    }
}
