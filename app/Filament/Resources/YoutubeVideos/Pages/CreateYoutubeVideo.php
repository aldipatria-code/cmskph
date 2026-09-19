<?php

namespace App\Filament\Resources\YoutubeVideos\Pages;

use App\Filament\Resources\YoutubeVideos\YoutubeVideoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateYoutubeVideo extends CreateRecord
{
    protected static string $resource = YoutubeVideoResource::class;
}
