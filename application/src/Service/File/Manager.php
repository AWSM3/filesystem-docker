<?php
/**
 * Author: AWSM3
 * Manager.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Service\File;

/** @uses */
use App\Entity\File\File;
use App\Entity\File\FileInterface;
use App\Factory\File\FileFactory;
use App\Repository\File\FileRepository;
use App\Service\File\Exception\FileAlreadyExists;
use App\Service\File\Exception\FileNotFound;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Utils\Storage\File as FileStorage;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Manager
 *
 * @package App\Service\File
 */
class Manager implements ManagerInterface
{
    /** @var ContainerInterface */
    private $container;
    /** @var FileFactory*/
    private $fileFactory;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var FileRepository */
    private $fileRepository;
    /** @var FileStorage */
    private $fileStorage;

    /**
     * Service constructor.
     *
     * @param ContainerInterface $container
     * @param FileFactory $fileFactory
     * @param EntityManagerInterface $entityManager
     * @param FileRepository $fileRepository
     * @param FileStorage $fileStorage
     */
    public function __construct(
        ContainerInterface $container,
        FileFactory $fileFactory,
        EntityManagerInterface $entityManager,
        FileRepository $fileRepository,
        FileStorage $fileStorage
    ) {
        $this->container = $container;
        $this->fileFactory = $fileFactory;
        $this->entityManager = $entityManager;
        $this->fileRepository = $fileRepository;
        $this->fileStorage = $fileStorage;
    }

    /**
     * Upload file to system
     *
     * @param Request $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function uploadFile(Request $request): FileInterface
    {
        /** Create File entity object */
        $fileObject = $this->fileFactory->create($request);

        /** Checking file existence */
        try {
            $this->checkFileExists($fileObject);
        } catch (FileAlreadyExists $e) {
            /** Return existence file entity object */
            return $e->getEntity();
        }

        $file = $fileObject->getFile();
        try {
            /** Move file to new permament location */
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw $e;
        }

        return $fileObject;
    }

    /**
     * Get file entity
     *
     * @param string $id
     *
     * @return FileInterface
     * @throws FileNotFound
     */
    public function getFile(string $id): FileInterface
    {
        /** @var File $fileObject */
        $fileObject = $this->fileRepository->find($id);
        if (!$fileObject) {
            throw new FileNotFound('Требуемый файл не найден в базе данных.');
        }

        return $fileObject;
    }

    /**
     * Get files entities
     *
     * @param Request $request
     *
     * @return array
     */
    public function getFiles(Request $request): array
    {
        /** @var File[]|array $files */
        $files = $this->fileRepository->findBy(['id' => $request->request->get('files')]);

        return $files;
    }

    /**
     * @param string $id
     *
     * @return void
     * @throws FileNotFound
     */
    public function deleteFile(string $id): void
    {
        $fileObject = $this->getFile($id);
        $this->entityManager->remove($fileObject);
        $this->entityManager->flush();
    }

    /**
     * @param FileInterface $fileObject
     *
     * @throws FileAlreadyExists
     */
    private function checkFileExists(FileInterface $fileObject)
    {
        /** @var FileInterface $entity */
        $entity = $this->fileRepository->findOneBy([FileInterface::COLUMN_HASH => $fileObject->getHash()]);

        if ($entity) {
            throw new FileAlreadyExists($entity, 'Такой файл уже существует.');
        }
    }
}