<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');

	include('../common/util.php');
	$dbh = connectToDB();

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Cursillo Weekend List</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	</head>
<body>
	<?php
		$weekends = getWeekends($dbh);
	?>

	<div class="container">
	<?php include('../common/nav.php'); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Number</th>
					<th>Title</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Gender</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($weekends as $weekend): ?>
				<?php 
					$start = new DateTime($weekend['Start']);
					$end = new DateTime($weekend['End']);
				?>

				<tr>
					<td><?php echo $weekend['EventID'] ?></td>
					<td><?php echo $weekend['EventName'] ?></td>
					<td><?php echo $start->format('Y-m-d') ?></td>
					<td><?php echo $end->format('Y-m-d') ?></td>
					<td><?php echo $weekend['Gender'] ?></td>
					<td>
						<a href="update.php?id=<?php echo $weekend['EventID']; ?>" target="new">
							<button type="button" class="btn btn-success">Edit</button>
						</a>
					</td>
					<td>
						<a href="delete.php?id=<?php echo $weekend['EventID']; ?>" target="new">
							<button type="button" class="btn btn-danger">Delete</button>
						</a>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>