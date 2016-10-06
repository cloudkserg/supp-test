<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class GenerateSwagger extends Command
{
    const NAME_FILE = 'swagger.json';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swagger:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate swagger file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $swagger = \Swagger\scan(app_path(), [ ]);
        $swagger->saveAs(public_path('doc') . '/' . self::NAME_FILE);
    }
}
