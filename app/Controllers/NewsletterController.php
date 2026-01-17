<?php

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\NewsletterSubscriber;

class NewsletterController extends Controller
{
    public function subscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $redirectUrl = $_SERVER['HTTP_REFERER'] ?? '/';

            if (!$email) {
                // In a real app we would use flash messages here
                // For now, let's just redirect back
                $this->redirect($redirectUrl . '?newsletter_error=invalid_email');
                return;
            }

            if (NewsletterSubscriber::exists($email)) {
                $this->redirect($redirectUrl . '?newsletter_error=already_subscribed');
                return;
            }

            $subscriber = new NewsletterSubscriber();
            $subscriber->setEmail($email);

            if ($subscriber->save()) {
                $this->redirect($redirectUrl . '?newsletter_success=1');
            } else {
                $this->redirect($redirectUrl . '?newsletter_error=save_failed');
            }
        }
    }
}
