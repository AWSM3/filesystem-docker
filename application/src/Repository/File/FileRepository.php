<?php
/**
 * @author: AWSM3
 * Repository.php
 */
declare(strict_types=1);

/** @file */
namespace App\Repository\File;

/** @uses */
use App\Entity\File\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class FileRepository
 *
 * @package App\Repository\File
 */
class FileRepository extends ServiceEntityRepository
{
    /**
     * FileRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, File::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('f')
            ->where('f.something = :value')->setParameter('value', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
