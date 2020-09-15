Hyve Mobile Importer
-
1. composer update
2. CLI: php /src/importer/client/index.php
3. API Post Endpoint: https://import.tsekcorona.co.za/process
4. Environment vars in /src/utils/.env
5. Importer sends all data to GoLang API

Components
- DotEnv Loader
- League CSV package for CSV Manipulation
- Nestbot/Carbon package for Time Manipulation
- utils\Importer does main processing

Processing
- Timezones
- Notes are UTF-8 encoded if UTF-8 or out through htmlspecialchars if not
- Images get created under the '/card' directory and the base64 encoded string is set in the post data to the API 



