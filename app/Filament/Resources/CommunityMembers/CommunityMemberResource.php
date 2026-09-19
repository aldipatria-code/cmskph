<?php

namespace App\Filament\Resources\CommunityMembers;

use App\Filament\Resources\CommunityMembers\Pages\EditCommunityMember;
use App\Filament\Resources\CommunityMembers\Pages\ListCommunityMembers;
use App\Filament\Resources\CommunityMembers\Schemas\CommunityMemberForm;
use App\Filament\Resources\CommunityMembers\Tables\CommunityMembersTable;
use App\Models\CommunityMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CommunityMemberResource extends Resource
{
    protected static ?string $model = CommunityMember::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;
    protected static string|UnitEnum|null $navigationGroup = 'Community';
    protected static ?string $navigationLabel = 'Anggota Komunitas';
    protected static ?string $modelLabel = 'Anggota Komunitas';
    protected static ?string $pluralModelLabel = 'Anggota Komunitas';
    protected static ?string $recordTitleAttribute = 'name';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return CommunityMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommunityMembersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCommunityMembers::route('/'),
            'edit' => EditCommunityMember::route('/{record}/edit'),
        ];
    }
}
