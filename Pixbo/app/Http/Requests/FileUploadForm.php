<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Event;
use App\Models\Photo;
use App\Models\Screen;
use DB;

class FileUploadForm extends Request
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
        return [
            'photo' => 'required|mimes:jpg,jpeg,png,bmp'
        ];
    }

    public function persist() {

        $vm = $this;
        $screen = DB::transaction(function () use ($vm) {
            $screen = null;
            // find or create screen and add photo to it.
            $photo = Photo::getOrCreate($vm->file('photo'))->move($vm->file('photo'));
            if (!is_null($photo->screen)) {
                $screen = $photo->screen;
            } else {
                $screen = new Screen;
                $screen->save();
            }

            $event = new Event;
            $event->fill(['start_date' => date('Y-m-d')]);

            $screen->photo()->save($photo);
            $screen->event()->save($event);
            return $screen;
        });
        return $screen;
    }
}
