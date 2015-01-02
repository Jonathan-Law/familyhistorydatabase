<?php
if (!isset($session))
{
	$session = mySession::getInstance();
}
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
if ($session->isLoggedIn())
{
	$user = User::current_user();
	$user = recast("User", $user);
	$favorites = Favorites::getFavoritesByUser($user->id);
}
else
{
	$favorites = "";
}
// echo "<pre>";
// print_r($favorites);
// echo "</pre>";
?>
<div class='greenlink little text-center' style='margin-top:10px;'>
   <a href="/?controller=index&amp;action=people">Browse for more people</a> || 
   <a href="/?controller=search&amp;action=showMainSearch">Search for more people</a>
</div>
<div>

	<div class="inline_reset">
		<h1 class="inline">
			Favorites (watch) List
		</h1>
		<hr>
		<p>You should receive updates for each of the following individuals when updates are made to their pages.</p>
	</div>
	<div style="width: 100%; padding 15px;" id='favorites_list'>
		<table style="width: 100%">
			<?php
			$people = array();
			if (!empty($favorites))
			{

				foreach ($favorites as $person) 
				{
					$people[] = recast("Person", Person::getById($person->person_id));
				}
				foreach ($people as $person) 
				{
					echo "<tr>";
					echo "<td>";
					echo "<a href='?controller=individual&action=homepage&id=".$person->id."'>".$person->displayName()."</a>";
					echo "</td>";
					echo "<td class='text-right'>";
					echo "<button class='btn btn-danger' onclick='removeFavorite(".$person->id.")'><i class='icon-trash'></i>Remove Individual</button>";
					echo "</td>";
					echo "</tr>";
				}
			}
			?>
		</table>
	</div>
</div>