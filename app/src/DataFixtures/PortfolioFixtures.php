<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PortfolioFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Skills
        $skills = [
            // Frontend
            ['name' => 'HTML5', 'icon' => 'fab fa-html5', 'level' => 95, 'color' => '#e34f26', 'category' => 'Frontend'],
            ['name' => 'CSS3', 'icon' => 'fab fa-css3-alt', 'level' => 90, 'color' => '#1572b6', 'category' => 'Frontend'],
            ['name' => 'JavaScript', 'icon' => 'fab fa-js-square', 'level' => 85, 'color' => '#f7df1e', 'category' => 'Frontend'],
            ['name' => 'React.js', 'icon' => 'fab fa-react', 'level' => 80, 'color' => '#61dafb', 'category' => 'Frontend'],
            ['name' => 'Bootstrap', 'icon' => 'fab fa-bootstrap', 'level' => 90, 'color' => '#7952b3', 'category' => 'Frontend'],
            
            // Backend
            ['name' => 'PHP', 'icon' => 'fab fa-php', 'level' => 95, 'color' => '#777bb4', 'category' => 'Backend'],
            ['name' => 'Symfony', 'icon' => 'fas fa-symfony', 'level' => 90, 'color' => '#000000', 'category' => 'Backend'],
            ['name' => 'MySQL', 'icon' => 'fas fa-database', 'level' => 85, 'color' => '#4479a1', 'category' => 'Backend'],
            ['name' => 'API REST', 'icon' => 'fas fa-plug', 'level' => 88, 'color' => '#ff6b6b', 'category' => 'Backend'],
            ['name' => 'AJAX', 'icon' => 'fas fa-exchange-alt', 'level' => 82, 'color' => '#4ecdc4', 'category' => 'Backend'],
            
            // Tools
            ['name' => 'Git', 'icon' => 'fab fa-git-alt', 'level' => 85, 'color' => '#f05032', 'category' => 'Tools'],
            ['name' => 'Docker', 'icon' => 'fab fa-docker', 'level' => 75, 'color' => '#2496ed', 'category' => 'Tools'],
            ['name' => 'Linux', 'icon' => 'fab fa-linux', 'level' => 80, 'color' => '#fcc624', 'category' => 'Tools'],
            ['name' => 'Windows', 'icon' => 'fa-brands fa-windows', 'level' => 70, 'color' => '#3155b8ff', 'category' => 'Tools'],
            ['name' => 'Composer', 'icon' => 'fas fa-box', 'level' => 90, 'color' => '#885630', 'category' => 'Tools'],
            ['name' => 'NPM', 'icon' => 'fab fa-npm', 'level' => 78, 'color' => '#cb3837', 'category' => 'Tools'],
        ];

        foreach ($skills as $index => $skillData) {
            $skill = new Skill();
            $skill->setName($skillData['name']);
            $skill->setIcon($skillData['icon']);
            $skill->setLevel($skillData['level']);
            $skill->setColor($skillData['color']);
            $skill->setCategory($skillData['category']);
            $skill->setSortOrder($index + 1);
            $skill->setActive(true);
            $manager->persist($skill);
        }

        // Projects
        $projects = [
            [
                'title' => 'Ent-facile',
                'description' => 'Une application web moderne construite avec symfony-php, qui est un Espace Numérique de Travail facile à utilisé et optimiser. ',
                'technologies' => ['Symfony', 'PHP', 'MySQL', 'Bootstrap', 'JavaScript'],
                'category' => 'Symfony',
                'featured' => true,
                'sortOrder' => 1,
            ],
            [
                'title' => 'E-school',
                'description' => 'Une plateforme de vente de cours en ligne développer pendant ma formation avec deux des mes camarades.',
                'technologies' => ['React.js', 'JavaScript', 'API REST', 'Bootstrap'],
                'category' => 'React',
                'featured' => true,
                'sortOrder' => 2,
            ],
            [
                'title' => 'Web-test',
                'description' => 'Une plateforme dediée aux admistrateurs et Développeur pour tester les différentes vulnérabilités possible.',
                'technologies' => ['Symfony', 'PHP', 'JWT', 'Swagger', 'MySQL'],
                'category' => 'API',
                'featured' => false,
                'sortOrder' => 3,
            ],
            [
                'title' => 'Pennar-bed',
                'description' => 'Une société qui aides les jeûnes étudiants d\'origine différentes dans l\'intégration sociales et les procédures administratives. ',
                'technologies' => ['Symfony', 'PHP', 'AJAX', 'Chart.js', 'Bootstrap'],
                'category' => 'Symfony',
                'featured' => false,
                'sortOrder' => 4,
            ],
            [
                'title' => 'My blog',
                'description' => 'Un dediée aux tutoriels des solutions de certains bug et certaines démonstration de test de pénétration dans un environement 100% isolé. ',
                'technologies' => ['HTML5', 'CSS3', 'JavaScript', 'Bootstrap'],
                'category' => 'Frontend',
                'featured' => false,
                'sortOrder' => 5,
            ],
            [
                'title' => 'Gourmetech',
                'description' => 'Un site qui propose des fomrules des plats spéciales. ',
                'technologies' => ['React.js', 'PWA', 'Service Workers', 'JavaScript'],
                'category' => 'React',
                'featured' => false,
                'sortOrder' => 6,
            ],
        ];

        foreach ($projects as $index => $projectData) {
            $project = new Project();
            $project->setTitle($projectData['title']);
            $project->setDescription($projectData['description']);
            $project->setTechnologiesArray($projectData['technologies']);
            $project->setCategory($projectData['category']);
            $project->setFeatured($projectData['featured']);
            $project->setSortOrder($projectData['sortOrder']);
            $project->setActive(true);
            $project->setDemoUrl('#');
            $project->setGithubUrl('#');
            $manager->persist($project);
        }

        $manager->flush();
    }
}

