<?php
/**
 * Author: AWSM3
 * ManagerInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Service\File;

/** @uses */
use App\Entity\File\FileInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface ManagerInterface
 *
 * @package App\Service\File
 *
 */
interface ManagerInterface
{
    /**
     * Upload file to system
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function uploadFile(Request $request): FileInterface;

    /**
     * Get file entity
     *
     * @param string $id
     *
     * @return FileInterface
     */
    public function getFile(string $id): FileInterface;

    /**
     * Get files entities
     *
     * @param Request $request
     *
     * @return array
     */
    public function getFiles(Request $request): array;

    /**
     * @param string $id
     *
     * @return void
     */
    public function deleteFile(string $id): void;
}