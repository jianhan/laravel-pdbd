<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DropTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tables:drop-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all tables in local mysql database. DO NOT RUN IN PRODUCTION';

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
     * @return mixed
     */
    public function handle()
    {
        if (\App::environment('production')) {
            $this->comment("THIS IS PRODUCTION ENVIRONMENT, PLEASE BE AWARE!!!!!!!!!!!!!!!!");
        }

        if (!$this->confirm('CONFIRM DROP AL TABLES IN THE CURRENT DATABASE? [y|N]')) {
            exit('Drop Tables command aborted');
        }

        $colname = 'Tables_in_' . env('DB_DATABASE');

        $tables = \DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $droplist[] = $table->$colname;
        }
        $droplist = implode(',', $droplist);

        \DB::beginTransaction();
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        \DB::statement("DROP TABLE $droplist");
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        \DB::commit();

        $this->line(PHP_EOL . "Finished" . PHP_EOL);
    }
}
