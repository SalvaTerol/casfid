<?php

namespace Domain\Menu\Actions\Pizza;

use Illuminate\Http\UploadedFile;

class UploadImageAction
{
    public static function execute(UploadedFile|string|null $newImage, ?string $currentImage = null): ?string
    {
        if ($newImage instanceof UploadedFile) {
            return $newImage->store('/', 'public');
        }

        return $currentImage ?? $newImage;
    }
}
