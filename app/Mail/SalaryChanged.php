<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SalaryChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Employee $employee, public $oldSalary)
    {
        $this->employee = $employee;
        $this->oldSalary = $oldSalary;
    }

    public function build()
    {
        return $this->subject("Salary Changed")
            ->markdown('emails.salary-changed');
    }
}
