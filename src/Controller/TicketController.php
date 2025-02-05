<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class TicketController extends AbstractController
{
    #[Route('/api/tickets', methods: ['POST'])]
    public function createTicket(Request $request, TicketRepository $ticketRepository, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Проверка данных, например, описание и статус
        if (empty($data['description']) || empty($data['status'])) {
            return new JsonResponse(['message' => 'Invalid data'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $ticket = new Ticket();
        $ticket->setDescription($data['description']);
        $ticket->setStatus($data['status']);
        $ticket->setCreatedAt(new \DateTime());
        $ticket->setUser($this->getUser()); // Предположим, что авторизованный пользователь создает тикет

        $ticketRepository->save($ticket, true);

        return new JsonResponse($serializer->normalize($ticket, null, ['groups' => ['ticket:read']]), JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/tickets', methods: ['GET'])]
    public function getTickets(TicketRepository $ticketRepository, SerializerInterface $serializer): JsonResponse
    {
        $tickets = $ticketRepository->findAll();

        return new JsonResponse($serializer->normalize($tickets, null, ['groups' => ['ticket:read']]), JsonResponse::HTTP_OK);
    }

    #[Route('/api/tickets/{id}', methods: ['GET'])]
    public function getTicket(int $id, TicketRepository $ticketRepository, SerializerInterface $serializer): JsonResponse
    {
        $ticket = $ticketRepository->find($id);

        if (!$ticket) {
            return new JsonResponse(['message' => 'Ticket not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($serializer->normalize($ticket, null, ['groups' => ['ticket:read']]), JsonResponse::HTTP_OK);
    }

    #[Route('/api/tickets/{id}', methods: ['PUT', 'PATCH'])]
    public function updateTicket(int $id, Request $request, TicketRepository $ticketRepository, SerializerInterface $serializer): JsonResponse
    {
        $ticket = $ticketRepository->find($id);

        if (!$ticket) {
            return new JsonResponse(['message' => 'Ticket not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (!empty($data['description'])) {
            $ticket->setDescription($data['description']);
        }

        if (!empty($data['status'])) {
            $ticket->setStatus($data['status']);
        }

        $ticketRepository->save($ticket, true);

        return new JsonResponse($serializer->normalize($ticket, null, ['groups' => ['ticket:read']]), JsonResponse::HTTP_OK);
    }

    #[Route('/api/tickets/{id}', methods: ['DELETE'])]
    public function deleteTicket(int $id, TicketRepository $ticketRepository): JsonResponse
    {
        $ticket = $ticketRepository->find($id);

        if (!$ticket) {
            return new JsonResponse(['message' => 'Ticket not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $ticketRepository->remove($ticket, true);

        return new JsonResponse(['message' => "Ticket $id deleted"], JsonResponse::HTTP_NO_CONTENT);
    }
}
