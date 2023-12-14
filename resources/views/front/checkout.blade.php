<x-front-layout title="Checkout">
    @push('css-files')
        <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}" />
    @endpush
    <x-slot:breadcrumb>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">checkout</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="{{ route('products.index') }}">Shop</a></li>
                            <li>checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:breadcrumb>

    <section class="checkout-wrapper section">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="panel" style="background-color: #c2c5e7; padding:70px; border-radius:20px">
                        <div class="checkout-steps-form-style-1">
                            <form action="{{ route('checkout.store') }}" method="post">
                                @csrf
                                <ul id="accordionExample">
                                    <li>
                                        <h4 class="title" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="true" aria-controls="collapseThree" style="cursor: pointer;">
                                            Your Personal Details
                                            &nbsp;
                                            <span style="width: 3%;">
                                                <svg viewBox="0 0 16 16">
                                                    <path
                                                        d="M8,8.00024l-8,-8h3.9999l4.0001,4l3.9999,-4.00024l4.0001,0.000244Z"
                                                        transform="translate(0 4)" />
                                                </svg>
                                            </span>
                                        </h4>

                                        <section class="checkout-steps-form-content collapse show" id="collapseThree"
                                            aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">User Name</label>
                                                        <div class="row">
                                                            <div class="col-md-6 form-input form">
                                                                <x-form.input name="addresses[billing][fname]"
                                                                    placeholder="First Name" />
                                                            </div>
                                                            <div class="col-md-6 form-input form">
                                                                <x-form.input name="addresses[billing][lname]"
                                                                    placeholder="Last Name" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">Email address</label>
                                                        <div class="form-input form">
                                                            <x-form.input name="addresses[billing][email]" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">Phone Number</label>
                                                        <div class="form-input form">
                                                            <x-form.input name="addresses[billing][phone_number]" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">Mailing addresses</label>
                                                        <div class="form-input form">
                                                            <x-form.input name="addresses[billing][street_address]" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">City</label>
                                                        <div class="form-input form">
                                                            <x-form.input name="addresses[billing][city]" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">Post Code</label>
                                                        <div class="form-input form">
                                                            <x-form.input name="addresses[billing][postal_code]" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">Country</label>
                                                        <div class="select-items">
                                                            <x-form.select name="addresses[billing][country]"
                                                                style="" class="form-select" :options="$countries"
                                                                selected="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 mt-2">
                                                    <label for="checkbox-3" style="font-weight: 450;">
                                                        <input type="checkbox" id="checkbox-3">
                                                        &nbsp; My delivery and mailing addresseses are the same.
                                                    </label>
                                                </div>
                                            </div>
                                            <hr class="mb-4" style="color: #0b1cdd;">
                                        </section>
                                    </li>
                                    <li>
                                        <h4 class="title collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFour" aria-expanded="false"
                                            aria-controls="collapseFour" style="cursor: pointer;">
                                            Shipping addresses
                                            &nbsp;
                                            <span style="width: 3%;">
                                                <svg viewBox="0 0 16 16">
                                                    <path
                                                        d="M8,8.00024l-8,-8h3.9999l4.0001,4l3.9999,-4.00024l4.0001,0.000244Z"
                                                        transform="translate(0 4)" />
                                                </svg>
                                            </span>
                                        </h4>

                                        <section class="checkout-steps-form-content collapse" id="collapseFour"
                                            aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">User Name</label>
                                                        <div class="row">
                                                            <div class="col-md-6 form-input form">
                                                                <x-form.input name="addresses[shipping][fname]"
                                                                    placeholder="First Name" />
                                                            </div>
                                                            <div class="col-md-6 form-input form">
                                                                <x-form.input name="addresses[shipping][lname]"
                                                                    placeholder="Last Name" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">Email addresses</label>
                                                        <div class="form-input form">
                                                            <x-form.input name="addresses[shipping][email]" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">Phone Number</label>
                                                        <div class="form-input form">
                                                            <x-form.input name="addresses[shipping][phone_number]" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">Mailing addresses</label>
                                                        <div class="form-input form">
                                                            <x-form.input name="addresses[shipping][street_address]" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">City</label>
                                                        <div class="form-input form">
                                                            <x-form.input name="addresses[shipping][city]" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">Post Code</label>
                                                        <div class="form-input form">
                                                            <x-form.input name="addresses[shipping][postal_code]" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <div class="single-form form-default">
                                                        <label style="font-weight: 450;">Country</label>
                                                        <div class="select-items">
                                                            <x-form.select name="addresses[shipping][country]"
                                                                style="" class="form-select" :options="$countries"
                                                                selected="" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="checkout-payment-option">
                                                        <h6 class="heading-6 font-weight-400 payment-title">Select
                                                            Delivery
                                                            Option</h6>
                                                        <div class="payment-option-wrapper">
                                                            <div class="row mb-2">
                                                                <div class="col-md-6">
                                                                    <label style="font-weight: 450;" for="shipping-1">
                                                                        <div>
                                                                            <x-form.radio name="shipping" checked
                                                                                id="shipping-1" :options="['Standerd Shipping']" />
                                                                            <span class="price">$10.0</span>
                                                                            <img src="data:image/webp;base64,UklGRrYAAABXRUJQVlA4TKoAAAAvO8AHAJdgpm2b8cc3GuvZ7AsNBW3bsDh9m4K2bZjyRzkSv902/7FYSgKEWroPedfQlwQIjZ4AoZbygZAAJTBy28aRt2ba7mT8/99u95z2FtH/CcBPvzhvq1X2YnyuBDvf+ricb5BcZYyPzVKbVAY73gKw11HkfH8w1KBifFdlsJ6A/kq6KkmuAPGsAEkK8AykBgCegdQgbcyJ8RCZE4sWorvhNLrbKPYbAw=="
                                                                                alt="Sipping"
                                                                                data-pagespeed-url-hash="4092129372"
                                                                                onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label style="font-weight: 450;" for="shipping-2">
                                                                        <div>
                                                                            <x-form.radio name="shipping" checked
                                                                                id="shipping-2" :options="['Standerd Shipping']" />
                                                                            <span class="price">$10.0</span>
                                                                            <img src="data:image/webp;base64,UklGRuoBAABXRUJQVlA4TN4BAAAvO8AHEM/juG0jSVLNPjd/YHPaeO5qW2kwaBvJkb/gef7M+m8YtG0jyH0Kj+n5I/qFINumCPOnvMHjeX4nRCEMkRCEqBAVIQxBYGbhwqzZgVIIxEaYRbWJEAgy5rbkO+AxSOhsIMZvUmPZOJORU2qEIDCDiCEwF1xOZjDCYP3tP4KSZsv7P8JIfCYCOYNANAlKQROxFMJGFIRADM1xaApBGCIiWgTGuO88jncs6/XdXn9MBti2badqcHd3qJe6C3Xq7u7umnJKv/+chDsGbzwlEf1nG7BtG2JLIel6BFSTUi1MzqAAn4mIdLArAwmwgh+dPNoUfmYCfu77QanODyblWxaGscqvp+kdA5Y0ybLPKlAHricMmIL0K5Pyq9vxgDXOrJr0Py/gFtVh3kKnk/b8FRmmYQ2dXqJaH5s3r5VS49D1yaQ8sBT50dNhjqDT94DmT0jJOxtsX0p5HkkeSxEXUfchBqzoKmiSo6eBLMEueTTtdMxhQBxC6FT02meViGgvrVpeoAwGHkQz8z5m2MCAPYv1FANWdcvCedtpnKFdMwXCUPO6oNPHUQuMku0QgUUMuLHCxLdAj4m+AqXcRshZJU+9Tw8qhw1iYMxjAG6HVCvfy5PmG/xV996oWakE"
                                                                                alt="Sipping"
                                                                                data-pagespeed-url-hash="91661997"
                                                                                onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-2">
                                                                <div class="col-md-6">
                                                                    <label style="font-weight: 450;" for="shipping-3">
                                                                        <div>
                                                                            <x-form.radio name="shipping" checked
                                                                                id="shipping-3" :options="['Standerd Shipping']" />
                                                                            <span class="price">$10.0</span>
                                                                            <img src="data:image/webp;base64,UklGRlwFAABXRUJQVlA4TE8FAAAvO8AHEI2Yads21Xb7HNH/KH5MBAJJ/pQjjCOQTXGL5ASSNuufckH20/8oWmJnHcBC17Zt07bV+tzH6VWqiP/g+936At8b+ZmR9z5rBJvvKm7P9nxGkVRb27It+7rf9/twy0AG6EEBtwYw/cnhMvMUrjFcR7/wfs8tsbZtU3vmvu+PnRKSIqwm2JULsipIAbb14W5ZsG2bdrRO3LZt27Zt87RjnHfb0c2teue9th0nX135sm3btu3cCQDic/3BF5dH7/z7+yKdS5X8/3Ceaih/Mmjk+MOzCsa0QMYrlJJ+qYN7v0L74/f38QdnL1VXHaY5k1ZMKsGvx+3kndP7qyhL1jof+QmZTMzA53E6euvU5kxRRbYTcFFYyibeEFmr6EPy48LjK5pH/72ypCgSugQCFlLYmj1JFR/AZIl9l+5tKZ3Tsm0E7xUMlrOgV1IBA0d2Xk/c2JlWzHkUyBcEFrPK97V9vyWXpDb3InchG5asINNUhbmoy5Gf72dAmdur1ZLdyvvEwf7FIiV+6yFA0tVT98nRT5dnQsliqx9ZWUZHslSAItuRXE5HiswhMKcoTsdy3+ldrtD/9rsuPP720r9BCNx6PBiQCiV6kqmc7H2WoGfnxIlh4+W7kB4soTcFbcX3jfUeCZpffvlhyGh9XD/yCoZWODn/wKWbWjB7l1lQ1TpkxofdiWv7TGMYw6TswKLwrxk3Fzp7avfirFbj20ahSgMJTQEpUoqbYXPr2hN7kI89OjO//a9lJddV1B2uWJ0LCTtY4KL7buRWgyHLlCar9NAn0xTmqWhJxZ/9IcEA4PWmBQYkljBavyWILMCEpgIKkoIJWguf7Fvfh2xH2bU/nXdpy0Xq6amu5EBkLxAX3X/dlZblN2hZIQfynQqHYZ4qMiti8xoSCIAyVE0t9Nv/v9Mh0KBMQQIUpIok+JriVPPWFBrunH1BTtw7/aeSOy57cGu/bmr5ClpoWfUOndhEJ7RGk9+Rs6qQsK4nx3QOLG0TezoLIoq01eO1vqbmFunRMy+cVHbgi0nrO4kmpsgG0qgSIIV24mQ6mwAnPpy0KOPOUu/Oq50w2qGXl+Cn0Ow00gaVQmQN15LESo3TDF1ArO5FyIceKK3SpQLtXbWLfgLPtQqrDl+qxnamjmxTXPzSloRTN9P/B6Pjq0qskM+QA4NOD/8LBkpA+xQqwqtRwmqELwXtCtOXOLVl6h9GatHRppGLTIXyGQyI0G7v9gT8+WsqbBC+VGshX1kZVu/2PAwNi4wZUjXsdDLPkLRhijy9qIYz2ABCu7OD+DUJy8CXgmr0p+j67UpiGyKGtCedfXPGRaRzCeZbxF9ZhF5gaPVITOZaQv9UklaRSGcAxmuNBQhNgID/dBL8Y4kIrz5L8B6whBt2mRfO0WtpMyuuOJ+RXb+IxE+650CGjvH+7cX13diH7bAs7YYqYyajtGs3wP7z10xhBFcapirkLM2Y8y/cGFZz6WhxooyJGTSrZmfGqMVMnoHhjk4YphnbNnyhX6EAdqS6v9rWjDEmKle1s6KibQTC52GWGNI0CSTQpSvCqxaMxrXAJ0ok1ehBUM5RyPzMBeELYC74O3f9x+eEShxSbSDwg1qIX5OwCq40/EBrCybv9Nutf/n4Qs943uVehjMhR9A7XY+tg95W5R/K9Qcq9uP9q7nwAbp9rKFid15+JGK6Ujn14Y7GyO0EkLjd9bIa7kC9q/3gwPbR5rYR6wysSh+ceZmd5Adpof8AqaiJ3vkDUlz1J5DtRwjy+v+192B4JLpK+GQ6PBomg71PKFTf/XyDwVAQoMUnFwZ9lgIA"
                                                                                alt="Sipping"
                                                                                data-pagespeed-url-hash="386161918"
                                                                                onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label style="font-weight: 450;" for="shipping-4">
                                                                        <div>
                                                                            <x-form.radio name="shipping" checked
                                                                                id="shipping-4" :options="['Standerd Shipping']" />
                                                                            <span class="price">$10.0</span>
                                                                            <img src="data:image/webp;base64,UklGRuoDAABXRUJQVlA4TN0DAAAvO8AHADXRzf9/nRS1hbu7uztE7u7uTuTu7u6wvti6u/vo6n/+u89/GsBCSymBEDZFCyAkIyPcHpACyCZCUlKizaGA6WJD3J10Y+Du4qvBXTuYNj4hBZykdxVcBfY9S5H4rKmfA0mSFDWc5y64u7MgUZJk07ZyPvzatm3btu17n23br/8TEARPj+5qyT/BfrECJV51adT+pomyd0okzj7qvQuMz21KBP/ime47W5S9ViL4Vk+dplsc8uinOHsXkL+RJl+FIo9+BUb/eCAw+g/4lS+tNuMGrwK9d57Nes6vfBoY/RVKkP8mx7aV11qn2Z48/qkA4uyz6aGHdD6ZDvPVwOg3hGyzntUKqTqf9DV7OTzbG+2QQYaPEnH2AQIPKF6aHju0QtLyW/l+AJ7traW/RDJ8FEmTLxC+KH9/1nI7Lo//4ZzWL410vlnnoKwrrzVELpMDcEuQokiORqPRCMCzuyIyeJaC24n0ojqKDEVkZGRkTupgT7j8qComwM/k1EXkOFtT4EgcysGD5aIB9ckPK4w/4XEhjugCr0D/tUIKUUDxkk8gY0UbcbwqTYQ1eIe1BUAp2BKwQNSjEu24DHjTiVrUYBQBxO4oLDbwEafviWg9HxksJQUpLeKSGhFc7WHT6QtLRg5YRuzwIbd4VpxisFbE7khDXvzKF/aLZfPd0Mprw4pbldG51Xo96Tzd/Ro+9X0iksU/+TUE6A+bLjg8yQ6bJqKz4g5mwWozW7C/AAtiY3fchyh75zhfv2tybDc6N5sce2xWk27DiTT5Bp/6ARG5jEfhmgebjKFg0flEXrGNlect1g8A6lSsjooqQBNGognD9xgRaYVkt+E8QtJz40ZVeiHiDNsHIDdJgBHNKE1SWBnCE+SfdkgjIt1PlldzKyI2IKwZ8akJ4EFc8QYOAlJKiShndnSGF0xO3UTm+8FAfxBxgVSANWc837FJaLHt/E/DScdHvkTl5n9e3s09Iv1XUWD0i2u7uoZQqVsD6KKejQnqnnDAlaMJYNGDwd+NxffstxLCXKAbz1IIXjA6txA5Tbe58GorXqmAQF6p8ErFBZyy5CAAbP7KARWAD99U4Fc+s1lNW21HYyDKP+i980n7mxGQv+ISsk99f+WlnozOrS8AeDcPHpPBs3iLwGJs1tOk8810nuyC07d6rPfOI/1XoX/5SlCS9JvRucnk2OHen62Hwh8sdkO09JfwmTz+I6D1P4LnI+CB3XJp+a1C+5tutRnz7G5k8Q+h8D7gPN1H2EOy+Lsk/RIjPJ/6oVZIEmXvOJRSlL95bnbog9I+OnH6gfK4jofkNpxC6AA="
                                                                                alt="Sipping"
                                                                                data-pagespeed-url-hash="680661839"
                                                                                onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mb-4" style="color: #0b1cdd;">
                                        </section>
                                    </li>
                                    <li>
                                        <h4 class="title collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapsefive" aria-expanded="false"
                                            aria-controls="collapsefive" style="cursor: pointer;">Payment Info
                                            &nbsp;
                                            <span style="width: 3%;">
                                                <svg viewBox="0 0 16 16">
                                                    <path
                                                        d="M8,8.00024l-8,-8h3.9999l4.0001,4l3.9999,-4.00024l4.0001,0.000244Z"
                                                        transform="translate(0 4)" />
                                                </svg>
                                            </span>
                                        </h4>
                                        <section class="checkout-steps-form-content collapse" id="collapsefive"
                                            aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <label style="font-weight: 450;">Cardholder Name</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="cardholder-name" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label style="font-weight: 450;">Card Number</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="card-number"
                                                            placeholder="0000 0000 0000 0000" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label style="font-weight: 450;">Expiration</label>
                                                    <div class="row">
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input name="exp-m" placeholder="MM" />
                                                        </div>
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input name="exp-y" placeholder="YYYY" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label style="font-weight: 450;">CVC/CVV <span><i
                                                                class="mdi mdi-alert-circle"></i></span></label>
                                                    <div class="form-input form">
                                                        <x-form.input name="cvc-cvv" placeholder="****" />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mb-4" style="color: #0b1cdd;">
                                        </section>
                                    </li>
                                    <div class="checkout-sidebar-coupon mt-4">
                                        <form action="#">
                                            @csrf
                                            <p>Appy Coupon to get discount!</p>
                                            <x-form.input name="coupon-code" placeholder="Coupon Code" />
                                            <button class="btn btn btn-outline-primary mt-2 mb-4"
                                                type="submit">apply</button>
                                        </form>
                                    </div>
                                    <br>
                                    <div class="steps-form-btn button">
                                        <div class="button">
                                            <button class="btn btn-outline-primary" type="submit"
                                                style="font-size: large">Pay Now</button>
                                        </div>
                                    </div>
                                </ul>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            </form>
        </div>
    </section>


    @push('js-files')
        <script type="text/javascript" data-pagespeed-no-defer="">
            pagespeed.lazyLoadImages.overrideAttributeFunctions();
        </script>
        <script src="{{ asset('assets/js/bootstrap.min.js.pagespeed.jm.R6pdwTt0pj.js') }}"></script>
        <script src="{{ asset('assets/js/tiny-slider.js+glightbox.min.js+main.js.pagespeed.jc.MCgBCVbLAV.js') }}"></script>
        <script>
            eval(mod_pagespeed_Zp_OOsHKoc);
        </script>
        <script>
            eval(mod_pagespeed_5TvwT_lz9K);
        </script>
        <script>
            eval(mod_pagespeed_uoja0BW_wo);
        </script>
    @endpush
</x-front-layout>
