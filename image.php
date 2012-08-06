<?php
/*
       Licensed to the Apache Software Foundation (ASF) under one
       or more contributor license agreements.  See the NOTICE file
       distributed with this work for additional information
       regarding copyright ownership.  The ASF licenses this file
       to you under the Apache License, Version 2.0 (the
       "License"); you may not use this file except in compliance
       with the License.  You may obtain a copy of the License at

         http://www.apache.org/licenses/LICENSE-2.0

       Unless required by applicable law or agreed to in writing,
       software distributed under the License is distributed on an
       "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
       KIND, either express or implied.  See the License for the
       specific language governing permissions and limitations
       under the License.
*/

require_once('library/System.php');
require("gps.php");

if (!User::current())
	exit();

if ($_REQUEST[completed] == 1) {
	$name = uniqid("");
	move_uploaded_file($_FILES['image']['tmp_name'], "uploads/plakat_$name.jpg");

	$latlon = read_latlon("uploads/plakat_$name.jpg");
	if ($latlon!=-1)
	{
		$lat = preg_replace("/,/",".",$latlon[0]);
		$lon = preg_replace("/,/",".",$latlon[1]);

		// FIXME - these functions no longer exist
		$id = map_add($lat, $lon, 'plakat_ok');
		map_change($id, null, null, "getimg.php?id=".$name);

		$msg = "Plakat wurde komplett eingetragen!";
		header("Location: ./?message=".$msg."&lat=".$lat."&lon=".$lon."&zoom=16");
	}
	else
	{
		$msg = "URL: <a href=./getimg.php?id=$name>getimg.php?id=$name</a>";
		header("Location: ./?message=".$msg);
	}
}
?>
