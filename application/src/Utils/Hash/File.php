<?php
/**
 * Author: AWSM3
 * File.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Utils\Hash;

/**
 * Class File
 *
 * @package App\Utils\Hash
 */
class File
{
    const HASH_ALGO = 'sha256';

    /**
     * @param string $filename
     *
     * @return string
     */
    public function hash(string $filename): string
    {
        return hash_file(self::HASH_ALGO, $filename);
    }
}