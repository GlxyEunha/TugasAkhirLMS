<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\DeleteInactiveUsers;

class DeleteInactiveUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:delete-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users who have been inactive for over a year';

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
        DeleteInactiveUsers::dispatch();
        $this->info('Inactive users have been deleted.');
    }
}
