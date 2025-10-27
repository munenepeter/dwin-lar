<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


/**
 * MaintenanceController
 * Handles system maintenance, backups, and optimization
 */
class MaintenanceController extends Controller {
    public function index() {
        // Get system information
        $systemInfo = [
            'database_size' => $this->getDatabaseSize(),
            'storage_size' => $this->getStorageSize(),
            'cache_size' => $this->getCacheSize(),
            'last_backup' => $this->getLastBackupDate(),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
        ];

        return view('admin.maintenance.index', compact('systemInfo'));
    }

    public function backup(Request $request) {
        try {
            // Run backup command
            Artisan::call('backup:run');

            return response()->json([
                'success' => true,
                'message' => 'Backup completed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Backup failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function optimize(Request $request) {
        try {
            // Clear and optimize
            Artisan::call('optimize:clear');
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            return response()->json([
                'success' => true,
                'message' => 'System optimized successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Optimization failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper Methods
     */
    private function getDatabaseSize() {
        try {
            $databaseName = env('DB_DATABASE');
            $result = DB::select("
                SELECT 
                    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_mb
                FROM information_schema.TABLES 
                WHERE table_schema = ?
            ", [$databaseName]);

            return $result[0]->size_mb ?? 0;
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    private function getStorageSize() {
        try {
            $size = 0;
            $files = Storage::allFiles();

            foreach ($files as $file) {
                $size += Storage::size($file);
            }

            return round($size / 1024 / 1024, 2); // Convert to MB
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    private function getCacheSize() {
        try {
            $cacheDirectory = storage_path('framework/cache');

            if (!is_dir($cacheDirectory)) {
                return 0;
            }

            $size = 0;
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($cacheDirectory)
            );

            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $size += $file->getSize();
                }
            }

            return round($size / 1024 / 1024, 2); // Convert to MB
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    private function getLastBackupDate() {
        try {
            // Assuming backups are stored in storage/app/backups
            $backupPath = storage_path('app/backups');

            if (!is_dir($backupPath)) {
                return 'Never';
            }

            $files = glob($backupPath . '/*');

            if (empty($files)) {
                return 'Never';
            }

            usort($files, function ($a, $b) {
                return filemtime($b) - filemtime($a);
            });

            return date('Y-m-d H:i:s', filemtime($files[0]));
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }
}
