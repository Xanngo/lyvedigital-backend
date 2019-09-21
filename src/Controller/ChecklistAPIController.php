<?php
// src/Controller/ChecklistAPIController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Service\ChecklistService;

class ChecklistAPIController extends AbstractController
{
    /**
     * @Route("/api/checklist", name="api_checklist", methods={"POST"})
     */
    public function checklistAction(Request $request, ChecklistService $checklistService)
    {
        $jsonBody = $request->getContent();
        $body = json_decode($jsonBody);

        if (!$body && !isset($body->content)) {
            return new JsonResponse([
                "error" => "Malformed or missing content."
            ], 400);
        }

        $analizedContent = $checklistService->analize($body->content);

        if (!$analizedContent) {
            $min_number_of_words = $checklistService->getMinNumberOfWords();
            return new JsonResponse([
                "error" => "Invlid content. It must contain more than $min_number_of_words words."
            ], 400);
        }

        return new JsonResponse($analizedContent);
    }
}