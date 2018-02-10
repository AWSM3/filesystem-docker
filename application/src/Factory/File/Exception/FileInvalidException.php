<?php
/**
 * @filename: FileInvalidException.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Factory\File\Exception;

/** @uses */
use App\Entity\File\FileInterface;
use Symfony\Component\Form\FormErrorIterator;
use Throwable;

/**
 * Class FileInvalidException
 *
 * @package App\Factory\File\Exception
 */
class FileInvalidException extends \Exception
{
    /** @var FormErrorIterator */
    private $formErrorIterator;

    /**
     * FileInvalidException constructor.
     *
     * @param string $message
     * @param FormErrorIterator $formErrorIterator
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", FormErrorIterator $formErrorIterator, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->formErrorIterator = $formErrorIterator;
    }

    /**
     * @return FormErrorIterator
     */
    public function getFormErrorIterator(): FormErrorIterator
    {
        return $this->formErrorIterator;
    }

    /**
     * @param FormErrorIterator $formErrorIterator
     */
    public function setFormErrorIterator(FormErrorIterator $formErrorIterator): void
    {
        $this->formErrorIterator = $formErrorIterator;
    }
}