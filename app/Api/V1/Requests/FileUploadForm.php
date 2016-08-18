<?php

/**
 * Created by PhpStorm.
 * User: xergo
 * Date: 20-Apr-16
 * Time: 5:16 PM
 */
namespace App\Api\V1\Requests;

use App\Http\Requests\Request;
use App\Models\Category;
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
            //'photo' => 'required|mimes:jpg,jpeg,png,bmp'
        ];
    }

    public function persist() {

        $newFile = $this->file('file');

        $screen = null;
        
        $screengroups = [];
        if ($this->has('screengroups'))
            $screengroups[] = (int) $this->get('screengroups');

        $result = DB::transaction(function () use ($newFile, $screen, $screengroups) {
            // find or create screen and add photo to it.
            $photo = Photo::getOrCreate($newFile)->move($newFile);
            if (!is_null($photo->screen)) {
                $screen = $photo->screen;
            } else {
                $screen = new Screen;
                $screen->save();
                $defaultCategory = Category::first();
                $defaultCategory->addScreen($screen);
            }

            $event = new Event;
            $event->fill(['start_date' => date('Y-m-d'), 'recur_type' => 'daily']);

            if (count($screengroups)>0)
                $screen->screengroups()->sync($screengroups);

            $screen->photo()->save($photo);
            $screen->event()->save($event);
            return $screen;
        });
        return $result;

    }
}