Welcome Admin, you are logged-in as, 
<?php

		echo '<br />Username: '. $sessVar['sadmin_uname']; //displays the username of the array
		
		if($sessVar['sadmin_ulvl'] == 1) {
			echo '<br />User Level: System Admin'; //displays the session id of the array
			} else {
			echo '<br />User Level: Ordinary user';
				}?>
<a href="<?php echo base_url();?>item/item/view_item"><br />View Items</a>
<a href="<?php echo base_url();?>item/item/view_category"><br />View Categories</a>                
<a href="<?php echo base_url();?>admin/profile_mboos/edit_profile/<?php echo $sessVar['sadmin_uid'] ?>"><br />Edit Profile</a>
<a href = "<?php echo base_url();?>admin/login/logout"><br />Sign Out</a>