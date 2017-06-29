<?php
require_once("class.event.php");
require_once("session.php");
?>
<div>
<span class="user-info">
									<small>Welcome,</small>
									<span><?php if($_SESSION['user_name']){?><span><?php echo $_SESSION['user_name']; ?></span><?php } ?></span>
								</span>
</div>