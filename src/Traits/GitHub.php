<?php

namespace BucklesHusky\TaskManager\Traits;

use GuzzleHttp\Exception\ConnectException;
use Psr\Log\LoggerInterface;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\SiteConfig\SiteConfig;
use Exception;

trait GitHub 
{
    /**
     * Makes a call to the GitHub api
     * @param string $endpoint API Endpoint url for example repos/octocat/hello-world/pulls/42/
     * @param string $method HTTP Method for the request
     * @param string $body JSON Body to send to the api
     * @param array $params Query string parameters to send to the api
     * @return \Psr\Http\Message\ResponseInterface|bool Boolean false on curl error or ResponseInterface response from GitHub
     */
    public function sendRequest(string $endpoint, string $method, string $body = null, array $params = null)
    {
        $gitToken = Environment::getEnv('GITHUB_TOKEN');

        // if it's empty throw an error
        if (empty($gitToken)) {
            throw new Exception('"GITHUB_TOKEN" is not set in the environment file');
        }

        $service = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.github.com/',
            'headers' => [
                'Authorization' => 'token ' . $gitToken,
                'Content-Type' => 'application/json; charset=utf-8',
                'Accept' => 'application/vnd.github.v3+json',
            ],
        ]);

        $curlOptions = [
            CURLOPT_CONNECTTIMEOUT => 2,
            CURLOPT_TIMEOUT => 17,
            CURLOPT_SSL_VERIFYPEER => !Director::isDev()
        ];

        try {
            $response = $service->request(
                $method,
                $endpoint,
                [
                    'curl' => $curlOptions,
                    'body' => $body,
                    'query' => $params,
                ]
            );
        } catch (ConnectException $e) {
            Injector::inst()->get(LoggerInterface::class)->debug('Did not receive a response from the GitHub API in ' . $curlOptions['CURLOPT_TIMEOUT'] . ' seconds');
            return false;
        }
        
        // var_dump($response->getBody()->getContents()); exit;

        return $response;
    }

    /**
     * Create an issue in the github repo
     *
     * @param string $authUser the github user
     * @param string $repo the repo to create the issue in
     * @param string $issueTitle the issue title
     * @param string $issueContent the issue content
     * @param string|null $pageLink the link to the page
     * @return void
     */
    public function createGitIssue(string $authUser, string $repo, string $issueTitle, string $issueContent, string $pageLink = null)
    {
        // current site config
        $siteConfig = SiteConfig::current_site_config();

        // should the user be assigned
        $assign =  $siteConfig->AssignUserToIssue ? '"assignees":["' . $authUser. '"],' : '';

        // @todo the milestone id should be an option on the form
        $this->sendRequest(
            "repos/$authUser/$repo/issues", 
            'POST', 
            '{"title":"' . $issueTitle . '","body":"' . $issueContent . '",' . $assign . '"milestone":1,"labels":["bug"]}'
        );
    }

    /**
     * @todo use to get the milestones for the form. 
     * This should be used to save in the cms
     * https://docs.github.com/en/rest/issues/milestones
     */
    public function getMilestones(string $authUser, string $repo)
    {
        return $this->sendRequest(
            "repos/$authUser/$repo/milestones", 
            'GET'
        );
    }

    /**
     * https://docs.github.com/en/rest/issues/milestones#create-a-milestone
     */
    public function createMilestone()
    { 
    }

    /**
     * @todo get a list of git issues.
     * https://docs.github.com/en/rest/issues/issues#list-repository-issues
     */
    public function getGitIssues(string $authUser, string $repo)
    {
        
    }
}
