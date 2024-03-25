<?php

namespace App\Filament\Widgets;
use App\Models\Research;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class ResearchOverView extends BaseWidget
{
    use InteractsWithPageFilters;
    public function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        return [
            StatsOverviewWidget\Stat::make(
                label: new HtmlString('<b class="text-2xl " style="color: rgb(245,158,11) !important;"> Total Research</b>'),
                value: Research::query()
                    ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->count(),
            ),
            StatsOverviewWidget\Stat::make(
                label: new HtmlString('<b class="text-2xl " style="color: #4c7d12 !important;"> Published Research</b>'),
                value: Research::query()
                    ->where('status',"publish")
                    ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->count(),
            ),
            StatsOverviewWidget\Stat::make(
                label: new HtmlString('<b class="text-2xl " style="color: rgba(185,36,36,0.84) !important;"> Rejected Research</b>'),
                value: Research::query()
                    ->where("status","reject")
                    ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->count(),
            ),
            // ...
        ];
    }

}
