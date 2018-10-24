<?php

// DB 연결
function sql_connect_flower($host, $user, $pass, $db=FLOWER_MYSQL_DB)
{
    global $flower;

    if(function_exists('mysqli_connect') && FLOWER_MYSQLI_USE) {
        $link = mysqli_connect($host, $user, $pass, $db);

        // 연결 오류 발생 시 스크립트 종료
        if (mysqli_connect_errno()) {
            die('Connect Error: '.mysqli_connect_error());
        }
    } else {
        $link = mysql_connect($host, $user, $pass);
    }

    return $link;
}

// DB 선택
function sql_select_db_flower($db, $connect)
{
    global $flower;

    if(function_exists('mysqli_select_db') && FLOWER_MYSQLI_USE)
        return @mysqli_select_db($connect, $db);
    else
        return @mysql_select_db($db, $connect);
}


function sql_set_charset_flower($charset, $link=null)
{
    global $flower;

    if(!$link)
        $link = $flower['connect_db'];

    if(function_exists('mysqli_set_charset') && FLOWER_MYSQLI_USE)
        mysqli_set_charset($link, $charset);
    else
        mysql_query(" set names {$charset} ", $link);
}

// mysqli_query 와 mysqli_error 를 한꺼번에 처리
// mysql connect resource 지정 - 명랑폐인님 제안
function sql_query_flower($sql, $error=G5_DISPLAY_SQL_ERROR, $link=null)
{
    global $flower;

    if(!$link)
        $link = $flower['connect_db'];

    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    // union의 사용을 허락하지 않습니다.
    //$sql = preg_replace("#^select.*from.*union.*#i", "select 1", $sql);
    $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql);
    // `information_schema` DB로의 접근을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);

    if(function_exists('mysqli_query') && FLOWER_MYSQLI_USE) {
        if ($error) {
            $result = @mysqli_query($link, $sql) or die("<p>$sql<p>" . mysqli_errno($link) . " : " .  mysqli_error($link) . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysqli_query($link, $sql);
        }
    } else {
        if ($error) {
            $result = @mysql_query($sql, $link) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysql_query($sql, $link);
        }
    }

    return $result;
}

// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
function sql_fetch_flower($sql, $error=G5_DISPLAY_SQL_ERROR, $link=null)
{
    global $flower;

    if(!$link)
        $link = $flower['connect_db'];

    $result = sql_query_flower($sql, $error, $link);
    //$row = @sql_fetch_array($result) or die("<p>$sql<p>" . mysqli_errno() . " : " .  mysqli_error() . "<p>error file : $_SERVER['SCRIPT_NAME']");
    $row = sql_fetch_array_flower($result);
    return $row;
}

// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_array_flower($result)
{
    if(function_exists('mysqli_fetch_assoc') && FLOWER_MYSQLI_USE)
        $row = @mysqli_fetch_assoc($result);
    else
        $row = @mysql_fetch_assoc($result);

    return $row;
}
?>