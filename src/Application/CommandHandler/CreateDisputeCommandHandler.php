<?php

namespace App\Application\CommandHandler;

use App\Domain\Command\CreateDisputeCommand;
use App\Domain\Model\Dispute;
use App\Domain\Repository\DisputeRepositoryInterface;

class CreateDisputeCommandHandler implements CommandHandlerInterface
{
    private DisputeRepositoryInterface $disputeRepository;

    public function __construct(DisputeRepositoryInterface $disputeRepository)
    {
        $this->disputeRepository = $disputeRepository;
    }

    public function __invoke(CreateDisputeCommand $command)
    {
        $this->disputeRepository->add(new Dispute($command->getCaseNumber()));
    }
}