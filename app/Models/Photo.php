<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends Model
{
    /**
     * Table name of model.
     *
     * @var string
     */
    protected $table = 'photos';

    /**
     * [$fillable variables allowed for massallocation]
     *
     * @var [String]
     */
    protected $fillable = [
        'name',
        'screen_id',
        'path',
        'thumb_path',
        'archived',
        'sha1',
    ];

    protected $baseDir = 'screens/images';

/**
 * Get the screens associated with the given image.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
 */
    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }

/**
 * Remove the image and it's associated file.
 *
 * @return bool|null
 * @throws \Exception
 */
    public function delete()
    {
        $path = 'public' . $this->attributes['path'];

        if (\File::exists($path)) {
            \File::delete($path);
        }

        parent::delete();
    }

    public static function named($name)
    {
        return (new static)->saveAs($name);
    }

    protected function saveAs($name)
    {
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $this->archived = 0;
        $this->name = sprintf("image_%s.%s", md5(date('Y-m-d H:i:s:u')), $ext);
        $this->path = sprintf("%s/%s", $this->baseDir, $this->name);

        $this->thumb_path = sprintf("%s/tn-%s", $this->baseDir, $this->name);

        return $this;
    }

    public function move(UploadedFile $file)
    {
        $file->move($this->baseDir, $this->name);
        $this->sha1 = sha1_file($this->path);
        Image::make($this->path)
            ->fit(200)
            ->save($this->thumb_path);

        return $this;
    }

    public static function getOrCreate(UploadedFile $file)
    {
        $photo = new static;
        $photo = Photo::where(['sha1' => sha1_file($file)])->first();
        if (!is_null($photo)) {
            return $photo;
        } else {
            return Photo::named($file->getClientOriginalName());
        }
    }

    public function getScreen($screengroup)
    {
        $screen = $this->screen;

        if (!is_null($screen)) {
            if (!$screen->screengroups->contains($screengroup->id)) {
                $screengroup->screens()->save($screen);
            }
        } else {
            $screen = new Screen;
            $screen->fill([
                'name' => $photo->name,
                'screen_group_id' => $screengroup->id,
                'event_id' => null,
                'user_id' => Auth::user()->id,
            ]);
            $this->photo()->save($photo);
            $screengroup->screens()->attach($screen);
        }
    }
}
