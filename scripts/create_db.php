<?php
if(isset($_GET['installation_id'])&&isset($_GET['org_name'])&&isset($_GET['odb'])&&isset($_GET['odbu'])&&isset($_GET['odbp'])){
    $installation_id=$_GET['installation_id'];
    $institute_name=$_GET['org_name'];
    $odb=$_GET['odb'];
    $odbu=$_GET['odbu'];
  	$odbp=$_GET['odbp'];
  	include_once("../classes/tdb.class.php");
  	$tdbh=new tdb("root", "", "create new");
    $tl=$_GET['tl'];
    $enc_string=$tl."-".$installation_id;
    $enc=fopen("../../../redaert.txt", "w");
    $encw=fwrite($enc, $enc_string);
    fclose($enc);
    if($tdbh->connection){
        $x=mysql_query("CREATE DATABASE treader_db");
        $y=mysql_query("CREATE USER 'triaas'@'localhost' IDENTIFIED BY 'tReader'");
        $z=mysql_query("GRANT SELECT, INSERT, UPDATE, DELETE ON treader_db.* TO 'triaas'@'localhost'");
        $dbh=new tdb("root", "", "treader_db");
        if($dbh->connection){
          mysql_query('SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO"');
          mysql_query('SET time_zone = "+00:00"');
          
mysql_query('CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `installation_id` varchar(15) NOT NULL,
  `institute_name` varchar(50) NOT NULL,
  `brand_name` varchar(20) NOT NULL,
  `address` tinytext NOT NULL,
  `city` varchar(30) NOT NULL,
  `contact_no` varchar(30) NOT NULL,
  `logo` varchar(50) NOT NULL,
  `full_address` tinytext NOT NULL,
  `webh` varchar(100) NOT NULL,
  `odb` varchar(15) NOT NULL,
  `odbu` varchar(15) NOT NULL,
  `odbp` varchar(15) NOT NULL,
  `sms_url` varchar(100) NOT NULL,
  `sms_un` varchar(50) NOT NULL,
  `sms_pas` varchar(50) NOT NULL,
  `sms_templates` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ');

mysql_query("INSERT INTO `config` (`installation_id`, `institute_name`, `odb`, `odbu`, `odbp`) VALUES
('$installation_id', '$institute_name', '$odb', '$odbu', '$odbp')") or die(mysql_error());

          mysql_query("CREATE TABLE IF NOT EXISTS `omrsheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sheet_name` varchar(20) NOT NULL,
  `sub_pattern` varchar(10) NOT NULL,
  `no_of_subs` int(1) NOT NULL,
  `sub_names` tinytext NOT NULL,
  `sub_qs_dist` varchar(20) NOT NULL,
  `col_qs_pattern` varchar(20) NOT NULL,
  `marking_pattern` varchar(25) NOT NULL,
  `roll_digit` varchar(2) NOT NULL,
  `js_file` varchar(50) NOT NULL,
  `q_opts` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14");


          mysql_query('CREATE TABLE IF NOT EXISTS `omr_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `reg_date` varchar(15) NOT NULL,
  `last_login` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ');
          mysql_query("INSERT INTO `omr_admin` (`id`, `fname`, `lname`, `username`, `password`, `reg_date`, `last_login`) VALUES
(1, 'Admin ', 'Name', 'omradmin', 'password', '', '')");


          mysql_query("CREATE TABLE IF NOT EXISTS `scaned_omrs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_id` varchar(15) NOT NULL,
  `std_roll_no` varchar(11) NOT NULL,
  `test_data` mediumtext NOT NULL,
  `scaned_time` int(20) NOT NULL,
  `wrong_ans` varchar(3) NOT NULL,
  `right_ans` int(4) NOT NULL,
  `total_score` int(5) NOT NULL,
  `rank` int(5) NOT NULL,
  `incorrect_filled` int(4) NOT NULL,
  `correct_match` varchar(3) NOT NULL,
  `incorrect_match` varchar(3) NOT NULL,
  `col1_score` int(4) NOT NULL,
  `col2_score` int(4) NOT NULL,
  `col3_score` int(4) NOT NULL,
  `col4_score` int(4) NOT NULL,
  `col5_score` int(4) NOT NULL,
  `percentage` float NOT NULL,
  `percentile` float NOT NULL,
  `omr_src` varchar(300) NOT NULL,
  `sms_sent` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");


          mysql_query("CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roll_no` varchar(10) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `img_src` varchar(100) NOT NULL,
  `batch` varchar(25) NOT NULL,
  `medium` varchar(10) NOT NULL,
  `reg_date` varchar(15) NOT NULL,
  `main_stream` enum('eng','med') NOT NULL DEFAULT 'eng',
  `mobile` varchar(15) NOT NULL,
  `mobile_p` varchar(13) NOT NULL,
  `address` tinytext NOT NULL,
  `sms_sent` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

          
          mysql_query("CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `test_id` varchar(11) NOT NULL,
  `test_name` varchar(200) NOT NULL,
  `test_date` varchar(100) NOT NULL,
  `std_type` varchar(20) NOT NULL,
  `omr_code` varchar(100) NOT NULL,
  `batch` varchar(10) NOT NULL,
  `max_score` int(5) NOT NULL,
  `total_qs` int(5) NOT NULL,
  `sub_pattern` tinytext NOT NULL,
  `answer_data` mediumtext NOT NULL,
  `minor_name` varchar(20) NOT NULL,
  `total_stds` int(5) NOT NULL,
  `topper` varchar(50) NOT NULL,
  `sms_sent` int(5) NOT NULL,
  `hidden` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");


          header("Location:../config-setting.php");
        }

    }else{
        echo "Error! Try again.";
        exit();
    }
}else{
    echo "ERROR! Please first Install this on Online server!";
}

?>