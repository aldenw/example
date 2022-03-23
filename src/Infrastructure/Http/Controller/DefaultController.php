<?php

namespace App\Infrastructure\Http\Controller;

use App\Domain\Command\AddDisputeResponseCommand;
use App\Domain\Command\CreateDisputeCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private MessageBusInterface $commandBus;

    /**
     * @param MessageBusInterface $commandBus
     */
    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route(path="/dispute/{caseNumber}", methods={"POST"})
     */
    public function createDispute(string $caseNumber)
    {
        $this->commandBus->dispatch(new CreateDisputeCommand($caseNumber));

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route(path="/dispute/{caseNumber}/response/{message}", methods={"POST"})
     */
    public function addDisputeResponse(string $caseNumber, string $message)
    {
        $this->commandBus->dispatch(new AddDisputeResponseCommand($caseNumber, $message));

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}