<?php

namespace App\Http\Controllers;

use App\Http\Requests\WallRequest;
use App\Models\Wall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WallController extends Controller
{
    public function createNewPostOnWall(WallRequest $request)
    {
        $userID1 = Auth::user()->id;
        $userID2 = $request->userID2;
        $content = $request->input('content');
        $wall = new Wall();
        $wall->userID1 = $userID1;
        $wall->userID2 = $userID2;
        $wall->content = $content;
        $wall->save();

        return Redirect::back()->with('createWall', 'Successfully  created post on the wall');
    }

    public function editPostOnWallView($wallId)
    {
        $wall = Wall::findOrFail($wallId);
        return response()->json($wall);
    }

    public function editPostOnWall(Request $request)
    {
        $content = $request->input('content');

        $wall = Wall::find($request->id);
        $wall->content = $content;
        $wall->save();

        return response()->json($wall);
    }

    public function deletePostOnWall(Request $request)
    {
        $id = $request->id;
        $wall = Wall::where('id', '=', $id)->delete();

        return Redirect::back()->with('deletePostWall', 'Successfully  deleted post on the wall');
    }
}
