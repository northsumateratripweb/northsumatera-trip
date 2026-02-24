<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ClearOldLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clear {--days=30 : Number of days to keep}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear log files older than specified days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $logPath = storage_path('logs');
        
        if (!File::exists($logPath)) {
            $this->error('Log directory does not exist');
            return 1;
        }

        $files = File::files($logPath);
        $deletedCount = 0;
        $cutoffDate = Carbon::now()->subDays($days);

        foreach ($files as $file) {
            $fileTime = Carbon::createFromTimestamp(File::lastModified($file));
            
            if ($fileTime->lt($cutoffDate)) {
                File::delete($file);
                $deletedCount++;
                $this->info("Deleted: {$file->getFilename()}");
            }
        }

        $this->info("Cleared {$deletedCount} old log file(s)");
        return 0;
    }
}
