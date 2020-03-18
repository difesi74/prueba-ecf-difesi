<?php

namespace App\Interfaces;

interface MailerProvider {

    /**
     * Send method
     *
     * @param string $email
     * @param string $message
     * @return boolean
     */
    public function send($email, $message): bool;
}