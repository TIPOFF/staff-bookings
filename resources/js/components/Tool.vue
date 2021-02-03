<template>
    <div>
        <loading-view v-if="loading" />

        <div v-else>
            <location-form
                v-if="activeStep === 1"
                @completed="selectLocation"
            />

            <contact-details-form
                v-if="activeStep === 2"
                :location-id="location.id"
                @completed="setUser"
            />

            <games-form
                v-if="activeStep === 3"
                :location-slug="location.slug"
                :user-id="userId"
                @completed="nextStep"
            />

            <purchase-form
                v-if="activeStep === 4"
                :location-slug="location.slug"
                :stripe-key="location.stripe_publishable"
                :user-id="userId"
                @completed="nextStep"
            />
        </div>
    </div>
</template>

<script>
import ContactDetailsForm from './ContactDetailsForm';
import LocationForm from './LocationForm';
import GamesForm from './GamesForm';
import PurchaseForm from './PurchaseForm';

export default {
    components: {
        PurchaseForm,
        ContactDetailsForm,
        LocationForm,
        GamesForm,
    },
    data() {
        return {
            activeStep: 1,
            totalSteps: 4,
            userId: '',
            location: null,
            loading: false,
        };
    },
    mounted() {
        if (this.locationSlugFromHash) {
            this.loadLocation(this.locationSlugFromHash);
        }

        this.activeStep = this.initialStep;
    },
    methods: {
        async loadLocation(slug) {
            this.loading = true;

            await Nova.request()
                .get(`/api/locations/${ slug }`)
                .then(response => {
                    this.location = response.data.data;
                })
              .catch(error => {
                console.error(error);
              })
                .finally(() => {
                    this.loading = false;
                });
        },
        async selectLocation(slug) {
            await this.loadLocation(slug);

            this.$router.push({ hash: `#${this.location.slug}`});

            this.nextStep();
        },
        setUser(user) {
            this.userId = user.id;

            this.nextStep();
        },
        nextStep() {
            if (this.activeStep < this.totalSteps) {
                this.activeStep++;
            } else {
                this.activeStep = this.initialStep;

                this.$toasted.show('Purchase complete.', {
                    type: 'success',
                });
            }
        },
    },
    computed: {
        initialStep() {
            return this.locationSlugFromHash ? 2 : 1;
        },
        locationSlugFromHash() {
            return this.$router.currentRoute.hash
                .replace('#', '');
        },
    },
};
</script>
