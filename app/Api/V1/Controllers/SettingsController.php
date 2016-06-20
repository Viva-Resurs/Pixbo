<?php

namespace App\Api\V1\Controllers;

use Activity;
use Gate;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Api\V1\Transformers\SettingsTransformer;

class SettingsController extends BaseController
{
    public function index() {
        if (Gate::denies('edit_site_settings')) {
            $this->response->error('permission_denied', 401);
        }
        $settings = Settings::first();

        return $this->item($settings, new SettingsTransformer());
    }

    public function update(Request $request) {
        if (Gate::denies('edit_site_settings')) {
            $this->response->error('permission_denied', 401);
        }
        $settings = Settings::first();

        $new_settings = $request->all();

        if($settings->update($new_settings)) {
            
            Activity::log([
                'user_id' => $this->user,
                'contentId' => 1,
                'contentType' => 'Setting',
                'action' => 'Update',
                'description' => 'Updated the settings.',
                'details' => $settings->toJson(),
            ]);
            return $this->response->noContent();
        } else {
            return $this->response->error('could_not_update_settings', 500);
        }
    }

}
