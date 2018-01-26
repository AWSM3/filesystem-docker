<?php
/**
 * Author: AWSM3
 * FileInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Entity\File;

/** @uses */
use App\Entity\EntityInterface;
use App\Entity\FileableEntityInterface;

/**
 * Interface FileInterface
 *
 * @package App\Entity\File
 */
interface FileInterface extends EntityInterface, FileableEntityInterface
{
    const
        COLUMN_HASH = 'hash';

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getHash(): string;

    /**
     * @return null|string
     */
    public function getTitle(): ?string;

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface;

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface;
}