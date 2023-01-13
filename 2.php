<?php
$sum = 0;
for ($i=1; $i<=1000; $i++){
    $chars = str_split(strval($i));
    if (count($chars)>=3){
        foreach ($chars as $char){
            if(intval($char)+1==intval(next($chars))){
                if(intval(current($chars))+1==intval(next($chars))){
                    $sum-=$i;
                }
            }
        }
    }
    $sum+=$i;
}
echo "$sum";
