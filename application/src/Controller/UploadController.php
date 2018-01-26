<?php
/**
 * Author: AWSM3
 * UploadController.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Controller;

/** @uses */
use App\Response\File\ArrayModel;
use App\Service\File\ManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\{
    HttpFoundation\JsonResponse, HttpFoundation\Request, Routing\Annotation\Route
};

/**
 * Class UploadController
 *
 * @package App\Controller
 */
class UploadController extends Controller
{
    /** @var ManagerInterface */
    private $fileManager;
    /** @var ArrayModel */
    private $arrayModel;

    /**
     * UploadController constructor.
     *
     * @param ManagerInterface $fileManager
     * @param ArrayModel $arrayModel
     */
    public function __construct(ManagerInterface $fileManager, ArrayModel $arrayModel)
    {
        $this->fileManager = $fileManager;
        $this->arrayModel = $arrayModel;
    }

    /**
     * @Route("/upload", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        $file = $this->fileManager->uploadFile($request);
        $responseModel = $this->arrayModel->setData($file);

        return new JsonResponse($responseModel());
    }
}