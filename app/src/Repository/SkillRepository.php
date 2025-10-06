<?php

namespace App\Repository;

use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Skill>
 */
class SkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skill::class);
    }

    /**
     * Find all active skills ordered by category and sort order
     */
    public function findActiveSkills(): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.active = :active')
            ->setParameter('active', true)
            ->orderBy('s.category', 'ASC')
            ->addOrderBy('s.sortOrder', 'ASC')
            ->addOrderBy('s.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find skills by category
     */
    public function findSkillsByCategory(string $category): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.active = :active')
            ->andWhere('s.category = :category')
            ->setParameter('active', true)
            ->setParameter('category', $category)
            ->orderBy('s.sortOrder', 'ASC')
            ->addOrderBy('s.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Get all skill categories
     */
    public function getCategories(): array
    {
        return $this->createQueryBuilder('s')
            ->select('DISTINCT s.category')
            ->where('s.active = :active')
            ->andWhere('s.category IS NOT NULL')
            ->setParameter('active', true)
            ->orderBy('s.category', 'ASC')
            ->getQuery()
            ->getSingleColumnResult();
    }

    /**
     * Find skills grouped by category
     */
    public function findSkillsGroupedByCategory(): array
    {
        $skills = $this->findActiveSkills();
        $grouped = [];

        foreach ($skills as $skill) {
            $category = $skill->getCategory() ?? 'Autres';
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][] = $skill;
        }

        return $grouped;
    }
}

