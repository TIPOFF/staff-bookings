<template>
    <div>
        <h1 class="text-90 font-normal text-2xl mb-3">Choose a Location</h1>

        <card class="mb-8 px-8 py-6">
            <div class="w-1/2">
                <api-selector
                    class="form-control form-select w-full"
                    resource="locations"
                    sort-by="name"
                    label="name"
                    v-model="selectedLocation"
                    key-by="slug"
                />
            </div>
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
import ApiSelector from './ApiSelector';
import { required } from 'vuelidate/lib/validators';

export default {
    components: {
        ApiSelector,
    },
    data() {
        return {
            selectedLocation: '',
        };
    },
    methods: {
        submit() {
          if (this.$v.$invalid) {
              this.$toasted.show('Please select a location.', {
                  type: 'error',
              });

              return;
          }

          this.$emit('completed', this.selectedLocation);
        },
    },
    validations: {
        selectedLocation: {
            required,
        },
    },
};
</script>
