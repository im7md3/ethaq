<?php

namespace App\Observers;

use App\Models\WebsitePage;
use Illuminate\Support\Str;

class WebsitePageObserver
{
    /**
     * Handle the WebsitePage "created" event.
     *
     * @param  \App\Models\WebsitePage  $websitePage
     * @return void
     */
    public function created(WebsitePage $websitePage)
    {
        $slug = Str::slug($websitePage->title);
            $count = WebsitePage::where('slug', 'LIKE', "{$slug}%")->count();
            if ($count) {
                $slug .= '-' . ($count + 1);
            }
            $websitePage->slug = $slug;
            $websitePage->save();
        }

    /**
     * Handle the WebsitePage "updated" event.
     *
     * @param  \App\Models\WebsitePage  $websitePage
     * @return void
     */
    public function updated(WebsitePage $websitePage)
    {
        //
    }

    /**
     * Handle the WebsitePage "deleted" event.
     *
     * @param  \App\Models\WebsitePage  $websitePage
     * @return void
     */
    public function deleted(WebsitePage $websitePage)
    {
        //
    }

    /**
     * Handle the WebsitePage "restored" event.
     *
     * @param  \App\Models\WebsitePage  $websitePage
     * @return void
     */
    public function restored(WebsitePage $websitePage)
    {
        //
    }

    /**
     * Handle the WebsitePage "force deleted" event.
     *
     * @param  \App\Models\WebsitePage  $websitePage
     * @return void
     */
    public function forceDeleted(WebsitePage $websitePage)
    {
        //
    }
}
