<?php

namespace App\Http\Controllers\Admin;

use File;
use Validator;
use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Company;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    protected $service;

    public function __construct(ArticleService $service){
        $this->service = $service;
    }

    public function index(Request $request){
       
        $collection = Article::select('*');

        if(isset($request->tag_id) && $request->tag_id > 0){
            $collection->whereHas('tags', function($q){
                $q->where('tag_id', request()->tag_id);
            });
        }
        $articles = $collection->get();

        $companies  = Company::get();
        $tags       = Tag::get();
        return view('admin.articles.index',compact('companies','articles','tags'));
    }

    public function store(Request $request){
        if($request->ajax()){

            //Start Validation
            $messages = [
                'name.required'         => 'Name field is required.',
                'created_at.required'   => 'Date field is required.',
                'description.required'  => 'Description field is required.',
                'title.required'        => 'Title field is required.',
                'tag_id.required'       => 'Tag field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'name'          => 'required',
                'created_at'    => 'required',
                'description'   => $request->article_id > 0 ? '' : 'required',
                'title'         => 'required',
                'tag_id'        => 'required',
            ],$messages);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            } 
            //end Validation

            $article                = $request->article_id > 0 ? Article::find($request->article_id) : new Article;
            $article->title         = $request->title;
            $article->description   = $request->description;
            $article->website_url   = $request->website_url;
            $article->created_at    = Carbon::createFromFormat('Y.m.d', $request->created_at)->format('Y-m-d H:i:s');
            $article->name                  = $request->name;
            $article->comment_on_off        = $request->comment_on_off=='' ? 'off' : 'on';
            $article->comment_title         = $request->comment_on_off=='on' ?$request->comment_title : '';
            $article->comment_description   = $request->comment_on_off=='on' ?$request->comment_description : ''; 
            

            if ($request->hasFile('image')) {
                    $image  = $request->file('image');
                    $name   = 'article_'.rand(4444,5555).time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/articles');
                    if(! File::exists($destinationPath)){
                        File::makeDirectory( $destinationPath );
                    }
                    $image->move( $destinationPath, $name );
                    $article->image = '/images/articles/'.$name;
                }
            $article->save();
            $request->article_id > 0 ? $article->tags()->sync($request->tag_id) : $article->tags()->attach($request->tag_id);

            return response()->json([
                'success'   => true,
                'message'   => $request->article_id > 0 ? 'Article has been updated.' : 'Article has been created.',
                'redirect_url' => url('admin/articles'),
                'reload'    => false
            ],201);
        }
    }

    public function delete(Request $request){
        if($request->ajax()){
            if(Article::find($request->id)){
                $article = Article::find($request->id);
                $article->delete();
            }
            return response()->json([
                'success'   => true,
                'message'   => 'Article has been deleted',
            ],201);
        }
    }

    public function deleteAllArticle(Request $request) {
        $ids = $request->article_id;
        foreach($ids as $id){
            $article = Article::find($id);
            $article->delete();
        }
        return redirect()->back()->with('message','Articles has been deleted successfully');
    }

    public function upload(Request $request){
        $fileName=$request->file('file')->getClientOriginalName();
        $path=$request->file('file')->storeAs('uploads', $fileName, 'public');
        return response()->json(['location'=>"/storage/$path"]); 
        
        /*$imgpath = request()->file('file')->store('uploads', 'public'); 
        return response()->json(['location' => "/storage/$imgpath"]);*/

    }
}
