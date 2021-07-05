<?php

namespace Bank\Http\Controllers;

use Bank\Http\Requests\SearchRequest;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(SearchRequest $request)
    {
        return "hello";
        foreach ($request->get('terms') as $term) {
            $term = strtolower($term);

            $matches = $this->findbyProvider($term);
        }
    }

    private function findByProvider(string $term)
    {
        if (!starts_with($term, ':provider')) return;

        $provider = trim(ltrim(':provider'));
    }
}
