<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\CronjobController;
use Illuminate\Console\Command;

class PackageExpiryReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:package-expiry-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $cronjobControl=new CronjobController();
        $cronjobControl->expiryReminder();
        return true;
    }
}
