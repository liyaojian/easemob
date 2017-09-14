<?php

namespace liyaojian\Easemob\App;

trait EasemobMessages
{

    /**
     * 发送文本消息
     *
     * @param array $users [接收的对象数组]
     * @param string $target_type [类型]
     * @param string $message [内容]
     * @param string $send_user [消息发送者]
     * @param array $ext [消息扩展体]
     *
     * @return mixed
     * @throws EasemobError
     */
    public function sendMessageText($users, $target_type = 'users', $message = "", $send_user = 'admin', $ext = [])
    {
        $url = $this->url . 'messages';
        $option = [
            'target_type' => $target_type,
            'target' => $users,
            'msg' => [
                'type' => 'txt',
                'msg' => $message
            ],
            'from' => $send_user
        ];

        // 是否有消息扩展
        if (!empty($ext)) {
            $option['ext'] = $ext;
        }

        $access_token = $this->getToken();
        return $this->http->post($url, $option, $access_token);
    }


    /**
     * 发送图片消息
     *
     * @param array $users [接收的对象数组]
     * @param string $target_type [类型]
     * @param string $uuid [文件的uuid]
     * @param string $share_secret [文件的秘钥 上传后生产]
     * @param string $file_name [指定文件名]
     * @param int $width [宽]
     * @param int $height [高]
     * @param string $send_user
     *
     * @return mixed
     * @throws EasemobError
     */
    public function sendMessageImg($users, $target_type = 'users', $uuid, $share_secret, $file_name, $width = 480, $height = 720, $send_user = 'admin')
    {
        $url = $this->url . 'messages';
        $option = [
            'target_type' => $target_type,
            'target' => $users,
            'msg' => [
                'type' => 'img',
                'url' => $this->url . 'chatfiles/' . $uuid,
                'filename' => $file_name,
                'secret' => $share_secret,
                'size' => [
                    'width' => $width,
                    'height' => $height
                ]
            ],
            'from' => $send_user
        ];
        $access_token = $this->getToken();

        return $this->http->post($url, $option, $access_token);

    }


    /**
     * 发送语音消息
     *
     * @param array $users [接收的对象数组]
     * @param string $target_type [类型]
     * @param string $uuid [文件的uuid]
     * @param string $share_secret [文件的秘钥 上传后生产]
     * @param string $file_name [指定文件名]
     * @param int $length [长度]
     * @param string $send_user
     *
     * @return mixed
     * @throws EasemobError
     */
    public function sendMessageAudio($users, $target_type = 'users', $uuid, $share_secret, $file_name, $length = 10, $send_user = 'admin')
    {
        $url = $this->url . 'messages';
        $option = [
            'target_type' => $target_type,
            'target' => $users,
            'msg' => [
                'type' => 'audio',
                'url' => $this->url . 'chatfiles/' . $uuid,
                'filename' => $file_name,
                'secret' => $share_secret,
                'length' => $length
            ],
            'from' => $send_user
        ];
        $access_token = $this->getToken();

        return $this->http->post($url, $option, $access_token);
    }

    /**
     * 发送视频消息
     *
     * @param array $users
     * @param string $target_type [类型]
     * @param string $uuid [文件的uuid]
     * @param string $share_secret [文件的秘钥 上传后生产]
     * @param string $file_name [指定文件名]
     * @param int $length [长度]
     * @param string $send_user
     *
     * @return mixed
     * @throws EasemobError
     */
    /**
     * 发送视频消息
     *
     * @param array $users [接收的对象数组]
     * @param string $target_type [类型]
     * @param        $video_uuid [视频uuid]
     * @param        $video_share_secret [视频秘钥]
     * @param        $video_file_name [下载的时候视频名称]
     * @param int $length [长度]
     * @param int $video_length [视频大小]
     * @param        $img_uuid [缩略图]
     * @param        $img_share_secret [图片秘钥]
     * @param string $send_user [发送者]
     *
     * @return mixed
     * @throws EasemobError
     */
    public function sendMessageVideo($users, $target_type = 'users', $video_uuid, $video_share_secret, $video_file_name, $length = 10, $video_length = 58103, $img_uuid, $img_share_secret, $send_user = 'admin')
    {
        $url = $this->url . 'messages';
        $option = [
            'target_type' => $target_type,
            'target' => $users,
            'msg' => [
                'type' => 'video',
                'url' => $this->url . 'chatfiles/' . $video_uuid,
                'filename' => $video_file_name,
                'thumb_secret' => $video_share_secret,
                'length' => $length,
                'file_length' => $video_length,
                'thumb' => $this->url . 'chatfiles/' . $img_uuid,
                'secret' => $img_share_secret
            ],
            'from' => $send_user
        ];
        $access_token = $this->getToken();

        return $this->http->post($url, $option, $access_token);
    }


    /**
     * 消息透传
     *
     * @param array $users [接收的对象数组]
     * @param string $target_type [类型]
     * @param string $action [内容]
     * @param string $send_user [消息发送者]
     *
     * @return mixed
     * @throws EasemobError
     */
    public function sendMessagePNS($users, $target_type = 'users', $action = "", $send_user = 'admin')
    {
        $url = $this->url . 'messages';
        $option = [
            'target_type' => $target_type,
            'target' => $users,
            'msg' => [
                'type' => 'cmd',
                'action' => $action
            ],
            'from' => $send_user
        ];
        $access_token = $this->getToken();

        return $this->http->post($url, $option, $access_token);
    }

    /**
     * 获取历史记录文件地址
     * @param $time 20170920 格式
     * @return mixed
     * @throws EasemobError
     */
    public function getMessageHistoryUrl($time)
    {
        $url = $this->url . 'chatmessages/' . $time;
        $option = [];
        $access_token = $this->getToken();

        $response = $this->http->get($url, $option, $access_token);
        if ($response['status_code'] != 200) {
            throw new EasemobError($response['data']['error'], $response['status_code']);
        }
        return $response;
    }

    /**
     * 保存历史记录到本地
     * @param $time 20170920 格式
     * @param $path 绝对路径 
     * @return mixed
     */
    public function saveMessageHistory($time, $path = '/')
    {
        $response = $this->getMessageHistoryUrl($time);
        $urls = $response['data']['data'];
        if (!empty($urls)) {
            $file_count = 0;
            $file = [];
            foreach ($urls as $key => $value) {
                $file_count++;
                $url = $value['url'];
                $filename = $time . '-' . $file_count . '.gz';
                $file[] = $filename;
                $this->http->http->get($url, ['save_to' => $path . $filename]);
            }
            return $file;
        }
        throw new EasemobError('can not get downurl',404);
    }
}