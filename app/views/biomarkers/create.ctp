<?php echo $html->css('frozenbrowser');?>
<div class="menu">
	<div class="mainContent">
		<h2 class="title">EDRN Biomarker Database</h2>
	</div>
	<!-- Breadcrumbs Area -->
	<div id="breadcrumbs">
	<a href="/<?php echo PROJROOT;?>/">Home</a> / Biomarkers
	<div class="userdetails">
			<?php if (isset($_SESSION['username'])) {
				echo "Logged in as: {$_SESSION['username']}. &nbsp;";
				echo "<a href=\"/".PROJROOT."/users/logout\">Log Out</a>";
			} else {
				echo "Not Logged In. &nbsp; ";
				echo "<a href=\"/".PROJROOT."/users/login\">Log In</a>";
			}?>
	</div>
	</div><!-- End Breadcrumbs -->
</div>

<h2>Create a New Biomarker:</h2>
<br/>
<form method="POST" action="/<?php echo PROJROOT;?>/biomarkers/createBiomarker">
<table style="margin-left:25px;">
  <tr>
    <td>Biomarker Long Name:</td>
    <td><input type="text" name="name"/></td>
  	<td><input type="submit" value="Create"/></td>
  </tr>
</table>
</form>
<p>&nbsp;</p>