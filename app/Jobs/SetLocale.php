<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App;
use Carbon\Carbon;

class SetLocale extends Job implements SelfHandling
{

    protected $languages;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->languages = config('app.languages');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!session()->has('locale')) {
            session()->put('locale', \Request::getPreferredLanguage($this->languages));
        }

        App::setLocale(session('locale'));
        Carbon::setLocale(session('locale'));
    }
}
