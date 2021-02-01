<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Menu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sidebar:make {tableIgnore} {laporanIgnore}';
    // protected $signature = 'menu:sidebar {tableIgnore}  {laporanIgnore}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat menu sidebar kiri';

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

        $tablesReturn = [];
        $laporanReturn = [];
        foreach ($tables as $table) {
            foreach ($table as $key => $value)

            $tableIgnore = explode(',', $this->argument('tableIgnore'));

            if(in_array($value, $tableIgnore)) {

                continue;
            }

            $valueCaptialize = ucwords(preg_replace('/_/', " ", $value));

            $tablesReturn[] = "
            @if(in_array(auth()->user()->level, ['Admin']))
            <li>
                <a @if(Route::current()->action['as'] == '$value.index') class='active-menu' @endif href=\"{{ route('$value.index') }}\"><i class=\"fa fa-table\"></i>$valueCaptialize</a>
            </li>
            @endif
            \r";

            $laporanReturn[] = "
            @if(in_array(auth()->user()->level, ['Admin']))
            <li>
                <a  @if(Route::current()->action['as'] == '$value.laporan.index') class='active-menu' @endif href=\"{{ route('$value.laporan.index') }}\"><i class=\"fa fa-table\"></i>$valueCaptialize</a>
            </li>
            @endif
            \r";
        }

        if($this->argument('laporanIgnore') == "true") {
            $laporanHead = "<li>
                <a href=\"#\"><i class=\"fa fa-sitemap\"></i>Laporan <span class=\"fa arrow\"></span></a>
                <ul class=\"nav nav-second-level  @if(Request::segment(2) == 'laporan') collapse in @endif\">";

            $laporanFoot = "</ul>
            </li>";

            $file_put = implode('', $tablesReturn) . $laporanHead . implode('', $laporanReturn) . $laporanFoot;
        } else {
            $file_put = implode('', $tablesReturn);
        }

        file_put_contents(base_path('resources/views/layouts/sidebar.blade.php'), $file_put);

        echo "Berhasil diletakkan di" . base_path('resources/views/layouts/sidebar.blade.php');
    }
}
