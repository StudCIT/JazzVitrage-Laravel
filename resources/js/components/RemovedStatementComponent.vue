<template>
    <div>
        <form role="form" @submit.prevent class="search">
            <i class="fa fa-search" aria-hidden="true"></i>
            <input v-model="search" type="text" class="form-control">
        </form>
        <div class="openImg" v-if="test" @click="closeImg">
            <img :src="test">
        </div>
      <table class="table table-bordered accordion" id="accordion">
          <thead>
                <tr>
                    <th>№</th>
                    <th>ПІБ Учасника / Назва групи</th>
                    <th>Тип заявки</th>
                    <th>Номінація</th>
                    <th width="30px"></th>
                    <th width="30px"></th>
                </tr>
          </thead>

          <tbody class="card" v-for="(item, index) in filteredList" :key="index">
                <tr>
                    <td data-toggle="collapse" :data-target="'#collapse'+(index+1)">
                        {{index+1}}
                    </td>
                    <td data-toggle="collapse" :data-target="'#collapse'+(index+1)">
                        {{ item.name }}
                    </td>
                    <td data-toggle="collapse" :data-target="'#collapse'+(index+1)">
                        {{ item.type }}
                    </td>
                    <td data-toggle="collapse" :data-target="'#collapse'+(index+1)">
                        {{ item.nomination }}
                    </td>
                    <td>
                        <a href="#" @click="unarchiveMember(item.id, index)"><i class="fa fa-2x fa-check-circle" aria-hidden="true"></i></a>
                    <td>
                        <a href="#" @click="deleteMember(item.id, index)"><i class="fa fa-2x fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
                <tr :id="'collapse'+(index+1)" class="collapse" data-parent="#accordion">
                    <td colspan="5" class="card-body">
                        <div class="col-5">
                            <p v-if="item.type == 'соліст' || item.type == 'дует'"><strong>ПІБ:</strong> {{ item.name }}</p>
                            <p v-else><strong>Назва колективу:</strong> {{ item.name }}</p>
                        </div>
                        <div class="col-5 type-style">
                            <p><strong>Тип:</strong> {{ item.type }}</p>
                            <p><strong>Номінація:</strong> {{ item.nomination }}</p>
                        </div>
                        <div class="mt-2"></div>
                        <div class="col-12">
                            <label for="memberDate" class="brtop" v-if="item.type == 'соліст'">Дата народження</label>
                            <p id="memberDate" v-if="item.type == 'соліст'">{{ item.memberDate }}</p>

                            <label for="memberAddress" class="brtop" v-if="item.type == 'соліст'">Домашня адреса</label>
                            <p id="memberAddress" v-if="item.type == 'соліст'">{{ item.memberAddress }}</p>

                            <label for="memberPassportData" class="brtop" v-if="item.type == 'соліст'">Паспортні дані</label>
                            <p id="memberPassportData" v-if="item.type == 'соліст'">{{ item.memberPassportData }}</p>

                            <label for="memberDate1" class="brtop" v-if="item.type == 'дует'">Дата народження першого учасника</label>
                            <p id="memberDate1" v-if="item.type == 'дует'">{{ item.memberDate1 }}</p>

                            <label for="memberDate2" class="brtop" v-if="item.type == 'дует'">Дата народження другого учасника</label>
                            <p id="memberDate2" v-if="item.type == 'дует'">{{ item.memberDate2 }}</p>

                            <label for="memberAddress1" class="brtop" v-if="item.type == 'дует'">Домашня адреса першого учасника</label>
                            <p id="memberAddress1" v-if="item.type == 'дует'">{{ item.memberAddress1 }}</p>

                            <label for="memberAddress2" class="brtop" v-if="item.type == 'дует'">Домашня адреса другого учасника</label>
                            <p id="memberAddress2" v-if="item.type == 'дует'">{{ item.memberAddress2 }}</p>

                            <label for="memberPassportData1" class="brtop" v-if="item.type == 'дует'">Паспортні дані першого учасника</label>
                            <p id="memberPassportData1" v-if="item.type == 'дует'">{{ item.memberPassportData1 }}</p>

                            <label for="memberPassportData2" class="brtop" v-if="item.type == 'дует'">Паспортні дані другого учасника</label>
                            <p id="memberPassportData2" v-if="item.type == 'дует'">{{ item.memberPassportData2 }}</p>

                            <label for="nameAgeCategory" class="brtop">Вікова категорія</label>
                            <p id="nameAgeCategory">{{ item.nameAgeCategory }}</p>

                            <label for="memberAverage" class="brtop" v-if="item.type == 'ансамбль' || item.type == 'Хор' || item.type == 'Оркестр'">Середній вік учасників</label>
                            <p id="memberAverage" v-if="item.type == 'ансамбль' || item.type == 'Хор' || item.type == 'Оркестр'">{{ item.memberAverage }}</p>

                            <label for="memberIdCode" class="brtop" v-if="item.type == 'соліст'">Ідентифікаційний номер учня</label>
                            <p id="memberIdCode" v-if="item.type == 'соліст'">{{ item.idCode }}</p>

                            <label for="memberIdCode1" class="brtop" v-if="item.type == 'дует'">Ідентифікаційний номер першого учасника</label>
                            <p id="memberIdCode1" v-if="item.type == 'дует'">{{ item.idCode1 }}</p>

                            <label for="memberIdCode2" class="brtop" v-if="item.type == 'дует'">Ідентифікаційний номер другого учасника</label>
                            <p id="memberIdCode2" v-if="item.type == 'дует'">{{ item.idCode2 }}</p>

                            <label for="memberPhoto" class="brtop" v-if="item.type == 'соліст' || item.type == 'дует'">Фото документів</label>
                            <p></p>

                            <div id="memberPhoto" class="row" v-if="item.type == 'соліст'">
                                <div class="col-2 statementPhotoDoc" @click="getFileImg(item.passport_photo)">
                                    <i class="fa fa-search"></i>
                                    <div class="mb-2">
                                        <img src="/img/file.png">
                                    </div>
                                    <label class="brtop mb-2">Копія свідоцтва про народження або паспорта</label>
                                </div>
                                <div class="col-2 statementPhotoDoc" @click="getFileImg(item.in_file)">
                                    <i class="fa fa-search"></i>
                                    <div class="mb-2">
                                        <img src="/img/file.png">
                                    </div>
                                    <label class="brtop mb-2">Копія ідентифікаційного коду</label>
                                </div>
                            </div>

                            <div id="memberPhoto" class="row" v-if="item.type == 'дует'">
                                <div class="col-2 statementPhotoDoc" @click="getFileImg(item.passport_photo1)">
                                    <i class="fa fa-search"></i>
                                    <div class="mb-2">
                                        <img src="/img/file.png">
                                    </div>
                                    <label class="brtop mb-2">Копія свідоцтва про народження або паспорта першого учасника</label>
                                </div>
                                <div class="col-2 statementPhotoDoc" @click="getFileImg(item.in_file1)">
                                    <i class="fa fa-search"></i>
                                    <div class="mb-2">
                                        <img src="/img/file.png">
                                    </div>
                                    <label class="brtop mb-2">Копія ідентифікаційного коду першого учасника</label>
                                </div>
                                <div class="col-2 statementPhotoDoc" @click="getFileImg(item.passport_photo2)">
                                    <i class="fa fa-search"></i>
                                    <div class="mb-2">
                                        <img src="/img/file.png">
                                    </div>
                                    <label class="brtop mb-2">Копія свідоцтва про народження або паспорта другого учасника</label>
                                </div>
                                <div class="col-2 statementPhotoDoc" @click="getFileImg(item.in_file2)">
                                    <i class="fa fa-search"></i>
                                    <div class="mb-2">
                                        <img src="/img/file.png">
                                    </div>
                                    <label class="brtop mb-2">Копія ідентифікаційного коду другого учасника</label>
                                </div>
                            </div>

                            <div id="memberDoc" class="row mb-2" v-if="item.type == 'ансамбль' || item.type == 'Хор' || item.type == 'Оркестр'">
                                <div class="col-2 statementPhotoDoc" @click="getFile(item.file)">
                                    <i class="fa fa-search"></i>
                                    <div class="mb-2">
                                        <img src="/img/file.png">
                                    </div>
                                    <label class="brtop mb-2">Документ с датами народження учасників</label>
                                </div>
                            </div>

                            <hr>
                            <label for="school_name" class="brtop">Назва мистецького навчального закладу</label>
                            <p id="school_name">{{ item.school_name }}</p>

                            <label for="schoolContact" class="brtop">Адреса, телефон та e-mail навч. закладу</label>
                            <p id="schoolContact">{{ `${item.school_address} / ${item.school_phone} / ${item.school_email}` }}</p>
                            <hr>
                            <div v-for="teacher in item.teachers" :key="teacher.teacher_id">
                                <label class="brtop">ПІП викладача</label>
                                <p>{{ `${teacher.teacher_surname} ${teacher.teacher_name} ${teacher.teacher_patronymic}` }}</p>
                                <label class="brtop">Контактний телефон викладача</label>
                                <p>{{ teacher.teacher_phone }}</p>
                                <label class="brtop">Контактний телефон викладача</label>
                                <p>{{ teacher.teacher_phone }}</p>
                                <label class="brtop">Email викладача</label>
                                <p>{{ teacher.teacher_email }}</p>

                                <div v-if="item.type == 'ансамбль' || item.type == 'Хор' || item.type == 'Оркестр'">
                                    <label class="brtop">Домашня адреса викладача</label>
                                    <p>{{ teacher.teacher_address }}</p>
                                    <label class="brtop">Ідентифікаційний номер викладача</label>
                                    <p>{{ teacher.teacher_in }}</p>
                                    <label class="brtop">Дані свідотства про народження або паспорта</label>
                                    <p>{{ teacher.teacher_passport_data }}</p>
                                    <label class="brtop">Фото документів</label>
                                    <div id="memberPhoto" class="row">
                                        <div class="col-2 statementPhotoDoc" @click="getFileImg(teacher.teacher_passport)">
                                            <i class="fa fa-search"></i>
                                            <div class="mb-2">
                                                <img src="/img/file.png">
                                            </div>
                                            <label class="brtop mb-2">Копія свідоцтва про народження або паспорта</label>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                            </div>

                            <div v-if="item.concertmaster_surname == '' || item.concertmaster_name == '' || item.concertmaster_patronymic == ''"> </div>
                            <div v-else>
                                <label for="concertDate" class="brtop">ПІП концертмейстра</label>
                                <p id="concertDate">{{ `${item.concertmaster_name} ${item.concertmaster_surname} ${item.concertmaster_patronymic}` }}</p>
                            </div>

                            <label class="brtop mb-3">Програма та хронометраж кожного твору</label>
                            <p>Перший твір:</p>
                            <p class="composition-style">Назва: {{ item.compositionName }} Автор: {{ item.compositionAuthor }} Хронометраж: {{ item.compositionTiming }}</p>
                            <p>Другий твір:</p>
                            <p class="composition-style">Назва: {{ item.compositionName2 }} Автор: {{ item.compositionAuthor2 }} Хронометраж: {{ item.compositionTiming2 }}</p>
                            <br>
                            <label class="brtop mb-3">Відео конкурсу</label>
                            <p>
                                <video width="40%" id="videoMember" controls>
                                    <source v-if="item.video" :src="item.video" type="video/mp4">
                                </video>
                            </p>
                        </div>
                    </td>
                </tr>
            </tbody>
      </table>
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
                members: [],
                search: '',
                test: '',
                preloader: false
            };
        },
        components: {
            Spinner,
        },
        created () {
            this.getFullList();
        },
        computed: {
            filteredList() {
                return this.members.filter(members => {
                    return members.name.toLowerCase().includes(this.search.toLowerCase()) || members.type.toLowerCase().includes(this.search.toLowerCase())
                        || members.file || members.video || members.passport_photo || members.in_file
                })
            }
        },
        methods: {
	        getFullList() {
		        axios.get('/get-archive-members')
			        .then((response) => {
                        this.members = [];
				        response.data.forEach(member => {
					        if (member.solo_duet.length == 0 && member.status == "archive") {
						        this.members.push({
							        name: member.group.name,
                                    type: member.app_type.name,
	                                memberAverage: member.group.average_age,
	                                school_name: member.preparation.school_name,
	                                school_address: member.preparation.school_address,
	                                school_phone: member.preparation.school_phone,
	                                school_email: member.preparation.school_email,
	                                teachers: member.teachers,
	                                concertmaster_surname: member.preparation.concertmaster_surname,
	                                concertmaster_name: member.preparation.concertmaster_name,
	                                concertmaster_patronymic: member.preparation.concertmaster_patronymic,
	                                compositionName: member.presentation.composition_one,
	                                compositionAuthor: member.presentation.author_one,
	                                compositionTiming: member.presentation.time_one,
	                                compositionName2: member.presentation.composition_two,
	                                compositionAuthor2: member.presentation.author_two,
	                                compositionTiming2: member.presentation.time_two,
	                                file: member.group.file,
                                    groupId: member.group.group_people_id,
	                                nameAgeCategory: member.age_category,
                                    id: member.application_id,
                                    check: member.check,
                                    nomination: member.nomination.name,
                                    video: member.presentation.video
						        })
					        } else if (member.solo_duet.length == 1 && member.status == "archive") {
						        this.members.push({
							        name: `${member.solo_duet[0].surname} ${member.solo_duet[0].name} ${member.solo_duet[0].patronymic}`,
                                    type: member.app_type.name,
                                    memberDate: member.solo_duet[0].data_birthday.split('-').reverse().join('-'),
                                    memberAddress: member.solo_duet[0].member_address,
                                    memberPassportData: member.solo_duet[0].passport_data,
	                                idCode: member.solo_duet[0].in,
	                                school_name: member.preparation.school_name,
	                                school_address: member.preparation.school_address,
	                                school_phone: member.preparation.school_phone,
	                                school_email: member.preparation.school_email,
	                                teachers: member.teachers,
	                                concertmaster_surname: member.preparation.concertmaster_surname,
	                                concertmaster_name: member.preparation.concertmaster_name,
	                                concertmaster_patronymic: member.preparation.concertmaster_patronymic,
	                                compositionName: member.presentation.composition_one,
	                                compositionAuthor: member.presentation.author_one,
	                                compositionTiming: member.presentation.time_one,
	                                compositionName2: member.presentation.composition_two,
	                                compositionAuthor2: member.presentation.author_two,
	                                compositionTiming2: member.presentation.time_two,
	                                passport_photo: member.solo_duet[0].passport_photo,
	                                in_file: member.solo_duet[0].in_file,
	                                nameAgeCategory: member.age_category,
                                    id: member.application_id,
                                    check: member.check,
                                    nomination: member.nomination.name,
                                    video: member.presentation.video
						        })
					        } else if (member.solo_duet.length == 2 && member.status == "archive") {
						        this.members.push({
							        name: `${member.solo_duet[0].surname} ${member.solo_duet[0].name} ${member.solo_duet[0].patronymic}, ${member.solo_duet[1].surname} ${member.solo_duet[1].name} ${member.solo_duet[1].patronymic}`,
                                    type: member.app_type.name,
	                                memberDate1: member.solo_duet[0].data_birthday.split('-').reverse().join('-'),
                                    memberDate2: member.solo_duet[1].data_birthday.split('-').reverse().join('-'),
                                    memberAddress1: member.solo_duet[0].member_address,
                                    memberAddress2: member.solo_duet[1].member_address,
	                                idCode1: member.solo_duet[0].in,
                                    idCode2: member.solo_duet[1].in,
                                    memberPassportData1: member.solo_duet[0].passport_data,
                                    memberPassportData2: member.solo_duet[1].passport_data,
	                                school_name: member.preparation.school_name,
	                                school_address: member.preparation.school_address,
	                                school_phone: member.preparation.school_phone,
	                                school_email: member.preparation.school_email,
	                                teachers: member.teachers,
	                                concertmaster_surname: member.preparation.concertmaster_surname,
	                                concertmaster_name: member.preparation.concertmaster_name,
	                                concertmaster_patronymic: member.preparation.concertmaster_patronymic,
	                                compositionName: member.presentation.composition_one,
	                                compositionAuthor: member.presentation.author_one,
	                                compositionTiming: member.presentation.time_one,
	                                compositionName2: member.presentation.composition_two,
	                                compositionAuthor2: member.presentation.author_two,
	                                compositionTiming2: member.presentation.time_two,
	                                passport_photo1: member.solo_duet[0].passport_photo,
	                                in_file1: member.solo_duet[0].in_file,
	                                passport_photo2: member.solo_duet[1].passport_photo,
	                                in_file2: member.solo_duet[1].in_file,
	                                nameAgeCategory: member.age_category,
                                    id: member.application_id,
                                    check: member.check,
                                    nomination: member.nomination.name,
                                    video: member.presentation.video
						        })
					        }
				        });
			        })
            },
            getFileImg(file) {
                axios({
                    url: "/"+file,
                    method: 'GET',
                    responseType: 'blob'
                }).then((response) => {
                    var fileURL = window.URL.createObjectURL(response.data);
                    this.test = fileURL;
                });
            },
            getFile(file) {
                axios({
                    url: "/"+file,
                    method: 'GET',
                    responseType: 'blob'
                }).then((response) => {
                    var link = document.createElement('a');
                    var fileURL = window.URL.createObjectURL(response.data);
                    link.setAttribute('href', fileURL);
                    link.setAttribute('download','download');
                    link.click();
                });
            },
            closeImg() {
                this.test = '';
            },
	        unarchiveMember(id, index) {
                this.preloader = !this.preloader;
		        axios.post('/unarchive-members/' + id)
			        .then((response) => {
                        this.members.splice(index, 1);
                        this.preloader = !this.preloader;
				        swal("Учасник був успішно повернений", {
					        icon: "success",
				        });
                    })
                    .catch((error) => {
                        this.preloader = !this.preloader;
                        swal({
                            icon: "error",
                            title: 'Помилка',
                            text: 'Не вдалося '
                        });
                    });
            },
	        deleteMember(id, index) {
                swal({
                    title: "Бажаєте видалити?",
                    text: "Вкажіть причину видалення",
                    content: "input",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then( (inputValue) => {
                    if (inputValue === false) return false;
                    else if (inputValue === "") {
                        swal.showInputError("Ви маєте вказати причину");
                        return false
                    }
                    else if (inputValue){
                        const data = {
                            message: inputValue,
                        };
                        this.preloader = !this.preloader;
                        axios.post('/delete-members/' + id, data)
                            .then((response) => {
                                this.preloader = !this.preloader;
                                this.members.splice(index, 1);
                                swal("Учасник був успішно видалений", {
                                    icon: "success",
                                });
                            })
                            .catch((error) => {
                                this.preloader = !this.preloader;
                                swal({
                                    icon: "error",
                                    title: 'Помилка',
                                    text: 'Не вдалося'
                                });
                            });
                    }
                })
	        }
        }
    }
</script>
