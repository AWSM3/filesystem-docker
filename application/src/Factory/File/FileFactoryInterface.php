<?php
/**
 * Author: AWSM3
 * FileFactoryInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Factory\File;

/** @uses */
use App\Entity\EntityInterface;
use App\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface FileFactoryInterface
 *
 * @package App\Factory\File
 */
interface FileFactoryInterface extends FactoryInterface
{
    /**
     * @param Request $request
     *
     * @return EntityInterface
     */
    public function create(Request $request): EntityInterface;
}