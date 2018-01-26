<?php
/**
 * Author: AWSM3
 * FileFactory.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Factory\File;

/** @uses */
use App\Entity\EntityInterface;
use App\Entity\File\File;
use App\Form\UploadFileType;
use App\Utils\Hash\File as FileHash;
use App\Utils\Storage\File as FileStorage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FileFactory
 *
 * @package App\Factory\File
 */
class FileFactory implements FileFactoryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var FormFactoryInterface */
    private $formFactory;
    /** @var */
    private $fileHasher;
    /** @var FileStorage */
    private $fileStorage;

    /**
     * FileFactory constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param FormFactoryInterface $formFactory
     * @param FileHash $fileHasher
     * @param FileStorage $fileStorage
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        FileHash $fileHasher,
        FileStorage $fileStorage
    )
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->fileHasher = $fileHasher;
        $this->fileStorage = $fileStorage;
    }

    /**
     * @param Request $request
     *
     * @return EntityInterface|File
     */
    public function create(Request $request): EntityInterface
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('file');
        $fileObject = new File();

        $form = $this->formFactory->create(UploadFileType::class, $fileObject);
        // $form->handleRequest($request); // ToDo: Почему не работает?
        $form->submit(array_merge($request->request->all(), $request->files->all())); // Приходится писать так

        if ($form->isValid()) {
            $fileHash = $this->fileHasher->hash($file->getRealPath());
            $fileObject->setHash($fileHash);
            $fileObject->setExtension($file->getClientOriginalExtension());
            $fileObject->setCreatedAt(new \DateTime());
            $fileObject->setUpdatedAt(new \DateTime());

            $this->entityManager->persist($fileObject);
        }

        return $fileObject;
    }
}