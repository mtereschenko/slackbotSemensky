<?php

namespace app\client;

use Maknz\Slack\Client;

class SlackBot
{
    private $client;
    const BOT_CONFIG = [
        'username' => 'ZONA.TECH',
        //just lazy to store it in repo
        'icon' => 'http://vignette2.wikia.nocookie.net/stalker/images/b/b4/Y_68641107.jpg/revision/latest?cb=20151015023343&path-prefix=ru',
    ];

    public function __construct()
    {
        $this->client = new Client(config('slackWebHook'), self::BOT_CONFIG);
    }

    /** 
     * Select one message of all
     * @param array $messages
     * @return string message text
     */
    public function selectOneMessage($messages)
    {
        /*
         * уже хочу спать. Думать лень, а результат хочу(((
         * И вообще єто метод надо в документ поместить, а не в бота. Блин(
         * А нет. В бота. Документ должен возвращать массив с каунтерами, а
         * бот должен решать что взять
         */

        $suffledMessages = $this->shuffleMessages($messages);
        $messageKey = rand(0, count($suffledMessages));
        list($text, $count) = $suffledMessages[$messageKey];

        return $text;
    }

    /** 
     * Send message to slack
     * @param string $message
     */
    public function sendMessage($message)
    {
        $this->client->send($message);
    }

    /** 
     * Here we have to shuffle all incoming messages
     * account the frequency
     * @param array $messages
     * @return array
     */
    private function shuffleMessages($messages)
    {
        /* 
         * todo Начу учитывать частоту выпадания сообщений
         * с учетом поступления новых сообщений
         */
        $keys = array_keys($messages);
        shuffle($keys);
        $shuffledMessages = array_combine($keys, $messages);

        return $shuffledMessages;
    }
}
