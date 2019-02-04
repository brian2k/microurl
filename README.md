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
- Responsive Design for mobile
- Pagespeed improvements

### Coming soon
- Auto-Copy-to-Clipboard
- Delete URL after a certain time (JS based, since some have shared servers)
- Keeping the token after refreshing
- favicon
- dynamic background images (just drop JPEG images in the 'bg' folder)
- dynamic tablename
- separate JS/PHP code completely from content
