<template>
    <div>
        <h1 v-if="hasError" class='text-center'>Ой лишенько... виникли проблеми</h1>
        <template v-else>
            <div class="row">
                <div class="col-10">
                    <form role="form" @submit.prevent class="search">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <input v-model="search" type="text" class="form-control">
                    </form>
                </div>
                <div class="col-2">
                    <select class="form-control mt-2 w-100" id="member" @change="searchMembers">
                        <option value="" selected="selected">всі учасники</option>
                        <option value="Соліст">Соліст</option>
                        <option value="Дует">Дует</option>
                        <option value="Група">Група</option>
                    </select>
                </div>
            </div>
            <a href="/admin/vidomist-chleniv-zhuri" target="_blank" class="btn btn-outline-secondary">Загальна відомість членів журі</a>
            <a href="/admin/vidomist-dzhaz-vitrazh" target="_blank" class="btn btn-outline-secondary mx-2">Відомість джаз вітраж</a>
            <a href="/admin/list-members" target="_blank" class="btn btn-outline-secondary">Список учасників</a>
            <a href="/admin/сontact-members" target="_blank" class="btn btn-outline-secondary mx-2">Контактні дані</a>
            <a href="/admin/diploms" target="_blank" class="btn btn-outline-secondary">Таблиця для вручення дипломів</a>
        <br><br>
        <table class="table table-bordered" ref="printTable" id="allMembers">
            <thead>
                <tr>
                    <th width="30px">№</th>
                    <th>ПІБ Учасника / Назва групи</th>
                    <th>Тип заявки</th>
                    <th>Номінація</th>
                    <th>Рекомендації</th>
                    <th class="text-center" style="cursor: pointer" @click="sortByEvaluation()">Оцінка</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in filteredList" v-bind:key="item.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.type }}</td>
                    <td>{{ item.nomination }}</td>
                    <td>{{ item.recommendation }}</td>
                    <td class="text-center">{{ item.evaluation }}</td>
                </tr>
            </tbody>
        </table>


        </template>

    </div>
</template>
<script>

export default {
    data() {
        return {
            members: [],
            search: '',
            hasError: false,
            sorted: false

        }
    },
    created() {
        this.getFullList();
    },
    computed: {
        filteredList() {
            return this.members.filter(members => {
                return members.name.toLowerCase().includes(this.search.toLowerCase()) || members.type.toLowerCase().includes(this.search.toLowerCase())
            })
        },
    },
    methods: {
        getFullList() {
            axios.get('/get-rating')
                .then( ( response ) => {
                    response.data.forEach( ( member ) => {
                        if(member.solo_duet.length == 0) {
                            this.members.push({
                                id: member.application_id,
                                name: member.group.name,
                                type: member.app_type.name,
                                evaluation: Math.round(member.rating),
                                nomination: member.nomination.name,
                                recommendation: member.recommendation
                            })
                        } else if(member.solo_duet.length == 1) {
                            this.members.push({
                                id: member.application_id,
                                name: `${member.solo_duet[0].surname} ${member.solo_duet[0].name} ${member.solo_duet[0].patronymic}`,
                                type: member.app_type.name,
                                evaluation: Math.round(member.rating),
                                nomination: member.nomination.name,
                                recommendation: member.recommendation
                            })
                        } else if(member.solo_duet.length == 2) {
                            this.members.push({
                                id: member.application_id,
                                name: `${member.solo_duet[0].surname} ${member.solo_duet[0].name} ${member.solo_duet[0].patronymic}, ${member.solo_duet[1].surname} ${member.solo_duet[1].name} ${member.solo_duet[1].patronymic}`,
                                type: member.app_type.name,
                                evaluation: Math.round(member.rating),
                                nomination: member.nomination.name,
                                recommendation: member.recommendation
                            })
                        }
                    });
            })
            .catch( ( error)  => {
                console.error(error);
                this.hasError = true;
            })

        },
        sortByEvaluation() {
            if(this.sorted) {
                this.members.sort((a, b) => a.evaluation > b.evaluation ? 1 : -1);
            } else {
                this.members.sort((a, b) => a.evaluation < b.evaluation ? 1 : -1);
            }
            this.sorted = !this.sorted;
        },
        searchMembers(){
            var input, filter, table, tr, td, i;
            input = document.getElementById("member");
            filter = input.value.toLowerCase();
            table = document.getElementById("allMembers");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2];
                if (td.innerHTML.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                }
                else {
                    if (filter=="група" && td.innerText!="соліст" && td.innerText!="дует"){
                        tr[i].style.display = "";
                    }
                    else{
                        tr[i].style.display = "none";
                    }
                }
            }
        },
    },
}
</script>
