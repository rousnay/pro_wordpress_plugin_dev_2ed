<?php $full_name = $_POST['full_name']; ?>

<form action="" method="POST">
	<label>
		Full Name:
		<input type="text" name="full_name" value="<?php echo $full_name; ?>" />
	</label>
	<input type="submit" value="Submit" />
</form>
