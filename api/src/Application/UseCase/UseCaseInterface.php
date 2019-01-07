<?php declare(strict_types=1);

namespace Api\Application\UseCase;

interface UseCaseInterface
{
    /**
     * @param CommandQueryInterface $commandQuery
     * @return ViewModelInterface
     */
    public function execute(CommandQueryInterface $commandQuery): ViewModelInterface;
}
