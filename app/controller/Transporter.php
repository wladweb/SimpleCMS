<?php

namespace SimpleCMS\Application\Controller;

use SimpleCMS\Application\App;

class Transporter {

    protected $referer = '/';
    protected $app;
    protected $params;
    protected $controllers = array(
        'SingleController',
        'AdminController',
        'AuthController',
        'CategoryController',
        'CommentController',
        'EditpostsController',
        'ImagesController',
        'IndexController',
        'UsersController'
    );
    protected $data = array(
        'SingleController' => array(
            'p1' => array('Ваш голос учтен', 'success'),
            'p2' => array('Произошла ошибка', 'error'),
            'p3' => array('Превышен лимит голосов, попробуйте проголосовать позднее',
                'info')
        ),
        'CommentController' => array(
            'ac1' => array('Комментарий успешно добавлен', 'success'),
            'ac2' => array('Произошла ошибка', 'error'),
            'ac3' => array('Пустой комментарий', 'info'),
            'e1' => array('Комметарий отредактирован', 'success'),
            'e2' => array('Ничего не изменено', 'info'),
            'd1' => array('Коментарий удален', 'success'),
            'd2' => array('Ошибка при удалении', 'error')
        ),
        'ImagesController' => array(
            'i1' => array('Картинка успешно загружена', 'success'),
            'i2' => array('Произошла ошибка', 'error'),
            'i3' => array('Не выбран файл', 'info'),
            'd1' => array('Картинка успешно удалена', 'success'),
            'd2' => array('Произошла ошибка при удалении', 'error')
        ),
        'UsersController' => array(
            'u1' => array('Информация успешно обновлена', 'success'),
            'u2' => array('Произошла ошибка при обновлении', 'error'),
            'u3' => array('Ничего не изменено', 'info'),
            'd1' => array('Пользователь успешно удален', 'success'),
            'd2' => array('Произошла ошибка при удалении', 'error')
        ),
        'AdminController' => array(
            'u1' => array('Информация успешно обновлена', 'success'),
            'u2' => array('Произошла ошибка при обновлении', 'error')
        ),
        'EditpostsController' => array(
            'u1' => array('Пост успешно отредактирован', 'success'),
            'u2' => array('Произошла ошибка при редактировании поста', 'error'),
            'd1' => array('Пост успешно удален', 'success'),
            'd2' => array('Произошла ошибка при удалении поста', 'error'),
            'a1' => array('Пост успешно добавлен', 'success'),
            'a2' => array('Произошла ошибка при добавлении поста', 'error')
        ),
        'AuthController' => array(
            'l1' => array('Неправильный логин или пароль', 'error'),
            'l2' => array('Заполните все поля', 'error'),
            'r1' => array('Успешная регистрация', 'success'),
            'r2' => array('Не удалось зарегистрироваться', 'error')
        ),
        'CategoryController' => array(
            'a1' => array('Категория успешно добавлена', 'success'),
            'a2' => array('Ошибка при добавлении категории', 'error'),
            'a3' => array('Название не может быть пустым ', 'info'),
            'u1' => array('Категория обновлена', 'success'),
            'u2' => array('Ошибка при обновлении категории', 'error'),
            'u3' => array('Ничего не изменено', 'info'),
            'd1' => array('Категория удалена', 'success'),
            'd2' => array('Ошибка при удалении категории', 'error')
        )
    );

    public function __construct() {
        $this->app = App::getInstance();
        $this->params = $this->app->getParams();
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $this->referer = $_SERVER['HTTP_REFERER'];
        }
    }

    public function end_work($c, $n, $m = '') {
        $ref = $this->get_referer();
        $c = array_search($c, $this->controllers);
        $h = "Location: $ref/cn/$c/tm/$n$m";
        header($h);
        exit;
    }

    protected function get_referer() {
        $path = parse_url($this->referer)['path'];
        $path = explode('/', trim($path, '/'));
        if (empty($path[0])) {
            $path = '/index/index';
        } elseif (count($path) == 1) {
            $path = '/' . $path[0] . '/index';
        } elseif ((!empty($path[2]) and $path[2] !== 'cn') and ! empty($path[3])) {
            $path = array_slice($path, 0, 4);
            $path = '/' . implode('/', $path);
        } else {
            $path = '/' . $path[0] . '/' . $path[1];
        }
        return $path;
    }

    public function get_message() {
        if (array_key_exists('tm', $this->params) and array_key_exists('cn',
                        $this->params)) {
            $t_message = $this->params['tm'];
            $c_name = $this->params['cn'];
            $m = $this->data[$this->controllers[$c_name]][$t_message];
            $this->get_info_block($m);
        }
    }

    public function get_info_block($m) {
        if ($m !== false) {
            echo '<div class="info-block info-' . $m[1] . '">';
            echo $m[0];
            echo '</div>';
        }
    }

}
