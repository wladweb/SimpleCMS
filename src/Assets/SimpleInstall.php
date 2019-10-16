<?php

namespace Wladweb\SimpleCMS\Assets;

use Wladweb\SimpleCMS\Application as App;
use RedBeanPHP\R;

class SimpleInstall
{
    private $post_data = [];
    private $have_post = false;
    private static $tables = [
        'comments',
        'posts',
        'category',
        'users',
        'bloginfo',
        'role'
    ];

    public static function checkInstallation(): void
    {
        $tables = R::inspect();

        if (empty($tables)) {

            self::install();
        } else {

            if (!empty(array_diff(self::$tables, $tables))) {
                echo 'Database not empty';
                exit;
            }
        }
    }

    private static function install()
    {
        $install = new self;
        $install->run();
    }

    /**
     * Setup database connection with RedBeanPHP
     * 
     * @param string $path Path to setup.ini file
     * @return void 
     */
    public function __construct()
    {
        if (\filter_has_var(INPUT_POST, 'send-from')) {
            $this->have_post = true;
        }
    }

    private function run()
    {
        if ($this->have_post) {
            $this->post_data = $this->getPostData();
            $this->createTables();
        } else {
            require_once App::$app_dir . DIRECTORY_SEPARATOR . 'src/View/atemplate/install_template.php';
        }
    }

    /**
     * Save data from POST
     * 
     * @return array
     */
    protected function getPostData()
    {
        $post_data = [];

        $post_data['blog_name'] = \filter_input(INPUT_POST, 'blog_name', FILTER_SANITIZE_STRING);
        $post_data['blog_desc'] = \filter_input(INPUT_POST, 'blog_desc', FILTER_SANITIZE_STRING);
        $post_data['author'] = \filter_input(INPUT_POST, 'author', FILTER_SANITIZE_STRING);
        $post_data['email'] = \filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $post_data['login'] = \filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
        $post_data['pass'] = \filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
        $post_data['date'] = \date('Y-m-d H:i:s', \time());

        return $post_data;
    }

    /**
     * Create tables and start data with RedBeanPHP
     * 
     * @return void 
     */
    public function createTables()
    {
        R::freeze(false);

        //table comments <-admin comment
        $acomment = R::dispense('comments');
        $acomment->cbody = 'Комментарий админа';
        $acomment->ctime = $this->post_data['date'];
        $acomment->anchor = 'comm54bb8a7a39c1b';

        //table comments <-user comment
        $ucomment = R::dispense('comments');
        $ucomment->cbody = 'Первый комметарий пользователя';
        $ucomment->ctime = $this->post_data['date'];
        $ucomment->anchor = 'comm54bb8a7a39c1a';

        //table posts
        $post = R::dispense('posts');
        $post->title = 'Первый пост';
        $post->content = ''
                . '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam efficitur venenatis leo, eu pharetra metus eleifend nec. Suspendisse sagittis blandit aliquet. Praesent rhoncus aliquam mi vitae euismod. Etiam velit tellus, dignissim in ex non, facilisis sodales purus. Pellentesque interdum, diam eget lobortis rutrum, nibh nibh efficitur ipsum, eget varius ipsum enim malesuada nunc. Pellentesque lobortis, nulla vitae tincidunt volutpat, orci nunc ullamcorper nunc, at viverra mi lacus ac ante. Nam diam sapien, egestas eget erat quis, rutrum tempor enim. Vivamus sed velit diam.

Etiam egestas velit metus, nec aliquam dui elementum in. Quisque erat velit, efficitur in augue at, aliquam commodo odio. Nam suscipit turpis nec dictum malesuada. Morbi lectus urna, aliquam vel efficitur vitae, mollis ac justo. Praesent tincidunt viverra dignissim. Nullam ut iaculis diam. Nullam convallis molestie malesuada. Duis tincidunt dolor justo, in sagittis nisl vulputate quis. Nam convallis nibh id accumsan porta. Donec et orci non nisi tristique vulputate.

Nulla sollicitudin felis in mi facilisis dapibus. Vivamus cursus tellus maximus pellentesque tempus. In vitae gravida augue. Sed eget sem urna. Donec consequat sem vitae ligula pharetra, vel rutrum neque eleifend. Aliquam vehicula ut felis facilisis vulputate. Nulla facilisi. Vestibulum rutrum, nibh quis dictum tincidunt, dolor nulla iaculis sapien, at hendrerit ligula justo nec sapien. Sed ut tincidunt neque. Aenean ultrices lorem non odio mollis, at tincidunt dolor vestibulum. Cras semper vel justo at pharetra. Integer efficitur consectetur justo eu finibus. Donec finibus tellus eu tortor euismod, ut dictum velit sollicitudin. Donec ac lorem in elit posuere vestibulum feugiat a risus.

Donec ut mattis tellus. Vestibulum erat lectus, aliquet ac blandit in, gravida id massa. Phasellus dignissim nisi a dolor dapibus auctor. Aliquam porta velit nec turpis congue, non auctor nisl varius. Ut eget neque nisi. Aliquam pharetra risus ut metus pellentesque sagittis. Donec ornare, magna feugiat aliquam fermentum, nibh metus porttitor turpis, eget finibus lacus tellus vel nisi.

Aliquam sed sodales ligula, eu facilisis eros. Mauris commodo libero orci, a sagittis turpis sagittis eget. Aenean facilisis purus nisl, ut maximus justo hendrerit sed. Praesent scelerisque ante non leo laoreet, vitae sagittis diam sollicitudin. Curabitur ac dictum neque. Pellentesque vel lorem tellus. Proin finibus tempus elementum. Sed a volutpat enim. Vivamus sit amet dolor eu tortor euismod consequat congue ac velit. Vestibulum tincidunt urna vitae enim tempus, et placerat est consequat. Morbi blandit elit at metus venenatis ornare. Phasellus pharetra metus et tellus egestas commodo. Etiam cursus metus sollicitudin tortor volutpat auctor. ';

        $post->subtitle = 'Первая запись в блоге';
        $post->ctime = $this->post_data['date'];
        $post->popular = 0;
        $post->img = 'hello_world.jpg';
        $post->ownCommentsList[] = $acomment;
        $post->ownCommentsList[] = $ucomment;

        //table category
        $category = R::dispense('category');
        $category->cat_name = "Без категории";
        $category->show_it = 1;
        $category->ownPostsList[] = $post;

        //table users <-admin
        $auser = R::dispense('users');
        $auser->uname = $this->post_data['login'];
        $auser->avatar = 'site.gif';
        $auser->role = R::enum('role:admin');
        $auser->upass = md5(md5($this->post_data['pass']));
        $auser->uemail = $this->post_data['email'];
        $auser->ukey = md5(microtime() . rand(1000, 100000));
        $auser->lastvote = $this->post_data['date'];
        $auser->utime = $this->post_data['date'];
        $auser->ownCommentsList[] = $acomment;
        $auser->ownPostsList[] = $post;

        //table users <-user
        $uuser = R::dispense('users');
        $uuser->uname = 'user';
        $uuser->avatar = 'site.gif';
        $uuser->role = R::enum('role:user');
        $uuser->upass = md5(md5('user'));
        $uuser->uemail = 'user@gmail.com';
        $uuser->ukey = md5(microtime() . rand(1000, 100000));
        $uuser->lastvote = $this->post_data['date'];
        $uuser->utime = $this->post_data['date'];
        $uuser->ownCommentsList[] = $ucomment;

        //table bloginfo
        $bloginfo = R::dispense('bloginfo');
        $bloginfo->author = $this->post_data['author'];
        $bloginfo->email = $this->post_data['email'];
        $bloginfo->blogname = $this->post_data['blog_name'];
        $bloginfo->description = $this->post_data['blog_desc'];
        $bloginfo->template = 'watchis';
        $bloginfo->pagination = 10;

        //save
        $beans = [
            $category,
            $auser,
            $uuser,
            $post,
            $acomment,
            $ucomment,
            $bloginfo
        ];

        R::storeAll($beans);
        R::freeze(true);
    }

}
