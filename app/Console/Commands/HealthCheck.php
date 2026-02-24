<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'health:check {--notify : Send notification if issues found}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check application health (database, cache, storage, etc.)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running health checks...');
        $issues = [];

        // Check database connection
        $this->info('Checking database connection...');
        try {
            DB::connection()->getPdo();
            $this->info('✓ Database: OK');
        } catch (\Exception $e) {
            $this->error('✗ Database: FAILED - ' . $e->getMessage());
            $issues[] = 'Database connection failed';
        }

        // Check cache
        $this->info('Checking cache...');
        try {
            Cache::put('health_check', 'test', 10);
            $value = Cache::get('health_check');
            if ($value === 'test') {
                $this->info('✓ Cache: OK');
            } else {
                throw new \Exception('Cache read/write failed');
            }
        } catch (\Exception $e) {
            $this->error('✗ Cache: FAILED - ' . $e->getMessage());
            $issues[] = 'Cache system failed';
        }

        // Check storage writable
        $this->info('Checking storage permissions...');
        $testFile = storage_path('logs/health_check.txt');
        try {
            file_put_contents($testFile, 'test');
            if (file_exists($testFile)) {
                unlink($testFile);
                $this->info('✓ Storage: OK');
            } else {
                throw new \Exception('Cannot write to storage');
            }
        } catch (\Exception $e) {
            $this->error('✗ Storage: FAILED - ' . $e->getMessage());
            $issues[] = 'Storage not writable';
        }

        // Check disk space
        $this->info('Checking disk space...');
        $freeSpace = disk_free_space(base_path());
        $totalSpace = disk_total_space(base_path());
        $usedPercent = (($totalSpace - $freeSpace) / $totalSpace) * 100;
        
        if ($usedPercent > 90) {
            $this->warn("⚠ Disk space: {$usedPercent}% used");
            $issues[] = "Disk space critical: {$usedPercent}% used";
        } else {
            $this->info("✓ Disk space: {$usedPercent}% used");
        }

        // Check website is accessible
        $this->info('Checking website accessibility...');
        try {
            $response = Http::timeout(10)->get(config('app.url'));
            if ($response->successful()) {
                $this->info('✓ Website: OK');
            } else {
                throw new \Exception('Website returned status ' . $response->status());
            }
        } catch (\Exception $e) {
            $this->error('✗ Website: FAILED - ' . $e->getMessage());
            $issues[] = 'Website not accessible';
        }

        // Summary
        $this->newLine();
        if (empty($issues)) {
            $this->info('✓ All health checks passed!');
            return 0;
        } else {
            $this->error('✗ Health check failed with ' . count($issues) . ' issue(s):');
            foreach ($issues as $issue) {
                $this->error('  - ' . $issue);
            }

            // Log issues
            Log::error('Health check failed', ['issues' => $issues]);

            // Send notification if requested
            if ($this->option('notify')) {
                $this->sendNotification($issues);
            }

            return 1;
        }
    }

    /**
     * Send notification about health issues
     */
    protected function sendNotification(array $issues): void
    {
        try {
            $message = "⚠️ *HEALTH CHECK ALERT*\n\n";
            $message .= "Website: " . config('app.url') . "\n";
            $message .= "Issues found:\n";
            foreach ($issues as $issue) {
                $message .= "• {$issue}\n";
            }
            $message .= "\nTime: " . now()->format('Y-m-d H:i:s');

            // Send via WhatsApp (if configured)
            if (class_exists(\App\Services\WhatsAppService::class)) {
                $adminPhone = config('services.whatsapp.admin_phone');
                if ($adminPhone) {
                    \App\Services\WhatsAppService::sendMessage($adminPhone, $message);
                    $this->info('Notification sent via WhatsApp');
                }
            }
        } catch (\Exception $e) {
            $this->warn('Failed to send notification: ' . $e->getMessage());
        }
    }
}
