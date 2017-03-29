<?php

use App\Models\ScreenGroup;
use App\Models\Client;
use App\Models\Ticker;
use App\Models\Event;
use App\Models\Screen;
use App\Models\Photo;

use Illuminate\Database\Eloquent\Model;

use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Database\Seeder;

class InitialDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('screengroup')->delete();
        DB::table('screengroup_ticker')->delete();
        DB::table('screengroup_screen')->delete();
        DB::table('client')->delete();
        DB::table('ticker')->delete();
        DB::table('screen')->delete();
        DB::table('event')->delete();

        // Create a screengroup
        $sg = new ScreenGroup([
            'name' => "First ScreenGroup",
            'desc' => "Just for testing",
            'user_id' => 1
        ]);
        $sg->save();

        // Create Client and set it´s Screengroup
        $client = new Client([
            "name"=>"Test screen",
            "address"=>"9a:aa:aa:aa:aa:aa",
            "screen_group_id"=>$sg->id,
            'user_id' => 1
        ]);
        $client->save();

        // Create one Ticker
        $ticker = new Ticker([
            'text' => "Some text to display on a screen"
        ]);
        $ticker->save();

        // Create and attach event to Ticker
        $ticker->event()->save(
            new Event(['start_date' => date('Y-m-d'), 'recur_type' => 'daily'])
        );

        // Attach to screengroup
        $ticker->screengroups()->save($sg);

        // Create a screen
        $screen = new Screen();
        $screen->save();

        // Create a photo
        $file = new File("public/testimage.jpg");
        $photo = new Photo();
        $photo->originalName = "testimage.jpg";
        $photo->name = "testimage.jpg";
        $photo->path = "testimage.jpg";
        $photo->thumb_path = "tn-testimage.jpg";
        $photo->sha1 = $photo->path;
        Image::make("public/testimage.jpg")
            ->fit(200)
            ->save($photo->thumb_path);

        // Attach Photo to Screen
        $screen->photo()->save($photo);

        // Create and attach event to Screen
        $screen->event()->save(
            new Event(['start_date' => date('Y-m-d'), 'recur_type' => 'daily'])
        );

        // Attach to screengroup
        $screen->screengroups()->save($sg);

    }
}
