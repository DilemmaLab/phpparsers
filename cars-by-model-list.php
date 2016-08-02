<?php
// Parser auto.ru - list of cars advs
// Example of usage: bash~: $ php task-dm979.php cadillac cts 0

$mark = $argv[1];//'mazda';#'cadillac';
$model = $argv[2];//'6';#'cts';
$cartype = array('all','used','new'); // [0] [1] [2]
$ict = $argv[3];// Id of Car Type // == 2 for new, 1 for used, 0 for all

// $url_part = "{$mark}/{$model}/{$cartype[$ict]}" || "{$mark}/{$model}/all" ||
//             "{$mark}//{$cartype[$ict]}"         ||    "{$mark}/all" ||
//             "{$cartype[$ict]}"                  ||       "all"
$url_part = '';
if ($mark) {
    $url_part = "{$mark}/";
    if ($model)
        $url_part = $url_part . $model . "/";
}
$url_part = $url_part . $cartype[$ict];

/*
$url =
    "http://auto.ru/cars/{$mark}/".$model."/{$cartype[$ict]}/?sort[create_date]=desc&" .
 */
$url =
    "http://auto.ru/cars/{$url_part}/?sort[create_date]=desc&" .
    "output_type=list&" .
    "search[section_id]=&" .
    "search[mark][0]=&" .
    "search[mark-folder][0]=&" .
    "search[salon_id]=&" .
    "search[year][min]=&" .
    "search[year][max]=&" .
    "search[price][min]=&" .
    "search[price][max]=&" .
    "search[engine_volume][min]=&" .
    "search[engine_volume][max]=&" .
    "search[engine_power][min]=&" .
    "search[engine_power][max]=&" .
    "search[acceleration][min]=&" .
    "search[acceleration][max]=&" .
    "search[geo_region]=&" .
    "search[geo_city]=&" .
    "search[geo_country]=&" .
    "search[geo_similar_cities]=&" .
    "search[period]=0&" .
    "show_sales=1";

/* For Browser Emulation */
$user_agent = array('Mozilla/5.0 (iPad; U; CPU OS 3_2_1 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Mobile/7B405',
    'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-GB; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3',
    'Opera/9.80 (X11; Linux i686; Ubuntu/14.10) Presto/2.12.388 Version/12.16',
    'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:41.0) Gecko/20100101 Firefox/41.0',
    'Mozilla/5.0 (Windows NT 6.0; rv:2.0) Gecko/20100101 Firefox/4.0 Opera 12.14',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.94 Safari/537.36',
    'Opera/9.80 (X11; Linux x86_64; Edition Linux Mint) Presto/2.12.388 Version/12.16',
    'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko',
    'Mozilla/5.0 (compatible, MSIE 11, Windows NT 6.3; Trident/7.0;  rv:11.0) like Gecko',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.1 Safari/537.36',
    'Mozilla/5.0 (X11; OpenBSD i386) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36'); //Mozilla/5.0 (Windows Phone 10.0; Android <Android Version>; <Device Manufacturer>; <Device Model>) AppleWebKit/<WebKit Rev> (KHTML, like Gecko) Chrome/<Chrome Rev> Mobile Safari/<WebKit Rev> Edge/<EdgeHTML Rev>.<Windows Build>

// рандомизировать микросекундами
function make_seed()
{
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
}
srand(make_seed());
$ua = mt_rand(0,10);
//ini_set('user_agent', $user_agent[$ua]); // Эмуляция браузера
/* End For Browser Emulation */


function parser($url, $mark, $model, $cartype, $ict)
{
    $content = file_get_contents($url);

    /*
     if ($content != FALSE) {
        preg_match('#<title>Ошибка 404! Страница не найдена. - AUTO.RU</title>#', $content, $match);
    }
    */

    $i = 1; //Page number
    $carfile = fopen(__DIR__ . "/urlout-{$mark}-{$model}-{$cartype[$ict]}.dat", "w"); //Erase File
    fclose($carfile); //Erase File
    while ( $content != FALSE ) {

        /* Если использовали эмуляцию Браузера, иначе - закомментировать! */
        /*$match = array();
        preg_match('#<title>Ошибка 404! Страница не найдена. - AUTO.RU</title>#', $content, $match);//<h2>Ошибка 404</h2><p>Неправильно набран адрес - Только если браузер ЭМИТИРОВАЛИ! Иначе - закомментировать
        if (count($match))
            break;*/
        /* */

        preg_match_all('#href="//auto.ru/cars/' . $cartype[$ict] . '/sale/(.*?)/">#', $content, $matches, PREG_SET_ORDER);

        $old_idcutter = '';
        $carfile = fopen(__DIR__ . "/urlout-{$mark}-{$model}-{$cartype[$ict]}.dat", "a+");// "w+");
        foreach ($matches as $key1 => $key2) {
            $idcutter = $key2[1];
            if ($old_idcutter == $idcutter)
                continue;
            $old_idcutter = $idcutter;
            $url_clear = "http://auto.ru/cars/{$mark}/" . $model . "/{$cartype[$ict]}/sale/" . $idcutter;
            echo $url_clear, "\n";
            fwrite($carfile, $url_clear);
            fwrite($carfile, "\n");
        }
        fclose($carfile);

        $i++;

        // Имитируем задержку
        $time = mt_rand(1, 5000); // stats_cdf_poisson();
        sleep($time/1000);

        /*global $user_agent, $ua;
        ini_set('user_agent', $user_agent[$ua]); // Эмуляция браузера*/
        $content = file_get_contents($url."&p={$i}");
        /* Если использовали эмуляцию Браузера, иначе - закомментировать! */
        /*if ($content != FALSE) {
            $match = ''; // (?)
            preg_match('#<title>Ошибка 404! Страница не найдена. - AUTO.RU</title>#', $content, $match);
            if (count($match))
                echo "\n",$match,"\n";
                break;
        }*/
        /* */
    }

    return $content;

};

function jsoner($url, $mark, $model, $cartype, $ict){
    // Creating jss-files of mark, model, price, year, ...

}

/*
if (! $ict){
    parser($url, $mark, $model, $cartype, 1);
    parser($url, $mark, $model, $cartype, 2);
    shell_exec("cat urlout-{$mark}-{$model}-used.dat urlout-{$mark}-{$model}-new.dat > urlout-{$mark}-{$model}-all.dat ; rm urlout-{$mark}-{$model}-new.dat urlout-{$mark}-{$model}-used.dat");
}
else
    parser($url, $mark, $model, $cartype, $ict);*/

echo $url, "\n";

?>