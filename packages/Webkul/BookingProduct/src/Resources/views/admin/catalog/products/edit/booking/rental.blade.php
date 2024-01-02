{!! view_render_event('bagisto.admin.catalog.product.edit.before', ['product' => $product]) !!}

<v-rental-booking></v-rental-booking>

{!! view_render_event('bagisto.admin.catalog.product.edit.after', ['product' => $product]) !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-rental-booking-template"
    >
        <!-- Renting Type -->
        <x-admin::form.control-group class="w-full mb-2.5">
            <x-admin::form.control-group.label class="required">
                @lang('booking::app.admin.catalog.products.edit.type.booking.renting-type.title')
            </x-admin::form.control-group.label>

            <x-admin::form.control-group.control
                type="select"
                name="booking[renting_type]"
                rules="required"
                v-model="rental_booking.renting_type"
                :label="trans('booking::app.admin.catalog.products.edit.type.booking.renting-type.title')"
            >
                @foreach (['daily', 'hourly', 'daily_hourly'] as $item)
                    <option value="{{ $item }}">
                        @lang('booking::app.admin.catalog.products.edit.type.booking.renting-type.' . $item)
                    </option>
                @endforeach
            </x-admin::form.control-group.control>

            <x-admin::form.control-group.error 
                control-name="booking[renting_type]"
            >
            </x-admin::form.control-group.error>
        </x-admin::form.control-group>

        <!-- Daily Price -->
        <x-admin::form.control-group
            class="w-full mb-2.5"
            v-if="rental_booking.renting_type == 'daily' || rental_booking.renting_type == 'daily_hourly'"
        >
            <x-admin::form.control-group.label class="required">
                @lang('booking::app.admin.catalog.products.edit.type.booking.renting-type.daily-price')
            </x-admin::form.control-group.label>

            <x-admin::form.control-group.control
                type="text"
                name="booking[daily_price]"
                rules="required"
                v-model="rental_booking.daily_price"
                :label="trans('booking::app.admin.catalog.products.edit.type.booking.renting-type.daily-price')"
            >
            </x-admin::form.control-group.control>

            <x-admin::form.control-group.error 
                control-name="booking[renting_type]"
            >
            </x-admin::form.control-group.error>
        </x-admin::form.control-group>

        <!-- Hourly Price -->
        <x-admin::form.control-group
            class="w-full mb-2.5"
            v-if="rental_booking.renting_type == 'hourly' || rental_booking.renting_type == 'daily_hourly'"
        >
            <x-admin::form.control-group.label class="required">
                @lang('booking::app.admin.catalog.products.edit.type.booking.renting-type.hourly-price')
            </x-admin::form.control-group.label>

            <x-admin::form.control-group.control
                type="text"
                name="booking[hourly_price]"
                rules="required"
                v-model="rental_booking.hourly_price"
                :label="trans('booking::app.admin.catalog.products.edit.type.booking.renting-type.hourly-price')"
            >
            </x-admin::form.control-group.control>

            <x-admin::form.control-group.error 
                control-name="booking[hourly_price]"
            >
            </x-admin::form.control-group.error>
        </x-admin::form.control-group>

        <div v-if="rental_booking.renting_type == 'hourly' || rental_booking.renting_type == 'daily_hourly'">
            <!-- Same Slot For All -->
            <x-admin::form.control-group class="w-full mb-2.5" >
                <x-admin::form.control-group.label class="required">
                    @lang('booking::app.admin.catalog.products.edit.type.booking.same-slot-for-all-days.title')
                </x-admin::form.control-group.label>

                <x-admin::form.control-group.control
                    type="select"
                    name="booking[same_slot_all_days]"
                    rules="required"
                    v-model="rental_booking.same_slot_all_days"
                    :label="trans('booking::app.admin.catalog.products.edit.type.booking.same-slot-for-all-days.title')"
                    @change="slots.one=[];slots.many=[];"
                >
                    <option value="1">
                        @lang('booking::app.admin.catalog.products.edit.type.booking.same-slot-for-all-days.yes')
                    </option>

                    <option value="0">
                        @lang('booking::app.admin.catalog.products.edit.type.booking.same-slot-for-all-days.no')
                    </option>
                </x-admin::form.control-group.control>

                <x-admin::form.control-group.error 
                    control-name="booking[same_slot_all_days]"
                >
                </x-admin::form.control-group.error>
            </x-admin::form.control-group>
        </div>

        <!-- Slots Component -->
        <v-slots
            :booking-product="rental_booking"
            :booking-type="'rental_slot'"
            :same-slot-all-days="rental_booking.same_slot_all_days"
        >
        </v-slots>
    </script>

    <script type="module">
        app.component('v-rental-booking', {
            template: '#v-rental-booking-template',

            props: ['bookingProduct'],

            data() {
                return {
                    rental_booking: @json($bookingProduct && $bookingProduct?->rental_slot) ? @json($bookingProduct?->rental_slot) : {
                        renting_type: 'daily',

                        daily_price: '',

                        hourly_price: '',

                        same_slot_all_days: 1,

                        slots: []
                    },
                },
            },
        });
    </script>
@endpushOnce