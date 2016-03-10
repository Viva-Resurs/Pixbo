<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class ChangeLocale extends Job implements SelfHandling
{

    protected $lang;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($lang)
    {
        $this->lang = $lang;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        session()->put('locale', $this->lang);
    }
}
