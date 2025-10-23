<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
        $verticalMenuData = json_decode($verticalMenuJson);

        foreach ($verticalMenuData->menu as $item) {
            // if (isset($item->slug)) {
            //     $item->slug = config('app.app_url') . $item->slug;
            // }
            if (is_array($item->slug)) {
                foreach ($item->slug as &$slug) {
                    $slug = config('app.app_url') . $slug;
                }
            } elseif (isset($item->slug)) {
                $item->slug = config('app.app_url') . $item->slug;
            }
            
            if (isset($item->submenu)) {
                foreach ($item->submenu as $submenuItem) {
                    if (isset($submenuItem->slug)) {
                        $submenuItem->slug = config('app.app_url') . $submenuItem->slug;
                    }
                }
            }
        }


        // Share all menuData to all the views
        \View::share('menuData', [$verticalMenuData]);
    }
}
