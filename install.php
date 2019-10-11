<?php

namespace SimpleCMS;

use Wladweb\SimpleCMS\Model\BlogModel;
use Wladweb\SimpleCMS\BlogException;
use RedBeanPHP\RedException;
use RedBeanPHP\R;

class SimpleInstall
{
    protected $post_data;
    protected $date;

    /**
     * Setup database connection with RedBeanPHP
     * 
     * @param string $path Path to setup.ini file
     * @return void 
     */
    public function __construct($path)
    {

        try {
            new BlogModel($path);
        } catch (BlogException $blog_e) {
            echo $blog_e->getMessage();
        } catch (RedException $red_e) {
            echo $red_e->getMessage();
        }

        $this->post_data = $this->get_post_data();

        $dt = new \DateTime;
        $this->date = $dt->format('Y-m-d H:i:s');
    }

    /**
     * Clear string, remove tags and spaces
     * 
     * @param string $str Input string
     * @return string Output string
     */
    protected function clear_string($str)
    {
        return trim(strip_tags($str));
    }

    /**
     * Save data from POST
     * 
     * @return array
     */
    protected function get_post_data()
    {
        $post_data = array();
        $post_data['blog_name'] = $this->clear_string($_POST['blog_name']);
        $post_data['blog_desc'] = $this->clear_string($_POST['blog_desc']);
        $post_data['author'] = $this->clear_string($_POST['author']);
        $post_data['email'] = $this->clear_string($_POST['email']);
        $post_data['login'] = $this->clear_string($_POST['login']);
        $post_data['pass'] = $this->clear_string($_POST['pass']);
        return $post_data;
    }

    /**
     * Create tables and start data with RedBeanPHP
     * 
     * @return void 
     */
    public function create_tables()
    {
        if (!R::testConnection()) {
            throw new BlogException('Unable connect');
        }

        R::freeze(false);

        //table comments <-admin comment
        $acomment = R::dispense('comments');
        $acomment->cbody = 'Комментарий админа';
        $acomment->ctime = $this->date;
        $acomment->anchor = 'comm54bb8a7a39c1b';

        //table comments <-user comment
        $ucomment = R::dispense('comments');
        $ucomment->cbody = 'Первый комметарий пользователя';
        $ucomment->ctime = $this->date;
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
        $post->ctime = $this->date;
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
        $auser->lastvote = $this->date;
        $auser->utime = $this->date;
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
        $uuser->lastvote = $this->date;
        $uuser->utime = $this->date;
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
    }

}
