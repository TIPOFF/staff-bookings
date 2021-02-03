<template>
    <div class="py-3 border-b border-40">
        <div class="flex items-center justify-between">
            {{ this.game.start_at }} - {{ game.end_at }} (UTC):
            {{ game.room.data.theme.data.title }}

            <div class="flex items-center">
                <button
                    class="btn btn-sm btn-outline focus:outline-none focus:shadow-outline active:outline-none active:shadow-outline"
                    :disabled="processing"
                    @click="playPrivate = false; show = true;"
                >
                    Public
                </button>

                <button
                    class="btn btn-sm btn-outline focus:outline-none focus:shadow-outline active:outline-none active:shadow-outline"
                    @click="playPrivate = true; show = true;"
                >
                    Private
                </button>
            </div>
        </div>

        <div
            v-show="show"
            class="mt-3"
        >
            <div class="flex items-center">
                Players:

                <select
                    v-model="participantCount"
                    class="form-control form-select ml-3"
                >
                    <template v-for="count in game.participants_available">
                        <option
                            :value="count"
                            :key="count"
                        >
                            {{ count }}
                        </option>
                    </template>
                </select>
            </div>

            <div class="mt-3">
                <button
                    class="btn btn-default btn-primary"
                    :disabled="processing"
                    @click="select"
                >
                    Confirm
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import {required, minValue, integer} from 'vuelidate/lib/validators';

export default {
    props: {
        game: {
            type: Object,
            required: true,
        },
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
            playPrivate: false,
            processing: false,
            show: false,
            participantCount: 2,
        };
    },
    methods: {
        select() {
            this.$v.$touch()

            if (this.$v.$invalid) {
                this.$toasted.show('Oops. Something went wrong.', {
                    type: 'error',
                });

                return;
            }

            this.processing = true;

            Nova.request()
                .post('/api/cart-items', {
                    slot_number: this.game.slot_number,
                    participants: this.participantCount,
                    is_private: this.playPrivate,
                })
                .then(() => {
                    this.show = false;

                    this.$emit('selected');
                })
                .finally(() => {
                    this.processing = false;
                });
        },
    },
    validations: {
        playPrivate: {
            required,
        },
        participantCount: {
            required,
            integer,
            minValue: minValue(1),
        },
    },
};
</script>
