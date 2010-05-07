<?
header('content-type: text/html; charset=utf8');
function GetCrumps($lnk)
{
	$crumps = "<a href='view_forums.php'>Список форумов</a>";
	if (isset($_GET["forum"]))
	{
		$forum_id = $_GET["forum"];
		$r = mysql_query("SELECT frm_title FROM `bit_forum`.`forums` WHERE frm_id='$forum_id'", $lnk);
		$res = mysql_fetch_assoc($r);
		$crumps = $crumps." | "."<a href='view_topics.php?forum=".$forum_id."'>".$res["frm_title"]."</a>";
	}
	
	if (isset($_GET["topic"]))
	{
		$topic_id = $_GET["topic"];
		
		$r = mysql_query("SELECT tpc_title FROM `bit_forum`.`topics` WHERE tpc_id='$topic_id'", $lnk);
		$res = mysql_fetch_assoc($r);
		
		$crumps = $crumps." | <a href='view_posts.php?forum=".$forum_id."&topic=".$topic_id."'>".$res["tpc_title"]."</a>";
	}
	return $crumps;
}
?>