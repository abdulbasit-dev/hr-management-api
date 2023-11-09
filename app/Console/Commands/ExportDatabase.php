<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class ExportDatabase extends Command
{
    protected $signature = "db:export";
    protected $description = 'Export database to sql file';

    public function handle()
    {
        $filename = 'database_backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $command = 'mysqldump -u ' . env('DB_USERNAME') . ' -p' . env('DB_PASSWORD') . ' ' . env('DB_DATABASE') . ' > ' . storage_path('app/' . $filename);
        exec($command);

        $this->info('Database exported to ' . $filename);
    }
}
