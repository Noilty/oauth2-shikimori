<?php

declare(strict_types=1);

namespace Noilty\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class ShikimoriUser implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var array
     */
    protected $response;

    /**
     * @param array $response
     */
    public function __construct(array $response = array())
    {
        $this->response = $response;
    }

    /**
     * @return ?string
     */
    public function getId(): ?string
    {
        return (string) $this->getValueByKey($this->response, 'id');
    }

    /**
     * @return ?string
     */
    public function getNickname(): ?string
    {
        return $this->getValueByKey($this->response, 'nickname');
    }

    /**
     * @return ?string
     */
    public function getAvatar(): ?string
    {
        return $this->getValueByKey($this->response, 'avatar');
    }

    /**
     * @return ?array
     */
    public function getImage(): ?array
    {
        return $this->getValueByKey($this->response, 'image');
    }

    public function getLastOnlineAt(): \DateTimeImmutable
    {
        return $this->getValueByKey($this->response, 'last_online_at');
    }

    /**
     * @return ?string
     */
    public function getEmail(): ?string
    {
        return $this->getValueByKey($this->response, 'email');
    }

    /**
     * @return ?string
     */
    public function getUrl(): ?string
    {
        return $this->getValueByKey($this->response, 'url');
    }

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->getValueByKey($this->response, 'name');
    }

    /**
     * @return ?string
     */
    public function getSex(): ?string
    {
        return $this->getValueByKey($this->response, 'sex');
    }

    /**
     * @return ?string
     */
    public function getWebsite(): ?string
    {
        return $this->getValueByKey($this->response, 'website');
    }

    /**
     * @return ?\DateTimeImmutable
     */
    public function getBirthOn(): ?\DateTimeImmutable
    {
        return $this->getValueByKey($this->response, 'birth_on');
    }

    /**
     * @return ?int
     */
    public function getFullYears(): ?int
    {
        return $this->getValueByKey($this->response, 'full_years');
    }

    /**
     * @return ?string
     */
    public function getLocale(): ?string
    {
        return $this->getValueByKey($this->response, 'locale');
    }

    /**
     * @param string $domain
     *
     * @return ResourceOwner
     */
    public function setDomain($domain): ResourceOwner
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->response;
    }

    public function getHostedDomain()
    {
        //
    }
}