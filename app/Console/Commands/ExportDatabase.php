<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExportDatabase extends Command
{
    protected $signature = "db:backup";
    protected $description = 'Export database to sql file';

    public function handle()
    {
        // check if mysqldump is installed on the system
        $os = PHP_OS;
        $hasMysqldump = "";

        if(stripos($os, 'WIN') === 0){
            $hasMysqldump = exec('where mysqldump');
        } elseif (stripos($os, 'LINUX') === 0 || stripos($os, 'DARWIN') === 0) {
            $hasMysqldump = exec('command -v mysqldump');
        }

        if (!$hasMysqldump) {
            $this->error('mysqldump is not installed');
            return;
        }

        $filename = 'database_backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $command = 'mysqldump -u ' . env('DB_USERNAME') . ' -p' . env('DB_PASSWORD') . ' ' . env('DB_DATABASE') . ' > ' . storage_path('app/' . $filename);
        exec($command);

        $this->info('Database exported to ' . storage_path('app/' . $filename));
    }
}
