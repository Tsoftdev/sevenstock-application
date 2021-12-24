<?php
namespace App\Http\Controllers\API;
  
use Session;
use Validator;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Company;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class ArticleApiController extends Controller
{
    /**
     * Get Tranding Articles for inner page
     * @Role: API
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function trandingArticles(Request $request)
    {
        $limit = $request->filled('limit') ? $request->limit : 10;
        $trandingArticles = Article::with('tags')->inRandomOrder()->take($limit)->get();
         
        return response()->json([
            'success'           => true,
            'trandingArticles'   => $trandingArticles,
            'message'           =>'Tranding articles get successfull.'
        ]);
    }

    /**
     * Get Realted Articles
     * @Role: API
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function relatedArticles(Request $request, $articleId, $relatedTagID)
    {
        $relatedArticles = Article::with('tags')->whereHas('tags', function($q) use($articleId, $relatedTagID){
                                $q->where('tag_id', '=', $relatedTagID);
                                $q->whereNotIn('article_id',[$articleId]);
                            })
                            ->inRandomOrder()
                            ->get();
         
        return response()->json([
            'success'           => true,
            'relatedArticles'   => $relatedArticles,
            'message'           =>'Related articles get successfull.'
        ]);
    }

    /**
     * Get Latest Articles
     * @Role: API
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function latestArticles(Request $request)
    {
        $latestArticles = Article::with('tags')->latest()->take(4)->orderBy('created_at','DESC')->get();
         
        return response()->json([
            'success'           => true,
            'latestArticles'   => $latestArticles,
            'message'           =>'Latest articles get successfull.'
        ]);
    }

    /**
     * Get Tags
     * @Role: API
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function getTags(Request $request)
    {
        $tags = Tag::get();
         
        return response()->json([
            'success'   => true,
            'tags' => $tags,
            'message'   =>'Tags get successfull.'
        ]);
    }

    /**
     * Get Companies
     * @Role: API
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function getCompanies(Request $request)
    {
        $companies = Company::get();
         
        return response()->json([
            'success'   => true,
            'companies' => $companies,
            'message'   =>'Companies get successfull.'
        ]);
    }

    /**
    * Get Articles with company filter
    * @Role: API
    * @param  \Illuminate\Http\Request  $request
    * @return JSON
    */
    public function getArticles(Request $request)
    {
        $collection = Article::with('company','tags')->select('articles.*');

        if(isset($request->company_id) && $request->company_id > 0){
            $collection->where('company_id',$request->company_id);
        }

        if(isset($request->tag_id) && $request->tag_id > 0){
            $collection->whereHas('tags', function($q){
                $q->where('tag_id', request()->tag_id);
            });
        }
    
        $limit = $request->filled('limit') ? $request->limit : 10;
        $collection->orderBy('created_at','DESC');
        $articles =  $request->limit != 'all' ? $collection->paginate($limit) : $collection->get();
         
        return response()->json([
            'success'   => true,
            'articles'  => $articles,
           // 'paginate'  => $articles->links(),
            'message'   =>'Articles get successfull.'
        ]);
    }

    /**
     * Get Signle Article
     * @Role: API
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function singleArticle(Request $request, $params)
    {
        $clauseType = is_numeric($params) ? 'whereId' : 'whereSlug' ;
        $article = Article::with('company','tags')->$clauseType($params)->first();
         
        return response()->json([
            'success' => true,
            'article'    => $article,
            'message' =>'Article loaded.'
        ]);
    }
}