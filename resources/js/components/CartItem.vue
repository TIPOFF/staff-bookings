<template>
    <div
        :key="cartItem.id"
        class="flex justify-between py-3"
    >
        {{ cartItem.slot_number }}
        -
        {{ cartItem.participants }} participants
        -
        {{ cartItem.is_private ? 'private' : 'public' }}
        -
        {{ cartItem.amount | dollars }}

        <button
            class="btn btn-sm btn-outline focus:outline-none focus:shadow-outline active:outline-none active:shadow-outline"
            :disabled="processing"
            @click="remove"
        >
            Remove
        </button>
    </div>
</template>

<script>
export default {
    props: {
        cartItem: {
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
            processing: false,
        };
    },
    methods: {
        remove() {
            this.processing = true;

            Nova.request()
                .delete(`/api/cart-items/${ this.cartItem.id }`)
                .then(() => {
                    this.$emit('deleted');
                })
                .finally(() => {
                    this.processing = false;
                })
        },
    },
};
</script>
