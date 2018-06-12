<?php

namespace App\Http\Conversations;

use App\Match;
use App\Profile;
use App\Team;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class MakeBetConversation extends Conversation
{

    public $name, $user, $id;
    public $profile;
    public $matches = [], $match_id;
    
    public $teams = [];
    public $result_one, $result_two;

    public function register_profile()
    {




            
            return $this->askMatch();

    }

    public function askMatch()
    {
        $this->name = $this->bot->getUser()->getFirstName();
        $this->user = "none";
        $this->id = $this->bot->getUser()->getId();

        /*$this->profile = Profile::firstOrCreate([
            'name'  => $this->name,
            'user'  => $this->user,
            'chat_id'   => $this->id
        ]);*/


        $matchs = Match::all();

        foreach ($matchs as $match) {
            $this->matches[] = Button::create(Team::findOrFail($match->team_one) . " - " . Team::findOrFail($match->team_two))->value($match->id);
        }
        
        $question = Question::create("یه مسابقه انتخاب کن")
            ->fallback("we have an error :(")
            ->callbackId("ask_match")
            ->addButtons($this->matches);
        
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
        return $this->ask("پیش‌بینی میکنی  $this->teams[0] چنتا گل بزنه?", function (Answer $result_one)
        {
            $this->result_one = $result_one->getText();
            
            $this->askResultTwo();
        });
    }

    public function askResultTwo()
    {
        return $this->ask("$this->teams[1] چطور؟", function (Answer $result_two)
        {
            $this->result_two = $result_two->getText();

            $this->submitBet();
        });
    }

    public function submitBet()
    {
        /*$this->profile->bet->create([
            'match_id'  =>  $this->match_id,
            'result_one'    =>  $this->result_one,
            'result_two'    =>  $this->result_two
        ]);*/

        return $this->say("ثبت شد، با /Start بازم شرکت کن");
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
