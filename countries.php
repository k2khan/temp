<?php
    $db = new PDO('sqlite:countries.db') or die ("cannot open database");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Countries DB</title>
        <link rel="icon" type="image/jpg" href="images/earth.png">
        <link rel="stylesheet" type="text/css" href="countryStyle.css">
    </head>
    <body>
        <div class="header">
            <div id="banner">
		    <img id="sfBanner"
			src="images/earth.png"
                        title="Picture of the Earth">
                </a>
            </div>
        </div>
        <div class="content">
            <h1>Countries DB!</h1>
	    <br/>

        <form method="post">
            <select name="select">
                <option value="Query1">Display Countries and leaders with female prime ministers</option>
                <option value="Query2">Select region and country names where capital city is not the largest city</option>
                <option value="Query3">Select leaders and HDI Scores of countries with a high score and a leader who is a president</option>
                <option value="Query4">Select countries and their gdp and HDI Score and order them by score lowest to highest</option>
                <option value="Query5">Select the country in each region with the largest land area</option>
            </select>
            <input type="submit" value="GO!"/>
        </form>

        <?php
        if ($_POST['select'] == 'Query1') {
            $query_1 = "SELECT Leader_name, Country_code
            FROM Leaders
            WHERE Title = 'Prime Minister' AND Gender = 'female'
            ORDER BY Country_code ASC";
            
            $query1 = $db->query($query_1);

            echo "<table><tr><th>Leader Name</th><th>Country Code</th></tr>";
            while($row = $query1->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>".$row['Leader_name']."</td><td>".$row['Country_code']."<td></tr>";
            }
        }
        ?>

        <?php
        if ($_POST['select'] == 'Query2') {
            $query_2 = "SELECT Region, COUNT(Country_name)
            AS max
            FROM Country
            GROUP BY Region
            HAVING Capital != Largest_city;
            ";
            
            $query2 = $db->query($query_2);

            echo "<table><tr><th>Region</th><th>Count(Country_name)</th></tr>";
            while($row = $query2->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>".$row['Region']."</td><td>".$row['max']."<td></tr>";
            }
        }
        ?>


        <?php
        if ($_POST['select'] == 'Query3') {
            $query_3 = "SELECT Country.Country_name, Leaders.Leader_name, Country.HDI_Score
            FROM Leaders
            INNER JOIN Country
            ON Leaders.Country_code = Country.Country_code
            WHERE Country.HDI_Score >= .6 AND Leaders.Title = 'President'";
            
            $query3 = $db->query($query_3);

            echo "<table><tr><th>Country Name</th><th>Leader Name</th><th>HDI Score</th></tr>";
            while($row = $query3->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>".$row['Country_name']."</td><td>".$row['Leader_name']."</td><td>".$row['HDI_Score']."<td></tr>";
            }
        }
        ?>

        <?php
        if ($_POST['select'] == 'Query4') {
            $query_4 = "SELECT Country_name, GDP, HDI_score
            FROM Country
            ORDER BY HDI_score DESC";
            
            $query4 = $db->query($query_4);

            echo "<table><tr><th>Country Name</th><th>GDP</th><th>HDI Score</th></tr>";
            while($row = $query4->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>".$row['Country_name']."</td><td>".$row['GDP']."</td><td>".$row['HDI_Score']."<td></tr>";
            }
        }
        ?>

         <?php
        if ($_POST['select'] == 'Query5') {
            $query_5 = "SELECT Country.Region, Country.Country_name, MAX(Country.Area_km2)
            AS max
            FROM Country
            GROUP BY Country.Region";
            
            $query5 = $db->query($query_5);

            echo "<table><tr><th>Region</th><th>Country Name</th><th>Area (km^2)</th></tr>";
            while($row = $query5->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>".$row['Region']."</td><td>".$row['Country_name']."</td><td>".$row['max']."<td></tr>";
            }
        }
        ?>       

	</select>
        </div>
    </body>
</html>
