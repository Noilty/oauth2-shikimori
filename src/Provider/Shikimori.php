<?php

declare(strict_types=1);

namespace Noilty\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use League\OAuth2\Client\Provider\AbstractProvider;
use Psr\Http\Message\ResponseInterface;
use Noilty\OAuth2\Client\Exception\HostedDomainException;

class Shikimori extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * @var string $accessType
     */
    protected $accessType;

    /**
     * @var string $hostedDomain
     */
    protected $hostedDomain;

    /**
     * @var string $prompt
     */
    protected $prompt;

    /**
     * @var array $scopes
     */
    protected $scopes = [];

    public function getBaseAuthorizationUrl(): string
    {
        return 'https://shikimori.me/oauth/authorize';
    }

    public function getBaseAccessTokenUrl(array $params): string
    {
        return 'https://shikimori.me/oauth/token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return 'https://shikimori.me/api/users/whoami';
    }

    protected function getAuthorizationParameters(array $options): array
    {
        if (empty($options['hd']) && $this->hostedDomain) {
            $options['hd'] = $this->hostedDomain;
        }

        if (empty($options['access_type']) && $this->accessType) {
            $options['access_type'] = $this->accessType;
        }

        if (empty($options['prompt']) && $this->prompt) {
            $options['prompt'] = $this->prompt;
        }

        // Default scopes MUST be included for OpenID Connect.
        // Additional scopes MAY be added by constructor or option.
        $scopes = array_merge($this->getDefaultScopes(), $this->scopes);

        if (!empty($options['scope'])) {
            $scopes = array_merge($scopes, $options['scope']);
        }

        $options['scope'] = array_unique($scopes);

        $options = parent::getAuthorizationParameters($options);

        unset($options['approval_prompt']);

        return $options;
    }

    protected function getDefaultScopes(): array
    {
        // "openid" MUST be the first scope in the list.
        return [];
    }

    protected function getScopeSeparator(): string
    {
        return ' ';
    }

    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if (empty($data['error'])) {
            return;
        }

        $code = 0;
        $error = $data['error'];

        if (is_array($error)) {
            $code = $error['code'];
            $error = $error['message'];
        }

        throw new IdentityProviderException($error, $code, $data);
    }

    protected function createResourceOwner(array $response, AccessToken $token): ShikimoriUser
    {
        $user = new ShikimoriUser($response);

        $this->assertMatchingDomain($user->getHostedDomain());

        return $user;
    }

    /**
     * @param ?string $hostedDomain
     *
     * @throws HostedDomainException If the domain does not match the configured domain.
     */
    protected function assertMatchingDomain(?string $hostedDomain): void
    {
        if ($this->hostedDomain === null) {
            // No hosted domain configured.
            return;
        }

        if ($this->hostedDomain === '*' && $hostedDomain) {
            // Any hosted domain is allowed.
            return;
        }

        if ($this->hostedDomain === $hostedDomain) {
            // Hosted domain is correct.
            return;
        }

        throw HostedDomainException::notMatchingDomain($this->hostedDomain);
    }
}