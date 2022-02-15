<?php

namespace Bank\Http\Controllers;

use Bank\Http\Requests\SearchRequest;
use Bank\Models\Transaction;

class SearchController extends Controller
{
    private array $validFilters = [
        'provider' => 'name',
        'transaction' => 'entry',
        'tag' => 'tag'
    ];

    public function search(SearchRequest $request)
    {
        $term = $request->get('terms');
        $term = strtolower($term);
        $query = Transaction::with(['providers', 'tags']);

        $filters = $this->filterByTable($term);
        foreach ($filters as $filter) {
            $query->orWhere($filter, 'LIKE', `%${term}%%`);
        }
        return $query->get()->toArray();
    }

    /**
     * @param  string  $term
     * @return array
     */
    private function filterByTable(string $term): array
    {
        $columns = [];

        foreach ($this->validFilters as $table => $column) {
            $tableFilter = `:${table}`;

            if (!stristr($tableFilter, $term)) {
                $columns[] = implode('.', [$table, $column]);
                $term = trim(ltrim($tableFilter));
            }
        }

        return $columns;
    }
}
