<div id="createEvent" style="order:2;">
	<a href="index.php?action=companyCreation"><button>Add your company now!</button></a>
</div>


<?php

if (user::isAdmin()) {
	$companies = company::get_allCompaniesInfo();
	/* $companies = [{"companyId":1, "name":"Randstad", "description":"Good to know you!", "vatNumber":"198533365815"}] */
	
	echo "<div class=rowDivider style=order:3;></div>";
	echo "<div class=adminEventOverview  style=order:4;>";
	echo "<h2>Admin Company Overview:</h2>";
	
	for($x = 0; $x < count($companies); $x++) {
		$companyId = $companies[$x]['companyId'];
		$name = $companies[$x]['name'];
		$fileInfo = userFile::get_imageOfUploader('company', $companyId);
		$url = $fileInfo->getUrl();
		
		echo "<a href=index.php?action=company&companyId=$companyId>";
		echo "<div style='position:relative; float:left; background-color:white; width:150px; height:200px; margin: 10px;'>";
		echo "<p style='text-align:center; font-weight:700;'>$name</p>";
		if (isset($url)) {
			echo "<img src=$url style='position:absolute; width:150px; height:150px; bottom:0;'>";
		}
		echo "</div>";
		echo "</a>";
	}
	echo "<div>";
}

?>