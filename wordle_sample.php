<?php

use SebastianBergmann\CodeCoverage\Report\PHP;

$wordlist = ['apple','shake','hello','guide','aiueo','input'];
    $wordindex = rand(0,5);
    $todaysword = $wordlist[$wordindex];
    $todaysword_split = str_split($todaysword);//todayswordを１文字づつ配列で代入=>[a,i,u,e,o]
    const TRY_COUNT = 6;
    
    $count = 0;//実行回数のカウント
    for($i = 1; $i <= TRY_COUNT; $i++){
        $maru_count = 0;
        echo "半角英数字を５文字入力してください->";
        $ans = trim(fgets(STDIN));
        $ans_long = mb_strlen($ans);
        $ans_split = str_split($ans);//ansの中身を配列で代入
        if($ans_long != 5){
            echo "5文字入力してください\n";
            $i--;
            continue;
        }

        echo "ヒント->";
        foreach($ans_split as $key => $tango){//foreachでans_splitの中身を１実行=>１回目$tango=a,２回目$tango=i,３回目$tango=u...
            if($tango == $todaysword_split[$key]){//tangoとtodaystangoが完全に一致していたら〇
                echo "〇 ";
                $maru_count++;
            }else{
                foreach($todaysword_split as $todays_tango){//場所は一致していなくても単語が一致しているかチェック
                    $sankaku = 0;
                    if($tango == $todays_tango){
                        echo "△ ";
                        $sankaku = 1;
                        break;
                    }
                }
                if($sankaku != 1){
                    echo "× ";
                }
            }
        }
        
        if($maru_count == 5){//〇が連続で5個＝すべて文字が一致していたら正解
            echo "\nおめでとう！正解です！\n";
            break;
        }

        echo PHP_EOL;

        $nokori = TRY_COUNT - $i;
        if($nokori != 0){
            echo "残りの入力回数は" .$nokori ."回です\n" .PHP_EOL;
        }else{
            echo "残念はずれです！ちなみに答えは<$todaysword>でした！\n" .PHP_EOL;
        }
    }
    ?>