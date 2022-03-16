<template>
    <el-row>
        <el-col :span="12">
            <el-button type="button" @click="openAddAutoDialog">Добавить</el-button>
            <el-table row-key="date" :data="data" style="width: 100%">
                <el-table-column
                    prop="id"
                    label="ID"
                    width="180"
                    column-key="id"
                />
                <el-table-column prop="title" label="Заголовок" />
                <el-table-column prop="status" label="Статус" />
                <el-table-column label="Действия">
                    <template #default="scope">
                        <el-button size="small" @click="handleEdit(scope.$index, scope.row)"
                        >Изменить</el-button
                        >
                        <el-popconfirm title="Действительно хотите удалить?" confirmButtonText="Да"
                                       @confirm="handleDelete(scope.$index, scope.row)">
                            <template #reference>
                                <el-button
                                    size="small"
                                    type="danger"
                                >Удалить</el-button
                                >
                            </template>
                        </el-popconfirm>
                    </template>
                </el-table-column>
            </el-table>
            <el-dialog
                title="Добавить автомобиль"
                v-model="addAutoDialog"
                width="30%"
                v-loading="loading"
            >
                <el-form :model="form" ref="form" @submit.native.prevent="addAuto">
                    <el-form-item>
                        <el-input v-model="form.title" placeholder="Заголовок"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <span slot="label">Фото автомобиля</span><br/>
                        <el-upload
                            name="auto_picture"
                            action="#"
                            style="width: 100%"
                            drag
                            :auto-upload="false"
                            :limit="1"
                            :accept="'image/*'"
                            :on-change="handleChange"
                            :on-remove="handleRemove"
                        >
                            <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" data-v-ba633cb8=""><path fill="currentColor" d="M544 864V672h128L512 480 352 672h128v192H320v-1.6c-5.376.32-10.496 1.6-16 1.6A240 240 0 0 1 64 624c0-123.136 93.12-223.488 212.608-237.248A239.808 239.808 0 0 1 512 192a239.872 239.872 0 0 1 235.456 194.752c119.488 13.76 212.48 114.112 212.48 237.248a240 240 0 0 1-240 240c-5.376 0-10.56-1.28-16-1.6v1.6H544z"></path></svg>
                            <div class="el-upload__text"><em>Загрузить</em></div>
                        </el-upload>
                    </el-form-item>
                    <el-button
                        class="login-button"
                        native-type="submit"
                        block
                    >{{this.form.id ? 'Сохранить' : 'Добавить'}}
                    </el-button>
                </el-form>
            </el-dialog>
        </el-col>
    </el-row>
</template>

<script>
export default {
    name: "ViewScreen",
    data() {
        return {
            data: [],
            meta: {},
            form: {
                title: '',
                auto_picture: '',
            },
            loading: false,
            addAutoDialog: false,
        }
    },
    methods: {
        openAddAutoDialog(){
            this.form = {
                title: '',
                auto_picture: '',
            };
            this.addAutoDialog = true;
        },
        handleDelete(index, row){
            this.loading = true;
            this.$axios.delete(`/autos/${row.id}`)
                .then((response) => {
                    this.getAutos();
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        handleEdit(index, row){
            this.$axios.get(`/autos/${row.id}`)
                .then((response) => {
                    this.loading = false;
                    this.form =  response.data.data;
                    this.addAutoDialog = true;
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        addAuto(){
            var formData = new FormData();
            this.loading = true;
            formData.append("title", this.form.title);
            formData.append("auto_picture", this.form.auto_picture[0]);
            if(this.form.id) {
                formData.append("_method", "PUT");
            }
            this.$axios.post(this.form.id ? `/autos/${this.form.id}` : `/autos`, formData, {header:{"Content-Type": "multipart/form-data"}})
                .then((response) => {
                    this.addAutoDialog = false;
                    this.getAutos();
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        handleChange(file) {
            this.form.auto_picture = [file.raw];
        },
        handleRemove(file, fileList) {
            console.log(file, fileList);
        },
        getAutos() {
            this.loading = true;
            this.$axios.get(`/autos`)
                .then((response) => {
                    this.loading = false;
                    if (response.data.data.length) {
                        this.data =  response.data.data;
                        this.meta = response.data.meta;
                    }else{
                        this.data = '';
                        this.meta = '';
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    },
    created(){
        this.getAutos()
    }
}
</script>

<style scoped>

</style>
