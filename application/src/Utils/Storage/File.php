<?php
/**
 * Author: AWSM3
 * File.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Utils\Storage;

/** @uses */
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use \SplFileInfo;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class File
 *
 * @package App\Utils\Storage
 */
class File
{
    /** @var ContainerInterface */
    private $container;
    /** @var Filesystem */
    private $filesystem;

    /**
     * File constructor.
     *
     * @param ContainerInterface $container
     * @param Filesystem $filesystem
     */
    public function __construct(ContainerInterface $container, Filesystem $filesystem)
    {
        $this->container = $container;
        $this->filesystem = $filesystem;
    }

    /**
     * @param UploadedFile $file
     * @param string $path
     * @param string $filename
     */
    public function moveFile(UploadedFile $file, string $path, string $filename): void
    {
        $file->move($path, $filename);
    }

    /**
     * @param string $filepath
     *
     * @return SymfonyFile
     */
    public function getFile(string $filepath): SymfonyFile
    {
        if (!$this->filesystem->exists($filepath)) {
            throw new FileNotFoundException('Требуемый файл не найден: '.$filepath.' не существует.');
        }

        return new SymfonyFile($filepath);
    }

    /**
     * @param SplFileInfo $file
     */
    public function removeFile(SplFileInfo $file): void
    {
        $this->filesystem->remove($file->getRealPath());
        /** @ToDo: можно реализовать проверку директории на наличие файлов и удалять её, если она пуста */
    }

    /**
     * @param string $fileName
     *
     * @param string $directory
     *
     * @return string
     */
    public function getFilepath(string $fileName, string $directory = ''): string
    {
        $sharding = $this->getFileSharding($fileName);
        $storageDir = $this->container->getParameter('filestorage_dir');
        if ($directory) {
            $storageDir .= DIRECTORY_SEPARATOR.$directory;
        }

        return $storageDir.DIRECTORY_SEPARATOR.$sharding;
    }

    /**
     * @param $filePath
     * @param $host
     *
     * @return string
     */
    public function getPublicPath($filePath, $filename, $host): string
    {
        $publicDirName = '/public';
        $position = stripos($filePath, $publicDirName) + strlen($publicDirName);
        $publicPath = substr($filePath, $position).DIRECTORY_SEPARATOR.$filename;

        return $publicPath;
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    private function getFileSharding(string $filename = ''): string
    {
        $sharding = date('d_m_Y');
        if ($filename) {
            $sharding = substr($filename, 0, 5).'_'.$sharding;
        }

        return $sharding;
    }
}