<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {



        // Remember to copy files from the SDK's src/ directory to a
        // directory in your application on the server, such as php-sdk/


        $config = Yii::app()->params["configFB"];
        $facebook = new Facebook($config);
        $user_id = $facebook->getUser();


        if ($user_id) {


            // We have a user ID, so probably a logged in user.
            // If not, we'll get an exception, which we handle below.



            try {

                $access_token = $facebook->getAccessToken();
                $facebook->setAccessToken($access_token);
                $user_profile = $facebook->api('/me', 'GET');
                
                print_r(json_encode($user_profile));
                file_put_contents(Yii::app()->basePath . "/data/Facebook/User/" . $user_id, json_encode($user_profile));
                #$profile = file_get_contents(Yii::app()->basePath . "/data/Facebook/");
                $user = new User();
                $exist = $user->find("sid=:sid", array(":sid" => $user_id));
                if (!$exist) {
                    $user->username = $user_profile["name"];
                    $user->password = null;
                    $user->sid=$user_profile["id"];
                    $user->phone=$user_profile["phone"];
                    $user->email=$user_profile["email"];
                    $user->gener=$user_profile["gender"];
                    $user->about_you=$user_profile[""];
                    $user->language="vi";
                    $user->jlpt=null;
                    $user->like=0;
                    $user->dislike=0;
                    $user->level=0;
                    $user->quotation=$user_profile["quotes"];
                    $user->profile_image=$user_profile[""];
                    $user->mask_name=$user_profile["name"];
                    $user->birthday = $user_profile["birthday"];
                    $user->hometown=$user_profile["hometown"]["name"];
                    $user->living=$user_profile["location"]["name"];
                    $user->type=0;
                    $user->created_time=date("Y:m:d H:m:s");
                    $user->updated_time=date("Y:m:d H:m:s");
                    
                    $user->save();
                         
                }


                /*
                  $img = file_get_contents('https://graph.facebook.com/'.$fid.'/picture?type=large');
                  $file = dirname(__file__).'/avatar/'.$fid.'.jpg';
                  file_put_contents($file, $img);

                  <img src="https://graph.facebook.com/<?= $fid ?>/picture">


                  <img src="https://graph.facebook.com/<?= $fid ?>/picture?type=large">
                 */
            } catch (FacebookApiException $e) {
                // If the user is logged out, you can have a 
                // user ID even though the access token is invalid.
                // In this case, we'll get an exception, so we'll
                // just ask the user to login again here.
                $login_url = $facebook->getLoginUrl();
                echo 'Please <a href="' . $login_url . '">login.</a>';
                error_log($e->getType());
                error_log($e->getMessage());
            }
        } else {

            // No user, print a link for the user to login
            $login_url = $facebook->getLoginUrl();
            echo 'Please <a href="' . $login_url . '">login.</a>';
        }

        // display the login form
        $this->render('login', array("user_id" => $user_id, "facebook" => $facebook));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}