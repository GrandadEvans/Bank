<?php

namespace Bank\Http\Controllers;

use Illuminate\Support\Facades\DB;

/**
 * Controller for the UI graphs
 */
class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function byTags(): string
    {
        $recordsToGrab = 8;

        $allTags =  DB::table('tag_transaction')
            ->join('tags', 'tags.id', '=', 'tag_transaction.tag_id')
            ->get('tag');
        $count = $allTags->countBy('tag');
        $array = $count->toArray();
        arsort($array);
        $array = array_slice($array, 0, $recordsToGrab);
        $data = [];
        foreach ($array as $tag => $value) {
            $data[] = [$tag, $value];
        }

        return json_encode($data);
    }

    /**
     * @param $income
     * @param $expenditure
     * @return array
     */
    protected function findDelta($income, $expenditure): array
    {
        $inInt = intval($income->group_in);
        $outInt = intval($expenditure->group_out);
        $delta = $inInt + $outInt;

        return [
            $income->month,
            $inInt,
            $outInt,
            $delta
        ];
    }

    /**
     * Get the monthly totals
     *
     * @return false|string
     */
    public function totalsByMonth(): bool|string
    {
        $income = DB::table('transactions')
            ->select(
                DB::raw('SUM(amount) AS group_in'),
                DB::raw("DATE_FORMAT(date, '%b %Y') AS month")
            )
            ->where('amount', '>', 0)
            ->groupByRaw('MONTH(date)')
            ->orderByDesc('date')
            ->limit(12)
            ->get()
            ->toArray();
        $outgoings = DB::table('transactions')
            ->select(DB::raw('SUM(amount) AS group_out'), DB::raw("DATE_FORMAT(date, '%b %Y') AS month"))
            ->where('amount', '<', 0)
            ->groupByRaw('MONTH(date)')
            ->orderByDesc('date')
            ->limit(12)
            ->get()
            ->toArray();
        $results = array_map(['Bank\Http\Controllers\GraphController', 'findDelta'], $income, $outgoings);
        array_unshift($results, ['Month', 'In', 'Out', 'Delta']);

        return json_encode($results);
    }
}
