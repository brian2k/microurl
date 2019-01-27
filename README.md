# microurl
URL shortener in PHP


### Requires config.php with:
$servername<br>
$username<br>
$password<br>
$dbname



### Features:
- Shortens URL based on the Webservers Address
- Counts the access on each URL
- Shows statistics by addine a '-' (minus) to the end of the shortened URL
- Generates a random Token (6 chars - individual)
- Validates URL (must contain 'http://' and no spaces etc.) with filter_var()
- Changes Background based on the amount of images in 'bg' folder

## Coming soon
- Responsive Design for mobile
- Auto-Copy-to-Clipboard
- Delete URL after a certain time (JS based, since some have shared servers)
- Pagespeed improvements



