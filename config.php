<?php

return [
    
    //ROUTER
    'router' => [
        'value' => 'Wladweb\SimpleCMS\Assets\Router'
    ],
    
    //CONTROLLERS
    'controller_index' => [
        'value' => 'Wladweb\SimpleCMS\Controller\IndexController'
    ],
    'controller_admin' => [
        'value' => 'Wladweb\SimpleCMS\Controller\AdminController'
    ],
    'controller_category' => [
        'value' => 'Wladweb\SimpleCMS\Controller\CategoryController'
    ],
    'controller_comment' => [
        'value' => 'Wladweb\SimpleCMS\Controller\CommentController'
    ],
    'controller_images' => [
        'value' => 'Wladweb\SimpleCMS\Controller\ImagesController'
    ],
    'controller_single' => [
        'value' => 'Wladweb\SimpleCMS\Controller\SingleController'
    ],
    'controller_users' => [
        'value' => 'Wladweb\SimpleCMS\Controller\UsersController'
    ],
    'controller_posts' => [
        'value' => 'Wladweb\SimpleCMS\Controller\PostsController'
    ],
    
    //MODELS
    'model_posts' => [
        'value' => 'Wladweb\SimpleCMS\Model\Posts',
        'singleton' => true
    ],
    'model_bloginfo' => [
        'value' => 'Wladweb\SimpleCMS\Model\Bloginfo',
        'singleton' => true
    ],
    'model_category' => [
        'value' => 'Wladweb\SimpleCMS\Model\Category',
        'singleton' => true
    ],
    'model_comments' => [
        'value' => 'Wladweb\SimpleCMS\Model\Comments',
        'singleton' => true
    ],
    'model_users' => [
        'value' => 'Wladweb\SimpleCMS\Model\Users',
        'singleton' => true
    ],
    
    //PAGINATION
    'pagination' => [
        'value' => 'Wladweb\SimpleCMS\Assets\Pagination'
    ],
    
    //TRANSPORTER
    'transporter' => [
        'value' => 'Wladweb\SimpleCMS\Assets\Transporter'
    ]
];

