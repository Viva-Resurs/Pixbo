<?php
namespace App\Api\V1\Transformers\ScreenGroup;
use App\Models\ScreenGroup;
use League\Fractal\TransformerAbstract;
use App\Api\V1\Transformers\Screen\ScreenTransformer;
use App\Api\V1\Transformers\Ticker\TickerTransformer;
class ScreenGroupTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];
    protected $defaultIncludes = ['screens', 'tickers'];

    public function transform(ScreenGroup $screengroup)
    {
        return [
            'id' 	=> (int) $screengroup->id,
            'name'  => $screengroup->name,
            'desc'	=> $screengroup->desc
        ];
    }

    public function includeScreens(ScreenGroup $screengroup) {
        $screens = $screengroup->screens;
        return $this->collection($screens, new ScreenTransformer());
    }

    public function includeTickers(ScreenGroup $screengroup) {
        $tickers = $screengroup->tickers;
        return $this->collection($tickers, new TickerTransformer());
    }
}