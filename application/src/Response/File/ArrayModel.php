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

        $data = [
            'url'       => $this->requestUtil->makeAbsolutePublicPath($this->data->getPublicPath()),
            'title'     => $this->data->getTitle(),
            'id'        => $this->data->getId(),
            'extension' => $this->data->getExtension(),
            'filename'  => $this->data->getFilenameWithExtension(),
        ];

        return [static::DATA_KEY => $data];
    }
}