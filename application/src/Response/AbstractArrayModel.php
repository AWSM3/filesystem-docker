<?php
/**
 * Author: AWSM3
 * AbstractArrayModel.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Response;

/**
 * Class AbstractArrayModel
 *
 * @package App\Response
 */
abstract class AbstractArrayModel
{
    const
        STATUS_KEY = 'status',
        STATUS_STATE = false,

        MESSAGES_KEY = 'messages',
        MESSAGES_STATE = [],

        DATA_KEY = 'data',
        DATA_STATE = null;

    /** @var mixed */
    protected $data;

    /** @var array */
    protected $responseArray = [
        self::STATUS_KEY   => self::STATUS_STATE,
        self::MESSAGES_KEY => self::MESSAGES_STATE,
        self::DATA_KEY     => self::DATA_STATE,
    ];

    /**
     * @param bool $status
     *
     * @return array
     */
    public function __invoke(bool $status = self::STATUS_STATE): array
    {
        $this->responseArray[self::STATUS_KEY] = $status;

        return array_merge($this->responseArray, $this->toArray());
    }


    /** ================================================================ */

    /**
     * @param $data
     *
     * @return self
     */
    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    abstract protected function toArray(): array;
}