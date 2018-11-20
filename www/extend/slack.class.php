<?php
if (!defined('_GNUBOARD_')) exit;

/*
https://api.slack.com/incoming-webhooks
https://www.webpagefx.com/tools/emoji-cheat-sheet/
*/

define('G5_SLACK_USE', true);

if(!defined('G5_SLACK_USE') || G5_SLACK_USE !== true)
    return;

// 경로설정
define('G5_SLACK_PATH', G5_PLUGIN_PATH.'/'.G5_SLACK_DIR);

// Slack 설정
define('G5_SLACK_WEBHOOK_URL', '');
define('G5_SLACK_CHANNEL',     '#general');
define('G5_SLACK_ICON_URL',    'https://a.slack-edge.com/41b0a/img/plugins/app/service_36.png');
define('G5_SLACK_EMOJI',       ':loudspeaker:');
define('G5_SLACK_BAR_COLOR',   '#36a64f');

class SLACK
{
    private $webHookUrl;
    private $channel;
    private $userName;
    private $message;
    private $iconEmoji;
    private $iconUrl;
    private $attachments;
    private $attachmentsText;
    private $attachmentsTitle;
    private $attachmentsPreText;
    private $attachmentsColor;
    private $attachmentsAuthor;
    private $attachmentsFields;
    private $attachmentsFooter;

    public function __construct($webHookUrl='', $userName='') {
        $this->webHookUrl        = $webHookUrl;
        $this->userName          = $userName;
        $this->iconEmoji         = '';
        $this->iconUrl           = '';
        $this->message           = '';
        $this->attachments       = array();
        $this->attachmentsFields = array();
    }

    public function setWebHookUrl($webHookUrl) {
        $this->webHookUrl = $webHookUrl;
    }

    public function setChannel($channel) {
        $this->channel = $channel;
    }

    public function setUserName($userName) {
        $this->userName = $userName;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    private function subString($str, $len=0, $suffix='…') {
        $_str = trim($str);

        if($len > 0) {
            $arrStr = preg_split("//u", $_str, -1, PREG_SPLIT_NO_EMPTY);
            $strLen = count($arrStr);

            if ($strLen >= $len) {
                $sliceStr = array_slice($arrStr, 0, $len);
                $str = join('', $sliceStr);

                $_str = $str . ($strLen > $len ? $suffix : '');
            } else {
                $_str = join('', $arrStr);
            }
        }

        return $_str;
    }

    public function setAttachmentsText($text, $len=0) {
        $this->attachmentsText = $this->subString($text, $len);
    }

    public function setAttachmentsTitle($title) {
        $this->attachmentsTitle = $title;
    }

    public function setAttachmentPreText($pretext) {
        $this->attachmentsPreText = $pretext;
    }

    public function setAttachmentsColor($color) {
        $this->attachmentsColor = $color;
    }

    public function setAttachmentsAuthor($author) {
        $this->attachmentsAuthor = $author;
    }

    public function setAttachmentsFields($title, $value, $short = false)
    {
        $this->attachmentsFields[] = array(
            'title' => $title,
            'value' => $value,
            'short' => $short
        );
    }

    public function setAttachmentsFooter($footer) {
        $this->attachmentsFooter = $footer;
    }

    private function setAttachments() {
        $this->attachments[] = array(
            'pretext'     => $this->attachmentsPreText,
            'title'       => $this->attachmentsTitle,
            'author_name' => $this->attachmentsAuthor,
            'text'        => $this->attachmentsText,
            'color'       => $this->attachmentsColor,
            'fields'      => $this->attachmentsFields,
            'footer'      => $this->attachmentsFooter,
            'mrkdwn_in'   => array('text', 'pretext')
        );
    }

    public function setIconEmoji($iconEmoji) {
        $iconEmoji = strip_tags(trim($iconEmoji));

        if($iconEmoji)
            $this->iconEmoji = $iconEmoji;
    }

    public function setIconUrl($iconUrl) {
        $iconUrl = strip_tags(trim($iconUrl));

        if($iconUrl)
            $this->iconUrl = $iconUrl;
    }

    public function send() {
        if($this->webHookUrl) {
            $this->setAttachments();

            $postData = array(
                'channel'     => $this->channel,
                'username'    => $this->userName,
                'icon_emoji'  => $this->iconEmoji,
                'icon_url'    => $this->iconUrl,
                'text'        => $this->message,
                'attachments' => $this->attachments,
                'mrkdwn'      => true,
                'link_names'  => 1
            );

            $ch = curl_init($this->webHookUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS,     'payload='.json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);

            return $result;
        } else {
            return 'WebHook URL Error';
        }
    }
}