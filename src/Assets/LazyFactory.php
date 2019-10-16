<?php

namespace Wladweb\SimpleCMS\Assets;

use Wladweb\SimpleCMS\Application as App;

class LazyFactory
{
    public function getPosts()
    {
        return App::get('model_posts');
    }

    public function getCategory()
    {
        return App::get('model_category');
    }

    public function getBloginfo()
    {
        return App::get('model_bloginfo');
    }

    public function getUsers()
    {
        return App::get('model_users');
    }

    public function getComments()
    {
        return App::get('model_comments');
    }

}
