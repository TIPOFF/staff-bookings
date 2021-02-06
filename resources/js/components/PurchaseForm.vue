<template>
    <div>
        <h1 class="text-90 font-normal text-2xl mb-3">
            Payment
        </h1>

        <card class="mb-8">
            <div class="flex border-b border-40">
                <div class="w-1/5 px-8 py-6">
                    <label
                        for="address"
                        class="inline-block text-80 pt-2 leading-tight"
                    >
                        Address
                    </label>
                </div>

                <div class="py-6 px-8 w-1/2">
                    <div class="flex items-center mb-3">
                        <input
                            type="text"
                            id="address"
                            v-model="address"
                            class="w-full form-control form-input form-input-bordered"
                            autocomplete="off"
                        />
                    </div>
                </div>
            </div>

            <div class="flex border-b border-40">
                <div class="w-1/5 px-8 py-6">
                    <label
                        for="city"
                        class="inline-block text-80 pt-2 leading-tight"
                    >
                        City
                    </label>
                </div>

                <div class="py-6 px-8 w-1/2">
                    <div class="flex items-center mb-3">
                        <input
                            type="text"
                            id="city"
                            v-model="city"
                            class="w-full form-control form-input form-input-bordered"
                            autocomplete="off"
                        />
                    </div>
                </div>
            </div>

            <div class="flex border-b border-40">
                <div class="w-1/5 px-8 py-6">
                    <label
                        for="state"
                        class="inline-block text-80 pt-2 leading-tight"
                    >
                        State
                    </label>
                </div>

                <div class="py-6 px-8 w-1/2">
                    <div class="flex items-center mb-3">
                        <input
                            type="text"
                            id="state"
                            v-model="state"
                            class="w-full form-control form-input form-input-bordered"
                            autocomplete="off"
                        />
                    </div>
                </div>
            </div>

            <div class="flex border-b border-40">
                <div class="w-1/5 px-8 py-6">
                    <label
                        for="zip"
                        class="inline-block text-80 pt-2 leading-tight"
                    >
                        Zip Code
                    </label>
                </div>

                <div class="py-6 px-8 w-1/2">
                    <div class="flex items-center mb-3">
                        <input
                            type="text"
                            id="zip"
                            v-model="zip"
                            class="w-full form-control form-input form-input-bordered"
                            autocomplete="off"
                        />
                    </div>
                </div>
            </div>

            <div class="flex border-b border-40">
                <div class="w-1/5 px-8 py-6">
                    <label
                        for="phone-number"
                        class="inline-block text-80 pt-2 leading-tight"
                    >
                        Phone Number
                    </label>
                </div>

                <div class="py-6 px-8 w-1/2">
                    <div class="flex items-center mb-3">
                        <input
                            type="text"
                            id="phone-number"
                            v-model="phoneNumber"
                            class="w-full form-control form-input form-input-bordered"
                            v-mask="'###-###-####'"
                            autocomplete="off"
                        />
                    </div>
                </div>
            </div>

            <div class="flex border-b border-40">
                <div class="w-1/5 px-8 py-6">
                    <label
                        for="card-holder-name"
                        class="inline-block text-80 pt-2 leading-tight"
                    >
                        Card Holder Name
                    </label>
                </div>

                <div class="py-6 px-8 w-1/2">
                    <div class="flex items-center mb-3">
                        <input
                            type="text"
                            id="card-holder-name"
                            v-model="cardHolderName"
                            class="w-full form-control form-input form-input-bordered"
                            autocomplete="off"
                        />
                    </div>
                </div>
            </div>

            <div class="px-8 py-6">
                <div ref="stripeCard" />
            </div>
        </card>

        <div class="flex justify-end">
            <button
                class="btn btn-default btn-primary"
                :disabled="processing"
                @click="submit"
            >
                Finish
            </button>
        </div>
    </div>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';
import { required } from 'vuelidate/lib/validators';

export default {
    props: {
        stripeKey: {
            type: String,
            required: true,
        },
        location: {
            type: Object,
            required: true,
        },
        userId: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            cardHolderName: '',
            stripe: null,
            cardElement: null,
            processing: false,
            paymentMethodId: '',
            address: '',
            city: '',
            state: '',
            zip: '',
            phoneNumber: '',
        };
    },
    mounted() {
        this.attachStripeCard();
    },
    methods: {
        async submit() {
            this.$v.$touch()

            if (this.$v.$invalid) {
                this.$toasted.show('Fill in the user information.', {
                    type: 'error',
                });

                return;
            }

            this.processing = true;

            const { paymentMethod, error } = await this.stripe.createPaymentMethod(
                'card', this.cardElement, {
                    billing_details: {
                        name: this.cardHolderName,
                    },
                },
            );

            if (error) {
                this.$toasted.show('Purchase failed.', {
                    type: 'error',
                });

                this.processing = false;
            } else {
                new Promise(resolve => {
                    this.paymentMethodId = paymentMethod.id;

                    resolve();
                }).then(() => {
                    Nova.request()
                        .post('/api/orders', {
                          location_id: this.location.id,
                            payment_method_id: this.paymentMethodId,
                            address: this.address,
                            city: this.city,
                            state: this.state,
                            zip: this.zip,
                            phone_number: this.phoneNumber,
                            user_id: this.userId,
                        })
                        .then(() => {
                            this.$emit('completed');
                        })
                        .finally(() => {
                            this.processing = false;
                        });
                });
            }
        },
        async attachStripeCard() {
            this.stripe = await loadStripe(this.stripeKey);

            this.cardElement = this.stripe.elements()
                .create('card');

            this.cardElement.mount(this.$refs.stripeCard);
        },
    },
    validations: {
        cardHolderName: {
            required,
        },
        address: {
            required,
        },
        city: {
            required,
        },
        state: {
            required,
        },
        zip: {
            required,
        },
        phoneNumber: {
            required,
        },
    },
};
</script>
