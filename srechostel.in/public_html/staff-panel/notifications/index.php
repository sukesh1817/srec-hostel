<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- displays site properly based on user's device -->

  <link rel="icon" type="image/png" sizes="32x32" href=".//assets/images/favicon-32x32.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Notifications page</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<style>
  .nav-noti {
  font-family: "Poppins", sans-serif !important;
  font-weight: 400 !important;
  font-style: normal !important;
}

</style>
<link rel="stylesheet" href="/css-files/noti.css">

  <!-- Feel free to remove these styles or customise in your own stylesheet 👍 -->
  <style>
    .attribution {
      font-size: 11px;
      text-align: center;
    }

    .attribution a {
      color: hsl(228, 45%, 44%);
    }
  </style>
</head>

<body>
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/staff-template/common-template/navbar.php";

  ?>

  <div class="container font-for-noti">
    <div class="app">
      <div class="header">
        <h2><span class="title">Notifications</span> </h2>
        <!-- <p>Mark all as read</p> -->
      </div>
      <div class="body">

        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/.." . '/composer/vendor/autoload.php'; // include Composer's autoloader
        $client = new MongoDB\Client('mongodb://127.0.0.1:27017/');
        // print_r($client);
        $database = $client->selectDatabase('hostelmanagment');
        // print_r($database);
        
        //create collection if collection is not exists
        try {
          $createCollection = $database->createCollection("c_" . $_SESSION['yourToken']);
        } catch (Exception $e) {

        }

        //current time finder
        $filter = [];
        $options = ['sort' => ['time' => -1], 'limit' => 5];

        $kolkataTimeZone = new DateTimeZone('Asia/Kolkata');
        $dateTimeKolkata = new DateTime('now', $kolkataTimeZone);
        $collection = $database->selectCollection("c_" . $_SESSION['yourToken']);
        $i=1;
        $cursor = $collection->find($filter, $options);
        foreach ($cursor as $d) {
          ?>
          <div id="<?php echo $d['notiId'] ?>" class="posts notification <?php if ($d['checked'] == 1) {
               echo "readed ";
               echo $i;
             } else {
               echo "unreaded ";
               echo $i;
             } ?>">
            <div class="avatar"><img src="/assets/images/avatar-mark-webber.webp"></div>
            <div class="text">
              <div class="text-top">
                <p><span class="profil-name"><?php echo $d['message'] ?><br> <b><?php echo $d['time'] ?></b><?php if ($d['checked'] == 1) {
                         echo "";
                       } else {
                         echo "<span class='unread-dot'></span>";
                       } ?></p>
              </div>
              <div class="text-bottom"> <?php 
              $a=gmdate("H:i:s", time()-$d['timestamp']); 
              $time = explode (":", $a); 
              $h= $time[0]; 
              $m=$time[1];
              $s=$time[2];
              if($h>0){
                if($h>23){
                  $t = $h/24;
                  echo intval($t)." days ago";
                } else {
                  echo intval($h)." hours ago";
                }
              } else if($m>0){
                echo intval($m)." minutes ago";
              } else {
                echo "just now";
              }
              ?></div>
            </div>
          </div>
          <?php
          $i++;
        }

        ?>









        <!-- <div class="notification unreaded">
          <div class="avatar"><img src="/assets/images/avatar-angela-gray.webp"></div>
          <div class="text">
            <div class="text-top">
              <p><span class="profil-name">Home pass booked successfully at </span> <b>2024-06-04 | 07:46:26 AM</b> <span class="unread-dot"></span></p>
            </div>
            <div class="text-bottom"> 5m ago</div>
          </div>
        </div>
        <div class="notification unreaded private-message">
          <div class="avatar"><img src="/assets/images/avatar-jacob-thompson.webp"></div>
          <div class="text">
            <div class="text-top">
              <p><span class="profil-name">Jacob Thompson</span> has joined your group <b class="b-blue">Chess
                  Club</b><span class="unread-dot"></span></p>
            </div>
            <div class="text-bottom"> 1 day ago</div>
          </div>
        </div>
        <div class="notification readed private-message">
          <div class="avatar"><img src="/assets/images/avatar-rizky-hasanuddin.webp"></div>
          <div class="text">
            <div class="text-top">
              <p><span class="profil-name">Rizky Hasanuddin</span> sent you a private message</p>
            </div>
            <div class="text-bottom"> 5 days ago
              <p> Hello, thanks for setting up the Chess Club. I've been a member for a few weeks now and
                I'm already having lots of fun and improving my game.</p>
            </div>
          </div>
        </div>
        <div class="notification readed picture">
          <div class="avatar"><img src="/assets/images/avatar-kimberly-smith.webp"></div>
          <div class="text">
            <div class="text-top">
              <p><span class="profil-name">Kimberly Smith</span> commented on your picture</p>
            </div>
            <div class="text-bottom"> 1 week ago</div>
          </div>
          <div class="commented-picture">
            <img src="/assets/images/image-chess.webp">
          </div>
        </div>
        <div class="notification readed">
          <div class="avatar"><img src="/assets/images/avatar-nathan-peterson.webp"></div>
          <div class="text">
            <div class="text-top">
              <p><span class="profil-name">Nathan Peterson</span> reacted to your recent post <b>5 end-game strategies
                  to increase your win rate</b></p>
            </div>
            <div class="text-bottom"> 2 weeks ago</div>
          </div>
        </div>
        <div class="notification readed">
          <div class="avatar"><img src="/assets/images/avatar-anna-kim.webp"></div>
          <div class="text">
            <div class="text-top">
              <p><span class="profil-name">Anna Kim </span>left the group<b class="b-blue"> Chess Club</b></p>
            </div>
            <div class="text-bottom"> 2 weeks ago</div>
          </div>
        </div> -->
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="/js-files/noti.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</body>

</html>