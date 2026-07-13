<?php
namespace App\Models\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait Archivable
{
    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
    }

    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    public function isArchived(): bool
    {
        return $this->archived_at !== null;
    }

    public function archive(): void
    {
        $this->update(['archived_at' => now()]);
    }

    public function unarchive(): void
    {
        $this->update(['archived_at' => null]);
    }

    /**
     * Discover all models that use the Archivable trait
     */
    public static function discoverArchivableModels(): array
    {
        $models = [];
        $modelsPath = app_path('Models');

        if (!File::isDirectory($modelsPath)) {
            return $models;
        }

        foreach (File::files($modelsPath) as $file) {
            $class = 'App\\Models\\' . Str::before($file->getFilename(), '.php');

            if (class_exists($class) && in_array(self::class, class_uses_recursive($class))) {
                $models[Str::snake(Str::before($file->getFilename(), '.php'))] = $class;
            }
        }

        return $models;
    }
}
