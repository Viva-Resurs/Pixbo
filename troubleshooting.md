# Just a file for various problems & solutions that may occur

Problem: Fail to login
Response:
'me' 500 Internal Server Error
	The token could not be parsed from the request
'login' 200 OK -
	Warning: "Cannot modify header information - headers already sent"
	Deprecated:  Automatically populating $HTTP_RAW_POST_DATA is deprecated ...
	... set 'always_populate_raw_post_data' to '-1' in php.ini ...
Solution:
	uncomment this line in php.ini
	;always_populate_raw_post_data = -1

Problem: Outdated migration/seeds
Solution:
  run 'composer dump-autoload' to refresh migrations and seeds
