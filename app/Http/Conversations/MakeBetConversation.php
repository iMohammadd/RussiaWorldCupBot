<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;

class MakeBetConversation extends Conversation
{

    public function register_profile()
    {
        $user = $this->bot->getUser();
        return $this->ask('how are u?', function (Answer $answer) {
            $this->bot->reply( $answer->getText());
        });

    }
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->register_profile();
    }
}
