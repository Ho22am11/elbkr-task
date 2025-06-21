<?php

namespace App\Filament\Resources\NoneResource\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrdersPerWeekChart extends ChartWidget
{

    public function getHeading(): string
    {
        return __('heading');
    }


    protected function getData(): array
    {
         $orders = Order::selectRaw('DAYOFWEEK(created_at) AS weekday, COUNT(*) AS total')
            ->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])
            ->groupBy('weekday')
            ->pluck('total', 'weekday');

       $days = [];
    for ($i = 1; $i <= 7; $i++) {
        $days[$i] = __("day_$i");
    }

    $counts = [];
    foreach ($days as $index => $label) {
        $counts[] = $orders->get($index, 0);
    }
        return [
            'datasets' => [
                [
                    'label' => __('dataset_label'),
                    'data' => $counts,
                ],
            ],
            'labels' => array_values($days),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize'  => 1,
                        'precision' => 0,
                    ],

                ],
            ],
        ];
    }
}
