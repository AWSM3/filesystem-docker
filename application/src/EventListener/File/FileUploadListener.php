<?php
/**
 * Author: AWSM3
 * FileUploadListener.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\EventListener\File;

/** @uses */
use App\Entity\FileableEntityInterface;
use App\Utils\Storage\File as FileStorage;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class FileUploadListener
 *
 * @package App\EventListener\File
 */
class FileUploadListener
{
    /** @var FileStorage */
    private $fileStorage;
    /** @var Request */
    private $request;

    /**
     * FileUploadListener constructor.
     *
     * @param FileStorage $fileStorage
     * @param RequestStack $requestStack
     */
    public function __construct(FileStorage $fileStorage, RequestStack $requestStack)
    {
        $this->fileStorage = $fileStorage;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return void
     * @throws \Exception
     */
    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        if (!$entity instanceof FileableEntityInterface) {
            return;
        }

        $this->uploadFile($entity);
        $entityManager->flush($entity);
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return void
     */
    public function postLoad(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        if (!$entity instanceof FileableEntityInterface) {
            return;
        }

        if ($entity->getAbsoluteFilepath()) {
            $entity->setFile($this->getFile($entity));
        }
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return void
     */
    public function postRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        if (!$entity instanceof FileableEntityInterface) {
            return;
        }

        if ($entity->getFile()) {
            $this->removeFile($entity);
        }
    }

    /**
     * Upload only works for Fileable entities
     *
     * @param FileableEntityInterface $entity
     *
     * @return void
     * @throws \Exception
     */
    private function uploadFile(FileableEntityInterface $entity): void
    {
        $file = $entity->getFile();

        if ($file instanceof UploadedFile) {
            $fileName = $entity->getFilenameWithExtension();
            $filePath = $this->fileStorage->getFilepath($fileName);
            $entity->setPath($filePath);
            $entity->setPublicPath($this->fileStorage->getPublicPath($filePath, $fileName, $this->request->getSchemeAndHttpHost()));
            try {
                $this->fileStorage->moveFile($file, $entity->getPath(), $entity->getFilenameWithExtension());
            } catch (\Exception $e) {
                throw $e;
            }

            $file = $this->getFile($entity);
            $entity->setFile($file);
        }
    }

    /**
     * @param FileableEntityInterface $entity
     *
     * @return File
     */
    private function getFile(FileableEntityInterface $entity): File
    {
        return $this->fileStorage->getFile($entity->getAbsoluteFilepath());
    }

    /**
     * @param FileableEntityInterface $entity
     *
     * @return void
     */
    private function removeFile(FileableEntityInterface $entity): void
    {
        $this->fileStorage->removeFile($entity->getFile());
    }
}