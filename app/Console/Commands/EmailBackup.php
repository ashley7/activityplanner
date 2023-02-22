<?php

namespace App\Console\Commands;

use App\Mail\BackupMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EmailBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This send email backup of database';

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
        Mail::to("thembocharles123@gmail.com")->send(new BackupMail());
    }
}
