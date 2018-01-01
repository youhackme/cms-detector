<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 25/12/2017
 * Time: 18:46
 */

namespace App\Engine;


class Apps
{

    private $applications;


    public function setName($name)
    {
        return $name;
    }

    public function add(App $app)
    {
        $this->applications[] = $app;
    }


    public function all()
    {
        return $this->applications;
    }

    /**
     * Unique list of applications
     * @return mixed
     */
    public function unique()
    {

        $collection = collect($this->applications);

        // A collection of unique applications except WordPress
        $applications = $technologiesCollectionExcludingWordPress = $collection->filter(function ($app) {
            return $app->name != 'WordPress';
        })->unique('name');


        // A collection of WordPress Apps
        $uniqueWordPressList = $collection->filter(function ($app) {
            return $app->name == 'WordPress';
        });

        // Merge WordPress Apps
        if ($uniqueWordPressList->count() > 1) {

            $themes  = [];
            $plugins = [];
            foreach ($uniqueWordPressList as $application) {
                $themes[]  = $application->themes;
                $plugins[] = $application->plugins;
            }

            $themeFlattened   = collect($themes)->flatten()->unique('slug');
            $pluginsFlattened = collect($plugins)->flatten()->unique('slug');


            // We need to merge plugins and themes
            $applications = $wordpressCollection = $uniqueWordPressList->unique(function ($app) use (
                $themeFlattened,
                $pluginsFlattened
            ) {

                if ($app->name == 'WordPress') {
                    $app->themes  = $themeFlattened->all();
                    $app->plugins = $pluginsFlattened->all();

                    return false;
                }

            })->merge($technologiesCollectionExcludingWordPress);

        }

        return $applications->all();

    }

}