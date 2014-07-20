<?php
class Application {

	private $db;

	public $debug = true;
	private $prefix;

	public function __construct($db) {
		global $table_prefix;
		$this->db     = $db;
		$this->prefix = $table_prefix;

		$this->db->query("CREATE TABLE IF NOT EXISTS `".$this->prefix."__users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `email` varchar(70) DEFAULT NULL,
          `oauth_uid` varchar(200) NOT NULL DEFAULT '',
          `oauth_provider` varchar(200) DEFAULT NULL,
          `username` varchar(100) DEFAULT NULL,
          `gender` varchar(100) DEFAULT NULL,
          `twitter_oauth_token` varchar(200) DEFAULT NULL,
          `twitter_oauth_token_secret` varchar(200) DEFAULT NULL,
          `facebook_acces_token` varchar(255) DEFAULT NULL,
          `access_token` text,
          `img` varchar(255) DEFAULT NULL,
          `link` varchar(255) DEFAULT NULL,
          `isFan` varchar(255) DEFAULT false,

          `shared` varchar(255) DEFAULT false,
          `invited` varchar(255) DEFAULT false,
          `agreed` varchar(255) DEFAULT false,
          `banned` varchar(255) DEFAULT false,
          `totalscore` int(10) DEFAULT '0',
          `playcount` varchar(255) DEFAULT false,
          `ip` varchar(255) DEFAULT false,

          PRIMARY KEY (`id`,`oauth_uid`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8");

		$this->db->query("CREATE TABLE IF NOT EXISTS `".$this->prefix."__registration` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `vards` varchar(250) NOT NULL DEFAULT '',
                `uzvards` varchar(250) NOT NULL DEFAULT '',
                `ceka_nr` varchar(250) NOT NULL DEFAULT '',
                `epasts` varchar(250) NOT NULL DEFAULT '',
                `talrunis` varchar(250) NOT NULL DEFAULT '',
                `vecums` varchar(250) NOT NULL DEFAULT '',
                `spam` int(1) DEFAULT '0',
                `ip` varchar(250) NOT NULL DEFAULT '',
                `winner` int(1) DEFAULT '0',
                `winning_date` timestamp NULL DEFAULT NULL,
                `date` timestamp NOT NULL default CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`,`winner`)
              ) ENGINE=MyISAM DEFAULT CHARSET=utf8");

		//       $this->db->query("CREATE TABLE IF NOT EXISTS `" . $this->prefix . "__banned` (
		//   `uid` int(20) NOT NULL,
		//   `ip` varchar(255) DEFAULT false,
		//   PRIMARY KEY (`uid`)
		// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

	}

	public function report($dumper) {
		if ($debug) {
			var_dump($dumper);
		}
	}

	//==========================================================================================
	//                                    REGISTER  &  WINNERS
	//==========================================================================================
	public function registerUser($vards, $uzvards, $ceka_nr, $epasts, $talrunis, $vecums, $spam = null) {

		$vards    = mysqli_real_escape_string($this->db->link, $vards);
		$uzvards  = mysqli_real_escape_string($this->db->link, $uzvards);
		$ceka_nr  = mysqli_real_escape_string($this->db->link, $ceka_nr);
		$epasts   = mysqli_real_escape_string($this->db->link, $epasts);
		$talrunis = mysqli_real_escape_string($this->db->link, $talrunis);
		$vecums   = mysqli_real_escape_string($this->db->link, $vecums);
		$spam     = mysqli_real_escape_string($this->db->link, $spam);

		$ip = mysqli_real_escape_string($this->db->link, getIP());

		$sql = "SELECT * FROM ".$this->prefix."__registration WHERE ceka_nr= '$ceka_nr' ";
		$this->db->query($sql) or die(mysqli_error($this->db->link));
		$r = $this->db->fetch();

		if (!empty($r)) {
			return false;
		} else {
			$q = array("vards" => $vards, "uzvards" => $uzvards, "ceka_nr" => $ceka_nr, "epasts" => $epasts, "talrunis" => $talrunis, "vecums" => $vecums, "spam" => $spam, "ip" => $ip, "winner" => 0, "winning_date" => NULL);
			$this->db->insert($this->prefix."__registration", $q);
			$id = $this->db->lastId();
			return $id;
		}

	}
	public function updateWinners($from, $to, $count) {
		// parbaudam vai shaja nedelja nav jau uzvaretaju

		// $query = "UPDATE ".$this->prefix."__registration SET winner = 1  WHERE winner!=1 AND date BETWEEN '".$from." 00:00:00' AND '".$to." 23:59:59' GROUP BY talrunis, epasts ORDER BY RAND() LIMIT 10 ";

		$skaits = $this->checkWinners($from, $to);
		// echo "skaits ".$skaits;

		if ($skaits > 0) {
			// jau ir izlozeti neko nedaram
			return false;
			break;
		} else {
			// selektejam random updeitam
			$select = $this->selectWinners($from, $to, $count);
			// apdeitojam selektetos

			for ($i = 0; $i < count($select); $i++) {

				if ($i == count($select)-1) {
					$upd .= "`id`=".$select[$i]["id"];
				} else {
					$upd .= "`id`=".$select[$i]["id"]." OR ";
				}

			}

			$query = "UPDATE ".$this->prefix."__registration SET winner = 1, winning_date = CURRENT_TIMESTAMP  WHERE ".$upd;
			$this->db->query($query);

			return $select;
			break;

		}

	}
	public function checkWinners($from, $to) {
		$sql = "SELECT count(*) FROM ".$this->prefix."__registration WHERE winner=1 AND date BETWEEN '".$from." 00:00:00' AND '".$to." 23:59:59'  GROUP BY talrunis, epasts";
		$this->db->query($sql);
		$r = $this->db->fetch();

		return $r;

	}

	public function selectWinners($from, $to, $count) {

		$sql = "SELECT * FROM ".$this->prefix."__registration WHERE winner!=1 AND date BETWEEN '".$from." 00:00:00' AND '".$to." 23:59:59'  GROUP BY talrunis ORDER BY RAND() LIMIT ".$count." ";
		$this->db->query($sql);
		$data = array();
		while ($row = $this->db->fetch()) {
			array_push($data, $row);
		}
		return $data;

	}

	public function getWinners($from, $to, $count) {

		$sql = "SELECT * FROM ".$this->prefix."__registration WHERE winner=1 AND date BETWEEN '".$from." 00:00:00' AND '".$to." 23:59:59' ORDER BY winning_date ASC LIMIT ".$count." ";
		$this->db->query($sql);
		$data = array();
		while ($row = $this->db->fetch()) {
			array_push($data, $row);
		}
		return $data;

	}

	//==========================================================================================
	//                                      INSERTION
	//==========================================================================================

	public function insertNewUser($oauth_uid, $oauth_provider, $username, $email, $gender = null, $twitter_oauth_token = null, $twitter_oauth_token_secret = null, $facebook_acces_token = null, $access_token = null, $img = null, $link = null, $fan = null) {

		$oauth_uid                  = mysqli_real_escape_string($this->db->link, $oauth_uid);
		$oauth_provider             = mysqli_real_escape_string($this->db->link, $oauth_provider);
		$username                   = mysqli_real_escape_string($this->db->link, $username);
		$email                      = mysqli_real_escape_string($this->db->link, $email);
		$gender                     = mysqli_real_escape_string($this->db->link, $gender);
		$twitter_oauth_token        = mysqli_real_escape_string($this->db->link, $twitter_oauth_token);
		$twitter_oauth_token_secret = mysqli_real_escape_string($this->db->link, $twitter_oauth_token_secret);
		$facebook_acces_token       = mysqli_real_escape_string($this->db->link, $facebook_acces_token);
		$access_token               = mysqli_real_escape_string($this->db->link, $access_token);
		$img                        = mysqli_real_escape_string($this->db->link, $img);
		$link                       = mysqli_real_escape_string($this->db->link, $link);
		$fan                        = mysqli_real_escape_string($this->db->link, $fan);
		$ip                         = mysqli_real_escape_string($this->db->link, getIP());

		$q = array("oauth_provider" => $oauth_provider, "oauth_uid" => $oauth_uid, "username" => $username, "email" => $email, "gender" => $gender, "twitter_oauth_token" => $twitter_oauth_token, "twitter_oauth_token_secret" => $twitter_oauth_token_secret, "facebook_acces_token" => $facebook_acces_token, "access_token" => $access_token, "img" => $img, "link" => $link, "isFan" => $fan, "ip" => $ip);

		$this->db->insert($this->prefix."__users", $q);
		$id = $this->db->lastId();

		// $image = file_get_contents('https://graph.facebook.com/'.$oauth_uid.'/picture?width=1000&height=1000'); // sets $image to the contents of the url
		//       $image_sm = file_get_contents('https://graph.facebook.com/'.$oauth_uid.'/picture?width=90&height=90');
		//       file_put_contents('users/'.$id.'___'.$oauth_uid.'.jpg', $image);
		//       file_put_contents('users/'.$id.'___'.$oauth_uid.'_sm.jpg', $image_sm);
		//
		return $id;
	}

	public function insertScore($id, $oauth_provider, $oauth_uid, $score) {
		$id        = mysqli_real_escape_string($this->db->link, $id);
		$oauth_uid = mysqli_real_escape_string($this->db->link, $oauth_uid);

		$oauth_provider = mysqli_real_escape_string($this->db->link, $oauth_provider);
		$score          = mysqli_real_escape_string($this->db->link, $score);
		$ip             = mysqli_real_escape_string($this->db->link, getIP());

		$q = array("uid" => $id, "oauth_uid" => $oauth_uid, "score" => $score, "ip" => $ip);

		$this->db->insert($this->prefix."__games", $q);
		$last_id = $this->db->lastId();

		// $this->checkScore($id);

		return $this->checkScore($id);
	}

	public function inviteFriend($oauth_uid, $friend_uid, $request) {

		$oauth_uid  = mysqli_real_escape_string($this->db->link, $oauth_uid);
		$friend_uid = mysqli_real_escape_string($this->db->link, $friend_uid);
		$q          = array("oauth_uid" => $oauth_uid, "friend_uid" => $friend_uid, "request" => $request);

		// parbaudam vai jau nav tadu draugu tas cilveks aicinajis
		$sql = "SELECT * FROM ".$this->prefix."__invites WHERE oauth_uid = '$oauth_uid' and friend_uid = '$friend_uid'";
		$this->db->query($sql) or die(mysqli_error($this->db->link));
		$r = $this->db->fetch();

		if (!empty($r)) {

			// nav tuksh, saskaitam cik
			$sql_c = "SELECT count(*) as count FROM ".$this->prefix."__invites WHERE oauth_uid = '$oauth_uid' ";
			$this->db->query($sql_c) or die(mysqli_error($this->db->link));
			$r_c = $this->db->fetch();

			$count = $r_c["count"];
		} else {

			// insert new
			$this->db->insert($this->prefix."__invites", $q);
			$id = $this->db->lastId();

			$sql_c = "SELECT count(*) as count FROM ".$this->prefix."__invites WHERE oauth_uid = '$oauth_uid' ";
			$this->db->query($sql_c) or die(mysqli_error($this->db->link));
			$r_c = $this->db->fetch();

			$count = $this->updateInvites($oauth_uid, $r_c["count"]);
		}

		return $count;
	}

	public function inDb($id) {

		$sql = "SELECT * FROM ".$this->prefix."__users WHERE id = '$id'";
		$this->db->query($sql) or die(mysqli_error($this->db->link));
		$r = $this->db->fetch();

		if (!empty($r)) {

			// User is already present
			return true;
		} else {
			return false;
		}
	}

	public function checkUser($id, $uid, $oauth_provider, $username, $email, $gender = null, $twitter_oauth_token = null, $twitter_oauth_token_secret = null, $facebook_acces_token = null, $access_token = null, $img = null, $link = null, $fan = null) {

		if ($oauth_provider == "email") {
			$sql = "SELECT * FROM ".$this->prefix."__users WHERE email = '$email' and oauth_provider = '$oauth_provider'";
			$this->db->query($sql) or die(mysqli_error($this->db->link));
			$r = $this->db->fetch();
		} else {
			$sql = "SELECT * FROM ".$this->prefix."__users WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'";
			$this->db->query($sql) or die(mysqli_error($this->db->link));
			$r = $this->db->fetch();
		}

		if (!empty($r)) {

			// User is already present
			// apdeitojam facebook_acces_token

			if ($oauth_provider == "facebook") {

				// $this->updateAcces_token($uid,$facebook_acces_token);
				$this->updateIsFan($uid, $fan);
			} else if ($oauth_provider == "email") {
				$this->updateUsername($id, $username);
			} else {

				//twitter
				// $this->updateAcces_token_tw($uid,$twitter_oauth_token,$twitter_oauth_token_secret,$access_token);

			}
		} else {

			//user not present. Insert a new Record
			if ($uid || $email) {
				$oauth_provider             = mysqli_real_escape_string($this->db->link, $oauth_provider);
				$uid                        = mysqli_real_escape_string($this->db->link, $uid);
				$username                   = mysqli_real_escape_string($this->db->link, $username);
				$email                      = mysqli_real_escape_string($this->db->link, $email);
				$twitter_oauth_token        = mysqli_real_escape_string($this->db->link, $twitter_oauth_token);
				$twitter_oauth_token_secret = mysqli_real_escape_string($this->db->link, $twitter_oauth_token_secret);
				$facebook_acces_token       = mysqli_real_escape_string($this->db->link, $facebook_acces_token);
				$access_token               = mysqli_real_escape_string($this->db->link, $access_token);
				$img                        = mysqli_real_escape_string($this->db->link, $img);
				$gender                     = mysqli_real_escape_string($this->db->link, $gender);
				$link                       = mysqli_real_escape_string($this->db->link, $link);
				$fan                        = mysqli_real_escape_string($this->db->link, $fan);

				$id = $this->insertNewUser($uid, $oauth_provider, $username, $email, $gender, $twitter_oauth_token, $twitter_oauth_token_secret, $facebook_acces_token, $access_token, $img, $link, $fan);

				$r = $this->getUser($id);

				// $r = $this->getUserUID($uid);
				return $r;
			} else {
				return null;
			}
		}
		return $r;
	}

	//==========================================================================================
	//                                          UPDATES
	//==========================================================================================

	public function updateAgreed($uid, $agreed) {
		$q = array("agreed" => $agreed);

		// var_dump( $uid."/".$agreed);
		$r = $this->db->update($this->prefix."__users", $q, "oauth_uid", $uid) or die(mysqli_error($this->db->link));

		return $r;
	}

	public function updateInvites($uid, $count) {

		// UPDATE CATEGORY
		// SET count = count + 1
		// WHERE category_id = ?

		$q = array("invited" => $count);

		// var_dump( $uid."/".$agreed);
		$r = $this->db->update($this->prefix."__users", $q, "oauth_uid", $uid) or die(mysqli_error($this->db->link));

		return $count;
	}

	public function updateRequest($request, $uid) {
		$q = array("responded" => 1);

		//WHERE ".$field."'".$id."'";
		$this->db->update2($this->prefix."__invites", $q, "request='".$request."' AND friend_uid='".$uid."'");
	}

	public function updateShared($uid) {
		$q = array("shared" => '1');
		$this->db->update($this->prefix."__users", $q, "oauth_uid", $uid);
	}

	public function updateUsername($id, $username) {
		mysqli_real_escape_string($this->db->link, $username);
		$q = array("username" => $username);
		$this->db->update($this->prefix."__users", $q, "id", $id);
	}

	public function updateIsFan($uid, $fan) {
		$q = array("isFan" => $fan);
		$this->db->update($this->prefix."__users", $q, "oauth_uid", $uid);
	}

	public function updateAcces_token($uid, $facebook_acces_token) {
		$q = array("facebook_acces_token" => $facebook_acces_token);
		$this->db->update($this->prefix."__users", $q, "oauth_uid", $uid);
		$_SESSION['facebook_acces_token'] = $facebook_acces_token;
	}

	public function updateAcces_token_tw($uid, $twitter_oauth_token, $twitter_oauth_token_secret, $access_token) {
		$q = array("twitter_oauth_token" => $twitter_oauth_token, "twitter_oauth_token_secret" => $twitter_oauth_token_secret, "access_token" => $access_token);
		$this->db->update($this->prefix."__users", $q, "oauth_uid", $uid);
		$_SESSION['twitter_oauth_token'] = $twitter_oauth_token;
	}

	//==========================================================================================
	//                                          DELETION
	//==========================================================================================
	public function deleteUid($uid) {
		$sql = "DELETE FROM ".$this->prefix."__cron WHERE uid=$uid";
		$ret .= "__games:".$this->db->query($sql);

		return $ret;
	}

	//==========================================================================================
	//                                          GETS
	//==========================================================================================

	public function getUser($id) {

		$sql = "SELECT * FROM ".$this->prefix."__users WHERE id = $id";
		$this->db->query($sql);
		$r = $this->db->fetch();

		return $r;
	}

	public function getUsers($oauth_provider) {

		$sql = "SELECT * FROM ".$this->prefix."__users WHERE oauth_provider = '".$oauth_provider."' AND agreed=1 AND isFan=1  ORDER BY RAND()";

		$this->db->query($sql);
		$data = array();
		while ($row = $this->db->fetch()) {
			array_push($data, $row);
		}
		return $data;
	}

	public function getUserUID($uid) {

		$sql = "SELECT * FROM ".$this->prefix."__users WHERE oauth_uid = $uid";
		$this->db->query($sql);
		$r = $this->db->fetch();

		return $r;
	}

	public function checkScore($id) {

		$sql = "SELECT ".$this->prefix."__users.totalscore as user_score,
                    ".$this->prefix."__users.playcount as user_score,
                    COUNT(".$this->prefix."__games.score) as real_playcount,
                    MAX(".$this->prefix."__games.score) as games_score
                    FROM ".$this->prefix."__users
                    LEFT JOIN ".$this->prefix."__games
                    ON (".$this->prefix."__games.uid = ".$this->prefix."__users.id)
                    WHERE  ".$this->prefix."__users.id = $id";

		// SELECT
		// CITADELE_PAGALMETIS__users.totalscore as user_score,
		// MAX(CITADELE_PAGALMETIS__games.score) as games_score
		// FROM CITADELE_PAGALMETIS__users
		// LEFT JOIN CITADELE_PAGALMETIS__games
		// ON (CITADELE_PAGALMETIS__games.uid = CITADELE_PAGALMETIS__users.id)
		// WHERE CITADELE_PAGALMETIS__users.id = 1

		$this->db->query($sql);
		$row = $this->db->fetch();

		// var_dump($row);
		// score kas glabajas useros

		$score = $row["user_score"];

		if ($row["user_score"] != $row["games_score"] || $row["playcount"] != $row["real_playcount"]) {

			// nesakrit rezultati apdeitojam user tabulu
			$this->addScoreForce($id, $row["games_score"], $row["real_playcount"]);
			$score = $row["games_score"];
		}

		$rank = $this->getRank($score);

		return $rank;
	}

	public function addScoreForce($id, $score, $playcount) {
		$sql = "UPDATE ".$this->prefix."__users set totalscore=$score, playcount=$playcount WHERE id=$id";
		$this->db->query($sql);
	}

	public function getRank($score) {

		//     SELECT gameid,
		//        MIN(date) AS FirstTime,
		//        MAX(date) AS LastTime,
		//        MAX(score) AS TOPscore.
		//        COUNT(*)  AS NbOfTimesPlayed
		// FROM highscores
		// WHERE userid='2345'
		// GROUP BY gameid
		// ORDER BY COUNT(*) DESC

		$sql = "SELECT COUNT(G.id) + 1 AS RANK FROM ".$this->prefix."__users G WHERE G.totalscore > $score";
		$this->db->query($sql);
		$r = $this->db->fetch();

		return $r["RANK"];
	}

	public function getTop($rescue) {

		if ($rescue > 0) {

			// saglabajam rescue sesija
			$_SESSION["rescue"] = $rescue;
		} else {
			unset($_SESSION["rescue"]);
		}

		$sql = "SELECT id, username, totalscore, playcount FROM ".$this->prefix."__users WHERE banned!=1 ORDER BY totalscore DESC LIMIT 100";
		$this->db->query($sql);
		$data = array();
		while ($row = $this->db->fetch()) {
			array_push($data, $row);
		}
		return $data;
	}
}
