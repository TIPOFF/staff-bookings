<template>
    <div>
        <h3 class="mb-3">Coupon</h3>

        <input
            type="text"
            v-model="code"
            class="form-control form-input form-input-bordered w-full"
        />

        <button
            class="btn btn-default btn-primary mt-3"
            @click="submit"
            :disabled="loading"
        >
            Apply Code
        </button>
    </div>
</template>

<script>
export default {
    props: {
        locationSlug: {
            type: String,
            required: true,
        },
        cartId: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            code: '',
            loading: false,
        };
    },
    methods: {
        submit() {
            this.loading = true;

            if (this.code) {
                const endpoint = this.code.length === 9
                    ? '/api/voucher-applications'
                    : '/api/discount-applications';

                Nova.request()
                    .post(endpoint, {
                      code: this.code,
                      cart_id: this.cartId,
                    })
                    .then(response => {
                        this.code = '';

                        this.$toasted.show('Code applied to the cart.', { type: 'success' });

                        Nova.$emit('code-applied', response.data.data);
                    })
                    .catch(() => {
                        this.$toasted.show('The code is invalid.', { type: 'error' });
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            }
        },
    },
};
</script>
