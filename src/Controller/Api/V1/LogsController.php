<?php

namespace App\Controller\Api\V1;

use App\Service\LogServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     "/api/v1/logs", name="logs_")
 */
class LogsController extends AbstractController
{
    /**
     * @Route("", methods={"GET","HEAD"}, name="list")
     */
    public function index(LogServiceInterface $logService): Response
    {
        $logsList = $logService->getLogsList();

        return $this->json($logsList);
    }


}
