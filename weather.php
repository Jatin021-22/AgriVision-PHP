<?php
session_start();
$weatherData = null; 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $city = htmlspecialchars($_POST['city']); 
    $apiKey = '717aa625d6e9f10a7d41c3de8f46c990'; 
    $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

   try {
       
        $response = file_get_contents($url);

        if ($response === FALSE) {
            throw new Exception("Failed to retrieve data from the API.");
        }

        
        $weatherData = json_decode($response, true);

       
        if (!$weatherData || $weatherData['cod'] != 200) {
            throw new Exception("City not found or invalid API response.");
        }
    } catch (Exception $e) {
       
        $weatherData = null; 
        $error = $e->getMessage(); 
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <link rel='stylesheet' href='https://unpkg.com/boxicons@latest/css/boxicons.min.css'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Weather Forecast</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <style>
        
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('.\uploads\img2\pexels-fotios-photos-1107717.jpg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
          
            margin: 0;
            
            justify-content: center;
            
        }

        .container1 {
            margin-top:130px;
            margin-left:500px;
            margin-bottom:100px;
            max-width: 600px; 
            padding: 20px;
            background-color: rgba(247, 248, 249, 0.9); 
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(33, 99, 253, 0.3);
            transition: transform 0.3s, box-shadow 0.3s; 
        }

        .container1:hover {
            transform: translateY(-5px); 
            box-shadow: 0 8px 20px rgba(18, 69, 196, 0.69); 
        }

        h2 {
            margin-bottom: 20px;
            
            color: #007bff; 
            text-align: center; 
            font-size: 24px;
        }

        .weather-card {
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            background-color: #f8f9fa; 
            transition: transform 0.3s, background-color 0.3s; 
        }

        .weather-card:hover {
            background-color: #e2e6ea; 
            transform: scale(1.02); 
        }

        .data-label {
            font-weight: bold;
        }

        .form {
            width: 100%;
            padding: 12px; 
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease; 
        }

        .form:focus {
            border-color: #007bff; 
            box-shadow: 0 0 5px rgba(0, 123, 255, .5); 
            outline: none; 
        }

        .botton {
            width: 100%; 
            background-color: #007bff;
            color: white;
            padding: 12px; 
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s; 
        }

        .botton:hover {
            background-color: #0056b3; 
            transform: translateY(-2px);
        }

        /* Responsive Styles */
        @media (max-width: 600px) {
            .container1 {
                max-width: 90%;
            }

            .form,
            .botton {
                font-size: 14px; 
                padding: 10px;
            }
        }
    </style>
</head>
<?php// include 'header.php';?>
<body>
<?php include ('header.php'); ?>

<!-- ***** Breadcrumb Area Start ***** -->
<div class="breadcrumb-area">
    <div class="container h-100">
        <div class="row h-100 align-items-end">
            <div class="col-12">
                <div class="breadcumb--con">
                    <h4 style="font-size:40px;color:#5eb4ee;">Weather </h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Weather</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Background Curve -->
    <div class="breadcrumb-bg-curve">
        <img src="./img/core-img/curve-5.png" alt="">
    </div>
</div>

    <div class="container1">
  
        <h2>  <i class="bi bi-cloud rotate" style="color: #3498db;  text-shadow: 0 0 5px rgb(119, 177, 238); margin-right:20px; font-size:40px;"></i>                Weather Forecast</h2>

        <form method="POST">
            <div class="form-group">
                <input type="text" name="city" class="form" placeholder="Enter city name" required>
            </div>
            <button type="submit" class="botton" data-toggle="tooltip" title="Click to get weather for the city!">Get Weather</button>
        </form>

        <?php if ($weatherData): ?>
            <div class="weather-card">
                <h5>Weather in <?php echo htmlspecialchars($city); ?></h5>
                <p class="data-label"><i class="bi bi-thermometer" style="color: #3498db;  text-shadow: 0 0 5px rgb(119, 177, 238); margin-right:10px;"></i>Temperature: </p>
                <p><?php echo $weatherData['main']['temp']; ?> °C</p>
                
                <p class="data-label"><i class="bi bi-droplet" style="color: #3498db;  text-shadow: 0 0 5px rgb(119, 177, 238); margin-right:10px;" ></i> Humidity: </p>
                <p><?php echo $weatherData['main']['humidity']; ?> %</p>
                
                <p class="data-label"><i class="bi bi-speedometer" style="color: #3498db;  text-shadow: 0 0 5px rgb(119, 177, 238); margin-right:10px;"></i>Pressure: </p>
                <p><?php echo $weatherData['main']['pressure']; ?> hPa</p>
                
                <p class="data-label"><i class="bi bi-stickies" style="color: #3498db;  text-shadow: 0 0 5px rgb(119, 177, 238); margin-right:10px;"></i>Description: </p>
                <p><?php echo ucfirst($weatherData['weather'][0]['description']); ?></p>
                
                <p class="data-label"><i class="bi bi-wind" style="color: #3498db;  text-shadow: 0 0 5px rgb(119, 177, 238); margin-right:10px;"></i>Wind Speed: </p>
                <p><?php echo $weatherData['wind']['speed']; ?> m/s   (   1 mile ≈ 1.6 km)</p>
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <div class="alert alert-danger" role="alert">
                City not found. Please try again.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'footer.php';?>