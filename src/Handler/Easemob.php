<?php

namespace liyaojian\Easemob\Handler;

use Cache;

class Easemob
{
    // 缓存的名称
    const CACHE_NAME = 'easemob';

    // 接口地址域名
    public $domain_name = null;

    // 企业的唯一标识
    public $org_name = null;

    // “APP”唯一标识
    public $app_name = null;

    // 客户ID
    public $client_id = null;

    // 客户秘钥
    public $client_secret = null;

    // url地址
    public $url = null;

    public $http;

    /***********************   发送消息   **********************************/
    use EasemobMessages;

    public function __construct($config)
    {
        $this->domain_name = $config['domain_name'];
        $this->org_name = $config['org_name'];
        $this->app_name = $config['app_name'];
        $this->client_id = $config['client_id'];
        $this->client_secret = $config['client_secret'];
        $this->url = sprintf('%s/%s/%s/', $this->domain_name, $this->org_name, $this->app_name);
        $this->http = new Http();
    }

    /***********************   注册   **********************************/

    /**
     * 开放注册用户
     *
     * @param        $name [用户名]
     * @param string $password [密码]
     * @param string $nick_name [昵称]
     *
     * @return mixed
     */
    public function publicRegistration($name, $password = '', $nick_name = "")
    {
        $url = $this->url . 'users';
        $option = [
            'username' => $name,
            'password' => $password,
            'nickname' => $nick_name,
        ];

        return $this->http->post($url, $option);
    }


    /**
     * 授权注册用户
     *
     * @param        $name [用户名]
     * @param string $password [密码]
     * @param string $nick_name [昵称]
     *
     * @return mixed
     */
    public function authorizationRegistration($name, $password = 'e10adc3949ba59abbe56e057f20f883e', $nickname = "")
    {
        $url = $this->url . 'users';
        $option = [
            'username' => $name,
            'password' => $password,
            'nickname' => $nickname,
        ];
        $access_token = $this->getToken();

        return $this->http->post($url, $option, $access_token);
    }


    /**
     * 授权注册用户——批量
     * 密码不为空
     *
     * @param    array $users [用户名 包含 username,password的数组]
     *
     * @return mixed
     */
    public function authorizationRegistrations($users)
    {
        $url = $this->url . 'users';
        $option = $users;
        $access_token = $this->getToken();

        return $this->http->post($url, $option, $access_token);
    }

    /***********************   用户操作   **********************************/

    /**
     * 获取单个用户
     *
     * @param $user_name
     *
     * @return mixed
     */
    public function getUser($user_name)
    {
        $url = $this->url . 'users/' . $user_name;
        $option = [];
        $access_token = $this->getToken();

        return $this->http->get($url, $option, $access_token);
    }


    /**
     * 获取所有用户
     *
     * @param int $limit [显示条数]
     * @param string $cursor [光标，在此之后的数据]
     *
     * @return mixed
     */
    public function getUserAll($limit = 10, $cursor = '')
    {
        $url = $this->url . 'users';
        $option = [
            'limit' => $limit,
            'cursor' => $cursor
        ];
        $access_token = $this->getToken();

        return $this->http->get($url, $option, $access_token);
    }


    /**
     * 删除用户
     * 删除一个用户会删除以该用户为群主的所有群组和聊天室
     *
     * @param $user_name
     *
     * @return mixed
     */
    public function delUser($user_name)
    {
        $url = $this->url . 'users/' . $user_name;
        $option = [];
        $access_token = $this->getToken();

        return $this->http->delete($url, $option, $access_token);
    }


    /**
     * 修改密码
     *
     * @param $user_name
     * @param $new_password [新密码]
     *
     * @return mixed
     */
    public function editUserPassword($user_name, $new_password)
    {
        $url = $this->url . 'users/' . $user_name . '/password';
        $option = [
            'newpassword' => $new_password
        ];
        $access_token = $this->getToken();

        return $this->http->put($url, $option, $access_token);
    }


    /**
     * 修改用户昵称
     * 只能在后台看到，前端无法看见这个昵称
     *
     * @param $user_name
     * @param $nickname
     *
     * @return mixed
     */
    public function editUserNickName($user_name, $nickname)
    {
        $url = $this->url . 'users/' . $user_name;
        $option = [
            'nickname' => $nickname
        ];
        $access_token = $this->getToken();

        return $this->http->put($url, $option, $access_token);
    }


    /**
     * 强制用户下线
     *
     * @param $user_name
     *
     * @return mixed
     */
    public function disconnect($user_name)
    {
        $url = $this->url . 'users/' . $user_name . '/disconnect';
        $option = [];
        $access_token = $this->getToken();

        return $this->http->get($url, $option, $access_token);
    }


    /***********************   好友操作   **********************************/

    /**
     * 给用户添加好友
     *
     * @param $owner_username [主人]
     * @param $friend_username [朋友]
     *
     * @return mixed
     */
    public function addFriend($owner_username, $friend_username)
    {
        $url = $this->url . 'users/' . $owner_username . '/contacts/users/' . $friend_username;
        $option = [];
        $access_token = $this->getToken();

        return $this->http->post($url, $option, $access_token);
    }


    /**
     * 给用户删除好友
     *
     * @param $owner_username [主人]
     * @param $friend_username [朋友]
     *
     * @return mixed
     */
    public function delFriend($owner_username, $friend_username)
    {
        $url = $this->url . 'users/' . $owner_username . '/contacts/users/' . $friend_username;
        $option = [];
        $access_token = $this->getToken();

        return $this->http->delete($url, $option, $access_token);
    }


    /**
     * 查看用户所以好友
     *
     * @param $user_name
     *
     * @return mixed
     */
    public function showFriends($user_name)
    {
        $url = $this->url . 'users/' . $user_name . '/contacts/users/';
        $option = [];
        $access_token = $this->getToken();

        return $this->http->get($url, $option, $access_token);
    }

    /***********************   文件上传下载   **********************************/

    /**
     * 上传文件
     *
     * @param $file_path
     *
     * @return mixed
     * @throws EasemobError
     */
    public function uploadFile($file_path)
    {
        if (!is_file($file_path)) {
            throw new EasemobError('文件不存在', 404);
        }
        $url = $this->url . 'chatfiles';

        $curl_file = curl_file_create($file_path);
        $option = [
            'file' => $curl_file,
        ];
        $access_token = $this->getToken();

        return $this->http->post($url, $option, $access_token);
    }


    /**
     * 下载文件
     *
     * @param $uuid [uuid]
     * @param $share_secret [秘钥]
     *
     * @return mixed
     */
    public function downloadFile($url, $path, $filename)
    {
        $option = [];
        $access_token = $this->getToken();
        $header [] = 'Authorization: Bearer ' . $access_token;
        $header [] = 'Accept: application/octet-stream';

        $this->http->http->get($url, [
            'headers' => $header,
            'save_to' => $path . $filename
        ]);
        return true;
    }


    /***********************   token操作   **********************************/

    /**
     * 返回token
     *
     * @return mixed
     */
    public function getToken()
    {
        if ($token = Cache::get('EASEMOB_ACCESS_TOKEN')) {
            return $token;
        } else {
            $url = $this->url . "token";

            $option = [
                'grant_type' => 'client_credentials',
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
            ];

            $return = $this->http->post($url, $option);
            $token = $return['access_token'];
            Cache::setTime('EASEMOB_ACCESS_TOKEN', $token, $return['expires_in'] - 100);
            return $token;
        }
    }

    /**
     * 字符串替换
     *
     * @param $string
     *
     * @return mixed
     */
    protected static function stringReplace($string)
    {
        $string = str_replace('\\', '', $string);
        $string = str_replace(' ', '+', $string);

        return $string;
    }

}