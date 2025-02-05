<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\News;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $news = News::published()->featured()
            ->orderBy('order')
            ->limit(8)
            ->get();

        return view('home', [
            'news' => $news,
        ]);
    }

    public function newsList()
    {
        $news = News::published()->orderBy('order')->get();
        return view('news.index', compact('news'));
    }

    public function showNews(News $news)
    {
        // Increment views with rate limiting and unique tracking
        $this->incrementNewsViews($news);

        // Find similar news based on title keywords
        $similarNews = News::published()
            ->where('id', '!=', $news->id)
            // Use full-text search or keyword matching
            ->where(function($query) use ($news) {
                // Split title into keywords and search
                $keywords = explode(' ', $news->title);
                
                // Remove very short or common words
                $keywords = array_filter($keywords, function($word) {
                    return strlen($word) > 2;
                });
                
                // Search for news with similar keywords
                foreach ($keywords as $keyword) {
                    $query->orWhere('title', 'LIKE', "%{$keyword}%");
                }
            })
            ->limit(5)
            ->get();

        // If not enough similar news found, fill with recent news
        if ($similarNews->count() < 5) {
            $additionalNews = News::published()
                ->where('id', '!=', $news->id)
                ->whereNotIn('id', $similarNews->pluck('id'))
                ->limit(5 - $similarNews->count())
                ->get();
            
            $similarNews = $similarNews->merge($additionalNews);
        }

        return view('news.show', [
            'news' => $news,
            'recentNews' => $similarNews
        ]);
    }

    /**
     * Increment news views with rate limiting
     * 
     * @param News $news
     * @return void
     */
    protected function incrementNewsViews(News $news)
    {
        // Use session to prevent multiple counts from same user
        $sessionKey = 'news_view_' . $news->id;
        
        if (!session()->has($sessionKey)) {
            // Increment views
            $news->increment('views');
            
            // Mark as viewed in session
            session()->put($sessionKey, now());
        }
    }

    public function profile()
    {
        $transactions = null;
        if(auth()->user()->member()) {
            $transactions = Transaction::diposite()->where('member_id', auth()->user()->member()->id)->get();
        }
        
        return view('profile.index', compact('transactions'));
    }

    public function memberForm()
    {
        return view('member.form');
    }

    public function members()
    {
        return view('member.list');
    }

    public function aboutUs()
    {
        return view('about_us');
    }

    public function diposite()
    {
        $transactions = Transaction::diposite()->with('member')->get();
        return view('diposite.index', compact('transactions'));
    }
}
