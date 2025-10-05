<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ContactService;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'page_title' => 'Portfolio Développeur Web - Symfony Expert',
            'developer_name' => 'Job Makombela',
            'developer_title' => 'Développeur Web Full-Stack',
            'developer_specialty' => 'Spécialisé Symfony & React.js',
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('main/about.html.twig', [
            'page_title' => 'À propos - Portfolio Développeur',
        ]);
    }

    #[Route('/skills', name: 'app_skills')]
    public function skills(): Response
    {
        $skills = [
            'Frontend' => [
                ['name' => 'HTML5', 'icon' => 'fab fa-html5', 'level' => 95, 'color' => '#e34f26'],
                ['name' => 'CSS3', 'icon' => 'fab fa-css3-alt', 'level' => 90, 'color' => '#1572b6'],
                ['name' => 'JavaScript', 'icon' => 'fab fa-js-square', 'level' => 85, 'color' => '#f7df1e'],
                ['name' => 'React.js', 'icon' => 'fab fa-react', 'level' => 80, 'color' => '#61dafb'],
                ['name' => 'Bootstrap', 'icon' => 'fab fa-bootstrap', 'level' => 90, 'color' => '#7952b3'],
            ],
            'Backend' => [
                ['name' => 'PHP', 'icon' => 'fab fa-php', 'level' => 95, 'color' => '#777bb4'],
                ['name' => 'Symfony', 'icon' => 'fas fa-symfony', 'level' => 90, 'color' => '#000000'],
                ['name' => 'MySQL', 'icon' => 'fas fa-database', 'level' => 85, 'color' => '#4479a1'],
                ['name' => 'API REST', 'icon' => 'fas fa-plug', 'level' => 88, 'color' => '#ff6b6b'],
                ['name' => 'AJAX', 'icon' => 'fas fa-exchange-alt', 'level' => 82, 'color' => '#4ecdc4'],
            ],
            'Tools & Others' => [
                ['name' => 'Git', 'icon' => 'fab fa-git-alt', 'level' => 85, 'color' => '#f05032'],
                ['name' => 'Docker', 'icon' => 'fab fa-docker', 'level' => 75, 'color' => '#2496ed'],
                ['name' => 'Linux', 'icon' => 'fab fa-linux', 'level' => 80, 'color' => '#fcc624'],
                ['name' => 'Composer', 'icon' => 'fas fa-box', 'level' => 90, 'color' => '#885630'],
                ['name' => 'NPM', 'icon' => 'fab fa-npm', 'level' => 78, 'color' => '#cb3837'],
            ]
        ];

        return $this->render('main/skills.html.twig', [
            'page_title' => 'Compétences - Portfolio Développeur',
            'skills' => $skills,
        ]);
    }

    #[Route('/projects', name: 'app_projects')]
    public function projects(): Response
    {
        $projects = [
            [
                'title' => 'E-commerce Symfony',
                'description' => 'Plateforme e-commerce complète développée avec Symfony 7, incluant gestion des commandes, paiements, et administration.',
                'technologies' => ['Symfony', 'PHP', 'MySQL', 'Bootstrap', 'JavaScript'],
                'image' => 'project1.jpg',
                'demo_url' => '#',
                'github_url' => '#',
                'featured' => true,
            ],
            [
                'title' => 'Application React.js',
                'description' => 'Application web moderne avec React.js pour la gestion de tâches en temps réel avec API REST.',
                'technologies' => ['React.js', 'JavaScript', 'API REST', 'Bootstrap'],
                'image' => 'project2.jpg',
                'demo_url' => '#',
                'github_url' => '#',
                'featured' => true,
            ],
            [
                'title' => 'API REST Symfony',
                'description' => 'API RESTful complète avec authentification JWT, documentation Swagger et tests unitaires.',
                'technologies' => ['Symfony', 'PHP', 'JWT', 'Swagger', 'MySQL'],
                'image' => 'project3.jpg',
                'demo_url' => '#',
                'github_url' => '#',
                'featured' => false,
            ],
            [
                'title' => 'Dashboard Admin',
                'description' => 'Interface d\'administration moderne avec statistiques en temps réel et gestion des utilisateurs.',
                'technologies' => ['Symfony', 'PHP', 'AJAX', 'Chart.js', 'Bootstrap'],
                'image' => 'project4.jpg',
                'demo_url' => '#',
                'github_url' => '#',
                'featured' => false,
            ],
            [
                'title' => 'Site Vitrine',
                'description' => 'Site vitrine responsive avec animations CSS3 et optimisations SEO.',
                'technologies' => ['HTML5', 'CSS3', 'JavaScript', 'Bootstrap'],
                'image' => 'project5.jpg',
                'demo_url' => '#',
                'github_url' => '#',
                'featured' => false,
            ],
            [
                'title' => 'Application Mobile Web',
                'description' => 'Application web progressive (PWA) avec fonctionnalités offline et notifications push.',
                'technologies' => ['React.js', 'PWA', 'Service Workers', 'JavaScript'],
                'image' => 'project6.jpg',
                'demo_url' => '#',
                'github_url' => '#',
                'featured' => false,
            ],
        ];

        return $this->render('main/projects.html.twig', [
            'page_title' => 'Projets - Portfolio Développeur',
            'projects' => $projects,
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, ContactService $contactService): Response
    {
        $success = false;
        $error = null;

        if ($request->isMethod('POST')) {
            $data = [
                'name' => $request->request->get('name'),
                'email' => $request->request->get('email'),
                'subject' => $request->request->get('subject'),
                'message' => $request->request->get('message'),
            ];

            $result = $contactService->handleContactForm($data, $request);
            $success = $result['success'];
            $error = $result['success'] ? null : $result['message'];
        }

        return $this->render('main/contact.html.twig', [
            'page_title' => 'Contact - Portfolio Développeur',
            'success' => $success,
            'error' => $error,
        ]);
    }
}
