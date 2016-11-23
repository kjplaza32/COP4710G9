<?php 

function connectToDB() {
	$password = getenv("CURSILLOPW");
	$user = get_current_user();
	$dbname = $user . '_db';
	$dsn = 'mysql:dbname='.$dbname.';host=127.0.0.1';

	try {
	    $dbh = new PDO($dsn, $user, $password);
	    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,false); 
	    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
	    echo 'Connection failed: ' . $e->getMessage();
	    die();
	}

	return $dbh;
}

/*		Site Specific		*/

function baseDir() {
	$user = get_current_user();
	return '/~' . $user . '/';
}

function makeLink($rel) {
	echo basedir() . $rel;
}

/*		Datahandling		*/
function checkBoxToBit($data) {
	return $data == 'on' ? "b'1'" : "b'0'";
}

function bitToCheckBox($data) {
	return $data == 1 ? 'on' : 'off';
}

function validateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

/*			Individual Stuff 				*/
function updateIndividual($dbh, $individualId, $addressID, $first, $last, $gender, 
						  $spousefirst, $spouselast, $pastorfirst, $pastorlast, $email, 
						  $phone, $nametag, $occupation, $sponsorId, $parishName, 
						  $birthday, $isMarried, $hasSpouseAttended, $type) {

	// TODO: Create Team/candidate entries
	$sql = "update individual set AddressID=?,
							      FirstName=?,
							      LastName=?,
							      Gender=?,
							      SpouseFirstName=?,
							      SpouseLastName=?,
							      PastorFirstName=?,
							      PastorLastName=?,
							      Email=?,
							      Phone=?,
							      NameTag=?,
							      Occupation=?,
							      SponsorID=?,
							      ParishName=?,
							      Birthday=?,
							      IsMarried=$isMarried,
							      HasSpouseAttended=$hasSpouseAttended,
							      IndividualType=?
			where IndividualId=?";
	
	$stm = $dbh->prepare($sql);
	$res = $stm->execute(array($addressID,
							   $first,
							   $last,
							   $gender,
							   $spousefirst,
							   $spouselast,
							   $pastorfirst,
							   $pastorlast,
							   $email,
							   $phone,
							   $nametag,
							   $occupation,
   							   $sponsorId,
							   $parishName,
							   $birthday,
							   $type,
							   $individualId));
	return $res;
}

function createIndividual($dbh, $addressId, $first, $last, $gender, $spousefirst, $spouselast,
						  $pastorfirst, $pastorlast, $email, $phone, $nametag, 
						  $occupation, $sponsorId, $parishName, $birthday, $isMarried, 
						  $hasSpouseAttended, $type) {


	// TODO: create team/candidate entries
	$sql = "insert into individual (AddressID,
									FirstName,
									LastName,
									Gender,
									SpouseFirstName,
									SpouseLastName,
									PastorFirstName,
									PastorLastName,
									Email,
									Phone,
									NameTag,
									Occupation,
									SponsorID,
									ParishName,
									Birthday,
									IsMarried,
									HasSpouseAttended,
									IndividualType)
				values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,$isMarried,$hasSpouseAttended,?)";
	
	$stm = $dbh->prepare($sql);
	$res = $stm->execute(array($addressId,
							   $first,
							   $last,
							   $gender,
							   $spousefirst,
							   $spouselast,
							   $pastorfirst,
							   $pastorlast,
							   $email,
							   $phone,
							   $nametag,
							   $occupation,
							   $sponsorId,
							   $parishName,
							   $birthday,
							   $type));
	return $res;
}

function getIndividual($dbh, $id) {
	$sql = "select * from individual where individualId=?";
	$stm = $dbh->prepare($sql);
	$res = $stm->execute(array($id));

	if($res == 1) {
		return $stm->fetchAll()[0];
	}

}

function deleteIndividual($dbh, $individual) {
	deleteAddress($dbh, $individual['AddressID']);

	$sql = "delete from individual where individualId=?";
	$stm = $dbh->prepare($sql);
	$stm->execute(array($individual['IndividualID']));
}

function getIndividuals($dbh) {
	$sql = "select * from individual";
	$stm = $dbh->prepare($sql);
	$res = $stm->execute(array());
	$res = $stm->fetchAll();

	return $res;
}

function findSponsor($dbh, $firstName, $lastName) {
	$sql = "select * from individual 
				where FirstName=? and LastName=? and IndividualType='TEAM'";
	
	$stm = $dbh->prepare($sql);
	$res = $stm->execute(array($firstName, $lastName));

	if($res == 1) {
		$res = $stm->fetchAll();
		if(count($res) > 0) {
			return $res[0]["IndividualID"];			
		}
	}

	return null;
}


/*		Address Stuff 				*/

function createAddress($dbh, $line1, $line2, $city, $state, $zipcode) {

	if(empty($line1)||empty($city)||empty($state)||empty($zipcode)) {
		return -1;
	}

	$sql = "insert into address (line1, line2, city, state, zipcode) values (?,?,?,?,?)";
	$stm = $dbh->prepare($sql);
	$res = $stm->execute(array($line1, $line2, $city, $state, $zipcode));

	if($res != 1) {
		die( 'ERROR: Could not create address');
	}

	$addressId = $dbh->lastInsertId();
	return $addressId;
}

function getAddress($dbh, $id) {
	$sql = "select * from address where addressId=?";
	$stm = $dbh->prepare($sql);
	$res = $stm->execute(array($id));

	if($res == 1) {
		return $stm->fetchAll()[0];
	}
}

function createUpdateAddress($dbh, $id, $line1, $line2, $city, $state, $zip) {
	$address = getAddress($dbh, $id);
	if(empty($address)) {
		return createAddress($dbh, $line1, $line2, $city, $state, $zip);
	}

	if($address['Line1'] != $line1 ||
	   $address['Line2'] != $line2 ||
	   $address['City']  != $city  ||
	   $address['State'] != $state ||
	   $address['ZipCode'] != $zip) {
		deleteAddress($dbh, $id);
		return createAddress($dbh, $line1, $line2, $city, $state, $zip);
	} else {
		return $id;
	}
}

function deleteAddress($dbh, $id) {
	$sql = "delete from address where addressId=?";
	$stm = $dbh->prepare($sql);
	$stm->execute(array($id));
}


/*			Parish Stuff 				*/

function getParish($dbh, $parishName) {
	$sql = "select * from parish where ParishName=?";
	$stm = $dbh->prepare($sql);
	$res = $stm->execute(array($parishName));

	if($res == 1) {
		$res = $stm->fetchAll();
		if(count($res) == 1) {
			return $res[0];
		} 
	}

	return null;
}

function findParish($dbh, $parishName) {
	$sql = "select * from parish where ParishName=?";
	$stm = $dbh->prepare($sql);
	$res = $stm->execute(array($parishName));

	if($res == 1) {
		$res = $stm->fetchAll();
		if(count($res) == 1) {
			return $parishName;
		} 
	}

	return null;
}

function createParish($dbh, $parishName, $diocese, $addressId) {
	$sql = "insert into parish (ParishName, Diocese, AddressID) values (?,?,?)";
	$stm = $dbh->prepare($sql);
	$res = $stm->execute(array($parishName, $diocese, $addressId));

	return $res;
}

function getParishes($dbh) {
	$sql = "select * from parish";
	$stm = $dbh->prepare($sql);
	$res = $stm->execute();

	return $stm->fetchAll();
}

function updateParish($dbh, $parishName, $addressId, $diocese) {
	$sql = "update parish set AddressID=?,
							  Diocese=?
				where ParishName=?";
	
	$stm = $dbh->prepare($sql);
	$res = $stm->execute(array($addressId, $diocese, $parishName));

	return $res;
}

function deleteParish($dbh, $parish) {
	deleteAddress($dbh, $parish['AddressID']);

	$parishName = $parish['ParishName'];
	$sql = "delete from parish where ParishName=?";
	$stm = $dbh->prepare($sql);
	$res = $stm->execute(array($parishName));

	return $res;
}


/*				Cursillo Stuff 			*/

function createCursillo($dbh, $startDate, $endDate, $addressId, $title, 
						$gender, $description, $notes, $photo) {
	$sql = "insert into cursilloweekend 
				(Start, End, AddressID, EventName, Gender, Notes, Description, PhotoUrl)
			values (?,?,?,?,?,?,?,?)";

	$stm = $dbh->prepare($sql);
	$res = $stm->execute(array($startDate, $endDate, $addressId, $title, 
							   $gender, $description, $notes, $photo));

	return $res;
}



?>