import Vuelidate from 'vuelidate';
import VueTheMask from 'vue-the-mask';

Nova.booting((Vue, router, store) => {
    Vue.use(Vuelidate);
    Vue.use(VueTheMask);

    Vue.filter('dollars', function (value) {
        if (!value) {
            return '-';
        }

        const dollars = value / 100;

        return dollars.toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD',
        });
    });

    router.addRoutes([
        {
            name: 'booking',
            path: '/booking',
            component: require('./components/Tool'),
        },
    ]);
});
