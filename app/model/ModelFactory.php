<?php

namespace SimpleCMS\Application\Model;

class ModelFactory {

    protected $models;

    public function __construct() {
        $this->models = array(
            'PostsModel',
            'BloginfoModel',
            'CommentsModel',
            'CategoryModel',
            'UsersModel',
            'ImagesModel'
        );
    }

    public function get_model($model) {
        if (array_key_exists($model, $this->models)) {
            $model_name = __NAMESPACE__ . '\\' . $this->models[$model];
            return new $model_name;
        }
    }

}
