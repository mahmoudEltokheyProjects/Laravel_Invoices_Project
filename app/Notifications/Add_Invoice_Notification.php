<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
class Add_Invoice_Notification extends Notification
{
    use Queueable;
    private $invoice_id ;
    private $userAddInvoice ;
    public function __construct($latestInvoiceId,$user_add_invoice)
    {
        // Assign the "latest invoice id" to "$invoice_id" variable
        $this->invoice_id = $latestInvoiceId;
        // Assign the "user_add_invoice" to "$user_add_invoice" variable
        $this->userAddInvoice = $user_add_invoice;
    }
    public function via($notifiable)
    {
        return ['database'];
    }
    // Store Notification in DB
    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->invoice_id ,
            'title' => 'تم اضافة فاتورة جديدة بواسطة : '  ,
            'user_create_invoice' => auth()->user()->name ,
        ];
    }
}
