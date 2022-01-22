<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $quizzes = Quiz::all();
        return $quizzes;
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
        $quiz_label = $request->label;

        $quiz = new Quiz;
        $quiz->label = $quiz_label;
        $quiz->published = $request->published;
        $quiz->save();

        foreach ($request->questions as $question) {
         
            $question1 = new Question;
            $question1->label = $question['label'];
            $question1->answer = 0;
            $question1->quiz_id = $quiz->id;
            $question1->earnings = $question['earnings'];
            $question1->save();

            $right_answer = 0;

            foreach( $question['choices'] as $choice ) {
                $choice1 = new Choice;
                $choice1->label = $choice['label'];
                $choice1->question_id = $question1->id;
                $choice1->save();
                if ($choice['id'] == $question['answer']) {
                    $right_answer = $choice1->id;
                }
            }

            $question2 = Question::find($question1->id);
            $question2->answer = $right_answer;
            $question2->save();
        }
    
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
        return Quiz::find($id);
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
        $quiz = Quiz::find($id);
        $quiz->published = false;
        $quiz->label = $request->label;
        $quiz->save();

        $allQuestionsInBack = Question::query()
        ->where('quiz_id', 'LIKE', "%{$quiz->id}%")
        ->get();

        foreach ($allQuestionsInBack as $questionInBack) {
            $deleteQuestion = false;
            foreach ($request->questions as $question) {
                $deleteQuestion = true;
            }
            if ($deleteQuestion) {
                $questionInBack->delete();
            }
        }

        foreach ($request->questions as $question) {
            $questionToFind = Question::find($question['id']);
            $right_answer = 0;
            if (!$questionToFind) {
                $question1 = new Question;
                $question1->quiz_id = $quiz->id;
                $question1->label = $question['label'];
                $question1->answer = $right_answer;
                $question1->earnings = $question['earnings'];
                $question1->save();
            } else {
                $question1 = Question::find($question['id']);
                $right_answer = $questionToFind->answer;
                $question1->quiz_id = $quiz->id;
                $question1->label = $question['label'];
                $question1->answer = $right_answer;
                $question1->earnings = $question['earnings'];
                $question1->save();
            }

            $question_id = $question1->id;
            $allChoicesInBack = Choice::query()
            ->where('question_id', 'LIKE', "%{$question_id}%")
            ->get();

            foreach ($allChoicesInBack as $choiceInBack) {
                $deleteChoice = false;
                foreach ($question['choices'] as $choice) {
                    $deleteChoice = true;
                }
                if ($deleteChoice) {
                    $choiceInBack->delete();
                }
            }

            foreach ($question['choices'] as $choice) {
                $choiceToFind = Choice::find($choice['id']);
                if (!$choiceToFind) {
                    $choice1 = new Choice;
                    $choice1->label = $choice['label'];
                    $choice1->question_id = $question1->id;
                    $choice1->save();
                } else {
                    $choice1 = Choice::find($choice['id']);
                    $choice1->label = $choice['label'];
                    $choice1->question_id = $question1->id;
                    $choice1->save();
                }

                if ($choice['id'] == $question['answer']) {
                    $right_answer = $choice1->id;
                }
            }

            if ($question1->answer != $right_answer) {
                $question1->answer = $right_answer;
                $question1->save();
            }
        }
    }

    public function publish($id)
    {
        //
        $quiz = Quiz::find($id);
        $quiz->published = true;
        $quiz->save();
    }

    public function unpublish($id)
    {
        //
        $quiz = Quiz::find($id);
        $quiz->published = false;
        $quiz->save();
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
        Quiz::find($id)->delete();
    }
}
