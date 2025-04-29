<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\UsuarioPublicate;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
  /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // modify this to your own needs
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
        //SitemapGenerator::create('https://onlyescorts.cl')->writeToFile($sitemapPath);
   
    }
}
