<?php
/**
 * Created by PhpStorm.
 * User: Manto PC
 * Date: 2018-11-07
 * Time: 13:38
 */

namespace App\Repository;

use App\Entity\UsersToSchedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UsersToSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersToSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersToSchedule[]    findAll()
 * @method UsersToSchedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class UsersToScheduleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UsersToSchedule::class);
    }

    public function getScheduleByUser($scheduleid, $userid)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s.id
                      FROM App\Entity\UsersToSchedule s
                      WHERE s.fkSchedule = :scheduleid
                      AND s.fkUser = :userId'
            )
            ->setParameter('userId', $userid)
            ->setParameter('scheduleid',$scheduleid)
            ->getOneOrNullResult();
    }

}