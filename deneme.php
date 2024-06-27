<!DOCTYPE html>
<html>
<head>
    <title>Günlük Hava Durumu</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</head>
<body>
	<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card w-50 mx-auto">
                    <div class="card-header text-center">
                        <h2>Hava Durumu</h2>
                    </div>
                    <div class="card-body">
                        <form method="get">
                            <div class="form-group ">
                                <label for="city">Şehir: </label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-3">Hava Durumu Getir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php
    function getDailyWeatherData($apiKey, $city) {
        $apiUrl = "https://api.collectapi.com/weather/getWeather?data.lang=tr&data.city=$city";
        $ch = curl_init($apiUrl);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: apikey ' . $apiKey
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response);
    }

    if (isset($_GET["city"])) {
        $apiKey = 'apikey 76zPxlbV9UQ2JRo2batpF5:2x01tBsbkWxoDue2LZfCXp';
        $city = urlencode($_GET["city"]);

        $data = getDailyWeatherData($apiKey, $city);

        if ($data && isset($data->result)) {
            $dailyWeather = $data->result;
			
			echo"<div class='row mt-5'>";
            echo"<div class='col-md-12 w-75 mx-auto'>";
            echo"<h3 class='text-center'>Hava Durumu Sonuçları</h3>";
			echo"<div class='mx-auto'>";
            echo "<table  class='table table-bordered'>
                    <tr>
                        <th>şehir</th>
						<th>gün</th>
						<th>Hava Durumu</th>
						<th>resim</th>
						<th>Sıcaklık</th>
						<th>nem</th>
						<th>en yüksek</th>
						<th>en düşük</th>
						<th>Tarih</th>	
                    </tr>";
            
            foreach ($dailyWeather as $day) {
				$weatherImage = $day->icon;
                echo "<tr>";
				echo "<td>$city</td>";
				echo "<td>{$day->day}</td>";
				echo "<td>{$day->description}</td>";
				echo "<td><img src='$weatherImage' alt='{$day->description}' width='40' height='40'></td>";
				echo "<td>{$day->degree}°C</td>";
				echo "<td>%{$day->humidity} <img src='damla.png'  width='20' height='20'></td>";
				echo "<td>{$day->max}°C <img src='max.png'  width='13' height='20'></td>";
				echo "<td>{$day->min}°C <img src='min.png'  width='20' height='20'></td>";

                echo "<td>{$day->date}</td>";         
                echo "</tr>";
            }

            echo "</table>";
			echo"</div>";
			echo"</div>";
			echo"</div>";
			
        } else {
			echo"<div class='w-25 mx-auto rounded-2 text-center mt-4 bg-dark text-white'>";
            echo "<span>Hava durumu verileri alınamadı.</span>";
			echo"</div>";
        }
    }
    ?>
</body>
</html>
