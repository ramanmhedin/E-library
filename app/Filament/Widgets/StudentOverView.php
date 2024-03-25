<?php

namespace App\Filament\Widgets;

use App\Models\College;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class StudentOverView extends ChartWidget
{
    protected static ?string $heading = 'Students And Research';


    protected function getData(): array
    {
        $queryResult = College::query()
            ->withCount(["users as student_count" => function (Builder $query) {
                $query->where("users.role_id", 2);
            }])
            ->withCount(["researches as research_count" => function (Builder $query) {
                $query->where("status", "publish");
            }])
            ->addSelect("name")->get();

        $data = $queryResult->pluck("student_count", "name")->toArray();
        $research_data = $queryResult->pluck("research_count", "name")->toArray();
        $labels = array_keys($data);
        // Preparing data for the chart
        return [
            'labels' => $labels,
            'datasets' => [
                [

                    'label' => 'students',
                    'data' => $data,
                    'backgroundColor' =>$this->generateColors(count($data),0.5),
                    'borderColor' =>$this->generateColors(count($data),1),
                    'indexAxis'=>'x'
                    // You can specify more options here according to your chart library's requirements
                ],
                [

                    'label' => 'published research',
                    'data' => $research_data,
                    'backgroundColor' =>'#4c7d12',
                    'borderColor' =>'$this->generateColors(count($data),1)',
                    'indexAxis'=>'x'
                    // You can specify more options here according to your chart library's requirements
                ],
            ],
        ];
    }


    protected function getType(): string
    {
        return 'bar';
    }

    public function generateColors($numColors,$number)
    {
        $colors = [];
        // Iterate through each step
        for ($i = 0; $i < $numColors; $i++) {
            // Calculate RGB values for each step
            $red = 255 - ($i * (255 / ($numColors - 1)));
            $green = 255-($i * (255 / ($numColors - 10)));
            $blue = $i * (255 / ($numColors - 1));

            // Push RGBA string to the colors array
            $colors[] = "rgba($red, $green, $blue, $number)";
        }

        return $colors;
    }

}
