Introduction
===========
Payment gateway integration in a symfony project. Now it supports only shift4 & aci, gradually we will try to add more payment gateway. 

Requirements
===========
1. Docker, Docker compose

Installation
===========

### Build & start container docker

```
sudo docker compose up --build -d
```

### Access container's bash (/var/www/html directory)

```
sudo docker exec -it -w /var/www/html dc.pgi_ubuntu bash
```

### Install packages via composer

```
composer install
```

Usage
===========

We have used 453 port. Common 443 port can be occupied by other projects. So after installation, you can access project by browsing https://127.0.0.1:453

#### Endpoints
1. /api/v1/payment/{paymentType} (now only shift4 & aci are supported as paymentType)

Sample parameters

```
{
    "amount": 123,
    "currency": "EUR",
    "cardNumber": "4242424242424242",
    "cardExpYear": 2032,
    "cardExpMonth": "12",
    "cardCvv": "111"
}
```

### CLI Command
We have added any console command named `app:payment` which can be used to complete payment from terminal. We need to pass all the arguments for running it properly. First argument will be paymentType. Then we can pass all other arguments as a key value pair like `amount:456`
```
php bin/console app:payment aci amount:456 currency:EUR cardNumber:4242424242424242 cardExpYear:2036 cardExpMonth:05 cardCvv:255
```

### Stop container

```
sudo docker compose down
```


### Testing

```
php bin/phpunit
```

### Notes
You can also run it without docker. In that case, you need `PHP 8`.
