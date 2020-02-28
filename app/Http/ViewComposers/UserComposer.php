<?php


namespace App\Http\ViewComposers;


use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserComposer
{
    protected $user;
    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = $this->user;
        }
        $view->with('user', $this->user);
    }
}
