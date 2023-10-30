<?php

include 'vendor/autoload.php';

#$weatherUrl = 'https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/37207?unitGroup=us&key=A4XMMX8RAXQCLDDS6C7BFCDXT&contentType=json';

# write a php script that will fetch json from the above $weatherUrl and print the json response using the symfony/http-client
# ask me for my zipcode and set it to a variable $zipcode
# append the $zipcode to the $weatherUrl
# print the current temp for the zipcode
$zipcode = $_GET['zipcode'] ?? '37207';
$weatherUrl = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/$zipcode?unitGroup=us&key=A4XMMX8RAXQCLDDS6C7BFCDXT&contentType=json";

$client = \Symfony\Component\HttpClient\HttpClient::create();
$response = $client->request('GET', $weatherUrl);
$json = $response->toArray();
print_r($json['days'][0]['temp']);
#run php built in webserver
#php -S localhost:8000

?>
<form>
<input type="text" name="zipcode" id="zipcode" value="<?php echo $zipcode ?>">
<button type="submit">Submit</button>
</form>
