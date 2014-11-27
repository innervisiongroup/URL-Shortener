<?php

use Way\Validators\ValidationException;
use Way\Exceptions\NonExistentHashException;

class LinksController extends BaseController {

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('links.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        try
        {
            $hash = Little::make(Input::get('url'));
        }

        catch (ValidationException $e)
        {
            return Redirect::home()->withErrors($e->getErrors())->withInput();
        }

        if (Input::has('_token')) {
            $words = $this->extractCommonWords(Input::get('url'));
            return Redirect::home()->with([
                'flash_message' => 'Here you go! ' . link_to($hash),
                'hashed'        => $hash,
                'tags'          => $words
            ]);
        }
        else { // API
            if (Input::get('format') == 'json' OR !Input::has('format')) {
                return json_encode(URL::to($hash));
            }
        }
    }
    

    /**
     * Accept hash, and fetch url
     *
     * @param $hash
     *
     * @return mixed
     */
    public function processHash($hash)
    {
        try
        {
            $url = Little::getUrlByHash($hash);

            return Redirect::to($url);
        }

        catch (NonExistentHashException $e)
        {
            return Redirect::home()->with('flash_message', 'Sorry - could not find your desired URL.');
        }
    }


    private function extractCommonWords($url){
        $ch = curl_init();
 
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);
     
        $data = curl_exec($ch);
        curl_close($ch);
     
        $html = $data;

        $string = strip_tags($html);

        $stopWords = array('sont', 'dans', 'pour', 'i','a','about','an','and','are','as','at','be','by','com','de','en','for','from','how','in','is','it','la','of','on','or','that','the','this','to','was','what','when','where','who','will','with','und','the','www');
   
        $string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
        $string = trim($string); // trim the string
        $string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too...
        $string = strtolower($string); // make it lowercase
   
        preg_match_all('/\b.*?\b/i', $string, $matchWords);
        $matchWords = $matchWords[0];
      
        foreach ( $matchWords as $key=>$item ) {
            if ( $item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 ) {
                unset($matchWords[$key]);
            }
        }   
        $wordCountArr = array();
        if ( is_array($matchWords) ) {
            foreach ( $matchWords as $key => $val ) {
                $val = strtolower($val);
                if ( isset($wordCountArr[$val]) ) {
                    $wordCountArr[$val]++;
                } else {
                    $wordCountArr[$val] = 1;
                }
            }
        }
        arsort($wordCountArr);
        $wordCountArr = array_slice($wordCountArr, 0, 10);
        return $wordCountArr;
    }

}
