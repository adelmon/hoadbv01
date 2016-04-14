<?php
/*==============================================================================
 * (C) Copyright 2016 John J Kauflin, All rights reserved. 
 *----------------------------------------------------------------------------
 * DESCRIPTION: Get data for reports
 *----------------------------------------------------------------------------
 * Modification History
 * 2016-04-12 JJK 	Initial version
 *============================================================================*/

include 'commonUtil.php';
// Include table record classes and db connection parameters
include 'hoaDbCommon.php';

$username = getUsername();

$adminRec = new AdminRec();
$adminRec->result = "Not Valid";
$adminRec->message = "";

$action = getParamVal("action");
$fiscalYear = getParamVal("FY");
$duesAmt = strToUSD(getParamVal("duesAmt"));

$adminLevel = getAdminLevel();
$conn = getConn();

if ($action == "AddAssessments") {

// End of if ($action == "AddAssessments") {
} else if ($action == "DuesStatements") {

	$outputArray = array();

		// Loop through all the member properties
		$sql = "SELECT * FROM hoa_properties p, hoa_owners o WHERE p.Member = 1 AND p.Parcel_ID = o.Parcel_ID AND o.CurrentOwner = 1 ";		
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		
		$cnt = 0;
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$cnt = $cnt + 1;

				//$Parcel_ID = $row["Parcel_ID"];
				//$OwnerID = $row["OwnerID"];
				//$FY = $row["Own"];
				/*					
				if (!$stmt->execute()) {
					error_log("Execute failed: " . $stmt->errno . ", Error = " . $stmt->error);
					echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				}
				*/
			
				//if ($cnt < 101) {
					//$hoaRec = getHoaRec($conn,$Parcel_ID,$OwnerID,NULL,NULL);
					//array_push($outputArray,$hoaRec);
				//}
				
				$hoaPropertyRec = new HoaPropertyRec();
				
				$hoaPropertyRec->parcelId = $row["Parcel_ID"];
				$hoaPropertyRec->lotNo = $row["LotNo"];
				$hoaPropertyRec->subDivParcel = $row["SubDivParcel"];
				$hoaPropertyRec->parcelLocation = $row["Parcel_Location"];
				$hoaPropertyRec->ownerName = $row["Owner_Name1"] . ' ' . $row["Owner_Name2"];
				$hoaPropertyRec->ownerPhone = $row["Owner_Phone"];
				
				array_push($outputArray,$hoaPropertyRec);
			}
			
			/*
			$serializedArray = serialize($outputArray);
			if (function_exists('mb_strlen')) {
				$size = mb_strlen($serializedArray, '8bit');
			} else {
				$size = strlen($serializedArray);
			}
			
			error_log("END Array cnt = " . count($outputArray) . ', size = ' . round($size/1000,0) . 'K bytes');
			[09-Apr-2016 22:26:04 Europe/Paris] BEG Array
			[09-Apr-2016 22:26:12 Europe/Paris] END Array cnt = 542, size = 5209K bytes				
			*/
			
			$adminRec->hoaPropertyRecList = $outputArray;
		}

		$adminRec->message = "Completed data lookup Dues Statements";
		$adminRec->result = "Valid";
}
	
	// Close db connection
	$conn->close();

	echo json_encode($adminRec);
?>