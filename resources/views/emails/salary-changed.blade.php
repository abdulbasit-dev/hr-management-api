<x-mail::message>
  # Hello {{ $employee->name }},

  ## Your salery has been changed from {{ $oldSalary }} to {{ $employee->salary }}.

  Thanks,<br>
  {{ config('app.name') }}
</x-mail::message>
