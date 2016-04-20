<?php

namespace App\Http\Requests;

use DB;
use App\Models\Event;
use App\Models\Tag;

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
            'selected_tags' => 'required'
        ];
    }

    public function persist($screen) {
        $vm = $this;

        $event = $vm->get('event');
        $day_num = $vm->get('day_num');
        $event['recur_day_num'] = json_encode(($day_num));
        $tags = $vm->get('selected_tags');

        $screengroups = $vm->get('selected_screengroups');

        $result = DB::transaction(function () use ($screen, $event, $tags, $screengroups) {
            $e = Event::find($event['id']);
            $e->update($event);

            $tagged = [];

            foreach ($tags as $tag) {
                $t = Tag::where('name', $tag['name'])->first();
                if (!is_null($t)) {
                    array_push($tagged, $t->id);
                } else {
                    $t = new Tag;
                    $t->fill([
                        'name' => $tag['name'],
                    ])->save();
                    array_push($tagged, $t->id);
                }
            }
            $screen->tags()->sync($tagged);

            $screen->screengroups()->sync($screengroups);
            $screen->save();
        });

        return $result;
    }
}
