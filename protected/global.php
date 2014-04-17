<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function timeconvert($str_time){

	return date("Y-m-d H:i:s",  strtotime($str_time));
}

function saveLikePost($post_id,$like){
	$likepost = new LikePost();
	$likepost->post_id = $post_id;

	$user_sid=$like["id"]+0;
	$user = User::model()->find("sid=:user_sid",array(":user_sid"=>$user_sid));
	if(!isset($user)){

		$user = new User();
		$user->sid=$user_sid;
		$user->username =  $like["name"];
		$user->created_time = date("Y-m-d H:i:s");
		$user->updated_time = $user->created_time;

		if(!$user->save()){
			print_r($user->getErrors());
		}
	}
	$likepost->user_id = $user->id;
	$likepost->username = $like["name"];
	$likepost->created_time = date("Y-m-d H:i:s");
	$likepost->updated_time = $likepost->created_time;
	if (!$likepost->save()){
		print_r($likepost->getErrors());
		return false;
	}else return $likepost->id;
}


function saveComment($post_id,$post_comment) {
	$comment = new Comment();
	if(isset($post_comment["id"]))
	$comment->sid = $post_comment["id"] + 0;
	else print_r($post_comment);
	$comment->post_id = $post_id;
	$comment->author_sid = $post_comment["from"]["id"] + 0;
	$user = User::model()->find("sid=:user_sid", array(":user_sid" => $comment->author_sid));

	if (!isset($user)) {
		$user = new User();
		$user->sid = $comment->author_sid;
		$user->username = $post_comment["from"]["name"];
		$user->created_time = date("Y-m-d H:i:s");
		$user->updated_time = date("Y-m-d H:i:s");
		if (!$user->save()) {
			print_r($user->getErrors());
		}
	}
	$comment->author_id = $user->id;
	$comment->like_count = $post_comment["like_count"] + 0;
	if (isset($post_comment["message"]))
	$comment->message = $post_comment["message"];
	else $comment->message = "None";
	$comment->created_time = date("Y-m-d H:i:s", strtotime($post_comment["created_time"]));
	$comment->updated_time = $comment->created_time;
	if (!$comment->save()) {

		print_r($comment->getErrors());
		return false;
	}
	return $comment->id;
}

function savePost($node){
	if(isset($node["from"])){
		$user_sid = $node["from"]["id"] + 0;
		$user = User::model()->find("sid=:user_sid", array(":user_sid" => $user_sid));

		if (!isset($user)) {
			//save to tbl_user
			$user = new User();
			$user->sid = $user_sid;
			$user->username = $node["from"]["name"];
			$user->created_time = date("Y-m-d H:i:s");
			$user->updated_time = date("Y-m-d H:i:s");

			if (!$user->save()) {
				print_r($user->getErrors());
			}
		}
	}

	//save to tbl_post
	$post = new Post();
	$post->sid = end(explode("_",$node["id"])) + 0;
	if(isset($user_sid)){
		$post->author_sid = $user_sid;
		$post->author_id = $user->id;
	}
	
	
	if (isset($node["likes"]["data"]))
	$post->like_count = count($node["likes"]["data"]);

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

	if(isset($node["subject"])){
		$post->title = $node["subject"];
		$post->type = 1;
	}


	$post->last_comment_time = date("Y-m-d H:i:s", strtotime($node["updated_time"]));
	$post->created_time = date("Y-m-d H:i:s", strtotime($node["created_time"]));
	$post->updated_time = $post->created_time;
	if (isset($node["link"]))
	$post->link = $node["link"];
	if (isset($node["picture"]))
	$post->picture = $node["picture"];

	if (!$post->save()) {
		print($post->sid);
		print_r($post->getErrors());
		return false;

	}else return $post->id;
}


/*
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
 $user->created_time = date("Y:m:d H:i:s");
 $user->updated_time = date("Y:m:d H:i:s");
 $user->save();
 }
 }*/
/*
			$user_sid = $docs["from"]["id"] + 0;	
			$user = User::model()->find("sid=:user_sid", array(":user_sid" => $user_sid));

			if (!isset($user)) {
				//save to tbl_user
				$user = new User();
				$user->sid = $user_sid;
				$user->username = $docs["from"]["name"];
				$user->created_time = date("Y-m-d H:i:s");
				$user->updated_time = date("Y-m-d H:i:s");

				if (!$user->save()) {
					print_r($user->getErrors());
				}
			}

			//save to tbl_post
			$post = new Post();
			$post->sid = $docs["id"] + 0;
			$post->author_sid = $docs["from"]["id"] + 0;

			$post->author_id = $user->id;
			

			$post->title = $docs["subject"];
			$post->message=$docs["message"];
				
				
			$post->created_time = date("Y-m-d H:i:s", strtotime($docs["created_time"]));
			$post->updated_time = date("Y-m-d H:i:s", strtotime($docs["updated_time"]));
			$post->last_comment_time = $post->updated_time;
			if (isset($docs["link"]))
			$post->link = $docs["link"];
			if (isset($docs["picture"]))
			$post->picture = $docs["picture"];

			if (!$post->save()) {
				print($post->sid);
				print_r($post->getErrors());
				return false;

			}else return $post->id;
			*/	
?>