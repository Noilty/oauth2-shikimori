# Shikimori Provider for OAuth 2.0 Client
This package provides Google OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

To use this package, it will be necessary to have a Google client ID and client secret. These are referred to as `OAUTH_SHIKIMORI_ID` and `OAUTH_SHIKIMORI_SECRET` in the documentation.

Please follow the [Shikimori instructions][oauth-setup] to create the required credentials.

[oauth-setup]: https://shikimori.me/oauth/applications

## Installation

To install, use composer:

```sh
composer require noilty/oauth2-shikimori
```

## Usage

### to file `knpu_oauth2_client.yaml` need to add client:
```yaml
shikimori_main:
  type: generic
  provider_class: Noilty\OAuth2\Client\Provider\Shikimori
  client_id: '%env(OAUTH_SHIKIMORI_ID)%'
  client_secret: '%env(OAUTH_SHIKIMORI_SECRET)%'
  redirect_route: oauth.shikimori_check
  redirect_params: {}
  use_state: true
```
----
TODO
