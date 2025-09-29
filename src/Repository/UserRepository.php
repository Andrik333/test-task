<?php

namespace App\Repository;

use App\Entity\User;
use App\Components\Encryption;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param string $login
     * 
     * @return User|null
     */
    public function getUser(string $login): ?User
    {
        $qb = $this->createQueryBuilder('u');

        return $qb->select('u')
            ->where('u.login = :login')
            ->setParameter('login', Encryption::encrypt($login))
            ->getQuery()
            ->getOneOrNullResult();
    }
}
