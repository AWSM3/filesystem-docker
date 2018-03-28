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
     * Загрузить файл в хранилище
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function uploadFile(Request $request): FileInterface;

    /**
     * Получить конкретный файл по ID
     *
     * @param string $id
     *
     * @return FileInterface
     */
    public function getFile(string $id): FileInterface;

    /**
     * Получить множество файлов на основе данных реквеста
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

    /**
     * Получить файл по определеённому параметру из реквеста
     *
     * @param Request $request
     *
     * @return FileInterface
     */
    public function getFileByParam(Request $request): FileInterface;
}