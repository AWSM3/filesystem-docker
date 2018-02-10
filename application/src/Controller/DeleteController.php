<?php
/**
 * Author: AWSM3
 * DeleteController.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Controller;

/** @uses */
use App\Response\StatusArrayModel;
use App\Service\File\ManagerInterface;
use Symfony\Component\{
    HttpFoundation\JsonResponse, HttpFoundation\Request, Routing\Annotation\Route
};
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DeleteController
 *
 * @package App\Controller
 */
class DeleteController extends Controller
{
    /** @var ManagerInterface */
    private $fileManager;
    /** @var StatusArrayModel */
    private $statusArrayModel;

    /**
     * UploadController constructor.
     *
     * @param ManagerInterface $fileManager
     * @param StatusArrayModel $statusArrayModel
     */
    public function __construct(ManagerInterface $fileManager, StatusArrayModel $statusArrayModel)
    {
        $this->fileManager = $fileManager;
        $this->statusArrayModel = $statusArrayModel;
    }

    /**
     * @Route("/delete", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $responseModel = $this->statusArrayModel;
        try {
            $this->fileManager->deleteFile($request->get('id'));
            $status = true;
        } catch (\Exception $e) {
            $responseModel->setMessages([$e->getMessage()]);
            $status = false;
        }

        return new JsonResponse($responseModel($status));
    }
}