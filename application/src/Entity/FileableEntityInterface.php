<?php
/**
 * Author: AWSM3
 * FileableEntityInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Entity;

/** @uses */

use SplFileInfo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface FileableEntityInterface
 *
 * @package App\Entity
 */
interface FileableEntityInterface
{
    /**
     * @return null|File|UploadedFile|SplFileInfo
     */
    public function getFile(): ?SplFileInfo;

    /**
     * @return string
     */
    public function getAbsoluteFilepath(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string
     */
    public function getPublicPath(): string;

    /**
     * @return string
     */
    public function getExtension(): string;

    /**
     * @return string
     */
    public function getFilenameWithExtension(): string;

    /**
     * @param SplFileInfo $value
     *
     * @return void
     */
    public function setFile(SplFileInfo $value): void;

    /**
     * @param string $value
     *
     * @return void
     */
    public function setPath(string $value): void;

    /**
     * @param string $value
     *
     * @return void
     */
    public function setPublicPath(string $value): void;

    /**
     * @param string $value
     *
     * @return void
     */
    public function setExtension(string $value): void;
}