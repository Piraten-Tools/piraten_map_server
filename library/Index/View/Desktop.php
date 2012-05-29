<?php echo '<?xml version="1.0" ?>';?>
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <title>OpenStreetMap Piraten Karte</title>
  <link rel="stylesheet" href="bootstrap-1.1.0.min.css" />
  <link rel="stylesheet" href="style.css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.2.min.js"></script>
  <script type="text/javascript" src="js/OpenLayers.php"></script>
  <script type="text/javascript" src="js/map.js"></script>
  <script type="text/javascript" src="js/popups.php"></script>
  <script type="text/javascript">
//<![CDATA[
    var startPos = <?php print json_encode($this->getInitialPosition()); ?>;
    var posterFlags = <?php print json_encode($this->getPosterFlags()); ?>;
    var isLoggedIn = <?php print $loginok ? 'true': 'false'; ?>;

    function onPageLoaded() {
        <?php
        if ($this->getMessage()) {
            echo "displaymessage('success', '".$this->getMessage()."');";
        }
        if ($this->getError()) {
            echo "displaymessage('error', '".$this->getError()."');";
        } ?>
    }
//]]>
  </script>
</head>

<body>
    <div id="mask"></div>
    <div class="topbar">
        <div class="fill">
            <div class="container">
                <h3><a href="#">Plakat Karte</a></h3>
                <ul>
                    <?php if ($_SESSION['wikisession']) {?>
                    <li class="showifloggedin"><a href="#" onclick="auth.logout();">Abmelden</a></li>
                    <?php } else { ?>
                    <li class="menu showifloggedin">
                        <a href="#" class="menu"><?php echo $_SESSION['siduser']?></a>
                        <ul class="menu-dropdown">
                            <?php if (isAdmin()) { ?>
                            <li><a href="admin.php" target="_blank">Administration</a></li>
                            <li class="divider" />
                            <?php }
                            if ($canSendMail) { ?>
                            <li><a href="#" onclick="javascript:showModalId('chpwform');">Passwort ändern</a></li>
                            <li class="divider" />
                            <?php } ?>
                            <li><a href="#" onclick="auth.logout();">Abmelden</a></li>
                        </ul>
                    </li>
                    <?php } ?>

                    <li class="showifloggedin"><a href="#" onclick="javascript:showModalId('uploadimg');">Bild hochladen</a></li>
                    <li class="showifloggedin"><a href="#" onclick="showModalId('exportCity');">Export</a></li>

                    <li class="hideifloggedin"><a href="#" onclick="javascript:showModalId('loginform');">Anmelden</a></li>
                    <?php if ($canSendMail) { ?>
                    <li class="hideifloggedin"><a href="#" onclick="javascript:showModalId('registerform');">Registrieren</a></li>
                    <?php } /* $canSendMail */ ?>
                    <li><a href="#" onclick="togglemapkey();">Legende / Hilfe</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div style="display:none;" id="dlgBag">
    <?php 
        include('dialogs/loginform.php');
        include('dialogs/uploadimg.php');
        include('dialogs/exportCity.php');
        if ($canSendMail) {
            include('dialogs/newpassform.php');
            include('dialogs/registerform.php');
            include('dialogs/chpwform.php');
        }
    ?>
    </div>
    <div id="msgBag"></div>
    <div id="map"></div>
    <div id="mapkey">
        <div class="modal">
            <div class="modal-header">
                <h3>Legende</h3>
                <a href="#" onclick="javascript:togglemapkey();" class="close">&times;</a>
            </div>
            <div class="modal-body">
                <ul class="unstyled">
                    <?php if ($loginok==0) { ?>
                    <li>Plakate werden erst nachdem Login editierbar.</li>
                    <li>Lokaler oder Wiki Login möglich!</li>
                    <? } else {   ?>
                    <li>STRG+Mausklick: neuer Marker</li>
                    <?php } ?>
                    <li>
                        <ul>
                        <?php foreach ($this->getPosterFlags() as $key=>$value) {
                            if ($value!="") { ?>
                            <li><img  style="vertical-align:text-top;" src="./images/markers/<?php echo $key?>.png" width="20" alt="<?php echo $key?>" />=<?php echo $value?></li>
                        <?php
                            }
                        } ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>