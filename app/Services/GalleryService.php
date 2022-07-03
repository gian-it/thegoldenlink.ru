<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Gallery;

class GalleryService
{
    public function getGalleryForHomePage(): Gallery
    {
        return Gallery::find(1);
    }
}
