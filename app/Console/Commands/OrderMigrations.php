<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OrderMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate_in_order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create migrations in correct order';

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
        $migrations = [
                        '2022_11_13_184225_create_email_verifications_table.php',
                        '2014_10_12_100000_create_password_resets_table.php',
                        '2023_01_02_165539_create_news_table.php', 
                        '2022_11_13_144335_create_roles_table.php',
                        '2022_11_13_145104_create_countries_table.php',
                        '2023_01_07_163923_create_queries_table.php',
                        '2014_10_12_000000_create_users_table.php',
                        '2022_11_13_144540_create_users_roles_table.php',
                        '2019_08_19_000000_create_failed_jobs_table.php',
                        '2019_12_14_000001_create_personal_access_tokens_table.php',
                        '2022_11_13_145145_create_cities_table.php',
                        '2022_11_13_150420_create_institutions_table.php',
                        '2022_11_13_145805_create_reports_table.php',
                        '2022_11_13_151157_create_rooms_table.php',
                        '2022_11_13_151324_create_specifications_table.php',
                        '2022_11_13_150945_create_reservations_table.php'
        ];

        foreach($migrations as $migration)
        {
           $basePath = 'database/migrations/';          
           $migrationName = trim($migration);
           $path = $basePath.$migrationName;
           $this->call('migrate:refresh', [
            '--path' => $path ,            
           ]);
        }
    }
}
