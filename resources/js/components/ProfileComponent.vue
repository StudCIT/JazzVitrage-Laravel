<template>
<div class="container bootstrap snippet">
    <div class="row">
  	    <div class="col-sm-4">
            <div class="text-center" v-if="authUser.role == 'superAdmin'">
                <img v-if="data.photo" :src="data.photo" class="avatar img-circle img-thumbnail" alt="avatar">
                <img v-else :src="'/img/user.png'" class="avatar img-circle img-thumbnail">
                <h6>Завантажити інше фото...</h6>
                <input type="file" id="photo" name="photo" ref="photo" @change="previewFiles($event)" accept="image/*" class="text-center center-block file-upload ml-2" v-validate="'image'"><br>
                <span class="errors text-danger ml-2" v-if="errors.has('foto')">
                    Оберіть файл графічного формату
                </span>
            </div>

            <div class="text-center" v-else>
                <img v-if="data.photo" :src="data.photo" class="avatar img-circle img-thumbnail" alt="avatar">
                <img v-else :src="'/img/user.png'" class="avatar img-circle img-thumbnail">
            </div>

            <br/>
            <ul class="list-group" style="margin-bottom: 10px">
                <li class="list-group-item text-muted">Діяльність</li>
                <li class="list-group-item text-right">
                    <span class="pull-left"><strong>Роль</strong></span>
                    <span v-if="data.role == 'jury'">Журі</span>
                    <span v-if="data.role == 'orgComittee'">Організаційний комітет</span>
                    <span v-if="data.role == 'admin'">Адмін</span>
                    <span v-if="data.role == 'superAdmin'">Супер Адмін</span>
                </li>
            </ul>
        </div>

    	<div class="col-sm-8">
          <div class="tab-content">
            <div class="tab-pane active" id="home">
                <form class="form" id="registrationForm">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-8">
                                <label for="surname"><h4>Прізвище</h4></label>
                                <input type="text" class="form-control" name="surname" id="surname" :disabled="authUser.role != 'superAdmin'" v-model="data.surname"
                                    v-validate="{ required: true, regex: /^([a-zа-яіїє'-]+){2,}$/i }">
                                <span class="errors text-danger" v-if="errors.has('surname')">
                                        Поле "Прізвище" має бути заповнене не менше, ніж 2 символами (вводити лише літери або тире)
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-8">
                                <label for="name"><h4>Ім'я</h4></label>
                                <input type="text" class="form-control" name="name" id="name" :disabled="authUser.role != 'superAdmin'" v-model="data.name"
                                    v-validate="{ required: true, regex: /^([a-zа-яіїє'-]+){2,}$/i }">
                                <span class="errors text-danger" v-if="errors.has('name')">
                                        Поле "Ім’я" має бути заповнене не менше, ніж 2 символами (вводити лише літери або тире)
                                </span>
                            </div>
                        </div>
                        <div class="form-group" v-show="data.role == 'jury' || data.role == 'orgComittee'">
                            <div class="col-8">
                                <label for="patronymic"><h4>По-батькові</h4></label>
                                <input type="text" class="form-control" name="patronymic" id="patronymic" :disabled="authUser.role != 'superAdmin'" v-model="data.patronymic"
                                    v-validate="{ required: true, regex: /^([a-zа-яіїє'-]+){5,}$/i }">
                                <span class="errors text-danger" v-if="errors.has('patronymic')">
                                        Поле "По-батькові" має бути заповнене не менше, ніж 5 символами (вводити лише літери або тире)
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-8">
                                <label for="email"><h4>Email</h4></label>
                                <input type="email" class="form-control" name="email" id="email" :disabled="authUser.role != 'superAdmin'" v-model="data.email" required
                                    v-validate="{ regex: /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/ }">
                                <span class="errors text-danger" v-if="errors.has('email')">
                                    Введіть дані у форматі name@email.com
                                </span>
                            </div>
                        </div>
                        <div class="form-group" v-show="data.role == 'jury'">
                            <div class="col-8">
                                <label for="rank"><h4>Звання</h4></label>
                                <input type="text" class="form-control" name="rank" id="rank" :disabled="authUser.role != 'superAdmin'" v-model="data.rank"
                                    v-validate="{ required: true }">
                                <span class="errors text-danger" v-if="errors.has('rank')">
                                        Обов'язкове поле
                                </span>
                            </div>
                        </div>
                        <div class="form-group" v-show="data.role == 'jury'">
                            <div class="col-8">
                                <label for="info1"><h4>Додаткова інформація</h4></label>
                                <textarea class="form-control" id="info1" name="info1" :disabled="authUser.role != 'superAdmin'" rows="3" v-model="data.informations"></textarea>
                            </div>
                        </div>
                        <div class="form-group" v-show="data.role == 'jury'">
                            <div class="col-8">
                                <label for="regalia"><h4>Регалії</h4></label>
                                <input type="text" class="form-control" name="regalia" :disabled="authUser.role != 'superAdmin'" id="regalia" v-model="data.regalia">
                            </div>
                        </div>
                        <div class="form-group" v-show="data.role == 'jury'">
                            <div class="col-8">
                                <label for="info1"><h4>Номінації</h4></label>
                                    <br>
                                    <input
                                        style="width: 20px;height: 20px;margin-top: -5px"
                                        type="checkbox"
                                        class="form-check-input"
                                        id="vocal"
                                        value="Вокальний жанр"
                                        v-model="nominations"
                                        :disabled="authUser.role != 'superAdmin'"
                                    >
                                    <label
                                        style="font-size: 20px"
                                        class="form-check-label"
                                        for="vocal"
                                    >
                                        Вокальний жанр
                                    </label>
                                    <br>
                                    <input
                                        style="width: 20px;height: 20px;margin-top: -5px"
                                        type="checkbox"
                                        class="form-check-input"
                                        id="instrum"
                                        value="Інструментальний жанр"
                                        v-model="nominations"
                                        :disabled="authUser.role != 'superAdmin'"
                                    >
                                    <label
                                        style="font-size: 20px"
                                        class="form-check-label"
                                        for="instrum"
                                    >
                                        Інструментальний жанр
                                    </label>
                                    <br>
                                    <input
                                        style="width: 20px;height: 20px;margin-top: -5px"
                                        type="checkbox"
                                        class="form-check-input"
                                        id="compoz"
                                        value="Композиція"
                                        v-model="nominations"
                                        :disabled="authUser.role != 'superAdmin'"
                                    >
                                    <label
                                        style="font-size: 20px"
                                        class="form-check-label"
                                        for="compoz"
                                    >
                                        Композиція
                                    </label>
                            </div>
                        </div>

                        <div class="form-group" v-show="data.role == 'orgComittee'">
                            <div class="col-8">
                                <label for="info2"><h4>Біографія</h4></label>
                                <textarea class="form-control" id="info2" :disabled="authUser.role != 'superAdmin'" name="info2" rows="3" v-model="data.informations"></textarea>
                            </div>
                        </div>

                        <div class="form-group" v-if="authUser.role == 'superAdmin'">
                            <div class="col-8">
                                <button type="button" :class="editPassword ? 'btn btn-primary' : 'btn btn-light'" @click="editPass">Змінити пароль</button>
                            </div>
                        </div>

                        <div class="form-group" v-if="editPassword">
                            <div class="col-8">
                                <label for="newPassword"><h4>Новий пароль</h4></label>
                                <input type="password" class="form-control" name="newPassword" id="newPassword" v-model="newPassword">
                            </div>
                        </div>
                        <div class="form-group" v-if="editPassword">
                            <div class="col-8">
                                <label for="repeatPassword"><h4>Повторіть пароль</h4></label>
                                <input type="password" class="form-control" name="repeatPassword" id="repeatPassword" v-model="repeatPassword">
                                <span class="errors text-danger" v-if="checkPass()">Паролі не співпадають</span>
                            </div>
                        </div>
                        <div class="form-group" v-if="authUser.role == 'superAdmin'">
                            <div class="col-12">
                                <button :disabled="!checkNewPassword || errors.any()" class="btn btn-lg btn-success" type="button" @click="save"><i class="glyphicon glyphicon-ok-sign"></i> Зберегти</button>
                            </div>
                        </div>
                    </div>
              	</form>
            </div>
        </div>
    </div>
</div>
<div v-if="preloader" class="preloader">
    <Spinner :status="preloader" :size="54"></Spinner>
</div>
</div>
</template>
<script>
import Spinner from 'vue-spinner-component/src/Spinner.vue';
export default {
    data() {
        return {
            data: [],
            nominations: [],
            password: '',
            newPassword: '',
            repeatPassword: '',
            editPassword: false,
            preloader: false,
            authUser: []
        }
    },
    components: {
        Spinner,
    },
    mounted() {
        this.getUser();
        this.getUserAuth();
    },
    computed: {
        checkNewPassword() {
            return !this.editPassword || ((this.newPassword == this.repeatPassword) && (this.newPassword != '' || this.repeatPassword != ''))
        }
    },
    methods: {
        checkPass(){
            if (this.newPassword != this.repeatPassword){
                return true;
            }
            else {
                return false;
            }
        },
        getUser() {
            axios.get(`/user/${this.$route.params.id}`)
            .then((response) => {
                this.data = response.data;
                this.nominations = response.data.nominations ? response.data.nominations.split(";") : [];
                this.data.photo = this.data.photo;
            })
        },
        getUserAuth() {
            axios.get('/get-user')
                .then((response) => {
                    this.authUser = response.data
                })
        },
        save() {
            this.preloader = !this.preloader;
            var form = new FormData;
            this.data.password = this.newPassword;
            this.data.nominations = this.nominations.join(';');
            form.append('photo', this.$refs.photo.files[0]);
            form.append('data', JSON.stringify(this.data));
                axios.post(`/user/${this.$route.params.id}`, form, {
                    headers: {
                    'Content-Type': 'multipart/form-data'
                    }
                })
                .then(() => {
                    swal("Дані збережено", {
                        icon: "success",
                    });
                    this.editPassword = false;
                    // this.editNomination = false;
                    this.preloader = !this.preloader;
                }).catch(() => {
                    this.preloader = !this.preloader;
                    swal({
                        icon: "error",
                        title: 'Помилка',
                        text: 'Не вдалося'
                    });
                })

        },
        previewFiles(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = (e) => {
                    this.data.photo = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        },
        editPass() {
            this.editPassword = !this.editPassword;
        },
        editNom() {
            this.editNomination = !this.editNomination;
        }
    }
}
</script>
