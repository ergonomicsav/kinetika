<?php
class TwitterAPIExchange 
{
    private $oauth_access_token;
    private $oauth_access_token_secret;
    private $consumer_key;
    private $consumer_secret;
    private $postfields;
    private $getfield;
    protected $oauth;
    public $url;

    /**
     * Create the API access object. Requires an array of settings::
     * oauth access token, oauth access token secret, consumer key, consumer secret
     * These are all available by creating your own application on dev.twitter.com
     * Requires the cURL library
     * 
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        if (!in_array('curl', get_loaded_extensions())) 
        {
            throw new Exception('You need to install cURL, see: http://curl.haxx.se/docs/install.html');
        }
        
        if (!isset($settings['oauth_access_token'])
            || !isset($settings['oauth_access_token_secret'])
            || !isset($settings['consumer_key'])
            || !isset($settings['consumer_secret']))
        {
            throw new Exception('Make sure you are passing in the correct parameters');
        }

        $this->oauth_access_token = $settings['oauth_access_token'];
        $this->oauth_access_token_secret = $settings['oauth_access_token_secret'];
        $this->consumer_key = $settings['consumer_key'];
        $this->consumer_secret = $settings['consumer_secret'];
    }
    
    /**
     * Set postfields array, example: array('screen_name' => 'J7mbo')
     * 
     * @param array $array Array of parameters to send to API
     * 
     * @return TwitterAPIExchange Instance of self for method chaining
     */
    public function setPostfields(array $array)
    {
        if (!is_null($this->getGetfield())) 
        { 
            throw new Exception('You can only choose get OR post fields.'); 
        }
        
        if (isset($array['status']) && substr($array['status'], 0, 1) === '@')
        {
            $array['status'] = sprintf(" %s", $array['status']);
        }
        
        $this->postfields = $array;
        
        return $this;
    }
    
    /**
     * Set getfield string, example: '?screen_name=J7mbo'
     * 
     * @param string $string Get key and value pairs as string
     * 
     * @return \TwitterAPIExchange Instance of self for method chaining
     */
    public function setGetfield($string)
    {
        if (!is_null($this->getPostfields())) 
        { 
            throw new Exception('You can only choose get OR post fields.'); 
        }
        
        $search = array('#', ',', '+', ':');
        $replace = array('%23', '%2C', '%2B', '%3A');
        $string = str_replace($search, $replace, $string);  
        
        $this->getfield = $string;
        
        return $this;
    }
    
    /**
     * Get getfield string (simple getter)
     * 
     * @return string $this->getfields
     */
    public function getGetfield()
    {
        return $this->getfield;
    }
    
    /**
     * Get postfields array (simple getter)
     * 
     * @return array $this->postfields
     */
    public function getPostfields()
    {
        return $this->postfields;
    }
    
    /**
     * Build the Oauth object using params set in construct and additionals
     * passed to this method. For v1.1, see: https://dev.twitter.com/docs/api/1.1
     * 
     * @param string $url The API url to use. Example: https://api.twitter.com/1.1/search/tweets.json
     * @param string $requestMethod Either POST or GET
     * @return \TwitterAPIExchange Instance of self for method chaining
     */
    public function buildOauth($url, $requestMethod)
    {
        if (!in_array(strtolower($requestMethod), array('post', 'get')))
        {
            throw new Exception('Request method must be either POST or GET');
        }
        
        $consumer_key = $this->consumer_key;
        $consumer_secret = $this->consumer_secret;
        $oauth_access_token = $this->oauth_access_token;
        $oauth_access_token_secret = $this->oauth_access_token_secret;
        
        $oauth = array( 
            'oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $oauth_access_token,
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        );
        
        $getfield = $this->getGetfield();
        
        if (!is_null($getfield))
        {
            $getfields = str_replace('?', '', explode('&', $getfield));
            foreach ($getfields as $g)
            {
                $split = explode('=', $g);
                $oauth[$split[0]] = $split[1];
            }
        }
        
        $base_info = $this->buildBaseString($url, $requestMethod, $oauth);
        $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;
        
        $this->url = $url;
        $this->oauth = $oauth;
        
        return $this;
    }
    
    /**
     * Perform the acual data retrieval from the API
     * 
     * @param boolean $return If true, returns data.
     * 
     * @return json If $return param is true, returns json data.
     */
    public function performRequest($return = true)
    {
        if (!is_bool($return)) 
        { 
            throw new Exception('performRequest parameter must be true or false'); 
        }
        
        $header = array($this->buildAuthorizationHeader($this->oauth), 'Expect:');
        
        $getfield = $this->getGetfield();
        $postfields = $this->getPostfields();

        $options = array( 
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        );

        if (!is_null($postfields))
        {
            $options[CURLOPT_POSTFIELDS] = $postfields;
        }
        else
        {
            if ($getfield !== '')
            {
                $options[CURLOPT_URL] .= $getfield;
            }
        }

        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $json = curl_exec($feed);
        curl_close($feed);

        if ($return) { return $json; }
    }
    
    /**
     * Private method to generate the base string used by cURL
     * 
     * @param string $baseURI
     * @param string $method
     * @param string $params
     * 
     * @return string Built base string
     */
    private function buildBaseString($baseURI, $method, $params) 
    {
        $return = array();
        ksort($params);
        
        foreach($params as $key=>$value)
        {
            $return[] = "$key=" . $value;
        }
        
        return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $return)); 
    }
    
    /**
     * Private method to generate authorization header used by cURL
     * 
     * @param array $oauth Array of oauth data generated by buildOauth()
     * 
     * @return string $return Header used by cURL for request
     */    
    private function buildAuthorizationHeader($oauth) 
    {
        $return = 'Authorization: OAuth ';
        $values = array();
        
        foreach($oauth as $key => $value)
        {
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        }
        
        $return .= implode(', ', $values);
        return $return;
    }
   
    
}

function objectToArray($d) {
                if (is_object($d)) {
                        // Gets the properties of the given object
                        // with get_object_vars function
                        $d = get_object_vars($d);
                }
 
                if (is_array($d)) {
                        /*
                        * Return array converted to object
                        * Using __FUNCTION__ (Magic constant)
                        * for recursive call
                        */
                        return array_map(__FUNCTION__, $d);
                }
                else {
                        // Return array
                        return $d;
                }
        }

/**
 * Icons Shortcode
 */
function mtheme_latest_tweets ( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'username' => 'twitter',
      'cache_id' => '1',
      'count' => '1'
      ), $atts ) );

    $cache_combo = $cache_id . $username .$count;
    //check if cache needs update
    $mtheme_shortcode_last_cache_time = get_option('mtheme_shortcode_last_cache_time_' . $cache_combo);
    $diff = time() - $mtheme_shortcode_last_cache_time;
    $crt = 24 * 3600;

    // yes, it needs update            
    if($diff >= $crt || empty($mtheme_shortcode_last_cache_time)){

        // Setting our Authentication Variables that we got after creating an application
        $settings = array(
            'oauth_access_token' => "30495696-kAHw8UpFZgh78pQIKHdipr3UcZGkZfj043ZGIKUrb",
            'oauth_access_token_secret' => "eQlT9pstlIfO4Brqwr9jjTMNbN9LafGT4pUIC36mAs",
            'consumer_key' => "PGqIcUVjeWRpoaNx363Qw",
            'consumer_secret' => "ooDTnNeXRC8fTyMDwqPZN9UZwsRYLQm1I4ftgIEz8"
        );

        // We are using GET Method to Fetch the latest tweets.
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

        // Set your screen_name to your twitter screen name. Also set the count to the number of tweets you want to be fetched. Here we are fetching 5 latest tweets.
        $getfield = '?screen_name='.$username.'&count='.$count;
        $requestMethod = 'GET';

        // Making an object to access our library class
        $twitter = new TwitterAPIExchange($settings);
        $store = $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();

    // Since the returned result is in json format, we need to decode it             
      $result = json_decode($store);

        for($i = 0;$i <= count($result); $i++){
            if(!empty($result[$i])){
                $tweets_array[$i]['profile_image_url'] = $result[$i]->user->profile_image_url;
                $tweets_array[$i]['created_at'] = $result[$i]->created_at;
                $tweets_array[$i]['text'] = $result[$i]->text;          
                $tweets_array[$i]['status_id'] = $result[$i]->id_str;
            }   
        }

        //print_r($tweets_array);

        update_option('mtheme_shortcode_tweets_' . $cache_combo , serialize($tweets_array) );                         
        update_option('mtheme_shortcode_last_cache_time_' . $cache_combo , time() );

    }

                    //convert links to clickable format
                        function convert_links($status,$targetBlank=true,$linkMaxLen=250){
                         
                            // the target
                                $target=$targetBlank ? " target=\"_blank\" " : "";
                             
                            // convert link to url
                                $status = preg_replace("/((http:\/\/|https:\/\/)[^ )
]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);
                             
                            // convert @ to follow
                                $status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);
                             
                            // convert # to search
                                $status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);
                             
                            // return the status
                                return $status;
                        }
                    
                    
                    //convert dates to readable format  
                        function relative_time($a) {
                            //get current timestampt
                            $b = strtotime("now"); 
                            //get timestamp when tweet created
                            $c = strtotime($a);
                            //get difference
                            $d = $b - $c;
                            //calculate different time values
                            $minute = 60;
                            $hour = $minute * 60;
                            $day = $hour * 24;
                            $week = $day * 7;
                                
                            if(is_numeric($d) && $d > 0) {
                                //if less then 3 seconds
                                if($d < 3) return "right now";
                                //if less then minute
                                if($d < $minute) return floor($d) . " seconds ago";
                                //if less then 2 minutes
                                if($d < $minute * 2) return "about 1 minute ago";
                                //if less then hour
                                if($d < $hour) return floor($d / $minute) . " minutes ago";
                                //if less then 2 hours
                                if($d < $hour * 2) return "about 1 hour ago";
                                //if less then day
                                if($d < $day) return floor($d / $hour) . " hours ago";
                                //if more then day, but less then 2 days
                                if($d > $day && $d < $day * 2) return "yesterday";
                                //if less then year
                                if($d < $day * 365) return floor($d / $day) . " days ago";
                                //else return more than a year
                                return "over a year ago";
                            }
                        }   
                            
                    
                    $mtheme_shortcode_tweets = maybe_unserialize(get_option('mtheme_shortcode_tweets_' . $cache_combo));
                    if(!empty($mtheme_shortcode_tweets)){
                        //print_r($tp_twitter_plugin_tweets);
                        
                        $tweet_shortcode = '<div class="entry-content mtheme-tweets-shortcode">';
                        $tweet_shortcode .= '<ul class="tweet_list">';
                            $fctr = '1';
                            foreach($mtheme_shortcode_tweets as $tweet){

$tweet_shortcode .= '<li>';
$tweet_shortcode .= '<span class="tweet_avatar"><i class="icon-twitter icon-2x"></i></span>';
$tweet_shortcode .= '<span class="tweet_time">';
$tweet_shortcode .= '<a class="twitter_time" target="_blank" href="http://twitter.com/'.$username.'/statuses/'.$tweet['status_id'].'">'.relative_time($tweet['created_at']).'</a>';
$tweet_shortcode .= '</span>';
$tweet_shortcode .= '<span class="tweet_text">'.convert_links($tweet['text']).'</span>';
$tweet_shortcode .= '</li>';
                                if ( isSet($instance['tweetstoshow']) ) {
                                    if($fctr == $instance['tweetstoshow']){ break; }
                                }
                                $fctr++;
                            }
                        
                        $tweet_shortcode .= '</ul>';
                        $tweet_shortcode .= '</div>';
                    }
                    return $tweet_shortcode;
}
add_shortcode('latest_tweets', 'mtheme_latest_tweets');
?>