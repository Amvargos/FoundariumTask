<template>
    <div>

        <el-row :gutter="10">
            <el-col
                :span="4"
                v-for="item in autos"
                :key="item.id"
            >
                <el-card :body-style="{ padding: '0px' }">
                    <img
                        :src="item.auto_picture.versions.optimized"
                        class="image"
                    />
                    <div style="padding: 14px">
                        <span>{{item.title}}</span>
                        <div class="bottom">
                            <el-button class="time" v-if="item.active_orders.length" @click="activeBookingsOpen(item.active_orders)">Посмотреть забронированые даты</el-button>
                            <div class="actions" :class="!item.active_orders.length ? 'mt-2' : ''">
                                <el-button  size="large" class="button" @click="bookingOpen(item)">Забронировать</el-button>
                            </div>
                        </div>
                    </div>
                </el-card>
            </el-col>
        </el-row>
        <el-dialog
            :title="`Забронировать автомобиль ${bookingItem.title}`"
            v-model="bookingDialog"
            width="30%"
            v-loading="loading"
        >
            <el-form :model="form" @submit.native.prevent="booking">
                <el-form-item>
                    <el-date-picker
                        v-model="form.datetime"
                        value-format="YYYY-MM-DD HH:mm:ss"
                        type="datetimerange"
                        range-separator="-"
                        style="width: 100%"
                        :disabled-date="disabledDate"
                        start-placeholder="Начало"
                        end-placeholder="Конец">
                    </el-date-picker>
                </el-form-item>
                <el-button
                    class="login-button"
                    native-type="submit"
                    block
                >Забронировать
                </el-button>
            </el-form>
        </el-dialog>
        <el-dialog
            :title="`Активные бронирования`"
            v-model="activeBookingsDialog"
            width="50%"
        >
           <p v-for="booking in activeBookings">с {{$filters.formatDateDMT(booking.date_start)}} по {{$filters.formatDateDMT(booking.date_end)}}</p>
        </el-dialog>
    </div>
</template>

<script>
export default {
    name: "MainScreen",
    data() {
        return {
            autos: [],
            page: 1,
            loading: false,
            meta: {},
            form: {
              datetime: '',
            },
            bookingDialog: false,
            activeBookingsDialog: false,
            bookingItem: false,
            activeBookings: [],
        };
    },
    methods: {
        activeBookingsOpen(activeBookings){
            this.activeBookingsDialog = true;
            this.activeBookings = activeBookings;
        },
        disabledDate(time) {
            return time.getTime() < Date.now();
        },
        booking(){
            var formData = new FormData();

            formData.append("date_start", this.form.datetime[0]);
            formData.append("date_end", this.form.datetime[1]);

            this.$axios.post(`/auto/${this.bookingItem.id}/booking/`, formData)
                .then((response) => {
                    this.loading = false;
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        bookingOpen(item){
            this.bookingDialog = true;
            this.bookingItem = item;
        },
        getAutos() {
            this.loading = true;
            this.$axios.get(`/autos`)
                .then((response) => {
                    this.loading = false;
                    if (response.data.data.length) {
                        this.autos = response.data.data;
                        this.meta = response.data.meta;
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    },
    beforeMount(){
        this.getAutos()
    }
}
</script>

<style lang="scss" scoped>
.el-card__body {
    .image {
        width: 100%;
    }
    .time {
        margin: 15px 0px;
        display: block;
    }
    .button{
        width: 100%;
    }
}
.mt-2{
    margin-top: 15px;
}
</style>
