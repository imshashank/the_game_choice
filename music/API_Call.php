<?php

class API_Call {

        public function getGenres() {
            $Beats_Key = 'e3yekz3nrbv7pwhfyd2nd8fc';
            $type = 'genre';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 2,
                CURLOPT_URL => 'https://partner.api.beatsmusic.com/v1/api/genres?client_id='.$Beats_Key
            ));

            $result = curl_exec($curl);
            curl_close($curl);
            $result = strstr($result,"{");
            $json =  json_decode($result, true);
            $output = array();
            // filter the results to only show the name of the genres
            for ($i = 0; $i < $json['info']['count']; $i++) {
                $tempStr = $json['data'][$i]['name'];
                $output[$i] = substr($tempStr, 6);
            }
            $post_data = json_encode(array('genres' => $output), JSON_FORCE_OBJECT);
           # echo "</br>";
           # echo $post_data;
            var_dump($post_data);
            return $post_data;
        }

        public function getArtists($genre) {
            $key = 'FRK9EWQRQHV80DW4S';
            $url = 'http://developer.echonest.com/api/v4/genre/artists?api_key='.$key.'&format=json&name='.$genre;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 2,
                CURLOPT_URL => $url
            ));

            $result = curl_exec($curl);
            $json =  json_decode($result, true);
            $output = array();
            for ($i=0; $i < count($json['response']['artists']); $i++) {
                $output[$i] = $json['response']['artists'][$i]['name'];
                echo $output[$i];
                echo "</br>";
            }
            $post_data = json_encode(array('artists' => $output), JSON_FORCE_OBJECT);
            curl_close($curl);
            var_dump($output);
            return $post_data;
        }

        public function getArtistImage($artist) {
            $key = 'FRK9EWQRQHV80DW4S';
            $url = 'http://developer.echonest.com/api/v4/artist/images?api_key='.$key.'&name='.$artist.'&format=json&license=echo-source';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 2,
                CURLOPT_URL => $url
            ));
            $result = curl_exec($curl);
            echo $result;
            $json =  json_decode($result, true);
            $output = array();
            for ($i = 0; $i < count($json['response']['images']); $i++){
                $output[$i] = $json['response']['images'][$i]['url'];
            }
            $post_data = json_encode(array('images' => $output), JSON_FORCE_OBJECT);
            curl_close($curl);
            //var_dump($output);
            return $post_data;
        }
        /*
            return a json object of songs given an artist
        */
        public function getSongs($artist) {
            $artist =  rawurlencode($artist);
            $key = 'FRK9EWQRQHV80DW4S';
            $url = 'http://developer.echonest.com/api/v4/song/search?api_key='.$key.'&format=json&artist='.$artist.'&results=100&sort=song_hotttnesss-desc';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 2,
                CURLOPT_URL => $url
            ));
            $result = curl_exec($curl);
            $json =  json_decode($result, true);
            $output = array();
            for ($i = 0; $i < count($json['response']['songs']); $i++) {
                $compare = strtolower($json['response']['songs'][$i]['title']);
                if (!in_array($compare, $output)) {
                    $output[$i] = $compare;
                    echo $output[$i];
                    echo "</br>";
                }
            }
            $post_data = json_encode(array('songs' => $output), JSON_FORCE_OBJECT);
            curl_close($curl);
            return $post_data;
        }

        public function getPreview($trackName) {
            $trackName = rawurlencode($trackName);
            //echo $trackName;
            //$url = 'https://api.spotify.com/v1/search?query='.$trackName.'&offset=0&limit=20&type=track';
            $url = 'https://api.spotify.com/v1/search?q='.$trackName.'&limit=10&type=track';
            //echo $url;

            $ch = curl_init($url);
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => 2,
                CURLOPT_URL => $url,
                CURLOPT_SSL_VERIFYPEER => false
            ));

            $result = curl_exec($ch);
            //var_dump($result); // view results
            $json =  json_decode($result, true);
            $output = array();
            for ($i = 0; $i < count($json['tracks']['items']); $i++) {
                $currentUrl = $json['tracks']['items'][$i]['preview_url'];
                $output[$i] = $currentUrl;
                echo $output[$i];
                echo "</br>";
            }
            $post_data = json_encode(array('previews' => $output), JSON_FORCE_OBJECT);
            return $post_data;
        }
    }
    // check $_POST varialbe
    $obj = new API_Call();
    // if ( $_GET=['types']){
    // $genres = $obj->getGenres();
    // #var_dump($genres);
    // $genres=json_decode($genres);
    // foreach ($genres as $x => $y){
    // $result['categories'][]=$y;
    // #var_dump($result);
    //
    // }
    //  $result['title'][]='';
    //     echo json_encode($result);
    // }


    $obj->getGenres();
    $obj->getArtists('rock');
    //$obj->getPreview('i remember');
    if (array_key_exists('artist',$_POST)) {
        $obj -> getArtists($_POST['artist']);
    }
    if (array_key_exists('tracks',$_POST)) {
        $obj -> getSongs($_POST['tracks']);
    }

?>
