<template>
    <div>
        <h1 class="text-90 font-normal text-2xl mb-3">
            Games for <span style="text-transform: capitalize">{{ this.locationSlug }}</span>
        </h1>

        <card class="mb-8 px-8 py-6">
            <h2 class="mb-3">Cart</h2>

            <loading-view v-if="loadingCartItems" />

            <div v-else>
                <template v-for="cartItem in cartItems">
                    <cart-item
                        :cart-item="cartItem"
                        :user-id="userId"
                        @deleted="loadCart"
                    />
                </template>

                <div class="text-right mt-6">
                    <p class="text-80">Amount: {{ cart.amount | dollars }}</p>
                    <p class="text-80">Taxes: {{ cart.total_taxes | dollars }}</p>
                    <p class="text-80">Fees: {{ cart.total_fees | dollars }}</p>
                    <h4 class="mt-3">Total: {{ cart.total_amount | dollars }}</h4>
                </div>

                <div class="flex justify-end mt-6">
                    <div class="w-1/3">
                        <deduction-code-form
                            :location-slug="locationSlug"
                            :user-id="userId"
                        />
                    </div>
                </div>
            </div>
        </card>

        <card class="px-8 py-6 mb-8">
            <h2 class="mb-3">Available Games</h2>

            <loading-view v-if="loadingGames" />

            <template v-for="game in games">
                <game-item
                    :key="game.id"
                    :location-slug="locationSlug"
                    :game="game"
                    :user-id="userId"
                    @selected="loadCart"
                />
            </template>
        </card>

        <div class="flex justify-end">
            <button
                class="btn btn-default btn-primary"
                @click="submit"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import {required, minLength} from 'vuelidate/lib/validators';
import GameItem from './GameItem';
import CartItem from './CartItem';
import DeductionCodeForm from './DeductionCodeForm';

export default {
    components: {
        GameItem,
        CartItem,
        DeductionCodeForm,
    },
    props: {
        locationSlug: {
            type: String,
            required: true,
        },
        userId: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            games: [],
            loadingGames: false,
            loadingCartItems: false,
            cartItems: [],
            cart: null,
        };
    },
    created() {
        this.loadGames();

        this.loadCart();

        Nova.$on('code-applied', cart => {
            this.cart = cart;
        });
    },
    beforeDestroy() {
        Nova.$off('code-applied');
    },
    methods: {
        loadGames() {
            const formattedDate = moment().format('YYYY-MM-DD');

            this.loadingGames = true;

            Nova.request()
                .get(
                    `/api/availability/${this.locationSlug}?include=room.theme,room.location,rate&filter[hold]=false&initial_date=${formattedDate}&final_date=${formattedDate}`
                )
                .then(response => {
                    this.games = response.data.data;
                })
                .finally(() => {
                    this.loadingGames = false;
                });
        },
        loadCart() {
            this.cart = null;

            this.cartItems = [];

            this.loadingCartItems = true;

            Nova.request()
                .get('/api/carts')
                .then(response => {
                    this.cart = response.data.data;

                    this.cartItems = this.cart.cartItems.data;
                })
                .finally(() => {
                    this.loadingCartItems = false;
                });
        },
        submit() {
            this.$v.$touch()

            if (this.$v.$invalid) {
                this.$toasted.show('Please select a game.', {
                    type: 'error',
                });

                return;
            }

            this.$emit('completed');
        },
    },
    validations: {
        cartItems: {
            required,
            minLength: minLength(1)
        },
    }
};
</script>
