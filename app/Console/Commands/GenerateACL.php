<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Seeder;

//use App\Database\Seeds\RolesTableSeeder as RolesTableSeeder;

class GenerateACL extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:acl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate Access Control List';

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
        $this->line('PermissionTableSeeder');
        $this->call('db:seed',[
            '--class' => 'PermissionTableSeeder'
        ]);

        $this->line('RolesTableSeeder');
        $this->call('db:seed',[
            '--class' => 'RolesTableSeeder'
        ]);
    }
}
