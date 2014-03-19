<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FacebookConnect
 *
 * @author sasaki
 */
class FacebookConnect{
    //put your code here
    private static $_facebook;
    
    private function __construct($config){
        self::$_facebook =  new Facebook($config);
        
    }
    
    public static function getInstance($config){
        if(!self::$_facebook){
            self::$_facebook=new FacebookConnect($config);
        }
        return self::$_facebook;
    }
   
}

?>
