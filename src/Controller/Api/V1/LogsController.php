<?php

namespace App\Controller\Api\V1;

use App\Http\Criteria\RequestCriteria;
use App\Service\LogCacheInterface;
use App\Service\LogServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Symfony\Component\Routing\Annotation\Route(
 *     "/api/v1/logs",
 *      name="logs_"
 * )
 */
class LogsController extends AbstractController
{
    protected LogServiceInterface $logService;

    public function __construct(LogServiceInterface $logService)
    {
        $this->logService = $logService;
    }

    /**
     * @Symfony\Component\Routing\Annotation\Route(
     *     "",
     *     methods={"GET","HEAD"},
     *     name="list"
     * )
     */
    public function index(): Response
    {
        $logsList = $this->logService->getLogsList();

        return $this->json($logsList);
    }

    /**
     * @Symfony\Component\Routing\Annotation\Route(
     *     "/{logName}",
     *     methods={"GET","HEAD"},
     *     requirements={"logName"="[\w\-\.]+"},
     *     name="show"
     * )
     */
    public function show(string $logName, LogCacheInterface $cacheService, Request $request): Response
    {
        try {
            $dataIterator = $this->logService->getLogData($logName);
        } catch (\Throwable $throwable) {
            return $this->json([
                'error' => 'Log file not found'
            ], 404);
        }

        $cacheService->checkAndUpdate($logName, $dataIterator);
        $requestCriteria = new RequestCriteria($request);
        $result = $cacheService->getPaginatedLogItems($logName, $requestCriteria);

        return $this->json($result);
    }
}
