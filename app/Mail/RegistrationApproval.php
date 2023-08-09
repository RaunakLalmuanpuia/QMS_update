<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Employee;

class RegistrationApproval extends Mailable
{
  use Queueable, SerializesModels;

  public $employee;

  /**
   * Create a new message instance.
   *
   * @param  Employee  $employee
   * @return void
   */
  public function __construct(Employee $employee)
  {
    $this->employee = $employee;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->subject('Registration Approval')
      ->view('emails.registration-approval');
  }
}
