<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
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
    public function skills(SkillRepository $skillRepository): Response
    {
        $skillsEntities = $skillRepository->findAll();

        // Regrouper par catégorie
        $skills = [];
        foreach ($skillsEntities as $skill) {
            $category = $skill->getCategory(); // suppose que tu as une propriété "category"
            $skills[$category][] = [
                'name' => $skill->getName(),
                'icon' => $skill->getIcon(),
                'level' => $skill->getLevel(),
                'color' => $skill->getColor(),
            ];
        }
        return $this->render('main/skills.html.twig', [
            'page_title' => 'Compétences - Portfolio Développeur',
            'skills' => $skills,
        ]);
    }

    #[Route('/projects', name: 'app_projects')]
    public function projects(ProjectRepository $projectRepository): Response
    {
        $projectsEntities = $projectRepository->findAll();

        $projects = [];
        foreach ($projectsEntities as $project) {
            $projects[] = [
                'title' => $project->getTitle(),
                'description' => $project->getDescription(),
                'technologies' => $project->getTechnologies(), // array ou JSON décodé
                'image' => $project->getImage(),
                'demo_url' => $project->getDemoUrl(),
                'github_url' => $project->getGithubUrl(),
                'featured' => $project->isFeatured(),
            ];
        }

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
