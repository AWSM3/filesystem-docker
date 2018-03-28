<?php
/**
 * Author: AWSM3
 * GetController.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Controller;

/** @uses */
use App\Response\File\ArrayModel;
use App\Service\File\ManagerInterface;
use Symfony\Component\{
    HttpFoundation\JsonResponse, HttpFoundation\Request, Routing\Annotation\Route
};
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class GetController
 *
 * @package App\Controller
 */
class GetController extends Controller
{
    /** @var ManagerInterface */
    private $fileManager;
    /** @var ArrayModel */
    private $arrayModel;

    /**
     * GetController constructor.
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
     * @Route(
     *     "/file/{id}",
     *     requirements={
     *         "id": "[\w-]+"
     *     },
     *     methods={"GET"},
     *     name="get_file"
     * )
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function getFile(string $id): JsonResponse
    {
        $responseModel = $this->arrayModel;
        try {
            $file = $this->fileManager->getFile($id);
            $responseModel = $responseModel->setData($file);
            $status = true;
        } catch (\Exception $e) {
            $responseModel->setMessages([$e->getMessage()]);
            $status = false;
        }

        return new JsonResponse($responseModel($status));
    }

    /**
     * @Route(
     *     "/files",
     *     methods={"POST"},
     *     name="get_files"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getFiles(Request $request): JsonResponse
    {
        $responseModel = $this->arrayModel;
        try {
            $files = $this->fileManager->getFiles($request);
            $responseModel->setData($files);
            $status = true;
        } catch (\Exception $e) {
            $responseModel->setMessages([$e->getMessage()]);
            $status = false;
        }

        return new JsonResponse($responseModel($status));
    }

    /**
     * @Route(
     *     "/file/by-param",
     *     methods={"POST"},
     *     name="get_file_by_param"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getFileByParam(Request $request): JsonResponse
    {
        $responseModel = $this->arrayModel;
        try {
            $file = $this->fileManager->getFileByParam($request);
            $responseModel->setData($file);
            $status = true;
        } catch (\Exception $e) {
            $responseModel->setMessages([$e->getMessage()]);
            $status = false;
        }

        return new JsonResponse($responseModel($status));
    }
}