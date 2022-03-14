<?php

namespace App\Application\CommandHandler;

use App\Domain\Command\AddDisputeResponseCommand;
use App\Domain\Model\Exception\DisputeIsLockedException;
use App\Domain\Repository\DisputeRepositoryInterface;
use Doctrine\DBAL\LockMode;

class AddDisputeResponseCommandHandler implements CommandHandlerInterface
{
    private DisputeRepositoryInterface $disputeRepository;

    public function __construct(DisputeRepositoryInterface $disputeRepository)
    {
        $this->disputeRepository = $disputeRepository;
    }

    /**
     * @throws DisputeIsLockedException
     */
    public function __invoke(AddDisputeResponseCommand $command)
    {
        /**
         * Because from the repository we use the LockMode::PESSIMISTIC_WRITE
         * the row for this dispute will be locked, prevent any other processes
         * from reading that database row until we have finished.
         *
         * We want this, because we will be updating that row to mark it as locked,
         * and we don't want there to be race conditions with other processes.
         *
         * Note it's not the entire table that will be locked, but only the single
         * row for this given id.
         *
         * The "outer" transaction handling is being done by the doctrine
         * transaction middleware, which has the whole handling wrapped in a
         * transaction which flushes the database and commits the transaction
         * at the end, or rolls it back on failure.
         */
        $dispute = $this->disputeRepository->findByCaseNumber(
            $command->getCaseNumber(),
            LockMode::PESSIMISTIC_WRITE
        );
        $dispute->addDisputeResponse($command->getMessage());
    }
}