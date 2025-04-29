<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\Ciudad;
use App\Models\Foro;
use App\Models\Post;
use App\Models\Posts;
use App\Models\UsuarioPublicate;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SitemapController2 extends Controller
{
    public function index(){

        $content = file_get_contents(resource_path('sitemap.xml'));

        // Render the sitemap
        return response($content, 200, [
            'Content-Type' => 'application/xml'
        ]);   

    }

    public function profiles(){

        $sitemapPath = public_path('sitemap_profiles.xml');
        $sitemap = Sitemap::create();
        $today = new \DateTime(date("Y-m-d"));

       
         // Add dynamic pages (example with blog posts)
        $scort = UsuarioPublicate::get();
        //var_dump($scort);
        
        foreach ($scort as $scorts) {
            $url = $scorts->fantasia;
            $estado = $scorts->estadop;
            if(preg_match('/^[a-z áéíóúñüÁÉÍÓÚÑÜ]*$/',utf8_encode($url))){
                                       
            }else{
                //var_dump();
                $url = str_replace(' ', '-', $url);
                $url = str_replace('ñ', 'n', $url);
                $url = str_replace('á', 'a', $url);
                $url = str_replace('é', 'e', $url);
                $url = str_replace('í', 'i', $url);
                $url = str_replace('ó', 'o', $url);
                $url = str_replace('ú', 'u', $url);
                $url = str_replace('ü', 'u', $url);
            }
            if($estado == 1){
                $urls[] = [
                    'loc' => url('/escorts/' . strtolower($url).'-'.$scorts->id),
                    'lastmod' => Carbon::now()->toIso8601String(),
                    'changefreq' => 'daily',
                    'priority' => '0.64'
                ];
                foreach ($urls as $url) {
                    $sitemap->add(Url::create($url['loc'])
                        ->setLastModificationDate(new \DateTime($url['lastmod']))
                        ->setChangeFrequency($url['changefreq'])
                        ->setPriority($url['priority']));
                }
            } 
        }
        
        $sitemap->writeToFile($sitemapPath);
    
        // Render the sitemap
        return response($sitemap->render(), 200)->header('Content-Type', 'application/xml');
    }

    public function menu(){

        $sitemapPath = public_path('sitemap_menu.xml');
        $sitemap = Sitemap::create();
        $today = new \DateTime(date("Y-m-d"));

       
         // Add dynamic pages (example with blog posts)
        $ciudad = Ciudad::get();
        //var_dump($ciudad);
        foreach ($ciudad as $ciudades) {
            $url = $ciudades->nombre;

            if(preg_match('/^[a-z áéíóúñüÁÉÍÓÚÑÜ]*$/',utf8_encode($url))){
                                       
            }else{
                //var_dump();
                $url = str_replace(' ', '-', $url);
                $url = str_replace('ñ', 'n', $url);
                $url = str_replace('á', 'a', $url);
                $url = str_replace('é', 'e', $url);
                $url = str_replace('í', 'i', $url);
                $url = str_replace('ó', 'o', $url);
                $url = str_replace('ú', 'u', $url);
                $url = str_replace('ü', 'u', $url);
            }

            $urls[] = [
                'loc' => url('escorts-' . strtolower($url)),
                'lastmod' => Carbon::now()->toIso8601String(),
                'changefreq' => 'daily',
                'priority' => '1'
            ];
            foreach ($urls as $url) {
                $sitemap->add(Url::create($url['loc'])
                    ->setLastModificationDate(new \DateTime($url['lastmod']))
                    ->setChangeFrequency($url['changefreq'])
                    ->setPriority($url['priority']));
            }
        }
          // Add static pages
        $sitemap->add(Url::create('/foro')->setPriority(0.6)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
    
        $sitemap->writeToFile($sitemapPath);
    
        // Render the sitemap
        return response($sitemap->render(), 200)->header('Content-Type', 'application/xml');
   
    }

    public function blog(){

        $sitemapPath = public_path('sitemap_blog.xml');
        $sitemap = Sitemap::create();
        $today = new \DateTime(date("Y-m-d"));

        // Add static pages
        $sitemap->add(Url::create('/blog')->setPriority(0.6)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        
         // Add dynamic pages (example with blog posts)
        $blog_articulo = BlogArticle::get();
        $blog_categoria = BlogCategory::get();

        foreach ($blog_articulo as $blog_articulos) {
            $url = $blog_articulos->slug;

            $urls[] = [
                'loc' => url(($url)),
                'lastmod' => Carbon::now()->toIso8601String(),
                'changefreq' => 'daily',
                'priority' => '0.6'
            ];
            foreach ($urls as $url) {
                $sitemap->add(Url::create($url['loc'])
                    ->setLastModificationDate(new \DateTime($url['lastmod']))
                    ->setChangeFrequency($url['changefreq'])
                    ->setPriority($url['priority']));
            }
        }

        foreach ($blog_categoria as $blog_categorias) {
            $url = $blog_categorias->slug;

            $urls[] = [
                'loc' => url(('category/'.$url)),
                'lastmod' => Carbon::now()->toIso8601String(),
                'changefreq' => 'daily',
                'priority' => '0.6'
            ];
            foreach ($urls as $url) {
                $sitemap->add(Url::create($url['loc'])
                    ->setLastModificationDate(new \DateTime($url['lastmod']))
                    ->setChangeFrequency($url['changefreq'])
                    ->setPriority($url['priority']));
            }
        }
        $sitemap->writeToFile($sitemapPath);
    
        // Render the sitemap
        return response($sitemap->render(), 200)->header('Content-Type', 'application/xml');
   
    }
    public function landing(){

        $content = file_get_contents(resource_path('sitemap_landing.xml'));

        // Render the sitemap
        return response($content, 200, [
            'Content-Type' => 'application/xml'
        ]); 
    }

}
