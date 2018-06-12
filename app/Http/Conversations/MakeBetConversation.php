<?php

namespace App\Http\Conversations;

use App\Match;
use App\Profile;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class MakeBetConversation extends Conversation
{

    public $name, $user, $id;
    public $profile;
    public $matches, $match_id;
    
    public $teams;
    public $result_one, $result_two;

    public function register_profile()
    {




            
            return $this->askMatch();

    }

    public function askMatch()
    {
        //$this->name = $this->bot->getUser()->getFirstName();
        //$this->user = $this->bot->getUser()->getUsername();
        //$this->id = $this->bot->getUser()->getId();

        /*$this->profile = Profile::firstOrCreate([
            'name'  => $this->name,
            'user'  => $this->user,
            'chat_id'   => $this->id
        ]);*/

        $this->say($this->bot->getUser());

        $matchs = Match::all();

        foreach ($matchs as $match) {
            $this->matches[] = Button::create("$match->team_one - $match->team_two")->value($match->id);
        }
        
        $question = Question::create("Select a Match")
            ->fallback("we have an error :(")
            ->callbackId("ask_match")
            ->addButtons([
                $this->matches
            ]);
        
        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->teams[] = explode(" - ", $answer->getText());
                $this->match_id = $answer->getValue();

                $this->askResultOne();
            }
        });
    }

    public function askResultOne()
    {
        return $this->ask("Number of $this->teams[0] Goal?", function (Answer $result_one)
        {
            $this->result_one = $result_one->getText();
            
            $this->askResultTwo();
        });
    }

    public function askResultTwo()
    {
        return $this->ask("Number of $this->teams[1] Goal?", function (Answer $result_two)
        {
            $this->result_two = $result_two->getText();

            $this->submitBet();
        });
    }

    public function submitBet()
    {
        $this->profile->bet->create([
            'match_id'  =>  $this->match_id,
            'result_one'    =>  $this->result_one,
            'result_two'    =>  $this->result_two
        ]);

        return $this->say("Thanks, you can Make bet again with /Start");
    }
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        return $this->askMatch();
    }
}
