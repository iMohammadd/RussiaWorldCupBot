<?php

namespace App\Http\Conversations;

use App\Profile;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;

class MakeBetConversation extends Conversation
{

    public function register_profile()
    {



        $this->ask("hi bro", function (Answer $answer) {
            $user = $this->bot->getUsername();
            $id = $this->bot->getId();
            $this->bot->reply("hi " . $user . " " . $id);
        });
        /*Profile::firstOrCreate([
            'user'  => $user,
            'chat_id'   => $id
        ]);*/

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
