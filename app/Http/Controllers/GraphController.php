<?php

namespace Bank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function byTags($months)
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
        foreach($array as $tag => $value) {
            $data[] = [$tag, $value];
        }

        return json_encode($data);
    }

    protected function combineIncomeOutgoings($in, $out)
    {
        $inInt = intVal($in->group_in);
        $outInt = intVal($out->group_out);
        $delta = $inInt + $outInt;

        return [
            $in->month,
            $inInt,
            $outInt,
            $delta
        ];
    }

    public function totalsByMonth()
    {
        $income = DB::table('transactions')
            ->select(
                DB::raw("SUM(amount) AS group_in"),
                DB::raw("DATE_FORMAT(date, '%b %Y') AS month"))
            ->where('amount', '>', 0)
            ->groupByRaw('MONTH(date)')
            ->orderByDesc('date')
            ->limit(12)
            ->get()
            ->toArray();
        $outgoings = DB::table('transactions')
            ->select(DB::raw("SUM(amount) AS group_out"), DB::raw("DATE_FORMAT(date, '%b %Y') AS month"))
            ->where('amount', '<', 0)
            ->groupByRaw('MONTH(date)')
            ->orderByDesc('date')
            ->limit(12)
            ->get()
            ->toArray();
        $results = array_map(['Bank\Http\Controllers\GraphController', 'combineIncomeOutgoings'], $income, $outgoings);
        array_unshift($results, ['Month', 'In', 'Out', 'Delta']);

        return json_encode($results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
