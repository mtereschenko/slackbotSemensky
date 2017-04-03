<?php

namespace app\client;

class GoogleDocsClient
{
    
    private $client;
    
    public function __construct(\Google_Client $googleClient)
    {
        $this->client = $this->getClient($googleClient);
    }
    
    /** 
     * Get google service sheet. Actually 
     * service to getting data
     * @return \Google_Service_Sheets
     */
    public function getGoogleServiceSheetsClient() {
        return new \Google_Service_Sheets($this->client);
    }
    
    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    private function getClient(\Google_Client $googleClient)
    {
        $googleClient->setApplicationName(APPLICATION_NAME);
        $googleClient->setScopes(SCOPES);
        $googleClient->setAuthConfig(CLIENT_SECRET_PATH);
        $googleClient->setAccessType('offline');

        $credentialsPath = $this->expandHomeDirectory();
        if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
        } else {
            $authUrl = $googleClient->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));
            $accessToken = $googleClient->fetchAccessTokenWithAuthCode($authCode);
            $this->saveCredentials($credentialsPath, $accessToken);
        }

        // Exchange authorization code for an access token.
        $googleClient->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($googleClient->isAccessTokenExpired()) {
            $googleClient->fetchAccessTokenWithRefreshToken($googleClient->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($googleClient->getAccessToken()));
        }

        return $googleClient;
    }

    /**
     * Expands the home directory alias '~' to the full path.
     * @param string $path the path to expand.
     * @return string the expanded path.
     */
    private function expandHomeDirectory()
    {
        $homeDirectory = getenv('HOME');
        if (empty($homeDirectory)) {
            $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
        }
        
        return str_replace('~', realpath($homeDirectory), CREDENTIALS_PATH);
    }

    /**  
     * Store the credentials to disk.
     * @param string $credentialsPath
     * @param array $accessToken
     */
    private function saveCredentials($credentialsPath, $accessToken) 
    {
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
    }
}
