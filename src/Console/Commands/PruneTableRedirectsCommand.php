<?php

namespace PavelZanek\RedirectionsLaravel\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use PavelZanek\RedirectionsLaravel\Models\Redirect;

class PruneTableRedirectsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redirections:prune-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune table with redirects - old unused records.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->comment('Removing redirects...');
        Redirect::where('last_used', '<', Carbon::now()->subDays(config('redirections.days_removing_unused_records')))->delete();
        Redirect::whereNull('last_used')->where('created_at', '<', Carbon::now()->subDays(config('redirections.days_removing_unused_records_only_created')))->delete();
        $this->info("Redirects Table was pruned.");
        return 0;
    }
}
