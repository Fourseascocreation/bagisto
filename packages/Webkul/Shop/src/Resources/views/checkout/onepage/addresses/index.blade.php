{!! view_render_event('bagisto.shop.checkout.onepage.addresses.before') !!}

<v-checkout-addresses 
    :cart="cart"
    @update-cart="getOrderSummary($event)"
    @shipping-methods="shippingMethods($event)"
>
</v-checkout-addresses>

{!! view_render_event('bagisto.shop.checkout.onepage.addresses.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-addresses-template"
    >
        <template v-if="isAddressLoading">
            <!-- Onepage Shimmer Effect --> 
            <x-shop::shimmer.checkout.onepage.address />
        </template>
        
        <template v-else>
            <div class="mt-8 mb-7">
                {!! view_render_event('bagisto.shop.checkout.onepage.addresses.billing.before') !!} 

                @include('shop::checkout.onepage.addresses.billing')

                {!! view_render_event('bagisto.shop.checkout.onepage.addresses.billing.after') !!}

                {!! view_render_event('bagisto.shop.checkout.onepage.addresses.shipping.before') !!}

                @include('shop::checkout.onepage.addresses.shipping')

                {!! view_render_event('bagisto.shop.checkout.onepage.addresses.shipping.after') !!} 
            </div>

            <div 
                class="flex justify-end mt-4"
                v-if="
                (selectedAddresses.billing_address_id || selectedAddresses.shipping_address_id)
                && ! shippingAddress.isShowShippingForm
                "
            >
                {!! view_render_event('bagisto.shop.checkout.onepage.addresses.shipping_address.confirm_button.before') !!}

                <x-shop::button
                    type="button"
                    class="primary-button py-3 px-11 rounded-2xl"
                    :title="trans('shop::app.checkout.onepage.addresses.shipping.confirm')"
                    :loading="false"
                    @click="proceed"
                />

                {!! view_render_event('bagisto.shop.checkout.onepage.addresses.shipping_address.confirm_button.after') !!}
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-checkout-addresses', {
            template: '#v-checkout-addresses-template',

            props: ['cart'],

            data() {
                return {
                    customerAddresses: [],

                    addNewBillingAddress: false,

                    shippingAddress: {
                        sameAsBilling: true,

                        isShowShippingForm: false,
                    },

                    cartAddresses: {
                        billing: {},

                        shipping: {},
                    },

                    selectedAddresses: {
                        billing_address_id: null,

                        shipping_address_id: null,
                    },

                    countries: [],

                    isCustomer: Boolean("{{ auth()->guard('customer')->check() }}"),

                    isSameAsBilling: false,

                    isAddressLoading: true,
                };
            },

            mounted() {
                this.get();

                this.getCountries();
            },

            computed: {
                savedBillingAddresses() {
                    this.cartAddresses.billing = this.cart.billing_address;
                    
                    const addresses = [];

                    if (this.cartAddresses.billing) {
                        this.cartAddresses.billing.default_address = true;

                        addresses.push(this.cartAddresses.billing);
                    }

                    this.customerAddresses.forEach((address) => {
                        if (
                            address.first_name == this.cartAddresses.billing?.first_name
                            && address.last_name == this.cartAddresses.billing?.last_name
                            && address.city == this.cartAddresses.billing?.city
                            && address.state == this.cartAddresses.billing?.state
                            && address.country == this.cartAddresses.billing?.country
                            && address.postcode == this.cartAddresses.billing?.postcode
                            && address.email == this.cartAddresses.billing?.email
                            && address.phone == this.cartAddresses.billing?.phone
                            && address?.company_name == this.cartAddresses.billing?.company_name
                            && address?.address1 == this.cartAddresses.billing?.address1
                        ) {
                            return;
                        }

                        address.default_address = false;

                        addresses.push(address);
                    });

                    return addresses;
                },

                savedShippingAddresses() {
                    this.cartAddresses.shipping = this.cart.shipping_address;

                    const addresses = [];

                    if (this.cartAddresses.shipping) {
                        this.cartAddresses.shipping.default_address = true;

                        addresses.push(this.cartAddresses.shipping);
                    }

                    this.customerAddresses.forEach((address) => {
                        if (
                            address.first_name == this.cartAddresses.shipping?.first_name
                            && address.last_name == this.cartAddresses.shipping?.last_name
                            && address.city == this.cartAddresses.shipping?.city
                            && address.state == this.cartAddresses.shipping?.state
                            && address.country == this.cartAddresses.shipping?.country
                            && address.postcode == this.cartAddresses.shipping?.postcode
                            && address.email == this.cartAddresses.shipping?.email
                            && address.phone == this.cartAddresses.shipping?.phone
                            && address?.company_name == this.cartAddresses.shipping?.company_name
                            && address?.address1 == this.cartAddresses.shipping?.address1
                        ) {
                            return;
                        }

                        address.default_address = false;

                        addresses.push(address);
                    });

                    return addresses;
                },
            },

            methods: {
                get() {
                    this.isAddressLoading = true;

                    if (! this.isCustomer) {
                        this.isAddressLoading = false;

                        return;
                    }

                    this.$axios.get('{{ route('api.shop.customers.account.addresses.index') }}')
                        .then(response => {
                            this.customerAddresses = response.data.data;

                            this.isAddressLoading = false;
                        })
                        .catch(() => {});
                },

                storeBilling(params, { resetForm }) {
                    this.$axios.post('{{ route('shop.checkout.onepage.addresses.store') }}', {
                        ...params,
                        shipping: {
                            ...params.billing
                        },
                    })
                        .then(() => {
                            resetForm();

                            this.get();

                            this.addNewBillingAddress = false;

                            this.$emit('update-cart');
                        })
                        .catch(() => {});
                },


                storeShipping(params, { resetForm }) {
                    let selectedAddress = this.customerAddresses.find(address => {
                        return address.id == this.selectedAddresses.billing_address_id;
                    });

                    selectedAddress.address1 = [selectedAddress.address1 ?? '', selectedAddress.address2 ?? ''];

                    this.$axios.post('{{ route('shop.checkout.onepage.addresses.store') }}', {
                        ...params,
                        billing: {
                            ...selectedAddress
                        },
                    })
                        .then(() => {
                            resetForm();

                            this.get();

                            this.shippingAddress.isShowShippingForm = false;

                            this.$emit('update-cart');
                        })
                        .catch(() => {});
                },

                proceed() {
                    this.$axios.post('{{ route('shop.checkout.onepage.addresses.store') }}',  {
                        billing: {
                            address1: [''],

                            address_id: this.selectedAddresses.billing_address_id,
                        }, 

                        shipping: {
                            address1: [''],

                            address_id: this.selectedAddresses.shipping_address_id,
                        }
                    })
                        .then((response) => {
                            this.$emit('update-cart');

                            this.$emit('shipping-methods', response.data.data.shippingMethods);

                            resetForm();

                            this.get();

                            this.shippingAddress.isShowShippingForm = false;
                        })
                        .catch(() => {});
                },

                updateCartAddress(params) {
                    console.log(params);
                },

                haveStates(addressType) {
                    return false;
                },

                getCountries() {
                    this.$axios.get("{{ route('shop.api.core.countries') }}")
                        .then(response => {
                            this.countries = response.data.data;
                        })
                        .catch(() => {});
                },
            },
        });
    </script>
@endPushOnce