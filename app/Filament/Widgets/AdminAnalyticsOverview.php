<?php

namespace App\Filament\Widgets;

use App\Models\CommunityMember;
use App\Models\Post;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminAnalyticsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -10;

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    protected function getHeading(): ?string
    {
        return 'Analisis website';
    }

    protected function getDescription(): ?string
    {
        return 'Ringkasan pengguna, anggota komunitas, dan postingan untuk superadmin.';
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total pengguna', User::query()->count())
                ->description(User::query()->where('is_active', true)->count().' pengguna aktif')
                ->descriptionIcon(Heroicon::OutlinedUsers)
                ->color('primary'),
            Stat::make('Anggota komunitas', CommunityMember::query()->count())
                ->description(CommunityMember::query()->where('status', 'pending')->count().' menunggu ditinjau')
                ->descriptionIcon(Heroicon::OutlinedUserGroup)
                ->color('info'),
            Stat::make('Postingan', Post::query()->count())
                ->description(Post::query()->where('status', Post::STATUS_PUBLISHED)->count().' sudah diterbitkan')
                ->descriptionIcon(Heroicon::OutlinedDocumentText)
                ->color('success'),
            Stat::make('Draft', Post::query()->where('status', Post::STATUS_DRAFT)->count())
                ->description('Belum diterbitkan')
                ->descriptionIcon(Heroicon::OutlinedPencilSquare)
                ->color('gray'),
            Stat::make('Menunggu review', Post::query()->where('status', Post::STATUS_PENDING)->count())
                ->description('Perlu ditinjau pengurus')
                ->descriptionIcon(Heroicon::OutlinedClock)
                ->color('warning'),
            Stat::make('Ditolak', Post::query()->where('status', Post::STATUS_REJECTED)->count())
                ->description('Perlu diperiksa kembali')
                ->descriptionIcon(Heroicon::OutlinedXCircle)
                ->color('danger'),
        ];
    }
}
