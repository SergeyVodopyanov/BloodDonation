<?php

namespace App\Console\Commands;

use App\Services\PointService;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Log;

class ImportPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(PointService $service)
    {
        $filePath = base_path('app/Imports/Points.xlsx');

        if (!file_exists($filePath)) {
            $this->error('File not found: ' . $filePath);
            return 1;
        }

        $service->command_import($filePath);

        $this->info('Points imported successfully.');

        return 0;
    }
}
