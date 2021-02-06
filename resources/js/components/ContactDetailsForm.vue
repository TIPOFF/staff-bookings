<template>
    <section>
        <h1 class="text-90 font-normal text-2xl mb-3">Create User</h1>

        <card class="mb-8">
            <div class="flex border-b border-40">
                <div class="w-1/5 px-8 py-6">
                    <label
                        for="first-name"
                        class="inline-block text-80 pt-2 leading-tight"
                    >
                        First Name
                    </label>
                </div>

                <div class="py-6 px-8 w-1/2">
                    <div class="flex items-center mb-3">
                        <input
                            type="text"
                            id="first-name"
                            v-model="name"
                            class="w-full form-control form-input form-input-bordered"
                            autocomplete="off"
                        />
                    </div>
                </div>
            </div>

            <div class="flex border-b border-40">
                <div class="w-1/5 px-8 py-6">
                    <label
                        for="last-name"
                        class="inline-block text-80 pt-2 leading-tight"
                    >
                        Last Name
                    </label>
                </div>

                <div class="py-6 px-8 w-1/2">
                    <div class="flex items-center mb-3">
                        <input
                            type="text"
                            id="last-name"
                            v-model="nameLast"
                            class="w-full form-control form-input form-input-bordered"
                            autocomplete="off"
                        />
                    </div>
                </div>
            </div>

            <div class="flex">
                <div class="w-1/5 px-8 py-6">
                    <label
                        for="email"
                        class="inline-block text-80 pt-2 leading-tight"
                    >
                        Email
                    </label>
                </div>

                <div class="py-6 px-8 w-1/2">
                    <div class="flex items-center mb-3">
                        <input
                            type="email"
                            id="email"
                            v-model="email"
                            class="w-full form-control form-input form-input-bordered"
                            autocomplete="off"
                        />
                    </div>
                </div>
            </div>
        </card>

        <div class="flex justify-end">
            <button
                class="btn btn-default btn-primary"
                :disabled="processing"
                @click="submit"
            >
                Next
            </button>
        </div>
    </section>
</template>

<script>
import { required, email } from 'vuelidate/lib/validators';

export default {
  props: {
    locationId: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      name: '',
      nameLast: '',
      email: '',
      processing: false,
    };
  },
  methods: {
    submit() {
      this.$v.$touch();

      if (this.$v.$invalid) {
        this.$toasted.show('We couldn\'t create the user.', {
          type: 'error',
        });

        return;
      }

      this.processing = true;

      Nova.request()
        .post('/api/users', {
          name: this.name,
          name_last: this.nameLast,
          email: this.email,
          location_id: this.locationId,
        })
        .then((response) => {
          this.$emit('completed', response.data.data);
        })
        .finally(() => {
          this.processing = false;
        });
    },
  },
  validations: {
    name: {
      required,
    },
    nameLast: {
      required,
    },
    email: {
      required,
      email,
    },
  },
};
</script>
