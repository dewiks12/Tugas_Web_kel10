<?php

namespace App\Notifications;

use App\Models\Transaction;
use App\Notifications\Channels\TelegramChannel;
use App\Notifications\Channels\WhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Transaction $transaction,
        public string $oldStatus
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];
        
        // Add email channel if enabled in settings
        if (setting('email_notifications', true)) {
            $channels[] = 'mail';
        }

        // Add WhatsApp channel if enabled in settings
        if (setting('whatsapp_notifications', true) && $notifiable->whatsapp) {
            $channels[] = WhatsAppChannel::class;
        }

        // Add Telegram channel if enabled in settings
        if (setting('telegram_notifications', true) && $notifiable->telegram_id) {
            $channels[] = TelegramChannel::class;
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Laundry Order Status Updated')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your laundry order #' . $this->transaction->invoice_number . ' status has been updated.')
            ->line('Status changed from ' . ucfirst($this->oldStatus) . ' to ' . ucfirst($this->transaction->status) . '.')
            ->line('Estimated pickup date: ' . $this->transaction->pickup_date?->format('d M Y H:i'))
            ->action('View Order Details', route('customer.transactions.show', $this->transaction))
            ->line('Thank you for using our service!');
    }

    /**
     * Get the WhatsApp representation of the notification.
     */
    public function toWhatsApp(object $notifiable): string
    {
        return "Hello {$notifiable->name}!\n\n" .
            "Your laundry order #{$this->transaction->invoice_number} status has been updated.\n" .
            "Status: " . ucfirst($this->oldStatus) . " → " . ucfirst($this->transaction->status) . "\n" .
            "Pickup date: " . $this->transaction->pickup_date?->format('d M Y H:i') . "\n\n" .
            "Thank you for using our service!";
    }

    /**
     * Get the Telegram representation of the notification.
     */
    public function toTelegram(object $notifiable): string
    {
        return "<b>Laundry Order Status Updated</b>\n\n" .
            "Hello {$notifiable->name}!\n\n" .
            "Your laundry order #{$this->transaction->invoice_number} status has been updated.\n" .
            "Status: <i>" . ucfirst($this->oldStatus) . "</i> → <b>" . ucfirst($this->transaction->status) . "</b>\n" .
            "Pickup date: " . $this->transaction->pickup_date?->format('d M Y H:i') . "\n\n" .
            "Thank you for using our service!";
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'transaction_id' => $this->transaction->id,
            'invoice_number' => $this->transaction->invoice_number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->transaction->status,
            'message' => "Order #{$this->transaction->invoice_number} status changed from {$this->oldStatus} to {$this->transaction->status}",
        ];
    }
} 