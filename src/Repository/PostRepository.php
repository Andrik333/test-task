<?php

namespace App\Repository;

use App\Entity\Post;
use App\Components\Encryption;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    /**
     * @return Post[]
     */
    public function getPosts(): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $res = $qb->select('p.id as id, p.text as text, u.login as autor')
            ->from(Post::class, 'p')
            ->join('p.autor', 'u')
            ->setFirstResult(0)
            ->setMaxResults(12)
            ->getQuery()
            ->getScalarResult();

        foreach ($res as $key => $post) {
            $res[$key]['autor'] = Encryption::decrypt($post['autor']);
        }

        return $res;
    }
}