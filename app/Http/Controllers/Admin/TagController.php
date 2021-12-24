<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function store(Request $request){
        if($request->ajax()){

            //Start Validation
            $messages = [
                'name.required'        => 'Name field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'name'    => 'required',
            ],$messages);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            } 
            //end Validation

            $tag        = $request->tag_id > 0 ? Tag::find($request->tag_id) : new Tag;
            $tag->name  = $request->name;
            $tag->save();

            return response()->json([
                'success'   => true,
                'message'   => $request->tag_id > 0 ? 'Tag has been updated.' : 'Tag has been created.',
                'redirect_url' => url('admin/articles'),
                'reload'    => false
            ],201);
        }
    }

    public function delete(Request $request){
        if($request->ajax()){
            if(Tag::find($request->id)){
                $tag = Tag::find($request->id);
                $tag->delete();
            }
            return response()->json([
                'success'   => true,
                'message'   => 'Tag has been deleted',
            ],201);
        }
    }

    public function deleteAllTag(Request $request) {
        $ids = $request->tag_id;
        foreach($ids as $id){
            $tag = Tag::find($id);
            $tag->delete();
        }
        return redirect()->back()->with('message','Tags has been deleted successfully');
    }
}
