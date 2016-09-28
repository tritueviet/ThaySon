<?php

header('Content-type:text/html; charset=utf-8');
require_once "/facebook-php-sdk-v4-5.0-dev/src/Facebook/autoload.php";

require_once '/models/users.php';
require_once '/models/groups.php';
require_once '/models/feeds.php';
require_once '/models/members.php';
require_once '/models/status.php';
require_once '/models/comments.php';
require_once '/models/user_group.php';

require_once '/dao/daoUsers.php';
require_once '/dao/daoGroups.php';
require_once '/dao/daoComments.php';
require_once '/dao/daoMembers.php';
require_once '/dao/daoStatus.php';
require_once '/dao/daoFeeds.php';

// khởi tạo 1 session
session_start();

$app_id = '884706364900347';  //localhost
$app_secret = '2af0cda1f97283ae232449fc618ddbb5';
$permissions = ['user_about_me', 'user_actions.books', 'user_actions.fitness', 'user_actions.music', 'user_actions.news', 'user_actions.video', 'user_birthday', 'user_education_history', 'user_events', 'user_friends', 'user_games_activity', 'user_hometown', 'user_likes', 'user_location', 'user_managed_groups', 'user_photos', 'user_posts', 'user_relationship_details', 'user_relationships', 'user_religion_politics', 'user_status', 'user_tagged_places', 'user_videos', 'user_website', 'user_work_history', 'ads_management', 'ads_read', 'email', 'manage_pages', 'publish_actions', 'publish_pages', 'read_custom_friendlists', 'read_insights', 'read_page_mailboxes', 'rsvp_event']; //Permissions required
$redirect_url = 'http://localhost/ThaySon/daofacebook/indexlocal.php'; // Khi đăng nhập xong sẽ tự động chuyển hướng sang trang web này, nếu k điền j thì mặc đinh đường link cài đặt trong app
//require_once __DIR__ . "/facebook-php-sdk-v4-5.0-dev/src/Facebook/autoload.php"; //include autoload from SDK folder
//thêm thư viện

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSDKException;

// khai báo bắt buộc
$fb = new Facebook\Facebook([
    'app_id' => $app_id,
    'app_secret' => $app_secret,
    'default_graph_version' => 'v2.2',
        ]);
$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();
} catch (FacebookRequestException $ex) {
    die(" Error : " . $ex->getMessage()) . '<br>';
} catch (\Exception $ex) {
    die(" Error : " . $ex->getMessage()) . '<br>';
}
// nếu là sự kiện đăng xuất thì xóa session
if (isset($_GET["log-out"]) && $_GET["log-out"] == 1) {
    unset($_SESSION["fb_user_details"]);
    exit(header("location: " . $redirect_url));
}
//  nếu tồn tại accessToken thì thực hiện lệnh
if (isset($accessToken)) {
    $_SESSION['facebook_access_token'] = (string) $accessToken;

    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
//    $db = new DB_CONNECT();
//    $alltables = mysql_query("SHOW TABLES");
//    while ($table = mysql_fetch_assoc($alltables)) {
//        foreach ($table as $db => $tablename) {
//            mysql_query("OPTIMIZE TABLE '" . $tablename . "'")
//                    or die(mysql_error());
//        }
//    }

    $listGroup = getListGroups();
    $size = count($listGroup);
    echo "- Tong so group: " . $size . " <br>";
    for ($iGroup = 0; $iGroup < $size; $iGroup++) {
        $group = new Groups();
        $group = $listGroup[$iGroup];
        echo '<br><br> -->>> Group: ' . $group->getFacebookGroupId() . '<br>';


        echo '<br> -Member:  ' . '<br><br>';
        $membersFacebook = $fb->get('/' . $group->getFacebookGroupId() . '/members?limit=25');
        $nextMem = $membersFacebook->getGraphEdge();
        while ($nextMem != null) {
            foreach ($nextMem as $mem) {
                echo $mem->asArray()['name'] . ' - ' . $mem->asArray()['administrator'] . '<br>';
                $memberAdd = new Members();
                $memberAdd->setFacebookIdMember($mem->asArray()['id']);
                $memberAdd->setAdministrator($mem->asArray()['administrator']);
                $memberAdd->setName($mem->asArray()['name']);
                $memberAdd->setGroupId($group->getGroupId());
                createMembers($memberAdd);
            }
            $nextMem = $fb->next($nextMem);
        }

        echo '<br> -Feeds: <br> ';
        $feedsFacebook = $fb->get('/' . $group->getFacebookGroupId() . '/feed?fields=message,id,updated_time,created_time,from,comments&since='
                .date('Y-m-d', strtotime('-1 day')).'&until='.date('Y-m-d', strtotime('+1 day')));
        $nextFeeds = $feedsFacebook->getGraphEdge();
        while ($nextFeeds != null) {
            //echo "------------------> '.$nextFeeds.'<br><br>';
            $countFeed = $nextFeeds->count();
            //echo '------------------> '.$count;
            for ($i = 0; $i < $countFeed; $i++) {
                echo '<br><br>' . $nextFeeds[$i]->getField("from")->asArray()['name']. ' - - ';
                echo $nextFeeds[$i]->getField("id") . '   - - ' . $nextFeeds[$i]->getField("message") . '<br>';
                $feedAdd = new Feeds();
                $feedAdd->setFacebookIdFeed($nextFeeds[$i]->getField("id"));
                $feedAdd->setMessage($nextFeeds[$i]->getField("message"));

                $feedAdd->setCreateFeedTime($nextFeeds[$i]->getField("created_time")->format('Y-m-d H:i:s O'));
                $feedAdd->setUpdateFeedTime($nextFeeds[$i]->getField("updated_time")->format('Y-m-d H:i:s O'));

                $feedAdd->setGroupId($group->getGroupId());
                $feedAdd->setStatusId(1);
                $feedAdd->setFacebookUserIdFeed($nextFeeds[$i]->getField("from")->asArray()['id']);
                createFeeds($feedAdd);

                if ($nextFeeds[$i]->getField("comments")) {
                    $nextComment = $nextFeeds[$i]['comments'];

                    while ($nextComment != null) {
                        $countComment = $nextComment->count();
                        for ($j = 0; $j < $countComment; $j++) {
                            echo '<br>         ' . $nextComment[$j]->getField("id") . ' - - ' . $nextComment[$j]['created_time']->format('Y-m-d H:i:s O').' - - ';
                            echo $nextComment[$j]->getField("message") . ' - - ' . $nextComment[$j]['from']->getField("name");
                            $commentAdd = new Comments();
                            $commentAdd->setFacebookIdComment($nextComment[$j]->getField("id"));
                            $commentAdd->setMessage($nextComment[$j]->getField("message"));
                            $commentAdd->setCreateCommentTime($nextComment[$j]['created_time']->format('Y-m-d H:i:s O'));
                            $commentAdd->setFacebookUserIdComment($nextComment[$j]['from']->getField("id"));
                            $commentAdd->setFeedId($feedAdd->getFeedId());
                            $commentAdd->setStatusId(1);
                            createComments($commentAdd);
                        }
                        $nextComment = $fb->next($nextComment);
                    }
                }
            }
            $nextFeeds = $fb->next($nextFeeds);
        }
    }
    try {
        $responseUser = $fb->get('/me');
        $userNode = $responseUser->getGraphUser();

//        $responseGroup = $fb->get('/me?fields=groups');
        $responseGroup = $fb->get('/1649687745294539?fields=feed');
        $responseFeed = $fb->get('/me/feed?fields=id,message&limit=5');
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
// When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage() . '<br>';
        exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
// When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage() . '<br>';
        exit;
    }

    //echo 'Logged in as ' . $userNode->getName();
    //echo 'group ' . $responseGroup->getBody();
//    $feedEdge = $responseGroup->getGraphGroup();
//    echo '<br> ---: ' . $feedEdge;
//    echo '<br><br>------------------------------------------<br>  ' . $feedEdge->getProperty("groups")[0]->getProperty("id");
    //$feedEdge = $responseFeed->getGraphEdge();
    //echo '<br> ---------------------------------------------:<br> ' . $feedEdge;
    //echo '<br><br>------------------------------------------<br>  ' . $feedEdge[0]->getProperty("id");
} else {
//  nếu k có accesstoken thì chuyển hướng sang trang đăng nhập
    $loginUrl = $helper->getLoginUrl($redirect_url, $permissions);
    exit(header("location: " . $loginUrl));
//  trước đó có lệnh exit chuyển hướng sang trang đăng nhập, nếu k có lệnh exit kia thì sẽ hiện thẻ <a để chọn nút đăng nhập
    echo '<a href="' . $loginUrl . '">Login with Facebook</a>';
}
?>
