<?php


class FacebookCommand extends CConsoleCommand{

	public function actionTry(){
		echo end(explode("_","1234"));
	}

	public function actionInit(){
		ini_set('memory_limit', '512M');
		ini_set('max_execution_time',18000);

		$start = (float) array_sum(explode(' ',microtime()));
		//get cs to file and fb
		
		$this->getDocs();
		
		//get feeds to file
		$this->getFeed2File();
		$this->getFeedLike2File();
		$this->getFeedComment2File();
		

		//get feeds to db
		$this->getFeed2DB();
	
		$end = (float) array_sum(explode(' ',microtime()));
		print "Processing time: ". sprintf("%.4f", ($end-$start))." seconds.\n";


	}

	public function actionUpdate(){
		
		$start = (float) array_sum(explode(' ',microtime()));
		//update docs to file and db
		$this->updateDocs();

		//update feed to file and db
		$this->updateFeed();
		$end = (float) array_sum(explode(' ',microtime()));
		print "Processing time: ". sprintf("%.4f", ($end-$start))." seconds.\n";
	}

	private function getFeedComment2File(){
		$file_array = scandir(dirname(__FILE__)."/../data/Facebook/Group/feed/");
		$file_array = array_diff($file_array, array(".",".."));
		$counter = 0;
		foreach ($file_array as $key=>$filename){

			$content=file_get_contents(dirname(__FILE__)."/../data/Facebook/Group/feed/".$filename);
			$feed = json_decode($content,true);
			$feed_id=str_replace(".json", "", $filename);
			//request to get comment
			
			$feed["comments"]["data"] = $this->getBatch("comments", $feed_id, 500);

			//save to file
			file_put_contents(dirname(__FILE__)."/../data/Facebook/Group/feed/" . $feed_id . ".json", json_encode($feed, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
			echo $feed_id."    ".$counter++."\n";

		}

	}

	private function getFeedLike2File(){
		$file_array = scandir(dirname(__FILE__)."/../data/Facebook/Group/feed/");
		$file_array = array_diff($file_array, array(".",".."));
		$counter = 0;
		foreach ($file_array as $key=>$filename){

			$content=file_get_contents(dirname(__FILE__)."/../data/Facebook/Group/feed/".$filename);
			$feed = json_decode($content,true);
			$feed_id=str_replace(".json", "", $filename);
			//request to get post likes
			
			$feed["likes"]["data"] = $this->getBatch("likes", $feed_id, 500);

			//save to file
			file_put_contents(dirname(__FILE__)."/../data/Facebook/Group/feed/" . $feed_id . ".json", json_encode($feed, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
			echo $feed_id."    ".$counter++."\n";

		}

	}
	//get feed to file at intial phase\
	private function getFeed2File() {


		$fields = array(
            'id',
            'type',
            'object_id,picture,link,source',
            'from',
            'message',
            'created_time',
            'updated_time',
            'comments.limit(1).summary(true),likes.limit(1).summary(true)',
		);
		$feed_array = $this->getBatch("feed", Yii::app()->params["groupID"], 1000,-1,$fields);

		$counter = 0;
		foreach ($feed_array as $feed_id => &$feed) {

			//save to file
			file_put_contents(dirname(__FILE__)."/../data/Facebook/Group/feed/" . $feed_id . ".json", json_encode($feed, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
			echo $feed_id."    ".$counter++."\n";
			//usleep(10000);
		}

	}

	//get docs to file at inital phase
	private function getDocs() {

		$docs_array = $this->getBatch("docs", Yii::app()->params["groupID"], 500);
		foreach ($docs_array as $docs_id => &$docs) {
			//save to tbl_post
			savePost($docs);
			
			file_put_contents(dirname(__FILE__)."/../data/Facebook/Group/docs/" . $docs_id . ".json", json_encode($docs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
		}
	}


	private function getFeed2DB() {

		$file_array = scandir(dirname(__FILE__)."/../data/Facebook/Group/feed/");
		$file_array = array_diff($file_array, array(".",".."));
		foreach ($file_array as $key => $filename) {
			$data=file_get_contents(dirname(__FILE__)."/../data/Facebook/Group/feed/" .$filename);
			$node = json_decode($data, true);
			//save to tbl_post
			$post_id=savePost($node);
			if(isset($post_id)){
				if (isset($node["comments"]["data"])) {

					//save to tbl_comment
					foreach ($node["comments"]["data"] as $comment) {
							
						$comment_id=saveComment($post_id,$comment);
					}
				}
				//save to tbl_likepost
				if (isset($node["likes"]["data"])) {

					foreach ($node["likes"]["data"] as $like) {

						saveLikePost($post_id,$like);
					}
				}
			}
		}
	}


	private function updateDocs() {
		$docs_array=$this->getBatch("docs", Yii::app()->params["groupID"], 10,2);
		foreach ($docs_array as $docs_id => &$docs) {
			echo $docs_id;
			file_put_contents(dirname(__FILE__)."/../data/Facebook/Group/docs/" . $docs_id . ".json", json_encode($docs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
			
			$db_docs=Post::model()->find("sid=:sid",array(":sid"=>$docs["id"]+0));
			if(isset($db_docs))
				$db_docs->delete();
			savePost($docs);			
		}

	}


	//update feeds to file and run every n minutes
	private function updateFeed() {


		$fields = array(
            'id',
            'type',
            'object_id,picture,link,source',
            'from',
            'message',
            'created_time',
            'updated_time',
            'comments.limit(1).summary(true),likes.limit(1).summary(true)',
		);

		$feed_array = $this->getBatch("feed", Yii::app()->params["groupID"],50,2,$fields);

		foreach ($feed_array as $feed_id => &$feed) {

			$db_feed = Post::model()->find('sid=:sid',array(':sid'=>$feed_id));

			//update new comments if it is old post
			if(isset($db_feed)){//old post
				if(timeconvert($db_feed->last_comment_time)<timeconvert($feed["updated_time"])){
					//request to get comment
					$feed["comments"]["data"] = $this->getBatch("comments", $feed_id,500);
					//print $feed_id."\n";

					//update to tbl_comment
					foreach($feed["comments"]["data"] as $comment){
						$comment_id=saveComment($db_feed->id,$comment);
					}
				}
				$post_id=$db_feed->id;

			}else{//new post

				//request to get comment
				$feed["comments"]["data"] = $this->getBatch("comments", $feed_id, 500);


				//update to tbl_post
				$post_id=savePost($feed);

				//update to tbl_comment
				if(isset($feed["comments"]["data"])){
					foreach($feed["comments"]["data"] as $comment){
						$comment_id=saveComment($post_id,$comment);
					}
				}

				//print $feed_id."+\n";

			}

			//request to get post likes
			$feed["likes"]["data"] = $this->getBatch("likes", $feed_id, 500);

			//update to tbl_postlikes
			if (isset($feed["likes"]["data"])) {
				foreach ($feed["likes"]["data"] as $like) {
					$like_id=saveLikePost($post_id,$like);
					print $like_id;
				}
			}

			//save to file
			file_put_contents(dirname(__FILE__)."/../data/Facebook/Group/feed/" . $feed_id . ".json", json_encode($feed, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

			usleep(10000);
		}

	}


	//return an array of required object data: object_id=>raw data (nested array)
	private function getBatch($node_type, $node_id, $limit,$page_limit=-1,$fields=array()) {//node_type = feed/comments/docs/member

		$facebook = new Facebook(Yii::app()->params["configFB"]);

		$stop = false;
		$graph = $node_id . "/" . $node_type . "?limit=" . $limit."&fields=".urlencode(implode(',', $fields));
		$node_array = array();

		while (!$stop) {

			if($page_limit==0){
				$stop=true;
				break;
			}else $page_limit--;

			try {
				$nodes = $facebook->api($graph, 'GET');
			} catch (FacebookApiException $e) {
				echo ($e->getMessage());
					
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







}

?>