<?php

namespace Alhoqbani\Filepond\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\MediaLibrary\MediaCollections\FileAdderFactory;

/**
 * @property-read string $id
 * @property-read string $uuid
 * @property string $disk
 * @property string $path
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 */
class FilepondMedia extends Model
{
    public $guarded = [];

    protected $table = 'filepond_media';

    protected static function booted()
    {
        parent::booted();

        self::creating(function (self $model) {
            $model->attributes['uuid'] = Str::uuid();
        });

        self::deleted(function (self $model) {
            Storage::disk($model->disk)->delete($model->path);
        });
    }

    /**
     * @param $uuid
     * @return \Alhoqbani\Filepond\Models\FilepondMedia|null
     */
    public static function findByUuid($uuid): ?static
    {
        /** @var \Alhoqbani\Filepond\Models\FilepondMedia $filepondMedia */
        $filepondMedia = static::query()
            ->where('uuid', $uuid)
            ->first();

        return $filepondMedia;
    }

    /**
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return \Alhoqbani\Filepond\Models\FilepondMedia|null
     */
    public static function createFromRequestFile(UploadedFile $file): ?static
    {
        /** @var \Alhoqbani\Filepond\Models\FilepondMedia $filepondMedia */
        $filepondMedia = static::query()
            ->create([
                'disk' => 'local',
                'path' => $file->store('filepond-media', 'local'),
            ]);

        return $filepondMedia;
    }

    public function attach(HasMedia $subject): FileAdder
    {
        return app(FileAdderFactory::class)
            ->createFromDisk($subject, $this->path, $this->disk);
    }
}
