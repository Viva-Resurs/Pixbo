<?php

namespace App\Api\V1\Requests;

use DB;
use App\Models\Event;
use App\Models\Tag;
use App\Models\Screen;
use App\Http\Requests\Request;

class ScreenUpdateForm extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // TODO: Add validation to the screen updates.
        return [
        ];
    }

    public function persist(Screen $screen) {
        $newScreen = $this->all();
        $newEvent = $newScreen['event'];
        $newScreengroups = $newScreen['screengroups'];
        
        $event = $screen->event->first();
        $event->update($newEvent);
        $screen->screengroups()->sync($newScreengroups);
        $screen->categories()->sync(array($newScreen['category']));

        if($screen->update($newScreen)) {
            return true;
        }

        return false;
    }
}
