<?php

namespace App\utils\mailers;

use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;

class MailService implements Mailer
{
    private PHPMailer $mailer;
    private string $host;
    private string $username;
    private string $password;
    private string $port;
    private string $sender;
    private string $senderName;

    public function getMailer(): PHPMailer
    {
        return $this->mailer;
    }

    public function setMailer(PHPMailer $mailer): MailService
    {
        $this->mailer = $mailer;
        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): MailService
    {
        $this->host = $host;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): MailService
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): MailService
    {
        $this->password = $password;
        return $this;
    }

    public function getPort(): string
    {
        return $this->port;
    }

    public function setPort(string $port): MailService
    {
        $this->port = $port;
        return $this;
    }

    public function getSender(): string
    {
        return $this->sender;
    }

    public function setSender(string $sender): MailService
    {
        $this->sender = $sender;
        return $this;
    }

    public function getSenderName(): string
    {
        return $this->senderName;
    }

    public function setSenderName(string $senderName): MailService
    {
        $this->senderName = $senderName;
        return $this;
    }


    /**
     * @param PHPMailer $mailer
     */
    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
    }


    /**
     * Sends an email to the specified recipient.
     *
     * @param string $recipient The email address of the recipient.
     * @param string $subject The subject of the email.
     * @param string $htmlBody The HTML body of the email.
     * @throws PHPMailerException If an error occurs while sending the email.
     * @return void
     */
    public function sendMail(string $recipient, string $subject, string $htmlBody): void
    {
        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth = true;
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->setFrom($this->getSender(), $this->getSenderName());
        $this->mailer->Username = $this->getUsername();
        $this->mailer->Password = $this->getPassword();
        $this->mailer->Host = $this->getHost();
        $this->mailer->Port = $this->getPort();
        $this->mailer->addAddress($recipient);
        $this->mailer->isHTML();
        $this->mailer->Subject = $subject;
        $this->mailer->Body = $htmlBody;
        $this->mailer->send();
    }

}