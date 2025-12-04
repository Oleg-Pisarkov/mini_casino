<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Создать новое сообщение.
     *
     * @param User $user Пользователь, которому отправляется письмо
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Получить конверт сообщения (заголовок, тема и т.д.).
     */
    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Добро пожаловать в MINI CASINO!',
            from: 'no-reply@minicasino.loc',
        );
    }

    /**
     * Получить содержимое письма (шаблон и данные).
     */
    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.welcome', // путь к шаблону (resources/views/emails/welcome.blade.php)
            with: [
                'user' => $this->user,
            ],
        );
    }

    /**
     * Получить вложения (если нужны).
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments()
    {
        return [];
    }
}
