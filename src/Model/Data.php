<?php

namespace Wladweb\SimpleCMS\Model;

use Wladweb\SimpleCMS\Application as App;

class Data
{
    private $params;

    const MODEL_NAMESPACE = 'Wladweb\\SimpleCMS\\Model\\';

    public function __construct()
    {
        $this->params = App::getParams();
    }

    public function __call($name, $arguments = array())
    {
        $class = array_shift($arguments);

        $class = self::MODEL_NAMESPACE . $class;
        $object = new $class;
        if (empty($arguments)) {
            return $object->$name();
        } else {
            return $object->$name($arguments[0]);
        }
    }

    protected function getCommonData()
    {

        $result['bloginfo'] = App::get('model_bloginfo')->getData();
        $result['menu'] = App::get('model_category')->getCategories();

        //sidebar
        $result['popular_posts'] = App::get('model_posts')->getPopularList();
        $result['last_comments'] = App::get('model_comments')->getLastComments();

        return $result;
    }

    public function getCategoriesList()
    {
        return App::get('model_category')->getCategories(true);
    }

    public function getIndexData($start, $size)
    {

        $result = $this->getCommonData();

        $posts_data = App::get('model_posts')->getPostsList($start, $size);

        $result['posts'] = $posts_data['posts'];
        $result['posts_count'] = $posts_data['posts_count'];

        return $result;
    }

    public function getCategoryData($id, $start, $size)
    {

        $result = $this->getCommonData();

        $category_data = App::get('model_category')->getCategoryPosts($id, $start, $size);

        $result['category'] = $category_data['category'];
        if (isset($category_data['posts']))
            $result['posts'] = $category_data['posts'];
        $result['posts_count'] = $category_data['posts_count'];

        return $result;
    }

    public function getPostData($id)
    {

        $result = $this->getCommonData();

        $post_bean = App::get('model_posts')->getPost($id);

        $result['comments'] = $post_bean->ownCommentsList;
        $result['post'] = $post_bean->export();

        return $result;
    }

    public function getUserData($id)
    {

        $user_bean = App::get('model_users')->get($id);

        $result['comments'] = $user_bean->ownCommentsList;
        $result['user_id'] = $user_bean->id;

        return $result;
    }

    public function getAdminBloginfo()
    {
        $result['count_data'] = $this->countData();
        $result['bloginfo'] = App::get('model_bloginfo')->getData();

        return $result;
    }

    public function getComments($start, $size)
    {
        return App::get('model_comments')->getCommentsList($start, $size);
    }

    public function getUsers($start, $size)
    {
        return App::get('model_users')->getUsersList($start, $size);
    }

    public function countData()
    {

        $bloginfo = App::get('model_bloginfo');

        $count_data['posts'] = $bloginfo->getCount('posts');
        $count_data['users'] = $bloginfo->getCount('users');
        $count_data['comments'] = $bloginfo->getCount('comments');
        $count_data['category'] = $bloginfo->getCount('category');

        return $count_data;
    }

}
