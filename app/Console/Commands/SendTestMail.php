<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {to?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to the given address (uses current mail driver)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $to = $this->argument('to') ?? env('MAIL_TEST_TO');
        if (empty($to)) {
            $this->error('No recipient provided. Pass as argument or set MAIL_TEST_TO in .env');
            return 1;
        }

        try {
            Mail::raw('Ini email uji dari aplikasi (driver: ' . config('mail.default') . ').', function ($m) use ($to) {
                $m->to($to)->subject('Tes Notifikasi Aplikasi');
            });
            $this->info('Test mail dispatched to: ' . $to);
            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to send test mail: ' . $e->getMessage());
            return 1;
        }
    }
}
