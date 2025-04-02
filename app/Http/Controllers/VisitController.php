<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use Carbon\Carbon;

class VisitController extends Controller
{
    // Метод для записи посещения
    public function trackVisit(Request $request)
    {
        $today = Carbon::today()->toDateString();

        // Находим или создаем запись для текущей даты
        $visit = Visit::firstOrCreate(['date' => $today]);

        // Увеличиваем счетчик посещений
        $visit->increment('count');

        return response()->json(['message' => 'Visit tracked successfully']);
    }


    public function getLast7DaysVisits()
    {
        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays(6);

        // Получаем данные за последние 7 дней
        $visits = Visit::whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc')
            ->get();

        // Формируем данные для графика
        $labels = [];
        $counts = [];

        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $formattedDate = $date->toDateString();
            $visit = $visits->firstWhere('date', $formattedDate);

            $labels[] = $formattedDate;
            $counts[] = $visit ? $visit->count : 0;
        }

        return response()->json([
            'labels' => $labels,
            'visits' => $counts,
        ]);
    }
}
