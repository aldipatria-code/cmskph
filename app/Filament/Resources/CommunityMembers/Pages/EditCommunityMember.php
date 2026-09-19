<?php

namespace App\Filament\Resources\CommunityMembers\Pages;

use App\Filament\Resources\CommunityMembers\CommunityMemberResource;
use Filament\Resources\Pages\EditRecord;

class EditCommunityMember extends EditRecord
{
    protected static string $resource = CommunityMemberResource::class;
}
