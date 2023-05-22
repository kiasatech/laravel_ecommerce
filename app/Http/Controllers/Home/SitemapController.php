<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
//        SitemapGenerator::create('https://example.com')->writeToFile($path);

        $sitemap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/about-us'))
            ->add(Url::create('/contact-us'));

        $sitemap->writeToFile(public_path('sitemap.xml'));

        return response()->file(public_path('sitemap.xml'));
    }
}
