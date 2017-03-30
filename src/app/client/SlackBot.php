<?php

namespace app\client;

use Maknz\Slack\Client;

class SlackBot
{

    private $messages = [
        [
            'text' => 'Уволен Прогер Семецкий. Коммиты в мастер.',
            'count' => 0
        ],
        [
            'text' => 'Уволен Прогер Семецкий. Не соблюдал СОЛИД.',
            'count' => 0
        ],
        [
            'text' => 'Уволен Прогер Семецкий. Регулярно нарушал НДА.',
            'count' => 0
        ],
        [
            'text' => 'Уволен Прогер Семецкий. Попал начальнику под горячую руку. Хороший был прогер.',
            'count' => 0
        ],
        [
            'text' => 'Уволен Прогер Семецкий. Мешал JS, HTML, CSS, PHP в одном файле.',
            'count' => 0
        ],
    ];
    private $client;

    public function __construct()
    {
        $this->client = new Client(config('slack_web_hook'));
        $this->client->send('Hello world!');
    }

    public function getMessage()
    {
        /*
         * уже хочу спать. Думать лень, а результат хочу(((
         * И вообще єто метод надо в документ поместить, а не в бота. Блин(
         * А нет. В бота. Документ должен возвращать массив с каунтерами, а 
         * бот должен решать что взять
         */

        $commonMessageKey = '';
        $lessCounter = 1000000000000000;
        $messages = $this->shuffleMessages($this->messages);

        foreach ($messages as $key => $message) {
            if ($message['count'] <= $lessCounter) {
                $lessCounter = $message['count'];
                $commonMessageKey = $key;
            }
        }
        $this->messages[$commonMessageKey]['count'] ++;

        return $this->messages[$commonMessageKey]['text'];
    }

    public function sendMessage($message)
    {
        $this->client->send($message);
    }

    private function shuffleMessages($messages)
    {
        $keys = array_keys($messages);
        shuffle($keys);
        $shuffledMessages = array_combine($keys, $messages);

        return $shuffledMessages;
    }

}
