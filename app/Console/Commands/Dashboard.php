<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Dashboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:make {tables}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dashboard make';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tables = DB::select('SHOW TABLES');

        $dashboard = "";
        foreach ($tables as $table) {
            foreach ($table as $key => $value)

            $tables = explode(',', $this->argument('tables'));

            if(!in_array($value, $tables)) {

                continue;
            }

            $dashboard .= "
                <div class=\"col-md-3\">
                    <div class=\"main-box mb-red\">
                        <a href=\"{{ route('$value.index') }}\">
                            <i class=\"fa fa-bolt fa-5x\"></i>
                            <h5>({{ \${$value}s->count() }}) $value</h5>
                        </a>
                    </div>
                </div>
            ";

        }
        
        file_put_contents(base_path('resources/views/layouts/dashboard.blade.php'), $dashboard);

        echo "Berhasil diletakkan di" . base_path('resources/views/layouts/dashboard.blade.php');
    }
}
