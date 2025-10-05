<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * Find all active projects ordered by sort order
     */
    public function findActiveProjects(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.active = :active')
            ->setParameter('active', true)
            ->orderBy('p.sortOrder', 'ASC')
            ->addOrderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find featured projects
     */
    public function findFeaturedProjects(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.active = :active')
            ->andWhere('p.featured = :featured')
            ->setParameter('active', true)
            ->setParameter('featured', true)
            ->orderBy('p.sortOrder', 'ASC')
            ->addOrderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find projects by category
     */
    public function findProjectsByCategory(string $category): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.active = :active')
            ->andWhere('p.category = :category')
            ->setParameter('active', true)
            ->setParameter('category', $category)
            ->orderBy('p.sortOrder', 'ASC')
            ->addOrderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find projects by technology
     */
    public function findProjectsByTechnology(string $technology): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.active = :active')
            ->andWhere('p.technologies LIKE :technology')
            ->setParameter('active', true)
            ->setParameter('technology', '%"' . $technology . '"%')
            ->orderBy('p.sortOrder', 'ASC')
            ->addOrderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
