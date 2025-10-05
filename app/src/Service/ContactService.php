<?php

namespace App\Service;

use App\Entity\ContactMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;

class ContactService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MailerInterface $mailer,
        private string $adminEmail = 'contact@votreportfolio.com'
    ) {
    }

    public function handleContactForm(array $data, Request $request): array
    {
        $result = ['success' => false, 'message' => ''];

        try {
            // Validation des données
            $validation = $this->validateContactData($data);
            if (!$validation['valid']) {
                return ['success' => false, 'message' => $validation['message']];
            }

            // Création du message
            $contactMessage = $this->createContactMessage($data, $request);
            
            // Sauvegarde en base de données
            $this->entityManager->persist($contactMessage);
            $this->entityManager->flush();

            // Envoi de l'email
            $this->sendContactEmail($contactMessage);

            $result = [
                'success' => true, 
                'message' => 'Votre message a été envoyé avec succès ! Je vous répondrai dans les plus brefs délais.'
            ];

        } catch (\Exception $e) {
            $result = [
                'success' => false, 
                'message' => 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer.'
            ];
        }

        return $result;
    }

    private function validateContactData(array $data): array
    {
        $requiredFields = ['name', 'email', 'subject', 'message'];
        
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return ['valid' => false, 'message' => 'Tous les champs sont requis.'];
            }
        }

        // Validation de l'email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['valid' => false, 'message' => 'L\'adresse email n\'est pas valide.'];
        }

        // Validation de la longueur du message
        if (strlen($data['message']) < 10) {
            return ['valid' => false, 'message' => 'Le message doit contenir au moins 10 caractères.'];
        }

        return ['valid' => true, 'message' => ''];
    }

    private function createContactMessage(array $data, Request $request): ContactMessage
    {
        $contactMessage = new ContactMessage();
        $contactMessage->setName($data['name']);
        $contactMessage->setEmail($data['email']);
        $contactMessage->setSubject($data['subject']);
        $contactMessage->setMessage($data['message']);
        $contactMessage->setIpAddress($request->getClientIp());
        $contactMessage->setUserAgent($request->headers->get('User-Agent'));

        return $contactMessage;
    }

    private function sendContactEmail(ContactMessage $contactMessage): void
    {
        $email = (new Email())
            ->from($contactMessage->getEmail())
            ->to($this->adminEmail)
            ->subject('Nouveau message de contact: ' . $contactMessage->getSubject())
            ->html($this->generateEmailTemplate($contactMessage));

        $this->mailer->send($email);
    }

    private function generateEmailTemplate(ContactMessage $contactMessage): string
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #2563eb; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8fafc; padding: 20px; border-radius: 0 0 10px 10px; }
                .field { margin-bottom: 15px; }
                .label { font-weight: bold; color: #1e293b; }
                .value { margin-top: 5px; }
                .message { background: white; padding: 15px; border-radius: 8px; border-left: 4px solid #2563eb; }
                .footer { text-align: center; margin-top: 20px; color: #64748b; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Nouveau message de contact</h2>
                    <p>Portfolio Développeur</p>
                </div>
                <div class='content'>
                    <div class='field'>
                        <div class='label'>Nom complet :</div>
                        <div class='value'>{$contactMessage->getName()}</div>
                    </div>
                    <div class='field'>
                        <div class='label'>Email :</div>
                        <div class='value'>{$contactMessage->getEmail()}</div>
                    </div>
                    <div class='field'>
                        <div class='label'>Sujet :</div>
                        <div class='value'>{$contactMessage->getSubject()}</div>
                    </div>
                    <div class='field'>
                        <div class='label'>Message :</div>
                        <div class='message'>{$contactMessage->getMessage()}</div>
                    </div>
                    <div class='field'>
                        <div class='label'>Date :</div>
                        <div class='value'>{$contactMessage->getCreatedAt()->format('d/m/Y à H:i')}</div>
                    </div>
                    <div class='field'>
                        <div class='label'>IP :</div>
                        <div class='value'>{$contactMessage->getIpAddress()}</div>
                    </div>
                </div>
                <div class='footer'>
                    <p>Message envoyé depuis le formulaire de contact du portfolio</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }

    public function markAsRead(ContactMessage $contactMessage): void
    {
        $contactMessage->setRead(true);
        $this->entityManager->flush();
    }

    public function markAsReplied(ContactMessage $contactMessage): void
    {
        $contactMessage->setReplied(true);
        $this->entityManager->flush();
    }

    public function sendReply(ContactMessage $contactMessage, string $replyMessage): bool
    {
        try {
            $email = (new Email())
                ->from($this->adminEmail)
                ->to($contactMessage->getEmail())
                ->subject('Re: ' . $contactMessage->getSubject())
                ->html($this->generateReplyTemplate($contactMessage, $replyMessage));

            $this->mailer->send($email);
            $this->markAsReplied($contactMessage);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function generateReplyTemplate(ContactMessage $contactMessage, string $replyMessage): string
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #2563eb; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8fafc; padding: 20px; border-radius: 0 0 10px 10px; }
                .message { background: white; padding: 15px; border-radius: 8px; border-left: 4px solid #2563eb; }
                .footer { text-align: center; margin-top: 20px; color: #64748b; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Réponse à votre message</h2>
                    <p>Portfolio Développeur</p>
                </div>
                <div class='content'>
                    <p>Bonjour {$contactMessage->getName()},</p>
                    <div class='message'>{$replyMessage}</div>
                    <p>Cordialement,<br>L'équipe Portfolio</p>
                </div>
                <div class='footer'>
                    <p>Ce message est une réponse à votre demande du {$contactMessage->getCreatedAt()->format('d/m/Y')}</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
}
