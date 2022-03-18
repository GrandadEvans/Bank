<?php

namespace Bank\Http\Controllers;

use Bank\Http\Requests\TagFromJsRequest;
use Bank\Http\Requests\TagRequest;
use Bank\Models\Tag;
use Bank\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('tags.index')
            ->with('tags', Tag::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagRequest $request
     * @return Response
     */
    public function storeFromJs(TagFromJsRequest $request)
    {
        $statusCode = Response::HTTP_CREATED;

        try {
            $validated = $request->validated();

            if (isset($validated['tag_id']) && $validated['tag_id'] > 0) {
                $tag = Tag::findOrFail($validated['tag_id']);
            } else {
                $tag = $this->createNewTag($validated);
            }
            $transaction = Transaction::find($request->get('transaction_id'));
            $transaction->tags()->save($tag);

            $similarTransactions = [];
            if ($validated['find_similar'] == 1) {
                $entryText = $transaction->entry;
                $similarTransactions = Transaction::where('entry', $entryText)->
                    where('id', '!=', $validated['transaction_id'])->
                    get();
            }

            $reply = [
                "tag" => $tag,
                'similar_transactions' => $similarTransactions
            ];
        }
        catch(\Exception $e) {
            $statusCode = Response::HTTP_BAD_REQUEST;
            $reply = $e->getMessage();
        }
        return new Response($reply, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagFromJsRequest $request
     * @return Response
     * @throws \Throwable
     */
    public function associateFromJs(TagFromJsRequest $request)
    {
        try {
            $validated = $request->validated();
            $tag = Tag::findOrFail($validated['tag_id']);

            $transaction = Transaction::findOrFail($validated['transaction_id']);
            $transaction->tags()->save($tag);

            $entryText = $transaction->entry;
            $otherTransactions = Transaction::where('entry', $entryText)->
                where('id', '!=', $validated['transaction_id'])->
                get();

            $statusCode = Response::HTTP_CREATED;
            $reply = [
                'id' => $tag->id,
                'similarTransactions' => $otherTransactions
            ];

        }
        catch(\Exception $e) {
            $statusCode = Response::HTTP_BAD_REQUEST;
            $reply = $e->getMessage();
        }
        return new Response($reply, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagRequest $request
     * @return Response
     */
    public function store(TagRequest $request)
    {
        $validated = $request->validated();
        $tag = new Tag($validated);
        $tag->created_by_user_id = Auth::id();
        $tag->saveOrFail();

        $flashData = [
            'type' => 'success',
            'title' => 'Success!',
            'text' => 'Tag successfully created'
        ];

        session()->flash('alert', $flashData);



        return view('tags.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Bank\Models\Tag  $tag
     * @return Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Bank\Models\Tag  $tag
     * @return Response
     */
    public function edit(Tag $tag)
    {
        return view('tags.edit')
            ->with('tag', $tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TagRequest $request
     * @param Tag $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $validated = $request->validated();
        $tag->update($validated);
        $tag->saveOrFail();

        session()->put([
            'updatedTagId' => $tag->id,
            'updatedTagName' => $tag->tag,
            'updatedDefaultColor' => $tag->default_color
        ]);

        return redirect(route('tags.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Bank\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        $flashData = [
            'type' => 'success',
            'title' => 'Success!',
            'text' => 'Tag successfully deleted'
        ];

        session()->flash('alert', $flashData);
        session()->remove('hasUpdatedRegularExpressions');

        return redirect(route('tags.index'));
    }

    public function assignTransactions(Request $request)
    {
        $transactions = $request->get('transactions');
        $tagId = intval($request->get('entity'));

        $failedTransactions = [];
        $assignedTransactions = [];
        $errors = [];
        $responseText = 'OK';
        $responseCode = Response::HTTP_ACCEPTED;

        try {
            $tag = Tag::findOrFail($tagId);
            $tagdetails = [
                'name' => $tag->tag,
                'id' => $tag->id,
                'default_color' => $tag->default_color,
                'contrasted_color' => $tag->contrasted_color,
                'icon' => $tag->icon
            ];
        }
        catch(\Exception $e) {
            $errors[] = [
                'action' => 'find tag',
                'error' => $e->getMessage(),
                'tagId' => $tagId
            ];
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        if ($responseCode !== Response::HTTP_BAD_REQUEST) {
            foreach ($transactions as $transaction) {
                $tx = intval($transaction);
                try {
                    $exists = DB::table('tag_transaction')
                        ->where('tag_id', $tagId)
                        ->where('transaction_id', $tx)
                        ->exists();

                    if (!$exists) {
                        Transaction::findOrFail($tx)->tags()->save($tag);
                        $assignedTransactions[] = $tx;
                    }
                } catch (\Exception $e) {
                    $failedTransactions[] = $tx;
                    $errors[] = [
                        'action' => 'assigning tags to transactions',
                        'error' => $e->getMessage(),
                        'transactions' => $failedTransactions
                    ];
                    $responseCode = Response::HTTP_PARTIAL_CONTENT;
                }
            }
        }

        $responseText = [
            'errors' => $errors,
            'failedTransactions' => $failedTransactions,
            'assignedTransactions' => $assignedTransactions,
            'tagDetails' => $tagdetails
        ];
        return new Response($responseText, $responseCode);
    }

    public function simpleList()
    {
        return Tag::all();
    }

    private function createNewTag(array $validated)
    {
        $tag = new Tag();
        $tag->tag = $validated['tag_name'];
        $tag->icon = $validated['tag_icon'];
        $tag->created_by_user_id = Auth::id();
        $tag->default_color = '#' . $validated['default_color'];
        $tag->saveOrFail();

        return $tag;
    }
}
