<x-front-layout title="Order Payment">
    <section class="p-4 p-md-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-5">
                <div class="card rounded-3">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h3>Order Payment</h3>
                        </div>
                        <form action="{{ route('stripe.return', $order) }}">
                            <p class="fw-bold mb-4 pb-2">Saved cards:</p>

                            <div class="d-flex flex-row align-items-center mb-4 pb-1">
                                <img class="img-fluid"
                                    src="https://img.icons8.com/color/48/000000/mastercard-logo.png" />
                                <div class="flex-fill mx-3">
                                    <div class="form-outline">
                                        <input type="text" id="formControlLgXc" class="form-control form-control-lg"
                                            value="**** **** **** 3193" />
                                        <label class="form-label" for="formControlLgXc">Card Number</label>
                                    </div>
                                </div>
                                <a href="#!">Remove card</a>
                            </div>

                            <div class="d-flex flex-row align-items-center mb-4 pb-1">
                                <img class="img-fluid" src="https://img.icons8.com/color/48/000000/visa.png" />
                                <div class="flex-fill mx-3">
                                    <div class="form-outline">
                                        <input type="text" id="formControlLgXs" class="form-control form-control-lg"
                                            value="**** **** **** 4296" />
                                        <label class="form-label" for="formControlLgXs">Card Number</label>
                                    </div>
                                </div>
                                <a href="#!">Remove card</a>
                            </div>

                            <p class="fw-bold mb-4">Select Country:</p>

                            <div class="form-outline mb-4">
                                <x-form.select name="country" style="" class="form-select" :options="$countries"
                                    selected="" />
                            </div>

                            <div class="row mb-4">
                                <div class="col-7">
                                    <div class="form-outline">
                                        <input type="text" id="formControlLgXM" class="form-control form-control-lg"
                                            value="1234 5678 1234 5678" />
                                        <label class="form-label" for="formControlLgXM">Card Number</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-outline">
                                        <input type="password" id="formControlLgExpk"
                                            class="form-control form-control-lg" placeholder="MM/YYYY" />
                                        <label class="form-label" for="formControlLgExpk">Expire</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-outline">
                                        <input type="password" id="formControlLgcvv"
                                            class="form-control form-control-lg" placeholder="Cvv" />
                                        <label class="form-label" for="formControlLgcvv">Cvv</label>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-success btn-lg btn-block" type="submit">Pay Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="https://js.stripe.com/v3/"></script>

    <script>
        // This is your test publishable API key.
        const stripe = Stripe("{{ config('services.stripe.publishable_key') }}");

        let elements;

        initialize();
        document
            .querySelector("#payment-form")
            .addEventListener("submit", handleSubmit);

        let emailAddress = '';

        // Fetches a payment intent and captures the client secret
        async function initialize() {
            try {
                const {
                    clientSecret
                } = await fetch("{{ route('stripe.paymentIntet.create', $order) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: {
                        "_token": "{{ csrf_token() }}"
                    }
                }).then((r) => r.json());
            } catch (e) {
                console.log(e.message)
            }

            elements = stripe.elements({
                clientSecret
            });


            // const linkAuthenticationElement = elements.create("linkAuthentication");
            // linkAuthenticationElement.mount("#link-authentication-element");

            // const paymentElementOptions = {
            //     layout: "tabs",
            // };

            const paymentElement = elements.create("payment", paymentElementOptions);
            paymentElement.mount(
                "#payment-element");
        }

        async function handleSubmit(e) {
            e.preventDefault();
            setLoading(true);

            const {
                error
            } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    // Make sure to change this to your payment completion page
                    return_url: "{{ route('stripe.return', $order) }}",
                    receipt_email: emailAddress,
                },
            });

            // This point will only be reached if there is an immediate error when
            // confirming the payment. Otherwise, your customer will be redirected to
            // your `return_url`. For some payment methods like iDEAL, your customer will
            // be redirected to an intermediate site first to authorize the payment, then
            // redirected to the `return_url`.
            if (error.type === "card_error" || error.type === "validation_error") {
                showMessage(error.message);
            } else {
                showMessage("An unexpected error occurred.");
            }

            setLoading(false);
        }

        // ------- UI helpers -------

        function showMessage(messageText) {
            const messageContainer = document.querySelector("#payment-message");

            messageContainer.style.display = "block";
            messageContainer.textContent = messageText;

            setTimeout(function() {
                messageContainer.style.display = "none";
                messageContainer.textContent = "";
            }, 4000);
        }

        // Show a spinner on payment submission
        function setLoading(isLoading) {
            if (isLoading) {
                // Disable the button and show a spinner
                document.querySelector("#submit").disabled = true;
                document.querySelector("#spinner").style.display = "inline";
                document.querySelector("#button-text").style.display = "none";
            } else {
                document.querySelector("#submit").disabled = false;
                document.querySelector("#spinner").style.display = "none";
                document.querySelector("#button-text").style.display = "inline";
            }
        }
    </script>
</x-front-layout>
