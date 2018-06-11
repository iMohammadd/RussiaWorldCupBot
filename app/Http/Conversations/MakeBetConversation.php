<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class MakeBetConversation extends Conversation
{

    public function register_profile()
    {
        $user = $this->bot->getUser();
        $this->bot->reply($user);
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
