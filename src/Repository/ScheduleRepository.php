<?php
/**
 * Created by PhpStorm.
 * User: Manto PC
 * Date: 2018-11-07
 * Time: 13:38
 */

namespace App\Repository;

use App\Entity\Schedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Schedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schedule[]    findAll()
 * @method Schedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class ScheduleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Schedule::class);
    }

    public function getAllUserSchedules($user)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s.id, s.title, s.description, s.scheduledEndDate
                      FROM App\Entity\Schedule s
                      INNER JOIN App\Entity\UsersToSchedule uts
                      WHERE uts.fkSchedule = s.id
                      AND uts.fkUser = :userId
                      ORDER BY s.scheduledEndDate DESC'
            )
            ->setParameter('userId', $user)
            ->getArrayResult();
    }

}