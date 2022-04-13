<?php

/**
 * 単語のリストを表すクラスです。
 */
class WordList
{
    public $wordListAll = ['apple', 'shake', 'clear', 'hello', 'guide'];
}

/**
 * Wordleのルールを表すクラスです
 */
class Wordle
{
    /**
     * 残り解答回数
     */
    public $answerRestCount = 6;

    public function decideTodaysWord($wordList)
    {
        $todaysWord = $wordList[rand(0, count($wordList) - 1)];
        return $todaysWord;
    }

    /**
     * このゲームが終了しているかどうか判定します。
     */
    public function isEnd()
    {
        return $this->answerRestCount === 0;
    }

    /**
     * 解答して、Answerオブジェクトを返します。
     */
    public function answer()
    {
        $this->answerRestCount--;
        return new Answer();
    }
}

/**
 * 標準入力を表すクラス
 */
class StdIn
{
    /**
     * 標準入力から1行入力を受け付けて、入力結果を返します。
     */
    public function readLine()
    {
        $stdinWord = trim(fgets(STDIN));

        return $stdinWord;
    }
}

class Answer {
    /**
     * 正解かどうかを判定します。
     */
    public function isCorrect($words, $answer) {
        if ($words === $answer) {
            return true;
        }
    }

    /**
     * 不正解の場合のヒントを返します。
     */
    public function getHint($wordLine, $answer) {
            echo "ヒント->";
            foreach(str_split($wordLine) as $i => $c) {
            $hint = '';
            if ($answer[$i] === $c) {
                $hint .= '◯ ';
            } else if (strpos($answer, $c) !== false) {
                $hint .= '△ ';
            } else {
                $hint .= '✗ ';
            }
            echo $hint;
        }
        echo PHP_EOL;
    }
}

/**
 * 不正な解答を表す例外クラス。
 */
class InvalidAnswerException extends Exception
{
    public function getErrorMessage() {
    }
}

$wordList = new WordList();
$wordle = new Wordle($wordList->wordListAll);
$todaysWord = $wordle->decideTodaysWord($wordList->wordListAll);//todayswordの作成
$stdin = new StdIn();

while ($wordle->isEnd() === false) {
    echo '単語を入力してください。';
    $line = $stdin->readLine();
    try {
        $answer = $wordle->answer();
        if ($answer->isCorrect($line, $todaysWord)) {
            echo 'おめでとう！';
            break;
        } else {
            $answer->getHint($line, $todaysWord);
            echo "残り".$wordle->answerRestCount."回です".PHP_EOL;
        }
    } catch (InvalidAnswerException $e) {
        echo $e->getErrorMessage($line);
    }
}