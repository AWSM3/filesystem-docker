<?php
/**
 * Author: AWSM3
 * ArrayModel.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Response\File;

/** @uses */
use App\Entity\File\File;
use App\Response\AbstractArrayModel;
use App\Utils\Http\Request;

/**
 * Class ArrayModel
 *
 * @package App\Response\File
 *
 * @property File $data
 */
class ArrayModel extends AbstractArrayModel
{
    /** @var Request */
    private $requestUtil;

    /**
     * ArrayModel constructor.
     *
     * @param Request $requestUtil
     */
    public function __construct(Request $requestUtil)
    {
        $this->requestUtil = $requestUtil;
    }

    /**
     * @return array
     */
    protected function toArray(): array
    {
        if (!$this->data) {
            return [];
        }

        if (is_array($this->data)) {
            foreach ($this->data as $file) {
                /** @var File $file */
                $data[$file->getId()] = $this->objectToArray($file);
            }
        } elseif ($this->data instanceof File) {
            $data = $this->objectToArray($this->data);
        }

        return [static::DATA_KEY => $data];
    }

    /**
     * @param File $file
     *
     * @return array
     */
    private function objectToArray(File $file): array {
        return [
            'url'       => $this->requestUtil->makeAbsolutePublicPath($file->getPublicPath()),
            'title'     => $file->getTitle(),
            'id'        => $file->getId(),
            'extension' => $file->getExtension(),
            'filename'  => $file->getFilenameWithExtension(),
        ];
    }
}