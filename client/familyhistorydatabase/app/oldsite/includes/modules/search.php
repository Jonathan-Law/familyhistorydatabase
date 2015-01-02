<div class="hero-unit inline_reset text-center" style="margin-top: 10px;">
	<form class="navbar-search" id="site-search-page" method="get" action="/" style=" margin-top: 5px; float: none;">
		<input type="hidden" name="controller" value="search">
		<input type="hidden" name="action" value="main-search">
		<input type="text" class="search-query" style="line-height: 20px; width: 180px; height: 20px;" placeholder="Search" name="search" id="search-query-page">
	</form>
	<h1>Search Familyhistorydatabase.org!</h1>
</div>

<script type="text/javascript">
$(document).ready(function()
{
	$("#search-query-page").focus();
	$("#page_name").html("Search Page");
});
</script>
