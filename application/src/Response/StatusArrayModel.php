<?php
/**
 * Author: AWSM3
 * StatusArrayModel.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Response;

/**
 * Class StatusArrayModel
 *
 * @package App\Response
 */
class StatusArrayModel extends AbstractArrayModel
{
    /**
     * @return array
     */
    protected function toArray(): array
    {
        return $this->responseArray;
    }
}