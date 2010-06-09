<?php
	/*  Copyright 2010  Monjurul Dolon  (email : md@devgrow.com)
	      Author Homepage: http://mdolon.com/   Author Blog: http://devgrow.com/

		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License, version 2, as 
		published by the Free Software Foundation.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	*/
	$id = $_GET['id'] ? $_GET['id'] : $_POST['id'];
	$pos = $_GET['pos'] ? $_GET['pos'] : $_POST['pos'];
	$status = $_GET['status'] ? $_GET['status'] : $_POST['status'];
	$task = $_GET['task'] ? $_GET['task'] : $_POST['task'];
	$do = $_POST['do'];
	
	if($id)	$item = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."sharebar WHERE id=$id");

	if($do == 'update') $wpdb->query("UPDATE ".$wpdb->prefix."sharebar SET position='".$_POST['position']."', name='".$_POST['name']."', big='".$_POST['big']."', small='".$_POST['small']."' WHERE id='$id'");
	elseif($do == 'add') $wpdb->query("INSERT INTO ".$wpdb->prefix."sharebar (position, name, big, small) VALUES('".$_POST['position']."','".$_POST['name']."', '".$_POST['big']."', '".$_POST['small']."')");
	elseif($do == 'delete') $wpdb->query("DELETE FROM ".$wpdb->prefix."sharebar WHERE id=$id LIMIT 1");
	elseif($do == 'reset') sharebar_reset();
	elseif($do == 'settings'){
		$auto = $_POST['auto'] ? 1:0; $horizontal = $_POST['horizontal'] ? 1:0;
		$width = $_POST['width']; $position = $_POST['position'];
		$leftoffset = $_POST['leftoffset']; $rightoffset = $_POST['rightoffset'];
		sharebar_settings($auto, $horizontal, $width, $position, $leftoffset, $rightoffset);
	}
	
	if($pos == 'moveup') $wpdb->query("UPDATE ".$wpdb->prefix."sharebar SET position=position-1 WHERE id='$id'");
	if($pos == 'movedown') $wpdb->query("UPDATE ".$wpdb->prefix."sharebar SET position=position+1 WHERE id='$id'");
	if($pos) $status = "Position Updated!";
?>
<style>
	.wrap { width: 700px; }
	.h4title { margin:0 0 20px;overflow:hidden; }
	.wrap form label.wide { width: 100%; float: left; padding: 2px; font-weight: bold; }
	.wrap form .text { width: 400px; }
	.wrap form .mediumtext { width: 250px; }
	.wrap form .minitext { width: 50px; margin-right: 5px; }
	.wrap form .checkbox { margin-right: 5px; }
	.wrap form p.mediumtext { margin-right: 20px; }
	.thebutton { text-align: center; overflow: hidden; background: #fff; padding: 10px; border: 1px solid #ccc; }
	.thebutton td { padding: 0 15px; }
	.thebutton .name { padding: 0 0 10px; }
	.add-button { margin: 15px 0 0; }

	#sharebar-tl{width:700px;margin:0;padding:0;}
	#sharebar-tl caption{width:700px;font:italic 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;text-align:right;padding:0 0 5px;}
	#sharebar-tl th{font:bold 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;color:#4f6b72;border-right:1px solid #C1DAD7;border-bottom:1px solid #C1DAD7;border-top:1px solid #C1DAD7;letter-spacing:2px;text-transform:uppercase;text-align:left;background:#CAE8EA no-repeat;padding:6px 6px 6px 12px;}
	#sharebar-tl th.nobg{border-top:0;border-left:0;border-right:1px solid #C1DAD7;background:none;}
	#sharebar-tl td{border-right:1px solid #C1DAD7;border-bottom:1px solid #C1DAD7;background:#fff;color:#4f6b72;padding:6px 6px 6px 12px;}
	#sharebar-tl td.alt{background:#F5FAFA;color:#797268;}
	#sharebar-tl th.spec{border-left:1px solid #C1DAD7;border-top:0;background:#fff no-repeat;font:bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;}
	#sharebar-tl th.specalt{border-left:1px solid #C1DAD7;border-top:0;background:#f5fafa no-repeat;font:bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;color:#797268;}
	#sharebar-tl td, #sharebar-tl th { text-align: center; }
	#sharebar-tl tr { margin-bottom: 10px; }
	#sharebar-tl .leftj { text-align: left; }
	.sharebar-button { font-size: 11px; font-family: Verdana, Arial; padding: 2px 4px; background: #f7f7f7; color: #444; border: 1px solid #ddd; display: block; }
	.sharebar-button:hover { border-color: #aaa; }
	.FBConnectButton_Small{background-position:-5px -232px !important;border-left:1px solid #1A356E;}
	.FBConnectButton_Text{margin-left:12px !important ;padding:2px 3px 3px !important;}
</style>

<div class="wrap">

<?php if($status){?><div id="message" class="updated fade"><?php echo $status; ?></div><?php } ?>

<h2>Custom Sharebar</h2>

<h4 class="h4title"><div class="alignleft">By <a href="http://mdolon.com/" target="_blank">Monjurul Dolon</a> of <a href="http://devgrow.com/" target="_blank">DevGrow</a></div><div class="alignright"><a href="?page=Sharebar">Home</a> - <a href="?page=Sharebar&task=settings">Settings</a> - <a href="../wp-content/plugins/sharebar/README" target="_blank">Changelog</a> - <a href="http://devgrow.com/sharebar-wordpress-plugin/">Support</a></div></h4>

<?php if($task == 'edit' || $task == 'new'){?>

	<h3><?php if($task == 'edit') echo "Edit"; else echo "Add New"; ?> Button</h3>
	<?php
		if($task == 'edit'){
			echo '<table class="thebutton">';
			echo "<tr><th class='name'><strong>".$item->name.":</strong></th></tr>";
			echo "<tr><td>".$item->big."</td>";
			echo "<td>".$item->small."</td></tr>";
			echo '</table>';
		}
	?>
	<form action="?page=<?php echo $_GET['page']; ?>" method="post">
		<p class="mediumtext alignleft">
			<label for="name" class="wide">Name:</label>
			<input type="text" name="name" id="name" value="<?php echo $item->name; ?>" class="mediumtext" />
		</p>
		<p class="smalltext alignleft">
			<label for="position" class="wide">Position:</label>
			<input type="text" name="position" id="position" value="<?php echo $item->position; ?>" class="smalltext" />
		</p>
		<p>
			<label for="big" class="wide">Big Button:</label>
			<textarea name="big" id="big" class="text" rows=5><?php echo $item->big; ?></textarea>
		</p>
		<p>
			<label for="small" class="wide">Small Button:</label>
			<textarea name="small" id="small" class="text" rows=5><?php echo $item->small; ?></textarea>
		</p>
		<input type="hidden" name="do" value="<?php if($task == 'edit') echo "update"; else echo "add"; ?>" />
		<input type="hidden" name="id" value="<?php echo $item->id; ?>" />
		<input type="hidden" name="status" value="Share button has been <?php if($task == 'edit') echo "updated"; else echo "added"; ?>." />
		<input type="submit" value="<?php if($task == 'edit') echo "Update"; else echo "Add"; ?>" class="alignleft" />
	</form>
	<a href="?page=<?php echo $_GET['page']; ?>" class="alignleft" style="margin: 2px 0 0 10px;">Cancel</a>
		
<?php }elseif($task == 'delete'){ ?>

	<h3>Delete Button?</h3>
	<?php
		echo '<table class="thebutton">';
		echo "<tr><th class='name'><strong>".$item->name.":</strong></th></tr>";
		echo "<tr><td>".$item->big."</td>";
		echo "<td>".$item->small."</td></tr>";
		echo '</table>';
	?>
	<p>Are you sure you want to delete this button?</p>
	<form action="?page=<?php echo $_GET['page']; ?>" method="post">
		<input type="hidden" name="do" value="delete" />
		<input type="hidden" name="id" value="<?php echo $item->id; ?>" />
		<input type="hidden" name="status" value="Button has been deleted." />
		<input type="submit" value="Delete" class="alignleft" />
	</form>
	<a href="?page=<?php echo $_GET['page']; ?>" class="alignleft" style="margin: 2px 0 0 10px;">Cancel</a>
		
<?php }elseif($task == 'reset'){ ?>

	<h3>Reset Buttons?</h3>
	<p>Are you sure you want to reset <strong>ALL</strong> share buttons?  This cannot be undone and you will lose any customizations - all buttons will be reset to defaults.</p>
	<form action="?page=<?php echo $_GET['page']; ?>" method="post">
		<input type="hidden" name="do" value="reset" />
		<input type="hidden" name="status" value="All buttons have been reset to inital configuration." />
		<input type="submit" value="Reset ALL Buttons" class="alignleft" />
	</form>
	<a href="?page=<?php echo $_GET['page']; ?>" class="alignleft" style="margin: 2px 0 0 10px;">Cancel</a>
		
<?php }elseif($task == 'settings'){ ?>

	<h3>Sharebar Settings</h3>
	<form action="?page=<?php echo $_GET['page']; ?>" method="post">
		<p>
			<input type="checkbox" name="auto" id="auto" value="true" class="checkbox" <?php if($auto) echo "checked"; ?> /><label for="auto">Automatically add Sharebar to posts? (only affects single posts)</label><br />
			<small>If this option is disabled, you must manually add the horizontal and vertical bar code to your template(s).</small>
		</p>
		<p>
			<input type="checkbox" name="horizontal" value="true" id="horizontal" class="checkbox" <?php if($horizontal) echo "checked"; ?> /><label for="horizontal">Display horizontal Sharebar if the page is resized to less than <em><?php echo $width; ?>px</em>?</label>
		</p>
		<p>
			<select name="position" id="position">
				<option value="left"<?php if($position == 'left') echo " selected"; ?>>Left </option>
				<option value="right"<?php if($position == 'right') echo " selected"; ?>>Right </option>
			</select>
			<label for="position">Sharebar Position</label>
		</p>
		<p>
			<input type="text" name="leftoffset" id="leftoffset" class="minitext" value="<?php echo $leftoffset; ?>" /><label for="leftoffset">Left Offset (used when positioned to left)</label>
		</p>
		<p>
			<input type="text" name="rightoffset" id="rightoffset" class="minitext" value="<?php echo $rightoffset; ?>" /><label for="rightoffset">Right Offset (used when positioned to right)</label>
		</p>
		<p>
			<input type="text" name="width" id="width" class="minitext" value="<?php echo $width; ?>" /><label for="width">Minimum width in pixels required to show vertical Sharebar to the left of post</label>
		</p>
		<input type="hidden" name="do" value="settings" />
		<input type="hidden" name="status" value="Sharebar settings updated." />
		<input type="submit" value="Update Settings" class="alignleft" />
	</form>
	<a href="?page=<?php echo $_GET['page']; ?>" class="alignleft" style="margin: 2px 0 0 10px;">Cancel</a>
		
<?php }else{ ?>

	<p><strong>Sharebar</strong> adds a dynamic and fully customizable vertical box to the left of a blog post that contains links/buttons to popular social networking sites.</p>
	<p><strong>Big Buttons</strong> are used in the vertical Sharebar to the left of the post, while the <strong>Small Buttons</strong> are used in the horizontal Sharebar that appears under the post title (by default) if the width of the page is less than <strong><?php echo $width; ?>px</strong>.</p>
	<?php if($auto) echo "<p><strong>Auto mode is ON</strong>, so the buttons are added automatically.</p>";
		else{
			echo "<p><strong>Auto mode is OFF</strong>, so you must manually add the following code for the horizontal and vertical bars:</p>";
			echo "<blockquote><strong>Vertical (next to post) Sharebar:</strong> ";
			echo "<code>&lt;?php sharebar(); ?&gt;</code><br />";
			echo "<strong>Horizontal Sharebar:</strong> ";
			echo "<code>&lt;?php sharebar_horizontal(); ?&gt;</code></blockquote>";
		}
	?>
	<p>You can also call an individual button in any template by using the following code (where size is either <em>big</em> or <em>small</em>):
	<code>&lt;?php sharebar_button('name','size'); ?&gt;</code></p>
	<h3 class="alignleft">Active Buttons:</h3>
	<a href="?page=Sharebar&task=new" class="button alignright add-button">Add New Button</a>
	<table id="sharebar-tl">
		<thead><tr><th class='leftj'>Name</th><th>Position</th><th>Big Button</th><th>Small Button</th><th>Actions</th></tr></thead>
		<tbody>	
		<?php $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."sharebar ORDER BY position, id ASC"); echo "\n";
		foreach($results as $result){
			echo "\t\t<tr><td class='leftj'>".$result->name."</td><td>".$result->position."<a href='?page=Sharebar&pos=moveup&id=".$result->id."'><img src='../wp-content/plugins/sharebar/images/up.gif'/></a><a href='?page=Sharebar&pos=movedown&id=".$result->id."'><img src='../wp-content/plugins/sharebar/images/down.gif'/></a></td><td>".$result->big."</td><td>".$result->small."</td><td><a href='?page=".$_GET['page']."&task=edit&id=".$result->id."'>Edit</a> | <a href='?page=".$_GET['page']."&task=delete&id=".$result->id."'>Delete</a></td></tr>\n";
		} ?>
		</tbody>
	</table> 
	<a href="?page=<?php echo $_GET['page']; ?>&task=reset">Reset Buttons</a>
	
<?php } ?>

</div>