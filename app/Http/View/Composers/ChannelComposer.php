<?php


namespace App\Http\View\Composers;


use App\Models\Channel;
use Illuminate\View\View;

class ChannelComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $channel = \Cache::rememberForever('channels', function (){
            return Channel::all();
        });
        $view->with('channels', $channel);
    }
}
