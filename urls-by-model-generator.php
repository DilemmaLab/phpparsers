<?php
/**
 * Created by PhpStorm.
 * User: chirkina
 * Date: 12/25/15
 * Time: 4:00 PM
 */

// Generator of Urls
// Example of usage: bash~: $ php task-dm999-generator.php land-rover 'defender' 1 2014 2014

#Generator of URLs
function urlgenerator($site, $argvar=array()){

    if ($site == 'auto.ru') {
        $_c = count($argvar);
        for ($_i = $_c; $_i < 6; $_i+=1)
            array_push($argvar, '');

        $mark = 'land-rover';
        $model = '';//'jaguar';
        $cartype = array('all', 'used', 'new'); // [0] [1] [2]
        $ict = 2;#0;
        $year_min = '2014';$year_max = '2015';
        // /*

        if ($argvar[1])
            $mark = $argvar[1];//'mazda';#'cadillac';

        if ($argvar[2])
            $model = $argvar[2];//'6';#'cts';


        if ($argvar[3])
            $ict = $argvar[3];// Id of Car Type // == 2 for new, 1 for used, 0 for all


        if($argvar[4])
            $year_min = $argvar[4];


        if($argvar[5])
            $year_max = $argvar[5];
        // */

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

        $url =
            "http://auto.ru/cars/{$url_part}/?sort[create_date]=desc&" .
            "output_type=list&" .
            "search[section_id]=&" .
            "search[mark][0]=&" .
            "search[mark-folder][0]=&" .
            "search[salon_id]=&" .
            "search[year][min]=&" .$year_min.
            "search[year][max]=&" .$year_max.
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

        //$content = file_get_contents($url);
        $i = 1; //Page number
        $carfile = fopen(__DIR__ . "/user_urls.dat", "w");// "w+");

        echo $url, "\n";
            fwrite($carfile, $url);
            fwrite($carfile, "\n");

        $content = file_get_contents($url."&p={$i}");
        while ( $content != FALSE ) {

            /* Если использовали эмуляцию Браузера, иначе - закомментировать! */
            /*$match = array();
            preg_match('#<title>Ошибка 404! Страница не найдена. - AUTO.RU</title>#', $content, $match);//<h2>Ошибка 404</h2><p>Неправильно набран адрес - Только если браузер ЭМИТИРОВАЛИ! Иначе - закомментировать
            if (count($match))
                break;*/
            /* */

            echo $url."&p={$i}", "\n";
            fwrite($carfile, $url."&p={$i}");
            fwrite($carfile, "\n");
            //

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
        fclose($carfile);

    }
    //pass; // auto.ru ENDED

    if ($site == 'avito.ru') {
        $_c = count($argvar);
        for ($_i = $_c; $_i < 6; $_i+=1)
            array_push($argvar, '');

        $mark = '/land_rover';
        $model = '';//'jaguar';
        $cartype = array('', '/s_probegom', '/novyy'); // [0] [1] [2]
        $ict = 2;#0;
        $year_min = '11017'; // 2014; 2014 - 11017, 2015 - 13978, 2016 - 16381
        $year_max = '13978'; // 2015; 2014 - 11017, 2015 - 13978, 2016 - 16381

        $years = array(
            "2014" => "11017",
            "2015" => "13978",
            "2016" => "16381",
        );
        // /*

        if ($argvar[1])
            $mark = "/".$argvar[1];//'mazda';#'cadillac';
            $mark = preg_replace("#-#","_",$mark);

        if ($argvar[2])
            $model = "/".$argvar[2];//'6';#'cts';

        if ($argvar[3])
            $ict = $argvar[3];// Id of Car Type // == 2 for new, 1 for used, 0 for all

        if($argvar[4])
            $year_min = $years[$argvar[4]];

        if($argvar[5])
            $year_max = $years[$argvar[5]];
        // */

        // $url_part = "{$mark}/{$model}/{$cartype[$ict]}" || "{$mark}/{$model}/all" ||
        //             "{$mark}//{$cartype[$ict]}"         ||    "{$mark}/all" ||
        //             "{$cartype[$ict]}"                  ||       "all"

        $url = "https://www.avito.ru/rossiya/avtomobili{$cartype[$ict]}{$mark}{$model}?bt=0&f=188_{$year_min}b{$year_max}";

        //$content = file_get_contents($url);
        $i = 1; //Page number
        $carfile = fopen(__DIR__ . "/user_urls_avito.dat", "w");// "w+");

        echo $url, "\n";
            fwrite($carfile, $url);
            fwrite($carfile, "\n");

        $url_parts = array();
        $url_parts = explode("?bt=0",$url);
        $content = file_get_contents($url_parts[0]."?p={$i}&bt=0".$url_parts[1]);
        while ( $content != FALSE ) {

            /* Если использовали эмуляцию Браузера, иначе - закомментировать! */
            /*$match = array();
            preg_match('#<title>Ошибка 404! Страница не найдена. - AUTO.RU</title>#', $content, $match);//<h2>Ошибка 404</h2><p>Неправильно набран адрес - Только если браузер ЭМИТИРОВАЛИ! Иначе - закомментировать
            if (count($match))
                break;*/
            /* */

            $content = file_get_contents($url_parts[0]."?p={$i}&bt=0".$url_parts[1]);
            echo $url_parts[0]."?p={$i}&bt=0".$url_parts[1], "\n";
            fwrite($carfile, $url_parts[0]."?p={$i}&bt=0".$url_parts[1]);
            fwrite($carfile, "\n");
            //

            $i++;

            // Имитируем задержку
            $time = mt_rand(1, 5000); // stats_cdf_poisson();
            sleep($time/1000);

            /*global $user_agent, $ua;
            ini_set('user_agent', $user_agent[$ua]); // Эмуляция браузера*/
            $content = file_get_contents($url_parts[0]."?p={$i}&bt=0".$url_parts[1]);
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
        fclose($carfile);

    }
    //pass; // avito.ru ENDED

    if ($site == 'mail.ru') {
        $_c = count($argvar);
        for ($_i = $_c; $_i < 6; $_i+=1)
            array_push($argvar, '');

        $mark = 'land_rover/';
        $model = '';//'jaguar';
        $cartype = array('all','used','new','certified'); // [0] [1] [2] [3]
        $ict = 2;#0;
        $year_min = '2014';$year_max = '2015';
        // /*

        if ($argvar[1])
            $mark = $argvar[1].'/';//'mazda';#'cadillac';
            $mark = preg_replace("#-#","_",$mark);

        if ($argvar[2])
            $model = $argvar[2].'/';//'6';#'cts';

        if ($argvar[3])
            $ict = $argvar[3];// Id of Car Type // == 2 for new, 1 for used, 0 for all

        if($argvar[4])
            $year_min = $argvar[4];

        if($argvar[5])
            $year_max = $argvar[5];

        $url = "https://cars.mail.ru/sale/ru/{$cartype[$ict]}/{$mark}{$model}?year={$year_min}-{$year_max}";
        //$content = file_get_contents($url);
        $i = 1; //Page number
        $carfile = fopen(__DIR__ . "/user_urls_mail.dat", "w");// "w+");

        echo $url, "\n";
            fwrite($carfile, $url);
            fwrite($carfile, "\n");

        $content = file_get_contents($url."&page={$i}");
        while ( $content != FALSE ) {
            /* Если использовали эмуляцию Браузера, иначе - закомментировать! */
            /*$match = array();
            preg_match('#<title>Ошибка 404! Страница не найдена. - AUTO.RU</title>#', $content, $match);//<h2>Ошибка 404</h2><p>Неправильно набран адрес - Только если браузер ЭМИТИРОВАЛИ! Иначе - закомментировать
            if (count($match))
                break;*/
            /* */

            echo $url."&page={$i}", "\n";
            fwrite($carfile, $url."&page={$i}");
            fwrite($carfile, "\n");
            //

            $i++;

            // Имитируем задержку
            $time = mt_rand(1, 5000); // stats_cdf_poisson();
            sleep($time/1000);

            /*global $user_agent, $ua;
            ini_set('user_agent', $user_agent[$ua]); // Эмуляция браузера*/
            $content = file_get_contents($url."&page={$i}");
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
        fclose($carfile);

    }
}
if (! $argv)
    $argv = array();
#urlgenerator($site, $argv);
urlgenerator('auto.ru', $argv);
urlgenerator('mail.ru', $argv);
urlgenerator('avito.ru', $argv);

?>