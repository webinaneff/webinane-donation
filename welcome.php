<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="col-md-12">
        <div class="row">
            <h1 style="background-color: #4DB485; color: #fff; padding: 20px; line-height: 60px;">Panel Options</h1>
            <div class="nav-tab-wrapper give-nav-tab-wrapper">
                <a style="text-decoration: none;" href="http://localhost/client/wp-admin/edit.php?post_type=wp_donation&amp;page=webinane-settings&amp;tab=general" class="nav-tab nav-tab-active">General</a>
                <a style="text-decoration: none;" href="http://localhost/client/wp-admin/edit.php?post_type=wp_donation&amp;page=webinane-settings&amp;tab=gateways" class="nav-tab give-mobile-hidden">Payment Gateways</a>
                <a style="text-decoration: none;" href="http://localhost/client/wp-admin/edit.php?post_type=wp_donation&amp;page=webinane-settings&amp;tab=display" class="nav-tab give-mobile-hidden">Display Options</a>
                <a style="text-decoration: none;" href="http://localhost/client/wp-admin/edit.php?post_type=wp_donation&amp;page=webinane-settings&amp;tab=emails" class="nav-tab give-mobile-hidden">Emails</a>
                <a style="text-decoration: none;" href="http://localhost/client/wp-admin/edit.php?post_type=wp_donation&amp;page=webinane-settings&amp;tab=licenses" class="nav-tab give-mobile-hidden">Licenses</a>
                <a style="text-decoration: none;" href="http://localhost/client/wp-admin/edit.php?post_type=wp_donation&amp;page=webinane-settings&amp;tab=advanced" class="nav-tab give-mobile-hidden">Advanced</a>
            </div>
        </div>
        <div class="row">
	            <?php
	            global $wpdb;
	            $sql = "SHOW TABLES LIKE '%'";
	            $results = $wpdb->get_results($sql);
	            ?>

<?php print_r($index1); ?>
	            <?php print_r($index2); ?>
	            <?php print_r($index3); ?>
	            <?php print_r($index4); ?>

	            <?php
	            foreach($results as $index => $value) {
		            foreach($value as $tableName) {
			            echo $tableName . '<br />';
		            }
	            }
	            ?>
        </div>
    </div>
</div>

</body>
</html>
