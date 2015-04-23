<?php
include('NewMySurveys.php');
	echo "<div id=\"surveyBox\" class = \"fLef\">
	<h3>Current Studies</h3>
	<div class=\"scroll\"><div >$ResearchSurvey</div></div><br />
	<h3>Studies You Qualify For</h3>
	<div class=\"scroll\"><div >$QualticsSurvey</div></div>
</div>
<br />
<input type=\"button\" class='cBtn' value=\"charateristics profile\" onclick=\"location='characteristics.php'\" /> ";
?>