<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Auth;
use App\Notifications\NewUserFollowNotification;

class FollowersController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index($id)
    {
        //登录的用户
        $user = $this->userRepo->byId(Auth::guard('api')->user()->id);
        //登录用户的关注的用户
        // return $user->followedUsers;
        $followUser = $user->followedUsers()->pluck('followed_id')->toArray();
        // return $followUser;
        if (in_array($id,$followUser)) {
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function follow(Request $request)
    {
        $follower = Auth::guard('api')->user();
        $followed = $this->userRepo->byId($request->user);
        $flag = $follower->followThisUser($followed->id);
        if (count($flag['attached']) > 0) {
            $followed->increment('followers_count');
            $follower->increment('followings_count');
            $followed->notify(new NewUserFollowNotification());
            return response()->json(['followed' => true]);
        } else {
            $followed->decrement('followers_count');
            $follower->decrement('followings_count');
            return response()->json(['followed' => false]);
        }
    }
}
