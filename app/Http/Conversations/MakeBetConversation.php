<?php

namespace App\Http\Conversations;

use App\Bet;
use App\Match;
use App\Profile;
use App\Team;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Carbon\Carbon;

class MakeBetConversation extends Conversation
{

    public $name, $user, $id;
    public $profile;
    public $matches = [], $match;
    
    public $teams = [];
    public $result_one, $result_two;

    public $keyboard = [
        ['1', '2', '3'],
        ['4', '5', '6'],
        ['7', '8', '9'],
        ['0']
    ];

    public function init()
    {
        $this->name = $this->bot->getUser()->getFirstName();
        $this->user = "none";
        $this->id = $this->bot->getUser()->getId();


        try {
            $this->profile = Profile::whereChatId($this->id)->firstOrFail();
        } catch (\Exception $e) {
            $this->profile = Profile::Create([
                'name'  => $this->name,
                'user'  => $this->user,
                'chat_id'   => $this->id
            ]);
        }
        return $this->askMatch();
    }

    public function askMatch()
    {
        $matchs = [];
        foreach (Match::all() as $item) {
            if (strtotime($item->start_at . " " . $item->time) >= strtotime(Carbon::now()->toDateTimeString()) ) {
                $matchs[] = $item;
            }
        }


        foreach ($matchs as $match) {
            $this->matches[] = Button::create(Team::findOrFail($match->team_one)->name . " - " . Team::findOrFail($match->team_two)->name)->value($match->id);
        }
        
        $question = Question::create("یه مسابقه انتخاب کن")
            ->fallback("we have an error :(")
            ->callbackId("ask_match")
            ->addButtons($this->matches);
        
        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {

                $this->match = Match::findOrFail($answer->getValue());
                $this->teams[0] = Team::findOrFail($this->match->team_one)->name;
                $this->teams[1] = Team::findOrFail($this->match->team_two)->name;


                $this->askResultOne();
            }
        });
    }

    public function askResultOne()
    {
        return $this->ask("بنظرت " . $this->teams[0] . " چندتا گل میزنه؟", function (Answer $result_one)
        {
            $this->result_one = $result_one->getText();
            
            $this->askResultTwo();
        }, [
            'reply_markup' => json_encode([
                'keyboard' => $this->keyboard,
                'one_time_keyboard' => true,
                'resize_keyboard' => true
            ])
        ]);
    }

    public function askResultTwo()
    {
        return $this->ask($this->teams[1] . " چطور؟", function (Answer $result_two)
        {
            $this->result_two = $result_two->getText();

            $this->submitBet();
        }, [
            'reply_markup' => json_encode([
                'keyboard' => $this->keyboard,
                'one_time_keyboard' => true,
                'resize_keyboard' => true
            ])
        ]);
    }

    public function submitBet()
    {
        Bet::create([
            'profile_id'   =>  $this->profile->id,
            'match_id'  =>  $this->match->id,
            'result_one'    =>  $this->result_one,
            'result_two'    =>  $this->result_two
        ]);

        return $this->say("ثبت شد، با /start بازم شرکت کن");
    }
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        return $this->init();
    }
}
