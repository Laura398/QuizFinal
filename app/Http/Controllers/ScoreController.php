<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user_id = Auth::id();
        if ($user_id == 1) {
            $scores = Score::all();
            return $scores;
        } else {
            $scores = Score::query()
            ->where('user_id', 'LIKE', "%{$user_id}%")
            ->get();
            return $scores;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $quiz = Quiz::find($request->quiz_id);
        $score = new Score;
        $score->quiz_id = $quiz->id;
        $score->user_id = Auth::id();

        $finalScore = 0;
        $totalEarnings = 0;

        foreach( $request->answers as $answer ) {
            $question_id = $answer['question_id'];
            $question = Question::find($question_id);
            if ($question->answer == $answer['answer']) {
                $finalScore += $question->earnings;
            }
            $totalEarnings += $question->earnings;
        }

        $score->score = $finalScore/$totalEarnings*100;
        $score->save();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Score::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
