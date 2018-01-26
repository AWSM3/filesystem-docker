<?php
/**
 * Author: AWSM3
 * FileAlreadyExists.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Service\File\Exception;

/** @uses */
use App\Entity\File\FileInterface;
use Throwable;

/**
 * Class FileAlreadyExists
 *
 * @package App\Service\File\Exception
 */
class FileAlreadyExists extends \Exception
{
    /** @var FileInterface */
    private $entity;

    /**
     * FileAlreadyExists constructor.
     *
     * @param FileInterface $entity
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(FileInterface $entity, string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->entity = $entity;
    }

    /**
     * @return FileInterface
     */
    public function getEntity(): FileInterface
    {
        return $this->entity;
    }

    /**
     * @param FileInterface $entity
     */
    public function setEntity(FileInterface $entity): void
    {
        $this->entity = $entity;
    }
}