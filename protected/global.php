<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//return an array of required object data: object_id=>raw data (nested array)
function getBatch($node_type, $node_id, $limit) {//node_type = feed/comments/docs/member
    $facebook = new Facebook(Yii::app()->params["configFB"]);
    //$facebook = FacebookConnect::getInstance(Yii::app()->params["configFB"]);
    $stop = false;
    $graph = $node_id . "/" . $node_type . "?limit=" . $limit;
    $node_array = array();
    set_time_limit(1000000);

    while (!$stop) {

        try {
            $nodes = $facebook->api($graph, 'GET');
        } catch (FacebookApiException $e) {
            die($e->getMessage());
            $nodes = null;
            $stop = true;
        }

        if (!is_null($nodes)) {
            if (isset($nodes["paging"]["next"]))
                $graph = str_replace("https://graph.facebook.com", "", $nodes["paging"]["next"]);
            else {
                $stop = true;
            }

            foreach ($nodes["data"] as $node) {
                $ids = explode("_", $node["id"]);
                $id = end($ids);
                $node_array[$id] = $node;
            }
        }

        usleep(100000);
    }
    return $node_array;
}

//get raw data at initial phase
function get2File() {
    ini_set('memory_limit', '512M');
    //getMembers2File();
    //getDocs2File();
    getFeed2File();
}

//get members to file at intial phase
function getMembers2File() {
    $member_array = getBatch("members", Yii::app()->params["groupID"], 10000);
    //$content["data"] = $member_array;
    print count($member_array);
    print_r($member_array);
    //$facebook = new Facebook(Yii::app()->params["configFB"]);
    foreach ($member_array as $member) {
        //$facebook = FacebookConnect::getInstance(Yii::app()->params["configFB"]);
        //$user_data = $facebook->api("/".$member_id,"GET");
        //usleep(10000);
        //$user_data["administrator"] = $member["administrator"];
        file_put_contents(Yii::app()->basePath . "/data/Facebook/User/" . $member["id"] . ".json", json_encode($member, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}

//get feed to file at intial phase
function getFeed2File() {


    $feed_array = getBatch("feed", Yii::app()->params["groupID"], 500);
    foreach ($feed_array as $feed_id => &$feed) {
        //request to get comment 
        $feed["comments"] = getBatch("comments", $feed_id, 500);
        
        //request to get post likes     
        $feed["likes"] = getBatch("likes", $feed_id, 500);

        //save to file
        file_put_contents(Yii::app()->basePath . "/data/Facebook/Group/feed/" . $feed_id . ".json", json_encode($feed, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}

//get docs to file at inital phase
function getDocs2File() {
    $docs_array = getBatch("docs", Yii::app()->params["groupID"], 500);
    foreach ($docs_array as $docs_id => &$docs) {
        file_put_contents(Yii::app()->basePath . "/data/Facebook/Group/docs/" . $docs_id . ".json", json_encode($docs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}

//save member from file to db at inital phase
function saveMember2DB() {
    $file_array = scandir(Yii::app()->basePath . "/data/Facebook/Group/User/");
    $array = array(".", "..", ".DS_Store");
    $file_array = array_diff($file_array, $array);
    foreach ($file_array as $filename) {
        $content = file_get_contents(Yii::app()->basePath . "/data/Facebook/Group/User/" . $filename);
        $user_data = json_decode($content, true);

        $user = new User();

        $user->sid = $user_data["id"];
        $user->username = $user_data["name"];
        if ($user_data["administrator"])
            $user->type = 1;
        else
            $user->type = 0;
        $user->type = 0;
        $user->gender = $user_data["gender"];
        $user->locale = $user_data["locale"];
        $user->link = $user_data["username"];
        $user->created_time = date("Y:m:d H:m:s");
        $user->updated_time = date("Y:m:d H:m:s");
        $user->save();
    }
}

function saveAll() {
    
}

//save all data from file to db at intial phase
function save2DB($dir_array) {

    foreach ($dir_array as $key => $filename) {
        //usleep(10000);
        //print $key . ":" . memory_get_usage() . "<br>";
        $content = file_get_contents(Yii::app()->basePath . "/data/Facebook/Group/feed/" . $filename);
        $node = json_decode($content, true);
        $user_sid = $node["from"]["id"] + 0;
        $user = User::model()->find("sid=:user_sid", array(":user_sid" => $user_sid));

        if (!isset($user)) {
            //save to tbl_user
            $user = new User();
            $user->sid = $user_sid;
            $user->username = $node["from"]["name"];
            $user->created_time = date("Y-m-d H:m:s");
            $user->updated_time = date("Y-m-d H:m:s");

            if (!$user->save()) {
                print_r($user->getErrors());
            }
        }

        //save to tbl_post
        $post = new Post();
        $post->sid = str_replace(".json", "", $filename) + 0;
        $post->author_sid = $node["from"]["id"] + 0;

        $post->author_id = $user->id;
        if (isset($node["likes"]))
            $post->like_count = count($node["likes"]);

        if (isset($node["message"])) {
            if (strlen($node["message"]) > 100) {
                $post->title = substr($node["message"], 0, 100);
            } else {
                $post->title = $node["message"];
            }
            $post->message = $node["message"];
        } else {
            $post->title = "None"; //implode(' ', array_slice(explode(' ', $node["message"]), 0, 10));
            $post->message = "None";
        }

        $post->last_comment_time = date("Y-m-d H:m:s", strtotime($node["updated_time"]));
        $post->created_time = date("Y-m-d H:m:s", strtotime($node["created_time"]));
        $post->updated_time = $post->created_time;
        if (isset($node["link"]))
            $post->link = $node["link"];
        if (isset($node["picture"]))
            $post->picture = $node["picture"];

        if (!$post->save()) {
            print($post->sid);
            print_r($post->getErrors());
        } else {
            if (isset($node["comments"])) {
                //save to tbl_comment
                foreach ($node["comments"] as $post_comment) {
                    $comment = new Comment();
                    $comment->sid = $post_comment["id"] + 0;
                    $comment->post_id = $post->id;
                    $comment->author_sid = $post_comment["from"]["id"] + 0;
                    $user = User::model()->find("sid=:user_sid", array(":user_sid" => $comment->author_sid));
                    if (!isset($user)) {
                        $user = new User();
                        $user->sid = $comment->author_sid;
                        $user->username = $post_comment["from"]["name"];
                        $user->created_time = date("Y-m-d H:m:s");
                        $user->updated_time = date("Y-m-d H:m:s");
                        if (!$user->save()) {

                            print_r($user->getErrors());
                        }
                    }
                    $comment->author_id = $user->id;
                    $comment->like_count = $post_comment["like_count"] + 0;
                    if (isset($comment["message"]))
                        $comment->message = $post_comment["message"];
                    else
                        $comment->message = "None";
                    $comment->created_time = date("Y-m-d H:m:s", strtotime($post_comment["created_time"]));
                    $comment->updated_time = $comment->created_time;
                    if (!$comment->save()) {
                        print $comment->sid;
                        print_r($comment->getErrors());
                    }
                }
            }
            //save to tbl_likepost
            if (isset($node["likes"])) {
                
                foreach ($node["likes"] as $like) {
                    $likepost = new LikePost();
                    $likepost->post_id = $post->id;
                    print_r($like);
                    
                    $like_count=$like["id"]+0;
                    $user = User::model()->find("sid=:user_sid",array(":user_sid"=>$like_count));
                    if(!isset($user)){
                    
                        $user = new User();
                        $user->sid=$like_count;
                        $user->username =  $like["name"];
                        $user->created_time = date("Y-m-d H:m:s");
                        $user->updated_time = $user->created_time;
                        
                        if(!$user->save()){
                            print_r($user->getErrors());
                        }
                    }
                    $likepost->user_id = $user->id;
                    $likepost->username = $like["name"];
                    if (!$likepost->save())
                        print_r($likepost->getErrors());
                }
            }
        }
    }
}

//update docs to file and run every n minutes
function updateDocs2File() {
    
}

//update members to file and run every n minutes
function updateMembers2File() {
    
}

//update feeds to file and run every n minutes
function updateFeed2File() {
    
}

//update all to file and run every n minutes
function update2File() {
    update2Feed();
    update2Members();
    update2Docs();
}

//update all to db and run every n minutes
function update2DB() {
    
}

?>