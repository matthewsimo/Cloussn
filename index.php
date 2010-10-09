<!DOCTYPE html>
<html>
<head>
<style>
body {background: #f1f1f1; color: #1E1E1E;}
</style>
</head>
<body>
<?php

// Get the Config Infos
require_once 'config.php';

// Define where the Cloussn is on the interwebs
define('CLOUSSN_DOMAIN', preg_replace('#^www\.#', '', $_SERVER['SERVER_NAME']));
define('CLOUSSN_URL', str_replace('-/index.php', '/cloussn', 'http://'.CLOUSSN_DOMAIN.$_SERVER['PHP_SELF']));

if ( isset($_GET["url"]) ) {

// Define URL to shorten
$shorten_me = $_GET["url"];

// Begin CloudApp Process
require_once 'Cloud/API.php';

  $cldlyme        = new Cloud_API($cldlyme_user, $cldlyme_pass, 'Clssn Test');

  // Add the bookmark, yo
  $cld_link       = $cldlyme->addBookmark($shorten_me);
  // Prep Recently Bookmarked cloud.ly link for lessn
  $url_to_lessn   = $cld_link->url;


// Begin Lessn Process
  $lessn_request  = $lessn_domain . '?url=' . $url_to_lessn . '&api=' . $lessn_api_key;

  $do_lessn   = fopen($lessn_request, "r");
  $new_url    = stream_get_contents($do_lessn);
  fclose($do_lessn);

?>

<p>Original link: <a href="<?php echo $shorten_me; ?>"><?php echo $shorten_me; ?></a></p>
<p>CloudApp link: <a href="<?php echo $cld_link->url; ?>"><?php echo $cld_link->url; ?></a></p>
<input type="text" id="url" value="<?php echo htmlspecialchars($new_url); ?>" onclick="this.focus();this.select();" readonly="readonly" />
<script>
var input = document.getElementById('url');
input.focus();
input.select();
</script>

<?php
} else { // There is no url to shorten, show default schtufff.
?>

<p>Drag this link to your bookmark bar: <a href="javascript:location.href='<?php echo CLOUSSN_URL; ?>?url='+encodeURIComponent(location.href);">Cloussn</a></p>

<?php
}
?>

</body>
</html>