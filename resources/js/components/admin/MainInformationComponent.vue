<template>
    <div>
        <form enctype="multipart/form-data">
            <div class="row">
                <div class="col-5">

                    <!-- Загальні налаштування -->

                    <h3>Загальні налаштування</h3>
                    <hr>
                    <label for="logo" class="brtop">Логотип</label>
                    <div class="row">
                        <div class="col-9">
                            <label class="custom-file w-100">
                                <input type="file" class="custom-file-input" id="logo" name="logo" ref="logo" @change="previewFiles($event, 'logo')" accept=".jpg, .jpeg, .png, .bmp" v-validate="{ 'ext':['jpg', 'jpeg', 'png', 'bmp'] }">
                                <span class="custom-file-control">Файл не обрано</span>
                            </label>
                        </div>
                        <div class="col-3">
                            <button type="button" :disabled="errors.has('logo')" class="btn btn-outline-secondary edit w-100 px-0" @click='editFile("logo_section", "logo", "img")'>Зберегти</button>
                        </div>
                        <p class="text-danger col-9" v-if="errors.has('logo')">Файл повинен бути зображенням</p>
                    </div>
                    <img v-if="!errors.has('logo')" class="mt-3 w-50" :src="info.logo">
                    <hr>
                    <div>
                        <label for="description" class="brtop">Опис сайту</label>
                        <textarea name="description" class="form-control" v-model="info.description" id="description" rows="4" disabled
                            v-validate="{ required: true}"
                                data-vv-as="Опис сайту"></textarea>
                        <span class="errors text-danger" v-if="errors.has('description')">
                                {{ errors.first('description') }}
                        </span>
                        <button type="button" class="btn btn-outline-secondary my-2 px-5 float-right edit" @click='edit($event, "logo_section", "description")'>Редагувати</button><br><br>
                    </div>
                    <hr>
                    <div>
                        <label for="ticker" class="brtop">Рухомий рядок</label>
                        <textarea name="ticker" class="form-control" v-model="info.ticker" id="ticker" rows="4" disabled
                            v-validate="{ required: true}"
                                data-vv-as="Рухомий рядок"></textarea>
                            <span class="errors text-danger" v-if="errors.has('ticker')">
                                {{ errors.first('ticker') }}
                            </span>
                        <button type="button" class="btn btn-outline-secondary my-2 px-5 float-right edit" @click='edit($event, "logo_section", "ticker")'>Редагувати</button><br>
                    </div>


                    <!-- Згода на збір персональних даних -->
                    <br>
                    <h3>Згода на збір персональних даних</h3>
                    <div>
                        <label for="personal_data" class="brtop">Файл документу про згоду</label>
                        <div class="row">
                            <div class="col-9">
                                <label class="custom-file w-100">
                                    <input type="file" class="custom-file-input" accept=".pdf, .doc, .docx, .txt" v-validate="{ 'ext':['pdf', 'doc', 'txt', 'docx'] }" name="personal_data" id="personal_data" ref="personal_data" @change="previewFiles">
                                    <span class="custom-file-control">{{ info.personal_data.split('/')[2] }}</span>
                                </label>
                            </div>
                            <div class="col-3">
                                <button type="button" :disabled="errors.has('document')" class="btn btn-outline-secondary edit w-100 px-0" @click='editFile("position_section", "personal_data", "file")'>Зберегти</button>
                            </div>
                            <p class="text-danger col-9" v-if="errors.has('document')">Файл повинен відповідати формату: pdf, doc, txt, docx</p>
                        </div>
                    </div>


                    <!-- Логотипи номінацій -->
                    <br>
                    <h3>Логотипи номінацій</h3>
                    <div v-for="item in nominations" :key="item.nomination_id">
                        <label :for="'instrumental_logo_'+item.nomination_id" class="brtop">{{ item.name }}</label>
                        <div class="row">
                            <div class="col-9">
                                <label class="custom-file w-100">
                                    <input
                                        type="file"
                                        class="custom-file-input"
                                        :id="'instrumental_logo_'+item.nomination_id"
                                        :name="'instrumental_logo_'+item.nomination_id"
                                        :ref="'instrumental_logo_'+item.nomination_id"
                                        @change="previewFilesNomination($event, item.nomination_id-1)"
                                        accept=".png"
                                        v-validate="{ 'ext':['png'] }"
                                    >
                                    <span class="custom-file-control">Файл не обрано</span>
                                </label>
                            </div>
                            <div class="col-3">
                                <button
                                    type="button"
                                    :disabled="errors.has('instrumental_logo_'+item.nomination_id)"
                                    class="btn btn-outline-secondary edit w-100 px-0"
                                    @click="editNomination(item.nomination_id, 'instrumental_logo_'+item.nomination_id)"
                                >
                                    Зберегти
                                </button>
                            </div>
                            <p class="text-danger col-9" v-if="errors.has('instrumental_logo_'+item.nomination_id)">Файл повинен бути зображенням</p>
                        </div>
                        <img v-if="!errors.has('instrumental_logo_'+item.nomination_id)" class="mt-3 w-50" :src="item.logo">
                        <hr>
                    </div>
                    <!-- Положення -->
                    <br>
                    <h3>Положення</h3>
                    <hr>
                    <div>
                        <label for="provisions_text" class="brtop">Короткий опис положення</label>
                        <textarea name="provisions_text" class="form-control" v-model="info.provisions_text" id="provisions_text" rows="4" disabled
                            v-validate="{ required: true}"
                                data-vv-as="Короткий опис положення"></textarea>
                                <span class="errors text-danger" v-if="errors.has('provisions_text')">
                                    {{ errors.first('provisions_text') }}
                                </span>
                                </div>
                        <button type="button" class="btn btn-outline-secondary my-2 px-5 float-right edit" @click='edit($event, "position_section", "provisions_text")'>Редагувати</button><br><br>

                    <hr>
                    <div>
                    <label for="file" class="brtop">Файл документу про положення</label>
                    <div class="row">
                        <div class="col-9">
                            <label class="custom-file w-100">
                                <input type="file" class="custom-file-input" accept=".pdf" v-validate="{ 'ext':'pdf' }" name="document" id="file" ref="file" @change="previewFiles">
                                <span class="custom-file-control">{{ info.file.split('/')[2] }}</span>
                            </label>
                        </div>
                        <div class="col-3">
                            <button type="button" :disabled="errors.has('document')" class="btn btn-outline-secondary edit w-100 px-0" @click='editFile("position_section", "file", "file")'>Зберегти</button>
                        </div>
                        <p class="text-danger col-9" v-if="errors.has('document')">Файл повинен відповідати pdf-формату</p>
                    </div>
                    </div>
                    <hr>
                    <label for="video" class="brtop">Відео для положення конкурсу (YouTube)</label>
                    <div class="row">
                        <div class="col-9">
                            <input name="video" type="text" class="form-control" v-model="info.video" id="video" disabled
                                v-validate="{required: true, regex: /(?:https?:\/\/)?(?:www\.)?youtu\.?be(?:\.com)?\/?.*(?:watch|embed)?(?:.*v=|v\/|\/)([\w\-_]+)\&?/}">
                            <span class="text-danger" v-if="errors.has('video')">Некоректне посилання</span>
                        </div>
                        <div class="col-3">
                            <button type="button" :disabled="errors.has('video')" class="btn btn-outline-secondary edit w-100 px-0" @click='edit($event, "position_section", "video")'>Редагувати</button>
                        </div>
                    </div>
                    <iframe class="mt-3" width="100%" height="300" :src="'https://www.youtube.com/embed/'+info.video.slice(info.video.length - 11, info.video.length)" frameborder="0" allowfullscreen></iframe>
                    <hr>
                    <!-- Цитати -->
                    <label for="quote" class="brtop">Цитати</label>
                    <div class="row mt-2" v-for="(quote, index) in quotes" :key="'quote'+index">
                        <div class="col-9">
                            <textarea name="quote" class="form-control" id="quote" cols="30" rows="3" v-model="quote.text" :disabled="quote.disabled == '' ? quote.disabled : true"
                                 v-validate="{ required: true}"
                                    data-vv-as="Цитати">
                            </textarea>
                        </div>
                        <div class="col-3 pa-0">
                            <button type="button" class="btn btn-outline-secondary float-right ml-2 mb-1 w-40" style="width: 40px" @click="delQuotes($event, quote, index, quote.quote_id)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            <button v-if="quote !== editing && quote.disabled != false" type="button" style="width: 40px" class="btn btn-outline-secondary float-right" @click='editQuote(quote, "quote", index)'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            <button :disabled="errors.has('quote')" v-else type="button" style="width: 40px" class="btn btn-outline-secondary float-right" @click='saveQuotes(quote, "quote", index)'><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <span class="errors text-danger" v-if="errors.has('quote')">
						{{ errors.first('quote') }}
					</span>
                    <button type="button" class="btn btn-outline-secondary btn-block my-2" @click="addQuotes">Додати цитату</button>

                </div>
                <div class="col-2"></div>
                <div class="col-5">

                    <!-- Гімн -->
                    <h3>Гімн</h3>
                    <hr>
                    <label for="hymn_text" class="brtop">Текст гімну</label>
                    <textarea name="hymn_text" class="form-control" v-model="info.hymn_text" id="hymn_text" rows="10" disabled
                        v-validate="{ required: true}"
                            data-vv-as="Текст гімну"></textarea>
                            <span class="errors text-danger" v-if="errors.has('hymn_text')">
                                {{ errors.first('hymn_text') }}
                            </span>
                    <button type="button" class="btn btn-outline-secondary my-2 px-5 float-right edit" @click='edit($event, "hymn_section", "hymn_text")'>Редагувати</button><br><br>
                    <hr>
                    <label for="audio" class="brtop">Аудіоматеріал</label>

                    <div class="row">
                        <div class="col-9">
                            <label class="custom-file w-100">
                                <input type="file" v-validate="{ 'ext':['mp3', 'flac', 'aif', 'ac3', 'amr', 'aud', 'iff', 'wav'] }" accept=".mp3, .flac, .aif, .ac3, .amr, .aud, .iff, .wav" name="audio" class="custom-file-input" id="audio" ref="audio" @change="previewFiles">
                                <span class="custom-file-control">{{ info.audio.split('/')[2] }}</span>
                            </label>
                        </div>
                        <div class="col-3">
                            <button type="button" :disabled="errors.has('audio')" class="btn btn-outline-secondary edit w-100 px-0" @click='editFile("hymn_section", "audio", "audio")'>Зберегти</button>
                        </div>
                        <p class="text-danger col-9" v-if="errors.has('audio')">Файл не відповідає музичному формату</p>
                    </div>
                    <hr>
                    <label for="note_image" class="brtop">Зображення для нот</label>

                    <div class="row">
                        <div class="col-9">
                            <label class="custom-file w-100">
                                <input type="file" v-validate="{ 'ext':['jpg', 'jpeg', 'png', 'bmp'] }" name="note" class="custom-file-input" accept=".jpg, .jpeg, .png, .bmp" id="note_image" ref="note_image" @change="previewFiles($event, 'note_image')">
                                <span class="custom-file-control">Файл не обрано</span>
                            </label>
                        </div>
                        <div class="col-3">
                            <button type="button" :disabled="errors.has('note')" class="btn btn-outline-secondary edit w-100 px-0" @click='editFile("hymn_section", "note_image", "img")'>Зберегти</button>
                        </div>
                        <p class="text-danger col-9" v-if="errors.has('note')">Файл повинен бути зображенням</p>
                    </div>
                    <img v-if="!errors.has('note')" class="mt-3 w-50" :src="info.note_image">
                    <!-- Контакти -->
                    <br>
                    <h3 class="mt-3">Контакти</h3>
                    <hr>
                    <label for="address" class="brtop">Адреса</label>
                    <div class="row" v-for="(addressItem, index) in contact.address" :key="'address'+index">
                        <div class="col-10">
                            <input type="text" name="address" class="form-control" v-model="addressItem.contact" id="address" :disabled="addressItem.disabled == '' ? addressItem.disabled : true"
                                v-validate="{ required: true}"
                                    data-vv-as="Адреса">
                            <span class="errors text-danger" v-if="errors.has('address')">
								{{ errors.first('address') }}
						    </span>
                        </div>
                        <div class="col-2 pa-0">
                            <button v-if="addressItem !== editing" type="button"  style="width: 40px" class="btn btn-outline-secondary float-right" @click='editContact(addressItem, "address", index)'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            <button v-else type="button"  style="width: 40px" class="btn btn-outline-secondary float-right" @click='saveContact("address", index)'><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <hr>
                    <label for="phones" class="brtop">Телефон</label>
                    <div class="row mt-2" v-for="(phone, index) in contact.phones" :key="'phone'+index">
                        <div class="col-9">
                            <input type="text" name="phones" class="form-control" v-model="phone.contact" id="phones" :disabled="phone.disabled == '' ? phone.disabled : true"
                                v-validate="{ required: true, regex: /^(\s*)?(\+)?([- _()]?\d[- _()]?){10,12}(\s*)?$/ }"
                                    data-vv-as="Телефон">
                        </div>
                        <div class="col-3 pa-0">
                            <button type="button" class="btn btn-outline-secondary float-right ml-2 mb-1" style="width: 40px" @click="del(index, phone.contact_items_id, 'phones')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            <button v-if="phone !== editing && phone.disabled != false" type="button" style="width: 40px" class="btn btn-outline-secondary float-right" @click='editContact(phone, "phones", index)'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            <button :disabled="errors.has('phone')" v-else type="button" style="width: 40px" class="btn btn-outline-secondary float-right" @click='saveContact("phones", index)'><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                        </div>
                    </div>
                            <span class="errors text-danger" v-if="errors.has('phones')">
								{{ errors.first('phones') }}
						    </span>
                    <button type="button" class="btn btn-outline-secondary btn-block mt-2" @click="add('phones')">Додати телефон</button>

                    <!-- Соціальні мережі -->
                    <hr>
                    <label for="social" class="brtop">Соціальні мережі</label>
                    <div class="row mt-2" v-for="(social, index) in contact.socials" :key="'social'+index">
                        <div class="col-5">
                            <input type="text" name="socialLink" class="form-control" v-model="social.contact" id="socialLink" :disabled="social.disabled == '' ? social.disabled : true"
                                v-validate="{ required: true, regex: /^((http|https|ftp):\/\/)(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/i}">

                        </div>
                        <div class="col-4">
                            <input type="text" name="socialTitle" class="form-control" v-model="social.contact_title" id="socialTitle" :disabled="social.disabled == '' ? social.disabled : true"
                                v-validate="{ required: true}"
                                    data-vv-as="Соціальні мережі">

                        </div>
                        <div class="col-3 pa-0">
                            <button type="button" class="btn btn-outline-secondary float-right ml-2 mb-1" style="width: 40px" @click="del(index, social.contact_items_id, 'socials')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            <button v-if="social !== editing && social.disabled != false" type="button" style="width: 40px" class="btn btn-outline-secondary float-right" @click='editSocial(social, "social", index)'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            <button v-else type="button" style="width: 40px" class="btn btn-outline-secondary float-right" @click='saveSocial("social", index)'><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-5">
                            <span class="errors text-danger" v-if="errors.has('socialLink')">
                                   Некоректне посилання (введіть повну URL-адресу)
                            </span>
                            </div>
                            <div class="col-5">
                            <span class="errors text-danger" v-if="errors.has('socialTitle')">
                                    {{ errors.first('socialTitle') }}
                            </span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-block mb-4" @click="add('socials')">Додати соціальну мережу</button>

                    <!-- Майстер клас -->

                    <h3>Майстер клас</h3>
                    <hr>
                    <label for="title_master" class="brtop">Заголовок</label>
                    <div class="row">
                        <div class="col-9">
                            <input name="title_master" type="text" class="form-control" v-model="info.title_master" id="title_master" disabled v-validate="{required: true}">
                            <span class="text-danger" v-if="errors.has('title_master')">Некоректне посилання</span>
                        </div>
                        <div class="col-3">
                            <button type="button" :disabled="errors.has('title_master')" class="btn btn-outline-secondary edit w-100 px-0" @click='edit($event, "master_class", "title_master")'>Редагувати</button>
                        </div>
                    </div>
                    <hr>
                    <label for="title_gallery_master" class="brtop">Заголовок галереї</label>
                    <div class="row">
                        <div class="col-9">
                            <input name="title_gallery_master" type="text" class="form-control" v-model="info.title_gallery_master" id="title_gallery_master" disabled v-validate="{required: true}">
                            <span class="text-danger" v-if="errors.has('title_gallery_master')">Некоректне посилання</span>
                        </div>
                        <div class="col-3">
                            <button type="button" :disabled="errors.has('title_master')" class="btn btn-outline-secondary edit w-100 px-0" @click='edit($event, "master_class", "title_gallery_master")'>Редагувати</button>
                        </div>
                    </div>
                    <hr>
                    <label for="title_req_master" class="brtop">Заголовок заявок</label>
                    <div class="row">
                        <div class="col-9">
                            <input name="title_req_master" type="text" class="form-control" v-model="info.title_req_master" id="title_req_master" disabled v-validate="{required: true}">
                            <span class="text-danger" v-if="errors.has('title_req_master')">Некоректне посилання</span>
                        </div>
                        <div class="col-3">
                            <button type="button" :disabled="errors.has('title_req_master')" class="btn btn-outline-secondary edit w-100 px-0" @click='edit($event, "master_class", "title_req_master")'>Редагувати</button>
                        </div>
                    </div>

                    <hr>
                    <div>
                        <label for="info_message" class="brtop">Додаткова інформація</label>
                        <textarea name="info_message" class="form-control" v-model="info.info_message" id="info_message" rows="4" disabled
                            v-validate="{ required: true}"
                                data-vv-as="Додаткова інформація"></textarea>
                        <span class="errors text-danger" v-if="errors.has('info_message')">
                                {{ errors.first('info_message') }}
                        </span>
                        <button type="button" class="btn btn-outline-secondary my-2 px-5 float-right edit" @click='edit($event, "master_class", "info_message")'>Редагувати</button><br><br>
                    </div>
                    <hr>

                    <label for="logo_master" class="brtop">Логотип</label>
                    <div class="row">
                        <div class="col-9">
                            <label class="custom-file w-100">
                                <input type="file" class="custom-file-input" id="logo_master" name="logo_master" ref="logo_master" @change="previewFiles($event, 'logo_master')" accept=".jpg, .jpeg, .png, .bmp" v-validate="{ 'ext':['jpg', 'jpeg', 'png', 'bmp'] }">
                                <span class="custom-file-control">Файл не обрано</span>
                            </label>
                        </div>
                        <div class="col-3">
                            <button type="button" :disabled="errors.has('logo_master')" class="btn btn-outline-secondary edit w-100 px-0" @click='editFile("master_class", "logo_master", "img")'>Зберегти</button>
                        </div>
                        <p class="text-danger col-9" v-if="errors.has('logo')">Файл повинен бути зображенням</p>
                    </div>
                    <img v-if="!errors.has('logo_master')" class="mt-3 w-50" :src="info.logo_master">
                    <hr>
                    <div>
                        <label for="description_master" class="brtop">Опис майтер класу</label>
                        <textarea name="description_master" class="form-control" v-model="info.description_master" id="description_master" rows="4" disabled
                            v-validate="{ required: true}"
                                data-vv-as="Опис майтер класу"></textarea>
                        <span class="errors text-danger" v-if="errors.has('description_master')">
                                {{ errors.first('description_master') }}
                        </span>
                        <button type="button" class="btn btn-outline-secondary my-2 px-5 float-right edit" @click='edit($event, "master_class", "description_master")'>Редагувати</button><br><br>
                    </div>


                    <br>
                    <h3>Заявки</h3>
                    <hr>
                    <label for="compress_url" class="brtop">Посилання на ресурс для стискання відео</label>
                    <div class="row">
                        <div class="col-9">
                            <input name="compress_url" type="text" class="form-control" v-model="info.compress_url" id="compress_url" disabled
                                v-validate="{required: true}">
                            <span class="text-danger" v-if="errors.has('compress_url')">Некоректне посилання</span>
                        </div>
                        <div class="col-3">
                            <button type="button" :disabled="errors.has('compress_url')" class="btn btn-outline-secondary edit w-100 px-0" @click='edit($event, "position_section", "compress_url")'>Редагувати</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { imgValid } from "../../mixins/validation";
export default {
    data() {
        return {
            editing: {},
            info: {
                logo: '',
                description: '',
                ticker: '',
                provisions_text: '',
                video: '',
                audio: '',
                file: '',
                personal_data: '',
                hymn_text: '',
                note_image: '',
                logo_master: '',
                description_master: '',
                info_message: '',
                compress_url: ''
            },
            nominations: [],
            contact: {
                address: [],
                phones: [],
                socials: []
            },
            quotes: [],
            form: new FormData,
            showButton: true
        };
    },
	created () {
        this.getAllInfo();
        this.getQuotes();
    },
    validations: {
        info: {
            logo: { imgValid },
        }
    },
    methods: {

        previewFilesNomination(event, id) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = (e) => {
                    this.nominations[id].logo = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
                input.parentNode.querySelector('span').innerHTML = input.files[0].name;
            }
        },


        previewFiles(event, el) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = (e) => {
                    this.info[el] = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
                input.parentNode.querySelector('span').innerHTML = input.files[0].name;
            }
        },
        editSocial(social, el, index) {
            const textElementLink = document.querySelectorAll('#'+el+"Link")[index];
            const textElementTitle = document.querySelectorAll('#'+el+"Title")[index];
            textElementLink.removeAttribute('disabled');
            textElementTitle.removeAttribute('disabled');
            textElementLink.focus();
            this.editing = social;
        },
        saveSocial(el, index) {
            this.$validator.validateAll().then((result) => {
                if (!result) {
                    return;
                }
                else {
                    const textElementLink = document.querySelectorAll('#'+el+"Link")[index];
                    const textElementTitle = document.querySelectorAll('#'+el+"Title")[index];
                    textElementLink.setAttribute('disabled', 'disabled');
                    textElementTitle.setAttribute('disabled', 'disabled');
                    this.editing = {};
                    this.contact.socials[index].disabled = true;
                    axios.post('/post-social', {
                        id: this.contact.socials[index].contact_items_id,
                        contact: this.contact.socials[index].contact,
                        contact_title: this.contact.socials[index].contact_title,
                        contact_section_id: 3
                    }).then((res) => {
                        this.contact.socials[index].contact_section_id = res.data.contact_section_id;
                        this.contact.socials[index].contact_items_id = res.data.id;
                    })
                }
            });

        },
        editContact(phone, el, index) {
            const textElement = document.querySelectorAll('#'+el)[index];
            textElement.removeAttribute('disabled');
            textElement.focus();
            this.editing = phone;
        },
        saveContact(el, index) {

            this.$validator.validateAll().then((result) => {
                if (!result) {
                    return;
                }
                else {
                    this.selectElement(el, this.contact[el][index], index);
                    axios.post('/post-contact', {
                        id: this.contact[el][index].contact_items_id,
                        contact: this.contact[el][index].contact,
                        contact_section_id: this.contact[el][index].contact_section_id
                    }).then((res) => {
                        this.contact[el][index].contact_section_id = res.data.contact_section_id;
                        this.contact[el][index].contact_items_id = res.data.id;
                        swal("Інформація оновлена", {
                            icon: "success",
                            timer: 1000,
                            button: false
                        });
                    })
                }
            });
        },

        editNomination(id, ref) {
            this.form.append('logo', this.$refs[ref][0].files[0]);
            axios.post('/api/put-nomination/'+id, this.form)
	            .then((response) => {
		            swal("Інформація оновлена", {
			            icon: "success",
			            timer: 1000,
			            button: false
		            });
	            })
	            .catch((error) => {
		            swal({
			            icon: "error",
			            title: 'Помилка',
			            text: 'Файл не обрано'
		            });
	            });
        },

        editFile(table, row, type) {
            this.form.append('type', type);
            this.form.append('table', table);
            this.form.append('row', row);
            this.form.append('file', this.$refs[row].files[0]);
            axios.post('/post-info-file', this.form)
	            .then((response) => {
		            swal("Інформація оновлена", {
			            icon: "success",
			            timer: 1000,
			            button: false
		            });
	            })
	            .catch((error) => {
		            swal({
			            icon: "error",
			            title: 'Помилка',
			            text: 'Файл не обрано'
		            });
	            });
        },

        edit(event, table, el) {
            this.$validator.validateAll().then((result) => {
	            if (!result) {
		            return;
	            }
                else {
                    const textElement = document.getElementById(el);
                    if(this.showButton) {
                        textElement.removeAttribute('disabled');
                        textElement.focus();
                        event.target.innerHTML = 'Зберегти';
                        this.showButton = false;
                    }
                    else {
                        textElement.setAttribute('disabled', 'disabled');
                        event.target.innerHTML = 'Редагувати';
                        axios.post('/post-info', {
                            table,
                            row: el,
                            value: textElement.value
                        });
                        swal("Інформація оновлена", {
                            icon: "success",
                            timer: 1000,
                            button: false
                        });
                        this.showButton = true;
                    }
                }
            });
        },
	    editQuote(quote, el, index) {
		    const textElement = document.querySelectorAll('#'+el)[index];
		    textElement.removeAttribute('disabled');
		    textElement.focus();
		    this.editing = quote;
	    },
	    getAllInfo() {
		    axios.get('/get-all-info')
			    .then((response) => {
                    this.nominations = response.data.nominations;
                    response.data.info.map(item => {
                        Object.assign(this.info, item);
                    }),
                    response.data.contact.map(item => {
                        Object.assign(this.contact[item.caption], item.contacts_items);
                    })
			    })
        },

        // Quotes
        getQuotes() {
            axios.get('/get-quotes')
            .then((response) => {
                this.quotes = response.data;
            })
        },
        addQuotes() {
             this.$validator.validateAll().then((result) => {
                    if (!result) {
                        return;
                    }
                    else {
                        this.quotes.push({text: '', disabled: false});
                    }
             });
        },
	    delQuotes(event, quote, index, id) {
		    if (id == quote.quote_id) {
		    	event.preventDefault();
			    axios.post('/delete-quote/' + id);
			    this.quotes.splice(index, 1);
		    }
	    },
	    saveQuotes(quote, el, index) {
		    this.$validator.validateAll().then((result) => {
			    if (!result) {
				    return;
			    } else {
				    this.selectElement(el, this.quotes[index], index);
				    if (quote.quote_id) {
					    axios.post('/put-quote', {
						    id: this.quotes[index].quote_id,
						    text: this.quotes[index].text,
					    })
				    } else {
					    axios.post('/post-quote', {
						    text: this.quotes[index].text,
					    }).then(res => {
						    this.quotes[index].quote_id = res.data.quote_id
					    })
				    }
			    }
		    });
	    },
        // End Quotes

        add(arr) {
            this.contact[arr].push({contact: '', disabled: false});
        },
        del(index, id, arr) {
            if(id) {
                axios.post('/delete-contact/'+id);
            }
            this.contact[arr].splice(index, 1);
        },

        selectElement(el, elArray, index) {
            const textElement = document.querySelectorAll('#'+el)[index];
            textElement.setAttribute('disabled', 'disabled');
            this.editing = {};
            elArray.disabled = true;
        },
    }
}
</script>
<style scope>
    .hasError {
        color: red;
    }
    button {
        overflow:hidden;
    }
</style>
