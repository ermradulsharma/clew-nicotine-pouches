<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    var grand_total = {{ round(($carts->sum('total_discount_amount') + $shipping_price - $couponDiscount) * 100) }};
    // var grand_total = {{ number_format($carts->sum('total_discount_amount') + $shipping_price - $couponDiscount, 2) * 100 }}
    var stripe = Stripe(
        'pk_test_51QSXq0A0EWZCPdAMW4NQqgBIhRHHeaYR4fbdSy8PLeV9qlvOlifRy9j8Uspp21YRc2yCALmqLdcqXaFKabgqi6PP00HpuPXtjE'
    );

    var options = {
        mode: 'payment',
        amount: parseInt(grand_total),
        currency: 'usd',
        paymentMethodCreation: 'manual',
        appearance: {
            /*...*/
        },
    };
    var elements = stripe.elements(options);
    var paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    var form = document.getElementById('payment-form');
    var submitBtn = document.getElementById('submit');

    var handleError = (error) => {
        const messageContainer = document.querySelector('#error-message');
        messageContainer.textContent = error.message;
        submitBtn.disabled = false;
    }

    form.addEventListener('submit', async (event) => { 
        event.preventDefault();
        if (submitBtn.disabled) return;
        submitBtn.disabled = true;
        const {
            error: submitError
        } = await elements.submit();
        if (submitError) {
            handleError(submitError);
            return;
        }

        var first_name = document.getElementById("first_name").value;
        var address = document.getElementById("address").value;
        var city = document.getElementById("city").value;
        var stateEl = document.getElementById("state");
        var state = stateEl.selectedIndex !== -1 ? stateEl.options[stateEl.selectedIndex].text : '';
        var countryEl = document.getElementById("country");
        var country = countryEl.options[countryEl.selectedIndex].text;
        var postal_code = document.getElementById("pincode").value;

        // Create the ConfirmationToken using the details collected by the Payment Element
        // and additional shipping information
        const {
            error,
            confirmationToken
        } = await stripe.createConfirmationToken({
            elements,
            params: {
                shipping: {
                    name: first_name,
                    address: {
                        line1: address,
                        city: city,
                        state: state,
                        country: country,
                        postal_code: postal_code,
                    },
                },
                return_url: '{{ route('orderPlaced') }}',
            }
        });

        if (error) {
            handleError(error);
            return;
        }

        // Create the PaymentIntent
        const res = await fetch('{{ route('paymentStore') }}', {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                    "content"),
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                confirmationTokenId: confirmationToken.id,
            }),
        });
        const data = await res.json();
        if (data.status === 'succeeded') window.location = '{{ route('orderPlaced') }}';
        else window.location = '{{ route('orderCancelled') }}';
        // Handle any next actions or errors. See the Handle any next actions step for implementation.
        //handleServerResponse(data);
    });
</script>
