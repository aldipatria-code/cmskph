<?php

namespace App\Filament\Resources\CommunityMembers\Pages;

use App\Filament\Resources\CommunityMembers\CommunityMemberResource;
use Filament\Resources\Pages\ListRecords;

class ListCommunityMembers extends ListRecords
{
    protected static string $resource = CommunityMemberResource::class;
}
