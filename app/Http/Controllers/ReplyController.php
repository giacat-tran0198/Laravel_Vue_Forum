<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * ReplyController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Channel $channel
     * @param Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Channel $channel, Thread $thread)
    {
        $this->validateReply();

        $reply = $thread->addReply([
            'body' => $request->get('body'),
            'user_id' => auth()->id(),
        ]);
        if ($request->expectsJson()){
            return $reply->load('owner');
        }
        return back()
            ->with('flash', 'Votre réponse a été laissée.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply, Spam $spam)
    {
        $this->authorize('update', $reply);
        $this->validateReply();

        $reply->update($request->all('body'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();
        if (request()->wantsJson()){
            return response(['statut' => 'Commentaire supprimé']);
        }
        return back();
    }

    protected function validateReply()
    {
        \request()->validate([
            'body' => 'required',
        ]);

        resolve(Spam::class)->detect(\request()->get('body'));
    }
}
